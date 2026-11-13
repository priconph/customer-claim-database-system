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
use App\CcYecEightDReport;
// use App\Holiday;
// use App\CustomerClassification;
// use App\EmailRecipient;
// use App\CustomerClaimEmailRecipient;
// use DateTime;
// use App\ProductClassification;

class MasterlistController extends Controller
{
    public function view_customer_claim_master_list(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $customer_claim_details = CustomerClaim::with([
            'customer_details',
            'product_details'
        ])
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
        ->get();

        
          // ADDITIONAL FILTER QUERY
        if($request->filterCustomer != null){
            $customer_claim_details = collect($customer_claim_details)->where('customer',$request->filterCustomer);
        }
        if($request->filterSection != null){
            $customer_claim_details = collect($customer_claim_details)->where('section',$request->filterSection);
        }
        if($request->filterProductClassification != null){
            $customer_claim_details = collect($customer_claim_details)->where('product_classification',$request->filterProductClassification);
        }
        if($request->filterClass != null){
            $customer_claim_details = collect($customer_claim_details)->where('defect_category_class',$request->filterClass);
        }
        if($request->filterContributor != null){
            $customer_claim_details = collect($customer_claim_details)->where('contributor',$request->filterContributor);
        }

        if($request->filterStatus != null){
            $customer_claim_details = collect($customer_claim_details)->where('status',$request->filterStatus);
        }
        if($request->filterValidity != null){
            $customer_claim_details = collect($customer_claim_details)->where('validity',$request->filterValidity);
        }
          //END ADDITIONAL FILTER

        return DataTables::of($customer_claim_details)
        ->addColumn('validity', function($customer_claim_details){
            $result = "";
            if($customer_claim_details->validity == 1){
                $result .= '<center><span class="badge badge-pill badge-success">Valid</span></center>';
            }
            else if($customer_claim_details->validity == 2){
                $result .= '<center><span class="badge badge-pill badge-primary">Information</span></center>';
            }
            else if($customer_claim_details->validity == 3){
                $result .= '<center><span class="badge badge-pill badge-info">Feedback</span></center>';
            }
            else if($customer_claim_details->validity == 4){
                $result .= '<center><span class="badge badge-pill badge-danger">Invalid</span></center>';
            }
            else{
                $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
            }
            return $result;
        })
        ->addColumn('actual_response', function($customer_claim_details){
            $result = "";
            if($customer_claim_details->actual_response != null){
                $result .= '<center>'.$customer_claim_details->actual_response.'</center>';
            }else{
                $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
            }
            return $result;
        })
        // ->addColumn('mode_of_defect', function($customer_claim_details){
        //     $result = "";
        //     $result .= $customer_claim_details->mode_of_defect;
        //     return $result;
        // })
        ->addColumn('Automotive', function($customer_claim_details){
            $result = "";
            if($customer_claim_details->automotive == 1){
                    $result .= '<center>Automotive</center>';
            }
            else if($customer_claim_details->automotive == 2){
                    $result .= '<center>Non-Automotive</center>';

            }
            else if($customer_claim_details->automotive == 3){
                    $result .= '<center>N/A</center>';
            }
            return $result;
        })
        ->addColumn('Contributor', function($customer_claim_details){
            $result = "";
            if($customer_claim_details->contributor == 1){
                $result .= '<center>Man</center>';
            }
            else if($customer_claim_details->contributor == 2){
                $result .= '<center>Material</center>';
            }
            else if($customer_claim_details->contributor == 3){
                $result .= '<center>Method</center>';
            }
            else if($customer_claim_details->contributor == 4){
                $result .= '<center>Machine</center>';
            }
            else if($customer_claim_details->contributor == 5){
                $result .= '<center>Environment</center>';
            }
            else if($customer_claim_details->contributor == 6){
                $result .= '<center>N/A</center>';
            }
        
            return $result;
        })
        ->addColumn('Defect Category', function($customer_claim_details){
            $result = "";
            if($customer_claim_details->defect_category_class == 1){
                $result .= '<center>Class A</center>';
            }
            else if($customer_claim_details->defect_category_class == 2){
                $result .= '<center>Class B</center>';
            }
            else if($customer_claim_details->defect_category_class == 3){
                $result .= '<center>Class C</center>';
            }
            else if($customer_claim_details->defect_category_class == 4){
                $result .= '<center>N/A</center>';
            }
        
            return $result;
        })
        ->addColumn('status', function($customer_claim_details){
            $result = "";
            if($customer_claim_details->status == 1){
                $result .= '<center><span class="badge badge-pill badge-success">Closed</span></center>';
            }
            else{
                $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Open</span></center>';
            }
            return $result;
        })
        ->addColumn('quarter', function($customer_claim_details){
            $result = "";
            if($customer_claim_details->quarter == 1){
                $result .= '<center>Quarter 1</center>';
            }
            else if($customer_claim_details->quarter == 2){
                $result .= '<center>Quarter 2</center>';
            }
            else if($customer_claim_details->quarter == 3){
                $result .= '<center>Quarter 3</center>';
            }
            else if($customer_claim_details->quarter == 4){
                $result .= '<center>Quarter 4</center>';
            }
            
            return $result;
        })
        ->addColumn('action', function($customer_claim_details){
            $getYECReportUpload = CcYecEightDReport::where('customer_claim_id', $customer_claim_details->id)->where('logdel',0)->first();
            $getOperationEightDReport = CustomerClaim::where('id', $customer_claim_details->id)->where('logdel',0)->first();
            $result = "";
            if(isset($_SESSION['rapidx_user_level_id'])){
                // if($_SESSION['rapidx_user_level_id'] == 4 || $_SESSION['rapidx_user_level_id'] == 1 || $_SESSION['rapidx_department_id'] == 21 ||  22 || 23){ //added 21-23 for QAD department
                if($_SESSION['rapidx_user_level_id'] == 4 || $_SESSION['rapidx_user_level_id'] == 1 || $_SESSION['rapidx_department_id'] == 21 || $_SESSION['rapidx_department_id'] == 22 || $_SESSION['rapidx_department_id'] == 23){ // revamped :)
                    if(isset($getYECReportUpload)){
                        /**
                         * Old
                         */
                        // $result .= '<center><button type="button" class="btn btn-primary btn-xs text-center btnEditUploadReport mr-1" customer-claim-id = "'.$getYECReportUpload->id.'" type="button" view-customer-claim-id="" data-toggle="modal" data-target="#modalUploadYecEightD" aria-haspopup="true" aria-expanded="false" title="Re-upload YEC 8D Report">
                        //                 <i class="fa fa-lg fa-edit"></i>
                        //             </button>';
                        // $result .= '<a class="btn btn-secondary btn-xs text-center" title="Download YEC 8D Report" href="download_yec_eight_d_attachment/'.$getYECReportUpload->yec_eight_report_filename.'"   style="padding-left: 5px; padding-right: 5px;">
                        //                 <i class="fa fa-file"></i>
                        //             </a></center>';
                        // $result .= '<a class="btn btn-secondary btn-xs text-center" title="Download Operation Final 8D Report" href="download_operation_eight_d_attachment/'.$getOperationEightDReport->operation_eight_d_report_filename.'"   style="padding-left: 5px; padding-right: 5px;">
                        //     <i class="fa fa-file"></i>
                        // </a></center>';

                        $result .= '<center><div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Action">
                                            <i class="fa fa-lg fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">';
                        $result .=          '<button type="button" class="dropdown-item text-center btnEditUploadReport mr-1" customer-claim-id = "'.$getYECReportUpload->id.'" type="button" view-customer-claim-id="" data-toggle="modal" data-target="#modalUploadYecEightD" aria-haspopup="true" aria-expanded="false" title="Re-upload YEC 8D Report">
                                                <i class="fa fa-md fa-edit"></i> Re-upload YEC 8D Report
                                            </button>';
                        $result .=          '<a class="dropdown-item text-center" title="Download YEC 8D Report" href="download_yec_eight_d_attachment/'.$getYECReportUpload->yec_eight_report_filename.'"   style="padding-left: 5px; padding-right: 5px;">
                                                <i class="fa fa-md fa-download" aria-hidden="true"></i> Download YEC 8D Report
                                            </a>';
                        $result .=          '<a class="dropdown-item text-center" title="Download Operation Final 8D Report" href="download_operation_eight_d_attachment/'.$getOperationEightDReport->operation_eight_d_report_filename.'"   style="padding-left: 5px; padding-right: 5px;">
                                                <i class="fa fa-md fa-download" aria-hidden="true"></i> Download Operation Final 8D Report
                                            </a>';
                        $result .=      '</div>';
                        $result .= '</div></center>';
                    }
                    else{
                        /**
                         * Old
                         */
                        // $result .= '<center><button type="button" class="btn btn-primary btn-xs text-center btnUploadReport mr-1" customer-claim-id = "'.$customer_claim_details->id.'" type="button" view-customer-claim-id="" data-toggle="modal" data-target="#modalUploadYecEightD" aria-haspopup="true" aria-expanded="false" title="Upload YEC 8D Report">
                        // <i class="fas fa-lg fa-file-upload"></i>
                        // </button>';
                        // $result .= '<a class="btn btn-secondary btn-xs text-center" title="Download Operation Final 8D Report" href="download_operation_eight_d_attachment/'.$getOperationEightDReport->operation_eight_d_report_filename.'"   style="padding-left: 5px; padding-right: 5px;">
                        //     <i class="fa fa-file"></i>
                        // </a></center>';

                        $result .= '<center><div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Action">
                                            <i class="fa fa-lg fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">';
                        $result .=          '<button type="button" class="dropdown-item text-center btnUploadReport mr-1" customer-claim-id = "'.$customer_claim_details->id.'" type="button" view-customer-claim-id="" data-toggle="modal" data-target="#modalUploadYecEightD" aria-haspopup="true" aria-expanded="false" title="Upload YEC 8D Report">
                                                <i class="fas fa-md fa-file-upload"></i> Upload YEC 8D Report
                                            </button>';
                        $result .=          '<a class="dropdown-item text-center" title="Download Operation Final 8D Report" href="download_operation_eight_d_attachment/'.$getOperationEightDReport->operation_eight_d_report_filename.'"   style="padding-left: 5px; padding-right: 5px;">
                                                <i class="fa fa-md fa-download" aria-hidden="true"></i> Download Operation Final 8D Report
                                            </a>';
                        $result .=      '</div>';
                        $result .= '</div></center>';
                    }
                }
                else{
                    /**
                     * Old
                     */
                    // $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';

                    if(isset($getOperationEightDReport) && $getOperationEightDReport->operation_eight_d_report_filename != null){
                        $result .= '<center><a class="btn btn-primary btn-xs text-center" title="Download Operation Final 8D Report" href="download_operation_eight_d_attachment/'.$getOperationEightDReport->operation_eight_d_report_filename.'"   style="padding-left: 5px; padding-right: 5px;">
                            <i class="fa fa-md fa-file"></i> Download
                        </a></center>';
                    }else{
                        $result .= '<center><span class="badge badge-pill badge-secondary" style="cursor: not-allowed">No 8D Report</span></center>';
                    }
                    
                }
            }
            return $result;
        })
        ->rawColumns(['validity','Automotive', 'Contributor', 'Defect Category','status', 'quarter','action', 'actual_response', 'mode_of_defect'])
        ->make(true);
    }

