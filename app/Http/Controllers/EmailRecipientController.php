<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\EmailRecipient;
use DataTables;

class EmailRecipientController extends Controller
{
    //============================= Add Email Recipient =============================
    public function add_email_recipient(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
    
        $data = $request->all();
        if(!isset($request->email_recipient_id)){
            $rules = [
                'user_id'       => 'required',
                'email'         => 'required',
                'section'       => 'required',
            ];
    
            $validator = Validator::make($data, $rules);
        
            if($validator->passes()){
                $insert_email_recipient = [
                    'user_id'                   =>  $request->user_id,
                    'email'                     =>  $request->email,
                    'section'                   =>  $request->section,
                    'name'                      =>  $request->recipient_name,
                    'email_recipient_status'    =>  1,
                    'created_by'                =>  $_SESSION["rapidx_user_id"],
                    'last_updated_by'           =>  $_SESSION["rapidx_user_id"],
                    'logdel'                    =>  0,
                    'created_at'                =>  date('Y-m-d H:i:s'),
                    'updated_at'                =>  date('Y-m-d H:i:s')
                ];
    
                EmailRecipient::insert(
                    $insert_email_recipient
                );
                
                return response()->json(['result' => "1"]);
            }else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }else{
            $rules = [
                'user_id'       => 'required',
                'email'         => 'required',
                'section'       => 'required',
            ];
    
            $validator = Validator::make($data, $rules);
        
            if($validator->passes()){
                $update_email_recipient = [
                    'user_id'                   =>  $request->user_id,
                    'email'                     =>  $request->email,
                    'section'                   =>  $request->section,
                    'name'                      =>  $request->recipient_name,
                    'last_updated_by'           =>  $_SESSION["rapidx_user_id"],
                    'updated_at'                =>  date('Y-m-d H:i:s')
                ];
    

                if(isset($request->email_recipient_id)){               
                    EmailRecipient::where('id', $request->email_recipient_id)->update(
                        $update_email_recipient
                    );
                    return response()->json(['result' => "1"]);
                }

                
                return response()->json(['result' => "1"]);
            }else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }
        
    }


    //============================= View Email Recipients for Datatables =============================
    public function view_email_recipient(){
        $emailRecipients = EmailRecipient::
                    where('logdel', 0)->get();
                
        return DataTables::of($emailRecipients)
            ->addColumn('email_recipient_status', function($emailRecipient){
                $result = "";
                if($emailRecipient->email_recipient_status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Inactive</span></center>';
                }
                return $result;
            })
            ->addColumn('action', function($emailRecipient){
                if($emailRecipient->email_recipient_status == 1){
                    $result = '<center><button type="button" class="btn btn-primary btn-xs text-center actionEditEmailRecipient mr-1" type="button" email-recipient-id="' . $emailRecipient->id . '" data-toggle="modal" data-target="#modalAddEmailRecipient" aria-haspopup="true" aria-expanded="false" title="Edit Claim Details">
                                    <i class="fa fa-lg fa-edit"></i> 
                                </button>';
                    $result .= '<button type="button" class="btn btn-danger btn-xs text-center actionDeleteEmailRecipient mr-1" type="button" email-recipient-id="' . $emailRecipient->id . '" data-toggle="modal" status="' . $emailRecipient->email_recipient_status . '" data-target="#modalDeleteEmailRecipient" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
                                    <i class="fas fa-lg fa-trash-alt"></i>
                                </button>';
                                '</center>';
                }else{
                    $result = '<center>
                                    <button type="button" class="btn btn-warning btn-xs text-center actionDeleteEmailRecipient mr-1" type="button" email-recipient-id="' . $emailRecipient->id . '" data-toggle="modal" status="' . $emailRecipient->email_recipient_status . '" data-target="#modalDeleteEmailRecipient" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
                                        <i class="fas fa-lg fa-history"></i>
                                    </button>';
                                '</center>';
                }

                return $result;
            })
            ->rawColumns(['email_recipient_status', 'action']) // to format columns as html format
            ->make(true);
    }


    //============================= Get Email Recipient by ID for edit =============================
    public function get_email_recipient_by_id(Request $request){
        $emailRecipient = EmailRecipient::where('id', $request->email_recipient_id)->get();
        return response()->json(['emailRecipient' => $emailRecipient]); // pass the $customerClaim(variable) to ajax as a response for retrieving and pass the values on the inputs
    }


    //============================== Delete Email Recipient ==============================
    public function delete_email_recipient(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'email_recipient_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            if($request->status == 1){
                EmailRecipient::where('id', $request->email_recipient_id)
                ->update(
                    [
                        'email_recipient_status' => 0,
                        'last_updated_by' => $_SESSION["rapidx_user_id"],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
                return response()->json(['result' => "1"]);
            }else{
                EmailRecipient::where('id', $request->email_recipient_id)
                ->update(
                    [
                        'email_recipient_status' => 1,
                        'last_updated_by' => $_SESSION["rapidx_user_id"],
                        'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );
                    return response()->json(['result' => "1"]);
            }
            

                
            
        } else {
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }


    // Get Email Recipient for Checkbox
    public function get_email_recipient(Request $request){
        $emailRecipients = EmailRecipient::all();
        // return $emailRecipients;
        return response()->json(['emailRecipients' => $emailRecipients]);
    }
}
