@include('includes.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Basic styling for the loader */
    #loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        display: none; /* Hidden by default */
        justify-content: center;
        align-items: center;
        z-index: 9999; /* Ensure it overlays other content */
    }

    #loader {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div id="loader-wrapper">
    <div id="loader"></div>
</div>
<section class="hero-section">
    <div class="px-4 py-3 mb-3 text-center">
        <h1 class="display-5 fw-bold text-body-emphasis hero-heading">JOB APPLICATION</h1>
    </div>
</section>

<section class="after-hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 bg p-3 text-left">
                <div class="card">
                    <div class="card-body">
                        <!-------------------->
                        <form action="{{url('submit-form')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row row">
                                <div class="form-group  col-md-12 mt-3">
                                    <h3 class="section-heading">Employment Eligibility</h3>
                                </div>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-group  col-md-12 mt-3">
                                    <label for="inputName" class="control-label">Position Applied For</label>
                                    <select id="employmentEligibility" name="post_id" class="form-control" required>
                                        <option selected="">Choose...</option>
                                        @foreach($jobs as $job)
                                            <option
                                                value="{{$job['post_id']}}" {{ old('post_id') == $job['post_id'] ? 'selected' : '' }}>{{$job['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-12 mt-3">
                                    <label for="inputName" class="control-label">Select Highest Qualification</label>
                                    <select id="educationYears" class="form-control">
                                        <option selected="">Choose...</option>
                                        <option value="Matric">Matric</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Bachelor">Bachelor (14)</option>
                                        <option value="16">Bachelor (Hons)</option>
                                        <option value="16">Master/Mphil</option>
                                        <option value="16">PHD</option>
                                    </select>
                                </div>
                                <div class="form-group  col-md-12 mt-3">
                                    <label for="inputName" class="control-label">Enter Years of
                                        Experience</label>
                                    <input type="number" id="experienceYears" class="form-control"
                                           placeholder="Type Numbers">
                                </div>
                                <div class="form-group col-md-12 text-right mt-3">
                                    <button type="submit" id="checkEligibility" class="btn btn-primary">Proceed</button>
                                </div>
                                <div id="employmentForm" class="row" style="display: none">
                                    <div class="form-group  col-md-12 mt-3">
                                        <div class="alert alert-primary py-1" id="employmentEligibilitycontent"
                                             style="display: none;" role="alert">
                                        </div>
                                    </div>
                                    <div class="form-group  col-md-12 mt-3">
                                        <h3 class="section-heading">Personal Information</h3>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="firstName" class="control-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="first_name"
                                               value="{{ old('first_name') }}" placeholder="Enter name" required>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="lastName" class="control-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="last_name"
                                               value="{{ old('last_name') }}" placeholder="Enter last name" required>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="CNIC" class="control-label">CNIC</label>
                                        <input type="text" class="form-control" maxlength="15" minlength="13" id="CNIC"
                                               name="cnic_no" value="{{ old('cnic_no') }}" placeholder="XXXXX-XXXXXXX-X"
                                               required oninput="this.value = this.value.replace(/[^0-9-]/g, '').substring(0, 15);">
                                    </div>

                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="Email" class="control-label">Email</label>
                                        <input type="text" class="form-control" id="Email" name="email"
                                               value="{{ old('email') }}" placeholder="test@test.com" required>
                                    </div>

                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="Gender" class="control-label">Gender</label>
                                        <select id="Gender" class="form-control" name="gender" required>
                                            <option selected="">Choose...</option>
                                            <option {{ old('gender') == 'MALE' ? 'selected' : '' }} value="MALE">MALE
                                            </option>
                                            <option {{ old('gender') == 'FEMALE' ? 'selected' : '' }} value="FEMALE">
                                                FEMALE
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 mt-3">
                                        <label for="mobileNumber" class="control-label">Mobile Number</label>
                                        <input type="text" class="form-control" id="mobileNumber" name="phone_number"
                                               value="{{ old('phone_number') }}" placeholder="0000-0000000" minlength="10" maxlength="12" required
                                               oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(.*-.*-)/g, '$1').substring(0, 12);">
                                    </div>
                                    <div class="form-group col-md-12 mt-3">
                                        <label for="postalAddress" class="control-label">Present Address</label>
                                        <textarea type="text" class="form-control" id="postalAddress"
                                                  name="mailing_address" placeholder="Enter Present Address"
                                                  required>{{ old('mailing_address') }}</textarea>
                                    </div>

                                    <div class="form-group col-md-12 mt-3">
                                        <label for="permanentAddress" class="control-label">Permanent Address</label>
                                        <textarea type="text" class="form-control" id="permanentAddress"
                                                  name="permanent_address" placeholder="Enter Permanent Address"
                                                  required>{{ old('permanent_address') }}</textarea>
                                    </div>
                                    <div class="form-group col-md-12 mt-3">
                                        <label for="attachResume" class="control-label">Attach Resume (.pdf)</label>
                                        <input class="form-control ed_common_disable" id="attachResume" name="resume"
                                               type="file" required accept=".pdf, .doc, .docx, image/*">
                                    </div>
                                    <!-------------------Personal Information END------------------>
                                    <!-------------------Academics Information Start------------------>
                                    <div class="form-group  col-md-12 mt-3">
                                        <h3 class="section-heading">Qualification</h3>
                                        {{--                                        <p>Note: Please enter your qualifications starting from most recent</p>--}}
                                    </div>
                                    <!-------------Matriculation / Equivalent Start------------->
                                    <div class="form-group  col-md-12 mt-3">
                                        <h5>Matriculation / Equivalent </h5>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreelevel" class="control-label">Degree Level</label>
                                        <input type="text" class="form-control" name="qualification[0][degree_level]"
                                               value="{{ old('qualification.0.degree_level') }}" id="matricDegreelevel"
                                               placeholder="SSC" required>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreeTitle" class="control-label">Degree Title</label>
                                        <input type="text" class="form-control" name="qualification[0][degree_title]"
                                               value="{{ old('qualification.0.degree_title') }}" id="matricDegreeTitle"
                                               placeholder="Matric" required>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegree"
                                               class="control-label">Board/College/University:</label>
                                        <input type="text" class="form-control" id="matricDegree"
                                               name="qualification[0][institution]"
                                               value="{{ old('qualification.0.institution') }}"
                                               placeholder="Board/College/University" required>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricMajorSubjects" class="control-label">Major Subjects</label>
                                        <input type="text" class="form-control" name="qualification[0][major_subject]"
                                               value="{{ old('qualification.0.major_subject') }}"
                                               id="matricMajorSubjects" placeholder="Science/Arts" required>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricStartDate" class="control-label">Start Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               value="{{ old('qualification.0.start_date') }}"
                                               name="qualification[0][start_date]" id="matricStartDate" required>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricCompletionDate" class="control-label">Completion Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               value="{{ old('qualification.0.end_date') }}"
                                               name="qualification[0][end_date]" id="matricCompletionDate" required>
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricTotalMarks" class="control-label">Total Marks / CGPA</label>
                                        <input class="form-control" type="text" name="qualification[0][total_marks]"
                                               value="{{ old('qualification.0.total_marks') }}" id="matricTotalMarks"
                                               required
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricObtainedMarks" class="control-label">Obtained Marks /
                                            CGPA</label>
                                        <input class="form-control" type="text" name="qualification[0][obt_marks]"
                                               value="{{ old('qualification.0.obt_marks') }}" id="matricObtainedMarks"
                                               required
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="form-group col-md-4 mt-3">
                                        <label for="matricDegree" class="control-label">Attach
                                            Degree/Certificate</label>
                                        <input class="form-control" name="qualification[0][file]"
                                               id="matricAttachDegreeCertificate" type="file" accept=".pdf, .doc, .docx, image/*" required>
                                    </div>
                                    <!-------------Matriculation / Equivalent END------------->

                                    <!-------------Inter / Equivalent Start------------->
                                    <div class="form-group  col-md-12 mt-3">
                                        <h5>Intermediate</h5>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreelevel" class="control-label">Degree Level</label>
                                        <input type="text" class="form-control" name="qualification[1][degree_level]"
                                               value="{{ old('qualification.1.degree_level') }}" id="matricDegreelevel"
                                               placeholder="HSSC">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreeTitle" class="control-label">Degree Title</label>
                                        <input type="text" class="form-control" name="qualification[1][degree_title]"
                                               value="{{ old('qualification.1.degree_title') }}" id="matricDegreeTitle"
                                               placeholder="FSC/ ICS">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegree"
                                               class="control-label">Board/College/University:</label>
                                        <input type="text" class="form-control" id="matricDegree"
                                               name="qualification[1][institution]"
                                               value="{{ old('qualification.1.institution') }}"
                                               placeholder="Board/College/University">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricMajorSubjects" class="control-label">Major Subjects</label>
                                        <input type="text" class="form-control" name="qualification[1][major_subject]"
                                               value="{{ old('qualification.1.major_subject') }}"
                                               id="matricMajorSubjects" placeholder="Pre.Med/Eng/ICS/ICOM">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricStartDate" class="control-label">Start Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               value="{{ old('qualification.1.start_date') }}"
                                               name="qualification[1][start_date]" id="matricStartDate">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricCompletionDate" class="control-label">Completion Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               value="{{ old('qualification.1.end_date') }}"
                                               name="qualification[1][end_date]" id="matricCompletionDate">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricTotalMarks" class="control-label">Total Marks / CGPA</label>
                                        <input class="form-control" type="text" name="qualification[1][total_marks]"
                                               value="{{ old('qualification.1.total_marks') }}" id="matricTotalMarks"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricObtainedMarks" class="control-label">Obtained Marks /
                                            CGPA</label>
                                        <input class="form-control" type="text" name="qualification[1][obt_marks]"
                                               value="{{ old('qualification.1.obt_marks') }}" id="matricObtainedMarks"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="form-group col-md-4 mt-3">
                                        <label for="matricDegree" class="control-label">Attach
                                            Degree/Certificate</label>
                                        <input class="form-control" name="qualification[1][file]"
                                               id="matricAttachDegreeCertificate" type="file" accept=".pdf, .doc, .docx, image/*">
                                    </div>
                                    <!------------Inter / Equivalent END------------->
                                    <!-------------Bachelor Four Years Programme Start------------->
                                    <div class="form-group  col-md-12 mt-3">
                                        <h5>Bachelor (14/16) years</h5>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreelevel" class="control-label">Degree Level</label>
                                        <input type="text" class="form-control" name="qualification[2][degree_level]"
                                               value="{{ old('qualification.2.degree_level') }}" id="matricDegreelevel"
                                               placeholder="Bachelors">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreeTitle" class="control-label">Degree Title</label>
                                        <input type="text" class="form-control" name="qualification[2][degree_title]"
                                               value="{{ old('qualification.2.degree_title') }}" id="matricDegreeTitle"
                                               placeholder="BS Hons">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegree"
                                               class="control-label">Board/College/University:</label>
                                        <input type="text" class="form-control" id="matricDegree"
                                               name="qualification[2][institution]"
                                               value="{{ old('qualification.2.institution') }}"
                                               placeholder="Board/College/University">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricMajorSubjects" class="control-label">Major Subjects</label>
                                        <input type="text" class="form-control" name="qualification[2][major_subject]"
                                               value="{{ old('qualification.2.major_subject') }}"
                                               id="matricMajorSubjects">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricStartDate" class="control-label">Start Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               name="qualification[2][start_date]"
                                               value="{{ old('qualification.2.start_date') }}" id="matricStartDate">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricCompletionDate" class="control-label">Completion Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               name="qualification[2][end_date]"
                                               value="{{ old('qualification.2.end_date') }}" id="matricCompletionDate">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricTotalMarks" class="control-label">Total Marks / CGPA</label>
                                        <input class="form-control" type="text" name="qualification[2][total_marks]"
                                               value="{{ old('qualification.2.total_marks') }}" id="matricTotalMarks"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricObtainedMarks" class="control-label">Obtained Marks /
                                            CGPA</label>
                                        <input class="form-control" type="text" name="qualification[2][obt_marks]"
                                               value="{{ old('qualification.2.obt_marks') }}" id="matricObtainedMarks"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="form-group col-md-4 mt-3">
                                        <label for="matricDegree" class="control-label">Attach
                                            Degree/Certificate</label>
                                        <input class="form-control" name="qualification[2][file]"
                                               id="matricAttachDegreeCertificate" type="file" accept=".pdf, .doc, .docx, image/*">
                                    </div>
                                    <!-------------Bachelor Four Years Programme END------------->
                                    <!-------------Master Programme Start------------->
                                    <div class="form-group  col-md-12 mt-3">
                                        <h5>Master </h5>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreelevel" class="control-label">Degree Level</label>
                                        <input type="text" class="form-control" name="qualification[3][degree_level]"
                                               value="{{ old('qualification.3.degree_level') }}" id="matricDegreelevel"
                                               placeholder="Master">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreeTitle" class="control-label">Degree Title</label>
                                        <input type="text" class="form-control" name="qualification[3][degree_title]"
                                               value="{{ old('qualification.3.degree_title') }}" id="matricDegreeTitle"
                                               placeholder="Master">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegree"
                                               class="control-label">Board/College/University:</label>
                                        <input type="text" class="form-control" id="matricDegree"
                                               name="qualification[3][institution]"
                                               value="{{ old('qualification.3.institution') }}"
                                               placeholder="Board/College/University">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricMajorSubjects" class="control-label">Major Subjects</label>
                                        <input type="text" class="form-control" name="qualification[3][major_subject]"
                                               value="{{ old('qualification.3.major_subject') }}"
                                               id="matricMajorSubjects">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricStartDate" class="control-label">Start Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               value="{{ old('qualification.3.start_date') }}"
                                               name="qualification[3][start_date]" id="matricStartDate">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricCompletionDate" class="control-label">Completion Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               value="{{ old('qualification.3.end_date') }}"
                                               name="qualification[3][end_date]" id="matricCompletionDate">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricTotalMarks" class="control-label">Total Marks / CGPA</label>
                                        <input class="form-control" type="text" name="qualification[3][total_marks]"
                                               value="{{ old('qualification.3.total_marks') }}" id="matricTotalMarks"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricObtainedMarks" class="control-label">Obtained Marks /
                                            CGPA</label>
                                        <input class="form-control" type="text" name="qualification[3][obt_marks]"
                                               value="{{ old('qualification.3.obt_marks') }}" id="matricObtainedMarks"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="form-group col-md-4 mt-3">
                                        <label for="matricDegree" class="control-label">Attach
                                            Degree/Certificate</label>
                                        <input class="form-control" name="qualification[3][file]"
                                               id="matricAttachDegreeCertificate" type="file" accept=".pdf, .doc, .docx, image/*">
                                    </div>
                                    <!-------------Master Programme  END------------->
                                    <!-------------MPhil Programme Start------------->
                                    <div class="form-group  col-md-12 mt-3">
                                        <h5>MPhil</h5>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreelevel" class="control-label">Degree Level</label>
                                        <input type="text" class="form-control" name="qualification[4][degree_level]"
                                               value="{{ old('qualification.4.obt_marks') }}" id="matricDegreelevel"
                                               placeholder="MS / Mphil">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreeTitle" class="control-label">Degree Title</label>
                                        <input type="text" class="form-control" name="qualification[4][degree_title]"
                                               value="{{ old('qualification.4.degree_title') }}" id="matricDegreeTitle"
                                               placeholder="MS / Mphil">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegree"
                                               class="control-label">Board/College/University:</label>
                                        <input type="text" class="form-control" id="matricDegree"
                                               name="qualification[4][institution]"
                                               value="{{ old('qualification.4.institution') }}"
                                               placeholder="Board/College/University">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricMajorSubjects" class="control-label">Major Subjects</label>
                                        <input type="text" class="form-control" name="qualification[4][major_subject]"
                                               value="{{ old('qualification.4.major_subject') }}"
                                               id="matricMajorSubjects">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricStartDate" class="control-label">Start Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               value="{{ old('qualification.4.start_date') }}"
                                               name="qualification[4][start_date]" id="matricStartDate">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricCompletionDate" class="control-label">Completion Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               value="{{ old('qualification.4.end_date') }}"
                                               name="qualification[4][end_date]" id="matricCompletionDate">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricTotalMarks" class="control-label">Total Marks / CGPA</label>
                                        <input class="form-control" type="text" name="qualification[4][total_marks]"
                                               value="{{ old('qualification.4.total_marks') }}" id="matricTotalMarks"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricObtainedMarks" class="control-label">Obtained Marks /
                                            CGPA</label>
                                        <input class="form-control" type="text" name="qualification[4][obt_marks]"
                                               value="{{ old('qualification.4.obt_marks') }}" id="matricObtainedMarks"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="form-group col-md-4 mt-3">
                                        <label for="matricDegree" class="control-label">Attach
                                            Degree/Certificate</label>
                                        <input class="form-control" name="qualification[4][file]"
                                               id="matricAttachDegreeCertificate" type="file" accept=".pdf, .doc, .docx, image/*">
                                    </div>
                                    <!-------------Phd Programme END------------->
                                    <!-------------Phd Programme Start------------->
                                    <div class="form-group  col-md-12 mt-3">
                                        <h5>PhD</h5>
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreelevel" class="control-label">Degree Level</label>
                                        <input type="text" class="form-control" name="qualification[5][degree_level]"
                                               value="{{ old('qualification.5.obt_marks') }}" id="matricDegreelevel"
                                               placeholder="Phd">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegreeTitle" class="control-label">Degree Title</label>
                                        <input type="text" class="form-control" name="qualification[5][degree_title]"
                                               value="{{ old('qualification.5.degree_title') }}" id="matricDegreeTitle"
                                               placeholder="Doctrate">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricDegree"
                                               class="control-label">Board/College/University:</label>
                                        <input type="text" class="form-control" id="matricDegree"
                                               name="qualification[5][institution]"
                                               value="{{ old('qualification.5.institution') }}"
                                               placeholder="Board/College/University">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricMajorSubjects" class="control-label">Major Subjects</label>
                                        <input type="text" class="form-control" name="qualification[5][major_subject]"
                                               value="{{ old('qualification.5.major_subject') }}"
                                               id="matricMajorSubjects">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricStartDate" class="control-label">Start Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               value="{{ old('qualification.5.start_date') }}"
                                               name="qualification[5][start_date]" id="matricStartDate">
                                    </div>
                                    <div class="form-group  col-md-4 mt-3">
                                        <label for="matricCompletionDate" class="control-label">Completion Date</label>
                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"
                                               value="{{ old('qualification.5.end_date') }}"
                                               name="qualification[5][end_date]" id="matricCompletionDate">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricTotalMarks" class="control-label">Total Marks / CGPA</label>
                                        <input class="form-control" type="text" name="qualification[5][total_marks]"
                                               value="{{ old('qualification.5.total_marks') }}" id="matricTotalMarks"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                        <label for="matricObtainedMarks" class="control-label">Obtained Marks /
                                            CGPA</label>
                                        <input class="form-control" type="text" name="qualification[5][obt_marks]"
                                               value="{{ old('qualification.5.obt_marks') }}" id="matricObtainedMarks"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                    </div>
                                    <div class="form-group col-md-4 mt-3">
                                        <label for="matricDegree" class="control-label">Attach
                                            Degree/Certificate</label>
                                        <input class="form-control" name="qualification[5][file]"
                                               id="matricAttachDegreeCertificate" type="file" accept=".pdf, .doc, .docx, image/*">
                                    </div>
                                    <!-------------Phd Programme END------------->
                                    <!-------------------Academics Information END------------------>
                                    <!-------------------Previous Employment Start------------------>
                                    <!-- Employment Sections Container -->
                                    <div id="employmentSectionsContainer" class="form-group  col-md-12">
                                        <div class="row mt-3">
                                            <div class="form-group  col-md-12 mt-3">
                                                <h3 class="section-heading"> Employment History</h3>
                                                <p>Note: Please enter your work experience starting from most
                                                    recent.</p>
                                            </div>
                                            <!-------------Phd Programme Start------------->
                                            <!-------------Previous Employment 1 Start------------->
                                            <div class="form-group  col-md-12 mt-3">
                                                <h5>Employer 1</h5>
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpDesignation1" class="control-label">Designation</label>
                                                <input type="text" class="form-control" id="EmpDesignation1"
                                                       name="employment[0][job_title]"
                                                       value="{{ old('employment.0.job_title') }}"
                                                       placeholder="Designation"
                                                       required>
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="employerName1" class="control-label">Company/ Dept
                                                    Name</label>
                                                <input type="text" class="form-control" id="employerName1"
                                                       name="employment[0][company_name]"
                                                       value="{{ old('employment.0.company_name') }}"
                                                       placeholder="Company/ Dept Name" required>
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpLocationName1" class="control-label">Address </label>
                                                <input type="text" class="form-control" id="EmpLocationName1"
                                                       name="employment[0][location]"
                                                       value="{{ old('employment.0.location') }}"
                                                       placeholder="Location" required>
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpStartDate1" class="control-label">Start Date</label>
                                                <input type="date" class="form-control"
                                                       max="{{ now()->format('Y-m-d') }}"
                                                       value="{{ old('employment.0.start_date') }}"
                                                       name="employment[0][start_date]" id="EmpStartDate1" required>
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpEndDate1" class="control-label">End Date</label>
                                                <input type="date" class="form-control"
                                                       max="{{ now()->format('Y-m-d') }}"
                                                       value="{{ old('employment.0.end_date') }}"
                                                       name="employment[0][end_date]"
                                                       id="EmpEndDate1" required>
                                            </div>
                                            <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                                <label for="EmpTotalExperience1" class="control-label">Total Experience
                                                    (Only
                                                    Numbers)</label>
                                                <input class="form-control" type="text"
                                                       name="employment[0][total_experience]"
                                                       value="{{ old('employment.0.total_experience') }}"
                                                       id="EmpTotalExperience1" required
                                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                            </div>
                                            <div class="form-group col-md-8 mt-3">
                                                <label for="EmpAttachExperienceCertificate1" class="control-label">Attach
                                                    Experience Certificate</label>
                                                <input class="form-control" name="employment[0][file]"
                                                       id="EmpAttachExperienceCertificate1" type="file" accept=".pdf, .doc, .docx, image/*">
                                            </div>
                                            <!-------------Previous Employment 1 END------------->
                                            <!-------------Previous Employment 2 Start------------->
                                            <div class="form-group  col-md-12 mt-3">
                                                <h5>Employer 2</h5>
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpDesignation1" class="control-label">Designation</label>
                                                <input type="text" class="form-control" id="EmpDesignation1"
                                                       name="employment[1][job_title]"
                                                       value="{{ old('employment.1.job_title') }}"
                                                       placeholder="Designation">
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="employerName1" class="control-label">Company/ Dept
                                                    Name</label>
                                                <input type="text" class="form-control" id="employerName1"
                                                       name="employment[1][company_name]"
                                                       value="{{ old('employment.1.company_name') }}"
                                                       placeholder="Company/ Dept Name">
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpLocationName1" class="control-label">Address </label>
                                                <input type="text" class="form-control" id="EmpLocationName1"
                                                       name="employment[1][location]"
                                                       value="{{ old('employment.1.location') }}"
                                                       placeholder="Location">
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpStartDate1" class="control-label">Start Date</label>
                                                <input type="date" class="form-control"
                                                       max="{{ now()->format('Y-m-d') }}"
                                                       value="{{ old('employment.1.start_date') }}"
                                                       name="employment[1][start_date]" id="EmpStartDate1">
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpEndDate1" class="control-label">End Date</label>
                                                <input type="date" class="form-control"
                                                       max="{{ now()->format('Y-m-d') }}"
                                                       value="{{ old('employment.1.end_date') }}"
                                                       name="employment[1][end_date]"
                                                       id="EmpEndDate1">
                                            </div>
                                            <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                                <label for="EmpTotalExperience1" class="control-label">Total
                                                    Experience</label>
                                                <input class="form-control" type="text"
                                                       name="employment[1][total_experience]"
                                                       value="{{ old('employment.1.total_experience') }}"
                                                       id="EmpTotalExperience1"
                                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                            </div>
                                            <div class="form-group col-md-8 mt-3">
                                                <label for="EmpAttachExperienceCertificate1" class="control-label">Attach
                                                    Experience Certificate</label>
                                                <input class="form-control" name="employment[1][file]"
                                                       id="EmpAttachExperienceCertificate1" type="file" accept=".pdf, .doc, .docx, image/*">
                                            </div>
                                            <!-------------Previous Employment 2 END------------->
                                            <!-------------Previous Employment 3 Start------------->
                                            <div class="form-group  col-md-12 mt-3">
                                                <h5>Employer 3</h5>
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpDesignation1" class="control-label">Designation</label>
                                                <input type="text" class="form-control" id="EmpDesignation1"
                                                       name="employment[2][job_title]"
                                                       value="{{ old('employment.2.job_title') }}"
                                                       placeholder="Designation">
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="employerName1" class="control-label">Company/ Dept
                                                    Name</label>
                                                <input type="text" class="form-control" id="employerName1"
                                                       name="employment[2][company_name]"
                                                       value="{{ old('employment.2.company_name') }}"
                                                       placeholder="Company/ Dept Name">
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpLocationName1" class="control-label">Address </label>
                                                <input type="text" class="form-control" id="EmpLocationName1"
                                                       name="employment[2][location]"
                                                       value="{{ old('employment.2.location') }}"
                                                       placeholder="Location">
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpStartDate1" class="control-label">Start Date</label>
                                                <input type="date" class="form-control"
                                                       max="{{ now()->format('Y-m-d') }}"
                                                       value="{{ old('employment.2.start_date') }}"
                                                       name="employment[2][start_date]" id="EmpStartDate1">
                                            </div>
                                            <div class="form-group  col-md-4 mt-3">
                                                <label for="EmpEndDate1" class="control-label">End Date</label>
                                                <input type="date" class="form-control"
                                                       max="{{ now()->format('Y-m-d') }}"
                                                       value="{{ old('employment.2.end_date') }}"
                                                       name="employment[2][end_date]"
                                                       id="EmpEndDate1">
                                            </div>
                                            <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">
                                                <label for="EmpTotalExperience1" class="control-label">Total
                                                    Experience</label>
                                                <input class="form-control" type="text"
                                                       name="employment[2][total_experience]"
                                                       value="{{ old('employment.2.total_experience') }}"
                                                       id="EmpTotalExperience1"
                                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                            </div>
                                            <div class="form-group col-md-8 mt-3">
                                                <label for="EmpAttachExperienceCertificate1" class="control-label">Attach
                                                    Experience Certificate</label>
                                                <input class="form-control" name="employment[2][file]"
                                                       id="EmpAttachExperienceCertificate1" type="file" accept=".pdf, .doc, .docx, image/*">
                                            </div>
                                            <!-------------Previous Employment 3 END------------->
                                            <div id="employmentSectionTemplate" style="display: none;">
                                                <div class="row mt-3">
                                                    <div class="form-group  col-md-12 mt-3">
                                                        <h5>Employer <span class="employer-number"></span></h5>
                                                    </div>
                                                    <div class="form-group  col-md-4 mt-3">
                                                        <label class="control-label">Designation</label>
                                                        <input type="text" class="form-control job-title"
                                                               placeholder="Designation">
                                                    </div>
                                                    <div class="form-group  col-md-4 mt-3">
                                                        <label class="control-label">Company/ Dept Name</label>
                                                        <input type="text" class="form-control company-name"
                                                               placeholder="Company/ Dept Name">
                                                    </div>
                                                    <div class="form-group  col-md-4 mt-3">
                                                        <label class="control-label">Address</label>
                                                        <input type="text" class="form-control location"
                                                               placeholder="Location">
                                                    </div>
                                                    <div class="form-group  col-md-4 mt-3">
                                                        <label class="control-label">Start Date</label>
                                                        <input type="date" class="form-control start-date"
                                                               max="{{ now()->format('Y-m-d') }}">
                                                    </div>
                                                    <div class="form-group  col-md-4 mt-3">
                                                        <label class="control-label">End Date</label>
                                                        <input type="date" class="form-control end-date"
                                                               max="{{ now()->format('Y-m-d') }}">
                                                    </div>
                                                    <div class="form-group col-md-4 mt-3">
                                                        <label class="control-label">Total Experience</label>
                                                        <input class="form-control total-experience" type="text"
                                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 4);">
                                                    </div>
                                                    <div class="form-group col-md-8 mt-3">
                                                        <label class="control-label">Attach Experience
                                                            Certificate</label>
                                                        <input class="form-control experience-certificate" type="file" accept=".pdf, .doc, .docx, image/*">
                                                    </div>
{{--                                                    <div class="form-group col-md-12 text-right mt-3">--}}
{{--                                                        <button type="button" class="btn btn-danger removeSectionBtn">--}}
{{--                                                            Remove Section--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
{{--                                                    <hr>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 text-right mt-3">
                                        <button type="button" id="addEmployerBtn" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Add Experience
                                        </button>
                                    </div>

                                    <!-------------Previous Employment 4 Start------------->
                                    {{--                                    <div class="form-group  col-md-12 mt-3">--}}
                                    {{--                                        <h5>Employer 4</h5>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group  col-md-4 mt-3">--}}
                                    {{--                                        <label for="employerName1" class="control-label">Company/ Dept Name</label>--}}
                                    {{--                                        <input type="text" class="form-control" id="employerName1"--}}
                                    {{--                                               name="employment[3][company_name]"--}}
                                    {{--                                               value="{{ old('employment.3.company_name') }}"--}}
                                    {{--                                               placeholder="Company/ Dept Name">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group  col-md-4 mt-3">--}}
                                    {{--                                        <label for="EmpDesignation1" class="control-label">Designation</label>--}}
                                    {{--                                        <input type="text" class="form-control" id="EmpDesignation1"--}}
                                    {{--                                               name="employment[3][job_title]"--}}
                                    {{--                                               value="{{ old('employment.3.job_title') }}" placeholder="Designation">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group  col-md-4 mt-3">--}}
                                    {{--                                        <label for="EmpLocationName1" class="control-label">Location </label>--}}
                                    {{--                                        <input type="text" class="form-control" id="EmpLocationName1"--}}
                                    {{--                                               name="employment[3][location]" value="{{ old('employment.3.location') }}"--}}
                                    {{--                                               placeholder="Location">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group  col-md-4 mt-3">--}}
                                    {{--                                        <label for="EmpStartDate1" class="control-label">Start Date</label>--}}
                                    {{--                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"--}}
                                    {{--                                               name="employment[3][start_date]"--}}
                                    {{--                                               value="{{ old('employment.3.start_date') }}" id="EmpStartDate1">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group  col-md-4 mt-3">--}}
                                    {{--                                        <label for="EmpEndDate1" class="control-label">End Date</label>--}}
                                    {{--                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"--}}
                                    {{--                                               name="employment[3][end_date]" value="{{ old('employment.3.end_date') }}"--}}
                                    {{--                                               id="EmpEndDate1">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">--}}
                                    {{--                                        <label for="EmpTotalExperience1" class="control-label">Total Experience</label>--}}
                                    {{--                                        <input class="form-control" type="text" name="employment[3][total_experience]"--}}
                                    {{--                                               value="{{ old('employment.3.total_experience') }}"--}}
                                    {{--                                               id="EmpTotalExperience1">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group col-md-8 mt-3">--}}
                                    {{--                                        <label for="EmpAttachExperienceCertificate1" class="control-label">Attach--}}
                                    {{--                                            Experience Certificate</label>--}}
                                    {{--                                        <input class="form-control" name="employment[3][file]"--}}
                                    {{--                                               id="EmpAttachExperienceCertificate1" type="file">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <!-------------Previous Employment 4 END------------->--}}
                                    {{--                                    <!-------------Previous Employment 5 Start------------->--}}
                                    {{--                                    <div class="form-group  col-md-12 mt-3">--}}
                                    {{--                                        <h5>Employer 5</h5>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group  col-md-4 mt-3">--}}
                                    {{--                                        <label for="employerName1" class="control-label">Company/ Dept Name</label>--}}
                                    {{--                                        <input type="text" class="form-control" id="employerName1"--}}
                                    {{--                                               name="employment[4][company_name]"--}}
                                    {{--                                               value="{{ old('employment.4.company_name') }}"--}}
                                    {{--                                               placeholder="Company/ Dept Name">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group  col-md-4 mt-3">--}}
                                    {{--                                        <label for="EmpDesignation1" class="control-label">Designation</label>--}}
                                    {{--                                        <input type="text" class="form-control" id="EmpDesignation1"--}}
                                    {{--                                               name="employment[4][job_title]"--}}
                                    {{--                                               value="{{ old('employment.4.job_title') }}" placeholder="Designation">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group  col-md-4 mt-3">--}}
                                    {{--                                        <label for="EmpLocationName1" class="control-label">Location </label>--}}
                                    {{--                                        <input type="text" class="form-control" id="EmpLocationName1"--}}
                                    {{--                                               name="employment[4][location]" value="{{ old('employment.4.location') }}"--}}
                                    {{--                                               placeholder="Location">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group  col-md-4 mt-3">--}}
                                    {{--                                        <label for="EmpStartDate1" class="control-label">Start Date</label>--}}
                                    {{--                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"--}}
                                    {{--                                               value="{{ old('employment.4.start_date') }}"--}}
                                    {{--                                               name="employment[4][start_date]" id="EmpStartDate1">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group  col-md-4 mt-3">--}}
                                    {{--                                        <label for="EmpEndDate1" class="control-label">End Date</label>--}}
                                    {{--                                        <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}"--}}
                                    {{--                                               value="{{ old('employment.4.end_date') }}" name="employment[4][end_date]"--}}
                                    {{--                                               id="EmpEndDate1">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="col-md-4 col-md-4 mt-3 ed_degree_marks_section">--}}
                                    {{--                                        <label for="EmpTotalExperience1" class="control-label">Total Experience</label>--}}
                                    {{--                                        <input class="form-control" type="text" name="employment[4][total_experience]"--}}
                                    {{--                                               value="{{ old('employment.4.total_experience') }}"--}}
                                    {{--                                               id="EmpTotalExperience1">--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-group col-md-8 mt-3">--}}
                                    {{--                                        <label for="EmpAttachExperienceCertificate1" class="control-label">Attach--}}
                                    {{--                                            Experience Certificate</label>--}}
                                    {{--                                        <input class="form-control" name="employment[4][file]"--}}
                                    {{--                                               id="EmpAttachExperienceCertificate1" type="file">--}}
                                    {{--                                    </div>--}}
                                    <!-------------Previous Employment 5 END------------->

                                    <div class="form-group  col-md-12 mt-3">
                                        <h5>Disclaimer</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckDefault" required>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <p>I, certify that the information provided in this form are true and
                                                    complete to the best of my knowledge. If this application leads to
                                                    my eventual employment, I understand that any false or misleading
                                                    information in my application or interview may result in my
                                                    employment being terminated.</p>
                                            </label>
                                        </div>
                                    </div>

                                    <!-------------Previous Employment 5 END------------->

                                    <div class="form-group col-md-12 text-right mt-3">
                                        <button type="submit" class="btn btn-primary">Submit Application</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-------------------->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {

        // Education and experience mapping for specific posts beyond 12
        var eligibilityCriteria = {
            26: {
                "PHD": [6],
                "16": [10]
            },
            30: {
                "16": [7]
            },
            31: {
                "16": [7]
            },
            32: {
                "16": [5]
            },
            // Add additional mappings as needed
        };

        // Function to hide the form
        function hideForm() {
            $('#employmentForm').hide();
        }

        // Hide the form when any field changes
        $('#employmentEligibility, #educationYears, #experienceYears').on('change keyup', function () {
            hideForm();
        });

        // $('#checkEligibility').click(function(e) {
        //     e.preventDefault();
        //
        //     var postId = parseInt($('#employmentEligibility').val());
        //     var qualification = $('#educationYears').val();
        //     var experience = parseInt($('#experienceYears').val());
        //
        //     if (!postId || !qualification || isNaN(experience)) {
        //         alert('Please fill in all fields.');
        //         return;
        //     }
        //
        //     var requiredExperience = eligibilityCriteria[postId] ? eligibilityCriteria[postId][qualification] : null;
        //
        //     if (requiredExperience !== null) {
        //         if (experience >= requiredExperience) {
        //             $('#employmentForm').show();
        //         } else {
        //             $('#employmentForm').hide();
        //             alert('Your experience does not match the requirements for this post.');
        //         }
        //     } else {
        //         $('#employmentForm').hide();
        //         alert('No matching criteria found for the selected post and qualification.');
        //     }
        // });
    });
</script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var eligibilityCriteria = {};

    // Function to fetch eligibility criteria via fetch API
    function fetchEligibilityCriteria(postId, callback) {
        // Show loader before starting the fetch
        document.getElementById('loader-wrapper').style.display = 'flex';

        fetch('eligibility-criteria/' + postId) // Your API endpoint
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                eligibilityCriteria = data; // Update global eligibilityCriteria
                if (callback && typeof callback === 'function') {
                    callback(); // Execute the callback function if provided
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Not Eligible',
                    text: 'No matching criteria found for the selected post and qualification.'
                });
            })
            .finally(() => {
                // Hide loader after fetching data
                document.getElementById('loader-wrapper').style.display = 'none';
            });
    }

    // Event handler for the eligibility check button
    document.getElementById('checkEligibility').addEventListener('click', function (e) {
        e.preventDefault();


        var postId = parseInt(document.getElementById('employmentEligibility').value);
        var qualification = document.getElementById('educationYears').value;
        var experience = parseInt(document.getElementById('experienceYears').value);

        if (!postId || !qualification || isNaN(experience)) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Data',
                text: 'Please fill in all fields.'
            });
            return;
        }
        // Fetch the eligibility criteria before checking
        fetchEligibilityCriteria(postId, function () {
            var eligibilityData = eligibilityCriteria[postId];  // Eligibility data for the selected post
console.log(qualification);
            if (eligibilityData) {
                // Check if the qualification exists in the eligibility data
                var requiredExperience = eligibilityData[qualification] ? eligibilityData[qualification] : null;

                if (requiredExperience !== null) {
                    // Convert experience to number if it's coming as a string
                    var requiredYears = parseInt(requiredExperience[0]);

                    // Check if the provided experience meets or exceeds the required experience
                    if (experience >= requiredYears) {
                        $('#employmentForm').show();
                    } else {
                        $('#employmentForm').hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Not Eligible',
                            text: 'Your experience does not match the requirements for this post.'
                        });
                    }
                } else {
                    $('#employmentForm').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Not Eligible',
                        text: 'No matching criteria found for the selected post and qualification.'
                    });
                }
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let employerCount = 4; // Start from 4 because you have pre-defined 3 sections

        document.getElementById('addEmployerBtn').addEventListener('click', function () {
            // Clone the template
            let template = document.getElementById('employmentSectionTemplate').cloneNode(true);
            template.style.display = 'block';

            // Update the section number
            let employerNumber = employerCount;
            template.querySelector('.employer-number').textContent = employerNumber;

            // Update input names to maintain form data structure
            template.querySelector('.company-name').setAttribute('name', `employment[${employerCount}][company_name]`);
            template.querySelector('.job-title').setAttribute('name', `employment[${employerCount}][job_title]`);
            template.querySelector('.location').setAttribute('name', `employment[${employerCount}][location]`);
            template.querySelector('.start-date').setAttribute('name', `employment[${employerCount}][start_date]`);
            template.querySelector('.end-date').setAttribute('name', `employment[${employerCount}][end_date]`);
            template.querySelector('.total-experience').setAttribute('name', `employment[${employerCount}][total_experience]`);
            template.querySelector('.experience-certificate').setAttribute('name', `employment[${employerCount}][file]`);

            // Append the cloned section to the form
            document.getElementById('employmentSectionsContainer').appendChild(template);

            // Increment the employer count for the next section
            employerCount++;
        });

        // Delegate event for dynamically added remove buttons
        document.getElementById('employmentSectionsContainer').addEventListener('click', function (event) {
            if (event.target && event.target.classList.contains('removeSectionBtn')) {
                event.target.closest('.row').remove(); // Remove the closest .row (section) element
            }
        });
    });
</script>

@include('includes.footer')
