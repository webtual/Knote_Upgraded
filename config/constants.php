<?php

return [
    'contact_inquiry_receiver_email_cc' => 'hello@knote.com.au',
    'contact_inquiry_receiver_email' => 'info@knote.com.au',
    'google_map_api_key' => 'AIzaSyCkvUOwgo5TTlgLKwwwChz8L5QAAbt8_C0',

    'abn_acn_guid' => 'b4ed96a5-fc3a-4eb4-9537-f1084ec14631',
    'people_title' => array(1 => 'Mr.', 'Mrs.', 'Ms.', 'Doctor', 'Other'),
    'marital_status' => array(1 => 'Married', 'Single', 'Divorced', 'Widowed', 'Seperated'),
    'residential_status' => array(1 => 'Rent', 'Own', 'Leased', 'Government Housing', 'Living with Parents', 'Other'),

    'social_link' => [
        'facebook' => '',
        'twitter' => '',
        'instagram' => '',
        'google' => '',
        'linkedin' => ''
    ],

    'gender' => [
        'M' => 'Male',
        'F' => 'Female',
        'U' => 'Unknown/Unspecified/Other',
    ],

    'finance_periods' => array(1 => 'Monthly', 'Annual'),
    'liabilities_select_options' => array(1 => 'Limit', 'Repayment/Month'),

    'document_types' => array(1 => 'Proof of Identity', 'Business Financials', 'Contract of Sale of any other property documents', 'Other Docs'),

    'approval_status' => array(0 => 'Pending', 'Approved', 'Reject'),
    'purpose_of_visits' => array(1 => 'I want to find resources', 'Other'),
    'field_types' => array(1 => 'selection', 'radio', 'input'),

    'wp_url' => 'https://www.knote.com.au/',
    'wp_privacy_policy' => 'https://www.knote.com.au/privacy-policy/',

    'property_loan_types' => array(1 => 'Purchase', 'Refinance'),
    'type_of_property' => array(1 => 'Commercial', 'Residential', 'Others'),
    'type_of_crypto' => array(1 => 'Bitcoin', 'Ethereum'),

    //'apply_for' => array(1 => 'Business cash flow funding', 'Secured property backed funding', 'KF Secured Funding (Property/Cryptocurrency)'),
    //'apply_for' => array(1 => 'KF Business Cash Flow Funding', 'KF Property Backed Funding', 'KF Crypto Backed Funding'),
    'apply_for' => array(1 => 'KF Business Cash Flow Funding', 'KF Business/Property Backed Funding', 'KF Crypto Backed Funding'),

    'sms_sent_flag' => 0,
    'sms_url' => 'https://api.smsbroadcast.com.au/api-adv.php',

    //'sms_username' => 'credithub',
    //'sms_password' => 'Credithub@2019',
    //'sms_source' => 'Knote',

    'equifax_mode' => '0', //0=Dev, 1=Production
    'equifax_company_enquiry_test' => 'https://ctaau.vedaxml.com/cta/sys2/company-enquiry-v3-2',
    'equifax_company_trading_history_enquiry_test' => 'https://ctaau.apiconnect.equifax.com.au/cta/sys2/company-trading-history-v3-2',
    'equifax_company_user_score_seeker_enquiry_test' => 'https://ctaau.apiconnect.equifax.com.au/cta/sys2/soap11/score-seeker-v1-0',
    'equifax_previous_enquiry_test' => 'https://ctaau.apiconnect.equifax.com.au/cta/sys2/previous-enquiry-v1',

    'equifax_company_enquiry_live' => 'https://ctaau.vedaxml.com/cta/sys2/company-enquiry-v3-2',
    'equifax_company_trading_history_enquiry_live' => 'https://ctaau.apiconnect.equifax.com.au/cta/sys2/company-trading-history-v3-2',
    'equifax_company_user_score_seeker_enquiry_live' => 'https://ctaau.apiconnect.equifax.com.au/cta/sys2/soap11/score-seeker-v1-0',
    'equifax_previous_enquiry_live' => 'https://ctaau.apiconnect.equifax.com.au/cta/sys2/previous-enquiry-v1',

    //LIVE
    //'equifax_company_enquiry_live' => 'https://apiconnect.equifax.com.au/sys2/company-enquiry-v3-2',
    //'equifax_company_trading_history_enquiry_live' => 'https://apiconnect.equifax.com.au/sys2/company-trading-history-v3-2',
    //'equifax_company_user_score_seeker_enquiry_live' => 'https://apiconnect.equifax.com.au/sys2/soap11/score-seeker-v1-0',
    //'equifax_previous_enquiry_live' => 'https://apiconnect.equifax.com.au/sys2/previous-enquiry-v1',

    'equifax_username' => 'kltH7ChOja',
    'equifax_password' => 'bi$LS4C3LB',

    'sms_username' => 'knote',
    'sms_password' => '108Secure#',
    'sms_source' => 'KNOTE',

    'sms_otp_text' => 'Your OTP is {OTP}. Please do not share your OTP with anyone. Regards, Knote.',
    'sms_consent_otp_text' => 'Your consent OTP is {OTP}. Please do not share your OTP with anyone. Regards, Knote.',
    'admin_sms_lead_receivers' => '0412175700,0433000099', // Production
    //'admin_sms_lead_receivers' => '0485825033,0485825033', // Dev

    'sms_client_callback_inquiry' => 'Your {APPLICATION_TYPE} inquiry has been successfully submitted to our Knote Portal.',
    'sms_admin_callback_inquiry' => 'A new {APPLICATION_TYPE} callback inquiry has been generated on the Knote portal. Kindly contact the client at {CLIENT_PHONE_NUMBER}',

    'sms_admin_loan_application_inquiry' => 'A new {APPLICATION_TYPE} application with application reference number {APPLICATION_NUMBER} has been generated on the Knote portal. Please review it.',
    'sms_client_loan_application_inquiry' => 'Thank you for your submission. We have received your {APPLICATION_TYPE} application with application reference number {APPLICATION_NUMBER} on the Knote portal.',

    'sms_client_loan_application_fast_track' => 'Congratulations! Your {APPLICATION_TYPE} application with application reference number {APPLICATION_NUMBER} has been Fast Track on the Knote portal.',
    'sms_admin_loan_application_fast_track' => 'Fast Track the {APPLICATION_TYPE} loan application with application reference number {APPLICATION_NUMBER} on the Knote portal.',

    //'sms_client_loan_application_full_assessment' => 'Congratulations! Your {APPLICATION_TYPE} application with application reference number {APPLICATION_NUMBER} has been Full Assessment on the Knote portal.',
    'sms_client_loan_application_full_assessment' => 'Your {APPLICATION_TYPE} application (reference number {APPLICATION_NUMBER}) is currently undergoing a Full Assessment on the Knote portal. This process may take up to 72 hours, and we will keep you updated along the way!',
    'sms_admin_loan_application_full_assessment' => 'Full Assessment the {APPLICATION_TYPE} loan application with application reference number {APPLICATION_NUMBER} on the Knote portal.',

    'sms_client_loan_application_settled' => 'Congratulations! Your {APPLICATION_TYPE} application with application reference number {APPLICATION_NUMBER} has been settled on the Knote portal.',
    'sms_admin_loan_application_settled' => 'Settled the {APPLICATION_TYPE} loan application with application reference number {APPLICATION_NUMBER} on the Knote portal.',

    'sms_client_loan_application_approved' => 'Congratulations! Your {APPLICATION_TYPE} application with application reference number {APPLICATION_NUMBER} has been approved on the Knote portal.',
    'sms_admin_loan_application_approved' => 'Approved the {APPLICATION_TYPE} loan application with application reference number {APPLICATION_NUMBER} on the Knote portal.',

    'sms_client_loan_application_declined' => 'Dear {CLIENT_NAME}, your {APPLICATION_TYPE} loan application with reference number {APPLICATION_NUMBER} has been declined. For more details, please contact us at 1300 056 683. Thank you.',
    'sms_admin_loan_application_declined' => 'Declined the {APPLICATION_TYPE} loan application with application reference number {APPLICATION_NUMBER} on the Knote portal.',

    'sms_director_consent_loan_application_inquiry' => 'A new {APPLICATION_TYPE} application with reference {APPLICATION_NUMBER} has been created on the Knote portal. Please review and provide your consent here: {LINK}.'
];


