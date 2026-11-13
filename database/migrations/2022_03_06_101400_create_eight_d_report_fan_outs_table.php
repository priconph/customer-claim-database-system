<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEightDReportFanOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eight_d_report_fan_outs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_claim_id')->unsigned()->comment = 'Customer Claim Id';
            $table->tinyInteger('action_counter')->nullable();
            $table->string('corrective_action')->nullable();
            $table->string('product_name')->nullable();
            $table->string('person_incharge')->nullable();
            $table->string('due_date')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('revision_counter')->nullable();
            // $table->tinyInteger('eight_d_report_fan_out_status')->nullable();
            
            // Defaults
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('logdel')->nullable()->default(0)->comment = '0-active, 1-deleted';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eight_d_report_fan_outs');
    }
}
