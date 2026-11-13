<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\ChecksheetExport;
use App\CustomerClaim;

class ChecksheetExportController extends Controller
{
    //
    public function export(Request $request) 
    {
        $claim_info = CustomerClaim::with([
            'customer_details',
            'product_details',
            'rapidx_user'
        ])
        ->where('id', $request->checksheet_id)->get();
        // return $claim_info;
        // $date = date('Ymd',strtotime(NOW()));
        return Excel::download(new ChecksheetExport($claim_info), 'Checksheet_'.$claim_info[0]->pmi_control_number.'.xlsx');
    }
}
