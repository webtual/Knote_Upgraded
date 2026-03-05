@component('mail::message')
# Hello Admin,

A new broker registration request has been submitted on **Knote**. Please review the details below and take the necessary action to approve or reject the request.

**Broker Details:**

**Name:** {{ $user->name }}  
**Phone:** {{ display_aus_phone($user->phone) }}  
**Email:** {{ $user->email }}

You can manage broker registrations from the admin panel.

Best regards, 
{{ config('app.name') }}
@endcomponent