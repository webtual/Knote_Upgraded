@component('mail::message')
# Hello {{ $user->name }},

Thank you for attempting to log in to your account. To ensure the security of your account, please use the following One-Time Password (OTP) to complete your login process:

**Your OTP is: {{ $user->otp }}**

**Important:**
- Do not share this OTP with anyone.
- If you did not request this login, please contact our support team immediately.

Thank you for helping us keep your account secure.

Best regards, 
{{ config('app.name') }}
@endcomponent