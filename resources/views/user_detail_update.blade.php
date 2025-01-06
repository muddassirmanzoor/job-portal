@include('includes.header')
<section class="hero-section">
    <div class="px-4 py-3 mb-3 text-center">
        <h1 class="display-5 fw-bold text-body-emphasis hero-heading">View Profile</h1>
    </div>
</section>

<section class="after-hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 bg p-3 text-black">
                <div class="card-body">
                    <!-------------------->
                    <div class="row white-container">
                        <div class="col-md-12 page-sidebar  mb-3">
                            <div class="card">
{{--                                <img style="width: 130px;margin: 30px auto 0 auto;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKSyc6olVgh1r-dUpRS50R7m4G0r6AOtmwSbF5aQb0Bbhv4D6KAtCpSCihob_zVpFjFng&usqp=CAU" class="card-img-top" alt="...">--}}
                                <div class="card-body">
                                    <h5 class="card-title mt-2">{{$application['post']['title'] }}</h5>
                                    <h5 class="card-title mt-2">Personal Information</h5>
                                    <div class="widget sidebar-widget white-container candidates-single-widget">
                                        <div class="widget-content">
                                            <table class="table">
                                                <tbody>
                                                <tr class="ps-info">
                                                    <td>Full Name</td>
                                                    <td>{{$application['first_name'] . ' '. $application['last_name'] }}</td>
                                                    <td>CNIC</td>
                                                    <td>{{$application['cnic_no']}}</td>
                                                    <td>Email</td>
                                                    <td>{{$application['email']}}</td>
                                                </tr>
                                                <tr class="ps-info">
                                                    <td>Gender</td>
                                                    <td>{{$application['gender']}}</td>
                                                    <td>Mobile</td>
                                                    <td>{{$application['phone_number']}}</td>
                                                    <td>Postal Address</td>
                                                    <td>{{$application['mailing_address']}}</td>
                                                </tr>
                                                <tr class="ps-info">
                                                    <td>Permanent Address</td>
                                                    <td>{{$application['permanent_address']}}</td>
                                                    <td>Resume</td>
                                                    <td> @php
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
                                                            <img style="max-width: 20px" src="{{ $imageSrc }}" alt="File Icon">
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

                        <div class="col-md-12 page-content">
                            <div class="card">
                                <div class="card-body">
                                    <!---------->

                                    <form method="POST" action="{{url('first-user-scrutiny-update')}}">
                                        @csrf
                                        <!-- Hidden input to store the total relevant experience -->
                                        <input type="hidden" name="total_relevant_experience" id="totalRelevantExperienceInput" value="0">
                                        <input type="hidden" name="applicant_id"  value="{{$application['applicant_id']}}">

                                        <div class="candidates-item candidates-single-item">
                                            <section>
                                                <h5 class="card-title mt-2">Academics</h5>
                                                <ul class="list-unstyled">
                                                    <!--                        <li><strong>Degree(s):</strong> </li>-->
                                                </ul>
                                                <div class="col-md-12 nopadding">
                                                    <table class="table table-hover table-striped" id="academics_table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Institute</th>
                                                            <th scope="col">Degree</th>
                                                            <th scope="col">Level</th>
                                                            <th scope="col">From</th>
                                                            <th scope="col">To</th>
                                                            <th scope="col">Marks/ Total Marks</th>
                                                            <th scope="col">Certificate</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($application['qualification'] as $qualification)
                                                            <tr id="708511">
                                                                <td data-label="Institute" id="d_institue">{{$qualification['institution']}}</td>
                                                                <td data-label="Degree" id="d_name">{{$qualification['degree_level']}}</td>
                                                                <td data-label="Level" id="d_major">{{$qualification['degree_title']}}</td>
                                                                <td data-label="From" id="d_start_date">{{date('d-m-Y', strtotime($qualification['start_date']))}}</td>
                                                                <td data-label="To" id="d_end_date">{{date('d-m-Y', strtotime($qualification['end_date']))}}</td>
                                                                <td data-label="Achieved Percentage" id="d_grade">{{$qualification['obt_marks']}}/ {{$qualification['total_marks']}}</td>
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
                                            <section>
                                                <h5 class="card-title mt-2">Basic Scrutiny</h5>
                                                <!------------------------>
                                                <div class="row">

                                                    <div class="md-col-12 mb-3">
                                                        <div class="form-group ">
                                                            <label class="basicScrutinyQ" for="exampleFormControlTextarea1">1: Qualification Criteria Met: </label>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="qualification_criteria_met" id="qualificationMetinlineRadio1" value="1" {{ $application['qualification_criteria_met'] == '1' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="qualification_criteria_met" id="qualificationMetinlineRadio2" value="0" {{ $application['qualification_criteria_met'] == '0' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                        </div>
                                                    </div> <!---End Col--->
                                                    <div class="md-col-12  mb-3">
                                                        <div class="form-group">
                                                            <label class="basicScrutinyQ" for="exampleFormControlTextarea1">2: Qualification Relevance: </label>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="qualification_relevance" id="educationRelevanceinlineRadio1" value="1" {{ $application['qualification_relevance'] == '1' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="qualification_relevance" id="educationRelevanceinlineRadio2" value="0" {{ $application['qualification_relevance'] == '0' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                        </div>
                                                    </div> <!---End Col--->


                                                    <div class="md-col-12  mb-3">
                                                        <div class="form-group">
                                                            <label class="basicScrutinyQ" for="exampleFormControlTextarea1">3: Higher Qualification : </label>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="higher_qualification" id="higherQualificationMetinlineRadio1" value="1" {{ $application['higher_qualification'] == '1' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="higher_qualification" id="higherQualificationMetinlineRadio2" value="0" {{ $application['higher_qualification'] == '0' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                        </div>
                                                    </div> <!---End Col--->
                                                </div><!---End ROw--->
                                                <!------------------------>
                                            </section>
                                            <section>
                                            <h5 class="card-title mt-2">Work History</h5>
                                            <div class="col-md-12 nopadding">
                                                <table class="table table-hover table-striped" id="work_history_table" style="margin:0px 0px 30px;">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Position Title</th>
                                                        <th scope="col"> Company Name</th>
                                                        <th scope="col">From</th>
                                                        <th scope="col">To</th>
                                                        <th scope="col">Experience</th>
                                                        <th scope="col">Experience Letter</th>
                                                        <th scope="col">Verified Start Date</th>
                                                        <th scope="col">Verified End Date</th>
                                                        <th scope="col">Relevance</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $total_experience_years = 0;
                                                        $total_experience_months = 0;
                                                    @endphp
                                                    @foreach($application['experience'] as $experience)
                                                        @php
                                                            $start = \Carbon\Carbon::parse($experience['start_date']);
                                                            $end = \Carbon\Carbon::parse($experience['end_date']);

                                                            // Calculate difference in years and months
                                                            $years = $end->diffInYears($start);
                                                            $months = $end->diffInMonths($start) % 12;

                                                            // Add this value to the total experience count in years and months
                                                            $total_experience_years += $years;
                                                            $total_experience_months += $months;

                                                            // If months exceed 12, convert to years
                                                            if ($total_experience_months >= 12) {
                                                                $additional_years = intdiv($total_experience_months, 12);
                                                                $total_experience_years += $additional_years;
                                                                $total_experience_months = $total_experience_months % 12;
                                                            }
                                                        @endphp
                                                    <tr id="{{$experience['employment_id']}}">
                                                        <td data-label="Position Title">{{$experience['job_title']}}</td>
                                                        <td data-label="Company Name">{{$experience['company_name']}}</td>
                                                        <td data-label="From">{{date('d-m-Y', strtotime($experience['start_date']))}}</td>
                                                        <td data-label="To">{{date('d-m-Y', strtotime($experience['end_date']))}}</td>
                                                        <td data-label="Total Experience">{{$years}}
                                                            years and {{$months}} months</td>
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
                                                        <!---------- Start Date Field ---------->
                                                        <td data-label="Start Date">
                                                            <div class="form-group">
                                                                <input class="form-control eligibility-start-date" type="date" name="eligibilityOptions[{{$experience['employment_id']}}][start_date]" id="eligibilityStartDate{{$experience['employment_id']}}" value="{{$experience['verified_start_date']}}">
                                                            </div>
                                                        </td>
                                                        <!---------- End Date Field ---------->
                                                        <td data-label="End Date">
                                                            <div class="form-group">
                                                                <input class="form-control eligibility-end-date" type="date" name="eligibilityOptions[{{$experience['employment_id']}}][end_date]" id="eligibilityEndDate{{$experience['employment_id']}}" value="{{$experience['verified_end_date']}}">
                                                            </div>
                                                        </td>
                                                        <!---------- Experience Relevance ---------->
                                                        <td data-label="Experience Relevance">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input relevance-yes" type="radio" name="eligibilityOptions[{{$experience['employment_id']}}][is_relevant]" id="eligibilityinlineRadioYes{{$experience['employment_id']}}" value="1" {{ $experience['is_relevant'] == '1' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="eligibilityinlineRadioYes{{$experience['employment_id']}}">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input relevance-no" type="radio" name="eligibilityOptions[{{$experience['employment_id']}}][is_relevant]" id="eligibilityinlineRadioNo{{$experience['employment_id']}}" value="0" {{ $experience['is_relevant']  == '0' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="eligibilityinlineRadioNo{{$experience['employment_id']}}">No</label>
                                                            </div>
                                                        </td>
                                                            <!---------->
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <ul class="list-unstyled">
                                                    <li><strong>Total
                                                            Experience:</strong> {{$total_experience_years}} years
                                                        and {{$total_experience_months}} months
                                                    </li>
                                                    <input type="hidden" name="total_experience"
                                                           value="{{$total_experience_years.'.'.$total_experience_months}}">
                                                </ul>
                                                <ul class="list-unstyled relevant-experience">
                                                    @php
                                                    $yearsMonths = explode('.', $application['total_relevant_experience']);
                                                    $years = $yearsMonths[0];
                                                    $months = 0;
                                                    if(isset($yearsMonths[1])){
                                                        $months = $yearsMonths[1];
                                                    }
                                                        @endphp
                                                    <li><strong>Total Verified/ Relevant Experience:</strong><span id="totalRelevantExperience">{{$years}} years and {{$months}} months</span></li>
                                                </ul>
                                            </div>
                                        </section>

                                        <section>
                                            <h5 class="card-title mt-2">Eligibility</h5>
                                                <!------------------------>
                                                <div class="row">
                                                    <div class="md-col-12  mb-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">Remarks</label>
                                                            <textarea class="form-control" name="remarks" id="exampleFormControlTextarea1" rows="3">{{ $application['remarks']}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="md-col-12  mb-3">
                                                        <div class="form-group">
                                                            <label class="basicScrutinyQ"  for="exampleFormControlTextarea1">Final Status:  </label>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_eligible" id="eligibilityinlineRadio1" value="1" {{ $application['is_eligible'] == '1' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="inlineRadio1">Eligible</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_eligible" id="eligibilityinlineRadio2" value="0" {{ $application['is_eligible'] == '0' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="inlineRadio2">Not Eligible</label>
                                                            </div>
                                                        </div>
                                                    </div> <!---End Col--->
                                                    <div class="form-group col-md-12 text-right mt-3">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div><!---End ROw--->
                                                <!------------------------>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function calculateTotalExperience() {
            let totalYears = 0;
            let totalMonths = 0;

            document.querySelectorAll('tr').forEach(row => {
                const startDateInput = row.querySelector('.eligibility-start-date');
                const endDateInput = row.querySelector('.eligibility-end-date');
                const relevanceYesRadio = row.querySelector('.relevance-yes');

                if (relevanceYesRadio && relevanceYesRadio.checked) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);

                    if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime())) {
                        let diffInMonths = (endDate.getFullYear() - startDate.getFullYear()) * 12 + (endDate.getMonth() - startDate.getMonth());

                        // If the end date's day is less than the start date's day, adjust the month count
                        if (endDate.getDate() < startDate.getDate()) {
                            diffInMonths--;
                        }

                        // Calculate years and months from the total months
                        const years = Math.floor(diffInMonths / 12);
                        const months = diffInMonths % 12;

                        totalYears += years;
                        totalMonths += months;
                    }
                }
            });

            // Convert months to years if totalMonths exceeds 12
            totalYears += Math.floor(totalMonths / 12);
            totalMonths = totalMonths % 12;

            // Display the total experience in the format of "X years and Y months"
            const totalRelevantExperienceElement = document.getElementById('totalRelevantExperience');
            if (totalRelevantExperienceElement) {
                totalRelevantExperienceElement.textContent = `${totalYears} years and ${totalMonths} months`;
            }
            $('#totalRelevantExperienceInput').val(totalYears+'.'+totalMonths);
        }
        // Attach event listeners to update experience on input change
        document.querySelectorAll('.eligibility-start-date, .eligibility-end-date, .relevance-yes, .relevance-no').forEach(input => {
            input.addEventListener('change', calculateTotalExperience);
        });

        // Initial calculation on page load
        calculateTotalExperience();
    });
</script>
{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        function calculateRelevantExperience() {--}}
{{--            var totalRelevantExperience =  0;--}}

{{--            // Iterate through each "Yes" radio button that is checked--}}
{{--            $('.experience-radio[type="radio"][value="1"]:checked').each(function() {--}}
{{--                // Extract the employment ID from the name attribute (e.g., "eligibilityOptions[1]")--}}
{{--                let employmentId = $(this).attr('name').match(/\d+/)[0];--}}

{{--                // Find the corresponding row using the employment ID--}}
{{--                let experienceRow = $('tr#' + employmentId);--}}

{{--                // Get the total experience value from the relevant column and convert it to a float--}}
{{--                let experienceYears = parseFloat(experienceRow.find('td[data-label="Total Experience"]').text()) || 0;--}}

{{--                // Add the experience to the total relevant experience--}}
{{--                totalRelevantExperience += experienceYears;--}}
{{--            });--}}

{{--            // Update the total relevant experience in the list--}}
{{--            $('ul.relevant-experience li strong').text('Total Relevant Experience: ' + totalRelevantExperience.toFixed(2) + ' Years');--}}

{{--            // Update the hidden input field with the total relevant experience--}}
{{--            $('#totalRelevantExperienceInput').val(totalRelevantExperience.toFixed(2));--}}
{{--        }--}}

{{--        // Trigger the calculation whenever a radio button is clicked--}}
{{--        $('input[type="radio"]').on('change', function() {--}}
{{--            calculateRelevantExperience();--}}
{{--        });--}}

{{--        // Initial calculation on page load--}}
{{--        calculateRelevantExperience();--}}
{{--    });--}}


{{--</script>--}}
@include('includes.footer')
