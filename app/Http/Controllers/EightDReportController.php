<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use Mail;
use DataTables;
use App\CustomerClaim;
use App\EightDReport;
use App\EightDReportFanOut;
use App\Holiday;
use App\EmailRecipient;
use App\EightDReportHistory;
use DateTime;

class EightDReportController extends Controller
{
    public function view_eight_d_report_cn(Request $request){
        session_start();
        $customerClaims = CustomerClaim::with([
                        'customer_details',
                        'eight_d_report_details',
                    ])
                    ->where('section', 'CN')
                    ->where('logdel', 0)
                    ->where('validity', '!=', 2) // Information
                    ->get();

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
            // ->addColumn('validity_status', function($customerClaim){
            //     $result = "";
            //     if($customerClaim->status == 1){
            //         $result .= '<center><span class="badge badge-pill badge-success">Validated</span></center>';
            //     }
            //     else{
            //         $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Pending</span></center>';
            //     }
            //     return $result;
            // })
            ->addColumn('action', function($customerClaim){
                $disabled = '';
                $result = '<center>';

                if(!isset($customerClaim->eight_report_filename)){
                    $disabled = 'disabled';
                }

                if($customerClaim->status != 1){
                    if(isset($customerClaim->operation_eight_d_report_filename)){
                        $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionAddEightDReport mb-1" type="button" edit-data="1" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalEightDReport" aria-haspopup="true" aria-expanded="false" title="Re-upload 8D Report">
                                        <i class="fa fa-lg fa-edit"></i> Edit
                                    </button>';
                    }else{
                        $result .= '<button type="button" '.$disabled.' class="btn btn-primary btn-xs text-center actionAddEightDReport mb-1" type="button" edit-data="0" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalEightDReport" aria-haspopup="true" aria-expanded="false" title="Upload 8D Report">
                                        <i class="fa fa-plus fa-lg"></i> Upload
                                    </button>';
                    }
    
                    if($customerClaim->eight_report_filename != null){
                        $result .= '<br><a class="btn btn-secondary btn-xs text-center" style="width: max-content" title="Download 8D Report" href="download_eight_d_attachment/'. $customerClaim->id .'"   style="padding-left: 5px; padding-right: 5px;">
                                        <i class="fa fa-md fa-file"></i> Download 8D
                                    </a>';
                    }
                    $result .=  '</center>';
                }else{
                    $result .= '<span class="badge badge-pill badge-success" style="width: max-content">Validated</span><br>';
                    /**
                     * added 21,22,23 for QAD department
                     * 05-30-2022
                     */
                    if(isset($_SESSION['rapidx_user_level_id'])){
                        if($_SESSION['rapidx_department_id'] == 1 || $_SESSION['rapidx_department_id'] == 21 || $_SESSION['rapidx_department_id'] == 22 || $_SESSION['rapidx_department_id'] == 23){
                            if(isset($customerClaim->operation_eight_d_report_filename)){
                                $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionReUploadEightDReport mb-1" re-upload="1" style="width: max-content" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalReUploadOperationEightDReport" aria-haspopup="true" aria-expanded="false" title="Re-upload 8D Report">
                                                <i class="fa fa-lg fa-edit"></i> Re-upload Operation 8D Report
                                            </button>';
                            }else{
                                $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionReUploadEightDReport mb-1" re-upload="0" style="width: max-content" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalReUploadOperationEightDReport" aria-haspopup="true" aria-expanded="false" title="Upload 8D Report">
                                                <i class="fa fa-lg fa-edit"></i> Upload Operation 8D Report
                                            </button>';
                            }
                        }
                    }
                    
                    $result .=  '</center>';
                }

                return $result;
            })
            ->rawColumns(['status', 'validity', 'action']) // to format columns as html format
            ->make(true);
    }


    public function view_eight_d_report_ts(Request $request){
        session_start();
        $customerClaims = CustomerClaim::with([
                        'customer_details',
                        'eight_d_report_details',
                    ])
                    ->where('section', 'TS')
                    ->where('logdel', 0)
                    ->where('validity', '!=', 2) // Information
                    ->get();

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
            ->addColumn('action', function($customerClaim){
                $disabled = '';
                $result = '<center>';

                if(!isset($customerClaim->eight_report_filename)){
                    $disabled = 'disabled';
                }

                if($customerClaim->status != 1){
                    if(isset($customerClaim->operation_eight_d_report_filename)){
                        $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionAddEightDReport mb-1" type="button" edit-data="1" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalEightDReport" aria-haspopup="true" aria-expanded="false" title="Re-upload 8D Report">
                                        <i class="fa fa-lg fa-edit"></i> Edit
                                    </button>';
                    }else{
                        $result .= '<button type="button" '.$disabled.' class="btn btn-primary btn-xs text-center actionAddEightDReport mb-1" type="button" edit-data="0" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalEightDReport" aria-haspopup="true" aria-expanded="false" title="Upload 8D Report">
                                        <i class="fa fa-plus fa-lg"></i> Upload
                                    </button>';
                    }
    
                    if($customerClaim->eight_report_filename != null){
                        $result .= '<br><a class="btn btn-secondary btn-xs text-center" style="width: max-content" title="Download 8D Report" href="download_eight_d_attachment/'. $customerClaim->id .'"   style="padding-left: 5px; padding-right: 5px;">
                                        <i class="fa fa-md fa-file"></i> Download 8D
                                    </a>';
                    }
                    $result .=  '</center>';
                }else{
                    $result .= '<span class="badge badge-pill badge-success" style="width: max-content">Validated</span><br>';
                    /**
                     * added 21,22,23 for QAD department
                     * 05-30-2022
                     */
                    if(isset($_SESSION['rapidx_user_level_id'])){
                        if($_SESSION['rapidx_department_id'] == 1 || $_SESSION['rapidx_department_id'] == 21 || $_SESSION['rapidx_department_id'] == 22 || $_SESSION['rapidx_department_id'] == 23){
                            /**
                             * Since the QAD only is allowed on this part
                             * I change the code to re-upload as requested
                             * 11-07-2022
                             */
                            if(isset($customerClaim->operation_eight_d_report_filename)){
                                $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionReUploadEightDReport mb-1" re-upload="1" style="width: max-content" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalReUploadOperationEightDReport" aria-haspopup="true" aria-expanded="false" title="Re-upload 8D Report">
                                                <i class="fa fa-lg fa-edit"></i> Re-upload Operation 8D Report
                                            </button>';
                            }else{
                                $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionReUploadEightDReport mb-1" re-upload="0" style="width: max-content" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalReUploadOperationEightDReport" aria-haspopup="true" aria-expanded="false" title="Upload 8D Report">
                                                <i class="fa fa-lg fa-edit"></i> Upload Operation 8D Report
                                            </button>';
                            }
                        }
                    }
                    
                    $result .=  '</center>';
                }

                return $result;
            })
            ->rawColumns(['status', 'validity', 'action']) // to format columns as html format
            ->make(true);
    }


