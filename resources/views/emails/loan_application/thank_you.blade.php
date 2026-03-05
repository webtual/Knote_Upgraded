@component('mail::message')
# Dear {{ $loan_application->user->name }},
Your inquiry has been successfully submitted. Your inquiry reference number is **{{ $loan_application->application_number }}**

We hope this message finds you well.

We wanted to take a moment to express my gratitude for your recent inquiry about our loan services. We value your interest in Knote and appreciate the opportunity to assist you in your financial needs.

At Knote, we strive to provide personalized and reliable financial solutions tailored to our clients' specific requirements. We understand that seeking financial assistance is an important decision, and we are committed to guiding you through the process with professionalism and expertise.

Your inquiry is important to us, and our team is currently reviewing the details you provided. We aim to respond promptly and provide you with the information you need to make informed decisions.

If you have any further questions or need additional information in the meantime, please feel free to reach out to our team. We are here to help and support you every step of the way.

Once again, thank you for considering Knote for your financial needs. We look forward to the opportunity to serve you.


Best regards,<br>
{{ config('app.name') }}
@endcomponent
