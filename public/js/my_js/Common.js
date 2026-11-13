// Reset Form values function
function resetFormValues() {
    // Reset values
    $("#formAddCustomerClaim")[0].reset();
    $('select[name="quarter"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="customer"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="sender_name"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="contributor"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="validity"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="product_classification"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="automotive"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="defect_category_class"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="email_recipient_attention[]"]', $("#formAddCustomerClaim")).val(0).trigger('change');
    $('select[name="email_recipient_cc[]"]', $("#formAddCustomerClaim")).val(0).trigger('change');

    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');
    $('div').find('select').removeClass('is-invalid');
    $("div").find('select').attr('title', '');
    $("div").find('input[type="date"]').attr('title', '');

    $('#chkActualDateReceivedClaim').attr('checked', false);
    $('#txtAddActualDateReceivedOfClaim').attr('disabled', true);
    $('#chkdateReturnClaim').attr('checked', false);
    $('#txtAddDateReturnOfClaimSample').attr('disabled', true);

}

// Reset values when modalAddCustomerClaim(Modal) is closed
$("#modalAddCustomerClaim").on('hidden.bs.modal', function () {
    console.log('modal is closed');
    resetFormValues();
});


// Reset Form values function
function resetFormValuesEmailRecipient() {
    // Reset values
    $("#formAddEmailRecipient")[0].reset();

    // Reset hidden input fields
    $("input[name='user_id']", $('#formAddEmailRecipient')).val('');
    $("input[name='email_recipient_id']", $('#formAddEmailRecipient')).val('');
    $("input[name='recipient_name']", $('#formAddEmailRecipient')).val('');

    // Reset values
    $("select[name='recipient_name_display']", $('#formAddEmailRecipient')).val(0).trigger('change');
    $("select[name='section']", $('#formAddEmailRecipient')).val(0).trigger('change');

    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');
    $('div').find('select').removeClass('is-invalid');
    $("div").find('select').attr('title', '');
}

$("#modalAddEmailRecipient").on('hidden.bs.modal', function () {
    console.log('modal is closed');
    resetFormValuesEmailRecipient();
});


// Reset Form(Product Classification) values function
function resetFormValuesProductClassification() {
    // Reset values
    $("#formAddProductClassification")[0].reset();

    // Reset hidden input fields
    $("input[name='product_name']", $('#formAddProductClassification')).val('');
    $("input[name='product_details']", $('#formAddProductClassification')).val('');

    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');
}

$("#modalAddProductClassification").on('hidden.bs.modal', function () {
    resetFormValuesProductClassification();
});


// Reset Form(Customer Classification) values function
function resetFormValuesCustomerClassification() {
    // Reset values
    $("#formAddCustomer")[0].reset();
    console.log('resetFormValuesCustomerClassification RUN')
    // Reset hidden input fields
    $("input[name='customer_name']", $('#formAddCustomer')).val('');
    $("input[name='customer_details']", $('#formAddCustomer')).val('');
    $("input[name='customer_id']", $('#formAddCustomer')).val('');

    
    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');
}

$("#modalAddCustomer").on('hidden.bs.modal', function () {
    // console.log('test');
    resetFormValuesCustomerClassification();
});

// Reset Form(Holiday) values function
function resetFormValuesHoliday() {
    // Reset values
    $("#formAddHoliday")[0].reset();

    // Reset hidden input fields
    $("input[name='holiday_name']", $('#formAddHoliday')).val('');
    // $("input[name='holiday_month']", $('#formAddHoliday')).val('');

    $("select[name='holiday_month']", $('#formAddHoliday')).val(0).trigger('change');
    $("select[name='holiday_day']", $('#formAddHoliday')).val(0).trigger('change');

    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');
}

$("#modalAddHoliday").on('hidden.bs.modal', function () {
    // console.log('modal is closed');
    resetFormValuesHoliday();
});


