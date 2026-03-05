@component('mail::message')
# Hello Admin,

A new loan application has been received on Knote. Please review the following information:

**Loan Applicant:** {{ $loan_application->user->name }}  
**Loan Application Number:** {{ $loan_application->application_number }}  
**Business Name:** {{ $loan_application->business_name }}  
**Business Phone:** {{ display_aus_phone($loan_application->business_phone) }}  
**Business Email:** {{ $loan_application->business_email }}  

Please take the necessary actions accordingly.

Thank you!

Best regards,  
{{ config('app.name') }}
@endcomponent