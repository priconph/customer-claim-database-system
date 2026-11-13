<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CustomerClaim;

class EightDReportHistory extends Model
{
    public function customer_info(){
        return $this->belongsTo(CustomerClaim::class, 'customer_claim_id');
    }
}
