<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Inquiry Received</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef2f6;
        }
        .email-header {
            background-color: #0783df;
            padding: 25px 40px;
            color: #ffffff;
        }
        .email-header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }
        .email-body {
            padding: 35px 40px;
        }
        .email-body h2 {
            font-size: 18px;
            font-weight: 700;
            color: #0783df;
            margin-top: 0;
            margin-bottom: 24px;
            border-bottom: 2px solid #f0f4f8;
            padding-bottom: 10px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 10px 0;
            vertical-align: top;
            font-size: 14.5px;
            line-height: 1.5;
        }
        .info-table .label {
            font-weight: 700;
            color: #0783df;
            width: 120px;
        }
        .info-table .value {
            color: #333333;
        }
        .email-footer {
            background-color: #fcfdfe;
            padding: 20px 40px;
            border-top: 1px solid #eef2f6;
            text-align: center;
        }
        .email-footer a {
            color: #8fa0b3;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        .email-footer a:hover {
            color: #0783df;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header" style="text-align: center;">
            <img src="{{ env('AWS_URL') }}/assets/images/logo.png" alt="{{ $siteName }}" style="max-height: 60px; max-width: 100%; background-color: #ffffff; padding: 10px; border-radius: 8px; display: inline-block; margin-bottom: 10px;">
            <h1>{{ $siteName }}</h1>
        </div>
        <div class="email-body">
            <h2>New Inquiry Received: {{ $inquiryType }}</h2>
            <table class="info-table">
                <tr>
                    <td class="label">Name:</td>
                    <td class="value">{{ $name }}</td>
                </tr>
                <tr>
                    <td class="label">Email:</td>
                    <td class="value">{{ $email }}</td>
                </tr>
                <tr>
                    <td class="label">Phone:</td>
                    <td class="value">{{ $phone }}</td>
                </tr>
                @if(!empty($jobTitle))
                <tr>
                    <td class="label">Job Title:</td>
                    <td class="value">{{ $jobTitle }}</td>
                </tr>
                @endif
                @if(!empty($companyName))
                <tr>
                    <td class="label">Company:</td>
                    <td class="value">{{ $companyName }}</td>
                </tr>
                @endif
                @if(!empty($country))
                <tr>
                    <td class="label">Country:</td>
                    <td class="value">{{ $country }}</td>
                </tr>
                @endif
                @if(!empty($reportName))
                <tr>
                    <td class="label">Report Name:</td>
                    <td class="value"><strong>{{ $reportName }}</strong></td>
                </tr>
                @endif
                <tr>
                    <td class="label">Message:</td>
                    <td class="value">{!! nl2br(e($messageText)) !!}</td>
                </tr>
            </table>
        </div>
        <div class="email-footer">
            <a href="{{ $siteUrl }}">For details visit our website</a>
        </div>
    </div>
</body>
</html>