    public function view_eight_d_report_yf(Request $request){
        session_start();
        $customerClaims = CustomerClaim::with([
                        'customer_details',
                        'eight_d_report_details',
                    ])
                    ->where('section', 'YF')
                    ->where('logdel', 0)
                    ->where('validity', '!=', 2) // Information
                    ->get();

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
            ->addColumn('action', function($customerClaim){
                $disabled = '';
                $result = '<center>';

                if(!isset($customerClaim->eight_report_filename)){
                    $disabled = 'disabled';
                }

                if($customerClaim->status != 1){
                    if(isset($customerClaim->operation_eight_d_report_filename)){
                        $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionAddEightDReport mb-1" type="button" edit-data="1" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalEightDReport" aria-haspopup="true" aria-expanded="false" title="Re-upload 8D Report">
                                        <i class="fa fa-lg fa-edit"></i> Edit
                                    </button>';
                    }else{
                        $result .= '<button type="button" '.$disabled.' class="btn btn-primary btn-xs text-center actionAddEightDReport mb-1" type="button" edit-data="0" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalEightDReport" aria-haspopup="true" aria-expanded="false" title="Upload 8D Report">
                                        <i class="fa fa-plus fa-lg"></i> Upload
                                    </button>';
                    }
    
                    if($customerClaim->eight_report_filename != null){
                        $result .= '<br><a class="btn btn-secondary btn-xs text-center" style="width: max-content" title="Download 8D Report" href="download_eight_d_attachment/'. $customerClaim->id .'"   style="padding-left: 5px; padding-right: 5px;">
                                        <i class="fa fa-md fa-file"></i> Download 8D
                                    </a>';
                    }
                    $result .=  '</center>';
                }else{
                    $result .= '<span class="badge badge-pill badge-success" style="width: max-content">Validated</span><br>';
                    /**
                     * added 21,22,23 for QAD department
                     * 05-30-2022
                     */
                    if(isset($_SESSION['rapidx_user_level_id'])){
                        if($_SESSION['rapidx_department_id'] == 1 || $_SESSION['rapidx_department_id'] == 21 || $_SESSION['rapidx_department_id'] == 22 || $_SESSION['rapidx_department_id'] == 23){
                            if(isset($customerClaim->operation_eight_d_report_filename)){
                                $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionReUploadEightDReport mb-1" style="width: max-content" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalReUploadOperationEightDReport" aria-haspopup="true" aria-expanded="false" title="Re-upload 8D Report">
                                                <i class="fa fa-lg fa-edit"></i> Re-upload Operation 8D Report
                                            </button>';
                            }else{
                                $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionReUploadEightDReport mb-1" style="width: max-content" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalReUploadOperationEightDReport" aria-haspopup="true" aria-expanded="false" title="Upload 8D Report">
                                                <i class="fa fa-lg fa-edit"></i> Upload Operation 8D Report
                                            </button>';
                            }
                        }
                    }
                    
                    $result .=  '</center>';
                }

                return $result;
            })
            ->rawColumns(['status', 'validity', 'action']) // to format columns as html format
            ->make(true);
    }


    public function view_eight_d_report_pps(Request $request){
        session_start();
        $customerClaims = CustomerClaim::with([
                        'customer_details',
                        'eight_d_report_details',
                    ])
                    ->where('section', 'PPS')
                    ->where('logdel', 0)
                    ->where('validity', '!=', 2) // Information
                    ->get();

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
            ->addColumn('action', function($customerClaim){
                $disabled = '';
                $result = '<center>';

                if(!isset($customerClaim->eight_report_filename)){
                    $disabled = 'disabled';
                }

                if($customerClaim->status != 1){
                    if(isset($customerClaim->operation_eight_d_report_filename)){
                        $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionAddEightDReport mb-1" type="button" edit-data="1" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalEightDReport" aria-haspopup="true" aria-expanded="false" title="Re-upload 8D Report">
                                        <i class="fa fa-lg fa-edit"></i> Edit
                                    </button>';
                    }else{
                        $result .= '<button type="button" '.$disabled.' class="btn btn-primary btn-xs text-center actionAddEightDReport mb-1" type="button" edit-data="0" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalEightDReport" aria-haspopup="true" aria-expanded="false" title="Upload 8D Report">
                                        <i class="fa fa-plus fa-lg"></i> Upload
                                    </button>';
                    }
    
                    if($customerClaim->eight_report_filename != null){
                        $result .= '<br><a class="btn btn-secondary btn-xs text-center" style="width: max-content" title="Download 8D Report" href="download_eight_d_attachment/'. $customerClaim->id .'"   style="padding-left: 5px; padding-right: 5px;">
                                        <i class="fa fa-md fa-file"></i> Download 8D
                                    </a>';
                    }
                    $result .=  '</center>';
                }else{
                    $result .= '<span class="badge badge-pill badge-success" style="width: max-content">Validated</span><br>';
                    /**
                     * added 21,22,23 for QAD department
                     * 05-30-2022
                     */
                    if(isset($_SESSION['rapidx_user_level_id'])){
                        if($_SESSION['rapidx_department_id'] == 1 || $_SESSION['rapidx_department_id'] == 21 || $_SESSION['rapidx_department_id'] == 22 || $_SESSION['rapidx_department_id'] == 23){
                            if(isset($customerClaim->operation_eight_d_report_filename)){
                                $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionReUploadEightDReport mb-1" style="width: max-content" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalReUploadOperationEightDReport" aria-haspopup="true" aria-expanded="false" title="Re-upload 8D Report">
                                                <i class="fa fa-lg fa-edit"></i> Re-upload Operation 8D Report
                                            </button>';
                            }else{
                                $result .= '<button type="button" class="btn btn-primary btn-xs text-center actionReUploadEightDReport mb-1" style="width: max-content" eight-d-report-id="' . $customerClaim->id . '" data-toggle="modal" data-target="#modalReUploadOperationEightDReport" aria-haspopup="true" aria-expanded="false" title="Upload 8D Report">
                                                <i class="fa fa-lg fa-edit"></i> Upload Operation 8D Report
                                            </button>';
                            }
                        }
                    }
                    
                    $result .=  '</center>';
                }

                return $result;
            })
            ->rawColumns(['status', 'validity', 'action']) // to format columns as html format
            ->make(true);
    }


