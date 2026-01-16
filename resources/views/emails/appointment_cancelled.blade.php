<h2>Notification: Your appointment has been cancelled.</h2>
<p>Hi {{ $appointment->client->name }},</p>
<p>Unfortunately, the appointment is at {{ $appointment->appointment_time }} day {{ $appointment->appointment_date }}
    has been cancelled.
</p>
<p>Please contact us if you have any questions.</p>
