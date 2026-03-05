@component('mail::message')
# Dear {{ $loan_application->user->name }},

I hope this email finds you well.

We are pleased to inform you that your application (Application Number:  **{{ $loan_application->application_number }}**) has been fast-tracked. As a result, you will receive a decision on your application in less than 24 hours.

Our team is working quickly to ensure that your request is processed as efficiently as possible. You can expect to hear from us shortly regarding the outcome of your application.

Should we require any additional information, we will contact you directly. If you have any questions or need assistance in the meantime, feel free to reach out.

Thank you for your patience, and we look forward to providing you with an update very soon.

Best regards,<br>
{{ config('app.name') }}
@endcomponent