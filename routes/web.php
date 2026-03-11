<?php

Route::get('/', function () {
    return redirect()->to(route('loan-applicant'));
})->name('root');

Auth::routes(['login' => false]);
Route::get('/login', function () {
    return redirect()->to(route('login.internal'));
})->name('login');
//Route::get('application/generate-document', 'ApplicationDocumentController@generate_document_sample')->name('application.document.generateDocument');
//CRON
Route::get('cron/application/incomplete', 'CronController@incomplete_application')->name('cron.application.incomplete');
Route::get('cron/application/due-status', 'CronController@status_due_application')->name('cron.application.due.status');
//SCRIPT
//Route::get('script/customernoupdate', 'ScriptController@customer_no_update')->name('customer.no.update');
//Route::get('script/applicationnoupdate', 'ScriptController@application_no_update')->name('application.no.update');
//Route::get('script/customernoupdateinquiry', 'ScriptController@customer_no_update_inquiry')->name('customer.no.update.inquiry');
Route::get('s/{consent_slug}', 'ApplicationController@consent_redirect')->name('loan.consent.redirect');
Route::get('loan/consent/verify/{enc_id}/{id}', 'ApplicationController@consent_verify')->name('loan.consent.verify');
Route::get('loan/consent/review/{enc_id}/{id}', 'ApplicationController@consent_review')->name('loan.consent.review');
Route::post('loan/consent-sent-otp', 'ApplicationController@consentSentOtp')->name('loan.consent.sent.otp');
Route::post('loan/consent-verify-otp', 'ApplicationController@consentVerifyOtp')->name('loan.consent.verify.otp');
Route::post('loan/consent-save', 'ApplicationController@consentSave')->name('loan.consent.save');
Route::get('login/customer', 'Auth\LoginController@showLoginForm')->name('login.customer');
Route::get('login/internal', 'Auth\LoginController@showLoginForm')->name('login.internal');
Route::get('login/broker', 'Auth\LoginController@showLoginForm')->name('login.broker');
Route::post('login/sent-otp', 'Auth\LoginController@sentOtp')->name('sent.otp');
Route::post('login/verify-otp', 'Auth\LoginController@verifyOtp')->name('verify.otp');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
//Auth::routes(['verify' => true]);
/*Auth*/
Route::get('register/loan-applicant', 'Auth\RegisterController@showRegistrationForm')->name('loan-applicant');
Route::get('register/broker', 'Auth\RegisterController@showRegistrationFormBroker')->name('register.broker');
Route::post('broker/store', 'Auth\RegisterController@broker_store')->name('register.broker.store');
Route::post('validate-step-2', 'Auth\RegisterController@validateStep2')->name('validate.step.2');
Route::post('validate-step-3', 'Auth\RegisterController@validateStep3')->name('validate.step.3');
/*Users Routes*/
Route::group(['middleware' => ['auth', 'is_user']], function () {
    Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');
    /*Create Loan Process*/
    Route::get('loan/create', 'ApplicationController@create')->name('loan.create');
    Route::post('loan/create', 'ApplicationController@storeBusinessInformation')->name('loan.create.store');

    Route::get('loan/create/business-information', 'ApplicationController@create')->name('loan.create.business.information');
    Route::post('loan/create/business-information', 'ApplicationController@storeBusinessInformation')->name('loan.create.store');

    Route::get('loan/create/people', 'ApplicationController@people')->name('loan.create.people');
    Route::post('loan/create/people', 'ApplicationController@storePeople')->name('loan.create.people.store');

    Route::get('loan/create/people/delete/{id}', 'TeamSizeController@destory')->name('loan.create.people.delete');

    Route::get('loan/create/finance', 'ApplicationController@finance')->name('loan.create.finance');
    Route::post('loan/create/finance', 'ApplicationController@storeFinance')->name('loan.create.store.finance');

    Route::get('loan/create/property-security', 'ApplicationController@finance')->name('loan.create.property.security');
    Route::post('loan/create/property-security', 'ApplicationController@storeFinance')->name('loan.create.store.property.security');

    Route::get('loan/create/document', 'ApplicationController@document')->name('loan.create.document');
    Route::post('loan/create/document', 'ApplicationController@documentStore')->name('loan.create.document');

    Route::post('loan/create/document/delete', 'DocumentController@destory')->name('loan.create.document.delete');

    Route::get('loan/create/review', 'ApplicationController@review')->name('loan.create.review');
    Route::post('loan/create/review', 'ApplicationController@reviewStore')->name('loan.create.review.store');

    Route::post('loan/save-exit', 'ApplicationController@save_exit')->name('loan.save.exit');

    /*Edit Loan Application*/
    Route::get('loan/edit/{enc_id}', 'ApplicationController@create')->name('loan.edit.business.information');
    Route::get('loan/edit/people/{enc_id}', 'ApplicationController@people')->name('loan.edit.people');
    Route::get('loan/edit/finance/{enc_id}', 'ApplicationController@finance')->name('loan.edit.finance');
    Route::get('loan/edit/document/{enc_id}', 'ApplicationController@document')->name('loan.edit.document');
    Route::get('loan/edit/review/{enc_id}', 'ApplicationController@review')->name('loan.edit.review');


    /*Search ABN ACN*/
    Route::post('search/abn-acn', 'ApplicationController@getAbnAcn')->name('search.abnacn');

    /*My Profile*/
    //Route::get('my-profile', 'UserController@myProfile')->name('my.profile');
    Route::get('edit-profile', 'UserController@my_profile')->name('user.my.profile');
    Route::post('my-profile-update', 'UserController@user_profile_update')->name('user.my.profile.update');




});

