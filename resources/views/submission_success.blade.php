<!-- resources/views/submission_success.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted</title>
    <style>
        /* Full-screen overlay styles */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .overlay h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .overlay p {
            font-size: 1.2em;
        }
    </style>
</head>
<body>
<div class="overlay">
    <h1>Application Submitted Successfully!</h1>
    <p>Thank you for submitting your application.</p>
</div>
</body>
</html>
