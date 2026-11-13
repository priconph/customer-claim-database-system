<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\EmailRecipient;
use App\CustomerClaim;

class CustomerClaimEmailRecipient extends Model
{
    public function email_recipient_info(){
        return $this->hasOne(EmailRecipient::class, 'id', 'email_recipient_id');
    }
    
    // public function email_recipient_details(){
    //     return $this->hasOne(CustomerClaim::class, 'id', 'customer_claim_id');
    // }
}
