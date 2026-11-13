<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEightDReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eight_d_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_claim_id')->unsigned()->comment = 'Customer Claim Id';
            $table->tinyInteger('action_code')->nullable()->comment = '1-Root Cause Act, 2-Escapee Cause Act, 3-Systemic Act, 4-Fan-out Act';
            $table->tinyInteger('action_counter')->nullable();
            $table->string('corrective_action')->nullable();
            $table->string('date')->nullable();
            $table->string('person_incharge')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('revision_counter')->nullable();
            // $table->tinyInteger('eight_d_report_status')->nullable();
            // $table->string('eight_d_report_name')->nullable()->comment = '8D Report Name';
            // $table->string('eight_d_report_filename')->nullable()->comment = '8D Report File';
            // $table->date('eight_d_report_date')->nullable()->comment = '8D Report Date';

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
        Schema::dropIfExists('eight_d_reports');
    }
}
