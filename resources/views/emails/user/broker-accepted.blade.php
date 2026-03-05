@component('mail::message')
# Hello {{ $user->name }},

We’re excited to inform you that a new registration has been successfully completed, and the broker account on Knote has been activated. Below are the details for your review:

**Name:** {{ $user->name }}  
**Phone:** {{ display_aus_phone($user->phone) }}  
**Email:** {{ $user->email }}  

You can now log in using your mobile number.

@component('mail::button', ['url' => route('login.broker')])
Login to Knote
@endcomponent

Thank you for joining us!

Best regards, 
{{ config('app.name') }}
@endcomponent