<!DOCTYPE html>
<html>
<head>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        .email-header {
            text-align: center;
        }
        .email-logo {
            width: 150px;
            margin-bottom: 20px;
        }
        .email-body {
            font-size: 16px;
            color: #333;
        }
        .email-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-content">
        <div class="email-header">
            <img src="https://www.pesrp.edu.pk/wp-content/uploads/2024/05/PMIU-Logo-Colored-ai.png" class="email-logo" alt="Site Logo">
        </div>
        <div class="email-body">
            <p>Dear {{ $profile->first_name }},</p>
            <p>You have successfully applied for the post of <strong>{{ $profile->post->title }}</strong>.</p>
            <p>To review your application details, please visit the following link:</p>
            <a href="{{ url('applicant-detail/' . encrypt($profile->applicant_id)) }}">
                View Your Application
            </a>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} PMIU Data Center. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