    //============================= Get Customer Claim by ID for edit =============================
    public function get_eight_d_report_by_id(Request $request){
        $customerClaim = CustomerClaim::with(['eight_d_report_details', 'eight_d_report_fanout_details'])->where('id', $request->customer_claim_id)->get();
        
        $eightDReportRootCauseAction = CustomerClaim::with('eight_d_report_details')->where('id', $request->customer_claim_id)
        ->whereHas('eight_d_report_details', function ($query){
            $query->where('action_code', 1);
        })
        ->get();

        $eightDReportRevision = $this->get_eight_d_report_revision_by_id($request->customer_claim_id);
        return response()->json(['customerClaim' => $customerClaim, 'eightDReportRootCauseAction' => $eightDReportRootCauseAction, 'eightDReportRevision' => count($eightDReportRevision)]);
    }

    //============================= Get Customer Claim by ID for reupload =============================
    public function get_eight_d_report_by_id_for_reupload(Request $request){
        $customerClaimDetails = CustomerClaim::where('id', $request->customer_claim_id)->get();
        // return $customerClaimDetails;
        return response()->json(['customerClaimDetails' => $customerClaimDetails]);
    }


    public function download_eight_d_attachment(Request $request, $id){
        $eight_d_report_id_for_download = CustomerClaim::where('id', $id)->first();
        // return $eight_d_report_id_for_download;
        $file =  storage_path() . "/app/public/eight_d_report/" . $eight_d_report_id_for_download->eight_report_filename;
        return Response::download($file, $eight_d_report_id_for_download->eight_report_filename);
    }


    public function download_eight_d_report_file(Request $request, $id){
        $customer_id_for_download = CustomerClaim::where('id', $id)->first();
        // return response()->file( storage_path() . "/app/public/yec_yed_report/" . $customer_id_for_download->yec_yed_report_file);
        $file =  storage_path() . "/app/public/eight_d_report/" . $customer_id_for_download->eight_report_filename;
        return Response::download($file, $customer_id_for_download->eight_report_filename);
    }


    public function download_email_attachment(Request $request, $id){
        $customer_id_for_download = CustomerClaim::where('id', $id)->first();
        // return response()->file( storage_path() . "/app/public/yec_yed_report/" . $customer_id_for_download->yec_yed_report_file);
        $file =  storage_path() . "/app/public/yec_yed_report/" . $customer_id_for_download->yec_yed_report_file;
        return Response::download($file, $customer_id_for_download->yec_yed_report_file);
    }


    //============================= Get Submitted 8D Report by Id =============================
    public function get_submitted_eight_d_report_by_id(Request $request){
        // $submittedEightDReport = CustomerClaim::with(['eight_d_report_history_details'])->where('id', $request->customer_claim_id)->get();
        $submittedEightDReport = CustomerClaim::where('id', $request->customer_claim_id)->first();
        $eightDReportRevision = $this->get_eight_d_report_revision_by_id($request->customer_claim_id);
        
        return response()->json(['submittedEightDReport' => $submittedEightDReport, 'eightDReportRevision' => count($eightDReportRevision)]);
    }


    //============================= Get 8D Report Revision by Id =============================
    public function get_eight_d_report_revision_by_id($customer_claim_id){
        // $submittedEightDReport = CustomerClaim::with(['eight_d_report_history_details'])->where('id', $request->customer_claim_id)->get();
        $eightDReportRevision = EightDReportHistory::where('customer_claim_id', $customer_claim_id)->get();
        return $eightDReportRevision;
    }


    public function disapproved_submitted_eight_d_report(Request $request){
        $data = $request->all();
        
        $rules = [];
        $customer_claim_id = $request->customer_claim_id;
        $validator = Validator::make($data, $rules);
        
        if($validator->passes()){
            $operation_sender_by_id = CustomerClaim::where('id', $customer_claim_id)->value('operation_sender_by_id'); // use for send_email_disapproved
            $revision_counter = EightDReportHistory::where('customer_claim_id', $customer_claim_id)->orderBy('id', 'desc')->get();
            if(count($revision_counter) > 0){
                $revision_counter_increment_one = $revision_counter[0]->revision_counter + 1;
                EightDReportHistory::where('id', $customer_claim_id)->insert([
                    'customer_claim_id' => $customer_claim_id,
                    'remarks' => $request->remarks,
                    'revision_counter' => $revision_counter_increment_one,
                    'sender_name' => $request->operation_eight_d_report_sender,
                    // 'created_by' => $request->operation_eight_d_report_sender_rapidx_user_id,
                ]);
                $this->send_email_disapproved($customer_claim_id, $operation_sender_by_id);
                return response()->json(['result' => "1"]);
            }else{
                EightDReportHistory::where('id', $customer_claim_id)->insert([
                    'customer_claim_id' => $customer_claim_id,
                    'remarks' => $request->remarks,
                    'revision_counter' => 1,
                    'sender_name' => $request->operation_eight_d_report_sender,
                    // 'created_by' => $request->operation_eight_d_report_sender_rapidx_user_id,
                ]);
                $this->send_email_disapproved($customer_claim_id, $operation_sender_by_id);
                return response()->json(['result' => "1"]);
            }
        }else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }


    public function approved_submitted_eight_d_report(Request $request){
        date_default_timezone_set('Asia/Manila');

        $rules = [];
        $customer_claim_id = $request->customer_claim_id;
        // $this->send_email_approved($customer_claim_id);
        CustomerClaim::where('id', $customer_claim_id)->update([
            'status' => 1,
            'accepted_at' => date('Y-m-d'),
        ]); 
        return response()->json(['result' => "1"]);
    }


