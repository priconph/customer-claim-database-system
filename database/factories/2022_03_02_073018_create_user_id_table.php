<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_claim_email_recipients', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->comment = 'RapidX ID on users table';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_claim_email_recipients', function (Blueprint $table) {
            //
        });
    }
}
