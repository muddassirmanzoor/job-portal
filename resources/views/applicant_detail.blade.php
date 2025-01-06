@include('includes.header')
<section class="hero-section">
    <div class="px-4 py-3 mb-3 text-center">
        <h1 class="display-5 fw-bold text-body-emphasis hero-heading">View Profile</h1>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif
<section class="after-hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 bg p-3 text-black">
                <div class="card-body">
                    <!-------------------->
                    <div class="row white-container">
                        <div class="col-sm-3 page-sidebar">
                            <div class="card">
                                {{--                                <img style="width: 130px;margin: 30px auto 0 auto;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKSyc6olVgh1r-dUpRS50R7m4G0r6AOtmwSbF5aQb0Bbhv4D6KAtCpSCihob_zVpFjFng&usqp=CAU" class="card-img-top" alt="...">--}}
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Personal Information</h5>
                                    <div class="widget sidebar-widget white-container candidates-single-widget">
                                        <div class="widget-content">
                                            <table>
                                                <tbody>
                                                <tr class="ps-info">
                                                    <td>Full Name</td>
                                                    <td>{{$application['first_name'] . ' '. $application['last_name'] }}</td>
                                                </tr>
                                                <tr class="ps-info">
                                                    <td>CNIC</td>
                                                    <td>{{$application['cnic_no']}}</td>
                                                </tr>
                                                <tr class="ps-info">
                                                    <td>Email</td>
                                                    <td>{{$application['email']}}</td>
                                                </tr>
                                                <tr class="ps-info">
                                                    <td>Gender</td>
                                                    <td>{{$application['gender']}}</td>
                                                </tr>
                                                <tr class="ps-info">
                                                    <td>Mobile</td>
                                                    <td>{{$application['phone_number']}}</td>
                                                </tr>
                                                <tr class="ps-info">
                                                    <td>Postal Address</td>
                                                    <td>{{$application['mailing_address']}}</td>
                                                </tr>
                                                <tr class="ps-info">
                                                    <td>Permanent Address</td>
                                                    <td>{{$application['permanent_address']}}</td>
                                                </tr>
                                                <tr class="ps-info">
                                                    <td>Resume</td>
                                                    <td>
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
                                                        </a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <aside>
                            </aside>
                        </div> <!-- end .page-sidebar -->

                        <div class="col-sm-9 page-content">
                            <div class="card">
                                <div class="card-body">
                                    <!---------->
                                    <div class="candidates-item candidates-single-item ">
                                        <section>
                                            <h5 class="card-title mt-2">Work History</h5>
                                            <div class="col-md-12 nopadding table-overflow-hidden">
                                                <table class="table table-hover table-striped" id="work_history_table"
                                                       style="margin:0px 0px 30px;">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Position Title</th>
                                                        <th scope="col"> Company Name</th>
                                                        <th scope="col">From</th>
                                                        <th scope="col">To</th>
                                                        <th scope="col">Total Experience</th>
                                                        <th scope="col">Experience Letter</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $total_experience = 0;
                                                    @endphp
                                                    @foreach($application['experience'] as $experience)
                                                        @php
                                                            $start = \Carbon\Carbon::parse($experience['start_date']);
                                                            $end = \Carbon\Carbon::parse($experience['end_date']);

                                                            // Calculate difference in years and months
                                                            $years = $end->diffInYears($start);
                                                            $months = $end->diffInMonths($start) % 12;

                                                            // Convert months to decimal and add to years
                                                            $total_experience_cal = $years + ($months / 12);

                                                            // Add to total experience
                                                            $total_experience += $total_experience_cal;
                                                        @endphp
                                                        <tr id="{{$experience['employment_id']}}">
                                                            <td data-label="Position Title">{{$experience['job_title']}}</td>
                                                            <td data-label="Company Name">{{$experience['company_name']}}</td>
                                                            <td data-label="From">{{$experience['start_date']}}</td>
                                                            <td data-label="To">{{$experience['end_date']}}</td>
                                                            <td data-label="Total Experience">{{number_format($total_experience_cal, 2)}}</td>
                                                            <td data-label="Experience Letter">
                                                                @if($experience['experienceImages'])
                                                                @php
                                                                    $extension = pathinfo($experience['experienceImages']['file_path'], PATHINFO_EXTENSION);
                                                                    $fileUrl = url('storage/'.$experience['experienceImages']['file_path']);
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
                                                                @endif

                                                                <a href="{{ $fileUrl }}" target="_blank">
                                                                    <img style="max-width: 20px" src="{{ $imageSrc }}"
                                                                         alt="File Icon">
                                                                </a></td>
                                                            <!---------->
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                        <section>
                                            <h5 class="card-title mt-2">Academics</h5>
                                            <ul class="list-unstyled">
                                                <!--                        <li><strong>Degree(s):</strong> </li>-->
                                            </ul>
                                            <div class="col-md-12 nopadding table-overflow-hidden">
                                                <table class="table table-hover table-striped" id="academics_table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Institute</th>
                                                        <th scope="col">Degree</th>
                                                        <th scope="col">Level</th>
                                                        <th scope="col">From</th>
                                                        <th scope="col">To</th>
                                                        <th scope="col">Obtained Marks</th>
                                                        <th scope="col">Certificate</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($application['qualification'] as $qualification)
                                                        <tr id="708511">
                                                            <td data-label="Institute"
                                                                id="d_institue">{{$qualification['institution']}}</td>
                                                            <td data-label="Degree"
                                                                id="d_name">{{$qualification['degree_level']}}</td>
                                                            <td data-label="Level"
                                                                id="d_major">{{$qualification['degree_title']}}</td>
                                                            <td data-label="From"
                                                                id="d_start_date">{{$qualification['start_date']}}</td>
                                                            <td data-label="To"
                                                                id="d_end_date">{{$qualification['end_date']}}</td>
                                                            <td data-label="Achieved Percentage"
                                                                id="d_grade">{{$qualification['obt_marks']}}</td>
                                                            <td data-label="Experience Letter">
                                                                @if($qualification['qualificationImages'])
                                                                @php
                                                                    $extension = pathinfo($qualification['qualificationImages']['file_path'], PATHINFO_EXTENSION);
                                                                    $fileUrl = url('storage/'.$qualification['qualificationImages']['file_path']);
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
                                                                @endif

                                                                <a href="{{ $fileUrl }}" target="_blank">
                                                                    <img style="max-width: 20px" src="{{ $imageSrc }}"
                                                                         alt="File Icon">
                                                                </a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                    </div>
                                    </form>
                                    <!---------->
                                </div> <!-- end .page-content -->
                            </div>
                        </div>
                    </div>

                    <!-------------------->
                </div>
            </div>
        </div>
    </div>
</section>
@include('includes.footer')