    public function view_eight_d_report_history_test(Request $request){
        $eightDReportHistories = EightDReportHistory::with([
                'customer_info',
            ])
            ->where('customer_claim_id', 1)
            ->where('logdel', 0)
            ->get();
        return $eightDReportHistories;
        // echo $request->customer_claim_id;
        // return DataTables::of($eightDReportHistories)
        //     // ->addColumn('revision_count', function($eightDReportHistory){
        //     //     $result = "";
        //     //     $result .= '<center><span class="badge badge-pill badge-secondary">'.$eightDReportHistory->remarks_counter.'</span></center>';
        //     //     return $result;
        //     // })
        //     // ->addColumn('remarks', function($eightDReportHistory){
        //     //     $result = "";
        //     //     $result .= '<center><span class="badge badge-pill badge-secondary">'.$eightDReportHistory->remarks.'</span></center>';
        //     //     return $result;
        //     // })
        //     ->addColumn('submitted_by', function($eightDReportHistory){
        //         $result = "";
        //         $result .= '<center><span class="badge badge-pill badge-primary">'.$eightDReportHistory->sender_name.'</span></center>';
        //         return $result;
        //     })
        //     ->rawColumns(['submitted_by']) // to format columns as html format
        //     ->make(true);
    }

    public function view_eight_d_report_history(Request $request){
        $eightDReportHistories = EightDReportHistory::with([
                'customer_info',
            ])
            ->where('customer_claim_id', $request->customerClaimId)
            ->where('logdel', 0)
            ->get();
        // return $eightDReportHistories;
        echo $request->customer_claim_id;
        return DataTables::of($eightDReportHistories)
            // ->addColumn('operation_eight_d_report_name', function($eightDReportHistory){
            //     $result = "";
            //     $result .= '<center><span class="badge badge-pill badge-secondary">'.$eightDReportHistory->customer_info->operation_eight_d_report_name.'</span></center>';
            //     return $result;
            // })
            // ->addColumn('operation_eight_d_report_date', function($eightDReportHistory){
            //     $result = "";
            //     $result .= '<center><span class="badge badge-pill badge-secondary">'.$eightDReportHistory->customer_info->operation_eight_d_report_date.'</span></center>';
            //     return $result;
            // })
            // ->addColumn('remarks', function($eightDReportHistory){
            //     $result = "";
            //     $result .= '<center><span class="badge badge-pill badge-secondary">'.$eightDReportHistory->remarks.'</span></center>';
            //     return $result;
            // })
            // ->addColumn('submitted_by', function($eightDReportHistory){
            //     $result = "";
            //     $result .= '<center><span class="badge badge-pill badge-primary">'.$eightDReportHistory->sender_name.'</span></center>';
            //     return $result;
            // })
            ->rawColumns(['submitted_by']) // to format columns as html format
            ->make(true);
    }