    public function add_yec_eight_d_report(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        // return $data;
        $rules = [
            'yec_eight_report' => 'required',
            'yec_eight_receive'     => 'required'
        ];

        $validator = Validator::make($data, $rules);

        // EDIT
        if(isset($request->checkbox_eight_d_report)){
            if($validator->passes()){
                $original_filename = $request->file('yec_eight_report')->getClientOriginalName();
                CcYecEightDReport::where('id', $request->edit_id)
                ->update([
                    'yec_eight_report_filename' => $original_filename,
                    'yec_eight_report_date'     => $request->yec_eight_receive,
                    'last_updated_by'           => $_SESSION["rapidx_user_id"],
                ]);

                Storage::putFileAs('public/yec_eight_d_report', $request->yec_eight_report,  $original_filename);
                return response()->json(['result' => 1]);
            }
            else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }
        //INSERT
        else{
            if($validator->passes()){
                $original_filename = $request->file('yec_eight_report')->getClientOriginalName();

                CcYecEightDReport::insert([
                    'customer_claim_id'         => $request->customer_claim_id,
                    'yec_eight_report_filename' => $original_filename,
                    'yec_eight_report_date'     => $request->yec_eight_receive,
                    'created_by'                => $_SESSION["rapidx_user_id"],
                ]);
        
                Storage::putFileAs('public/yec_eight_d_report', $request->yec_eight_report,  $original_filename);

                return response()->json(['result' => 1]);
            }
            else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }

        // $validator = Validator::make($data, $rules);

        // if($validator->passes()){
        //     $original_filename = $request->file('yec_eight_report')->getClientOriginalName();

        //     CcYecEightDReport::insert([
        //         'customer_claim_id'         => $request->customer_claim_id,
        //         'yec_eight_report_filename' => $original_filename,
        //         'yec_eight_report_date'     => $request->yec_eight_receive,
        //         'created_by'                => $_SESSION["rapidx_user_id"],
        //     ]);
    
        //     Storage::putFileAs('public/yec_eight_d_report', $request->yec_eight_report,  $original_filename);

        //     return response()->json(['result' => 1]);
        // }
        // else{
        //     return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        // }
    }
    public function get_yec_upload_for_edit(Request $request){
        $yec_report_details = CcYecEightDReport::with([
            'customer_claim_details'
        ])
        ->where('id',$request->id)->get();

        return response()->json(['result' => $yec_report_details]);
    }


    public function download_yec_eight_d_attachment(Request $requet, $name){
        $file =  storage_path() . "/app/public/yec_eight_d_report/" . $name;
        return Response::download($file, $name);
    }

    public function download_operation_eight_d_attachment($file){
        // return $file;
        $filePath =  storage_path() . "/app/public/operation_eight_d_report/" . $file;
        return Response::download($filePath, $file);
    }
}
