<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CustomerClaim;

class CcYecEightDReport extends Model
{
    public function customer_claim_details(){
        return $this->hasOne(CustomerClaim::class, 'id', 'customer_claim_id');
    }
}