    //============================= Add 8D Report Claim =============================
    public function add_eight_d_report(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        /*
            // return response()->json(['data' => $data]);

            // Insert
            // Corrective Action Validation
            // $rules = [
            //     'root_cause_date' => ['required'],
            //     'root_cause_in_charge' => ['required'],
            //     'root_cause_corrective_action' => ['required'],
            //     'root_cause_remarks' => ['required'],

            //     'escapee_cause_date' => ['required'],
            //     'escapee_cause_in_charge' => ['required'],
            //     'escapee_cause_corrective_action' => ['required'],
            //     'escapee_cause_remarks' => ['required'],

            //     'systemic_date' => ['required'],
            //     'systemic_in_charge' => ['required'],
            //     'systemic_corrective_action' => ['required'],
            //     'systemic_remarks' => ['required'],

            //     'fanout_due_date' => ['required'],
            //     'fanout_product_name' => ['required'],
            //     'fanout_in_charge' => ['required'],
            //     'fanout_corrective_action' => ['required'],
            //     'fanout_remarks' => ['required'],
            // ];
            // for ($index=2; $index <= $request->root_cause_action_counter; $index++) { 
            //     if($request->root_cause_action_counter > 1){
            //         $rules["root_cause_date_$index"] = ['required'];
            //         $rules["root_cause_in_charge_$index"] = ['required'];
            //         $rules["root_cause_corrective_action_$index"] = ['required'];
            //         $rules["root_cause_remarks_$index"] = ['required'];
            //     }
            //     else{
            //         $rules["root_cause_date_$index"] = [''];
            //         $rules["root_cause_in_charge_$index"] = [''];
            //         $rules["root_cause_corrective_action_$index"] = [''];
            //         $rules["root_cause_remarks_$index"] = [''];
                    
            //     }
            // }

            // // Escapee Cause Action Validation
            // for ($index=2; $index <= $request->escapee_cause_action_counter; $index++) { 
            //     if($request->escapee_cause_action_counter > 1){
            //         $rules["escapee_cause_date_$index"] = ['required'];
            //         $rules["escapee_cause_in_charge_$index"] = ['required'];
            //         $rules["escapee_cause_corrective_action_$index"] = ['required'];
            //         $rules["escapee_cause_remarks_$index"] = ['required'];
            //     }
            //     else{
            //         $rules["escapee_cause_date_$index"] = [''];
            //         $rules["escapee_cause_in_charge_$index"] = [''];
            //         $rules["escapee_cause_corrective_action_$index"] = [''];
            //         $rules["escapee_cause_remarks_$index"] = [''];
                    
            //     }
            // }

            // // Systemic Action Validation
            // for ($index=2; $index <= $request->systemic_action_counter; $index++) { 
            //     if($request->systemic_action_counter > 1){
            //         $rules["systemic_date_$index"] = ['required'];
            //         $rules["systemic_in_charge_$index"] = ['required'];
            //         $rules["systemic_corrective_action_$index"] = ['required'];
            //         $rules["systemic_remarks_$index"] = ['required'];
            //     }
            //     else{
            //         $rules["systemic_date_$index"] = [''];
            //         $rules["systemic_in_charge_$index"] = [''];
            //         $rules["systemic_corrective_action_$index"] = [''];
            //         $rules["systemic_remarks_$index"] = [''];
                    
            //     }
            // }

            // // Fanout Action Validation
            // for ($index=2; $index <= $request->fanout_action_counter; $index++) { 
            //     if($request->fanout_action_counter > 1){
            //         $rules["fanout_due_date_$index"] = ['required'];
            //         $rules["fanout_product_name_$index"] = ['required'];
            //         $rules["fanout_in_charge_$index"] = ['required'];
            //         $rules["fanout_corrective_action_$index"] = ['required'];
            //         $rules["fanout_remarks_$index"] = ['required'];
            //     }
            //     else{
            //         $rules["fanout_due_date_$index"] = [''];
            //         $rules["fanout_product_name_$index"] = [''];
            //         $rules["fanout_in_charge_$index"] = [''];
            //         $rules["fanout_corrective_action_$index"] = [''];
            //         $rules["fanout_remarks_$index"] = [''];
            //     }
            // }
        */

        $rules = [];
        $customer_claim_id = $request->customer_claim_id;
        $customerClaimDetails = CustomerClaim::where('id', $customer_claim_id)->first();
        if($customerClaimDetails->operation_eight_d_report_filename == null && $customerClaimDetails->operation_eight_d_report_name == null){
            $rules['eight_d_report_file'] = 'required'; // file
            $rules['eight_d_report_filename'] = 'required'; // filename
        }else{
            if(isset($request->checkbox_eight_d_report)){
                $rules['eight_d_report_file'] = 'required'; // file
                $rules['eight_d_report_filename'] = 'required'; // filename
            }else{
                $rules['eight_d_report_file'] = ''; // file
                $rules['eight_d_report_filename'] = ''; // filename
            }
        }

        
        
        $validator = Validator::make($data, $rules);
        if($validator->passes()){
            // // Root Cause Action
            /*
                // EightDReport::where('customer_claim_id', $customer_claim_id)->delete();
                // if($request->root_cause_action_counter > 1){ // Multiple Insert of Root Cause Action
                //     EightDReport::insert([
                //         'customer_claim_id' => $customer_claim_id,
                //         'action_code' => $request->root_cause_action_code,
                //         'action_counter' => 1,
                //         'corrective_action' => $request->root_cause_corrective_action,
                //         'date' => $request->root_cause_date,
                //         'person_incharge' => $request->root_cause_in_charge,
                //         'remarks' => $request->root_cause_remarks,
                //         // 'revision_counter' => $request->txt_po_number_label,
                //         // 'eight_d_report_name' => $request->txt_po_number_label,
                //         // 'eight_d_report_filename' => $request->txt_po_number_label,
                //         'created_by'=> $request->rapidx_user_id,
                //         'created_at' => date('Y-m-d H:i:s'),
                //     ]); 

                //     for($index = 2; $index <= $request->root_cause_action_counter; $index++){
                //         EightDReport::insert([
                //             'customer_claim_id' => $customer_claim_id,
                //             'action_code' => $request->root_cause_action_code,
                //             'action_counter' => $index,
                //             'corrective_action' => $request->input("root_cause_corrective_action_$index"),
                //             'date' => $request->input("root_cause_date_$index"),
                //             'person_incharge' => $request->input("root_cause_in_charge_$index"),
                //             'remarks' => $request->input("root_cause_remarks_$index"),
                //             // 'revision_counter' => $request->txt_po_number_label,
                //             // 'eight_d_report_name' => $request->txt_po_number_label,
                //             // 'eight_d_report_filename' => $request->txt_po_number_label,
                //             'created_by'=> $request->rapidx_user_id,
                //             'created_at' => date('Y-m-d H:i:s'),
                //         ]); 
                //     }
                // }
                // else{ // Single Insert of Root Cause Action
                //     EightDReport::insert([
                //         'customer_claim_id' => $customer_claim_id,
                //         'action_code' => $request->root_cause_action_code,
                //         'action_counter' => 1,
                //         'corrective_action' => $request->root_cause_corrective_action,
                //         'date' => $request->root_cause_date,
                //         'person_incharge' => $request->root_cause_in_charge,
                //         'remarks' => $request->root_cause_remarks,
                //         // 'revision_counter' => $request->txt_po_number_label,
                //         // 'eight_d_report_name' => $request->txt_po_number_label,
                //         // 'eight_d_report_filename' => $request->txt_po_number_label,
                //         'created_by'=> $request->rapidx_user_id,
                //         'created_at' => date('Y-m-d H:i:s'),
                //     ]); 
                // }
                
                // // Escapee Cause Action
                // if($request->escapee_cause_action_counter > 1){ // Multiple Insert of Escapee Cause Action
                //     EightDReport::insert([
                //         'customer_claim_id' => $customer_claim_id,
                //         'action_code' => $request->escapee_cause_action_code,
                //         'action_counter' => 1,
                //         'corrective_action' => $request->escapee_cause_corrective_action,
                //         'date' => $request->escapee_cause_date,
                //         'person_incharge' => $request->escapee_cause_in_charge,
                //         'remarks' => $request->escapee_cause_remarks,
                //         // 'revision_counter' => $request->txt_po_number_label,
                //         // 'eight_d_report_name' => $request->txt_po_number_label,
                //         // 'eight_d_report_filename' => $request->txt_po_number_label,
                //         'created_by'=> $request->rapidx_user_id,
                //         'created_at' => date('Y-m-d H:i:s'),
                //     ]); 
                //     for($index = 2; $index <= $request->escapee_cause_action_counter; $index++){
                //         EightDReport::insert([
                //             'customer_claim_id' => $customer_claim_id,
                //             'action_code' => $request->escapee_cause_action_code,
                //             'action_counter' => $index,
                //             'corrective_action' => $request->input("escapee_cause_corrective_action_$index"),
                //             'date' => $request->input("escapee_cause_date_$index"),
                //             'person_incharge' => $request->input("escapee_cause_in_charge_$index"),
                //             'remarks' => $request->input("escapee_cause_remarks_$index"),
                //             // 'revision_counter' => $request->txt_po_number_label,
                //             // 'eight_d_report_name' => $request->txt_po_number_label,
                //             // 'eight_d_report_filename' => $request->txt_po_number_label,
                //             'created_by'=> $request->rapidx_user_id,
                //             'created_at' => date('Y-m-d H:i:s'),
                //         ]); 
                //     }
                // }
                // else{ // Single Insert of Escapee Cause Action
                //     EightDReport::insert([
                //         'customer_claim_id' => $customer_claim_id,
                //         'action_code' => $request->escapee_cause_action_code,
                //         'action_counter' => 1,
                //         'corrective_action' => $request->escapee_cause_corrective_action,
                //         'date' => $request->escapee_cause_date,
                //         'person_incharge' => $request->escapee_cause_in_charge,
                //         'remarks' => $request->escapee_cause_remarks,
                //         // 'revision_counter' => $request->txt_po_number_label,
                //         // 'eight_d_report_name' => $request->txt_po_number_label,
                //         // 'eight_d_report_filename' => $request->txt_po_number_label,
                //         'created_by'=> $request->rapidx_user_id,
                //         'created_at' => date('Y-m-d H:i:s'),
                //     ]); 
                // }

                // // Systemic Action
                // if($request->systemic_action_counter > 1){ // Multiple Insert of Systemic Action
                //     EightDReport::insert([
                //         'customer_claim_id' => $customer_claim_id,
                //         'action_code' => $request->systemic_action_code,
                //         'action_counter' => 1,
                //         'corrective_action' => $request->systemic_corrective_action,
                //         'date' => $request->systemic_date,
                //         'person_incharge' => $request->systemic_in_charge,
                //         'remarks' => $request->systemic_remarks,
                //         // 'revision_counter' => $request->txt_po_number_label,
                //         // 'eight_d_report_name' => $request->txt_po_number_label,
                //         // 'eight_d_report_filename' => $request->txt_po_number_label,
                //         'created_by'=> $request->rapidx_user_id,
                //         'created_at' => date('Y-m-d H:i:s'),
                //     ]); 
                //     for($index = 2; $index <= $request->systemic_action_counter; $index++){
                //         EightDReport::insert([
                //             'customer_claim_id' => $customer_claim_id,
                //             'action_code' => $request->systemic_action_code,
                //             'action_counter' => $index,
                //             'corrective_action' => $request->input("systemic_corrective_action_$index"),
                //             'date' => $request->input("systemic_date_$index"),
                //             'person_incharge' => $request->input("systemic_in_charge_$index"),
                //             'remarks' => $request->input("systemic_remarks_$index"),
                //             // 'revision_counter' => $request->txt_po_number_label,
                //             // 'eight_d_report_name' => $request->txt_po_number_label,
                //             // 'eight_d_report_filename' => $request->txt_po_number_label,
                //             'created_by'=> $request->rapidx_user_id,
                //             'created_at' => date('Y-m-d H:i:s'),
                //         ]); 
                //     }
                // }
                // else{ // Single Insert of Systemic Action
                //     EightDReport::insert([
                //         'customer_claim_id' => $customer_claim_id,
                //         'action_code' => $request->systemic_action_code,
                //         'action_counter' => 1,
                //         'corrective_action' => $request->systemic_corrective_action,
                //         'date' => $request->systemic_date,
                //         'person_incharge' => $request->systemic_in_charge,
                //         'remarks' => $request->systemic_remarks,
                //         // 'revision_counter' => $request->txt_po_number_label,
                //         // 'eight_d_report_name' => $request->txt_po_number_label,
                //         // 'eight_d_report_filename' => $request->txt_po_number_label,
                //         'created_by'=> $request->rapidx_user_id,
                //         'created_at' => date('Y-m-d H:i:s'),
                //     ]); 
                // }
                
                // // Fanout Action
                // EightDReportFanOut::where('customer_claim_id', $customer_claim_id)->delete();
                // if($request->fanout_action_counter > 1){ // Multiple Insert of Systemic Action
                //     EightDReportFanOut::insert([
                //         'customer_claim_id' => $customer_claim_id,
                //         'action_counter' => 1,
                //         'corrective_action' => $request->fanout_corrective_action,
                //         'product_name' => $request->fanout_product_name,
                //         'person_incharge' => $request->fanout_in_charge,
                //         'due_date' => $request->fanout_due_date,
                //         'remarks' => $request->fanout_remarks,
                //         // 'revision_counter' => $request->txt_po_number_label,
                //         // 'eight_d_report_name' => $request->txt_po_number_label,
                //         // 'eight_d_report_filename' => $request->txt_po_number_label,
                //         'created_by'=> $request->rapidx_user_id,
                //         'created_at' => date('Y-m-d H:i:s'),
                //     ]); 
                //     for($index = 2; $index <= $request->fanout_action_counter; $index++){
                //         EightDReportFanOut::insert([
                //             'customer_claim_id' => $customer_claim_id,
                //             'action_counter' => $index,
                //             'corrective_action' => $request->input("fanout_corrective_action_$index"),
                //             'product_name' => $request->input("fanout_product_name_$index"),
                //             'person_incharge' => $request->input("fanout_in_charge_$index"),
                //             'due_date' => $request->input("fanout_due_date_$index"),
                //             'remarks' => $request->input("fanout_remarks_$index"),
                //             // 'revision_counter' => $request->txt_po_number_label,
                //             // 'eight_d_report_name' => $request->txt_po_number_label,
                //             // 'eight_d_report_filename' => $request->txt_po_number_label,
                //             'created_by'=> $request->rapidx_user_id,
                //             'created_at' => date('Y-m-d H:i:s'),
                //         ]); 
                //     }
                // }
                // else{ // Single Insert of Systemic Action
                //     EightDReportFanOut::insert([
                //         'customer_claim_id' => $customer_claim_id,
                //         'action_counter' => 1,
                //         'corrective_action' => $request->fanout_corrective_action,
                //         'product_name' => $request->fanout_product_name,
                //         'person_incharge' => $request->fanout_in_charge,
                //         'due_date' => $request->fanout_due_date,
                //         'remarks' => $request->fanout_remarks,
                //         // 'revision_counter' => $request->txt_po_number_label,
                //         // 'eight_d_report_name' => $request->txt_po_number_label,
                //         // 'eight_d_report_filename' => $request->txt_po_number_label,
                //         'created_by'=> $request->rapidx_user_id,
                //         'created_at' => date('Y-m-d H:i:s'),
                //     ]); 
                // }
            */
            
            if($customerClaimDetails->operation_eight_d_report_filename == null){
                // Upload 8D Report
                $original_eight_d_report_file = $request->file('eight_d_report_file')->getClientOriginalName();
                Storage::putFileAs('public/operation_eight_d_report', $request->eight_d_report_file,  $original_eight_d_report_file);

                CustomerClaim::where('id', $customer_claim_id)->update([
                    // 8D Report
                    'operation_eight_d_report_name' => $request->eight_d_report_filename,
                    'operation_eight_d_report_filename' => $original_eight_d_report_file,
                    'operation_eight_d_report_date' => date('Y-m-d H:i:s'),
                    'operation_sender_name' => $request->operation_eight_d_report_sender,
                    'operation_sender_by_id' => $request->operation_eight_d_report_sender_by_rapidx_id,
                    'initial_response' => date('Y-m-d H:i:s'),
                    'actual_response' => date('Y-m-d H:i:s'),

                    // Claim Validation
                    'is_the_defect_ng_based_on_specs' => $request->is_the_defect_ng_based_on_specs,
                    'is_the_defect_ng_based_on_specs_remarks' => $request->is_the_defect_ng_based_on_specs_remarks,
                    'is_defect_included_in_pmi' => $request->is_defect_included_in_pmi,
                    'is_defect_included_in_pmi_remarks' => $request->is_defect_included_in_pmi_remarks,
                    'is_defect_detectable_at_pmi' => $request->is_defect_detectable_at_pmi,
                    'is_defect_detectable_at_pmi_remarks' => $request->is_defect_detectable_at_pmi_remarks,
                    'is_unit_undergone_customer_assembly_process' => $request->is_unit_undergone_customer_assembly_process,
                    'is_unit_undergone_customer_assembly_process_remarks' => $request->is_unit_undergone_customer_assembly_process_remarks,
                    'is_defect_contributed_by_pmi' => $request->is_defect_contributed_by_pmi,
                    'is_defect_contributed_by_pmi_remarks' => $request->is_defect_contributed_by_pmi_remarks,
                ]);
            }else{
                if(isset($request->checkbox_eight_d_report)){
                    // Upload 8D Report
                    $original_eight_d_report_file = $request->file('eight_d_report_file')->getClientOriginalName();
                    Storage::putFileAs('public/operation_eight_d_report', $request->eight_d_report_file,  $original_eight_d_report_file);

                    CustomerClaim::where('id', $customer_claim_id)->update([
                        // 8D Report
                        'operation_eight_d_report_name' => $request->eight_d_report_filename,
                        'operation_eight_d_report_filename' => $original_eight_d_report_file,
                        'operation_eight_d_report_date' => date('Y-m-d H:i:s'),
                        'operation_sender_name' => $request->operation_eight_d_report_sender,
                        'operation_sender_by_id' => $request->operation_eight_d_report_sender_by_rapidx_id,
                        'initial_response' => date('Y-m-d H:i:s'),
                        'actual_response' => date('Y-m-d H:i:s'),

                         // Claim Validation
                        'is_the_defect_ng_based_on_specs' => $request->is_the_defect_ng_based_on_specs,
                        'is_the_defect_ng_based_on_specs_remarks' => $request->is_the_defect_ng_based_on_specs_remarks,
                        'is_defect_included_in_pmi' => $request->is_defect_included_in_pmi,
                        'is_defect_included_in_pmi_remarks' => $request->is_defect_included_in_pmi_remarks,
                        'is_defect_detectable_at_pmi' => $request->is_defect_detectable_at_pmi,
                        'is_defect_detectable_at_pmi_remarks' => $request->is_defect_detectable_at_pmi_remarks,
                        'is_unit_undergone_customer_assembly_process' => $request->is_unit_undergone_customer_assembly_process,
                        'is_unit_undergone_customer_assembly_process_remarks' => $request->is_unit_undergone_customer_assembly_process_remarks,
                        'is_defect_contributed_by_pmi' => $request->is_defect_contributed_by_pmi,
                        'is_defect_contributed_by_pmi_remarks' => $request->is_defect_contributed_by_pmi_remarks,
                    ]);
                }else{
                    CustomerClaim::where('id', $customer_claim_id)->update([
                        // Claim Validation
                        'is_the_defect_ng_based_on_specs' => $request->is_the_defect_ng_based_on_specs,
                        'is_the_defect_ng_based_on_specs_remarks' => $request->is_the_defect_ng_based_on_specs_remarks,
                        'is_defect_included_in_pmi' => $request->is_defect_included_in_pmi,
                        'is_defect_included_in_pmi_remarks' => $request->is_defect_included_in_pmi_remarks,
                        'is_defect_detectable_at_pmi' => $request->is_defect_detectable_at_pmi,
                        'is_defect_detectable_at_pmi_remarks' => $request->is_defect_detectable_at_pmi_remarks,
                        'is_unit_undergone_customer_assembly_process' => $request->is_unit_undergone_customer_assembly_process,
                        'is_unit_undergone_customer_assembly_process_remarks' => $request->is_unit_undergone_customer_assembly_process_remarks,
                        'is_defect_contributed_by_pmi' => $request->is_defect_contributed_by_pmi,
                        'is_defect_contributed_by_pmi_remarks' => $request->is_defect_contributed_by_pmi_remarks,
                    ]);
                }
            }
            
            $this->send_email($customer_claim_id);
            // $this->send_email($customer_claim_id, $operation_eight_d_report_sender_by_rapidx_id); // to be used
            
            return response()->json(['result' => "1"]);
        }else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }


