@component('mail::message')
# Hello {{ $user->name }},

We have received your broker registration request on **Knote**. Our admin team is currently reviewing your details.

Once the verification process is complete, you'll receive a confirmation email regarding the activation of your broker account.

**Submitted Details:**

**Name:** {{ $user->name }}  
**Phone:** {{ display_aus_phone($user->phone) }}  
**Email:** {{ $user->email }}

We appreciate your patience.

Best regards, 
{{ config('app.name') }}
@endcomponent