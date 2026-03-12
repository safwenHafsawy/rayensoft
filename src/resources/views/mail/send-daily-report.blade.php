<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Work Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #1f2937;
        }

        .container {
            max-width: 650px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .header {
            text-align: center;
            padding: 20px 20px 10px 20px;
        }

        .header img {
            max-height: 60px;
            display: block;
            margin: 0 auto;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #2563EB;
            margin: 15px 0 0 0;
        }

        .content {
            padding: 30px 25px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .highlight {
            font-weight: 600;
            color: #2563EB;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 15px;
        }

        th,
        td {
            border: 1px solid #DBEAFE;
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background: linear-gradient(90deg, #2563EB, #3B82F6);
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #EFF6FF;
        }

        tr:hover {
            background-color: #DBEAFE;
        }

        .footer {
            font-size: 13px;
            color: #9ca3af;
            text-align: center;
            padding: 20px 25px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                margin: 20px;
            }

            .header h1 {
                font-size: 20px;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://rayensoftsolution.com/assets/fullLogo.png" alt="Rayen Soft Logo">
            <h1>Daily Work Report</h1>
        </div>

        <div class="content">
            <p>Hello Team,</p>

            <p>Please find below the daily work reports for <span class="highlight">{{ $date }}</span>.</p>

            <p>Keep up the great work! If you have any questions or updates, feel free to bring them in the next weekly
                meeting.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Rayen Soft. All rights reserved.
        </div>
    </div>
</body>

</html>
