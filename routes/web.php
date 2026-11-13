<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/blank', function () {
    return view('blank');
})->name('blank');

Route::get('/customer_claim', function () {
    return view('customer_claim');
})->name('customer_claim');

Route::get('/email_recipient', function () {
    return view('email_recipient');
})->name('email_recipient');

Route::get('/customer_classification', function () {
    return view('customer_classification');
})->name('customer_classification');

Route::get('/product_classification', function () {
    return view('product_classification');
})->name('product_classification');

Route::get('/holiday_classification', function () {
    return view('holiday_classification');
})->name('holiday_classification');

Route::get('/eight_d_report', function () {
    return view('eight_d_report');
})->name('eight_d_report');

Route::get('/master_list', function () {
    return view('master_list');
})->name('master_list');

Route::get('/export_master_list', function () {
    return view('export_master_list');
})->name('export_master_list');

Route::get('/automailer', function () {
    return view('automailer');
})->name('automailer');


// Customer Claim Controller
Route::post('/add_customer_claim', 'CustomerClaimController@add_customer_claim')->name('add_customer_claim');
Route::get('/add_customer_claim_testing', 'CustomerClaimController@add_customer_claim_testing')->name('add_customer_claim_testing');
Route::get('/view_customer_claim_cn', 'CustomerClaimController@view_customer_claim_cn')->name('view_customer_claim_cn');
Route::get('/view_customer_claim_ts', 'CustomerClaimController@view_customer_claim_ts')->name('view_customer_claim_ts');
Route::get('/view_customer_claim_yf', 'CustomerClaimController@view_customer_claim_yf')->name('view_customer_claim_yf');
Route::get('/view_customer_claim_pps', 'CustomerClaimController@view_customer_claim_pps')->name('view_customer_claim_pps');
Route::get('/get_customer_claim_by_id', 'CustomerClaimController@get_customer_claim_by_id')->name('get_customer_claim_by_id');
Route::get('/get_customer_claim_view_by_id', 'CustomerClaimController@get_customer_claim_view_by_id')->name('get_customer_claim_view_by_id');
Route::get('/get_holiday_for_date_picker', 'CustomerClaimController@get_holiday_for_date_picker')->name('get_holiday_for_date_picker'); //BY CDP
Route::get('/download_cn_attachment/{id}', 'CustomerClaimController@download_cn_attachment')->name('download_cn_attachment'); //BY CDP
Route::get('/get_customer_claim_control_number', 'CustomerClaimController@get_customer_claim_control_number')->name('get_customer_claim_control_number'); //BY CDP
Route::get('/get_email_recipients', 'CustomerClaimController@get_email_recipients')->name('get_email_recipients');
Route::get('/send_email', 'CustomerClaimController@send_email')->name('send_email');
Route::get('/download_operation_eight_d_report/{id}', 'CustomerClaimController@download_operation_eight_d_report')->name('download_operation_eight_d_report');
Route::get('/get_customer_for_filter', 'CustomerClaimController@get_customer_for_filter')->name('get_customer_for_filter'); //BY CDP
Route::get('/get_product_classification_for_filter', 'CustomerClaimController@get_product_classification_for_filter')->name('get_product_classification_for_filter'); //BY CDP
Route::get('/download_eight_d_report_file/{id}', 'CustomerClaimController@download_eight_d_report_file')->name('download_eight_d_report_file'); //BY CDP
Route::get('/get_data_for_dashboard', 'CustomerClaimController@get_data_for_dashboard')->name('get_data_for_dashboard');


// Checksheet Controller
Route::get('/export', 'ChecksheetExportController@export')->name('export');


// RapidX Controller
Route::get('/get_rapidx_users', 'RapidXUserController@get_rapidx_users');
Route::get('/get_section', 'RapidXUserController@get_section');
Route::get('/get_cbo_rapidx_users', 'RapidXUserController@get_cbo_rapidx_users')->name('get_cbo_rapidx_users');


// Email Recipient Controller
Route::post('/add_email_recipient', 'EmailRecipientController@add_email_recipient')->name('add_email_recipient');
Route::get('/view_email_recipient', 'EmailRecipientController@view_email_recipient')->name('view_email_recipient');
Route::get('/get_email_recipient_by_id', 'EmailRecipientController@get_email_recipient_by_id')->name('get_email_recipient_by_id');
Route::get('/get_email_recipient', 'EmailRecipientController@get_email_recipient');
Route::post('/delete_email_recipient', 'EmailRecipientController@delete_email_recipient')->name('delete_email_recipient');


// Product Classification
Route::post('/add_product_classification', 'ProductClassificationController@add_product_classification')->name('add_product_classification');
Route::get('/view_product_classification', 'ProductClassificationController@view_product_classification')->name('view_product_classification');
Route::get('/get_product_classification_by_id', 'ProductClassificationController@get_product_classification_by_id')->name('get_product_classification_by_id');
Route::post('/delete_product_classification', 'ProductClassificationController@delete_product_classification')->name('delete_product_classification');
Route::get('/get_product_classification', 'ProductClassificationController@get_product_classification');


