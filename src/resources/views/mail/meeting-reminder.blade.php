<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta charset="UTF-8">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <title>Follow-Up Lead Reminder</title>

    <!-- Web-safe fallback font -->
    <style>
        body,
        table,
        td {
            font-family: 'Space Grotesk', Arial, sans-serif;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                padding: 1rem !important;
            }

            table {
                font-size: 0.8rem !important;
            }
        }
    </style>
</head>

<body style="margin:0; padding:0; background-color:#f4f5f7;">

    <!-- Outer container -->
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
        style="background:#f4f5f7; padding:40px 0;">
        <tr>
            <td align="center">

                <!-- Inner card -->
                <table class="container" role="presentation" width="600" cellspacing="0" cellpadding="0"
                    border="0"
                    style="background:#ffffff; border-radius:16px; padding:32px; box-shadow:0 6px 30px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding-bottom:24px;">
                            <img src="https://rayensoftsolution.com/assets/fullLogo.png" alt="Rayen Soft" width="120"
                                style="display:block;">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td
                            style="font-size:24px; font-weight:700; color:#1a1a1a; padding-bottom:8px; text-align:center;">
                            Heads up! 👋
                        </td>
                    </tr>

                    <!-- Subtitle -->
                    <tr>
                        <td style="font-size:16px; color:#4a4a4a; text-align:center; padding-bottom:24px;">
                            This is a friendly reminder about your upcoming meetings scheduled for
                            <strong>Today</strong>.
                        </td>
                    </tr>

                    <!-- Table -->
                    <tr>
                        <td>
                            <table width="100%" role="presentation" cellpadding="0" cellspacing="0" border="0"
                                style="border-collapse:collapse; border-radius:10px; overflow:hidden;">
                                <thead>
                                    <tr>
                                        <th
                                            style="background:#2563EB; padding:12px; text-align:left; color:#ffffff; font-size:14px;">
                                            Title</th>
                                        <th
                                            style="background:#2563EB; padding:12px; text-align:left; color:#ffffff; font-size:14px;">
                                            Date</th>
                                        <th
                                            style="background:#2563EB; padding:12px; text-align:left; color:#ffffff; font-size:14px;">
                                            Time</th>
                                        <th
                                            style="background:#2563EB; padding:12px; text-align:left; color:#ffffff; font-size:14px;">
                                            Lead</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($meetingsList as $meeting)
                                        <tr style="background:#faf8fc;">
                                            <td style="padding:12px; border-bottom:1px solid #e5e3e9; color:#333333;">
                                                {{ $meeting['title'] }}
                                            </td>
                                            <td style="padding:12px; border-bottom:1px solid #e5e3e9; color:#333333;">
                                                {{ $meeting['date'] }}
                                            </td>
                                            <td style="padding:12px; border-bottom:1px solid #e5e3e9; color:#333333;">
                                                {{ $meeting['time'] }}
                                            </td>
                                            <td style="padding:12px; border-bottom:1px solid #e5e3e9; color:#333333;">
                                                {{ $meeting['lead_name'] }}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="text-align:center; padding-top:32px; font-size:13px; color:#888;">
                            © {{ date('Y') }} <strong>Rayen Soft</strong>. All rights reserved.<br>
                            <span style="font-size:12px; color:#aaa;">Premium Email Delivery System</span>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