/*Broker Routes*/
Route::group(['prefix' => 'broker', 'middleware' => ['auth', 'is_broker']], function () {
    //dashboard
    Route::get('dashboard', 'Broker\HomeController@dashboard')->name('broker.dashboard');

    Route::get('loan-applications', 'Broker\ApplicationController@index')->name('broker.loan.application');
    Route::get('loan-applications-ajax', 'Broker\ApplicationController@indexAjax')->name('loan.applications.ajax');
    Route::get('current-loan-applications-export', 'Broker\ApplicationController@indexExport')->name('loan.applications.current.export');

    Route::get('declined-loan-applications', 'Broker\ApplicationController@index_declined')->name('broker.declined.application.index');
    Route::get('declined-loan-applications-ajax', 'Broker\ApplicationController@index_declined_ajax')->name('broker.declined.application.ajax');
    Route::get('declined-loan-applications-export', 'Broker\ApplicationController@declined_application_export')->name('broker.declined.application.export');

    Route::get('archived-loan-applications', 'Broker\ApplicationController@index_archived')->name('broker.archived.application.index');
    Route::get('archived-loan-applications-ajax', 'Broker\ApplicationController@index_archived_ajax')->name('broker.archived.application.ajax');
    Route::get('archived-loan-applications-export', 'Broker\ApplicationController@archived_application_export')->name('broker.archived.application.export');

    Route::get('settled-loan-applications', 'Broker\ApplicationController@index_settled')->name('broker.settled.application.index');
    Route::get('settled-loan-applications-ajax', 'Broker\ApplicationController@index_settled_ajax')->name('broker.settled.application.ajax');
    Route::get('settled-loan-applications-export', 'Broker\ApplicationController@settled_application_export')->name('broker.settled.application.export');

    Route::get('loan/details/download/{enc_id}', 'Broker\ApplicationController@application_download')->name('broker.loan.download');
    Route::get('loan/details/{enc_id}', 'Broker\ApplicationController@show')->name('broker.loan.show');

    Route::get('application/emaillogs/ajax', 'Broker\ApplicationController@ajax_emaillogs')->name('application.emaillogs.ajax');
    Route::post('application/get-mail-data', 'Broker\ApplicationController@get_mail_data');
    Route::post('application/get-error-mail-data', 'Broker\ApplicationController@get_error_mail_data');

    Route::get('my-profile', 'Broker\HomeController@my_profile')->name('broker.my.profile');
    Route::post('my-profile-update', 'Broker\HomeController@user_profile_update')->name('broker.my.profile.update');

    Route::get('loan-application/create', 'Broker\ApplicationController@create_loan_application')->name('broker.new.loan.application');
    Route::post('loan-application/store', 'Broker\ApplicationController@store_loan_application')->name('broker.new.loan.application.store');
});

