<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RapidXDepartment;


class EmailRecipient extends Model
{

    public function department_info(){
        return $this->hasOne(RapidXDepartment::class, 'id', 'section');
    }
}
