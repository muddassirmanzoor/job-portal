@include('includes.header')
    <!------------DataTables Start Hare------------>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>
<!------------DataTables End Hare------------>
<section class="hero-section">
    <div class="px-4 py-3 mb-3 text-center">
        <h1 class="display-5 fw-bold text-body-emphasis hero-heading">User List</h1>
    </div>
</section>

<section class="after-hero-section">
        <div class="row">
            <div class="col-md-12 col-xs-12 bg p-3 text-black">
                <div class="card-body">
                    <!-------------------->
                    <div class="row white-container">
                        <div class="col-md-12 page-content">
                            <div class="card">
                                <div class="card-body">
                                    <!---------->

                                    <div class="candidates-item candidates-single-item">
                                        <section>
                                            <div class="col-md-12 nopadding">
                                                <table class="table table-hover table-striped text-center  table-bordered scrutiny-list-data" id="eligible_user_table" style="margin:0px 0px 30px;">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Post Title</th>
                                                        <th scope="col">Candidate Name</th>
                                                        <th scope="col">Phone #</th>
                                                        <th scope="col">Latest Qualification</th>
                                                        <th scope="col">Qualification Relevance</th>
                                                        <th scope="col">Higher Qualification</th>
                                                        <th scope="col">Total Experience</th>
                                                        <th scope="col">Relevant Experience</th>
                                                        <th scope="col">Scrutinized</th>
                                                        <th scope="col">Reviewed</th>
                                                        <th scope="col">Eligible</th>
                                                        <th scope="col">Eligibility Form</th>
                                                        <th scope="col">Documents</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($applications as $application)
                                                        <tr>
                                                            <td data-label="Post For Apply">{{$application['post']['title']}}</td>
                                                            <td data-label="Name">{{$application['first_name']}} {{$application['last_name']}}</td>
                                                            <td data-label="Mobile Number">{{$application['phone_number']}}</td>
                                                            <td data-label="Relevance Experience">{{$application['latestQualification']['degree_title']}}</td>
                                                            <td data-label="q relevance" style="color: {{ $application['qualification_relevance'] == 1 ? 'green' : 'red' }};">
                                                                {{ $application['qualification_relevance'] == 1 ? 'Yes' : 'No' }}
                                                            </td>
                                                            <td data-label="h qualification" style="color: {{ $application['higher_qualification'] == 1 ? 'green' : 'red' }};">
                                                                {{ $application['higher_qualification'] == 1 ? 'Yes' : 'No' }}
                                                            </td>
                                                            <td data-label="Relevance Experience">{{$application['total_experience']}}</td>
                                                            <td data-label="Relevance Experience">{{$application['total_relevant_experience']}}</td>
                                                            <td data-label="Scrutinized" style="color: {{ $application['is_scrutinized'] == 1 ? 'green' : 'red' }};">
                                                                {{ $application['is_scrutinized'] == 1 ? 'Yes' : 'No' }}
                                                            </td>
                                                            <td data-label="Reviewed" style="color: {{ $application['is_reviewed'] == 1 ? 'green' : 'red' }};">
                                                                @if($application['is_reviewed'] == 1)
                                                                    @if(Auth::user()->hasRole('Review'))
                                                                    <a href="{{ url('user-detail/'.$application['applicant_id']) }}">Yes</a>
                                                                    @else
                                                                        Yes
                                                                    @endif
                                                                @else
                                                                    No
                                                                @endif
                                                            </td>
                                                            <td data-label="Eligible" style="color: {{ $application['is_eligible'] == 1 ? 'green' : 'red' }};">
                                                                {{ $application['is_eligible'] == 1 ? 'Yes' : 'No' }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ url('first-user-form/'.$application['applicant_id']) }}" target="_blank">Form</a>
                                                                @php
                                                                    $extension = pathinfo($application['resume_path'], PATHINFO_EXTENSION);
                                                                    $fileUrl = url('storage/'.$application['resume_path']);
                                                                    $imageSrc = asset('assets/images/Files_App_icon.png'); // Default icon

                                                                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                                        $imageSrc = asset('assets/images/image.png');
                                                                    } elseif ($extension === 'pdf') {
                                                                        $imageSrc = asset('assets/images/PDF_file_icon.png');
                                                                    } elseif (in_array($extension, ['doc', 'docx'])) {
                                                                        $fileUrl = "https://docs.google.com/gview?url={$fileUrl}&embedded=true";
                                                                        $imageSrc = asset('assets/images/word.jpg');
                                                                    }
                                                                @endphp

                                                                <a href="{{ $fileUrl }}" target="_blank">
                                                                    <img style="max-width: 20px" src="{{ $imageSrc }}"
                                                                         alt="File Icon">
                                                                </a>
                                                            </td>
                                                            <td><a href="{{ url('first-user-documents/'.$application['applicant_id']) }}" target="_blank">Zip</a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                    </div>
                                    <!---------->
                                </div> <!-- end .page-content -->
                            </div>
                        </div>
                    </div>

                    <!-------------------->
                </div>
            </div>
        </div>
</section>
<!-- Modal -->
<div class="modal fade" id="experienceLetterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Internship in Electrical Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img class="experienceLetterFullImage" src="./assets/dist/images/PDF_file.png">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">	Secondary School Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img class="experienceLetterFullImage" src="./assets/dist/images/PDF_file.png">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    new DataTable('#eligible_user_table', {
        layout: {
            topStart: {
                buttons: ['excel', 'csv']
            }
        }
    });
</script>
@include('includes.footer')
