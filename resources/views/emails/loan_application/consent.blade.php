@component('mail::message')
# Dear {{ $team_size_data->firstname }} {{ $team_size_data->lastname }},

A new loan application has been received on Knote. Please review the following information:

**Loan Applicant:** {{ $loan_application->user->name }}  
**Loan Application Number:** {{ $loan_application->application_number }}  
**Business Name:** {{ $loan_application->business_name }}  
**Business Phone:** {{ display_aus_phone($loan_application->business_phone) }}  
**Business Email:** {{ $loan_application->business_email }}

Please provide your consent using the following link: <a href="{{ url('s/'.$team_size_data->consent_slug) }}" style="display: inline-block; padding: 10px 20px; font-size: 14px; font-weight: bold; color: #fff; background-color: #1abc9c; text-decoration: none; border-radius: 5px; text-align: center; transition: background-color 0.3s ease;">
    Consent 
</a>

Thank you!

Best regards,  
{{ config('app.name') }}
@endcomponent