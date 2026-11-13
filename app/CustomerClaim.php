<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\CustomerClassification;
use App\ProductClassification;
use App\CustomerClaimEmailRecipient;
use App\EightDReport;
use App\EightDReportFanOut;
use App\RapidXUser;
use App\EightDReportHistory;

class CustomerClaim extends Model
{
    //

    public function customer_details(){
        return $this->hasOne(CustomerClassification::class, 'id', 'customer');
    }

    public function product_details(){
        return $this->hasOne(ProductClassification::class, 'id', 'product_classification');
    }

    public function email_recipient_details(){
        return $this->hasMany(CustomerClaimEmailRecipient::class, 'customer_claim_id', 'id');
    }

    public function eight_d_report_details(){
        return $this->hasMany(EightDReport::class, 'customer_claim_id', 'id');
    }
    
    public function eight_d_report_fanout_details(){
        return $this->hasMany(EightDReportFanOut::class, 'customer_claim_id', 'id');
    }

    public function rapidx_user(){
        return $this->hasOne(RapidXUser::class, 'id', 'created_by');
    }

    // public function eight_d_report_history_details(){
    //     return $this->hasMany(EightDReportHistory::class, 'customer_claim_id', 'id');
    // }

}
