@component('mail::message')
# Hello Admin,

A new callback inquiry has been received on Knote. Please review the following information:

**Name:** {{ $inquiry->name }}  
**Phone:** {{ display_aus_phone($inquiry->contact) }}  
**Email:** {{ $inquiry->email }}  
@php
    $apply_for = config('constants.apply_for');
@endphp
**Apply For:** {{ $apply_for[$inquiry->apply_for] }}

Please take the necessary actions accordingly.

Thank you!

Best regards,  
{{ config('app.name') }}
@endcomponent