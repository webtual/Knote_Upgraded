@component('mail::message')
# Dear Admin,
@php
$apply_for = config('constants.apply_for');
@endphp

Full Assessment the **{{ $apply_for[$loan_application->apply_for] }}** loan application with application reference number **{{ $loan_application->application_number }}** on the Knote portal.

Best regards,<br>
{{ config('app.name') }}
@endcomponent