@component('mail::message')
# Dear Admin,

@php
$apply_for = config('constants.apply_for');
$status_val_name = $loan_application->current_status ? $loan_application->current_status->status : '';
if(in_array($status_val_name, ['Completed', 'Under Review', 'Assessment'])){
    $text_val = "This application has been remained in **".$status_val_name."** status for over **4 hours** and is now overdue. Please review and take the necessary action promptly.";
}elseif($status_val_name == 'Fast Track'){
    $text_val = "This application has been remained in **Fast Track** status for over **24 hours** and is now overdue. Please review and take the necessary action promptly.";
}elseif($status_val_name == 'Full Assessment'){
    $text_val = "This application has remained in **Full Assessment** status for over **72 hours** and is now overdue. Please review and take the necessary action promptly.";
}
@endphp

The **{{ $apply_for[$loan_application->apply_for] }}** loan application with application reference number **{{ $loan_application->application_number }}** on the Knote portal requires immediate attention.

{{$text_val}}

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