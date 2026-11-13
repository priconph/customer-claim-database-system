//============================== Add Email Recipient ==============================
function AddCustomerClaim(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    let formData = new FormData($('#formAddCustomerClaim')[0]);
    // console.log(formData);
	$.ajax({
        url: "add_customer_claim",
        method: "post",
        processData: false,
        contentType: false,
        // data: $('#formAddCustomerClaim').serialize(),
        data: formData,
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddCustomerClaimIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddCustomerClaim").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Saving claim records failed!');
                if(response['error']['pmi_control_number'] === undefined){
                    $("#txtAddControlNumber").removeClass('is-invalid');
                    $("#txtAddControlNumber").attr('title', '');
                }
                else{
                    $("#txtAddControlNumber").addClass('is-invalid');
                    $("#txtAddControlNumber").attr('title', response['error']['pmi_control_number']);
                }

                if(response['error']['reference_number'] === undefined){
                    $("#txtAddReferenceNumber").removeClass('is-invalid');
                    $("#txtAddReferenceNumber").attr('title', '');
                }
                else{
                    $("#txtAddReferenceNumber").addClass('is-invalid');
                    $("#txtAddReferenceNumber").attr('title', response['error']['reference_number']);
                }

                if(response['error']['quarter'] === undefined){
                    $("#selectQuarter").removeClass('is-invalid');
                    $("#selectQuarter").attr('title', '');
                }
                else{
                    $("#selectQuarter").addClass('is-invalid');
                    $("#selectQuarter").attr('title', response['error']['quarter']);
                }

                if(response['error']['customer'] === undefined){
                    $("#selectCustomer").removeClass('is-invalid');
                    $("#selectCustomer").attr('title', '');
                }
                else{
                    $("#selectCustomer").addClass('is-invalid');
                    $("#selectCustomer").attr('title', response['error']['customer']);
                }

                // if(response['error']['sender_name'] === undefined){
                //     $("#selectSenderName").removeClass('is-invalid');
                //     $("#selectSenderName").attr('title', '');
                // }
                // else{
                //     $("#selectSenderName").addClass('is-invalid');
                //     $("#selectSenderName").attr('title', response['error']['sender_name']);
                // }

                if(response['error']['contributor'] === undefined){
                    $("#selectContributor").removeClass('is-invalid');
                    $("#selectContributor").attr('title', '');
                }
                else{
                    $("#selectContributor").addClass('is-invalid');
                    $("#selectContributor").attr('title', response['error']['contributor']);
                }

                if(response['error']['validity'] === undefined){
                    $("#selectValidity").removeClass('is-invalid');
                    $("#selectValidity").attr('title', '');
                }
                else{
                    $("#selectValidity").addClass('is-invalid');
                    $("#selectValidity").attr('title', response['error']['validity']);
                }

                if(response['error']['product_classification'] === undefined){
                    $("#selectProductClassification").removeClass('is-invalid');
                    $("#selectProductClassification").attr('title', '');
                }
                else{
                    $("#selectProductClassification").addClass('is-invalid');
                    $("#selectProductClassification").attr('title', response['error']['product_classification']);
                }

                if(response['error']['model_name'] === undefined){
                    $("#txtAddModelName").removeClass('is-invalid');
                    $("#txtAddModelName").attr('title', '');
                }
                else{
                    $("#txtAddModelName").addClass('is-invalid');
                    $("#txtAddModelName").attr('title', response['error']['model_name']);
                }

                if(response['error']['mode_of_defect'] === undefined){
                    $("#txtAddModeOfDefect").removeClass('is-invalid');
                    $("#txtAddModeOfDefect").attr('title', '');
                }
                else{
                    $("#txtAddModeOfDefect").addClass('is-invalid');
                    $("#txtAddModeOfDefect").attr('title', response['error']['mode_of_defect']);
                }

                if(response['error']['lot_number'] === undefined){
                    $("#txtAddPONumber").removeClass('is-invalid');
                    $("#txtAddPONumber").attr('title', '');
                }
                else{
                    $("#txtAddPONumber").addClass('is-invalid');
                    $("#txtAddPONumber").attr('title', response['error']['lot_number']);
                }

                if(response['error']['automotive'] === undefined){
                    $("#selectAutomotive").removeClass('is-invalid');
                    $("#selectAutomotive").attr('title', '');
                }
                else{
                    $("#selectAutomotive").addClass('is-invalid');
                    $("#selectAutomotive").attr('title', response['error']['automotive']);
                }

                if(response['error']['quantity'] === undefined){
                    $("#txtAddQuantity").removeClass('is-invalid');
                    $("#txtAddQuantity").attr('title', '');
                }
                else{
                    $("#txtAddWorkloadDescription").addClass('is-invalid');
                    $("#txtAddWorkloadDescription").attr('title', response['error']['quantity']);
                }

                if(response['error']['number_of_ng'] === undefined){
                    $("#txtAddNumberOfNG").removeClass('is-invalid');
                    $("#txtAddNumberOfNG").attr('title', '');
                }
                else{
                    $("#txtAddNumberOfNG").addClass('is-invalid');
                    $("#txtAddNumberOfNG").attr('title', response['error']['number_of_ng']);
                }

                if(response['error']['return_to_vendor'] === undefined){
                    $("#txtAddReturnToVendor").removeClass('is-invalid');
                    $("#txtAddReturnToVendor").attr('title', '');
                }
                else{
                    $("#txtAddReturnToVendor").addClass('is-invalid');
                    $("#txtAddReturnToVendor").attr('title', response['error']['return_to_vendor']);
                }

                if(response['error']['defect_category_class'] === undefined){
                    $("#selectDefectCategoryClass").removeClass('is-invalid');
                    $("#selectDefectCategoryClass").attr('title', '');
                }
                else{
                    $("#selectDefectCategoryClass").addClass('is-invalid');
                    $("#selectDefectCategoryClass").attr('title', response['error']['defect_category_class']);
                }

                if(response['error']['date_received'] === undefined){
                    $("#txtDateReceived").removeClass('is-invalid');
                    $("#txtDateReceived").attr('title', '');
                }
                else{
                    $("#txtDateReceived").addClass('is-invalid');
                    $("#txtDateReceived").attr('title', response['error']['date_received']);
                }

                if(response['error']['actual_date_received_claim'] === undefined){
                    $("#txtAddActualDateReceivedOfClaim").removeClass('is-invalid');
                    $("#txtAddActualDateReceivedOfClaim").attr('title', '');
                }
                else{
                    $("#txtAddActualDateReceivedOfClaim").addClass('is-invalid');
                    $("#txtAddActualDateReceivedOfClaim").attr('title', response['error']['actual_date_received_claim']);
                }

                if(response['error']['date_return_of_claim'] === undefined){
                    $("#txtAddDateReturnOfClaimSample").removeClass('is-invalid');
                    $("#txtAddDateReturnOfClaimSample").attr('title', '');
                }
                else{
                    $("#txtAddDateReturnOfClaimSample").addClass('is-invalid');
                    $("#txtAddDateReturnOfClaimSample").attr('title', response['error']['date_return_of_claim']);
                }

                if(response['error']['required_reply'] === undefined){
                    $("#txtAddRequiredReply").removeClass('is-invalid');
                    $("#txtAddRequiredReply").attr('title', '');
                }
                else{
                    $("#txtAddRequiredReply").addClass('is-invalid');
                    $("#txtAddRequiredReply").attr('title', response['error']['required_reply']);
                }

                if(response['error']['eight_report_name'] === undefined){
                    $("#txtAddEightDReportName").removeClass('is-invalid');
                    $("#txtAddEightDReportName").attr('title', '');
                }
                else{
                    $("#txtAddEightDReportName").addClass('is-invalid');
                    $("#txtAddEightDReportName").attr('title', response['error']['eight_report_name']);
                }
                
                if(response['error']['eight_report_filename'] === undefined){
                    $("#txtAddEightDFileUpload").removeClass('is-invalid');
                    $("#txtAddEightDFileUpload").attr('title', '');
                }
                else{
                    $("#txtAddEightDFileUpload").addClass('is-invalid');
                    $("#txtAddEightDFileUpload").attr('title', response['error']['eight_report_filename']);
                }

                if(response['error']['yec_yed_report_name'] === undefined){
                    $("#txtAddSenderName").removeClass('is-invalid');
                    $("#txtAddSenderName").attr('title', '');
                }
                else{
                    $("#txtAddSenderName").addClass('is-invalid');
                    $("#txtAddSenderName").attr('title', response['error']['yec_yed_report_name']);
                }

                if(response['error']['yec_yed_report_date'] === undefined){
                    $("#txtAddReportReceived").removeClass('is-invalid');
                    $("#txtAddReportReceived").attr('title', '');
                }
                else{
                    $("#txtAddReportReceived").addClass('is-invalid');
                    $("#txtAddReportReceived").attr('title', response['error']['yec_yed_report_date']);
                }

                if(response['error']['yec_yed_report_file'] === undefined){
                    $("#txtAddReportFile").removeClass('is-invalid');
                    $("#txtAddReportFile").attr('title', '');
                }
                else{
                    $("#txtAddReportFile").addClass('is-invalid');
                    $("#txtAddReportFile").attr('title', response['error']['yec_yed_report_file']);
                }

                if(response['error']['yec_yed_report_file'] === undefined){
                    $("#txtAddReportFile").removeClass('is-invalid');
                    $("#txtAddReportFile").attr('title', '');
                }
                else{
                    $("#txtAddReportFile").addClass('is-invalid');
                    $("#txtAddReportFile").attr('title', response['error']['yec_yed_report_file']);
                }
                
                if(response['error']['email_recipient_attention'] === undefined && response['error']['email_recipient_cc']   === undefined){
                    $("#divEmailId").attr('style', 'border: none');
                }
                else{
                    $("#divEmailId").attr('style', 'border: 1px solid red !important');
                }
            }else{
                // $("#modalAddCustomerClaim").modal('hide');
                $('#smartwizard').smartWizard("next"); // trigger next step when the validation is passed
                toastr.success('Claim records was succesfully saved!');
                dataTablesCustomerClaimCN.draw();
                dataTablesCustomerClaimTS.draw();
                dataTablesCustomerClaimYF.draw();
                dataTablesCustomerClaimPPS.draw();
                $('#modalAddCustomerClaim').modal('hide');
                $('#smartwizard').smartWizard("reset");
                $('#btnAddCustomerClaimNext').prop('disabled', false);
                $("#divEmailId").attr('style', 'border: none');
            }

            $("#iBtnAddCustomerClaimIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddCustomerClaim").removeAttr('disabled');
            $("#iBtnAddCustomerClaimIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            console.log('data ',data);
            console.log('xhr ',xhr);
            console.log('status ',status);
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddWorkloadIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddWorkload").removeAttr('disabled');
            $("#iBtnAddWorkloadIcon").addClass('fa fa-check');
        }
    });
}


