@component('mail::message')
# Hello {{ $inquiry->name }},

Thank you for submitting your inquiry. Our administrator has received it and will review it shortly. If any further information is required, we will contact you using the details you provided.

We appreciate your interest and will ensure a prompt response to your inquiry.

Thank you!

Best regards,<br>
{{ config('app.name') }}
@endcomponent