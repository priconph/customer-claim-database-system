<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

use Mail;
// use Illuminate\Support\Facades\Mail;
use DataTables;
use App\CustomerClaim;
use App\Holiday;
use App\CustomerClassification;
use App\EmailRecipient;
use App\CustomerClaimEmailRecipient;
use DateTime;
use App\ProductClassification;

class CustomerClaimController extends Controller
{
    //============================= Add Customer Claim =============================
    public function add_customer_claim(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        // return $data;

        // Insert
        if(!isset($request->customer_claim_id)){
            $rules = [
                'pmi_control_number'        => 'required',
                // 'reference_number'          => 'required',
                'quarter'                   => 'required',
                'customer'                  => 'required',
                // 'sender_name'               => 'required',
                'contributor'               => 'required',
                'validity'                  => 'required',
                'product_classification'    => 'required',
                'model_name'                => 'required',
                'mode_of_defect'            => 'required',
                // 'po_number'                => 'required',
                'automotive'                => 'required',
                // 'quantity'                  => 'required|max:8',
                // 'number_of_ng'              => 'required|min:8',
                // 'return_to_vendor'          => 'required',
                'defect_category_class'     => 'required',
                'date_received'             => 'required',
                // 'actual_date_received_claim'=> 'required', // optional
                // 'date_return_of_claim'         => 'required', // optional
                // 'required_reply'            => 'required', // 03-31-22
                // 'initial_response'          => 'required', // optional based on sender
                // 'actual_response'           => 'required', // optional based on sender
                // 'turn_around_time'          => 'required', // optional based on sender
                // 'email_recipient_attention' => 'required', // optional if validity is equal to information
                // 'email_recipient_cc'        => 'required', // optional if validity is equal to information
            ];

            // Add validation if validity is information 03-31-22
            if($request->validity == 2){
                $rules['required_reply'] = '';
                $rules['email_recipient_attention'] = '';
                $rules['email_recipient_cc'] = '';
            }else{
                $rules['required_reply'] = 'required';
                $rules['email_recipient_attention'] = 'required';
                $rules['email_recipient_cc'] = 'required';
            }

            // Add validation if checkbox is checked
            if(isset($request->chk_actual_date_received_claim)){
                $rules['actual_date_received_claim'] = 'required';

                // Final Report computation for final_report(column)
                if($request->chk_actual_date_received_claim <= $request->required_reply){
                    $final_report = 1; // On Time
                }else{
                    $final_report = 2; // Late
                }
            }else{
                $rules['actual_date_received_claim'] = '';

                // Final Report computation for final_report(column)
                if( $request->actual_response <= $request->required_reply){
                    $final_report = 1; // On Time
                }else{
                    $final_report = 2; // Late
                }
            }

            // Add required if chk_date_return_of_claim(checkbox) is checked
            if(isset($request->chk_date_return_of_claim)){
                $rules['date_return_of_claim'] = 'required';
            }else{
                $rules['date_return_of_claim'] = '';
            }

            if(isset($request->chk_actual_date_received_claim)){
                $rules['actual_date_received_claim'] = 'required';
            }else{
                $rules['actual_date_received_claim'] = '';
            }

            if(isset($request->chk_date_return_of_claim)){
                $rules['date_return_of_claim'] = 'required';
            }else{
                $rules['date_return_of_claim'] = '';
            }

            if(isset($request->checkbox_email_attachment)){
                $rules['yec_yed_report_name'] = 'required';
                $rules['yec_yed_report_date'] = 'required';
                $rules['yec_yed_report_file'] = 'required';
                if($request->yec_sender_name != ''){
                    $rules['yec_yed_report_name'] = '';
                }else{
                    $rules['yec_yed_report_name'] = 'required';
                }
                if($request->report_receive != ''){
                    $rules['yec_yed_report_date'] = '';
                }else{
                    $rules['yec_yed_report_date'] = 'required';
                }
                if($request->email_attachment != ''){
                    $rules['yec_yed_report_file'] = '';
                }else{
                    $rules['yec_yed_report_file'] = 'required';
                }
            }else{
                $rules['yec_yed_report_name'] = '';
                $rules['yec_yed_report_date'] = '';
                $rules['yec_yed_report_file'] = '';
            }

            if(isset($request->checkbox_eight_d_report)){
                $rules['eight_report_name'] = 'required';
                $rules['eight_report_filename'] = 'required';

                if($request->eight_d_report_name != ''){
                    $rules['eight_report_name'] = '';
                }else{
                    $rules['eight_report_name'] = 'required';
                }
                if($request->eight_d_report_file != ''){
                    $rules['eight_report_filename'] = '';
                }else{
                    $rules['eight_report_filename'] = 'required';
                }
                // $rules['eight_report_date'] = 'required';
            }else{
                $rules['eight_report_name'] = '';
                $rules['eight_report_filename'] = '';
                // $rules['eight_report_date'] = '';
            }

            // Old Code
            // if(isset($request->chk_actual_date_received_claim) && isset($request->actual_date_received_claim)){
            //     if(isset($request->actual_date_received_claim) && isset($request->required_reply)){
            //         $actualDateReceivedClaim = $request->actual_date_received_claim;
            //         $requiredReply = $request->required_reply;

            //         $actualDateReceivedClaimDiff = new DateTime($actualDateReceivedClaim);
            //         $requiredReplyDiff = new DateTime($requiredReply);

            //         $turnAroundTime = $actualDateReceivedClaimDiff->diff($requiredReplyDiff);
            //         $turnAroundTimeResult = $turnAroundTime->format('%a');
            //         $turnAroundTimeResult .= " days";
            //     }else
            //     {
            //         $turnAroundTimeResult = "0 day";
            //     }
            // }else{
            //     if(!isset($request->chk_actual_date_received_claim) && isset($request->date_received)){
            //         $dateReceived = $request->date_received;
            //         $requiredReply = $request->required_reply;

            //         $dateReceivedDiff = new DateTime($dateReceived);
            //         $requiredReplyDiff = new DateTime($requiredReply);

            //         $turnAroundTime = $dateReceivedDiff->diff($requiredReplyDiff);
            //         $turnAroundTimeResult = $turnAroundTime->format('%a');
            //         $turnAroundTimeResult .= " days";
            //     }else
            //     {
            //         $turnAroundTimeResult = "0 day";
            //     }
            // }

            // Turn Around Time computation

            // Function to get the dates between the start date and end date
            function getBetweenDates($startDate, $endDate)
            {
                $rangArray = [];

                $startDate = strtotime($startDate."+1 days");
                $endDate = strtotime($endDate);

                for (
                    $currentDate = $startDate;
                    $currentDate <= $endDate;
                    $currentDate += (86400)
                ) {

                    $date = date('Y-n-j', $currentDate);
                    $rangArray[] = $date;
                }

                return $rangArray;
            }

            $holidays = Holiday::where('logdel',0)->get();
            $holiday_full_date = array();
            foreach ($holidays as $holiday){
                $holiday_date_construct = date("Y")."-".$holiday->month."-".$holiday->day;

                array_push($holiday_full_date,$holiday_date_construct);
            }

            /**
             * If chk_actual_date_received_claim is checked(checkbox) then change the TAT computation to actual_date_received_claim else date_received nmodify operation_eight_d_report_filename eight_d_report_file
             */
            if(isset($request->chk_actual_date_received_claim) && isset($request->actual_date_received_claim)){
                if(isset($request->actual_date_received_claim) && isset($request->required_reply)){ // chk_actual_date_received_claim vs required_reply
                    $actualDateReceivedClaim = $request->actual_date_received_claim;
                    $requiredReply = $request->required_reply;

                    $dates = getBetweenDates($actualDateReceivedClaim, $requiredReply);

                    $count = 0;
                    foreach ($dates as $date){
                        $date_day = date("D", strtotime($date));

                        if(!in_array($date, $holiday_full_date)){
                            $count = $count + 1;
                        }
                        if($date_day == 'Sat' || $date_day == 'Sun'){
                            $count = $count - 1;
                        }
                    }
                    // $actualDateReceivedClaimDiff = new DateTime($actualDateReceivedClaim);
                    // $requiredReplyDiff = new DateTime($requiredReply);

                    // $turnAroundTime = $actualDateReceivedClaimDiff->diff($requiredReplyDiff);
                    // $turnAroundTimeResult = $turnAroundTime->format('%a');
                    $turnAroundTimeResult = $count." day/s";
                }else
                {
                    $turnAroundTimeResult = "0 day";
                }
            }else{
                if(!isset($request->chk_actual_date_received_claim) && isset($request->date_received)){ // date_received vs required_reply
                    $dateReceived = $request->date_received;
                    $requiredReply = $request->required_reply;

                    $dates = getBetweenDates($dateReceived, $requiredReply);

                    $count = 0;
                    $test = array();
                    foreach ($dates as $date){

                        $date_day = date("D", strtotime($date));

                        if(!in_array($date, $holiday_full_date)){
                            $count = $count + 1;
                        }
                        if($date_day == 'Sat' || $date_day == 'Sun'){
                            $count = $count - 1;
                        }

                    }
                    // $dateReceivedDiff = new DateTime($dateReceived);
                    // $requiredReplyDiff = new DateTime($requiredReply);

                    // $turnAroundTime = $dateReceivedDiff->diff($requiredReplyDiff);
                    // $turnAroundTimeResult = $turnAroundTime->format('%a');
                    $turnAroundTimeResult = $count." day/s";
                }else
                {
                    $turnAroundTimeResult = "0 day";
                }
            }

            // return $request->date_received."<br>".$request->required_reply;
            $validator = Validator::make($data, $rules);

            if($validator->passes()){
                $customer_claim_id = "";

                $insert_claim_data = [
                    'section'                   =>  $request->section,
                    'pmi_control_number'        =>  $request->pmi_control_number,
                    'reference_number'          =>  $request->reference_number,
                    'quarter'                   =>  $request->quarter,
                    'customer'                  =>  $request->customer,
                    'sender_name'               =>  $request->sender_name,
                    'contributor'               =>  $request->contributor,
                    'validity'                  =>  $request->validity,
                    'product_classification'    =>  $request->product_classification,
                    'model_name'                =>  $request->model_name,

                    'shipment_date'             =>  $request->shipment_date,
                    'shipment_quantity'         =>  $request->shipment_quantity,

                    'mode_of_defect'            =>  $request->mode_of_defect,
                    'po_number'                 =>  $request->po_number,
                    'automotive'                =>  $request->automotive,
                    'quantity'                  =>  $request->quantity,
                    'number_of_ng'              =>  $request->number_of_ng,
                    'return_to_vendor'          =>  $request->return_to_vendor,
                    'defect_category_class'     =>  $request->defect_category_class,
                    'date_received'             =>  $request->date_received,
                    'actual_date_received_claim'=>  $request->actual_date_received_claim,
                    'date_return_of_claim'      =>  $request->date_return_of_claim,
                    'required_reply'            =>  $request->required_reply,
                    'initial_response'          =>  $request->initial_response,
                    'actual_response'           =>  $request->actual_response,
                    'turn_around_time'          =>  $turnAroundTimeResult, // based on the computation at the top
                    'final_report'              =>  $final_report, // based on the computation at the top
                    'remarks'                   =>  $request->remarks, // based on the computation at the top

                    'lot_traceability'           =>  $request->lot_traceability,


                    //YEC YED Report Details
                    // 'yec_yed_report_name' => $request->yec_sender_name,
                    // 'yec_yed_report_date' => $request->report_receive,

                    //8D Report
                    // 'eight_report_name' => $request->eight_report_name,

                    // Data Verification
                    'is_po_number_traceable'                        =>  $request->is_po_number_traceable,
                    'is_po_number_traceable_remarks'                        =>  $request->is_po_number_traceable_remarks,

                    'is_lot_identification_match'                   =>  $request->is_lot_identification_match,
                    'is_lot_identification_match_remarks'                   =>  $request->is_lot_identification_match_remarks,

                    'are_there_wip_fgs_affected'                    =>  $request->are_there_wip_fgs_affected,
                    'are_there_wip_fgs_affected_remarks'                    =>  $request->are_there_wip_fgs_affected_remarks,

                    'is_sorting_reworking_necessary'                =>  $request->is_sorting_reworking_necessary,
                    'is_sorting_reworking_necessary_remarks'                =>  $request->is_sorting_reworking_necessary_remarks,

                    'is_sorting_needed'                             =>  $request->is_sorting_needed,
                    'is_sorting_needed_remarks'                             =>  $request->is_sorting_needed_remarks,

                    'is_shipment_affected'                          =>  $request->is_shipment_affected,
                    'is_shipment_affected_remarks'                          =>  $request->is_shipment_affected_remarks,

                    'are_data_needed_complete_available'            =>  $request->are_data_needed_complete_available,
                    'are_data_needed_complete_available_remarks'            =>  $request->are_data_needed_complete_available_remarks,

                    'does_customer_requests_production_record'      =>  $request->does_customer_requests_production_record,
                    'does_customer_requests_production_record_remarks'      =>  $request->does_customer_requests_production_record_remarks,

                    'are_there_clarifications_needed_to_settle'     =>  $request->are_there_clarifications_needed_to_settle,
                    'are_there_clarifications_needed_to_settle_remarks'     =>  $request->are_there_clarifications_needed_to_settle_remarks,


                    // Unit Verification
                    'is_actual_ng_unit_available'                   =>  $request->is_actual_ng_unit_available,
                    'is_actual_ng_unit_available_remarks'                   =>  $request->is_actual_ng_unit_available_remarks,

                    'is_unit_bearing_pmi_identification_mark'       =>  $request->is_unit_bearing_pmi_identification_mark,
                    'is_unit_bearing_pmi_identification_mark_remarks'       =>  $request->is_unit_bearing_pmi_identification_mark_remarks,

                    'is_claim_defect_identified_by_customer'        =>  $request->is_claim_defect_identified_by_customer,
                    'is_claim_defect_identified_by_customer_remarks'        =>  $request->is_claim_defect_identified_by_customer_remarks,

                    'does_customer_requires_official_capa_report'   =>  $request->does_customer_requires_official_capa_report,
                    'does_customer_requires_official_capa_report_remarks'   =>  $request->does_customer_requires_official_capa_report_remarks,

                    'created_by'                =>  $_SESSION["rapidx_user_id"],
                    'last_updated_by'           =>  $_SESSION["rapidx_user_id"],
                    'updated_at'                =>  date('Y-m-d H:i:s'),
                    'created_at'                =>  date('Y-m-d H:i:s')
                ];

                if(isset($request->email_attachment)){
                    $original_filename = $request->file('email_attachment')->getClientOriginalName();

                    $insert_claim_data['yec_yed_report_name'] = $request->yec_sender_name;
                    $insert_claim_data['yec_yed_report_date'] = $request->report_receive;
                    $insert_claim_data['yec_yed_report_file'] = $original_filename;

                    Storage::putFileAs('public/yec_yed_report', $request->email_attachment,  $original_filename);
                }

                if(isset($request->eight_d_report_file)){ // nmodify eight_d_report_file
                    $original_filename_eight_report = $request->file('eight_d_report_file')->getClientOriginalName();

                    $insert_claim_data['eight_report_name'] = $request->eight_d_report_name;
                    $insert_claim_data['eight_report_filename'] = $original_filename_eight_report;

                    Storage::putFileAs('public/eight_d_report', $request->eight_d_report_file,  $original_filename_eight_report);
                }

                /**
                 * Add validation in status(column)
                 */
                if($request->validity == 2){
                    $insert_claim_data['status'] = 1;
                }

                if($request->actual_response != null){
                    $insert_claim_data['status'] = 1;
                }

                // Get the last inserted claim and get the item_number(column) to increment, as per QAD that is the unique number
                $item_number = CustomerClaim::orderby('id', 'desc')->get('item_number');

                $item_number_validation = $item_number;
                // Check if there's Customer Claim data then order it by descending then get the item_number for incrementation else insert the default item_number which is 1

                $isEmailSentWithExistingRecords = 'false';
                $checkEmailOnInsertWithExistingRecords = '';
                $isEmailSentWithoutExistingRecords = 'false';
                $checkEmailOnInsertWithoutExistingRecords = '';

                /**
                 * Main Insertion
                 * Insert and increment the latest item_number
                 */
                if(count($item_number) > 0){
                    $item_number_val = $item_number[0]['item_number']; // sample value: 3
                    $customer_claim_id = CustomerClaim::insertGetId(
                        $insert_claim_data
                    );

                    if(isset($request->email_recipient_attention)){
                        if(count($request->email_recipient_attention) > 0){
                            for($index = 0; $index < count($request->email_recipient_attention); $index++){
                                CustomerClaimEmailRecipient::insert([
                                    'customer_claim_id' => $customer_claim_id,
                                    'email_recipient_id' => $request->email_recipient_attention[$index],
                                    'type' => 1,
                                    // 'status' => 1,
                                    'created_by' => $_SESSION["rapidx_user_id"],
                                    'last_updated_by' => $_SESSION["rapidx_user_id"],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            }
                        }
                    }

                    // $arr = array();
                    if(isset($request->email_recipient_cc)){
                        if(count($request->email_recipient_cc) > 0){
                            for($index = 0; $index < count($request->email_recipient_cc); $index++){
                                CustomerClaimEmailRecipient::insert([
                                    'customer_claim_id' => $customer_claim_id,
                                    'email_recipient_id' => $request->email_recipient_cc[$index],
                                    'type' => 2,
                                    // 'status' => 1,
                                    'created_by' => $_SESSION["rapidx_user_id"],
                                    'last_updated_by' => $_SESSION["rapidx_user_id"],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);

                                // $email_arr = array_push($arr, $request->email_recipient_cc[$index]);
                            }
                        }
                    }

                    // After the insert operation, then update the item_number(the item_number is set to default 0 and nullable)
                    // assume that the item_number(column) is null/empty after insertion, and you execute the $item_number_val(variable) query at the top,
                    // then we can use it to increment by 1 the use it as a values for the recently inserted
                    $incremented_item_number = $item_number_val + 1;
                    CustomerClaim::where('id', $customer_claim_id)->update(['item_number' => $incremented_item_number]);


                    if(isset($request->email_recipient_attention) || isset($request->email_recipient_cc)){
                        $checkEmailOnInsertWithExistingRecords = "true";
                        // Add validation if validity is information 03-31-22
                        if($request->validity != 2){
                            $isEmailSentWithExistingRecords = 'true';
                            $this->send_email($customer_claim_id);
                        }
                    }
                }else{
                    $customer_claim_id = CustomerClaim::insertGetId(
                        $insert_claim_data
                    );

                    if(isset($request->email_recipient_attention)){
                        if(count($request->email_recipient_attention) > 0){
                            for($index = 0; $index < count($request->email_recipient_attention); $index++){
                                CustomerClaimEmailRecipient::insert([
                                    'customer_claim_id' => $customer_claim_id,
                                    'email_recipient_id' => $request->email_recipient_attention[$index],
                                    'type' => 1,
                                    // 'status' => 1,
                                    'created_by' => $_SESSION["rapidx_user_id"],
                                    'last_updated_by' => $_SESSION["rapidx_user_id"],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            }
                        }
                    }

                    // $arr = array();
                    if(isset($request->email_recipient_cc)){
                        if(count($request->email_recipient_cc) > 0){
                            for($index = 0; $index < count($request->email_recipient_cc); $index++){
                                CustomerClaimEmailRecipient::insert([
                                    'customer_claim_id' => $customer_claim_id,
                                    'email_recipient_id' => $request->email_recipient_cc[$index],
                                    'type' => 2,
                                    // 'status' => 1,
                                    'created_by' => $_SESSION["rapidx_user_id"],
                                    'last_updated_by' => $_SESSION["rapidx_user_id"],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);

                                // $email_arr = array_push($arr, $request->email_recipient_cc[$index]);
                            }
                        }
                    }

                    if(isset($request->email_recipient_attention) || isset($request->email_recipient_cc)){
                        $checkEmailOnInsertWithoutExistingRecords = 'true';
                        if($request->validity != 2){
                            $isEmailSentWithoutExistingRecords = 'true';
                            $this->send_email($customer_claim_id);
                        }
                    }
                }
                return response()->json(['result' => "1",
                    'isEmailSentWithExistingRecords' => $isEmailSentWithExistingRecords,
                    'checkEmailOnInsertWithExistingRecords' => $checkEmailOnInsertWithExistingRecords,
                    'isEmailSentWithoutExistingRecords' => $isEmailSentWithoutExistingRecords,
                    'checkEmailOnInsertWithoutExistingRecords' => $checkEmailOnInsertWithoutExistingRecords
                ]);
            }
            else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }else{ // This will execute for update operation if customer_claim_id is set and not empty.
            // return response()->json(['email' => $request->customer_claim_id]);
            $rules = [
                'pmi_control_number'        => 'required',
                // 'reference_number'          => 'required',
                'quarter'                   => 'required',
                'customer'                  => 'required',
                // 'sender_name'               => 'required',
                'contributor'               => 'required',
                'validity'                  => 'required',
                'product_classification'    => 'required',
                'model_name'                => 'required',
                'mode_of_defect'            => 'required',
                // 'po_number'                 => 'required',
                'automotive'                => 'required',
                // 'quantity'                  => 'required|max:8',
                // 'number_of_ng'              => 'required|min:8',
                // 'return_to_vendor'          => 'required',
                'defect_category_class'     => 'required',
                'date_received'             => 'required',
                // 'actual_date_received_claim'=> 'required', // optional
                // 'date_return_of_claim'      => 'required', // optional
                // 'required_reply'            => 'required',
                // 'email_recipient_attention' => 'required',
                // 'email_recipient_cc'        => 'required',

                // 'initial_response'          => 'required', // optional based on sender
                // 'actual_response'           => 'required', // optional based on sender
                // 'turn_around_time'          => 'required', // optional based on sender
            ];

            /**
             * Validations
             */
            // Add validation if validity is information 03-31-22
            if($request->validity == 2){
                $rules['required_reply'] = '';
                $rules['email_recipient_attention'] = '';
                $rules['email_recipient_cc'] = '';
            }else{
                $rules['required_reply'] = 'required';
                $rules['email_recipient_attention'] = 'required';
                $rules['email_recipient_cc'] = 'required';
            }

            if(isset($request->chk_actual_date_received_claim)){
                $rules['actual_date_received_claim'] = 'required';
            }else{
                $rules['actual_date_received_claim'] = '';
            }

            if(isset($request->chk_date_return_of_claim)){
                $rules['date_return_of_claim'] = 'required';
            }else{
                $rules['date_return_of_claim'] = '';
            }

            if(isset($request->checkbox_email_attachment)){
                $rules['yec_yed_report_name'] = 'required';
                $rules['yec_yed_report_date'] = 'required';
                $rules['yec_yed_report_file'] = 'required';
                if($request->yec_sender_name != ''){
                    $rules['yec_yed_report_name'] = '';
                }else{
                    $rules['yec_yed_report_name'] = 'required';
                }
                if($request->report_receive != ''){
                    $rules['yec_yed_report_date'] = '';
                }else{
                    $rules['yec_yed_report_date'] = 'required';
                }
                if($request->email_attachment != ''){
                    $rules['yec_yed_report_file'] = '';
                }else{
                    $rules['yec_yed_report_file'] = 'required';
                }

                // if(isset($request->report_receive)){
                //     $rules['yec_yed_report_date'] = 'required';
                // }else{
                //     $rules['yec_yed_report_date'] = '';
                // }

                // if(isset($request->email_attachment)){
                //     $rules['yec_yed_report_file'] = 'required';
                // }else{
                //     $rules['yec_yed_report_file'] = '';
                // }
            }else{
                $rules['yec_yed_report_name'] = '';
                $rules['yec_yed_report_date'] = '';
                $rules['yec_yed_report_file'] = '';
            }

            if(isset($request->checkbox_eight_d_report)){
                $rules['eight_report_name'] = 'required';
                $rules['eight_report_filename'] = 'required';

                if($request->eight_d_report_name != ''){
                    $rules['eight_report_name'] = '';
                }else{
                    $rules['eight_report_name'] = 'required';
                }
                if($request->eight_d_report_file != ''){
                    $rules['eight_report_filename'] = '';
                }else{
                    $rules['eight_report_filename'] = 'required';
                }
                // $rules['eight_report_date'] = 'required';
            }else{
                $rules['eight_report_name'] = '';
                $rules['eight_report_filename'] = '';
                // $rules['eight_report_date'] = '';
            }

            function getBetweenDates($startDate, $endDate)
            {
                $rangArray = [];

                $startDate = strtotime($startDate."+1 days");
                $endDate = strtotime($endDate);

                for (
                    $currentDate = $startDate;
                    $currentDate <= $endDate;
                    $currentDate += (86400)
                ) {

                    $date = date('Y-n-j', $currentDate);
                    $rangArray[] = $date;
                }

                return $rangArray;
            }
            // $dates = getBetweenDates($dateReceived, $requiredReply);

            $holidays = Holiday::where('logdel',0)->get();
            $holiday_full_date = array();
            foreach ($holidays as $holiday){
                $holiday_date_construct = date("Y")."-".$holiday->month."-".$holiday->day;
                array_push($holiday_full_date,$holiday_date_construct);
            }

            // Turn Around Time computation
            if(isset($request->chk_actual_date_received_claim) && isset($request->actual_date_received_claim)){ // checkbox
                if(isset($request->actual_date_received_claim) && isset($request->required_reply)){
                    $actualDateReceivedClaim = $request->actual_date_received_claim;
                    $requiredReply = $request->required_reply;

                    $dates = getBetweenDates($actualDateReceivedClaim, $requiredReply);
                    $count = 0;

                    foreach ($dates as $date){
                        $date_day = date("D", strtotime($date));
                        if(!($date_day == 'Sat' || $date_day == 'Sun')){
                            if(!in_array($date, $holiday_full_date)){
                                $count = $count + 1;
                            }
                        }
                    }

                    /**
                     * Old Code
                     * 06-08-2022
                     */
                    // foreach ($dates as $date){
                    //     $date_day = date("D", strtotime($date));
                    //     if(!in_array($date, $holiday_full_date)){
                    //         $count = $count + 1;
                    //     }
                    //     if($date_day == 'Sat' || $date_day == 'Sun'){
                    //         $count = $count - 1;
                    //     }
                    // }

                    // $actualDateReceivedClaimDiff = new DateTime($actualDateReceivedClaim);
                    // $requiredReplyDiff = new DateTime($requiredReply);

                    // $turnAroundTime = $actualDateReceivedClaimDiff->diff($requiredReplyDiff);
                    // $turnAroundTimeResult = $turnAroundTime->format('%a');
                    $turnAroundTimeResult = $count." day/s";
                }else
                {
                    $turnAroundTimeResult = "0 day";
                }
            }else{
                if(!isset($request->chk_actual_date_received_claim) && isset($request->date_received)){
                    $dateReceived = $request->date_received;
                    $requiredReply = $request->required_reply;
                    $dates = getBetweenDates($dateReceived, $requiredReply);
                    $count = 0;
                    $test = array();

                    foreach ($dates as $date){
                        $date_day = date("D", strtotime($date));
                        if(!($date_day == 'Sat' || $date_day == 'Sun')){
                            if(!in_array($date, $holiday_full_date)){
                                $count = $count + 1;
                            }
                        }
                    }

                    /**
                     * Old Code
                     * 06-08-2022
                     */
                    // foreach ($dates as $date){
                    //     $date_day = date("D", strtotime($date));
                    //     if(!in_array($date, $holiday_full_date)){
                    //         $count = $count + 1;
                    //     }
                    //     if($date_day == 'Sat' || $date_day == 'Sun'){
                    //         $count = $count - 1;
                    //     }
                    // }

                    // $dateReceivedDiff = new DateTime($dateReceived);
                    // $requiredReplyDiff = new DateTime($requiredReply);

                    // $turnAroundTime = $dateReceivedDiff->diff($requiredReplyDiff);
                    // $turnAroundTimeResult = $turnAroundTime->format('%a');
                    $turnAroundTimeResult = $count." day/s";
                }else
                {
                    $turnAroundTimeResult = "0 day";
                }
            }

            $validator = Validator::make($data, $rules);
            if($validator->passes()){
                $update_claim_data = [
                    'section'                   =>  $request->section,
                    'pmi_control_number'        =>  $request->pmi_control_number,
                    'reference_number'          =>  $request->reference_number,
                    'quarter'                   =>  $request->quarter,
                    'customer'                  =>  $request->customer,
                    'sender_name'               =>  $request->sender_name,
                    'contributor'               =>  $request->contributor,
                    'validity'                  =>  $request->validity,
                    'product_classification'    =>  $request->product_classification,
                    'model_name'                =>  $request->model_name,
                    'mode_of_defect'            =>  $request->mode_of_defect,

                    'shipment_date'             =>  $request->shipment_date,
                    'shipment_quantity'         =>  $request->shipment_quantity,

                    'lot_traceability'           =>  $request->lot_traceability,

                    'po_number'                 =>  $request->po_number,
                    'automotive'                =>  $request->automotive,
                    'quantity'                  =>  $request->quantity,
                    'number_of_ng'              =>  $request->number_of_ng,
                    'return_to_vendor'          =>  $request->return_to_vendor,
                    'defect_category_class'     =>  $request->defect_category_class,
                    'date_received'             =>  $request->date_received,
                    'actual_date_received_claim'=>  $request->actual_date_received_claim,
                    'date_return_of_claim'      =>  $request->date_return_of_claim,
                    'required_reply'            =>  $request->required_reply,
                    'initial_response'          =>  $request->initial_response,
                    'actual_response'           =>  $request->actual_response,
                    'turn_around_time'          =>  $turnAroundTimeResult,
                    'final_report'              =>  $request->final_report, // based on the radio buttons
                    'remarks'                   =>  $request->remarks,

                    //YEC YED Report Details
                    // 'yec_yed_report_name' => $request->yec_sender_name,
                    // 'yec_yed_report_date' => $request->report_receive,

                    //8D Report
                    // 'eight_report_name' => $request->eight_report_name,

                    // Data Verification
                    'is_po_number_traceable'                        =>  $request->is_po_number_traceable,
                    'is_po_number_traceable_remarks'                        =>  $request->is_po_number_traceable_remarks,

                    'is_lot_identification_match'                   =>  $request->is_lot_identification_match,
                    'is_lot_identification_match_remarks'                   =>  $request->is_lot_identification_match_remarks,

                    'are_there_wip_fgs_affected'                    =>  $request->are_there_wip_fgs_affected,
                    'are_there_wip_fgs_affected_remarks'                    =>  $request->are_there_wip_fgs_affected_remarks,

                    'is_sorting_reworking_necessary'                =>  $request->is_sorting_reworking_necessary,
                    'is_sorting_reworking_necessary_remarks'                =>  $request->is_sorting_reworking_necessary_remarks,

                    'is_sorting_needed'                             =>  $request->is_sorting_needed,
                    'is_sorting_needed_remarks'                             =>  $request->is_sorting_needed_remarks,

                    'is_shipment_affected'                          =>  $request->is_shipment_affected,
                    'is_shipment_affected_remarks'                          =>  $request->is_shipment_affected_remarks,

                    'are_data_needed_complete_available'            =>  $request->are_data_needed_complete_available,
                    'are_data_needed_complete_available_remarks'            =>  $request->are_data_needed_complete_available_remarks,

                    'does_customer_requests_production_record'      =>  $request->does_customer_requests_production_record,
                    'does_customer_requests_production_record_remarks'      =>  $request->does_customer_requests_production_record_remarks,

                    'are_there_clarifications_needed_to_settle'     =>  $request->are_there_clarifications_needed_to_settle,
                    'are_there_clarifications_needed_to_settle_remarks'     =>  $request->are_there_clarifications_needed_to_settle_remarks,

                    // Unit Verification
                    'is_actual_ng_unit_available'                   =>  $request->is_actual_ng_unit_available,
                    'is_actual_ng_unit_available_remarks'                   =>  $request->is_actual_ng_unit_available_remarks,

                    'is_unit_bearing_pmi_identification_mark'       =>  $request->is_unit_bearing_pmi_identification_mark,
                    'is_unit_bearing_pmi_identification_mark_remarks'       =>  $request->is_unit_bearing_pmi_identification_mark_remarks,

                    'is_claim_defect_identified_by_customer'        =>  $request->is_claim_defect_identified_by_customer,
                    'is_claim_defect_identified_by_customer_remarks'        =>  $request->is_claim_defect_identified_by_customer_remarks,

                    'does_customer_requires_official_capa_report'   =>  $request->does_customer_requires_official_capa_report,
                    'does_customer_requires_official_capa_report_remarks'   =>  $request->does_customer_requires_official_capa_report_remarks,

                    'created_by'                =>  $_SESSION["rapidx_user_id"],
                    'last_updated_by'           =>  $_SESSION["rapidx_user_id"],
                    'updated_at'                =>  date('Y-m-d H:i:s'),
                    'created_at'                =>  date('Y-m-d H:i:s')
                ];

                if(isset($request->checkbox_eight_d_report)){
                    $original_eight_d_report_filename = $request->file('eight_d_report_file')->getClientOriginalName();
                    $update_claim_data['eight_report_filename'] = $original_eight_d_report_filename;
                    $update_claim_data['eight_report_name'] = $request->eight_d_report_name;

                    Storage::putFileAs('public/eight_d_report', $request->eight_d_report_file,  $original_eight_d_report_filename);
                }

                if(isset($request->checkbox_email_attachment)){
                    $original_filename = $request->file('email_attachment')->getClientOriginalName();
                    $update_claim_data['yec_yed_report_file'] = $original_filename;
                    $update_claim_data['yec_yed_report_name'] = $request->yec_sender_name;
                    $update_claim_data['yec_yed_report_date'] = $request->report_receive;

                    Storage::putFileAs('public/yec_yed_report', $request->email_attachment,  $original_filename);
                }

                /**
                 * Add validation in status(column)
                 */
                if($request->validity == 2){
                    $update_claim_data['status'] = 1;
                }

                if($request->actual_response != null){
                    $update_claim_data['status'] = 1;
                }

                if(isset($request->customer_claim_id)){
                    CustomerClaim::where('id', $request->customer_claim_id)->update(
                        $update_claim_data
                    );

                    CustomerClaimEmailRecipient::where('customer_claim_id', $request->customer_claim_id)->delete();
                    if(isset($request->email_recipient_attention)){
                        if(count($request->email_recipient_attention) > 0){
                            for($index = 0; $index < count($request->email_recipient_attention); $index++){
                                CustomerClaimEmailRecipient::insert([
                                    'customer_claim_id' => $request->customer_claim_id,
                                    'email_recipient_id' => $request->email_recipient_attention[$index],
                                    'type' => 1,
                                    // 'status' => 1,
                                    'created_by' => $_SESSION["rapidx_user_id"],
                                    'last_updated_by' => $_SESSION["rapidx_user_id"],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            }
                        }
                    }

                    // $arr = array();
                    if(isset($request->email_recipient_cc)){
                        if(count($request->email_recipient_cc) > 0){
                            for($index = 0; $index < count($request->email_recipient_cc); $index++){
                                CustomerClaimEmailRecipient::insert([
                                    'customer_claim_id' => $request->customer_claim_id,
                                    'email_recipient_id' => $request->email_recipient_cc[$index],
                                    'type' => 2,
                                    // 'status' => 1,
                                    'created_by' => $_SESSION["rapidx_user_id"],
                                    'last_updated_by' => $_SESSION["rapidx_user_id"],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);

                                // $email_arr = array_push($arr, $request->email_recipient_cc[$index]);
                            }
                        }
                    }

                    /*
                        As per request of Ma'am Jo, disable the emailing when editing
                    */
                    if(isset($request->email_recipient_attention) || isset($request->email_recipient_cc)){
                        /**
                         * Commented as requested by ma'am Jho last 05-10-2022(in Notepad)
                         * ? Modified by -JD 05-26-2022
                         */
                        // if($request->validity != 2){
                        //     $this->send_email($request->customer_claim_id);
                        // }

                    }else{
                        return response()->json(['result' => "1"]);
                        echo 'send email not set on update';
                    }
                    return response()->json(['result' => "1"]);
                }
            }
            else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }
    }


    //============================= View Customer Claim CN for Datatables =============================
    public function view_customer_claim_cn(Request $request){

        $customerClaims = CustomerClaim::with([
                        'customer_details',
                    ])
                    ->where('section', 'CN')
                    ->where('logdel', 0)
                    // ->where('validity', '!=', 2)

                    // FILTER QUERY
                    ->when($request->filterModeOfDefect, function ($query) use ($request) {
                        return $query ->where('mode_of_defect', 'like', '%'.$request->filterModeOfDefect.'%');
                    })
                    ->when($request->filterModelSeries, function ($query) use ($request) {
                        return $query ->where('model_name', 'like', '%'.$request->filterModelSeries.'%');
                    })
                    ->when($request->filterReferenceNo, function ($query) use ($request) {
                        return $query ->where('reference_number', 'like', '%'.$request->filterReferenceNo.'%');
                    })
                    ->when($request->filterControlNo, function ($query) use ($request) {
                        return $query ->where('pmi_control_number', 'like', '%'.$request->filterControlNo.'%');
                    })
                    ->when($request->filterTraceability, function ($query) use ($request) {
                        return $query ->where('po_number', 'like', '%'.$request->filterTraceability.'%');
                    })
                    ->when($request->filterRTV, function ($query) use ($request) {
                        return $query ->where('return_to_vendor', 'like', '%'.$request->filterRTV.'%');
                    })
                    ->when($request->dateRangeFrom, function ($query) use ($request) {
                        return $query ->where('date_received', '>=', $request->dateRangeFrom);
                    })
                    ->when($request->dateRangeTo, function ($query) use ($request) {
                        return $query ->where('date_received', '<=', $request->dateRangeTo);
                    })
                    // ->where('mode_of_defect', 'like', '%'.$request->filterModeOfDefect.'%')
                    // ->where('model_name', 'like', '%'.$request->filterModelSeries.'%')
                    // ->where('reference_number', 'like', '%'.$request->filterReferenceNo.'%')
                    // ->where('pmi_control_number','like', '%'.$request->filterControlNo.'%')
                    // ->where('po_number', 'like', '%'.$request->filterTraceability.'%')
                    // ->where('return_to_vendor', 'like', '%'.$request->filterRTV.'%')
                    // END FILTER QUERY
                    ->get();

        // ADDITIONAL FILTER QUERY
        if($request->filterCustomer != null){
            $customerClaims = collect($customerClaims)->where('customer',$request->filterCustomer);
        }
        if($request->filterSection != null){
            $customerClaims = collect($customerClaims)->where('section',$request->filterSection);
        }
        if($request->filterProductClassification != null){
            $customerClaims = collect($customerClaims)->where('product_classification',$request->filterProductClassification);
        }
        if($request->filterClass != null){
            $customerClaims = collect($customerClaims)->where('defect_category_class',$request->filterClass);
        }
        if($request->filterContributor != null){
            $customerClaims = collect($customerClaims)->where('contributor',$request->filterContributor);
        }
        if($request->filterValidity != null){
            $customerClaims = collect($customerClaims)->where('validity',$request->filterValidity);
        }
        //END ADDITIONAL FILTER


        return DataTables::of($customerClaims)
            ->addColumn('status', function($customerClaim){
                $result = "";
                if($customerClaim->status == 1){
                    $result .= '<center><span class="badge badge-pill text-xs badge-success">Closed</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">Open</span></center>';
                }
                return $result;
            })
            ->addColumn('validity', function($customerClaim){
                $result = "";
                if($customerClaim->validity == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Valid</span></center>';
                }
                else if($customerClaim->validity == 2){
                    $result .= '<center><span class="badge badge-pill badge-primary">Information</span></center>';
                }
                else if($customerClaim->validity == 3){
                    $result .= '<center><span class="badge badge-pill badge-info">Feedback</span></center>';
                }
                else if($customerClaim->validity == 4){
                    $result .= '<center><span class="badge badge-pill badge-danger">Invalid</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
                }
                return $result;
            })
            // ->addColumn('action', function($customerClaim){
            //     $result = '<center>';
            //     if($customerClaim->yec_yed_report_file != null){
            //         $result .= '<div class="btn-group">
            //             <a class="btn btn-warning text-light btn-xs text-center actionViewEmail mr-1" href="download_email_attachment/'.$customerClaim->id.'" customer-claim-id="' . $customerClaim->id . '" title="View Email Details">
            //                 <i class="far fa-lg fa-envelope"></i>
            //             </a>
            //         </div>';
            //     }

            //     $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionEditCustomerClaim mr-1" type="button" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalAddCustomerClaim" aria-haspopup="true" aria-expanded="false" title="Edit Claim Details">
            //                     <i class="fa fa-lg fa-edit"></i>
            //                 </button>';
            //     $result .= '<button type="button" class="btn btn-info btn-xs text-center actionViewCustomerClaim mr-1" type="button" view-customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalViewCustomerClaim" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
            //                     <i class="far fa-lg fa-eye"></i>
            //                 </button>';
            //     $result .= '<a href="export?checksheet_id='. $customerClaim->id .'" target="_blank" class="btn btn-secondary btn-xs text-center " style="padding-left: 5px; padding-right: 5px;"><i class="fas fa-lg fa-file-excel"></i></a>';

            //     $result .=  '</center>';
            //     return $result;
            // })
            ->addColumn('action', function($customerClaim){
                $result = '<center><div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Action">
                                <i class="fa fa-lg fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">'; // dropdown-menu start
                $result .= '<button type="button" class="dropdown-item text-center text-center actionViewCustomerClaim mr-1" type="button" view-customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalViewCustomerClaim" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
                                View
                            </button>';
                $result .= '<button type="button" class="dropdown-item text-center actionEditCustomerClaim mr-1" type="button" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalAddCustomerClaim" aria-haspopup="true" aria-expanded="false" title="Edit Claim Details">
                                Edit
                            </button>';
                if($customerClaim->yec_yed_report_file != null){
                $result .= '<a class=" text-center actionViewEmail mr-1 dropdown-item text-center" href="download_email_attachment/'.$customerClaim->id.'" customer-claim-id="' . $customerClaim->id . '" title="View Email Details">
                                Download Email
                            </a>';
                }

                $result .= '<a href="export?checksheet_id='. $customerClaim->id .'" target="_blank" class="dropdown-item text-center" style="padding-left: 5px; padding-right: 5px;">Export Checksheet</a>';

                $result .= '</div>'; // dropdown-menu end
                $result .= '</div></center>';
                return $result;
            })
            ->addColumn('eight_d_report', function($customerClaim){
                $result = "";
                if($customerClaim->eight_report_filename != null){
                    $result .= '<a title="Download 8D Report" href="download_eight_d_report_file/'.$customerClaim->id.'"><i class="far fa-lg fa-file">&nbsp;</i>'.$customerClaim->eight_report_filename.'</a>';
                }
                else{
                    $result .= '<span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">N/A</span>';
                }
                return $result;
            })
            ->addColumn('operation_eight_d_report_filename', function($customerClaim){
                $result = "<center>";
                if($customerClaim->operation_eight_d_report_filename != null){
                    if($customerClaim->status == 0){
                        // $result .= '<a class="btn btn-info text-light btn-xs text-center" href="download_operation_eight_d_report/'.$customerClaim->id.'"><i class="far fa-lg fa-file">&nbsp;</i>Download 8D Report</a>';
                        $result .= '<button class="btn btn-primary text-light btn-sm text-center actionValidateEightDReport" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalValidateEightDReport" aria-haspopup="true" aria-expanded="false" title="Validate Submitted 8D Report">
                                        <i class="far fa-lg fa-eye"></i>&nbsp;View Report
                                    </button></center>';
                    }else{
                        $result .= '<button class="btn btn-success text-light btn-sm text-center actionValidateEightDReport" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalValidateEightDReport" aria-haspopup="true" aria-expanded="false" title="Validated">
                                        <i class="far fa-lg fa-eye"></i>&nbsp;Validated
                                    </button></center>';
                    }

                }
                else{
                    $result .= '<span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">N/A</span></center>';
                }
                return $result;
            })
            ->rawColumns(['status', 'validity','eight_d_report', 'action', 'operation_eight_d_report_filename']) // to format columns as html format
            ->make(true);
    }


    //============================= View Customer Claim TS for Datatables =============================
    public function view_customer_claim_ts(Request $request){
        $customerClaims = CustomerClaim::with([
                        'customer_details',
                    ])
                    ->where('section', 'TS')
                    ->where('logdel', 0)

                    ->when($request->filterModeOfDefect, function ($query) use ($request) {
                        return $query ->where('mode_of_defect', 'like', '%'.$request->filterModeOfDefect.'%');
                    })
                    ->when($request->filterModelSeries, function ($query) use ($request) {
                        return $query ->where('model_name', 'like', '%'.$request->filterModelSeries.'%');
                    })
                    ->when($request->filterReferenceNo, function ($query) use ($request) {
                        return $query ->where('reference_number', 'like', '%'.$request->filterReferenceNo.'%');
                    })
                    ->when($request->filterControlNo, function ($query) use ($request) {
                        return $query ->where('pmi_control_number', 'like', '%'.$request->filterControlNo.'%');
                    })
                    ->when($request->filterTraceability, function ($query) use ($request) {
                        return $query ->where('po_number', 'like', '%'.$request->filterTraceability.'%');
                    })
                    ->when($request->filterRTV, function ($query) use ($request) {
                        return $query ->where('return_to_vendor', 'like', '%'.$request->filterRTV.'%');
                    })
                    ->when($request->dateRangeFrom, function ($query) use ($request) {
                        return $query ->where('date_received', '>=', $request->dateRangeFrom);
                    })
                    ->when($request->dateRangeTo, function ($query) use ($request) {
                        return $query ->where('date_received', '<=', $request->dateRangeTo);
                    })
                      // FILTER QUERY
                    //   ->where('mode_of_defect', 'like', '%'.$request->filterModeOfDefect.'%')
                    //   ->where('model_name', 'like', '%'.$request->filterModelSeries.'%')
                    //   ->where('reference_number', 'like', '%'.$request->filterReferenceNo.'%')
                    //   ->where('pmi_control_number','like', '%'.$request->filterControlNo.'%')
                    //   ->where('po_number', 'like', '%'.$request->filterTraceability.'%')
                    //   ->where('return_to_vendor', 'like', '%'.$request->filterRTV.'%')
                      // END FILTER QUERY
                    ->get();

          // ADDITIONAL FILTER QUERY
        if($request->filterCustomer != null){
            $customerClaims = collect($customerClaims)->where('customer',$request->filterCustomer);
        }
        if($request->filterSection != null){
            $customerClaims = collect($customerClaims)->where('section',$request->filterSection);
        }
        if($request->filterProductClassification != null){
            $customerClaims = collect($customerClaims)->where('product_classification',$request->filterProductClassification);
        }
        if($request->filterClass != null){
            $customerClaims = collect($customerClaims)->where('defect_category_class',$request->filterClass);
        }
        if($request->filterContributor != null){
            $customerClaims = collect($customerClaims)->where('contributor',$request->filterContributor);
        }
        if($request->filterValidity != null){
            $customerClaims = collect($customerClaims)->where('validity',$request->filterValidity);
        }
          //END ADDITIONAL FILTER
                // return $customerClaims;
        return DataTables::of($customerClaims)
            ->addColumn('status', function($customerClaim){
                $result = "";
                if($customerClaim->status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Closed</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Open</span></center>';
                }
                return $result;
            })
            ->addColumn('validity', function($customerClaim){
                $result = "";
                if($customerClaim->validity == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Valid</span></center>';
                }
                else if($customerClaim->validity == 2){
                    $result .= '<center><span class="badge badge-pill badge-primary">Information</span></center>';
                }
                else if($customerClaim->validity == 3){
                    $result .= '<center><span class="badge badge-pill badge-info">Feedback</span></center>';
                }
                else if($customerClaim->validity == 4){
                    $result .= '<center><span class="badge badge-pill badge-danger">Invalid</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
                }
                return $result;
            })
            // ->addColumn('action', function($customerClaim){
            //     $result = '<center>';
            //     if($customerClaim->yec_yed_report_file != null){
            //         $result .= '<div class="btn-group">
            //             <a class="btn btn-warning text-light btn-xs text-center actionViewEmail mr-1" href="download_email_attachment/'.$customerClaim->id.'" customer-claim-id="' . $customerClaim->id . '" title="View Email Details">
            //                 <i class="far fa-lg fa-envelope"></i>
            //             </a>
            //         </div>';
            //     }
            //     $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionEditCustomerClaim mr-1" type="button" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalAddCustomerClaim" aria-haspopup="true" aria-expanded="false" title="Edit Claim Details">
            //                     <i class="fa fa-lg fa-edit"></i>
            //                 </button>';
            //     $result .= '<button type="button" class="btn btn-info btn-xs text-center actionViewCustomerClaim mr-1" type="button" view-customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalViewCustomerClaim" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
            //                     <i class="far fa-lg fa-eye"></i>
            //                 </button>';
            //     $result .= '<a href="export?checksheet_id='. $customerClaim->id .'" target="_blank" class="btn btn-secondary btn-xs text-center " style="padding-left: 5px; padding-right: 5px;"><i class="fas fa-lg fa-file-excel"></i></a>';

            //     $result .=  '</center>';
            //     return $result;
            // })
            ->addColumn('action', function($customerClaim){
                $result = '<center><div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Action">
                                <i class="fa fa-lg fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">'; // dropdown-menu start
                $result .= '<button type="button" class="dropdown-item text-center text-center actionViewCustomerClaim mr-1" type="button" view-customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalViewCustomerClaim" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
                        View
                </button>';
                $result .= '<button type="button" class="dropdown-item text-center actionEditCustomerClaim mr-1" type="button" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalAddCustomerClaim" aria-haspopup="true" aria-expanded="false" title="Edit Claim Details">
                                Edit
                            </button>';
                if($customerClaim->yec_yed_report_file != null){
                    $result .= '
                        <a class=" text-center actionViewEmail mr-1 dropdown-item text-center" href="download_email_attachment/'.$customerClaim->id.'" customer-claim-id="' . $customerClaim->id . '" title="View Email Details">
                            Download Email
                        </a>';
                }

                $result .= '<a href="export?checksheet_id='. $customerClaim->id .'" target="_blank" class="dropdown-item text-center" style="padding-left: 5px; padding-right: 5px;">Export Checksheet</a>';

                $result .= '</div>'; // dropdown-menu end
                $result .= '</div></center>';
                return $result;
            })
            ->addColumn('eight_d_report', function($customerClaim){
                $result = "";
                if($customerClaim->eight_report_filename != null){
                    $result .= '<a title="Download 8D Report" href="download_eight_d_report_file/'.$customerClaim->id.'"><i class="far fa-lg fa-file">&nbsp;</i>'.$customerClaim->eight_report_filename.'</a>';
                }
                else{
                    $result .= '<span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">N/A</span>';
                }
                return $result;
            })
            ->addColumn('operation_eight_d_report_filename', function($customerClaim){
                $result = "<center>";
                if($customerClaim->operation_eight_d_report_filename != null){ //nmodify
                    if($customerClaim->status == 0){
                        // $result .= '<a class="btn btn-info text-light btn-xs text-center" href="download_operation_eight_d_report/'.$customerClaim->id.'"><i class="far fa-lg fa-file">&nbsp;</i>Download 8D Report</a>';
                        $result .= '<button class="btn btn-primary text-light btn-sm text-center actionValidateEightDReport" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalValidateEightDReport" aria-haspopup="true" aria-expanded="false" title="Validate Submitted 8D Report">
                                        <i class="far fa-lg fa-eye"></i>&nbsp;View Report
                                    </button></center>';
                    }else{
                        $result .= '<button class="btn btn-success text-light btn-sm text-center actionValidateEightDReport" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalValidateEightDReport" aria-haspopup="true" aria-expanded="false" title="Validated">
                                        <i class="far fa-lg fa-eye"></i>&nbsp;Validated
                                    </button></center>';
                    }

                }
                else{
                    $result .= '<span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">N/A</span></center>';
                }
                return $result;
            })
            ->rawColumns(['status', 'validity','eight_d_report', 'action', 'operation_eight_d_report_filename']) // to format columns as html format
            ->make(true);
    }


    //============================= View Customer Claim YF for Datatables =============================
    public function view_customer_claim_yf(Request $request){
        $customerClaims = CustomerClaim::with([
                            'customer_details',
                        ])
                    ->where('section', 'YF')
                    ->where('logdel', 0)

                    ->when($request->filterModeOfDefect, function ($query) use ($request) {
                        return $query ->where('mode_of_defect', 'like', '%'.$request->filterModeOfDefect.'%');
                    })
                    ->when($request->filterModelSeries, function ($query) use ($request) {
                        return $query ->where('model_name', 'like', '%'.$request->filterModelSeries.'%');
                    })
                    ->when($request->filterReferenceNo, function ($query) use ($request) {
                        return $query ->where('reference_number', 'like', '%'.$request->filterReferenceNo.'%');
                    })
                    ->when($request->filterControlNo, function ($query) use ($request) {
                        return $query ->where('pmi_control_number', 'like', '%'.$request->filterControlNo.'%');
                    })
                    ->when($request->filterTraceability, function ($query) use ($request) {
                        return $query ->where('po_number', 'like', '%'.$request->filterTraceability.'%');
                    })
                    ->when($request->filterRTV, function ($query) use ($request) {
                        return $query ->where('return_to_vendor', 'like', '%'.$request->filterRTV.'%');
                    })
                    ->when($request->dateRangeFrom, function ($query) use ($request) {
                        return $query ->where('date_received', '>=', $request->dateRangeFrom);
                    })
                    ->when($request->dateRangeTo, function ($query) use ($request) {
                        return $query ->where('date_received', '<=', $request->dateRangeTo);
                    })
                      // FILTER QUERY
                    // ->where('mode_of_defect', 'like', '%'.$request->filterModeOfDefect.'%')
                    // ->where('model_name', 'like', '%'.$request->filterModelSeries.'%')
                    // ->where('reference_number', 'like', '%'.$request->filterReferenceNo.'%')
                    // ->where('pmi_control_number','like', '%'.$request->filterControlNo.'%')
                    // ->where('po_number', 'like', '%'.$request->filterTraceability.'%')
                    // ->where('return_to_vendor', 'like', '%'.$request->filterRTV.'%')
                    // END FILTER QUERY
                    ->get();

        // ADDITIONAL FILTER QUERY
        if($request->filterCustomer != null){
            $customerClaims = collect($customerClaims)->where('customer',$request->filterCustomer);
        }
        if($request->filterSection != null){
            $customerClaims = collect($customerClaims)->where('section',$request->filterSection);
        }
        if($request->filterProductClassification != null){
            $customerClaims = collect($customerClaims)->where('product_classification',$request->filterProductClassification);
        }
        if($request->filterClass != null){
            $customerClaims = collect($customerClaims)->where('defect_category_class',$request->filterClass);
        }
        if($request->filterContributor != null){
            $customerClaims = collect($customerClaims)->where('contributor',$request->filterContributor);
        }
        if($request->filterValidity != null){
            $customerClaims = collect($customerClaims)->where('validity',$request->filterValidity);
        }
        //END ADDITIONAL FILTER

        return DataTables::of($customerClaims)
            ->addColumn('status', function($customerClaim){
                $result = "";
                if($customerClaim->status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Closed</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Open</span></center>';
                }
                return $result;
            })
            ->addColumn('validity', function($customerClaim){
                $result = "";
                if($customerClaim->validity == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Valid</span></center>';
                }
                else if($customerClaim->validity == 2){
                    $result .= '<center><span class="badge badge-pill badge-primary">Information</span></center>';
                }
                else if($customerClaim->validity == 3){
                    $result .= '<center><span class="badge badge-pill badge-info">Feedback</span></center>';
                }
                else if($customerClaim->validity == 4){
                    $result .= '<center><span class="badge badge-pill badge-danger">Invalid</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
                }
                return $result;
            })
            // ->addColumn('action', function($customerClaim){
            //     $result = '<center>';
            //     if($customerClaim->yec_yed_report_file != null){
            //         $result .= '<div class="btn-group">
            //             <a class="btn btn-warning text-light btn-xs text-center actionViewEmail mr-1" href="download_email_attachment/'.$customerClaim->id.'" customer-claim-id="' . $customerClaim->id . '" title="View Email Details">
            //                 <i class="far fa-lg fa-envelope"></i>
            //             </a>
            //         </div>';
            //     }
            //     $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionEditCustomerClaim mr-1" type="button" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalAddCustomerClaim" aria-haspopup="true" aria-expanded="false" title="Edit Claim Details">
            //                     <i class="fa fa-lg fa-edit"></i>
            //                 </button>';
            //     $result .= '<button type="button" class="btn btn-info btn-xs text-center actionViewCustomerClaim mr-1" type="button" view-customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalViewCustomerClaim" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
            //                     <i class="far fa-lg fa-eye"></i>
            //                 </button>';
            //     $result .= '<a href="export?checksheet_id='. $customerClaim->id .'" target="_blank" class="btn btn-secondary btn-xs text-center " style="padding-left: 5px; padding-right: 5px;"><i class="fas fa-lg fa-file-excel"></i></a>';

            //     $result .=  '</center>';
            //     return $result;
            // })
            ->addColumn('action', function($customerClaim){
                $result = '<center><div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Action">
                                <i class="fa fa-lg fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">'; // dropdown-menu start
                $result .= '<button type="button" class="dropdown-item text-center text-center actionViewCustomerClaim mr-1" type="button" view-customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalViewCustomerClaim" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
                        View
                </button>';
                $result .= '<button type="button" class="dropdown-item text-center actionEditCustomerClaim mr-1" type="button" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalAddCustomerClaim" aria-haspopup="true" aria-expanded="false" title="Edit Claim Details">
                                Edit
                            </button>';
                if($customerClaim->yec_yed_report_file != null){
                    $result .= '
                        <a class=" text-center actionViewEmail mr-1 dropdown-item text-center" href="download_email_attachment/'.$customerClaim->id.'" customer-claim-id="' . $customerClaim->id . '" title="View Email Details">
                            Download Email
                        </a>';
                }

                $result .= '<a href="export?checksheet_id='. $customerClaim->id .'" target="_blank" class="dropdown-item text-center" style="padding-left: 5px; padding-right: 5px;">Export Checksheet</a>';

                $result .= '</div>'; // dropdown-menu end
                $result .= '</div></center>';
                return $result;
            })
            ->addColumn('eight_d_report', function($customerClaim){
                $result = "";
                if($customerClaim->eight_report_filename != null){
                    $result .= '<a title="Download 8D Report" href="download_eight_d_report_file/'.$customerClaim->id.'"><i class="far fa-lg fa-file">&nbsp;</i>'.$customerClaim->eight_report_filename.'</a>';
                }
                else{
                    $result .= '<span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">N/A</span>';
                }
                return $result;
            })
            ->addColumn('operation_eight_d_report_filename', function($customerClaim){
                $result = "<center>";
                if($customerClaim->operation_eight_d_report_filename != null){
                    if($customerClaim->status == 0){
                        $result .= '<button class="btn btn-primary text-light btn-sm text-center actionValidateEightDReport" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalValidateEightDReport" aria-haspopup="true" aria-expanded="false" title="Validate Submitted 8D Report">
                                        <i class="far fa-lg fa-eye"></i>&nbsp;View Report
                                    </button></center>';
                    }else{
                        $result .= '<button class="btn btn-success text-light btn-sm text-center actionValidateEightDReport" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalValidateEightDReport" aria-haspopup="true" aria-expanded="false" title="Validated">
                                        <i class="far fa-lg fa-eye"></i>&nbsp;Validated
                                    </button></center>';
                    }
                    // $result .= '<a class="btn btn-info text-light btn-xs text-center" href="download_operation_eight_d_report/'.$customerClaim->id.'"><i class="far fa-lg fa-file">&nbsp;</i>Download 8D Report</a>';

                }
                else{
                    $result .= '<span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">N/A</span></center>';
                }
                return $result;
            })
            ->rawColumns(['status', 'validity','eight_d_report', 'action', 'operation_eight_d_report_filename']) // to format columns as html format
            ->make(true);
    }


    //============================= View Customer Claim PPS for Datatables =============================
    public function view_customer_claim_pps(Request $request){
        $customerClaims = CustomerClaim::with([
                        'customer_details',
                    ])
                    ->where('section', 'PPS')
                    ->where('logdel', 0)

                    ->when($request->filterModeOfDefect, function ($query) use ($request) {
                        return $query ->where('mode_of_defect', 'like', '%'.$request->filterModeOfDefect.'%');
                    })
                    ->when($request->filterModelSeries, function ($query) use ($request) {
                        return $query ->where('model_name', 'like', '%'.$request->filterModelSeries.'%');
                    })
                    ->when($request->filterReferenceNo, function ($query) use ($request) {
                        return $query ->where('reference_number', 'like', '%'.$request->filterReferenceNo.'%');
                    })
                    ->when($request->filterControlNo, function ($query) use ($request) {
                        return $query ->where('pmi_control_number', 'like', '%'.$request->filterControlNo.'%');
                    })
                    ->when($request->filterTraceability, function ($query) use ($request) {
                        return $query ->where('po_number', 'like', '%'.$request->filterTraceability.'%');
                    })
                    ->when($request->filterRTV, function ($query) use ($request) {
                        return $query ->where('return_to_vendor', 'like', '%'.$request->filterRTV.'%');
                    })
                    ->when($request->dateRangeFrom, function ($query) use ($request) {
                        return $query ->where('date_received', '>=', $request->dateRangeFrom);
                    })
                    ->when($request->dateRangeTo, function ($query) use ($request) {
                        return $query ->where('date_received', '<=', $request->dateRangeTo);
                    })
                      // FILTER QUERY
                    // ->where('mode_of_defect', 'like', '%'.$request->filterModeOfDefect.'%')
                    // ->where('model_name', 'like', '%'.$request->filterModelSeries.'%')
                    // ->where('reference_number', 'like', '%'.$request->filterReferenceNo.'%')
                    // ->where('pmi_control_number','like', '%'.$request->filterControlNo.'%')
                    // ->where('po_number', 'like', '%'.$request->filterTraceability.'%')
                    // ->where('return_to_vendor', 'like', '%'.$request->filterRTV.'%')
                    // END FILTER QUERY
                    ->get();

        // ADDITIONAL FILTER QUERY
        if($request->filterCustomer != null){
            $customerClaims = collect($customerClaims)->where('customer',$request->filterCustomer);
        }
        if($request->filterSection != null){
            $customerClaims = collect($customerClaims)->where('section',$request->filterSection);
        }
        if($request->filterProductClassification != null){
            $customerClaims = collect($customerClaims)->where('product_classification',$request->filterProductClassification);
        }
        if($request->filterClass != null){
            $customerClaims = collect($customerClaims)->where('defect_category_class',$request->filterClass);
        }
        if($request->filterContributor != null){
            $customerClaims = collect($customerClaims)->where('contributor',$request->filterContributor);
        }
        if($request->filterValidity != null){
            $customerClaims = collect($customerClaims)->where('validity',$request->filterValidity);
        }
        //END ADDITIONAL FILTER

        return DataTables::of($customerClaims)
            ->addColumn('status', function($customerClaim){
                $result = "";
                if($customerClaim->status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Closed</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Open</span></center>';
                }
                return $result;
            })
            ->addColumn('validity', function($customerClaim){
                $result = "";
                if($customerClaim->validity == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Valid</span></center>';
                }
                else if($customerClaim->validity == 2){
                    $result .= '<center><span class="badge badge-pill badge-primary">Information</span></center>';
                }
                else if($customerClaim->validity == 3){
                    $result .= '<center><span class="badge badge-pill badge-info">Feedback</span></center>';
                }
                else if($customerClaim->validity == 4){
                    $result .= '<center><span class="badge badge-pill badge-danger">Invalid</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
                }
                return $result;
            })
            // ->addColumn('action', function($customerClaim){
            //     $result = '<center>';

            //     if($customerClaim->yec_yed_report_file != null){
            //         $result .= '<div class="btn-group">
            //             <a class="btn btn-warning text-light btn-xs text-center actionViewEmail mr-1" href="download_email_attachment/'.$customerClaim->id.'" customer-claim-id="' . $customerClaim->id . '" title="View Email Details">
            //                 <i class="far fa-lg fa-envelope"></i>
            //             </a>
            //         </div>';
            //     }
            //     $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionEditCustomerClaim mr-1" type="button" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalAddCustomerClaim" aria-haspopup="true" aria-expanded="false" title="Edit Claim Details">
            //                     <i class="fa fa-lg fa-edit"></i>
            //                 </button>';
            //     $result .= '<button type="button" class="btn btn-info btn-xs text-center actionViewCustomerClaim mr-1" type="button" view-customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalViewCustomerClaim" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
            //                     <i class="far fa-lg fa-eye"></i>
            //                 </button>';
            //     $result .= '<a href="export?checksheet_id='. $customerClaim->id .'" target="_blank" class="btn btn-secondary btn-xs text-center " style="padding-left: 5px; padding-right: 5px;"><i class="fas fa-lg fa-file-excel"></i></a>';

            //     $result .=  '</center>';
            //     return $result;
            // })
            ->addColumn('action', function($customerClaim){
                $result = '<center><div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Action">
                                <i class="fa fa-lg fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">'; // dropdown-menu start
                $result .= '<button type="button" class="dropdown-item text-center text-center actionViewCustomerClaim mr-1" type="button" view-customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalViewCustomerClaim" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
                        View
                </button>';
                $result .= '<button type="button" class="dropdown-item text-center actionEditCustomerClaim mr-1" type="button" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalAddCustomerClaim" aria-haspopup="true" aria-expanded="false" title="Edit Claim Details">
                                Edit
                            </button>';
                if($customerClaim->yec_yed_report_file != null){
                    $result .= '
                        <a class=" text-center actionViewEmail mr-1 dropdown-item text-center" href="download_email_attachment/'.$customerClaim->id.'" customer-claim-id="' . $customerClaim->id . '" title="View Email Details">
                            Download Email
                        </a>';
                }
                $result .= '<a href="export?checksheet_id='. $customerClaim->id .'" target="_blank" class="dropdown-item text-center" style="padding-left: 5px; padding-right: 5px;">Export Checksheet</a>';

                $result .= '</div>'; // dropdown-menu end
                $result .= '</div></center>';
                return $result;
            })
            ->addColumn('eight_d_report', function($customerClaim){
                $result = "";
                if($customerClaim->eight_report_filename != null){
                    $result .= '<a title="Download 8D Report" href="download_eight_d_report_file/'.$customerClaim->id.'"><i class="far fa-lg fa-file">&nbsp;</i>'.$customerClaim->eight_report_filename.'</a>';
                }
                else{
                    $result .= '<span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">N/A</span>';
                }
                return $result;
            })
            ->addColumn('operation_eight_d_report_filename', function($customerClaim){
                $result = "<center>";
                if($customerClaim->operation_eight_d_report_filename != null){
                    if($customerClaim->status == 0){
                        $result .= '<button class="btn btn-primary text-light btn-sm text-center actionValidateEightDReport" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalValidateEightDReport" aria-haspopup="true" aria-expanded="false" title="Validate Submitted 8D Report">
                                        <i class="far fa-lg fa-eye"></i>&nbsp;View Report
                                    </button></center>';
                    }else{
                        $result .= '<button class="btn btn-success text-light btn-sm text-center actionValidateEightDReport" customer-claim-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalValidateEightDReport" aria-haspopup="true" aria-expanded="false" title="Validated">
                                        <i class="far fa-lg fa-eye"></i>&nbsp;Validated
                                    </button></center>';
                    }
                    // $result .= '<a class="btn btn-info text-light btn-xs text-center" href="download_operation_eight_d_report/'.$customerClaim->id.'"><i class="far fa-lg fa-file">&nbsp;</i>Download 8D Report</a>';

                }
                else{
                    $result .= '<span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">N/A</span></center>';
                }
                return $result;
            })
            ->rawColumns(['status', 'validity','eight_d_report', 'action', 'operation_eight_d_report_filename']) // to format columns as html format
            ->make(true);
    }


    //============================= Get Customer Claim by ID for edit =============================
    public function get_customer_claim_by_id(Request $request){
        $customerClaim = CustomerClaim::where('id', $request->customer_claim_id)->get();
        $email_Recipients = CustomerClaimEmailRecipient::with([
            'email_recipient_info'
        ])->where('customer_claim_id', $request->customer_claim_id)->get();
        return response()->json(['customerClaim' => $customerClaim, 'emailRecipients' => $email_Recipients]);
    }


    //============================= Get Customer Claim by ID for view =============================
    public function get_customer_claim_view_by_id(Request $request){
        $customerClaim = CustomerClaim::where('id', $request->view_customer_claim_id)->get();
        return response()->json(['customerClaim' => $customerClaim]); // pass the $customerClaim(variable) to ajax as a response for retrieving and pass the values on the inputs
    }


    //============================= Get Holiday for Date Picker on Customer Claim ===================
    public function get_holiday_for_date_picker(){
        $holiday = Holiday::where('logdel', 0)->get();
        return response()->json(['holiday' => $holiday]);
    }


    public function download_email_attachment(Request $request, $id){
        $customer_id_for_download = CustomerClaim::where('id', $id)->first();
        // return response()->file( storage_path() . "/app/public/yec_yed_report/" . $customer_id_for_download->yec_yed_report_file);
        $file =  storage_path() . "/app/public/yec_yed_report/" . $customer_id_for_download->yec_yed_report_file;
        return Response::download($file, $customer_id_for_download->yec_yed_report_file);
    }


    public function download_eight_d_report_file(Request $request, $id){
        $customer_id_for_download = CustomerClaim::where('id', $id)->first();
        // return response()->file( storage_path() . "/app/public/yec_yed_report/" . $customer_id_for_download->yec_yed_report_file);
        $file =  storage_path() . "/app/public/eight_d_report/" . $customer_id_for_download->eight_report_filename;
        return Response::download($file, $customer_id_for_download->eight_report_filename);
    }


    public function download_operation_eight_d_report(Request $request, $id){
        $customerClaimInfo = CustomerClaim::where('id', $id)->first();
        // return response()->file( storage_path() . "/app/public/yec_yed_report/" . $customerClaimInfo->yec_yed_report_file);
        $file =  storage_path() . "/app/public/operation_eight_d_report/" . $customerClaimInfo->operation_eight_d_report_filename;
        return Response::download($file, $customerClaimInfo->operation_eight_d_report_filename);
    }

    // Old
    // ================================ Get Customer Claim Control Number =============================
    // public function get_customer_claim_control_number(){
    //     date_default_timezone_set('Asia/Manila');

    //     $get_latest_control_number = CustomerClaim::orderBy('pmi_control_number', 'DESC')->get();

    //     $month = Date('m');
    //     $day = Date('d');
    //     $combined = $month.$day;

    //     if(count($get_latest_control_number) == 0){
    //         $count_control = 001;
    //         $count_control = str_pad($count_control, 3, '0', STR_PAD_LEFT);

    //         return response()->json(['combine_month_day' => $combined, 'control_counter' => $count_control]);

    //     }
    //     else{
    //         $control_number_exploded = explode('-',$get_latest_control_number[0]->pmi_control_number);

    //         $control_number_split =  str_split($control_number_exploded[1],2);


    //         if($month == $control_number_split[0]){
    //             $control_number_exploded[1] = $combined;
    //             $count_control = $control_number_exploded[2] + 1;
    //             $control_number_exploded[2] = str_pad($count_control, 3, '0', STR_PAD_LEFT);
    //         }
    //         else{
    //             $control_number_exploded[1] = $combined;
    //             $count_control = 001;
    //             $control_number_exploded[2] = str_pad($count_control, 3, '0', STR_PAD_LEFT);

    //         }
    //         return response()->json(['combine_month_day' => $control_number_exploded[1], 'control_counter' => $control_number_exploded[2]]);
    //     }
    // }

    /**
     * Original Code
     * 01-31-2023
     * -JD
     */
    // public function get_customer_claim_control_number(){
    //     date_default_timezone_set('Asia/Manila');

    //     $get_latest_control_number = CustomerClaim::orderBy('pmi_control_number', 'DESC')->get();
    //     // return $get_latest_control_number;
    //     $month = Date('m');
    //     $year = Date('y');
    //     $combined = $month.$year;

    //     if(isset($get_latest_control_number)){
    //         if(count($get_latest_control_number) > 0){
    //             // $control_number_exploded = explode('-',$get_latest_control_number[0]->pmi_control_number);
    //             // $control_number_split =  str_split($control_number_exploded[1],2);

    //             // if($month == $control_number_split[0]){
    //             //     $control_number_exploded[1] = $combined;
    //             //     $count_control = $control_number_exploded[2] + 1;
    //             //     $control_number_exploded[2] = str_pad($count_control, 3, '0', STR_PAD_LEFT);
    //             // }
    //             // else{
    //             //     $control_number_exploded[1] = $combined;
    //             //     $count_control = 001;
    //             //     $control_number_exploded[2] = str_pad($count_control, 3, '0', STR_PAD_LEFT);
    //             // }
    //             // return response()->json(['combine_month_day' => $control_number_exploded[1], 'control_counter' => $control_number_exploded[2]]);

    //             $control_number_exploded = explode('-',$get_latest_control_number[0]->pmi_control_number);
    //             $control_number_split =  str_split($control_number_exploded[1],2);

    //             if($month == 04){
    //                 $control_number = CustomerClaim::where('pmi_control_number','like', '%'.$combined.'-001%')->get();

    //                 if(count($control_number) == 0){
    //                     $control_number_exploded[1] = $combined;
    //                     $count_control = 001;
    //                     $control_number_exploded[2] = str_pad($count_control, 3, '0', STR_PAD_LEFT);
    //                 }
    //                 else{
    //                     $control_number_exploded[1] = $combined;
    //                     $count_control = $control_number_exploded[2] + 1;
    //                     $control_number_exploded[2] = str_pad($count_control, 3, '0', STR_PAD_LEFT);
    //                 }
    //             }
    //             else{
    //                 $control_number_exploded[1] = $combined;
    //                 $count_control = $control_number_exploded[2] + 1;
    //                 $control_number_exploded[2] = str_pad($count_control, 3, '0', STR_PAD_LEFT);
    //             }

    //             return response()->json(['combine_month_day' => $control_number_exploded[1], 'control_counter' => $control_number_exploded[2]]);

    //         }
    //         else{
    //             $count_control = '045';
    //             $count_control = str_pad($count_control, 3, '0', STR_PAD_LEFT);
    //             return response()->json(['combine_month_day' => $combined, 'control_counter' => $count_control, 'has latest control number' => 'no']);
    //         }
    //     }
    // }

    public function get_customer_claim_control_number(){
        date_default_timezone_set('Asia/Manila');

        $get_latest_control_number = CustomerClaim::orderBy('item_number', 'DESC')->get();
        // return $get_latest_control_number;
        $month = Date('m');
        // return $month;
        $year = Date('y');
        // return $year;
        $combined = $month.$year;
        // return $combined;
        if(isset($get_latest_control_number)){
            if(count($get_latest_control_number) > 0){
                $control_number_exploded = explode('-',$get_latest_control_number[0]->pmi_control_number);
                // return $control_number_exploded;
                $control_number_split =  str_split($control_number_exploded[1],2);
                // return $control_number_split;

                /**
                 * Check the month if april, for the first quarter of the fiscal year
                 * 01-31-2023
                 */
                if($month == 04){
                    $control_number = CustomerClaim::where('pmi_control_number','like', '%'.$combined.'-001%')->get();

                    if(count($control_number) == 0){
                        $control_number_exploded[1] = $combined;
                        $count_control = 001;
                        $control_number_exploded[2] = str_pad($count_control, 3, '0', STR_PAD_LEFT);
                    }
                    else{
                        $control_number_exploded[1] = $combined;
                        $count_control = $control_number_exploded[2] + 1;
                        $control_number_exploded[2] = str_pad($count_control, 3, '0', STR_PAD_LEFT);
                    }
                }
                else{
                    $control_number_exploded[1] = $combined;
                    $count_control = $control_number_exploded[2] + 1;
                    // return $count_control;
                    $control_number_exploded[2] = str_pad($count_control, 3, '0', STR_PAD_LEFT);
                    // return $control_number_exploded[2];
                }

                return response()->json(['combine_month_day' => $control_number_exploded[1], 'control_counter' => $control_number_exploded[2]]);

            }
            else{
                $count_control = '045';
                $count_control = str_pad($count_control, 3, '0', STR_PAD_LEFT);
                return response()->json(['combine_month_day' => $combined, 'control_counter' => $count_control, 'has latest control number' => 'no']);
            }
        }
    }


    public function get_email_recipients(Request $request){
        date_default_timezone_set('Asia/Manila');

        $search = $request->search;

        if($search == ''){
            $datas = [];
        }
        else{
            $datas = EmailRecipient::orderby('name','asc')->select('id','name', 'user_id')
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->where('email_recipient_status', 1)
                        ->get();
        }

        $response = array();
        $response[] = array(
            "id" => '',
            "text" => '',
            "user_id" => '',
        );

        foreach($datas as $data){
            $response[] = array(
                "id" => $data->id,
                "text" => $data->name,
                "user_id" => $data->user_id,
            );
        }

        echo json_encode($response);
        // exit;
    }


    public function send_email($customer_claim_id){
        // echo "send email \n";
        $customer_claim_result = CustomerClaim::where('id', $customer_claim_id)
                ->with([
                    'customer_details',
                    'product_details',
                    'email_recipient_details',
                    'email_recipient_details.email_recipient_info',
                ])
                ->first();

        /*
            For testing puposes only
            Commented by -JD
        */
        // echo $customer_claim_result;
        // exit(0);

        /*
            For testing puposes only
            Commented by -JD
        */
        // $to_emailarr = [];
        // $to_emailarr = collect($customer_claim_result->email_recipient_details)->where('customer_claim_id', $customer_claim_id)->pluck('email_recipient_info')->flatten(1)->pluck('email')->flatten(1)->toArray();
        // print_r($to_emailarr);
        // exit();

        $to_email = [];
        $cc_email = [];

        $subject = $customer_claim_result->pmi_control_number;
        $model_name = $customer_claim_result->model_name;
        if($customer_claim_result != null){
            $to_email = collect($customer_claim_result->email_recipient_details)->where('type', 1)->pluck('email_recipient_info')->flatten(1)->pluck('email')->flatten(1)->toArray();
            $cc_email = collect($customer_claim_result->email_recipient_details)->where('type', 2)->pluck('email_recipient_info')->flatten(1)->pluck('email')->flatten(1)->toArray();
        }

        $data = [
            'data' => $customer_claim_result,
            'subject' => $subject,
            'subject1' => $model_name
        ];
        // echo(json_encode($data));
        // exit();

        $email_recipients = [
            'to' => $to_email,
            'cc' => $cc_email,
        ];
        // echo(json_encode($email_recipients));
        // exit();

        try {
            $mail = Mail::send('mail.customer_claim_result.customer_claim_email', $data, function($message) use ($email_recipients, $data) {
                $message->to($email_recipients['to'])
                ->cc($email_recipients['cc'])
                ->bcc('cpagtalunan@pricon.ph')
                ->bcc('jdomingo@pricon.ph')
                ->subject('Customer Claim Reminder! '.$data['subject']."_".$data['subject1']);
            });
            return response()->json(['result' => 1]);
        }
        catch (Exception $e) {
            return response()->json(['result' => 0]);
        }
    }


    public function get_customer_for_filter(){
        $customer_list = CustomerClassification::get();
        return response()->json(['result' => $customer_list]);
    }


    public function get_product_classification_for_filter(){
        $product_classification = ProductClassification::get();
        // return $mode_of_defect;
        return response()->json(['result' => $product_classification]);
    }


    // get_data_for_dashboard

    public function get_data_for_dashboard(){
        $pending_claim = CustomerClaim::where('status', 0)->get();
        $total_claim = CustomerClaim::all();
        $product_classification = ProductClassification::all();
        $email_recipient = EmailRecipient::all();
        $customer_classification = CustomerClassification::all();
        // return $pending_claim;
        return response()->json(['pendingClaim' => count($pending_claim), 'totalClaim' => count($total_claim), 'totalProductClassification' => count($product_classification), 'totalEmailRecipient' => count($email_recipient), 'totalCustomerClassification' => count($customer_classification)]);
    }


}