//============================== Edit/Get Customer Claim by id to edit ==============================
function GetCustomerClaimById(customerClaimId){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "get_customer_claim_by_id",
        method: "get",
        data: {
            customer_claim_id: customerClaimId
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            console.log(response);

            let formAddCustomerClaim = $('#formAddCustomerClaim');
            let customerClaim = response['customerClaim'];
            let emailRecipients = response['emailRecipients'];
            if(customerClaim.length > 0){
                $("#txtAddSection").val(customerClaim[0].section);
                $("#txtAddItemNumber").val(customerClaim[0].item_number);
                $("#txtAddControlNumber").val(customerClaim[0].pmi_control_number);
                $("#txtAddReferenceNumber").val(customerClaim[0].reference_number);
                $('select[name="quarter"]', formAddCustomerClaim).val(customerClaim[0].quarter).trigger('change');
                $('select[name="customer"]', formAddCustomerClaim).val(customerClaim[0].customer).trigger('change');
                $("#selectSenderName").val(customerClaim[0].sender_name).trigger('change');
                $('select[name="contributor"]', formAddCustomerClaim).val(customerClaim[0].contributor).trigger('change');
                $('select[name="validity"]', formAddCustomerClaim).val(customerClaim[0].validity).trigger('change');
                $('select[name="product_classification"]', formAddCustomerClaim).val(customerClaim[0].product_classification).trigger('change');
                $("#txtAddModelName").val(customerClaim[0].model_name);
                $("#txtAddModeOfDefect").val(customerClaim[0].mode_of_defect);
                $("#txtAddPONumber").val(customerClaim[0].po_number);
                $("#txtAddLotTraceability").val(customerClaim[0].lot_traceability);
                $('select[name="automotive"]', formAddCustomerClaim).val(customerClaim[0].automotive).trigger('change');
                $("#txtAddQuantity").val(customerClaim[0].quantity);
                $("#txtAddNumberOfNG").val(customerClaim[0].number_of_ng);
                $("#txtAddReturnToVendor").val(customerClaim[0].return_to_vendor);
                $('select[name="defect_category_class"]', formAddCustomerClaim).val(customerClaim[0].defect_category_class).trigger('change');
                $("#txtDateReceived").val(customerClaim[0].date_received);
                $('textarea[name="remarks"]', formAddCustomerClaim).val(customerClaim[0].remarks);

                $("#txtAddShipmentDate").val(customerClaim[0].shipment_date);
                $("#txtAddShipmentQuantity").val(customerClaim[0].shipment_quantity);

                
                
                
                // Dates checkboxes
                if(customerClaim[0].actual_date_received_claim != null){
                    $('#chkActualDateReceivedClaim').attr('checked', true);
                    console.log('chkActualDateReceivedClaim not null');

                    if($('#chkActualDateReceivedClaim').is(':checked')){
                        $('input[name="actual_date_received_claim"]', formAddCustomerClaim).val(customerClaim[0].actual_date_received_claim).trigger('change');
                        $('#txtAddActualDateReceivedOfClaim').attr('disabled', false);
                    }else{
                        console.log('chkActualDateReceivedClaim not checked');
                        $('#chkActualDateReceivedClaim').attr('checked', false);
                        $('input[name="actual_date_received_claim"]', formAddCustomerClaim).val(customerClaim[0].actual_date_received_claim).trigger('change');
                        $('#txtAddActualDateReceivedOfClaim').attr('disabled', true);
                    }
                }else{
                    console.log('chkActualDateReceivedClaim is null');
                    $('#chkActualDateReceivedClaim').attr('checked', false);
                    $('input[name="actual_date_received_claim"]', formAddCustomerClaim).val(customerClaim[0].actual_date_received_claim).trigger('change');
                    $('#txtAddActualDateReceivedOfClaim').attr('disabled', true);
                }
                
                // Dates inputs
                $("#txtAddDateReturnOfClaimSample").val(customerClaim[0].date_return_of_claim);
                $("#txtAddRequiredReply").val(customerClaim[0].required_reply);
                $("#txtAddInitialResponse").val(customerClaim[0].initial_response);
                $("#txtAddActualResponse").val(customerClaim[0].actual_response);
                $("#txtAddTurnAroundTime").val(customerClaim[0].turn_around_time);

                // Claim Status
                if(customerClaim[0].status == 0){
                    $("#spanStatus").html('<strong>OPEN</strong>');
                    $("#statusBgColor").addClass('bg-info');
                    $("#initialReportBgColor").removeClass('bg-success');
                    $("#initialReportBgColor").removeClass('bg-secondary');
                }else if(customerClaim[0].status == 1){
                    $("#spanStatus").html('<strong>CLOSED</strong>');
                    $("#statusBgColor").addClass('bg-success');
                    $("#initialReportBgColor").removeClass('bg-info');
                    $("#initialReportBgColor").removeClass('bg-secondary');
                }else{
                    $("#spanStatus").html('<strong>N/A</strong>');
                    $("#statusBgColor").addClass('bg-secondary');
                    $("#initialReportBgColor").removeClass('bg-info');
                    $("#initialReportBgColor").removeClass('bg-success');
                }
                
                // Initial Report
                if(customerClaim[0].initial_response <= customerClaim[0].required_reply){
                    $("#spanInitialReport").html('<strong>RELEASED</strong>');
                    $("#initialReportBgColor").removeClass('bg-secondary');
                    $("#initialReportBgColor").addClass('bg-success');
                }else{
                    $("#spanInitialReport").html('<strong>N/A</strong>');
                    $("#initialReportBgColor").removeClass('bg-success');
                    $("#initialReportBgColor").addClass('bg-secondary');
                }
                
                //YEC/YED Report Details
                $('#txtAddSenderName').val(customerClaim[0].yec_yed_report_name);
                $('#txtAddReportReceived').val(customerClaim[0].yec_yed_report_date);
                $('#txtReportFileName').val(customerClaim[0].yec_yed_report_file);

                //8D Report
                $('#txtAddEightDReportName').val(customerClaim[0].eight_report_name);
                $('#txtEightDReportFileName').val(customerClaim[0].eight_report_filename);

                // Final Report
                if(customerClaim[0].final_report == 1){
                    $("#spanFinalReport").html('<strong>ON TIME</strong>');
                    $("#finalReportBgColor").removeClass('bg-danger');
                    $("#finalReportBgColor").addClass('bg-success');
                    console.log('on time because final report column value is 1');
                }else if(customerClaim[0].final_report == 2){
                    $("#spanFinalReport").html('<strong>Late</strong>');
                    $("#finalReportBgColor").removeClass('bg-success');
                    $("#finalReportBgColor").addClass('bg-danger');
                    console.log('late because final report column value is 0');
                }
                else{ // if final_report column is null, then actual_response vs required_reply will be the basis
                    if(customerClaim[0].actual_response <= customerClaim[0].required_reply){
                        $("#spanFinalReport").html('<strong>ON TIME</strong>');
                        $("#finalReportBgColor").removeClass('bg-danger');
                        $("#finalReportBgColor").addClass('bg-success');
                    }else{
                        $("#spanFinalReport").html('<strong>Late</strong>');
                        $("#finalReportBgColor").removeClass('bg-success');
                        $("#finalReportBgColor").addClass('bg-danger');
                        console.log('late');
                    }
                }

                if(customerClaim[0].is_po_number_traceable == 1){
                    $("#is_po_number_traceable_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_po_number_traceable == 2){
                    $("#is_po_number_traceable_no").prop("checked", true);
                }

                
                if(customerClaim[0].is_lot_identification_match == 1){
                    $("#is_lot_identification_match_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_lot_identification_match == 2){
                    $("#is_lot_identification_match_no").prop("checked", true);
                }

                if(customerClaim[0].are_there_wip_fgs_affected == 1){
                    $("#are_there_wip_fgs_affected_yes").prop("checked", true);
                }
                else if(customerClaim[0].are_there_wip_fgs_affected == 2){
                    $("#are_there_wip_fgs_affected_no").prop("checked", true);
                }

                if(customerClaim[0].is_sorting_reworking_necessary == 1){
                    $("#is_sorting_reworking_necessary_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_sorting_reworking_necessary == 2){
                    $("#is_sorting_reworking_necessary_no").prop("checked", true);
                }

                if(customerClaim[0].is_sorting_needed == 1){
                    $("#is_sorting_needed_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_sorting_needed == 2){
                    $("#is_sorting_needed_no").prop("checked", true);
                }

                
                if(customerClaim[0].is_shipment_affected == 1){
                    $("#is_shipment_affected_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_shipment_affected == 2){
                    $("#is_shipment_affected_no").prop("checked", true);
                }

                if(customerClaim[0].are_data_needed_complete_available == 1){
                    $("#are_data_needed_complete_available_yes").prop("checked", true);
                }
                else if(customerClaim[0].are_data_needed_complete_available == 2){
                    $("#are_data_needed_complete_available_no").prop("checked", true);
                }

                if(customerClaim[0].does_customer_requests_production_record == 1){
                    $("#does_customer_requests_production_record_yes").prop("checked", true);
                }
                else if(customerClaim[0].does_customer_requests_production_record == 2){
                    $("#does_customer_requests_production_record_no").prop("checked", true);
                }

                if(customerClaim[0].are_there_clarifications_needed_to_settle == 1){
                    $("#are_there_clarifications_needed_to_settle_yes").prop("checked", true);
                }
                else if(customerClaim[0].are_there_clarifications_needed_to_settle == 2){
                    $("#are_there_clarifications_needed_to_settle_no").prop("checked", true);
                }

                if(customerClaim[0].is_actual_ng_unit_available == 1){
                    $("#is_actual_ng_unit_available_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_actual_ng_unit_available == 2){
                    $("#is_actual_ng_unit_available_no").prop("checked", true);
                }

                if(customerClaim[0].is_unit_bearing_pmi_identification_mark == 1){
                    $("#is_unit_bearing_pmi_identification_mark_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_unit_bearing_pmi_identification_mark == 2){
                    $("#is_unit_bearing_pmi_identification_mark_no").prop("checked", true);
                }

                if(customerClaim[0].is_claim_defect_identified_by_customer == 1){
                    $("#is_claim_defect_identified_by_customer_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_claim_defect_identified_by_customer == 2){
                    $("#is_claim_defect_identified_by_customer_no").prop("checked", true);
                }

                if(customerClaim[0].does_customer_requires_official_capa_report == 1){
                    $("#does_customer_requires_official_capa_report_yes").prop("checked", true);
                }
                else if(customerClaim[0].does_customer_requires_official_capa_report == 2){
                    $("#does_customer_requires_official_capa_report_no").prop("checked", true);
                }

                //REMARKS VALUES
                $("#is_po_number_traceable_remarks").val(customerClaim[0].is_po_number_traceable_remarks);
                $("#is_lot_identification_match_remarks").val(customerClaim[0].is_lot_identification_match_remarks);
                $("#are_there_wip_fgs_affected_remarks").val(customerClaim[0].are_there_wip_fgs_affected_remarks);
                $("#is_sorting_reworking_necessary_remarks").val(customerClaim[0].is_sorting_reworking_necessary_remarks);
                $("#is_sorting_needed_remarks").val(customerClaim[0].is_sorting_needed_remarks);
                $("#is_shipment_affected_remarks").val(customerClaim[0].is_shipment_affected_remarks);
                $("#are_data_needed_complete_available_remarks").val(customerClaim[0].are_data_needed_complete_available_remarks);
                $("#does_customer_requests_production_record_remarks").val(customerClaim[0].does_customer_requests_production_record_remarks);
                $("#are_there_clarifications_needed_to_settle_remarks").val(customerClaim[0].are_there_clarifications_needed_to_settle_remarks);
                $("#is_actual_ng_unit_available_remarks").val(customerClaim[0].is_actual_ng_unit_available_remarks);
                $("#is_unit_bearing_pmi_identification_mark_remarks").val(customerClaim[0].is_unit_bearing_pmi_identification_mark_remarks);
                $("#is_claim_defect_identified_by_customer_remarks").val(customerClaim[0].is_claim_defect_identified_by_customer_remarks);
                $("#does_customer_requires_official_capa_report_remarks").val(customerClaim[0].does_customer_requires_official_capa_report_remarks);



                //Email Recipient
                for(i = 0; i<emailRecipients.length; i++){
                    if(emailRecipients[i].type == 1){
                        let recipientToInfo = '<option selected value="' +emailRecipients[i]['email_recipient_id'] + '">' + emailRecipients[i]['email_recipient_info']['name'] + '</option>';
                        $('select[name="email_recipient_attention[]"]', formAddCustomerClaim).append(recipientToInfo);  
                    }
                    else if(emailRecipients[i].type == 2){
                        let recipientCCInfo = '<option selected value="' +emailRecipients[i]['email_recipient_id'] + '">' + emailRecipients[i]['email_recipient_info']['name'] + '</option>';
                        $('select[name="email_recipient_cc[]"]', formAddCustomerClaim).append(recipientCCInfo);  
                        
                    }
                }
                console.log('emailRecipients', emailRecipients);

            }
            else{
                toastr.warning('No Claim records found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}


//============================== Get Customer Claim for viewing only ==============================
function GetCustomerClaimByIdForViewing(customerClaimId){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "get_customer_claim_view_by_id",
        method: "get",
        data: {
            view_customer_claim_id: customerClaimId
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            console.log(response);
            let formViewCustomerClaim = $('#formViewCustomerClaim');
            let customerClaim = response['customerClaim'];
            if(customerClaim.length > 0){
                $("#txtViewSection").val(customerClaim[0].section);
                $("#txtViewItemNumber").val(customerClaim[0].item_number);
                $("#txtViewControlNumber").val(customerClaim[0].pmi_control_number);
                $("#txtViewReferenceNumber").val(customerClaim[0].reference_number);
                $('#viewSelectQuarter').val(customerClaim[0].quarter).trigger('change');
                $('#selectViewCustomer').val(customerClaim[0].customer).trigger('change');
                $("#selectSenderName").val(customerClaim[0].sender_name);
                $('#viewSelectContributor').val(customerClaim[0].contributor).trigger('change');
                $('#viewSelectValidity').val(customerClaim[0].validity).trigger('change');
                $('#viewSelectProductClassification').val(customerClaim[0].product_classification).trigger('change');
                $("#txtViewModelName").val(customerClaim[0].model_name);
                $("#txtViewModeOfDefect").val(customerClaim[0].mode_of_defect);
                $("#txtViewPONumber").val(customerClaim[0].po_number);
                $('#viewSelectAutomotive').val(customerClaim[0].automotive).trigger('change');
                $("#txtViewQuantity").val(customerClaim[0].quantity);

                $("#txtViewLotTraceability").val(customerClaim[0].lot_traceability);

                
                $("#txtViewShipmentQuantity").val(customerClaim[0].shipment_quantity);

                $("#txtViewNumberOfNG").val(customerClaim[0].number_of_ng);
                $("#txtViewReturnToVendor").val(customerClaim[0].return_to_vendor);
                $('#viewSelectDefectCategoryClass').val(customerClaim[0].defect_category_class).trigger('change');
                $("#txtViewDateReceived").val(customerClaim[0].date_received);
                $('#txtViewActualDateReceivedOfClaim').val(customerClaim[0].actual_date_received_claim).trigger('change');

                

                $("#txtViewDateReturnOfClaimSample").val(customerClaim[0].date_return_of_claim);
                $("#txtViewRequiredReply").val(customerClaim[0].required_reply);
                $("#txtViewInitialResponse").val(customerClaim[0].initial_response);
                $("#txtViewActualResponse").val(customerClaim[0].actual_response);
                $("#txtViewTurnAroundTime").val(customerClaim[0].turn_around_time);

                $("#txtViewShipmentDate").val(customerClaim[0].shipment_date);


                // Final Report
                if(customerClaim[0].final_report == 1){
                    $("#spanViewFinalReport").html('<strong>ON TIME</strong>');
                    $("#finalViewReportBgColor").removeClass('bg-danger');
                    $("#finalViewReportBgColor").addClass('bg-success');
                    console.log('on time because final report column value is 1');
                }else if(customerClaim[0].final_report == 2){
                    $("#spanViewFinalReport").html('<strong>Late</strong>');
                    $("#finalViewReportBgColor").removeClass('bg-success');
                    $("#finalViewReportBgColor").addClass('bg-danger');
                    console.log('late because final report column value is 0');
                }
                else{ // if final_report column is null, then actual_response vs required_reply will be the basis
                    if(customerClaim[0].actual_response <= customerClaim[0].required_reply){
                        $("#spanViewFinalReport").html('<strong>ON TIME</strong>');
                        $("#finalViewReportBgColor").removeClass('bg-danger');
                        $("#finalViewReportBgColor").addClass('bg-success');
                    }else{
                        $("#spanViewFinalReport").html('<strong>Late</strong>');
                        $("#finalViewReportBgColor").removeClass('bg-success');
                        $("#finalViewReportBgColor").addClass('bg-danger');
                        console.log('late');
                    }
                }

                 // Claim Status
                 if(customerClaim[0].status == 0){
                    $("#spanViewStatus").html('<strong>OPEN</strong>');
                    $("#statusViewBgColor").addClass('bg-info');
                    $("#initialViewReportBgColor").removeClass('bg-success');
                    $("#initialViewReportBgColor").removeClass('bg-secondary');
                }else if(customerClaim[0].status == 1){
                    $("#spanViewStatus").html('<strong>CLOSED</strong>');
                    $("#statusViewBgColor").addClass('bg-success');
                    $("#initialViewReportBgColor").removeClass('bg-info');
                    $("#initialViewReportBgColor").removeClass('bg-secondary');
                }else{
                    $("#spanViewStatus").html('<strong>N/A</strong>');
                    $("#statusViewBgColor").addClass('bg-secondary');
                    $("#initialViewReportBgColor").removeClass('bg-info');
                    $("#initialViewReportBgColor").removeClass('bg-success');
                }
                
                // Initial Report
                if(customerClaim[0].initial_response <= customerClaim[0].required_reply){
                    $("#spanViewInitialReport").html('<strong>RELEASED</strong>');
                    $("#initialViewReportBgColor").removeClass('bg-secondary');
                    $("#initialViewReportBgColor").addClass('bg-success');
                }else{
                    $("#spanViewInitialReport").html('<strong>N/A</strong>');
                    $("#initialViewReportBgColor").removeClass('bg-success');
                    $("#initialViewReportBgColor").addClass('bg-secondary');
                }

                //YEC/YED Report Receive (E-mail)
                $("#txtViewSenderName").val(customerClaim[0].yec_yed_report_name);
                $("#txtViewReportReceived").val(customerClaim[0].yec_yed_report_date);
                $("#txtViewReportFileName").val(customerClaim[0].yec_yed_report_file);
                
                //8D Report
                $("#txtViewEightDReportName").val(customerClaim[0].eight_report_name);
                $("#txtViewEightDReportFileName").val(customerClaim[0].eight_report_filename);
                
                if(customerClaim[0].is_po_number_traceable == 1){
                    $("#view_is_po_number_traceable_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_po_number_traceable == 2){
                    $("#view_is_po_number_traceable_no").prop("checked", true);
                }

                
                if(customerClaim[0].is_lot_identification_match == 1){
                    $("#view_is_lot_identification_match_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_lot_identification_match == 2){
                    $("#view_is_lot_identification_match_no").prop("checked", true);
                }

                if(customerClaim[0].are_there_wip_fgs_affected == 1){
                    $("#view_are_there_wip_fgs_affected_yes").prop("checked", true);
                }
                else if(customerClaim[0].are_there_wip_fgs_affected == 2){
                    $("#view_are_there_wip_fgs_affected_no").prop("checked", true);
                }

                if(customerClaim[0].is_sorting_reworking_necessary == 1){
                    $("#view_is_sorting_reworking_necessary_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_sorting_reworking_necessary == 2){
                    $("#view_is_sorting_reworking_necessary_no").prop("checked", true);
                }

                if(customerClaim[0].is_sorting_needed == 1){
                    $("#view_is_sorting_needed_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_sorting_needed == 2){
                    $("#view_is_sorting_needed_no").prop("checked", true);
                }

                
                if(customerClaim[0].is_shipment_affected == 1){
                    $("#view_is_shipment_affected_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_shipment_affected == 2){
                    $("#view_is_shipment_affected_no").prop("checked", true);
                }

                if(customerClaim[0].are_data_needed_complete_available == 1){
                    $("#view_are_data_needed_complete_available_yes").prop("checked", true);
                }
                else if(customerClaim[0].are_data_needed_complete_available == 2){
                    $("#view_are_data_needed_complete_available_no").prop("checked", true);
                }

                if(customerClaim[0].does_customer_requests_production_record == 1){
                    $("#view_does_customer_requests_production_record_yes").prop("checked", true);
                }
                else if(customerClaim[0].does_customer_requests_production_record == 2){
                    $("#view_does_customer_requests_production_record_no").prop("checked", true);
                }

                if(customerClaim[0].are_there_clarifications_needed_to_settle == 1){
                    $("#view_are_there_clarifications_needed_to_settle_yes").prop("checked", true);
                }
                else if(customerClaim[0].are_there_clarifications_needed_to_settle == 2){
                    $("#view_are_there_clarifications_needed_to_settle_no").prop("checked", true);
                }

                if(customerClaim[0].is_actual_ng_unit_available == 1){
                    $("#view_is_actual_ng_unit_available_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_actual_ng_unit_available == 2){
                    $("#view_is_actual_ng_unit_available_no").prop("checked", true);
                }

                if(customerClaim[0].is_unit_bearing_pmi_identification_mark == 1){
                    $("#view_is_unit_bearing_pmi_identification_mark_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_unit_bearing_pmi_identification_mark == 2){
                    $("#view_is_unit_bearing_pmi_identification_mark_no").prop("checked", true);
                }

                if(customerClaim[0].is_claim_defect_identified_by_customer == 1){
                    $("#view_is_claim_defect_identified_by_customer_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_claim_defect_identified_by_customer == 2){
                    $("#view_is_claim_defect_identified_by_customer_no").prop("checked", true);
                }

                if(customerClaim[0].does_customer_requires_official_capa_report == 1){
                    $("#view_does_customer_requires_official_capa_report_yes").prop("checked", true);
                }
                else if(customerClaim[0].does_customer_requires_official_capa_report == 2){
                    $("#view_does_customer_requires_official_capa_report_no").prop("checked", true);
                }

                //REMARKS VALUES
                $("#view_is_po_number_traceable_remarks").val(customerClaim[0].is_po_number_traceable_remarks);
                $("#view_is_lot_identification_match_remarks").val(customerClaim[0].is_lot_identification_match_remarks);
                $("#view_are_there_wip_fgs_affected_remarks").val(customerClaim[0].are_there_wip_fgs_affected_remarks);
                $("#view_is_sorting_reworking_necessary_remarks").val(customerClaim[0].is_sorting_reworking_necessary_remarks);
                $("#view_is_sorting_needed_remarks").val(customerClaim[0].is_sorting_needed_remarks);
                $("#view_is_shipment_affected_remarks").val(customerClaim[0].is_shipment_affected_remarks);
                $("#view_are_data_needed_complete_available_remarks").val(customerClaim[0].are_data_needed_complete_available_remarks);
                $("#view_does_customer_requests_production_record_remarks").val(customerClaim[0].does_customer_requests_production_record_remarks);
                $("#view_are_there_clarifications_needed_to_settle_remarks").val(customerClaim[0].are_there_clarifications_needed_to_settle_remarks);
                $("#view_is_actual_ng_unit_available_remarks").val(customerClaim[0].is_actual_ng_unit_available_remarks);
                $("#view_is_unit_bearing_pmi_identification_mark_remarks").val(customerClaim[0].is_unit_bearing_pmi_identification_mark_remarks);
                $("#view_is_claim_defect_identified_by_customer_remarks").val(customerClaim[0].is_claim_defect_identified_by_customer_remarks);
                $("#view_does_customer_requires_official_capa_report_remarks").val(customerClaim[0].does_customer_requires_official_capa_report_remarks);

                /*
                    Claim Validation & Remarks
                */
                if(customerClaim[0].is_the_defect_ng_based_on_specs == 1){
                    $("#is_the_defect_ng_based_on_specs_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_the_defect_ng_based_on_specs == 2){
                    $("#is_the_defect_ng_based_on_specs_no").prop("checked", true);
                }

                if(customerClaim[0].is_defect_included_in_pmi == 1){
                    $("#is_defect_included_in_pmi_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_defect_included_in_pmi == 2){
                    $("#is_defect_included_in_pmi_no").prop("checked", true);
                }

                if(customerClaim[0].is_defect_detectable_at_pmi == 1){
                    $("#is_defect_detectable_at_pmi_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_defect_detectable_at_pmi == 2){
                    $("#is_defect_detectable_at_pmi_no").prop("checked", true);
                }

                if(customerClaim[0].is_unit_undergone_customer_assembly_process == 1){
                    $("#is_unit_undergone_customer_assembly_process_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_unit_undergone_customer_assembly_process == 2){
                    $("#is_unit_undergone_customer_assembly_process_no").prop("checked", true);
                }

                if(customerClaim[0].is_defect_contributed_by_pmi == 1){
                    $("#is_defect_contributed_by_pmi_yes").prop("checked", true);
                }
                else if(customerClaim[0].is_defect_contributed_by_pmi == 2){
                    $("#is_defect_contributed_by_pmi_no").prop("checked", true);
                }

                $("#is_the_defect_ng_based_on_specs_remarks").val(customerClaim[0].is_the_defect_ng_based_on_specs_remarks);
                $("#is_defect_included_in_pmi_remarks").val(customerClaim[0].is_defect_included_in_pmi_remarks);
                $("#is_defect_detectable_at_pmi_remarks").val(customerClaim[0].is_defect_detectable_at_pmi_remarks);
                $("#is_unit_undergone_customer_assembly_process_remarks").val(customerClaim[0].is_unit_undergone_customer_assembly_process_remarks);
                $("#is_defect_contributed_by_pmi_remarks").val(customerClaim[0].is_defect_contributed_by_pmi_remarks);
            }
            else{
                toastr.warning('No claim records found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}


//============================== EDIT WORKLOAD ==============================
function EditWorkload(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    let formData = new FormData($('#formEditWorkload')[0]);

    $.ajax({
        url: "edit_workload",
        method: "post",
        processData: false,
        contentType: false,
        data: formData,
        dataType: "json",
        beforeSend: function(){
            $("#iBtnEditWorkloadIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditWorkload").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Updating workload failed!');

                if(response['error']['name'] === undefined){
                    $("#txtEditWorkloadName").removeClass('is-invalid');
                    $("#txtEditWorkloadName").attr('title', '');
                }
                else{
                    $("#txtEditWorkloadName").addClass('is-invalid');
                    $("#txtEditWorkloadName").attr('title', response['error']['name']);
                }

                if(response['error']['work_instruction_title'] === undefined){
                    $("#txtEditWorkloadWorkInstructionTitle").removeClass('is-invalid');
                    $("#txtEditWorkloadWorkInstructionTitle").attr('title', '');
                }
                else{
                    $("#txtEditWorkloadWorkInstructionTitle").addClass('is-invalid');
                    $("#txtEditWorkloadWorkInstructionTitle").attr('title', response['error']['work_instruction_title']);
                }

                if(response['error']['description'] === undefined){
                    $("#txtEditWorkloadDescription").removeClass('is-invalid');
                    $("#txtEditWorkloadDescription").attr('title', '');
                }
                else{
                    $("#txtEditWorkloadDescription").addClass('is-invalid');
                    $("#txtEditWorkloadDescription").attr('title', response['error']['description']);
                }
            }else if(response['result'] == 1){
                toastr.success('Workload was succesfully updated!');
                $("#modalEditWorkload").modal('hide'); // hide modal
                dataTableWorkloads.draw(); // reload the datatables after the update operation
                dataTablePendingWorkloads.draw(); // reload the datatables after the update operation

                // reset the formEditWorkload values including checkbox, showing/hiding input file/text, disabled fields and remove error border
                resetFormValues();
                $("#formEditWorkload")[0].reset();
                $('#chkEditFile').removeAttr('checked'); // uncheck the Edit Attachment
                
                // check if the #chkEditFile(checkbox) has no attribute checked then hide then fileEditWorkloadFile(input type file) and show txtEditWorkloadFile(input type text)
                var chkEditFile = $('#chkEditFile').attr('checked');
                if (typeof chkEditFile === 'undefined' || chkEditFile === false) {
                    $('#fileEditWorkloadFile').addClass('d-none')
                    $('#txtEditWorkloadFile').removeClass('d-none');
                }
            }else if(response['result'] == 0){
                toastr.success("Workload was succesfully updated!" + ' ' + "<span class='text-danger'>Note that there is no file was uploaded</span>");
                $("#modalEditWorkload").modal('hide'); // hide modal
                dataTableWorkloads.draw(); // reload the datatables after the update operation
                dataTablePendingWorkloads.draw(); // reload the datatables after the update operation
                
                // reset the formEditWorkload values including checkbox, showing/hiding input file/text, disabled fields and remove error border
                resetModalValue(); 
                $("#formEditWorkload")[0].reset();
                $('#chkEditFile').removeAttr('checked'); // uncheck the Edit Attachment
                
                // check if the #chkEditFile(checkbox) has no attribute checked then hide then fileEditWorkloadFile(input type file) and show txtEditWorkloadFile(input type text)
                var chkEditFile = $('#chkEditFile').attr('checked');
                if (typeof chkEditFile === 'undefined' || chkEditFile === false) {
                    $('#fileEditWorkloadFile').addClass('d-none');
                    $('#txtEditWorkloadFile').removeClass('d-none');
                }
            }
            $("#iBtnEditWorkloadIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditWorkload").removeAttr('disabled');
            $("#iBtnEditWorkloadIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnEditWorkloadIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditWorkload").removeAttr('disabled');
            $("#iBtnEditWorkloadIcon").addClass('fa fa-check');
        }
    });

    
}

function getClaimControlNumber(section){
    $.ajax({
        url: "get_customer_claim_control_number",
        method: "get",
        dataType: "json",
        success: function(response){
            let controlNumber = `CC-${response['combine_month_day']}-${response['control_counter']}-${section}`;
            $('#txtAddControlNumber').val(controlNumber);
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            // $("#iBtnEditWorkloadIcon").removeClass('fa fa-spinner fa-pulse');
            // $("#btnEditWorkload").removeAttr('disabled');
            // $("#iBtnEditWorkloadIcon").addClass('fa fa-check');
        }
    });
}


//============================== Get Submitted 8D Report ==============================
// function ApprovedSubmittedEightDReport(customerClaimId){
//     toastr.options = {
//         "closeButton": false,
//         "debug": false,
//         "newestOnTop": true,
//         "progressBar": true,
//         "positionClass": "toast-top-right",
//         "preventDuplicates": false,
//         "onclick": null,
//         "showDuration": "300",
//         "hideDuration": "3000",
//         "timeOut": "3000",
//         "extendedTimeOut": "3000",
//         "showEasing": "swing",
//         "hideEasing": "linear",
//         "showMethod": "fadeIn",
//         "hideMethod": "fadeOut",
//     };

//     $.ajax({
//         url: "approved_submitted_eight_d_report",
//         method: "post",
//         data: {
//             customer_claim_id: customerClaimId
//         },
//         dataType: "json",
//         beforeSend: function(){
//         },
//         success: function(response){
//             console.log(response);
//             // let formValidateEightDReport = $('#formValidateEightDReport');
//             // let submittedEightDReport = response['submittedEightDReport'];
//             // $('#txtEightDReportFileName', formValidateEightDReport).val(submittedEightDReport.operation_eight_d_report_name);
//             // $('#txtEightDReportFile', formValidateEightDReport).attr("href", 'download_eight_d_report_file/'+submittedEightDReport.id);
//             // $('#spanEightDReportFile', formValidateEightDReport).text(submittedEightDReport.operation_eight_d_report_filename);
//             // $('#txtEightDReportDate', formValidateEightDReport).val(submittedEightDReport.operation_eight_d_report_date);
//             // $('#txtEightDReportSender', formValidateEightDReport).val(submittedEightDReport.operation_sender_name);
//         },
//         error: function(data, xhr, status){
//             toastr.error('An error occured!\n' + 'Data: ' + data.status + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
//         },
//     });
// }

// function DownloadEmailCnAttachement(id){
//     $.ajax({
//         url: "download_cn_attachment",
//         method: "get",
//         // processData: false,
//         // contentType: false,
//         data: {
//             id : id,
//         },
//         dataType: "json",
//         beforeSend: function(){
//             // $("#iBtnEditWorkloadIcon").addClass('fa fa-spinner fa-pulse');
//             // $("#btnEditWorkload").prop('disabled', 'disabled');
//         },
//         success: function(response){
           
//         },
//         error: function(data, xhr, status){
//             toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
//             // $("#iBtnEditWorkloadIcon").removeClass('fa fa-spinner fa-pulse');
//             // $("#btnEditWorkload").removeAttr('disabled');
//             // $("#iBtnEditWorkloadIcon").addClass('fa fa-check');
//         }
//     });

// }
// function exportChecksheet(id){
//     // console.log(id);
//         $.ajax({
//         url: "export",
//         method: "get",
//         data: {
//             id : id,
//         },
//         dataType: "json",
     
//         success: function(response){
           
//         },
       
//     });
// }


function getFilterCustomerId(cboElement){
	let result = '<option value="0" disabled selected>Select One</option>';

    $.ajax({
        url: "get_customer_for_filter",
        method: "get",
        dataType: "json",
        beforeSend: function(){
            result = '<option value="0" disabled>Loading</option>';
			cboElement.html(result);
        },
        success: function(response){
            // console.log(response);
            if(response['result'].length > 0){
				result = '<option value="0" disabled selected>Select One</option>';
				for(let index = 0; index < response['result'].length; index++){
                    result += '<option value="' + response['result'][index].id + '">' + response['result'][index].customer_name + '</option>';
				}
			}
			else{
				result = '<option value="0" disabled></option>';
			}
			cboElement.html(result);
        },
    });

}
function getFilterProductClassification(cboElement){
    let result = '<option value="0" disabled selected>Select One</option>';

    $.ajax({
        url: "get_product_classification_for_filter",
        method: "get",
        dataType: "json",
        beforeSend: function(){
            result = '<option value="0" disabled>Loading</option>';
			cboElement.html(result);
        },
        success: function(response){
            // console.log(response);
            if(response['result'].length > 0){
				result = '<option value="0" disabled selected>Select One</option>';
				for(let index = 0; index < response['result'].length; index++){
                    result += '<option value="' + response['result'][index].id + '">' + response['result'][index].product_name + '</option>';
				}
			}
			else{
				result = '<option value="0" disabled></option>';
			}
			cboElement.html(result);
        },
    });
}


