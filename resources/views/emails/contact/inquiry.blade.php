@component('mail::message')
# Hello Admin,
You have generate new contact inquiry.

Name : {{ $contact->name }} <br>
Phone : {{ $contact->contact }} <br>
Email : {{ $contact->email }} <br>
Message : {{ $contact->message }} <br>

{{-- 
@component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Best regards,<br>
{{ config('app.name') }}
@endcomponent