    // Send Email for checking
    public function send_email($customer_claim_id){
        $customer_claim_result = CustomerClaim::where('id', $customer_claim_id)
                ->with([
                    'customer_details',
                    'product_details',
                    'email_recipient_details',
                    'email_recipient_details.email_recipient_info',
                ])
                ->first();

        $email_recipient_to = EmailRecipient::where('user_id', 169) // 169 - Sir Shernan
                ->value('email');
        $email_recipient_cc = EmailRecipient::where('user_id', 11) // 11 - Ma'am Josephine
                ->value('email');   
        /*
            For testing puposes only
            Commented by -JD
        */
        // echo $email_recipient;
        // exit(0);

        $subject = "For Checking - 8D Report Submission_".$customer_claim_result->pmi_control_number."_".$customer_claim_result->model_name;

        $data = [
            'data' => $customer_claim_result,
            'subject' => $subject,
        ];
        // echo(json_encode($data));
        // exit();

        $email_recipients = [
            'to' => $email_recipient_to,
            'cc' => $email_recipient_cc,
        ];
        // echo(json_encode($email_recipients));
        // exit();

        try {
            $mail = Mail::send('mail.operation_eight_d_report.operation_eight_d_submission_email', $data, function($message) use ($email_recipients, $data) {
                $message->to($email_recipients['to'])
                ->cc($email_recipients['cc'])
                ->bcc('jdomingo@pricon.ph')
                ->subject($data['subject']);
            });
            return response()->json(['result' => 1]);
        } 
        catch (Exception $e) {
            return response()->json(['result' => 0]);
        }
    }


