<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\ProductClassification;
use DataTables;

class ProductClassificationController extends Controller
{
    //============================= Add Product Classification =============================
    public function add_product_classification(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
    
        $data = $request->all();
        if(!isset($request->product_classification_id)){
            $rules = [
                'product_name'      => 'required',
                // 'product_details'   => 'required',
            ];
    
            $validator = Validator::make($data, $rules);
        
            if($validator->passes()){
                $insert_product_classification = [
                    'product_name'          =>  $request->product_name,
                    'product_details'       =>  $request->product_details,
                    'product_classification_status'    =>  1,
                    'created_by'                =>  $_SESSION["rapidx_user_id"],
                    'logdel'                    =>  0,
                    'created_at'                =>  date('Y-m-d H:i:s'),
                    'updated_at'                =>  date('Y-m-d H:i:s')
                ];
    
                ProductClassification::insert(
                    $insert_product_classification
                );
                
                return response()->json(['result' => "1"]);
            }else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }else{
            $rules = [
                'product_name'       => 'required',
                // 'product_details'         => 'required',
            ];
    
            $validator = Validator::make($data, $rules);
        
            if($validator->passes()){
                $update_product_classification = [
                    'product_name'          =>  $request->product_name,
                    'product_details'       =>  $request->product_details,
                    'last_updated_by'           =>  $_SESSION["rapidx_user_id"],
                    'updated_at'                =>  date('Y-m-d H:i:s')
                ];
    

                if(isset($request->product_classification_id)){               
                    ProductClassification::where('id', $request->product_classification_id)->update(
                        $update_product_classification
                    );
                    return response()->json(['result' => "1"]);
                }

                
                return response()->json(['result' => "1"]);
            }else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }
    }


    //============================= View Product Classification for Datatables =============================
    public function view_product_classification(){
        $productClassifications = ProductClassification::
                    where('logdel', 0)->get();
                
        return DataTables::of($productClassifications)
            ->addColumn('product_classification_status', function($productClassification){
                $result = "";
                if($productClassification->product_classification_status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Inactive</span></center>';
                }
                return $result;
            })
            ->addColumn('action', function($productClassification){
                if($productClassification->product_classification_status == 1){
                    $result = '<center><button type="button" class="btn btn-primary btn-xs text-center actionEditProductClassification mr-1" type="button" product-classification-id="' . $productClassification->id . '" data-toggle="modal" data-target="#modalAddProductClassification" aria-haspopup="true" aria-expanded="false" title="Edit Product Classification Details">
                                    <i class="fa fa-lg fa-edit"></i> 
                                </button>';
                    $result .= '<button type="button" class="btn btn-danger btn-xs text-center actionDeleteProductClassification mr-1" type="button" product-classification-id="' . $productClassification->id . '" data-toggle="modal" status="' . $productClassification->product_classification_status . '" data-target="#modalDeleteProductClassification" aria-haspopup="true" aria-expanded="false" title="View Product Classification Details">
                                    <i class="fas fa-lg fa-trash-alt"></i>
                                </button>';
                                '</center>';
                }else{
                    $result = '<center>
                                    <button type="button" class="btn btn-warning btn-xs text-center actionDeleteProductClassification mr-1" type="button" product-classification-id="' . $productClassification->id . '" data-toggle="modal" status="' . $productClassification->product_classification_status . '" data-target="#modalDeleteProductClassification" aria-haspopup="true" aria-expanded="false" title="View Product Classification Details">
                                        <i class="fas fa-lg fa-history"></i>
                                    </button>';
                                '</center>';
                }

                return $result;
            })
            ->rawColumns(['product_classification_status', 'action']) // to format columns as html format
            ->make(true);
    }


    //============================= Get Product Classification by ID for edit =============================
    public function get_product_classification_by_id(Request $request){
        $productClassification = ProductClassification::where('id', $request->product_classification_id)->get();
        return response()->json(['productClassification' => $productClassification]); // pass the $customerClaim(variable) to ajax as a response for retrieving and pass the values on the inputs
    }


    //============================== Delete Product Classification ==============================
    public function delete_product_classification(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'product_classification_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            if($request->status == 1){
                ProductClassification::where('id', $request->product_classification_id)
                ->update(
                    [
                        'product_classification_status' => 0,
                        'last_updated_by' => $_SESSION["rapidx_user_id"],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
                $product_class_stat = ProductClassification::where('id', $request->product_classification_id)->get('product_classification_status'); // for checking stat of deleted
                return response()->json(['result' => "1", 'status' => $product_class_stat[0]->product_classification_status]);
            }else{
                ProductClassification::where('id', $request->product_classification_id)
                ->update(
                    [
                        'product_classification_status' => 1,
                        'last_updated_by' => $_SESSION["rapidx_user_id"],
                        'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );
                    $product_class_stat = ProductClassification::where('id', $request->product_classification_id)->get('product_classification_status'); // for checking stat of deleted
                    return response()->json(['result' => "1", 'status' => $product_class_stat[0]->product_classification_status]);
            }
            
            
        } else {
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }


    // Get Product Classification for Select
    public function get_product_classification(Request $request){
        $productClassifications = ProductClassification::all();
        return response()->json(['productClassifications' => $productClassifications]);
    }
}
