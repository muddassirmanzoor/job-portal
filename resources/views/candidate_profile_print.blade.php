
<!-- saved from url=(0063)file:///C:/Users/BM/OneDrive/Desktop/student-profile-print.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>
        Basic Scrutiny Form
    </title>
    <style type="text/css">
        a:hover { text-decoration: none !important; }
        .header h1 {color: #000000 !important; font: normal 33px Georgia, serif; margin: 0; padding: 0; line-height: 33px;}
        .header p {color: #000000; font: normal 11px Georgia, serif; margin: 0; padding: 0; line-height: 11px; letter-spacing: 2px}
        .sidebar ul  { color: #000000; margin: 0 0 0 10px; padding: 0 0 0 5px; font-size: 12px;font-family: Georgia, serif }
        .sidebar ul li {padding: 0 0 5px; margin: 0;}
        .sidebar h4 {color: #000000 !important;font-size: 13px;line-height: 16px;font-family: Georgia, serif;margin: 0 0 10px 0;padding: 0;font-weight: 400;}
        .sidebar p {line-height: 16px; font-family: Georgia, serif;}
        .sidebar p a{color: #d18648; text-decoration: none;}
        .content h2 {color:#000000 !important; font-weight: normal; margin: 0; padding: 0;  line-height: 30px; font-size: 30px;font-family: Georgia, serif; }
        .content p {color:#767676; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 12px;font-family: Georgia, serif;}
        .content a {color: #d18648; text-decoration: none;}
        .footer p {padding: 0; font-size: 11px; color:#000000; margin: 0; font-family: Georgia, serif;}
        .footer a {color: #f7a766; text-decoration: none;}
    </style>
</head>
<body style="margin: 0; padding: 0;">
<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
    <tbody><tr>
        <td align="center" style="margin: 0; padding: 0;padding: 35px 0">
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="750" style="font-family: Georgia, serif;border: 1px solid;" class="header">
                <tbody><tr>
                    <td height="115" align="center">
                        <p><img src="https://www.pesrp.edu.pk/wp-content/uploads/2024/05/PMIU-Logo-Colored-ai.png" style="width: 75px;padding: 15px;"></p>
                    </td>
                    <td height="115" align="center">
                        <h1 style="color: #000000; font: normal 25px Georgia, serif; margin: 0; padding: 0; line-height: 25px;">School Education Department,<br> Government of the Punjab</h1>
                        <p style="color: #000000; font: normal 11px Georgia, serif; margin: 0; padding: 0; line-height: 11px; letter-spacing: 2px">Basic Scrutiny Form</p>
                    </td>
                    <td height="115" align="center">
                        <p style="color: #000000; font: normal 11px Georgia, serif; margin: 0; padding: 0; line-height: 11px; letter-spacing: 2px">Date :
                            {{ \Carbon\Carbon::today()->format('d-m-Y') }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 1px; height: 5px; line-height: 1px;" height="5"><br></td>
                </tr>
                </tbody></table><!-- header-->
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="750" style="font-family: Georgia, serif; background: #fff; border: 1px solid;" bgcolor="#ffffff">
                <tbody><tr>
                    <td width="14" style="font-size: 0px;" bgcolor="#ffffff">&nbsp;</td>
                    <td width="186" valign="top" align="left" bgcolor="#ffffff" style="font-family: Georgia, serif; background: #fff;" class="sidebar">
                        <table cellpadding="0" cellspacing="0" border="0" style="color: #717171; font: normal 11px Georgia, serif; margin: 0; padding: 0; background: #fff;" width="186" bgcolor="#ffffff">
                            <tbody>
                            <tr>
                                <td style="padding: 25px 0 5px;" valign="top" align="left">
                                    <h4><b> Full Name:</b><br> {{$profile['first_name'].' '.$profile['last_name']}}</h4>
                                    <h4><b> CNIC No:</b> <br> {{$profile['cnic_no']}}</h4>
                                    <h4><b> Email:</b> <br> {{$profile['email']}}</h4>
                                    <h4><b> Gender:</b> {{$profile['gender']}}</h4>
                                    <h4><b> Mobile:</b><br>  {{$profile['phone_number']}}</h4>
                                    <h4><b> Address:</b><br>   {{$profile['mailing_address']}}</h4>
                                    <h4><b> Permanent Address:</b><br> {{$profile['permanent_address']}}</h4>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="24" bgcolor="#ffffff" style="font-size: 0px; font-family: Georgia, serif; background: #fff;">&nbsp;</td>
                    <td width="510" valign="top" align="left" bgcolor="#ffffff" style="font-family: Georgia, serif; background: #fff;" class="content">
                        <table cellpadding="0" cellspacing="0" border="0" style="color: #717171; font: normal 11px Georgia, serif; margin: 0; padding: 0;" width="510">
                            <tbody><tr>
                                <td style="padding: 15px 0 0;" align="left">
                                    <h2 style="color:#000000; font-weight: normal; margin: 0; padding: 0;  line-height: 25px; font-size: 25px;font-family: Georgia, serif; ">Basic Scrutiny</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 15px 0 0px;" valign="top">
                                    <!------------------->
                                    <table class="session-result-table" style="width: 100%;" border="1">
                                        <tbody>
                                        <tr style="color: #000000;font-size: 12px;font-family: Georgia, serif;list-style: none;padding: 0px;margin: 0px;">
                                            <th align="left" style="width: 180px;padding: 4px;">Total Experience:</th>
                                            <td>{{$profile['total_experience']}} Years</td>
                                            <th align="left" style="width: 180px;padding: 4px;">Total Relevant Experience:</th>
                                            <td align="left">{{$profile['total_relevant_experience']}} Years</td>
                                        </tr>
                                        <tr style="color: #000000;font-size: 12px;font-family: Georgia, serif;list-style: none;padding: 0px;margin: 0px;" align="left">
                                            <th style="width: 180px;padding: 4px;">Qualification Criteria Met:</th>
                                            <td> {{ $profile['qualification_criteria_met'] == 1 ? 'Yes' : 'No' }}</td>
                                            <th style="width: 180px;padding: 4px;">Qualification Relevance:</th>
                                            <td> {{ $profile['qualification_relevance'] == 1 ? 'Yes' : 'No' }}</td>
                                        </tr>
                                        <tr style="color: #000000;font-size: 12px;font-family: Georgia, serif;list-style: none;padding: 0px;margin: 0px;" align="left">
                                            <th style="width: 180px;padding: 4px;">Higher Qualification: </th>
                                            <td> {{ $profile['higher_qualification'] == 1 ? 'Yes' : 'No' }}</td>
                                            <th style="width: 180px;padding: 4px;">Eligibility:</th>
                                            <td> {{ $profile['is_eligible'] == 1 ? 'Yes' : 'No' }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!------------------->
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 15px 0 0;" align="left">
                                    <h2 style="color:#000000; font-weight: normal; margin: 0; padding: 0;  line-height: 25px; font-size: 25px;font-family: Georgia, serif; ">Qualification</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 15px 0 0px;" valign="top">
                                    <!------------------->
                                    <table style="width: 100%;" border="1">
                                        <tbody>
                                        <tr style="color: #000000;font-size: 12px;font-family: Georgia, serif;list-style: none;padding: 0px;margin: 0px;" align="center">
                                            <th>Degree</th>
                                            <th>Major Subjects</th>
                                            <th>BISE / University</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Marks</th>
                                        </tr>
                                        @foreach($profile['qualification'] as $qualification)
                                            <tr style="color: #000000;font-size: 12px;font-family: Georgia, serif;list-style: none;padding: 0px;margin: 0px;" align="center">
                                            <td>{{$qualification['degree_title']}}</td>
                                            <td>{{$qualification['major_subject']}}</td>
                                            <td>{{$qualification['institution']}}</td>
                                            <td>{{$qualification['start_date']}}	</td>
                                            <td>{{$qualification['end_date']}}</td>
                                            <td>{{$qualification['obt_marks']}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!------------------->
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 15px 0 0;" align="left">
                                    <h2 style="color:#000000; font-weight: normal; margin: 0; padding: 0;  line-height: 25px; font-size: 25px;font-family: Georgia, serif; ">Work History</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 15px 0 0px;" valign="top">
                                    <!------------------->
                                    <table style="width: 100%;" border="1" align="center">
                                        <tbody>
                                        <tr style="color: #000000;font-size: 12px;font-family: Georgia, serif;list-style: none;padding: 0px;margin: 0px;" align="center">
                                            <th>Sr #</th>
                                            <th>Position Title</th>
                                            <th>Company Name</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Total Experience</th>
                                            <th>Experience Relevance</th>
                                        </tr>
                                        @foreach($profile['experience'] as $i => $experience)
                                        <tr style="color: #000000;font-size: 12px;font-family: Georgia, serif;list-style: none;padding: 0px;margin: 0px;" align="center">
                                            <td>{{$i+1}}</td>
                                            <td>{{$experience['job_title']}}</td>
                                            <td>{{$experience['company_name']}}</td>
                                            <td>{{$experience['start_date']}}</td>
                                            <td>{{$experience['end_date']}}</td>
                                            <td>{{$experience['job_title']}}</td>
                                            <td>{{ $profile['is_relevant'] == 1 ? 'Yes' : 'No' }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!------------------->
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 15px 0 0;" align="left">
                                    <h2 style="color:#000000; font-weight: normal; margin: 0; padding: 0;  line-height: 25px; font-size: 25px;font-family: Georgia, serif; ">Remarks</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 15px 0 0px;" valign="top">
                                    <!------------------->
                                    <table style="width: 100%;" border="1" align="left">
                                        <tbody>
                                        <tr style="color: #000000;font-size: 12px;font-family: Georgia, serif;list-style: none;padding: 5px;margin: 0px;" align="left">
                                            <th>By</th>
                                            <th>Remarks</th>
                                        </tr>
                                        <tr style="color: #000000;font-size: 12px;font-family: Georgia, serif;list-style: none;padding: 5px;margin: 0px;" align="left">
                                            <td>Scrutiny </td>
                                            <td>{{$profile['remarks']}}</td>
                                        </tr>
                                        <tr style="color: #000000;font-size: 12px;font-family: Georgia, serif;list-style: none;padding: 5px;margin: 0px;" align="left">
                                            <td>Reviewer </td>
                                            <td>{{$profile['review_remarks']}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!------------------->
                                </td>
                            </tr>
                            </tbody></table>
                    </td>
                    <td width="16" bgcolor="#ffffff" style="font-size: 0px;font-family: Georgia, serif; background: #fff;">&nbsp;</td>
                </tr>
                </tbody></table><!-- body -->
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="750" style="font-family: Georgia, serif; line-height: 10px;" bgcolor="#698291" class="footer">
                <tbody><tr>
                    <td bgcolor="#698291" align="center" style="padding: 15px 0 10px; font-size: 11px; color:#fff; margin: 0; line-height: 1.2;font-family: Georgia, serif;" valign="top">
                        <p style="padding: 0; font-size: 11px; color:#fff; margin: 0; font-family: Georgia, serif;">© 2024 PMIU-PESRP. All Rights Reserved</p>
                    </td>
                </tr>
                </tbody></table><!-- footer-->
        </td>
    </tr>
    </tbody></table>

</body></html>
