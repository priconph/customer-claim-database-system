//============================== Edit/Get Customer Claim by id to edit ==============================
function GetEightDReportById(customerClaimId){
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
        url: "get_eight_d_report_by_id",
        method: "get",
        data: {
            customer_claim_id: customerClaimId
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let customerClaim = response['customerClaim'];
            let eightDReportRootCauseAction = response['eightDReportRootCauseAction'];
            // console.log('customerClaim response ',customerClaim);
            console.log('eightDReportRootCauseAction response ',eightDReportRootCauseAction);
            if(customerClaim.length > 0){
                $("#txtViewSection").val(customerClaim[0].section);
                $("#txtViewItemNumber").val(customerClaim[0].item_number);
                $("#txtViewControlNumber").val(customerClaim[0].pmi_control_number);
                $("#txtViewReferenceNumber").val(customerClaim[0].reference_number);
                $('#viewSelectQuarter').val(customerClaim[0].quarter).trigger('change');
                $('#viewSelectCustomer').val(customerClaim[0].customer).trigger('change');
                $("#viewSelectSenderName").val(customerClaim[0].sender_name).trigger('change');
                $('#viewSelectContributor').val(customerClaim[0].contributor).trigger('change');
                $('#viewSelectValidity').val(customerClaim[0].validity).trigger('change');
                $('#viewSelectProductClassification').val(customerClaim[0].product_classification).trigger('change');
                $("#txtViewModelName").val(customerClaim[0].model_name);
                $("#txtViewModeOfDefect").val(customerClaim[0].mode_of_defect);
                $("#txtViewPONumber").val(customerClaim[0].po_number);
                $('#viewSelectAutomotive').val(customerClaim[0].automotive).trigger('change');
                $("#txtViewQuantity").val(customerClaim[0].quantity);
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

                /*
                    Final Report
                */
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

                /*
                    Claim Status
                */
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
                
                /*
                    Initial Report
                */
                if(customerClaim[0].initial_response <= customerClaim[0].required_reply){
                    $("#spanViewInitialReport").html('<strong>RELEASED</strong>');
                    $("#initialViewReportBgColor").removeClass('bg-secondary');
                    $("#initialViewReportBgColor").addClass('bg-success');
                }else{
                    $("#spanViewInitialReport").html('<strong>N/A</strong>');
                    $("#initialViewReportBgColor").removeClass('bg-success');
                    $("#initialViewReportBgColor").addClass('bg-secondary');
                }

                /*
                    YEC/YED Report Receive (E-mail)
                */
                $("#txtViewSenderName").val(customerClaim[0].yec_yed_report_name);
                $("#txtViewReportReceived").val(customerClaim[0].yec_yed_report_date);
                $("#txtViewReportFileName").val(customerClaim[0].yec_yed_report_file);
                
                /*
                    8D Report
                */
                $("#txtViewEightDReportName").val(customerClaim[0].eight_report_name);
                $("#txtViewEightDReportFileName").val(customerClaim[0].eight_report_filename);
                let eightDReportRevision = response['eightDReportRevision'];
                console.log('eightDReportRevision ',eightDReportRevision);
                $('#totalRevision').text(eightDReportRevision);
                
                // Re-upload of 8D Report(enabling/disabling)
                if(customerClaim[0].operation_eight_d_report_filename == null){
                    $("#txtEightDReportFileName").prop('readonly', false);
                    $("#divFileEightDReportFile").removeClass('d-none');
                    $("#divTxtEightDReportFile").addClass('d-none');
                    $("#divCheckboxEightDReport").addClass('d-none');
                }else{
                    $("#txtEightDReportFileName").prop('readonly', true);
                    $("#divFileEightDReportFile").addClass('d-none');
                    $("#divTxtEightDReportFile").removeClass('d-none');
                    $("#divCheckboxEightDReport").removeClass('d-none');
                }


                /*
                    Data Verification & Unit Verification
                */
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


                // Remarks VALUES
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


                if($("input[type='edit_data']").val() != 0){
                    //============================= Root Cause Action =============================
                    let rootCauseActionCounterArr = [];
                    for (let index = 0; index < customerClaim[0]['eight_d_report_details'].length; index++) {
                        // console.table(customerClaim[0]['eight_d_report_details'][index].action_code)
                        if(customerClaim[0]['eight_d_report_details'][index].action_code == 1){
                            // console.log(customerClaim[0]['eight_d_report_details'][index].action_code);
                            rootCauseActionCounterArr.push(customerClaim[0]['eight_d_report_details'][index]);
                        }
                    }
                    // console.table(rootCauseActionCounterArr);

                    if(rootCauseActionCounterArr.length > 0){
                        // Reset values
                        // $('.generatedDivHeader').remove();
                        // $('#divRootCauseAction').find('.generatedDiv').remove();
                        // $('#root_cause_action_counter').val(1);

                        $('#root_cause_date').val(rootCauseActionCounterArr[0].date).trigger('change');
                        $('#root_cause_in_charge').val(rootCauseActionCounterArr[0].person_incharge).trigger('change');
                        $('#root_cause_corrective_action').val(rootCauseActionCounterArr[0].corrective_action).trigger('change');
                        $('#root_cause_remarks').val(rootCauseActionCounterArr[0].remarks).trigger('change');

                        for (let j = 1; j < rootCauseActionCounterArr.length; j++) { // Access the 2nd index in rootCauseActionCounterArr. Sample: [1, 2, 3] so start at 2
                            let rootCauseActionCounter = rootCauseActionCounterArr; // counter
                            if(rootCauseActionCounter.length > 1){
                                $('#remove_row_root_cause_action').removeClass('d-none');
                            }

                            var html =  '     <div class="divHeader_'+rootCauseActionCounter[j].action_counter+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ rootCauseActionCounter[j].action_counter +'.</span></h6></div>';
                                html += '	  <div class="row mt-2 generatedDiv" id="row_'+ rootCauseActionCounter[j].action_counter +'">';
                                html += '       <div class="col-md-6">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                                html += '               </div>';
                                html += '               <input type="date" class="form-control form-control-sm" id="root_cause_date_'+rootCauseActionCounter[j].action_counter+'" name="root_cause_date_'+rootCauseActionCounter[j].action_counter+'" placeholder="required">';
                                html += '           </div>';
                                html += '       </div>';
                                
                                html += '       <div class="col-md-6" id="row_'+rootCauseActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 40%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                                html += '               </div>';
                                html += '               <input type="text" class="form-control form-control-sm" id="root_cause_in_charge_'+rootCauseActionCounter[j].action_counter+'" name="root_cause_in_charge_'+rootCauseActionCounter[j].action_counter+'" placeholder="required">';
                                html += '           </div>';
                                html += '       </div>';

                                html += '       <div class="col-md-12" id="row_'+rootCauseActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                                html += '               </div>';
                                html += '               <textarea class="form-control form-control-sm" id="root_cause_corrective_action_'+rootCauseActionCounter[j].action_counter+'" name="root_cause_corrective_action_'+rootCauseActionCounter[j].action_counter+'" placeholder="required"></textarea>';
                                html += '           </div>';
                                html += '       </div>';

                                html += '       <div class="col-md-12" id="row_'+rootCauseActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                                html += '               </div>';
                                html += '               <textarea class="form-control form-control-sm" rows="2" id="root_cause_remarks_'+rootCauseActionCounter[j].action_counter+'" name="root_cause_remarks_'+rootCauseActionCounter[j].action_counter+'" placeholder="required"></textarea>';
                                html += '           </div>';
                                html += '       </div>';
                                html += '   </div>';
                            $('#root_cause_action_counter').val(rootCauseActionCounter.length);
                            $('#divRootCauseAction').append(html);
                            $('#root_cause_date_'+rootCauseActionCounter[j].action_counter).val(rootCauseActionCounter[j].date).trigger('change');
                            $('#root_cause_in_charge_'+rootCauseActionCounter[j].action_counter).val(rootCauseActionCounter[j].person_incharge).trigger('change');
                            $('#root_cause_corrective_action_'+rootCauseActionCounter[j].action_counter).val(rootCauseActionCounter[j].corrective_action).trigger('change');
                            $('#root_cause_remarks_'+rootCauseActionCounter[j].action_counter).val(rootCauseActionCounter[j].remarks).trigger('change');
                        }
                    }


                    //============================= Escapee Cause Action =============================
                    let escapeeCauseActionCounterArr = [];
                    for (let index = 0; index < customerClaim[0]['eight_d_report_details'].length; index++) {
                        // console.table(customerClaim[0]['eight_d_report_details'][index].action_code)
                        if(customerClaim[0]['eight_d_report_details'][index].action_code == 2){
                            // console.log(customerClaim[0]['eight_d_report_details'][index].action_code);
                            escapeeCauseActionCounterArr.push(customerClaim[0]['eight_d_report_details'][index]);
                        }
                    }
                    // console.table(escapeeCauseActionCounterArr);

                    if(escapeeCauseActionCounterArr.length > 0){
                        $('#escapee_cause_date').val(escapeeCauseActionCounterArr[0].date).trigger('change');
                        $('#escapee_cause_in_charge').val(escapeeCauseActionCounterArr[0].person_incharge).trigger('change');
                        $('#escapee_cause_corrective_action').val(escapeeCauseActionCounterArr[0].corrective_action).trigger('change');
                        $('#escapee_cause_remarks').val(escapeeCauseActionCounterArr[0].remarks).trigger('change');

                        for (let j = 1; j < escapeeCauseActionCounterArr.length; j++) { // Access the 2nd index in escapeeCauseActionCounterArr. Sample: [1, 2, 3] so start at 2
                            let escapeeCauseActionCounter = escapeeCauseActionCounterArr; // counter
                            if(escapeeCauseActionCounter.length > 1){
                                $('#remove_row_escapee_cause_action').removeClass('d-none');
                            }

                            var html =  '     <div class="divHeader_'+escapeeCauseActionCounter[j].action_counter+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ escapeeCauseActionCounter[j].action_counter +'.</span></h6></div>';
                                html += '	  <div class="row mt-2 generatedDiv" id="row_'+ escapeeCauseActionCounter[j].action_counter +'">';
                                html += '       <div class="col-md-6">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                                html += '               </div>';
                                html += '               <input type="date" class="form-control form-control-sm" id="escapee_cause_date_'+escapeeCauseActionCounter[j].action_counter+'" name="escapee_cause_date_'+escapeeCauseActionCounter[j].action_counter+'" placeholder="required">';
                                html += '           </div>';
                                html += '       </div>';
                                
                                html += '       <div class="col-md-6" id="row_'+escapeeCauseActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 40%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                                html += '               </div>';
                                html += '               <input type="text" class="form-control form-control-sm" id="escapee_cause_in_charge_'+escapeeCauseActionCounter[j].action_counter+'" name="escapee_cause_in_charge_'+escapeeCauseActionCounter[j].action_counter+'" placeholder="required">';
                                html += '           </div>';
                                html += '       </div>';

                                html += '       <div class="col-md-12" id="row_'+escapeeCauseActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                                html += '               </div>';
                                html += '               <textarea class="form-control form-control-sm" id="escapee_cause_corrective_action_'+escapeeCauseActionCounter[j].action_counter+'" name="escapee_cause_corrective_action_'+escapeeCauseActionCounter[j].action_counter+'" placeholder="required"></textarea>';
                                html += '           </div>';
                                html += '       </div>';

                                html += '       <div class="col-md-12" id="row_'+escapeeCauseActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                                html += '               </div>';
                                html += '               <textarea class="form-control form-control-sm" rows="2" id="escapee_cause_remarks_'+escapeeCauseActionCounter[j].action_counter+'" name="escapee_cause_remarks_'+escapeeCauseActionCounter[j].action_counter+'" placeholder="required"></textarea>';
                                html += '           </div>';
                                html += '       </div>';
                                html += '   </div>';
                            $('#escapee_cause_action_counter').val(escapeeCauseActionCounter.length);
                            $('#divEscapeeCauseAction').append(html);
                            $('#escapee_cause_date_'+escapeeCauseActionCounter[j].action_counter).val(escapeeCauseActionCounter[j].date).trigger('change');
                            $('#escapee_cause_in_charge_'+escapeeCauseActionCounter[j].action_counter).val(escapeeCauseActionCounter[j].person_incharge).trigger('change');
                            $('#escapee_cause_corrective_action_'+escapeeCauseActionCounter[j].action_counter).val(escapeeCauseActionCounter[j].corrective_action).trigger('change');
                            $('#escapee_cause_remarks_'+escapeeCauseActionCounter[j].action_counter).val(escapeeCauseActionCounter[j].remarks).trigger('change');
                        }
                    }


                    //============================= Systemic Action =============================
                    let systemicActionCounterArr = [];
                    for (let index = 0; index < customerClaim[0]['eight_d_report_details'].length; index++) {
                        // console.table(customerClaim[0]['eight_d_report_details'][index].action_code)
                        if(customerClaim[0]['eight_d_report_details'][index].action_code == 3){
                            // console.log(customerClaim[0]['eight_d_report_details'][index].action_code);
                            systemicActionCounterArr.push(customerClaim[0]['eight_d_report_details'][index]);
                        }
                    }
                    // console.table(systemicActionCounterArr);

                    if(systemicActionCounterArr.length > 0){
                        $('#systemic_date').val(systemicActionCounterArr[0].date).trigger('change');
                        $('#systemic_in_charge').val(systemicActionCounterArr[0].person_incharge).trigger('change');
                        $('#systemic_corrective_action').val(systemicActionCounterArr[0].corrective_action).trigger('change');
                        $('#systemic_remarks').val(systemicActionCounterArr[0].remarks).trigger('change');

                        for (let j = 1; j < systemicActionCounterArr.length; j++) { // Access the 2nd index in systemicActionCounterArr. Sample: [1, 2, 3] so start at 2
                            let systemicActionCounter = systemicActionCounterArr; // counter
                            if(systemicActionCounter.length > 1){
                                $('#remove_row_systemic_action').removeClass('d-none');
                            }

                            var html =  '     <div class="divHeader_'+systemicActionCounter[j].action_counter+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ systemicActionCounter[j].action_counter +'.</span></h6></div>';
                                html += '	  <div class="row mt-2 generatedDiv" id="row_'+ systemicActionCounter[j].action_counter +'">';
                                html += '       <div class="col-md-6">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                                html += '               </div>';
                                html += '               <input type="date" class="form-control form-control-sm" id="systemic_date_'+systemicActionCounter[j].action_counter+'" name="systemic_date_'+systemicActionCounter[j].action_counter+'" placeholder="required">';
                                html += '           </div>';
                                html += '       </div>';
                                
                                html += '       <div class="col-md-6" id="row_'+systemicActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 40%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                                html += '               </div>';
                                html += '               <input type="text" class="form-control form-control-sm" id="systemic_in_charge_'+systemicActionCounter[j].action_counter+'" name="systemic_in_charge_'+systemicActionCounter[j].action_counter+'" placeholder="required">';
                                html += '           </div>';
                                html += '       </div>';

                                html += '       <div class="col-md-12" id="row_'+systemicActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                                html += '               </div>';
                                html += '               <textarea class="form-control form-control-sm" id="systemic_corrective_action_'+systemicActionCounter[j].action_counter+'" name="systemic_corrective_action_'+systemicActionCounter[j].action_counter+'" placeholder="required"></textarea>';
                                html += '           </div>';
                                html += '       </div>';

                                html += '       <div class="col-md-12" id="row_'+systemicActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                                html += '               </div>';
                                html += '               <textarea class="form-control form-control-sm" rows="2" id="systemic_remarks_'+systemicActionCounter[j].action_counter+'" name="systemic_remarks_'+systemicActionCounter[j].action_counter+'" placeholder="required"></textarea>';
                                html += '           </div>';
                                html += '       </div>';
                                html += '   </div>';
                            $('#systemic_action_counter').val(systemicActionCounter.length);
                            $('#divSystemicAction').append(html);
                            $('#systemic_date_'+systemicActionCounter[j].action_counter).val(systemicActionCounter[j].date).trigger('change');
                            $('#systemic_in_charge_'+systemicActionCounter[j].action_counter).val(systemicActionCounter[j].person_incharge).trigger('change');
                            $('#systemic_corrective_action_'+systemicActionCounter[j].action_counter).val(systemicActionCounter[j].corrective_action).trigger('change');
                            $('#systemic_remarks_'+systemicActionCounter[j].action_counter).val(systemicActionCounter[j].remarks).trigger('change');
                        }
                    }


                    //============================= Fanout Action =============================
                    let fanOutActionCounterArr = [];
                    for (let index = 0; index < customerClaim[0]['eight_d_report_fanout_details'].length; index++) {
                        fanOutActionCounterArr.push(customerClaim[0]['eight_d_report_fanout_details'][index]);
                    }
                    // console.table(fanOutActionCounterArr);

                    if(fanOutActionCounterArr.length > 0){
                        $('#fanout_due_date').val(fanOutActionCounterArr[0].due_date).trigger('change');
                        $('#fanout_product_name').val(fanOutActionCounterArr[0].product_name).trigger('change');
                        $('#fanout_in_charge').val(fanOutActionCounterArr[0].person_incharge).trigger('change');
                        $('#fanout_corrective_action').val(fanOutActionCounterArr[0].corrective_action).trigger('change');
                        $('#fanout_remarks').val(fanOutActionCounterArr[0].remarks).trigger('change');

                        for (let j = 1; j < fanOutActionCounterArr.length; j++) { // Access the 2nd index in fanOutActionCounterArr. Sample: [1, 2, 3] so start at 2
                            let fanOutActionCounter = fanOutActionCounterArr; // counter
                            if(fanOutActionCounter.length > 1){
                                $('#remove_row_fanout_action').removeClass('d-none');
                            }

                            var html =  '     <div class="divHeader_'+fanOutActionCounter[j].action_counter+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ fanOutActionCounter[j].action_counter +'.</span></h6></div>';
                                html += '	  <div class="row mt-2 generatedDiv" id="row_'+ fanOutActionCounter[j].action_counter +'">';
                                html += '       <div class="col-md-4">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                                html += '               </div>';
                                html += '               <input type="date" class="form-control form-control-sm" id="fanout_date_'+fanOutActionCounter[j].action_counter+'" name="fanout_date_'+fanOutActionCounter[j].action_counter+'" placeholder="required">';
                                html += '           </div>';
                                html += '       </div>';

                                html += '       <div class="col-md-4" id="row_'+fanOutActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 40%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Product Name</i></span>';
                                html += '               </div>';
                                html += '               <input type="text" class="form-control form-control-sm" id="fanout_product_name_'+fanOutActionCounter[j].action_counter+'" name="fanout_product_name_'+fanOutActionCounter[j].action_counter+'" placeholder="required">';
                                html += '           </div>';
                                html += '       </div>';
                                
                                html += '       <div class="col-md-4" id="row_'+fanOutActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 40%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                                html += '               </div>';
                                html += '               <input type="text" class="form-control form-control-sm" id="fanout_in_charge_'+fanOutActionCounter[j].action_counter+'" name="fanout_in_charge_'+fanOutActionCounter[j].action_counter+'" placeholder="required">';
                                html += '           </div>';
                                html += '       </div>';

                                html += '       <div class="col-md-12" id="row_'+fanOutActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                                html += '               </div>';
                                html += '               <textarea class="form-control form-control-sm" id="fanout_corrective_action_'+fanOutActionCounter[j].action_counter+'" name="fanout_corrective_action_'+fanOutActionCounter[j].action_counter+'" placeholder="required"></textarea>';
                                html += '           </div>';
                                html += '       </div>';

                                html += '       <div class="col-md-12" id="row_'+fanOutActionCounter[j].action_counter+'">';
                                html += '           <div class="input-group input-group-sm mb-3">';
                                html += '                <div class="input-group-prepend" style="width: 30%;">';
                                html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                                html += '               </div>';
                                html += '               <textarea class="form-control form-control-sm" rows="2" id="fanout_remarks_'+fanOutActionCounter[j].action_counter+'" name="fanout_remarks_'+fanOutActionCounter[j].action_counter+'" placeholder="required"></textarea>';
                                html += '           </div>';
                                html += '       </div>';
                                html += '   </div>';
                            $('#fanout_action_counter').val(fanOutActionCounter.length);
                            $('#divFanoutAction').append(html);
                            $('#fanout_due_date_'+fanOutActionCounter[j].action_counter).val(fanOutActionCounter[j].due_date).trigger('change');
                            $('#fanout_product_name_'+fanOutActionCounter[j].action_counter).val(fanOutActionCounter[j].product_name).trigger('change');
                            $('#fanout_in_charge_'+fanOutActionCounter[j].action_counter).val(fanOutActionCounter[j].person_incharge).trigger('change');
                            $('#fanout_corrective_action_'+fanOutActionCounter[j].action_counter).val(fanOutActionCounter[j].corrective_action).trigger('change');
                            $('#fanout_remarks_'+fanOutActionCounter[j].action_counter).val(fanOutActionCounter[j].remarks).trigger('change');
                        }
                    }
                }

                $("#txtEightDReportFileName").val(customerClaim[0].operation_eight_d_report_name);
                $("#txtEightDReportFile").val(customerClaim[0].operation_eight_d_report_filename);
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


//============================== Add 8D Report ==============================
function AddEightDReport(){
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

    let customer_claim_id = $("input[name='customer_claim_id'").val();
    console.log('customer_claim_id ', customer_claim_id);
    
    // let formData = {
    //     'customer_claim_id': customer_claim_id
    // };
    // formData = $.param(formData) + '&' + new FormData($('#formEightDReport')[0]);

    let formData = new FormData($('#formEightDReport')[0]);
    formData.append('customer_claim_id', customer_claim_id)
    // console.log('formData ', JSON.stringify(formData));

	$.ajax({
        url: "add_eight_d_report",
        method: "post",
        processData: false,
        contentType: false,
        data: formData,
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddEightDReportIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddEightDReport").removeAttr('disabled');
            $("#iBtnAddEightDReportIcon").addClass('fa fa-check');
        },
        success: function(response){
            console.log('response', response);
            if(response['validation'] == 'hasError'){
                toastr.error('Saving records failed! \n Please fill required fields');
                // if(response['error']['operation_eight_d_report_name'] === undefined){
                //     $("#txtEightDReportFileName").attr('style', 'border: none');
                // }
                // else{
                //     $("#txtEightDReportFileName").attr('style', 'border: 1px solid red !important');
                // }
                // if(response['error']['operation_eight_d_report_filename'] === undefined){
                //     $("#fileEightDReportFile").attr('style', 'border: none');
                // }
                // else{
                //     $("#fileEightDReportFile").attr('style', 'border: 1px solid red !important');
                // }
            }else{
                toastr.success('Succesfully saved!');
                dataTablesCustomerClaimCN.draw();
                dataTablesCustomerClaimTS.draw();
                dataTablesCustomerClaimYF.draw();
                dataTablesCustomerClaimPPS.draw();
                $('#modalEightDReport').modal('hide');
            }
        },
        error: function(data, xhr, status){
            console.log('data ',data);
            console.log('xhr ',xhr);
            console.log('status ',status);
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddEightDReportIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddEightDReport").removeAttr('disabled');
            $("#iBtnAddEightDReportIcon").addClass('fa fa-check');
        }
    });
}


//============================== Get Submitted 8D Report ==============================
function GetSubmittedEightDReportById(customerClaimId){
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
        url: "get_submitted_eight_d_report_by_id",
        method: "get",
        data: {
            customer_claim_id: customerClaimId
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            console.log(response);
            let formValidateEightDReport = $('#formValidateEightDReport');
            let submittedEightDReport = response['submittedEightDReport'];
            let eightDReportRevision = response['eightDReportRevision'];
            $('#status', formValidateEightDReport).val(submittedEightDReport.status);
            $('#txtEightDReportFileName', formValidateEightDReport).val(submittedEightDReport.operation_eight_d_report_name);
            $('#txtEightDReportFile', formValidateEightDReport).attr("href", 'download_operation_eight_d_report/'+submittedEightDReport.id);
            $('#spanEightDReportFile', formValidateEightDReport).text(submittedEightDReport.operation_eight_d_report_filename);
            $('#txtEightDReportDate', formValidateEightDReport).val(submittedEightDReport.operation_eight_d_report_date);
            $('#txtEightDReportSender', formValidateEightDReport).val(submittedEightDReport.operation_sender_name);
            $('#totalRevision', formValidateEightDReport).text(eightDReportRevision);

            if($('#status', formValidateEightDReport).val() == 1){
                $('#btnDisapprovedEightDReport').addClass('d-none');
                $('#btnApprovedEightDReport').addClass('d-none');
            }else{
                $('#btnDisapprovedEightDReport').removeClass('d-none');
                $('#btnApprovedEightDReport').removeClass('d-none');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}


function DisapprovedSubmittedEightDReport(customerClaimId){
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

    let formData = new FormData($('#formValidateEightDReport')[0]);
    formData.append('customer_claim_id',customerClaimId);
    console.log(formData);
	$.ajax({
        url: "disapproved_submitted_eight_d_report",
        method: "post",
        processData: false,
        contentType: false,
        data: formData,
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            toastr.success('Successfully disapproved!');
            $("#modalValidateEightDReport").modal('hide');
        },
        error: function(data, xhr, status){
            console.log('data ',data);
            console.log('xhr ',xhr);
            console.log('status ',status);
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnApprovedEightDReport").removeClass('fa fa-spinner fa-pulse');
            $("#btnApprovedEightDReport").removeAttr('disabled');
            $("#iBtnApprovedEightDReport").addClass('fa fa-check');
        }
    });
}


function ApprovedSubmittedEightDReport(customerClaimId){
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

    let formData = new FormData($('#formValidateEightDReport')[0]);
    formData.append('customer_claim_id',customerClaimId);
    console.log(formData);
	$.ajax({
        url: "approved_submitted_eight_d_report",
        method: "post",
        processData: false,
        contentType: false,
        data: formData,
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            toastr.success('Successfully approved!');
            dataTablesCustomerClaimCN.draw();
            dataTablesCustomerClaimTS.draw();
            dataTablesCustomerClaimYF.draw();
            dataTablesCustomerClaimPPS.draw();
            $("#modalValidateEightDReport").modal('hide');
        },
        error: function(data, xhr, status){
            console.log('data ',data);
            console.log('xhr ',xhr);
            console.log('status ',status);
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnApprovedEightDReport").removeClass('fa fa-spinner fa-pulse');
            $("#btnApprovedEightDReport").removeAttr('disabled');
            $("#iBtnApprovedEightDReport").addClass('fa fa-check');
        }
    });
}


function GetEightDReportByIdForReUpload(customerClaimId){
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
        url: "get_eight_d_report_by_id_for_reupload",
        method: "get",
        data: {
            customer_claim_id: customerClaimId
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            // console.log(response['customerClaimDetails'][0].operation_eight_d_report_name);
            if(response['customerClaimDetails'][0].operation_eight_d_report_filename != null){
                $("#txtEightDReportFileName", $('#formReUploadOperationEightDReport')).val(response['customerClaimDetails'][0].operation_eight_d_report_name);
                $("#txtEightDReportFile", $('#formReUploadOperationEightDReport')).val(response['customerClaimDetails'][0].operation_eight_d_report_filename);
                console.log('not null');
                $("#txtEightDReportFileName", $('#formReUploadOperationEightDReport')).prop('readonly', true);
                $("#txtEightDReportFile", $('#formReUploadOperationEightDReport')).prop('readonly', true);
                $("#divCheckboxEightDReport", $('#formReUploadOperationEightDReport')).removeClass('d-none');

                // $("#btnUpploadOperationEightDReport", $('#formReUploadOperationEightDReport')).removeClass('d-none');
                // $("#divTxtEightDReportFile", $('#formReUploadOperationEightDReport')).removeClass('d-none');
                // $("#divFileEightDReportFile", $('#formReUploadOperationEightDReport')).addClass('d-none');
            }else{
                console.log('null');
                $("#txtEightDReportFileName", $('#formReUploadOperationEightDReport')).removeAttr('readonly');
                $("#txtEightDReportFile", $('#formReUploadOperationEightDReport')).removeAttr('readonly');
                $("#divCheckboxEightDReport", $('#formReUploadOperationEightDReport')).addClass('d-none');

                $("#divTxtEightDReportFile", $('#formReUploadOperationEightDReport')).addClass('d-none');
                $("#divFileEightDReportFile", $('#formReUploadOperationEightDReport')).removeClass('d-none');
                // $("#btnUpploadOperationEightDReport", $('#formReUploadOperationEightDReport')).addClass('d-none');
            }
            
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function UploadOperationEightDReportForValidatedClaim(){
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

    let customer_claim_id = $("input[name='customer_claim_id'", $('#formReUploadOperationEightDReport')).val();
    console.log('customer_claim_id ', customer_claim_id);

    let formData = new FormData($('#formReUploadOperationEightDReport')[0]);
    formData.append('customer_claim_id', customer_claim_id)

    $.ajax({
        url: "upload_operation_eight_d_report_for_validated_claim",
        method: "post",
        processData: false,
        contentType: false,
        data: formData,
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Please fill required fields!');
            }else{
                if(response['result'] == '1'){
                    toastr.success('Successfully uploaded!');
                    $("#modalReUploadOperationEightDReport").modal('hide');
                }else{
                    toastr.error('Please try again!');
                    $("#modalReUploadOperationEightDReport").modal('hide');
                }
            }
            
            
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}