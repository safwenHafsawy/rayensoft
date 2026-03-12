<!DOCTYPE html>
<html>

<head>
    <title>Follow-Up Lead Reminder</title>
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #f9fafb;
            color: #1a202c;
        }

        .container {
            max-width: 40rem;
            margin: 0 auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header img {
            height: 100px;
            display: block;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            font-size: 0.875rem;
        }

        th,
        td {
            border: 1px solid #2563EB;
            padding: 0.75rem;
            text-align: left;
        }

        th {
            background-color: #2563EB;
            color: #ffffff;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        .button {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            background-color: #2563EB;
            border-radius: 0.375rem;
            text-decoration: none;
        }

        .button:hover {
            background-color: #3B82F6;
        }

        .footer {
            margin-top: 2rem;
            color: #718096;
            font-size: 0.875rem;
            text-align: center;
        }

        .footer a {
            color: #3182ce;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <section class="container">
        <header class="header">
            <img width="150px" height="150px" src="https://rayensoftsolution.com/assets/fullLogo.png"
                alt="Rayen Soft Logo">
        </header>

        <main>
            <h2>Hi {{ $founderName }},</h2>
            <p>This is a reminder about the upcoming follow-up dates for the following leads:</p>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Follow-Up Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reminderLeads as $lead)
                        <tr>
                            <td>{{ $lead['name'] }}</td>
                            <td>{{ $lead['email'] }}</td>
                            <td>{{ $lead['phone'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($lead['follow_up_date'])->toFormattedDateString() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>

        <footer class="footer">
            <p>&copy; {{ date('Y') }} Rayen Soft. All rights reserved.</p>
        </footer>
    </section>
</body>

</html>
