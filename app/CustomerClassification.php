<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerClassification extends Model
{
    public function customer_details(){
        return $this->hasOne(EmailRecipient::class, 'id', 'email_recipient_id');
    }
}
