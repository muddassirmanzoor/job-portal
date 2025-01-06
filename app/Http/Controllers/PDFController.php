<?php

namespace App\Http\Controllers;

use AntonAm\PDFVersionConverter\Converter\GhostscriptConverter;
use AntonAm\PDFVersionConverter\Converter\GhostscriptConverterCommand;
use AntonAm\PDFVersionConverter\Guesser\RegexGuesser;
use App\Http\Controllers\Controller;
use App\Mail\ApplicationConfirmationMail;
use App\Models\EmploymentHistory;
use App\Models\ExperienceDocument;
use App\Models\Job;
use App\Models\Profile;
use App\Models\Qualification;
use App\Models\QualificationDocument;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use PhpOffice\PhpWord\IOFactory;
use function Sodium\compare;
use setasign\Fpdi\Fpdi;

class PDFController extends Controller
{
    public function downloadUserDocumentsZip($userId)
    {
        // Retrieve the user's profile
        $profile = Profile::where('applicant_id', $userId)->with('qualification','experience')->first();

        // Ensure the profile exists
        if (!$profile) {
            return response()->json(['error' => 'Profile not found.'], 404);
        }
//         Load::view('candidate_profile_print', compact('profile'));

        // Initialize an array to collect all file paths
        $filesToZip = [];

        // Add the resume to the files list if it exists
//        if ($profile->resume_path && Storage::exists($profile->resume_path)) {
//            $filesToZip[] = storage_path( $profile->resume_path);
            $resumePath = $this->normalizePath('public/storage/'.$profile->resume_path);
            if (file_exists($resumePath)) {
                $filesToZip[] = ['path' => $resumePath, 'folder' => 'resume'];
            }
//        }

        $qualifications = Qualification::where('applicant_id', $profile->applicant_id)->get();

        foreach ($qualifications as $qualification) {
            // Retrieve qualification documents associated with the user
            $qualificationDocuments = QualificationDocument::where('applicant_id', $profile->applicant_id)->where('qualification_id', $qualification['qualification_id'])->get();

            foreach ($qualificationDocuments as $document) {
                $docPath = $this->normalizePath('public/storage/'.$document->file_path);
                if (file_exists($docPath)) {
                    $filesToZip[] = ['path' => $docPath, 'folder' => 'documents'];
                }
            }
        }

        $experiences = EmploymentHistory::where('applicant_id', $profile->applicant_id)->get();

        foreach ($experiences as $experience) {
            // Retrieve employment documents associated with the user
            $experienceDocuments = ExperienceDocument::where('applicant_id', $profile->applicant_id)->where('employment_id', $experience['employment_id'])->get();

            foreach ($experienceDocuments as $document) {
                $docPath = $this->normalizePath('public/storage/'.$document->file_path);
                if (file_exists($docPath)) {
                    $filesToZip[] = ['path' => $docPath, 'folder' => 'experience'];
                }
            }
        }

        // Define the ZIP file path
        $zipDirectory = storage_path('app/public/uploads/zip/');
        $zipFileName = 'user_documents_' . $profile->first_name . '.zip';
        $zipFilePath = $zipDirectory . $zipFileName;

        // Ensure the ZIP directory exists, create if not
        if (!file_exists($zipDirectory)) {
            mkdir($zipDirectory, 0777, true); // Recursively create the directory with appropriate permissions
        }

        // Create a ZIP file
        $zip = new \ZipArchive();

        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            // Add files to the ZIP
            foreach ($filesToZip as $file) {
                if (file_exists($file['path'])) {
                    // Add the file to the specified folder in the ZIP archive
                    $relativePath = $file['folder'] . '/' . basename($file['path']);
                    $zip->addFile($file['path'], $relativePath);
                } else {
                    \Log::error("File does not exist: " . $file);
                }
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Unable to create ZIP file.'], 500);
        }
        if (file_exists($zipFilePath)) {
            // Return the ZIP file as a download and delete it after sending
            return response()->download($zipFilePath);
        }else{
            return response()->json(['error' => 'Unable to find ZIP file.'], 500);
        }
    }

