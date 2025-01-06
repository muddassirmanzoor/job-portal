<?php

namespace App\Http\Controllers;

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

class RecruitmentController extends Controller
{
    /**
     * Display a form of the Job Form.
     */
    public function coming()
    {
        return view('coming');
    } /**
     * Display a form of the Job Form.
     */
    public function jobForm()
    {
        $jobs = Job::whereDate('expires_at', '>=', Carbon::now('Asia/Karachi'))->get();
        return view('job_form', compact('jobs'));
    }

    /**
     * Submit Form.
     */
    public function submitForm(Request $request)
    {
        // Retrieve the qualifications from the request
        $qualifications = $request->input('qualification', []);
        // Define base validation rules
        $baseValidationRules = [
            'post_id' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'cnic_no' => [
                'required',
                'string',
                'min:13',
                'max:15',
                Rule::unique('profiles')->where(function ($query) use ($request) {
                    return $query->where('post_id', $request->post_id);
                }),
            ],
            'email' => 'required|email|max:255',
            'gender' => 'required|string|max:10',
            'phone_number' => 'required|string|max:15',
            'mailing_address' => 'required|string',
            'permanent_address' => 'required|string',
            'resume' => 'nullable|file|max:5120',
            'employment.*.company_name' => 'nullable|string',
            'employment.*.job_title' => 'nullable|string',
            'employment.*.location' => 'nullable|string',
            'employment.*.start_date' => 'nullable|date',
            'employment.*.end_date' => 'nullable|date',
            'employment.*.total_experience' => 'nullable|numeric',
            'employment.*.file' => 'nullable|file|max:5120',
            'qualification.*.degree_level' => 'nullable|string',
            'qualification.*.degree_title' => 'nullable|string',
            'qualification.*.institution' => 'nullable|string',
            'qualification.*.major_subject' => 'nullable|string',
            'qualification.*.start_date' => 'nullable|date',
            'qualification.*.end_date' => 'nullable|date',
            'qualification.*.total_marks' => 'nullable|string',
            'qualification.*.obt_marks' => 'nullable|string',
            'qualification.*.file' => 'nullable|file|max:5120',
        ];

        $customMessages = [
            'cnic_no.unique' => 'The CNIC number has already been taken for the selected post.',
            // Other custom messages if needed
        ];

        // Validate the request
        $validatedData = $request->validate($baseValidationRules, $customMessages);

        DB::beginTransaction();
        try {
            $path = null;
            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $path = $file->store('uploads/resumes/' . $validatedData['first_name'], 'public');
            }
            // Store the profile
            $profile = Profile::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'cnic_no' => $validatedData['cnic_no'],
                'email' => $validatedData['email'],
                'gender' => $validatedData['gender'],
                'phone_number' => $validatedData['phone_number'],
                'mailing_address' => $validatedData['mailing_address'],
                'post_id' => $validatedData['post_id'],
                'permanent_address' => $validatedData['permanent_address'],
                'resume_path' => $path,
            ]);

            // Store qualifications
            foreach ($validatedData['qualification'] as $index => $qualificationData) {
                if (!is_null($qualificationData['degree_level'])) {
                    $qualification = Qualification::create([
                        'applicant_id' => $profile->applicant_id,
                        'degree_level' => $qualificationData['degree_level'],
                        'degree_title' => $qualificationData['degree_title'],
                        'institution' => $qualificationData['institution'],
                        'major_subject' => $qualificationData['major_subject'] ?? null,
                        'start_date' => $qualificationData['start_date'],
                        'end_date' => $qualificationData['end_date'] ?? null,
                        'total_marks' => $qualificationData['total_marks'] ?? null,
                        'obt_marks' => $qualificationData['obt_marks'] ?? null,
                    ]);
                }
                if ($request->hasFile("qualification.{$index}.file")) {
                    $file = $request->file("qualification.{$index}.file")->store('uploads/qualifications/' . $profile->applicant_id, 'public');
                    QualificationDocument::create([
                        'applicant_id' => $profile->applicant_id,
                        'qualification_id' => $qualification->id,
                        'file_path' => $file,
                    ]);
                }
            }

            // Store employment histories
            foreach ($validatedData['employment'] as $index => $employmentData) {
                if (!is_null($employmentData['company_name'])) {
                    $employmentHistory = EmploymentHistory::create([
                        'applicant_id' => $profile->applicant_id,
                        'company_name' => $employmentData['company_name'],
                        'job_title' => $employmentData['job_title'],
                        'location' => $employmentData['location'],
                        'start_date' => $employmentData['start_date'],
                        'end_date' => $employmentData['end_date'],
                        'total_experience' => $employmentData['total_experience'],
                    ]);
                }
                if ($request->hasFile("employment.{$index}.file")) {
                    $file = $request->file("employment.{$index}.file")->store('uploads/employment/' . $profile->applicant_id,'public');
                    ExperienceDocument::create([
                        'applicant_id' => $profile->applicant_id,
                        'employment_id' => $employmentHistory->id,
                        'file_path' => $file,
                    ]);
                }
            }

            DB::commit();

            // Send email to the user
            Mail::to($profile->email)->send(new ApplicationConfirmationMail($profile));

            // Return the success view directly
            return redirect('applicant-detail/'.encrypt($profile->applicant_id))->with('success', 'Your application has been submitted successfully!');

        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('SQL Error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Something went wrong. Please fill all fields.'])->withInput();
        }
    }

    /**
     * Display of the submitted form.
     */
    public function submittedFormListing(Request $request)
    {
        if ($request->has('advertisement')) {
            Session::put('advertisement', $request->input('advertisement'));
        }

        $advertisement_id = Session::get('advertisement', 1); // Default to 1 if no advertisement is selected

        // Fetch the posts related to the advertisement ID
        $postIds = Job::where('advertisement_id', $advertisement_id)->pluck('post_id')->toArray();

        Session::forget('postIds');
        Session::put('postIds', $postIds);
        $applications = Profile::whereIn('post_id', $postIds)->with('post')->paginate(50);
        return view('job_form_listing', compact('applications'));
    }
    /**
     * Display of the submitted form.
     */
    public function submittedFormData($post_id)
    {
        $applications = Profile::where('post_id', $post_id)->with('post', 'latestQualification')->get();
        return view('profile_list', compact('applications'));
    }
    /**
     * Display of the submitted form.
     */
    public function scrutinizeFormData($post_id)
    {
        $applications = Profile::where('post_id', $post_id)->where('is_scrutinized', 0)->with('post')->get();
        return view('job_form_listing_data_table', compact('applications'));
    }
    /**
     * Display of the submitted form.
     */
    public function reviewFormData($post_id)
    {
        $applications = Profile::where('post_id', $post_id)->where('is_scrutinized', 1)->where('is_reviewed', 0)->with('post')->get();
        return view('job_form_listing_data_table', compact('applications'));
    }
    /**
     * Display of the submitted form.
     */
    public function secondReviewFormData($post_id)
    {
        $applications = Profile::where('post_id', $post_id)->where('is_scrutinized', 1)->where('is_reviewed', 1)->with('post')->get();
        return view('job_form_listing_data_table', compact('applications'));
    }
    /**
     * Display of the submitted form count.
     */
    public function firstSubmittedCount()
    {
        $postIds = Session::get('postIds', []);

        $applications =  DB::table('profiles as p')
            ->join('jobs as j', 'p.post_id', '=', 'j.post_id')
            ->select('p.post_id','j.title', DB::raw('COUNT(p.post_id) as profile_count'))
            ->whereIn('p.post_id', $postIds)
            ->groupBy('j.title', 'p.post_id')
            ->orderBy('p.post_id')
            ->get();
        return view('first_job_form_count', compact('applications'));
    }
    /**
     * Display of the reviewed form count.
     */
    public function firstScrutinizedCount(Request $request)
    {
        $postIds = Session::get('postIds', []);

        $applications =  DB::table('profiles as p')
            ->join('jobs as j', 'p.post_id', '=', 'j.post_id')
            ->select('p.post_id','j.title', DB::raw('COUNT(p.post_id) as profile_count'))
            ->whereIn('p.post_id', $postIds)
            ->where('p.is_scrutinized', 0)
            ->groupBy('j.title', 'p.post_id')
            ->orderBy('p.post_id')
            ->get();


        return view('first_job_form_count', compact('applications'));
    }
    /**
     * Display of the reviewed form count.
     */
    public function firstReviewedCount()
    {
        $postIds = Session::get('postIds', []);

        $applications =  DB::table('profiles as p')
            ->join('jobs as j', 'p.post_id', '=', 'j.post_id')
            ->select('p.post_id','j.title', DB::raw('COUNT(p.post_id) as profile_count'))
            ->whereIn('p.post_id', $postIds)
            ->where('p.is_scrutinized', 1)
            ->where('p.is_reviewed', 0)
            ->groupBy('j.title', 'p.post_id')
            ->orderBy('p.post_id')
            ->get();
        return view('first_job_form_count', compact('applications'));
    }
    /**
     * Display of the reviewed form count.
     */
    public function secondReviewedCount()
    {
        $postIds = Session::get('postIds', []);

        $applications =  DB::table('profiles as p')
            ->join('jobs as j', 'p.post_id', '=', 'j.post_id')
            ->select('p.post_id','j.title', DB::raw('COUNT(p.post_id) as profile_count'))
            ->whereIn('p.post_id', $postIds)
            ->where('p.is_scrutinized', 1)
            ->where('p.is_reviewed', 1)
            ->groupBy('j.title', 'p.post_id')
            ->orderBy('p.post_id')
            ->get();
        return view('first_job_form_count', compact('applications'));
    }
    /**
     * Display of the user detail.
     */
    public function userDetail($user_id)
    {
        $application = Profile::where('applicant_id', $user_id)->with('qualification.qualificationImages','experience.experienceImages','post')->first();

        if(Auth::user()->hasRole('Scrutiny')){
            if($application['is_scrutinized']){
                return view('user_detail_update', compact('application'));
            }else{
                return view('user_detail', compact('application'));
            }
        }
        elseif(Auth::user()->hasRole('Review')){
            return view('user_detail_update', compact('application'));
        }
    }

    /**
     * Display of the user detail.
     */
    public function applicantDetail($user_id)
    {
        $user_id = decrypt($user_id);
        $application = Profile::where('applicant_id', $user_id)->with('qualification.qualificationImages','experience.experienceImages','post')->first();
        return view('applicant_detail', compact('application'));
    }

    /**
     * Submit of the user scrutiny.
     */
    public function userScrutiny(Request $request)
    {
        $eligibilityOptions = $request->input('eligibilityOptions');

        $application = Profile::where('applicant_id', $request['applicant_id'])->first();
        if ($application) {
            // Update the profile fields using the update method
            $application->update([
                'total_experience' => $request['total_experience'],
                'total_relevant_experience' => $request['total_relevant_experience'],
                'qualification_criteria_met' => $request['qualification_criteria_met'],
                'qualification_relevance' => $request['qualification_relevance'],
                'higher_qualification' => $request['higher_qualification'],
                'remarks' => $request['remarks'],
                'is_eligible' => $request['is_eligible'],
                'scrutinized_by' => Auth::user()->id,
                'is_scrutinized' => 1,
            ]);

        foreach ($eligibilityOptions as $employment_id => $data) {
            // Validate that start and end dates are valid
            $start_date = $data['start_date'] ?? null;
            $end_date = $data['end_date'] ?? null;
            $is_relevant = $data['is_relevant'] ?? null;

            // Update the database record for each experience
            EmploymentHistory::where('employment_id', $employment_id)
                ->update([
                    'verified_start_date' => $start_date,
                    'verified_end_date' => $end_date,
                    'is_relevant' => $is_relevant]);
        }

        return redirect('first-scrutinize-count')->with('success', 'Profile scrutinized successfully.');
        } else {
            // If the profile doesn't exist, return with an error
            return redirect()->back()->with('error', 'Profile not found.');
        }
    }

    public function userScrutinyUpdate(Request $request)
    {
        $eligibilityOptions = $request->input('eligibilityOptions');

        $application = Profile::where('applicant_id', $request['applicant_id'])->first();
        if ($application) {

            if(Auth::user()->hasRole('Scrutiny')){
                $application->update([
                    'total_experience' => $request['total_experience'],
                    'total_relevant_experience' => $request['total_relevant_experience'],
                    'qualification_criteria_met' => $request['qualification_criteria_met'],
                    'qualification_relevance' => $request['qualification_relevance'],
                    'higher_qualification' => $request['higher_qualification'],
                    'remarks' => $request['remarks'],
                    'is_eligible' => $request['is_eligible'],
                    'scrutinized_by' => Auth::user()->id,
                    'is_scrutinized' => 1,
                ]);
            }
            elseif(Auth::user()->hasRole('Review')){
                // Loop through each field to update and log the changes
                foreach ($request->only([
                    'total_experience', 'total_relevant_experience', 'qualification_criteria_met',
                    'qualification_relevance', 'higher_qualification', 'remarks', 'is_eligible'
                ]) as $field => $newValue) {
                    $oldValue = $application->$field;

                    // If the value has changed, create a log entry
                    if ($oldValue != $newValue) {
                        \App\Models\ScrutinyUpdateLog::create([
                            'user_id' => Auth::user()->id,
                            'application_id' => $application->applicant_id,
                            'updated_field' => $field,
                            'old_value' => $oldValue,
                            'new_value' => $newValue,
                        ]);
                    }
                }
                $application->update([
                    'total_experience' => $request['total_experience'],
                    'total_relevant_experience' => $request['total_relevant_experience'],
                    'qualification_criteria_met' => $request['qualification_criteria_met'],
                    'qualification_relevance' => $request['qualification_relevance'],
                    'higher_qualification' => $request['higher_qualification'],
                    'remarks' => $request['remarks'],
//                    'review_remarks' => $request['review_remarks'],
                    'is_eligible' => $request['is_eligible'],
                    'reviewed_by' => Auth::user()->id,
                    'is_reviewed' => 1,
                ]);
            }

            foreach ($eligibilityOptions as $employment_id => $data) {
                $employmentHistory = EmploymentHistory::where('employment_id', $employment_id)->first();

                // Validate that start and end dates are valid
                $start_date = $data['start_date'] ?? null;
                $end_date = $data['end_date'] ?? null;
                $is_relevant = $data['is_relevant'] ?? null;

                // Log changes for each field
                foreach (['verified_start_date' => $start_date, 'verified_end_date' => $end_date, 'is_relevant' => $is_relevant] as $field => $newValue) {
                    $oldValue = $employmentHistory->$field;

                    if ($oldValue != $newValue) {
                        \App\Models\ScrutinyUpdateLog::create([
                            'user_id' => Auth::user()->id,
                            'application_id' => $application->applicant_id,
                            'employment_id' => $employment_id,
                            'updated_field' => $field,
                            'old_value' => $oldValue,
                            'new_value' => $newValue,
                        ]);
                    }
                }

                // Update the database record for each experience
                EmploymentHistory::where('employment_id', $employment_id)
                    ->update([
                        'verified_start_date' => $start_date,
                        'verified_end_date' => $end_date,
                        'is_relevant' => $is_relevant]);
            }

            if(Auth::user()->hasRole('Scrutiny')) {
                return redirect('first-scrutinize-count')->with('success', 'Profile scrutinized updated successfully.');
            }elseif(Auth::user()->hasRole('Review')){
                return redirect('first-review-form-data/'.$application->post_id)->with('success', 'Profile reviewed successfully.');
            }
        } else {
            // If the profile doesn't exist, return with an error
            return redirect()->back()->with('error', 'Profile not found.');
        }
    }

    public function getEligibilityCriteria($post_id)
    {
        // Example SQL query to fetch data (adapt as needed for your schema)
        $eligibilityCriteria = DB::table('eligibility')
            ->select('post_id', 'qualification', 'experience')
            ->where('post_id', $post_id)
            ->get();

        // Format the data as needed for the frontend
        $formattedData = [];

        foreach ($eligibilityCriteria as $criteria) {
            $post_id = $criteria->post_id;
            $qualification = $criteria->qualification;
            $experience = $criteria->experience;

            if (!isset($formattedData[$post_id])) {
                $formattedData[$post_id] = [];
            }

            if (!isset($formattedData[$post_id][$qualification])) {
                $formattedData[$post_id][$qualification] = [];
            }

            $formattedData[$post_id][$qualification][] = $experience;
        }

        return response()->json($formattedData);
    }
}