// Reset Form(EightDReport) values function
function resetFormValuesEightDReport() {
    // Reset hidden input fields
    $("#formEightDReport")[0].reset();
    $('select[name="quarter"]', $("#formEightDReport")).val(0).trigger('change');
    $('select[name="customer"]', $("#formEightDReport")).val(0).trigger('change');
    $('select[name="sender_name"]', $("#formEightDReport")).val(0).trigger('change');
    $('select[name="contributor"]', $("#formEightDReport")).val(0).trigger('change');
    $('select[name="validity"]', $("#formEightDReport")).val(0).trigger('change');
    $('select[name="product_classification"]', $("#formEightDReport")).val(0).trigger('change');
    $('select[name="automotive"]', $("#formEightDReport")).val(0).trigger('change');
    $('select[name="defect_category_class"]', $("#formEightDReport")).val(0).trigger('change');

    // Root Cause reset values
    $('.generatedDivHeader').remove();
    $('#divRootCauseAction').find('.generatedDiv').remove();
    $('#root_cause_action_counter').val(1);
    $('#remove_row_root_cause_action').addClass('d-none');

    // Escapee Cause reset values
    $('.generatedDivHeader').remove();
    $('#divEscapeeCauseAction').find('.generatedDiv').remove();
    $('#escapee_cause_action_counter').val(1);
    $('#remove_row_escapee_cause_action').addClass('d-none');

    // Systemic Cause reset values
    $('.generatedDivHeader').remove();
    $('#divSystemicAction').find('.generatedDiv').remove();
    $('#systemic_action_counter').val(1);
    $('#remove_row_systemic_action').addClass('d-none');

    // Fanout reset values
    $('.generatedDivHeader').remove();
    $('#divFanoutAction').find('.generatedDiv').remove();
    $('#fanout_action_counter').val(1);
    $('#remove_row_fanout_action').addClass('d-none');
}

$("#modalEightDReport").on('hidden.bs.modal', function () {
    console.log('modalEightDReport is closed');
    resetFormValuesEightDReport();
});


// Reset Form(Validate 8D Report) values function
function resetFormValuesEightDReportValidation() {
    // Reset values
    $("#formValidateEightDReport")[0].reset();

    // Reset hidden input fields
    $("input[name='operation_eight_d_report_filename']", $('#formValidateEightDReport')).val('');
    $("input[name='operation_eight_d_report_date']", $('#formValidateEightDReport')).val('');
    $("input[name='operation_eight_d_report_sender']", $('#formValidateEightDReport')).val('');
    $("input[name='remarks']", $('#formValidateEightDReport')).val('');
    $("input[name='remarks']", $('#formAddEightDReportRemarks')).val('');
}

$("#modalValidateEightDReport").on('hidden.bs.modal', function () {
    console.log('modalValidateEightDReport is closed');
    resetFormValuesEightDReportValidation();
});


// Reset Form(Add 8D Report Remarks) values function
function resetFormValuesEightDReportAddRemarks() {
    // Reset values
    $("#formAddEightDReportRemarks")[0].reset();

    // Reset hidden input fields
    $("input[name='remarks']", $('#formAddEightDReportRemarks')).val('');
}

$("#modalAddEightDReportRemarks").on('hidden.bs.modal', function () {
    console.log('modalAddEightDReportRemarks is closed');
    resetFormValuesEightDReportAddRemarks();
});



function resetUploadEightReport() {
    // Reset values
    $("#formYecEightUpload")[0].reset();
    $("#txtAddEightReport").removeClass('is-invalid');
    $("#txtAddEightReceived").removeClass('is-invalid');
   
}

// Reset values when modalAddCustomerClaim(Modal) is closed
$("#modalUploadYecEightD").on('hidden.bs.modal', function () {
    console.log('modal is closed');
    resetUploadEightReport();
});


function resetReUploadOperationEightDReport() {
    // Reset values
    $("#formReUploadOperationEightDReport")[0].reset();
    $('#divTxtEightDReportFile', $('#formReUploadOperationEightDReport')).removeClass('d-none');
    $('#divFileEightDReportFile', $('#formReUploadOperationEightDReport')).addClass('d-none');
}

// Reset values when modalAddCustomerClaim(Modal) is closed
$("#modalReUploadOperationEightDReport").on('hidden.bs.modal', function () {
    console.log('modalReUploadOperationEightDReport is closed');
    resetReUploadOperationEightDReport();
});
