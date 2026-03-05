@component('mail::message')
# Dear {{ $loan_application->user->name }},

We hope you're doing well.

We would like to inform you that your application (Application Number: **{{ $loan_application->application_number }}**) is currently undergoing a full assessment. Our team is carefully reviewing all aspects of your application to ensure a thorough and accurate evaluation.

We expect to provide you with a decision within **the next 72 hours**. Rest assured, we are working diligently to ensure the process is as quick and efficient as possible.

If we need any additional information from you, we will reach out promptly. 

Should you have any questions or require assistance in the meantime, please don't hesitate to contact me.

Thank you for your patience and understanding and we look forward to providing you with an update soon.

Best regards,<br>
{{ config('app.name') }}
@endcomponent