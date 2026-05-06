<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9fafb; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 20px; margin-bottom: 20px; }
        .status { display: inline-block; padding: 8px 16px; border-radius: 20px; font-weight: bold; font-size: 14px; text-transform: uppercase; }
        .status.approved { background: #d1fae5; color: #047857; }
        .status.cancelled { background: #fee2e2; color: #b91c1c; }
        .status.completed { background: #e0f2fe; color: #0369a1; }
        .status.pending { background: #fef3c7; color: #b45309; }
        .details { background: #f8fafc; padding: 20px; border-radius: 8px; margin-top: 20px; border: 1px solid #e2e8f0; }
        .btn { display: inline-block; background: #003B73; color: white; text-decoration: none; padding: 12px 24px; border-radius: 8px; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #003B73; margin: 0;">KAAFI Hospitals</h1>
        </div>
        
        <p>Hello <strong>{{ $appointment->user->name }}</strong>,</p>
        
        <p>Your appointment status has been updated to:</p>
        <div style="text-align: center;">
            <span class="status {{ $appointment->status }}">{{ $appointment->status }}</span>
        </div>

        <div class="details">
            <p style="margin-top: 0;"><strong>Specialist:</strong> {{ $appointment->doctor->name ?? 'General Consultation' }}</p>
            <p><strong>Department:</strong> {{ $appointment->department->name ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}</p>
            <p style="margin-bottom: 0;"><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
        </div>

        <p style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/portal') }}" class="btn">View in Patient Portal</a>
        </p>

        <p style="color: #6b7280; font-size: 12px; margin-top: 40px; text-align: center;">
            If you need to reschedule or have questions, please contact our reception desk.<br>
            &copy; {{ date('Y') }} KAAFI Hospitals. All rights reserved.
        </p>
    </div>
</body>
</html>