    // Send Email for disapproved
    public function send_email_disapproved($customer_claim_id, $sender_rapidx_user_id){
        $customer_claim_result = CustomerClaim::where('id', $customer_claim_id)
        ->with([
            'customer_details',
            'product_details',
            'email_recipient_details',
            'email_recipient_details.email_recipient_info',
        ])
        ->first();


        $email_recipient_to = EmailRecipient::where('user_id', $sender_rapidx_user_id) // based on the operation_rapidx_user_id
                ->value('email');
        $email_recipient_cc = EmailRecipient::where('user_id', 169) // 11 - Ma'am Josephine // 169 - Sir Shernan
                ->value('email');
        /*
            For testing puposes only
            Commented by -JD
        */
        // echo $email_recipient;
        // exit(0);

        $subject = "For Revision of 8D Report_".$customer_claim_result->pmi_control_number."_".$customer_claim_result->model_name;

        $data = [
            'data' => $customer_claim_result,
            'subject' => $subject,
        ];

        $email_recipients = [
            'to' => $email_recipient_to,
            'cc' => $email_recipient_cc,
        ];
        // echo(json_encode($email_recipients));
        // exit();

        try {
            $mail = Mail::send('mail.operation_eight_d_report.for_revision_eight_d_report_email', $data, function($message) use ($email_recipients, $data) {
                $message->to($email_recipients['to'])
                ->cc($email_recipients['cc'])
                ->bcc('jdomingo@pricon.ph')
                ->subject($data['subject']);
            });
            return response()->json(['result' => 1]);
        }
        catch (Exception $e) {
            return response()->json(['result' => 0]);
        }
    }

    
    // public function send_email_disapprovedxxx($customer_claim_id, $sender_rapidx_user_id){
    //     $customerDetails = CustomerClaim::where('id', $customer_claim_id)
    //             ->with([
    //                 'customer_details',
    //                 'product_details',
    //                 'email_recipient_details',
    //                 'email_recipient_details.email_recipient_info',
    //             ])
    //             ->first();
    //     $senderEmail = EmailRecipient::where('user_id', $sender_rapidx_user_id)->value('email');