    public function downloadUserDocuments($userId)
    {
        // Retrieve the user's profile
        $profile = Profile::where('applicant_id', $userId)->with('latestQualifications','experience', 'post')->first();

        // Ensure the profile exists
        if (!$profile) {
            return response()->json(['error' => 'Profile not found.'], 404);
        }

        // Step 1: Generate the main PDF from HTML content
        $viewContent = \Illuminate\Support\Facades\View::make('candidate_profile_print_new', compact('profile'))->render();
//        return view('candidate_profile_print_new', compact('profile'));
        $pdf = PDF::loadHTML($viewContent)->setPaper('a4', 'portrait');

        // Define paths
        $pdfDirectory = storage_path('app/public/uploads/pdf/');
        $pdfFileName = 'user_documents_' . $profile->first_name . '.pdf';
        $pdfFilePath = $pdfDirectory . $pdfFileName;


        // Ensure the PDF directory exists; create it if it doesn't
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0777, true);
        }

        // Save the generated PDF to file
        $pdf->save($pdfFilePath);
        $resumePath = storage_path('app/public/' . $profile->resume_path);
        $extension = pathinfo($resumePath, PATHINFO_EXTENSION);

        if (pathinfo($resumePath, PATHINFO_EXTENSION) == 'pdf') {
            try {
                $guesser = new RegexGuesser();
                $version = $guesser->guess($resumePath);

                if ($version == '1.5') {
                    $command = new GhostscriptConverterCommand();
                    $filesystem = new \Symfony\Component\Filesystem\Filesystem();

                    $converter = new GhostscriptConverter($command, $filesystem);
                    $converter->convert(storage_path('app/public/' . $profile->resume_path), '1.7');
                }
                $this->mergePdfs($pdfFilePath, $resumePath, $pdfFilePath);
            } catch (\Exception $e) {
                // Log the error message for debugging purposes
                \Log::error('PDF generation or merging error: ' . $e->getMessage());

                // Optionally, you can also provide a fallback mechanism or create a placeholder PDF
                // For example, you could create a new empty PDF or continue with the existing PDF
                // return response()->json(['error' => 'Could not process the PDF, but continuing...']);
            }
        }
//        elseif ($extension === 'doc' || $extension === 'docx') {
//            try {
//                $phpWord = IOFactory::load($resumePath);
//                $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
//                $tempHtmlPath = tempnam(sys_get_temp_dir(), 'html');
//                $htmlWriter->save($tempHtmlPath);
//
//                $htmlContent = file_get_contents($tempHtmlPath);
//                $resumePdf = Pdf::loadHTML($htmlContent)->setPaper('a4', 'portrait');
//
//                $resumePdfPath = storage_path('app/public/uploads/pdf/resume_' . $profile->first_name . '.pdf');
//                $resumePdf->save($resumePdfPath);
//
//                unlink($tempHtmlPath);
//
//                $this->mergePdfs($pdfFilePath, $resumePdfPath, $pdfFilePath);
//            } catch (\Exception $e) {
//                Log::error('Document conversion error: ' . $e->getMessage());
////                return response()->json(['error' => 'Error converting document: ' . $e->getMessage()], 500);
//            }
//        }

        // Return the response to display the PDF in a new tab
        return response()->file($pdfFilePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $pdfFileName . '"'
        ]);

