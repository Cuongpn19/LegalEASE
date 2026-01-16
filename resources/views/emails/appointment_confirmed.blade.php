<h2>Hi {{ $appointment->client->name }},</h2>
<p>Your appointment has been confirmed by the lawyer.</p>
<ul>
    <li><strong>Lawyer:</strong> {{ $appointment->lawyer->name }}</li>
    <li><strong>Appointment date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
    </li>
    <li><strong>Appointment time:</strong> {{ $appointment->appointment_time }}</li>
</ul>
<p>Thank you for trusting our services!</p>