/*Admin Routes*/
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'is_admin']], function () {

    Route::post('check-company-enquiry-score', 'ApplicationController@check_company_enquiry_score')->name('equifax.check.company.enquiry.score');
    Route::post('check-company-trading-history-score', 'ApplicationController@check_company_trading_history_score')->name('equifax.check.company.trading.history.score');
    Route::post('check-user-score-seeker', 'ApplicationController@check_user_score_seeker')->name('equifax.check.user.score.seeker');

    Route::post('application/credit-score-event-log-data', 'ApplicationController@credit_score_event_log_data')->name('equifax.application.credit.score.score.event.log.data');

    //Route::get('company-enquiry', 'EquifaxController@company_enquiry')->name('equifax.company.enquiry');
    //Route::get('company-previous-enquiry', 'EquifaxController@company_previous_enquiry')->name('equifax.company.previous.enquiry');

    Route::post('application/upload/application-documents-mail', 'ApplicationDocumentController@customer_store_mail')->name('upload.doc.mail');

    Route::post('application/upload/application-documents', 'ApplicationDocumentController@customer_store')->name('upload.doc');
    Route::post('upload-documents/delete', 'ApplicationDocumentController@customer_destroy');

    Route::get('application/emaillogs/ajax', 'ApplicationController@ajax_emaillogs')->name('application.emaillogs.ajax');
    Route::post('application/get-mail-data', 'ApplicationController@get_mail_data');
    Route::post('application/get-error-mail-data', 'ApplicationController@get_error_mail_data');

    /** EmailTemplates *********/
    Route::get('emailtemplates', 'EmailTemplatesController@index')->name('emailtemplates.index');
    Route::get('emailtemplates/ajax', 'EmailTemplatesController@ajax_list')->name('emailtemplates.ajax.list');
    Route::get('emailtemplates/create', 'EmailTemplatesController@create')->name('emailtemplates.create');
    Route::post('emailtemplates/create', 'EmailTemplatesController@store')->name('emailtemplates.store');
    Route::get('email-templates/edit/{enc_id}', 'EmailTemplatesController@edit')->name('email.templates.edit');
    Route::post('email-templates/update', 'EmailTemplatesController@update')->name('email.templates.update');

    Route::post('get-email-template', 'EmailTemplatesController@get_email_template')->name('get.email.templates');
    Route::post('application/send-email', 'EmailTemplatesController@email_indent_send')->name('application.sendemail');

    //ApprovedDocuments
    Route::get('approveddocuments', 'ApprovedDocumentsController@index')->name('approveddocuments.index');
    Route::get('approveddocuments/ajax', 'ApprovedDocumentsController@ajax_list')->name('approveddocuments.ajax.list');
    Route::get('approveddocuments/create', 'ApprovedDocumentsController@create')->name('approveddocuments.create');
    Route::post('approveddocuments/create', 'ApprovedDocumentsController@store')->name('approveddocuments.store');
    Route::get('approveddocuments/edit/{enc_id}', 'ApprovedDocumentsController@edit')->name('approveddocuments.edit');
    Route::post('approveddocuments/update', 'ApprovedDocumentsController@update')->name('approveddocuments.update');

    //TokenIdentifiersController
    Route::get('tokenidentifiers', 'TokenIdentifiersController@index')->name('tokenidentifiers.index');
    Route::get('tokenidentifiers/ajax', 'TokenIdentifiersController@ajax_list')->name('tokenidentifiers.ajax.list');
    Route::get('tokenidentifiers/create', 'TokenIdentifiersController@create')->name('tokenidentifiers.create');
    Route::post('tokenidentifiers/create', 'TokenIdentifiersController@store')->name('tokenidentifiers.store');
    Route::get('tokenidentifiers/edit/{enc_id}', 'TokenIdentifiersController@edit')->name('tokenidentifiers.edit');
    Route::post('tokenidentifiers/update', 'TokenIdentifiersController@update')->name('tokenidentifiers.update');
    Route::get('tokenidentifiers-export', 'TokenIdentifiersController@tokenidentifiers_export')->name('tokenidentifiers.export.csv');

    //dashboard
    Route::get('dashboard', 'HomeController@dashboard')->name('admin.dashboard');
    Route::get('dashboard-application-export', 'HomeController@dashboard_application_export')->name('admin.dashboard.application.export');


    /*My Profile*/
    Route::get('my-profile', 'UserController@myProfile')->name('my.profile');


    /*Loan Applications*/

    Route::post('conditionally-approved-update', 'ApplicationController@conditionally_approved')->name('loan.application.approved.update');
    Route::post('conditionally-approved-generate-documents', 'ApplicationDocumentController@generate_documents')->name('loan.application.generate.documents');
    Route::post('conditionally-approved-generate-documents-sel', 'ApplicationDocumentController@generate_documents_sel')->name('loan.application.generate.documents.sel');

    Route::get('loan-applications', 'ApplicationController@index')->name('admin.loan.application');
    Route::get('loan-applications-ajax', 'ApplicationController@indexAjax')->name('loan.applications.ajax');
    Route::get('current-loan-applications-export', 'ApplicationController@indexExport')->name('loan.applications.current.export');

    Route::get('declined-loan-applications', 'ApplicationController@index_declined')->name('admin.declined.application.index');
    Route::get('declined-loan-applications-ajax', 'ApplicationController@index_declined_ajax')->name('admin.declined.application.ajax');
    Route::get('declined-loan-applications-export', 'ApplicationController@declined_application_export')->name('admin.declined.application.export');

    Route::get('archived-loan-applications', 'ApplicationController@index_archived')->name('admin.archived.application.index');
    Route::get('archived-loan-applications-ajax', 'ApplicationController@index_archived_ajax')->name('admin.archived.application.ajax');
    Route::get('archived-loan-applications-export', 'ApplicationController@archived_application_export')->name('admin.archived.application.export');

    Route::get('settled-loan-applications', 'ApplicationController@index_settled')->name('admin.settled.application.index');
    Route::get('settled-loan-applications-ajax', 'ApplicationController@index_settled_ajax')->name('admin.settled.application.ajax');
    Route::get('settled-loan-applications-export', 'ApplicationController@settled_application_export')->name('admin.settled.application.export');

    Route::get('loan/details/download/{enc_id}', 'ApplicationController@application_download')->name('admin.loan.download');
    Route::get('loan/details/{enc_id}', 'ApplicationController@show')->name('admin.loan.show');

    Route::post('consent/resent', 'ApplicationController@consentResent')->name('consent.resent');


    Route::get('loan/details/edit/{enc_id}', 'ApplicationController@loan_edit')->name('loan.details.edit.business.information');
    Route::post('loan/details/update/business', 'ApplicationController@loan_update_business')->name('loan.details.update.business.information');


    Route::post('loan/details/add/director', 'ApplicationController@add_director')->name('loan.details.add.director');
    Route::post('loan/details/update/director', 'ApplicationController@update_director')->name('loan.details.update.director');
    Route::post('loan/details/team', 'ApplicationController@loan_team')->name('loan.details.team');

    Route::post('loan/details/add/property_security', 'ApplicationController@add_property_security')->name('loan.details.add.property.security');
    Route::post('loan/details/update/property_security', 'ApplicationController@update_property_security')->name('loan.details.update.property.security');
    Route::post('loan/details/property_security', 'ApplicationController@property_security')->name('loan.details.property.security');

    Route::post('loan/details/add/crypto_security', 'ApplicationController@add_crypto_security')->name('loan.details.add.crypto.security');
    Route::post('loan/details/update/crypto_security', 'ApplicationController@update_crypto_security')->name('loan.details.update.crypto.security');
    Route::post('loan/details/crypto_security', 'ApplicationController@crypto_security')->name('loan.details.crypto.security');


    Route::post('loan/details/add/business_financial', 'ApplicationController@add_business_financial')->name('loan.details.add.business.financial');
    Route::post('loan/details/update/business_financial', 'ApplicationController@update_business_financial')->name('loan.details.update.business.financial');
    Route::post('loan/details/business_financial', 'ApplicationController@business_financial')->name('loan.details.business.financial');

    Route::get('loan/details/document/{enc_id}', 'ApplicationController@loan_document_edit')->name('loan.details.edit.document');
    Route::post('loan/details/update/document', 'ApplicationController@loan_update_document')->name('loan.details.update.document');
    Route::post('loan/details/document/delete', 'ApplicationController@document_destory')->name('loan.details.document.delete');

    Route::get('loan/details/finance/{enc_id}', 'ApplicationController@loan_finance_edit')->name('loan.details.edit.finance');
    Route::post('loan/details/update/finance', 'ApplicationController@loan_finance_document')->name('loan.details.update.finance');

    Route::post('loan/details/directors_financial', 'ApplicationController@directors_financial')->name('loan.details.directors.financial');
    Route::post('loan/details/update/directors_financial', 'ApplicationController@update_directors_financial')->name('loan.details.update.directors.financial');

    //Route::get('loan/details/edit/people/{enc_id}', 'ApplicationController@loan_people')->name('loan.details.edit.people');


    /*Update Loan Status*/
    Route::post('review-note/store', 'ReviewNoteController@store')->name('review.note.create');
    Route::post('review/status/update', 'ReviewNoteController@update')->name('review.status.update');
    Route::post('review/status/assessorupdate', 'ReviewNoteController@assessorupdate')->name('review.status.assessorupdate');
    Route::post('assessor-review-note/store', 'AssessorReviewNoteController@assessor_store')->name('review.assessor.note.create');






    /*Users*/


    Route::get('users', 'UserController@index')->name('user.list');
    Route::get('users/ajax', 'UserController@ajax_list')->name('user.ajax.list');
    Route::get('users-export', 'UserController@export_data')->name('users.export');
    //Route::post('users-delete', 'UserController@destroy')->name('users.delete');
    Route::post('users-delete', 'UserController@destroy_users')->name('users.delete.one');


    //Brokers
    Route::get('brokers', 'BrokersController@index')->name('brokers.list');
    Route::get('brokers/ajax', 'BrokersController@ajax_list')->name('brokers.ajax.list');
    Route::get('brokers-export', 'BrokersController@export_data')->name('brokers.export');
    Route::get('brokers/create', 'BrokersController@create')->name('brokers.create');
    Route::post('brokers/create', 'BrokersController@store')->name('brokers.store');
    Route::post('get-brokers', 'BrokersController@get_users')->name('get.brokers');
    Route::post('brokers-delete', 'BrokersController@destroy_users')->name('brokers.delete.one');
    Route::post('brokers/update', 'BrokersController@users_update')->name('brokers.update');
    Route::post('brokers/status/accept', 'BrokersController@users_status_accept_update')->name('brokers.status.accept.update');
    Route::post('brokers/status/reject', 'BrokersController@users_status_reject_update')->name('brokers.status.reject.update');


    //Route::get('inquiries/ajax', 'InquiryController@ajax_list')->name('inquiries.ajax.list');
    //Route::get('inquiries-export', 'InquiryController@inquiries_export')->name('inquiries.export.csv');
    //Route::post('inquiries-delete', 'InquiryController@destroy')->name('inquiries.destroy');


    Route::get('users/loan-applications/{id}', 'ApplicationController@user_index')->name('admin.user.loan.application');
    Route::get('users-loan-applications-ajax', 'ApplicationController@index_users_ajax')->name('admin.users.application.ajax');
    Route::get('users-loan-applications-export', 'ApplicationController@user_index_export')->name('admin.user.loan.application.export');

    // Create new customer
    Route::get('users/create', 'UserController@create')->name('users.create');
    Route::post('users/create', 'UserController@store')->name('users.store');

    Route::post('get-users', 'UserController@get_users')->name('get.users');
    Route::post('users/update', 'UserController@users_update')->name('users.update');

    // Create new loan application
    Route::get('users/{enc_user_id}/loan-application/create', 'ApplicationController@admin_create_loan_application')->name('users.new.loan.application');
    Route::post('users/loan-application/store', 'ApplicationController@admin_store_loan_application')->name('users.new.loan.application.store');
    /*UsersLogs*/
    Route::get('user-logs', 'UserLogsController@index')->name('user.logs.list');
    Route::get('user-logs-list', 'UserLogsController@indexAjax')->name('user.logs.list.ajax');
    Route::get('user-logs/delete/{id}', 'UserLogsController@destroy')->name('user.logs.delete');
    Route::get('user-logs-export', 'UserLogsController@user_log_export')->name('admin.user.logs.export');

    /*Inquiry*/
    Route::get('inquiries', 'InquiryController@index')->name('inquiries');
    Route::get('inquiries/ajax', 'InquiryController@ajax_list')->name('inquiries.ajax.list');
    Route::get('inquiries-export', 'InquiryController@inquiries_export')->name('inquiries.export.csv');
    Route::post('inquiries-delete', 'InquiryController@destroy')->name('inquiries.destroy');
    Route::post('inquiries-add', 'InquiryController@inquiries_add')->name('inquiries.add');
    Route::post('inquiries-msg-update', 'InquiryController@inquiries_msg_update')->name('inquiries.msg.update');

    Route::post('get-inquiries-msg', 'InquiryController@get_inquiries_msg')->name('get.inquiries.msg');
});

/*Comman Auth Route*/
Route::middleware(['auth'])->group(function () {
    /*My Profile*/
    Route::post('my-profile', 'UserController@myProfileUpdate')->name('my.profile.update');
    Route::post('my-profile/change-password', 'UserController@myProfileChangePassword')->name('my.profile.change.password');
    Route::post('loan/people/add', 'TeamSizeController@add')->name('loan.teamsize.form.add');
});

/*Artisan Route*/
Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('storage:link');
    return response()->json([
        'status' => 'success',
        'message' => 'Cache, Config, View cleared and Storage link created',
        'output' => Artisan::output()
    ]);
});

Route::get('storage-link', function () {
    $exitCode = Artisan::call('storage:link');
    return response()->json([
        'status' => 'success',
        'message' => 'Storage Link Create Success!',
        'exitCode' => $exitCode,
        'output' => Artisan::output()
    ]);
});

/*Job Fire*/
Route::get('job-fire', function () {
    $exitCode = Artisan::call('queue:work --stop-when-empty');
    return response()->json([
        'status' => 'success',
        'message' => 'Job Fire completed',
        'exitCode' => $exitCode,
        'output' => Artisan::output()
    ]);
});