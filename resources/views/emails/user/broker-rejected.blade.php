@component('mail::message')
# Hello {{ $user->name }},

We regret to inform you that your registration as a broker on **Knote** has not been rejected at this time. Please see the reason for rejection below:

**Name:** {{ $user->name }}  
**Phone:** {{ display_aus_phone($user->phone) }}  
**Email:** {{ $user->email }}  
**Rejection Reason:** {{ $user->rejected_reason }}  

If you have any questions, please contact the Knote administration team for further clarification or assistance.

Thank you for your interest.

Best regards, 
{{ config('app.name') }}
@endcomponent