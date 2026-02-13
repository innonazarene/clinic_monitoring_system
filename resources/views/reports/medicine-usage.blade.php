<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Medicine Usage Report</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a2e; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #1b2a4a; padding-bottom: 10px; }
        .header h1 { color: #1b2a4a; margin: 0; font-size: 18px; }
        .header h2 { color: #d4a017; margin: 5px 0; font-size: 14px; }
        .meta { margin-bottom: 15px; font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #1b2a4a; color: white; padding: 8px; text-align: left; font-size: 10px; }
        td { padding: 6px 8px; border-bottom: 1px solid #ddd; font-size: 10px; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .section-title { color: #1b2a4a; font-size: 14px; margin-top: 20px; border-bottom: 2px solid #d4a017; padding-bottom: 5px; }
        .summary-box { background: #f0f4f8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <table style="border: none; margin-bottom: 0;">
            <tr>
                <td style="border: none; width: 80px; text-align: left; padding: 0;">
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/logo.jpg'))) }}" style="width: 70px;">
                </td>
                <td style="border: none; text-align: center; padding: 0;">
                    <h1 style="margin-left: -70px;">Merchant Marine Academy of Caraga, Inc.</h1>
                    <h2 style="margin-left: -70px;">Clinic Monitoring System - Medicine Usage Report</h2>
                </td>
            </tr>
        </table>
    </div>
    <div class="meta">
        <strong>Period:</strong> {{ $dateFrom }} to {{ $dateTo }}
        | <strong>Generated:</strong> {{ now()->format('M d, Y h:i A') }}
    </div>

    <h3 class="section-title">Medicine Summary (Total Dispensed)</h3>
    <div class="summary-box">
        <table>
            <thead><tr><th>Medicine</th><th>Total Quantity Dispensed</th></tr></thead>
            <tbody>
            @foreach($topMedicines as $item)
                <tr><td>{{ $item->medicine?->name }}</td><td>{{ $item->total }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <h3 class="section-title">Dispensing Log ({{ $logs->count() }} records)</h3>
    <table>
        <thead>
            <tr>
                <th>#</th><th>Date</th><th>Medicine</th><th>Qty</th><th>Patient</th><th>Type</th><th>Dispensed By</th>
            </tr>
        </thead>
        <tbody>
        @foreach($logs as $i => $log)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $log->dispensed_at->format('M d, Y') }}</td>
                <td>{{ $log->medicine?->name }}</td>
                <td>{{ $log->quantity }}</td>
                <td>{{ $log->patient_name }}</td>
                <td>{{ $log->patient_type_label }}</td>
                <td>{{ $log->dispenser?->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="footer">
        Clinic Monitoring System &copy; {{ date('Y') }} - Merchant Marine Academy of Caraga, Inc.
    </div>
</body>
</html>
