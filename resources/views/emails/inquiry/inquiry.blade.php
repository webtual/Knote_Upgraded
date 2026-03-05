@component('mail::message')
# Hello Admin,
You have generate new inquiry.

Name : {{ $inquiry->name }} <br>
Phone : {{ $inquiry->contact }} <br>
Email : {{ $inquiry->email }} <br>
Message : {{ $inquiry->message }} <br>

{{-- 
@component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Best regards,<br>
{{ config('app.name') }}
@endcomponent
