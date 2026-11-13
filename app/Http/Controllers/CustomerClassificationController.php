<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\CustomerClassification;
use DataTables;
class CustomerClassificationController extends Controller
{
    //  
    public function add_customer(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
    
        $data = $request->all();
        // return $data;

        if(!isset($request->customer_id)){
            $rules = [
                'customer_name'      => 'required',
                
            ];
           
            $validator = Validator::make($data, $rules);
        
            if($validator->passes()){
                $insert_customer = [
                    'customer_name'          =>  $request->customer_name,
                    'customer_details'       =>  $request->customer_details,
                    'customer_classification_status'    =>  1,
                    'created_by'                =>  $_SESSION["rapidx_user_id"],
                    'logdel'                    =>  0,
                    'created_at'                =>  date('Y-m-d H:i:s'),
                    'updated_at'                =>  date('Y-m-d H:i:s')
                ];
    
                CustomerClassification::insert(
                    $insert_customer
                );
                
                return response()->json(['result' => "1"]);
            }else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }
        else{
            $rules = [
                'customer_name'       => 'required',
                
            ];
    
            $validator = Validator::make($data, $rules);
        
            if($validator->passes()){
                $update_customer_classification = [
                    'customer_name'          =>  $request->customer_name,
                    'customer_details'       =>  $request->customer_details,
                    'last_updated_by'           =>  $_SESSION["rapidx_user_id"],
                    'updated_at'                =>  date('Y-m-d H:i:s')
                ];
    

                if(isset($request->customer_id)){               
                    CustomerClassification::where('id', $request->customer_id)->update(
                        $update_customer_classification
                    );
                    return response()->json(['result' => "1"]);
                }

                
                return response()->json(['result' => "1"]);
            }else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }
        
    }

    public function view_customer(){
        $customer_details = CustomerClassification::
            where('logdel', 0)->get();
        
        return DataTables::of($customer_details)
            ->addColumn('customer_classification_status', function($customer_details){
                $result = "";
                if($customer_details->customer_classification_status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Inactive</span></center>';
                }
                return $result;
            })
            ->addColumn('action', function($customer_details){
                if($customer_details->customer_classification_status == 1){
                    $result = '<center><button type="button" class="btn btn-primary btn-xs text-center actionEditCustomer mr-1" type="button" customer-classification-id="' . $customer_details->id . '" data-toggle="modal" data-target="#modalAddCustomer" aria-haspopup="true" aria-expanded="false" title="Edit Customer Details">
                                    <i class="fa fa-lg fa-edit"></i> 
                                </button>';
                    $result .= '<button type="button" class="btn btn-danger btn-xs text-center actionDeleteCustomer mr-1" type="button" customer-classification-id="' . $customer_details->id . '" data-toggle="modal" status="' . $customer_details->customer_classification_status . '" data-target="#modalDeleteCustomer" aria-haspopup="true" aria-expanded="false" title="View Customer Classification Details">
                                    <i class="fas fa-lg fa-trash-alt"></i>
                                </button>';
                                '</center>';
                }else{
                    $result = '<center>
                                    <button type="button" class="btn btn-warning btn-xs text-center actionDeleteCustomer mr-1" type="button" customer-classification-id="' . $customer_details->id . '" data-toggle="modal" status="' . $customer_details->customer_classification_status . '" data-target="#modalDeleteCustomer" aria-haspopup="true" aria-expanded="false" title="View Customer Classification Details">
                                        <i class="fas fa-lg fa-history"></i>
                                    </button>';
                                '</center>';
                }

                return $result;
            })
        ->rawColumns(['customer_classification_status', 'action']) // to format columns as html format
        ->make(true);
    }

    public function get_customer_by_id(Request $request){
        $customer_details = CustomerClassification::where('id', $request->customerId)->get();
        return response()->json(['result' => $customer_details]);
        
    }

    public function delete_customer_classification(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'customer_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            if($request->status == 1){
                CustomerClassification::where('id', $request->customer_id)
                ->update(
                    [
                        'customer_classification_status' => 0,
                        'last_updated_by' => $_SESSION["rapidx_user_id"],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
                $customer_class_stat = CustomerClassification::where('id', $request->customer_id)->get('customer_classification_status'); // for checking stat of deleted
                return response()->json(['result' => "1", 'status' => $customer_class_stat[0]->customer_classification_status]);
            }else{
                CustomerClassification::where('id', $request->customer_id)
                ->update(
                    [
                        'customer_classification_status' => 1,
                        'last_updated_by' => $_SESSION["rapidx_user_id"],
                        'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );
                    $customer_class_stat = CustomerClassification::where('id', $request->customer_id)->get('customer_classification_status'); // for checking stat of deleted
                    return response()->json(['result' => "1", 'status' => $customer_class_stat[0]->customer_classification_status]);
            }
            
            
        } else {
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }


    // Get Customer Classification for Select
    public function get_customer_classification(Request $request){
        $customerClassifications = CustomerClassification::all();
        return response()->json(['customerClassifications' => $customerClassifications]);
    }
}
