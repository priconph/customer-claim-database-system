<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_claims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_number')->default(1);
            $table->string('quarter');
            $table->string('validity');
            $table->date('date_received')->nullable();
            $table->date('actual_date_received_claim')->nullable();
            $table->date('date_return_of_claim')->nullable();
            $table->date('required_reply')->nullable();
            $table->string('original_filename')->nullable()->comment = 'Issued Report for Operations';
            $table->string('section')->comment = 'CN/TS/YF/PPS';
            $table->string('pmi_control_number')->nullable();
            $table->string('reference_number')->nullable()->comment = 'From Customer';
            $table->string('product_classification');
            $table->string('customer');
            $table->string('model_name');
            $table->string('mode_of_defect')->nullable();
            $table->date('shipment_date')->nullable();
            $table->string('shipment_quantity')->nullable();
            $table->string('po_number')->nullable()->comment = 'PO number';
            $table->string('lot_traceability')->nullable()->comment = 'Lot Traceability';
            $table->string('disposition_lot')->nullable();
            $table->string('automotive');
            $table->string('quantity')->nullable();
            $table->integer('number_of_ng')->nullable();
            $table->string('return_to_vendor')->nullable();
            $table->string('sender_name')->nullable();
            $table->date('send_date')->nullable();
            $table->string('contributor');
            $table->string('defect_category_class')->comment = 'Class A, Class B, Class C';
            $table->string('yec_yed_report_name')->nullable();
            $table->date('yec_yed_report_date')->nullable();
            $table->string('yec_yed_report_file')->nullable()->comment = 'From YEC Report, Ref. Only';
            $table->string('eight_report_name')->nullable()->comment = '8D Report Name';
            $table->string('eight_report_filename')->nullable()->comment = '8D Report File';
            $table->date('eight_report_date')->nullable()->comment = '8D Report Date';
            $table->date('initial_response')->nullable();
            $table->date('actual_response')->nullable();
            $table->string('turn_around_time')->nullable();
            $table->tinyInteger('status')->default(0)->nullable()->comment = '0-Open, 1-Closed';
            $table->string('initial_report')->nullable()->comment = 'N/A or Released';
            $table->tinyInteger('final_report')->nullable()->comment = '1-On time, 2-Late Submission';
            $table->string('remarks')->nullable();

            
            // Data Verification
            $table->tinyInteger('is_po_number_traceable')->nullable()->default(null);
            $table->string('is_po_number_traceable_remarks')->nullable()->default(null);
            
            $table->tinyInteger('is_lot_identification_match')->nullable()->default(null);
            $table->string('is_lot_identification_match_remarks')->nullable()->default(null);

            $table->tinyInteger('are_there_wip_fgs_affected')->nullable()->default(null);
            $table->string('are_there_wip_fgs_affected_remarks')->nullable()->default(null);

            $table->tinyInteger('is_sorting_reworking_necessary')->nullable()->default(null);
            $table->string('is_sorting_reworking_necessary_remarks')->nullable()->default(null);

            $table->tinyInteger('is_sorting_needed')->nullable()->default(null);
            $table->string('is_sorting_needed_remarks')->nullable()->default(null);

            $table->tinyInteger('is_shipment_affected')->nullable()->default(null);
            $table->string('is_shipment_affected_remarks')->nullable()->default(null);

            $table->tinyInteger('are_data_needed_complete_available')->nullable()->default(null);
            $table->string('are_data_needed_complete_available_remarks')->nullable()->default(null);

            $table->tinyInteger('does_customer_requests_production_record')->nullable()->default(null);
            $table->string('does_customer_requests_production_record_remarks')->nullable()->default(null);

            $table->tinyInteger('are_there_clarifications_needed_to_settle')->nullable()->default(null);
            $table->string('are_there_clarifications_needed_to_settle_remarks')->nullable()->default(null);


            // Unit Verification
            $table->tinyInteger('is_actual_ng_unit_available')->nullable()->default(null);
            $table->string('is_actual_ng_unit_available_remarks')->nullable()->default(null);

            $table->tinyInteger('is_unit_bearing_pmi_identification_mark')->nullable()->default(null);
            $table->string('is_unit_bearing_pmi_identification_mark_remarks')->nullable()->default(null);

            $table->tinyInteger('is_claim_defect_identified_by_customer')->nullable()->default(null);
            $table->string('is_claim_defect_identified_by_customer_remarks')->nullable()->default(null);
            
            $table->tinyInteger('does_customer_requires_official_capa_report')->nullable()->default(null);
            $table->string('does_customer_requires_official_capa_report_remarks')->nullable()->default(null);


            // 8D Report from operation
            $table->string('operation_eight_d_report_name')->nullable()->comment = 'Operation 8D Report Name';
            $table->string('operation_eight_d_report_filename')->nullable()->comment = 'Operation 8D Report File';
            $table->date('operation_eight_d_report_date')->nullable()->comment = 'Operation 8D Report Date';
            $table->string('operation_sender_name')->nullable()->comment = 'Operation 8D Report Sender Name';
            $table->string('operation_sender_by_id')->nullable()->comment = 'Operation 8D Report Sender By RapidX Id';
            
            // Claim Validation
            $table->tinyInteger('is_the_defect_ng_based_on_specs')->nullable();
            $table->string('is_the_defect_ng_based_on_specs_remarks')->nullable();

            $table->tinyInteger('is_defect_included_in_pmi')->nullable();
            $table->string('is_defect_included_in_pmi_remarks')->nullable();

            $table->tinyInteger('is_defect_detectable_at_pmi')->nullable();
            $table->string('is_defect_detectable_at_pmi_remarks')->nullable();

            $table->tinyInteger('is_unit_undergone_customer_assembly_process')->nullable();
            $table->string('is_unit_undergone_customer_assembly_process_remarks')->nullable();

            $table->tinyInteger('is_defect_contributed_by_pmi')->nullable();
            $table->string('is_defect_contributed_by_pmi_remarks')->nullable();


            // Defaults
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('last_updated_by')->unsigned();
            $table->bigInteger('logdel')->nullable()->default(0)->comment = '0-active, 1-deleted';
            $table->timestamps();

            // Foreign Key
            // $table->foreign('created_by')->references('id')->on('users');
            // $table->foreign('last_updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_claims');
    }
}