// Customer Classification
Route::get('/view_customer', 'CustomerClassificationController@view_customer')->name('view_customer');
Route::post('/add_customer', 'CustomerClassificationController@add_customer')->name('add_customer');
Route::get('/get_customer_by_id', 'CustomerClassificationController@get_customer_by_id')->name('get_customer_by_id');
Route::post('/delete_customer_classification', 'CustomerClassificationController@delete_customer_classification')->name('delete_customer_classification');
Route::get('/get_customer_classification', 'CustomerClassificationController@get_customer_classification');


// Holiday Controller
Route::get('/view_holiday', 'HolidayController@view_holiday')->name('view_holiday');
Route::post('/add_holiday', 'HolidayController@add_holiday')->name('add_holiday');
Route::get('/get_holiday_by_id', 'HolidayController@get_holiday_by_id')->name('get_holiday_by_id');
Route::post('/delete_holiday', 'HolidayController@delete_holiday')->name('delete_holiday');


// 8D Report Controller
Route::get('/view_eight_d_report_cn', 'EightDReportController@view_eight_d_report_cn')->name('view_eight_d_report_cn');
Route::get('/view_eight_d_report_ts', 'EightDReportController@view_eight_d_report_ts')->name('view_eight_d_report_ts');
Route::get('/view_eight_d_report_yf', 'EightDReportController@view_eight_d_report_yf')->name('view_eight_d_report_yf');
Route::get('/view_eight_d_report_pps', 'EightDReportController@view_eight_d_report_pps')->name('view_eight_d_report_pps');
Route::get('/get_eight_d_report_by_id', 'EightDReportController@get_eight_d_report_by_id')->name('get_eight_d_report_by_id');
Route::get('/get_eight_d_report_by_id_for_reupload', 'EightDReportController@get_eight_d_report_by_id_for_reupload')->name('get_eight_d_report_by_id_for_reupload');
Route::get('/download_email_attachment/{id}', 'EightDReportController@download_email_attachment')->name('download_email_attachment');
Route::get('/download_eight_d_attachment/{id}', 'EightDReportController@download_eight_d_attachment')->name('download_eight_d_attachment');
Route::post('/add_eight_d_report', 'EightDReportController@add_eight_d_report')->name('add_eight_d_report');
Route::get('/get_submitted_eight_d_report_by_id', 'EightDReportController@get_submitted_eight_d_report_by_id')->name('get_submitted_eight_d_report_by_id');
Route::get('/get_eight_d_report_revision_by_id', 'EightDReportController@get_eight_d_report_revision_by_id')->name('get_eight_d_report_revision_by_id');
Route::post('/disapproved_submitted_eight_d_report', 'EightDReportController@disapproved_submitted_eight_d_report')->name('disapproved_submitted_eight_d_report');
Route::post('/approved_submitted_eight_d_report', 'EightDReportController@approved_submitted_eight_d_report')->name('approved_submitted_eight_d_report');
Route::get('/view_eight_d_report_history', 'EightDReportController@view_eight_d_report_history')->name('view_eight_d_report_history');
Route::get('/view_eight_d_report_history_test', 'EightDReportController@view_eight_d_report_history_test')->name('view_eight_d_report_history_test');
Route::get('/view_eight_d_report_histories', 'EightDReportController@view_eight_d_report_histories')->name('view_eight_d_report_histories');
Route::post('/upload_operation_eight_d_report_for_validated_claim', 'EightDReportController@upload_operation_eight_d_report_for_validated_claim')->name('upload_operation_eight_d_report_for_validated_claim');


// Masterlist Controller
Route::get('/view_customer_claim_master_list', 'MasterlistController@view_customer_claim_master_list')->name('view_customer_claim_master_list');//BY CDP
Route::post('/add_yec_eight_d_report', 'MasterlistController@add_yec_eight_d_report')->name('add_yec_eight_d_report');//BY CDP
Route::get('/get_yec_upload_for_edit', 'MasterlistController@get_yec_upload_for_edit')->name('get_yec_upload_for_edit');//BY CDP
Route::get('/download_yec_eight_d_attachment/{name}', 'MasterlistController@download_yec_eight_d_attachment')->name('download_yec_eight_d_attachment');//BY CDP
Route::get('/download_operation_eight_d_attachment/{file}', 'MasterlistController@download_operation_eight_d_attachment')->name('download_operation_eight_d_attachment'); // Requested by Ma'am Jo - JD


// Auto Email For Due Date And Over Due Controller
Route::get('/get_date', 'AutoEmailController@get_date')->name('get_date');//BY CDP
Route::get('/send_mail_due_date', 'AutoEmailController@send_mail_due_date')->name('send_mail_due_date');//BY CDP
Route::get('/send_mail_before_due_date', 'AutoEmailController@send_mail_before_due_date')->name('send_mail_before_due_date');//BY CDP
Route::get('/send_mail_over_due_date', 'AutoEmailController@send_mail_over_due_date')->name('send_mail_over_due_date');//BY CDP

// Auto Email every 7th day of the month
Route::get('/getCustomerClaimData', 'AutoEmailController@getCustomerClaimData')->name('getCustomerClaimData');
Route::get('/sendMonthlyMailer', 'AutoEmailController@sendMonthlyMailer')->name('sendMonthlyMailer');
Route::get('/sendMonthlyForJannusMailer', 'AutoEmailController@sendMonthlyForJannusMailer')->name('sendMonthlyForJannusMailer');