@component('mail::message')
# Dear {{ $loan_application->user->name }},

We noticed that your loan application, referenced with the number **{{ $loan_application->application_number }}**, is incomplete. Please take a moment to complete it at your earliest convenience.!

Application Details:

Applicant Name  : **{{ $loan_application->user->name }}**
<br>
Applicant Email : **{{ $loan_application->user->email }}**
<br>
Applicant Phone : **{{ $loan_application->user->phone }}**
<br>

Your prompt action will help us proceed with your application. If you need assistance, feel free to contact us.

Best regards,<br>
{{ config('app.name') }}
@endcomponent