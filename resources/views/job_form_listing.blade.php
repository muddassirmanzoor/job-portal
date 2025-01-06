@include('includes.header')
<section class="hero-section">
    <div class="px-4 py-3  mb-3  text-center">
        <h1 class="display-5 fw-bold text-body-emphasis hero-heading">Jobs Listing</h1>
    </div>
</section>

<section class="after-hero-section">
        <div class="row">
            <div class="col-md-12 col-xs-12 bg p-3 text-center  text-white">
                <div class="card">
                    <div class="card-body">
                        <!-------------------->
                        <div class="table-responsive">
                            <div id="myTable_wrapper" class="dataTables_wrapper">
                                <table class="table table-hover table-striped academicsDetailTable" id="academics_table">
                                    <thead>
                                    <tr role="row">
                                        <th scope="col" rowspan="1" colspan="1" >Post For Apply</th>
                                        <th scope="col" rowspan="1" colspan="1" >Name</th>
                                        <th scope="col" rowspan="1" colspan="1" >CNIC</th>
                                        <th scope="col" rowspan="1" colspan="1" >Email</th>
                                        <th scope="col" rowspan="1" colspan="1" >Mobile Number</th>
                                        <th scope="col" rowspan="1" colspan="1" >Postal Address</th>
{{--                                        <th scope="col" rowspan="1" colspan="1" >Qualification</th>--}}
                                        <th scope="col" rowspan="1" colspan="1" >Date of Apply</th>
{{--                                        <th scope="col" rowspan="1" colspan="1" >Total Experience</th>--}}
                                        <th scope="col" rowspan="1" colspan="1" >Resume</th>
{{--                                        <th scope="col" rowspan="1" colspan="1" >Detail</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($applications as $application)
                                    <tr role="row" class="odd">
                                        <td data-label="Post For Apply">{{$application['post']['title']}}</td>
                                        <td data-label="Name">{{$application['first_name']}} {{$application['last_name']}}</td>
                                        <td data-label="CNIC">{{$application['cnic_no']}}</td>
                                        <td data-label="Email">{{$application['email']}}</td>
                                        <td data-label="Mobile Number">{{$application['phone_number']}}</td>
                                        <td data-label="Postal Address"> {{$application['mailing_address']}}</td>
{{--                                        <td data-label="Qualification">BS Computer Science</td>--}}
                                        <td data-label="Date of Apply">{{date('d-m-Y', strtotime($application['created_at']))}}</td>
{{--                                        <td data-label="Total Experience">5.6</td>--}}

                                        <td data-label="Attachments"><div class="image-wrapper">
                                                <a href="{{ url('storage/'.$application['resume_path']) }}" target="_blank">
{{--                                                <a href="{{ url('first-user-documents/'.$application['applicant_id']) }}" target="_blank">--}}
                                                    @php
                                                        $extension = pathinfo($application['resume_path'], PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                        <img style="max-width: 20px" src="{{ asset('assets/images/image.png') }}" alt="Image">
                                                        @elseif($extension === 'pdf')
                                                        <img style="max-width: 20px" src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Icon">
                                                    @elseif(in_array($extension, ['doc', 'docx']))
                                                        <img style="max-width: 20px" src="{{ asset('assets/images/word.jpg') }}" alt="Word Icon">
                                                    @else
                                                        <img style="max-width: 20px" src="{{ asset('assets/images/Files_App_icon.png') }}" alt="File Icon">
                                                    @endif
                                                </a></div></td>
{{--                                        <td><a href="{{ url('user-detail/'.$application['applicant_id']) }}">Detail</a>--}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $applications->links() }}
                            </div>
                        </div>
                        <!-------------------->
                    </div>
                </div>
            </div>
    </div>
</section>
@include('includes.footer')