//        return response()->download($pdfFilePath)->deleteFileAfterSend(true);
    }

    public function downloadUserDocuments3()
    {
        // Path to the files you want to include
        $imagePath = storage_path('app/public/uploads/resumes/Rumaisa/SfPFAKOiGBjLBXrRCG8TAdLKo4QxMmbYcg8NkwOj.jpg');
        $pdfPath = storage_path('app/public/uploads/resumes/Mashal/qyq6WmrlpawCLdTBH95ziICog528tE7Pwzqz5wcP.pdf');
        $docxPath = storage_path('app/public/uploads/resumes/QA/nAFbpJMTzWH1MFiIjXQ3X6K8ss3sHCyLZ3ZRurrt.doc');

        // Reading content from DOCX
        $phpWord = IOFactory::load($docxPath);
        $docContent = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $docContent .= $element->getText() . "<br>";
                }
            }
        }

        // Prepare content for PDF view
        $data = [
            'imagePath' => $imagePath,
            'pdfPath' => $pdfPath,
            'docContent' => $docContent,
        ];

        // Load a view with the prepared data
        $pdf = PDF::loadView('pdf_view', $data);

        // Return the generated PDF file for download
        return $pdf->download('combined_output.pdf');
    }

    /**
     * Merges two PDFs into one.
     *
     * @param string $pdf1Path Path to the main PDF.
     * @param string $pdf2Path Path to the PDF to merge (qualification/experience).
     * @param string $outputPath Path to save the final merged PDF.
     * @return void
     */
    protected function mergePdfs($pdf1Path, $pdf2Path, $outputPath)
    {
        // Initialize FPDI
        $fpdi = new Fpdi();

        // Add pages from the first PDF
        $pageCount = $fpdi->setSourceFile($pdf1Path);
        for ($i = 1; $i <= $pageCount; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $fpdi->useTemplate($template);
        }

        // Add pages from the second PDF (resume)
        $pageCount = $fpdi->setSourceFile($pdf2Path);
        for ($i = 1; $i <= $pageCount; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $fpdi->useTemplate($template);
        }

        // Output the final merged PDF
        $fpdi->Output($outputPath, 'F'); // 'F' saves the output to a file
    }

    public function downloadUserDocuments_o($userId)
    {
        // Retrieve the user's profile
        $profile = Profile::where('applicant_id', $userId)->with('qualification','experience')->first();

        // Ensure the profile exists
        if (!$profile) {
            return response()->json(['error' => 'Profile not found.'], 404);
        }

        // Initialize an array to store HTML content
        $htmlContent = '';

        // Render the Blade view to HTML
        $viewContent = \Illuminate\Support\Facades\View::make('candidate_profile_print_new', compact('profile'))->render();
        $htmlContent .= $viewContent;

        // Add the resume if it exists
//        if ($profile->resume_path && Storage::exists($profile->resume_path)) {
            $resumePath = storage_path('app/public/' . $profile->resume_path);
            if (file_exists($resumePath)) {
                if (pathinfo($resumePath, PATHINFO_EXTENSION) == 'pdf') {
                    $htmlContent .= '<iframe src="' . $resumePath . '" style="width:100%; height:500px;"></iframe>';
                } else {
                    $htmlContent .= '<img src="' . $resumePath . '" style="width:100%;"/>';
                }
            }
//        }

        // Add qualification documents
        $qualifications = Qualification::where('applicant_id', $profile->applicant_id)->get();

        foreach ($qualifications as $qualification) {
            $qualificationDocuments = QualificationDocument::where('applicant_id', $profile->applicant_id)
                ->where('qualification_id', $qualification['qualification_id'])->get();

            foreach ($qualificationDocuments as $document) {
                $docPath = storage_path('app/public/' . $document->file_path);
                if (file_exists($docPath)) {
                    if (pathinfo($docPath, PATHINFO_EXTENSION) == 'pdf') {
                        $htmlContent .= '<iframe src="' . $docPath . '" style="width:100%; height:500px;"></iframe>';
                    } else {
                        $htmlContent .= '<img src="' . $docPath . '" style="width:100%;"/>';
                    }
                }
            }
        }

        // Add experience documents
        $experiences = EmploymentHistory::where('applicant_id', $profile->applicant_id)->get();

        foreach ($experiences as $experience) {
            $experienceDocuments = ExperienceDocument::where('applicant_id', $profile->applicant_id)
                ->where('employment_id', $experience['employment_id'])->get();

            foreach ($experienceDocuments as $document) {
                $docPath = storage_path('app/public/' . $document->file_path);
                if (file_exists($docPath)) {
                    if (pathinfo($docPath, PATHINFO_EXTENSION) == 'pdf') {
                        $htmlContent .= '<iframe src="' . $docPath . '" style="width:100%; height:500px;"></iframe>';
                    } else {
                        $htmlContent .= '<img src="' . $docPath . '" style="width:100%;"/>';
                    }
                }
            }
        }

        // Generate the final PDF
        $pdf = Pdf::loadHTML($htmlContent)->setPaper('a4', 'portrait');

        // Define the PDF file path
        $pdfDirectory = storage_path('app/public/uploads/pdf/');
        $pdfFileName = 'user_documents_' . $profile->first_name . '.pdf';
        $pdfFilePath = $pdfDirectory . $pdfFileName;

        // Ensure the PDF directory exists, create if not
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0777, true); // Recursively create the directory with appropriate permissions
        }

        // Save the PDF to the file path
        $pdf->save($pdfFilePath);

        // Return the PDF file as a download
        return response()->download($pdfFilePath);
    }

    private function normalizePath($path)
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }
}
