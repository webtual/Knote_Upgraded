@component('mail::message')
# Dear {{ $loan_application->user->name }},

We regret to inform you that your loan application with the reference number {{ $loan_application->application_number }} has been declined.

If you have any questions or require further details regarding this decision, please contact us at 1300 056 683.

Thank you for considering us for your financial needs.

Best regards,<br>
{{ config('app.name') }}
@endcomponent