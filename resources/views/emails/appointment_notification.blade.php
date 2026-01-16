<h2>You have a new appointment request!</h2>
<ul>
    <li><strong>Client:</strong> {{ $appointment->client->name }}</li>
    <li><strong>Appointment date:</strong> {{ $appointment->appointment_date }}</li>
    <li><strong>Appointment time:</strong> {{ $appointment->appointment_time }}</li>
    <li><strong>Note:</strong> {{ $appointment->notes }}</li>
</ul>
<p>Please log in to the system to process your request.</p>
