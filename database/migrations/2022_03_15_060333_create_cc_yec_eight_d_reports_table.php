<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcYecEightDReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_yec_eight_d_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_claim_id')->unsigned()->comment = 'Customer Claim Id';
            $table->string('yec_eight_report_filename')->nullable()->comment = 'YEC 8D Report File';
            $table->date('yec_eight_report_date')->nullable()->comment = 'YEC 8D Report Date';

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('last_updated_by')->nullable();
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
        Schema::dropIfExists('cc_yec_eight_d_reports');
    }
}
