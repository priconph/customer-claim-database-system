<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEightDReportHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eight_d_report_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_claim_id')->unsigned()->comment = 'Customer Claim Id';
            $table->string('remarks')->nullable();
            $table->tinyInteger('revision_counter')->nullable()->default(0);
            $table->string('sender_name')->nullable();
            $table->integer('created_by')->nullable();
            
            // Defaults
            // $table->bigInteger('created_by')->unsigned();
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
        Schema::dropIfExists('eight_d_report_histories');
    }
}