    //     // $to_email = [];
    //     // $cc_email = [];

    //     // if($customerDetails != null){
    //     //     $to_email = collect($customerDetails->email_recipient_details)->where('type', 1)->pluck('email_recipient_info')->flatten(1)->pluck('email')->flatten(1)->toArray();
    //     //     $cc_email = collect($customerDetails->email_recipient_details)->where('type', 2)->pluck('email_recipient_info')->flatten(1)->pluck('email')->flatten(1)->toArray();
    //     // }

    //     // print_r($to_email);
    //     // print_r($cc_email);
    //     // return;

    //     $to_email = [];
    //     $cc_email = [];

    //     $email_recipient_cc_shernan = EmailRecipient::where('user_id', 190) // 169 - Sir Shernan
    //             ->value('email');
    //     $email_recipient_cc_josephine = EmailRecipient::where('user_id', 216) // 11 - Ma'am Josephine
    //             ->value('email');
        
    //     // echo $email_recipient_cc_josephine;
    //     // echo $email_recipient_cc_shernan;
    //     // return;
    //     $subject = "For Revision of 8D Report";

    //     $cc_email[] = $email_recipient_cc_shernan;
    //     $cc_email[] = $email_recipient_cc_josephine;

    //     if($customerDetails != null){
    //         $to_email = collect($customerDetails->email_recipient_details)->where('type', 1)->pluck('email_recipient_info')->flatten(1)->pluck('email')->flatten(1)->toArray();
    //         // $to_email[] = $senderEmail;
    //         // $to_email[] = collect($senderEmail)->flatten(1)->toArray();
    //     }

    //     /*
    //         For testing puposes only
    //         Commented by -JD
    //     */


    //     $data = [
    //         'data' => $customerDetails,
    //         'subject' => $subject
    //     ];

    //     $email_recipients = [
    //         'to' => $to_email,
    //         'cc' => $cc_email,
    //     ];

    //     // print_r($email_recipients);
    //     // print_r($to_email);
    //     // exit();
    //     // return;

    //     try {
    //         $mail = Mail::send('mail.operation_eight_d_report.for_revision_eight_d_report_email', $data, function($message) use ($email_recipients, $data) {
    //             $message->to($email_recipients['to'])
    //             ->cc([$email_recipients['co']])
    //             ->subject($data['subject']);
    //         });
    //         return response()->json(['result' => 1]);
    //     } 
    //     catch (Exception $e) {
    //         return response()->json(['result' => 0]);
    //     }
    // }

    public function upload_operation_eight_d_report_for_validated_claim(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        $rules = [];
        $customer_claim_id = $request->customer_claim_id;
        $customerClaimDetails = CustomerClaim::where('id', $customer_claim_id)->first();
        // return $data;

        if($customerClaimDetails->operation_eight_d_report_filename == null && $customerClaimDetails->operation_eight_d_report_name == null){
            $rules['eight_d_report_file'] = 'required'; // file
            $rules['eight_d_report_filename'] = 'required'; // filename
        }else{
            if(isset($request->checkbox_operation_eight_d_report)){
                $rules['eight_d_report_file'] = 'required'; // file
                $rules['eight_d_report_filename'] = 'required'; // filename
            }
        }

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
            if(isset($request->checkbox_operation_eight_d_report)){
                // Re-upload 8D Report
                $original_eight_d_report_file = $request->file('eight_d_report_file')->getClientOriginalName();
                Storage::putFileAs('public/operation_eight_d_report', $request->eight_d_report_file,  $original_eight_d_report_file);

                CustomerClaim::where('id', $customer_claim_id)->update([
                    // 8D Report
                    'operation_eight_d_report_name' => $request->eight_d_report_filename,
                    'operation_eight_d_report_filename' => $original_eight_d_report_file,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'last_updated_by' => $_SESSION["rapidx_user_id"],
                ]);
            }else{
                // Upload 8D Report
                $original_eight_d_report_file = $request->file('eight_d_report_file')->getClientOriginalName();
                Storage::putFileAs('public/operation_eight_d_report', $request->eight_d_report_file,  $original_eight_d_report_file);

                CustomerClaim::where('id', $customer_claim_id)->update([
                    // 8D Report
                    'operation_eight_d_report_name' => $request->eight_d_report_filename,
                    'operation_eight_d_report_filename' => $original_eight_d_report_file,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'last_updated_by' => $_SESSION["rapidx_user_id"],
                ]);
            }
            return response()->json(['result' => "1"]);
        }else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }
}
