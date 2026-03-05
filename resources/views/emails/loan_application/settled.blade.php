@component('mail::message')
# Dear {{ $loan_application->user->name }},

We are pleased to inform you that your loan application with the reference number **{{ $loan_application->application_number }}** has been settled!

Congratulations on your settled!

Best regards,<br>
{{ config('app.name') }}
@endcomponent