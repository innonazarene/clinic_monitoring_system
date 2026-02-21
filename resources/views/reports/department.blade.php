<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Department Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1a1a2e;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #1b2a4a;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #1b2a4a;
            margin: 0;
            font-size: 18px;
        }

        .header h2 {
            color: #d4a017;
            margin: 5px 0;
            font-size: 14px;
        }

        .meta {
            margin-bottom: 15px;
            font-size: 10px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #1b2a4a;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }

        td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .section-title {
            color: #1b2a4a;
            font-size: 14px;
            margin-top: 20px;
            border-bottom: 2px solid #d4a017;
            padding-bottom: 5px;
        }

        .stat-grid {
            display: flex;
            gap: 20px;
            margin: 10px 0;
        }

        .stat-box {
            background: #f0f4f8;
            padding: 10px;
            border-radius: 5px;
            flex: 1;
            text-align: center;
        }

        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #1b2a4a;
        }

        .stat-label {
            font-size: 9px;
            color: #666;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <table style="border: none; margin-bottom: 0;">
            <tr>
                <td style="border: none; width: 80px; text-align: left; padding: 0;">
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/logo.jpg'))) }}"
                        style="width: 70px;">
                </td>
                <td style="border: none; text-align: center; padding: 0;">
                    <h1 style="margin-left: -70px;">Merchant Marine Academy of Caraga, Inc.</h1>
                    <h2 style="margin-left: -70px;">Department Report - {{ $department->full_name }}
                        ({{ $department->code }})</h2>
                </td>
            </tr>
        </table>
    </div>
    <div class="meta">
        <strong>Generated:</strong> {{ now()->format('M d, Y h:i A') }}
    </div>

    <h3 class="section-title">BMI Statistics</h3>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bmiStats as $cat => $count)
                <tr>
                    <td>{{ $cat }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="section-title">Students ({{ $students->count() }})</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Sex</th>
                <th>BMI</th>
                <th>Category</th>
                <th>Allergies</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->student_id_number }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->sex }}</td>
                    <td>{{ $s->medicalRecord?->bmi ?? 'N/A' }}</td>
                    <td>{{ $s->medicalRecord?->bmi_category ?? 'N/A' }}</td>
                    <td>{{ $s->medicalRecord?->hasAllergies() ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="section-title">Personnel ({{ $personnel->count() }})</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Position</th>
                <th>BMI</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personnel as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->employee_id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->position }}</td>
                    <td>{{ $p->medicalRecord?->bmi ?? 'N/A' }}</td>
                    <td>{{ $p->medicalRecord?->bmi_category ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Clinic Health Monitoring System &copy; {{ date('Y') }} - Merchant Marine Academy of Caraga, Inc.
    </div>
</body>

</html>