<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Scrutiny Form</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Georgia, serif;
        }
        a:hover { text-decoration: none !important; }
        .header, .footer, .content {
            width: 100%;
            box-sizing: border-box;
            page-break-after: avoid;
        }
        .header, .footer, .content {
            width: 100%;
            box-sizing: border-box;
        }
        .header {
            border: 1px solid #000;
            padding: 5px 5px;
            text-align: center;
            position: relative;
        }
        .header img {
            width: 75px;
            position: absolute;
            left: 20px;
            top: 10px;
        }
        .header h1, .header p {
            margin: 0;
            padding: 0;
            color: #000;
        }
        .header h1 {
            font-size: 25px;
        }
        .header h3 {
            margin: 0px;
        }
        .header p {
            font-size: 11px;
            letter-spacing: 2px;
        }
        .content {
            padding: 5px;
        }
        .content h2 {
            font-size: 25px;
            margin: 0 0 10px 0;
        }
        .content h3, .content p {
            margin-bottom: 5px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            page-break-inside: avoid;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 4px;
            text-align: left;
            font-size: 13px;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            /*background-color: #698291; */
            color: #000000;
            text-align: center;
            padding: 10px 0;
            font-size: 11px;
            position: absolute;
            bottom: 0;
        }
        /* Prevent extra space after content */
        @media print {
            .content, .header, .footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
<div class="header">
{{--    <p><img src="https://www.pesrp.edu.pk/wp-content/uploads/2024/05/PMIU-Logo-Colored-ai.png" alt="PMIU Logo"></p>--}}
    <h3>PMIU-PESRP</br>
        School Education Department,<br> Government of the Punjab</h3>
{{--    <p>Date: {{ \Carbon\Carbon::today()->format('d-m-Y') }}</p>--}}
</div>
<div class="content">
    <p style="text-align: center; text-decoration: underline">Basic Scrutiny Form</p>
    <h3>Post Applied For: {{$profile['post']['title']}}</h3>
    <h3>Personal Info</h3>
    <table>
        <tr>
            <th>Full Name:</th>
            <td>{{$profile['first_name'].' '.$profile['last_name']}}</td>
            <th>CNIC No:</th>
            <td>{{$profile['cnic_no']}}</td>
        </tr>
        <tr>
            <th>Email:</th>
            <td>{{$profile['email']}}</td>
            <th>Gender:</th>
            <td>{{$profile['gender']}}</td>
        </tr>
        <tr>
            <th>Mobile:</th>
            <td>{{$profile['phone_number']}}</td>
            <th>Address:</th>
            <td>{{$profile['mailing_address']}}</td>
        </tr>
    </table>
    <h3>Basic Scrutiny</h3>
    @php
        $yearsMonths = explode('.', $profile['total_relevant_experience']);
        $years = $yearsMonths[0];
        $months = 0;
        if(isset($yearsMonths[1])){
            $months = $yearsMonths[1];
        }
    @endphp
    <table>
        <tr>
            <th>Total Experience:</th>
            <td>{{$profile['total_experience']}} Years</td>
            <th>Total Relevant/ Verified Experience:</th>
            <td>{{$years}} years and {{$months}} months</td>
        </tr>
        <tr>
            <th>Qualification Criteria Met:</th>
            <td>{{ $profile['qualification_criteria_met'] == 1 ? 'Yes' : 'No' }}</td>
            <th>Qualification Relevance:</th>
            <td>{{ $profile['qualification_relevance'] == 1 ? 'Yes' : 'No' }}</td>
        </tr>
        <tr>
            <th>Higher Qualification:</th>
            <td>{{ $profile['higher_qualification'] == 1 ? 'Yes' : 'No' }}</td>
            <th>Eligibility:</th>
            <td>{{ $profile['is_eligible'] == 1 ? 'Yes' : 'No' }}</td>
        </tr>
    </table>

    <h3>Qualification</h3>
    <table>
        <thead>
        <tr>
            <th>Degree</th>
            <th>Major Subjects</th>
            <th>BISE / University</th>
            <th>From</th>
            <th>To</th>
            <th>Marks/ Total Marks</th>
        </tr>
        </thead>
        <tbody>
        @foreach($profile['latestQualifications'] as $qualification)
            <tr>
                <td>{{ucfirst($qualification['degree_title'])}}</td>
                <td>{{ucfirst($qualification['major_subject'])}}</td>
                <td>{{ucfirst($qualification['institution'])}}</td>
                <td>{{date('d-m-Y', strtotime($qualification['start_date']))}}</td>
                <td>{{date('d-m-Y', strtotime($qualification['end_date']))}}</td>
                <td>{{$qualification['obt_marks']}}/ {{$qualification['total_marks']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3>Work History</h3>
    <table>
        <thead>
        <tr>
            <th>Sr #</th>
            <th>Position Title</th>
            <th>Company Name</th>
            <th>From</th>
            <th>To</th>
            <th>Total Verified Experience</th>
            <th>Experience Relevance</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_experience_years = 0;
            $total_experience_months = 0;
        @endphp
        @foreach($profile['experience'] as $i => $experience)
            @php
            if($experience['verified_start_date']){
                $start = \Carbon\Carbon::parse($experience['verified_start_date']);
            }else{
                $start = \Carbon\Carbon::parse($experience['start_date']);
            }

            if($experience['verified_end_date']){
                $end = \Carbon\Carbon::parse($experience['verified_end_date']);
            }else{
                $end = \Carbon\Carbon::parse($experience['end_date']);
            }

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
            <tr>
                <td>{{$i+1}}</td>
                <td>{{ucfirst($experience['job_title'])}}</td>
                <td>{{ucfirst($experience['company_name'])}}</td>
                <td>{{date('d-m-Y', strtotime($start))}}</td>
                <td>{{date('d-m-Y', strtotime($end))}}</td>

                <td>{{$experience['is_relevant'] == 1 ? $years.' Years and '.$months .' months' : '0'}}</td>
                <td>{{ $experience['is_relevant'] == 1 ? 'Yes' : 'No' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if($profile['remarks'])
    <h3>Remarks</h3>
    <table>
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>By</th>--}}
{{--            <th>Remarks</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
        <tbody>
        <tr>
{{--            <td>Scrutiny</td>--}}
            <td>{{$profile['remarks']}}</td>
        </tr>
{{--        <tr>--}}
{{--            <td>Reviewer</td>--}}
{{--            <td>{{$profile['review_remarks']}}</td>--}}
{{--        </tr>--}}
        </tbody>
    </table>
    @endif
    <h4>Final Status: <span style="color: {{ $profile['is_eligible'] == 1 ? 'green' : 'red' }};">{{ $profile['is_eligible'] == 1 ? 'Eligible' : 'Not Eligible' }}</span></h4>
</div>

<div class="footer">
    <p>© 2024 PMIU-PESRP. All Rights Reserved</p>
</div>
</body>
</html>
