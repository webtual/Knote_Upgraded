@component('mail::message')
# Dear Admin,

@php
$apply_for = config('constants.apply_for');
@endphp

Incomplete the **{{ $apply_for[$loan_application->apply_for] }}** loan application with application reference number **{{ $loan_application->application_number }}** on the Knote portal.

Application Details:

Applicant Name  : **{{ $loan_application->user->name }}**
<br>
Applicant Email : **{{ $loan_application->user->email }}**
<br>
Applicant Phone : **{{ $loan_application->user->phone }}**
<br>

Best regards,<br>
{{ config('app.name') }}
@endcomponent