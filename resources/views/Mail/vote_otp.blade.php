<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            max-width: 500px;
            margin: 40px auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #0d6efd;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 22px;
            font-weight: bold;
        }

        .content {
            padding: 30px;
            text-align: center;
        }

        .otp-box {
            background-color: #e9ecef;
            display: inline-block;
            padding: 15px 25px;
            font-size: 28px;
            letter-spacing: 5px;
            font-weight: bold;
            border-radius: 6px;
            color: #0d6efd;
            margin: 20px 0;
        }

        .footer {
            background-color: #f1f3f5;
            padding: 15px;
            font-size: 13px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            Vote Verification
        </div>
        <div class="content">
            <p>Hello ,</p>
            <p>Use the following One-Time Password (OTP) to complete your verification process.</p>

            <div class="otp-box">
                {{ $vote }}
            </div>

            <p>This OTP is valid for <strong>15 minutes</strong>.</p>
            <p>If you did not request this, please ignore this email.</p>
        </div>
        <div class="footer">
            &copy;  All rights reserved.
        </div>
    </div>

</body>

</html>
