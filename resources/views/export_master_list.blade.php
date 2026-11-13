@php $layout = 'layouts.super_user_layout'; @endphp

@php
    if(!isset($_SESSION['rapidx_user_level_id']) && empty($_SESSION['rapidx_user_level_id'])){
        session_start();
    }
@endphp
@php
    if(isset($_SESSION['rapidx_user_level_id']) && !empty($_SESSION['rapidx_user_level_id'])){
        if($_SESSION['qad_session_user_level_id'] == 4 || $_SESSION['rapidx_user_level_id'] == 1){ // 4-QAD Admin or 1-Super User
            $layout = 'layouts.super_user_layout';
        }
        else if($_SESSION['qad_session_user_level_id'] == 5){ // 5-Other Section
            $layout = 'layouts.admin_layout';
        }else{
            echo '<script type="text/javascript">
                    alert("Session Expired! Please Re-login");
                    window.location = "../RapidX/";
                </script>';
        }
    }else{
        echo '<script type="text/javascript">
                alert("Session Expired! Please Re-login");
                window.location = "../RapidX/";
            </script>';
    }
@endphp

{{-- Here I removed the @auth because the dashboard isn't loading properly --}}
@extends($layout)
@section('title', 'Master List')

@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Export Master List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Export Master List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="margin-bottom: 80px;">
                            <div class="card-header">
                                <h3 class="card-title" style="margin-top: 8px;">Export Master List</h3>
                                {{-- <button class="btn float-right reload"><i class="fas fa-sync-alt"></i></button> --}}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-10 col-lg-9 col-xl-6 pt-1">
                                        <form method="get" id="formDateRange">
                                            <div class="input-group input-group-sm mb-3">
                                                <!-- From -->
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Date Range From:</span>
                                                </div>
                                                <input type="date" class="form-control" name="from" id="dateRangeFrom" style="min-width: 70px;">
                                                
                                                <!-- To -->
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">To:</span>
                                                </div>
                                                <input type="date" class="form-control" name="to" id="dateRangeTo" style="min-width: 70px;">
                                                
                                                <!-- Search -->
                                                <div class="input-group-prepend">
                                                    <button type="submit" class="btn btn-info" id=""><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-12 col-md-2 col-lg-3 col-xl-6 text-right">
                                        <button class="btn btn-info" data-toggle="modal" data-target="#modalFilterMasterList" id=""><i class="fas fa-filter fa-md"></i> Filter</button>
                                    </div>
                                </div>
                                <br>
                                {{-- <div class="table-responsive"> --}}
                                    <table id="tblMasterList" class="table table-responsive table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Item No.</th>
                                                <th>Quarter</th>
                                                <th>Validity</th>
                                                <th>Date Received</th>
                                                <th>Required Reply</th>
                                                <th>Actual Response</th>
                                                <th>TAT</th>
                                                <th>Section</th>
                                                <th>PMI Control No.</th>
                                                <th>Reference No.</th>
                                                <th>Product</th>
                                                <th>Customer</th>
                                                <th>Model Name</th>
                                                <th style="min-width: 400px; width: 400px !important;">Mode Of Defect</th>
                                                <th>Shipment Qty</th>
                                                <th>Number of NG</th>
                                                <th>Automotive/Non-Automotive</th>
                                                <th>Contributor</th>
                                                <th>Defect Category A/B/C</th>
                                                <th>Claim Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Filtering Modal Start -->
    <div class="modal fade" id="modalFilterMasterList" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" style="min-width: 550px;">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title" id="h4ChangeProductClassificationTitle"><i class="fas fa-filter"></i>&nbsp;Filter</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFilterMasterlist" autocomplete="off">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxFilterCustomerId" name="checkbox_customer">&nbsp;Customer</span>
                            </div>
                            <select class="form-control" disabled id="selectFilterCustomerId" name="filter_customer">
                                {{-- auto generated --}}
                            </select>
                        </div>
    
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxFilterModeOfDefectId" name="checkbox_mode_of_defect">&nbsp;Mode of Defect</span>
                            </div>
                            {{-- <select class="form-control" disabled id="selectFilterModeOfDefectId" name="filter_mode_of_defect">
                                
                            </select> --}}
    
                            <input type="text" id="txtFilterModeOfDefectId" name="filter_mode_of_defect" class="form-control" disabled>
                        </div>
    
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxFilterSection" name="checkbox_section">&nbsp;Section / Line</span>
                            </div>
                            <select class="form-control" disabled id="selectFilterSection" name="filter_section">
                                <option value="" disabled selected>Select One</option>
                                <option value="CN">CN</option>
                                <option value="TS">TS</option>
                                <option value="YF">YF</option>
                                <option value="PPS">PPS</option>
                            </select>
                        </div>
    
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox"id="checkboxModelSeries" name="checkbox_model_series">&nbsp;Model / Series</span>
                            </div>
                            {{-- <select class="form-control" disabled id="selectFilterModelSeries" name="filter_model_series">
                            </select> --}}
                            <input type="text" id="txtFilterModelSeries" name="filter_model_series" class="form-control" disabled>
    
                        </div>
    
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxProductClassification" name="checkbox_product_classification">&nbsp;Product Classification</span>
                            </div>
                            <select class="form-control" disabled id="selectFilterProductClassification" name="filter_product_classification">
                                {{-- auto generated --}}
                            </select>
                        </div>
    
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxClass" name="checkbox_class">&nbsp;Class</span>
                            </div>
                            <select class="form-control" disabled id="selectFilterClass" name="filter_class">
                                
                                <option value="0" disabled selected>Select One</option>
                                <option value="1">Class A</option>
                                <option value="2">Class B</option>
                                <option value="3">Class C</option>
                            </select>
                        </div>
                        
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxReferenceNo" name="checkbox_reference_no">&nbsp;Reference Number</span>
                            </div>
                            {{-- <select class="form-control" disabled id="selectFilterReferenceNo" name="filter_reference_no"> --}}
                            {{-- </select> --}}
                            <input type="text" id="txtFilterReferenceNo" name="filter_reference_no" class="form-control" disabled>
                        </div>
                        
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxControlNo" name="checkbox_control_no">&nbsp;PMI Control Number</span>
                            </div>
                            {{-- <select class="form-control" disabled id="selectFilterControlNo" name="filter_control_no"> --}}
                                
                            {{-- </select> --}}
                            <input type="text" id="txtFilterControlNo" name="filter_control_no" class="form-control" disabled>
    
                        </div>
    
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxtraceability" name="checkbox_treacability">&nbsp;Traceability (lot no/Trace code/Po)</span>
                            </div>
                            {{-- <select class="form-control" disabled id="selectFiltertraceability" name="filter_treacability">
                                
                            </select> --}}
                            <input type="text" id="txtFiltertraceability" name="filter_treacability" class="form-control" disabled>
    
                        </div>
    
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxContributor" name="checkbox_contributor">&nbsp;Contributor</span>
                            </div>
                            <select class="form-control" disabled id="selectFilterContributor" name="filter_contributor">
                                <option value="0" disabled selected>Select One</option>
                                <option value="1">Man</option>
                                <option value="3">Method</option>
                                <option value="2">Material</option>
                                <option value="4">Machine</option>
                                <option value="5">Environment</option>
                                <option value="6">N/A</option>
                            </select>
                        </div>
    
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxRTV" name="checkbox_RTV">&nbsp;RTV Status</span>
                            </div>
                            {{-- <select class="form-control" disabled id="selectFilterRTV" name="filter_RTV">
                                
                            </select> --}}
    
                            <input type="text" id="txtFilterRTV" name="filter_RTV" class="form-control" disabled>
    
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="btnFilterMasterlist" class="btn btn-primary"><i class="fa fa-check"></i> Execute</button>
                </div>
            </div>
        </div>
    </div><!-- Filtering Modal End -->
@endsection

<!--     {{-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        $(document).ready(function () {


            dataTablesMasterList = $("#tblMasterList").DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>fltip',
                // dom: '<"html5buttons"B>lfTgitp',
                buttons:[
                    // {extend: 'copy'},
                    // {extend: 'excel', title: 'Master List'},
                    {extend: 'csv', title: 'Master List'},
                    // {extend: 'print',
                    //     customize: function(win){
                    //         $(win.document.body).addClass('white-bg');
                    //         $(win.document.body).css('font-size', '10px');
                    //         $(win.document.body).find('table')
                    //         .addClass('compact')
                    //         .css('font-size', 'inherit');
                    //     }
                    // },
                    
                ],
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ masterlist records",
                    "lengthMenu": "Show _MENU_ masterlist records",
                },
                "ajax" : {
                    url: "view_customer_claim_master_list",
                    data: function (param){
                        param.filterCustomer                = $('#selectFilterCustomerId').val();
                        param.filterModeOfDefect            = $('#txtFilterModeOfDefectId').val();
                        param.filterSection                 = $('#selectFilterSection').val();
                        param.filterModelSeries             = $('#txtFilterModelSeries').val();
                        param.filterProductClassification   = $('#selectFilterProductClassification').val();
                        param.filterClass                   = $('#selectFilterClass').val();
                        param.filterReferenceNo             = $('#txtFilterReferenceNo').val();
                        param.filterControlNo               = $('#txtFilterControlNo').val();
                        param.filterTraceability            = $('#txtFiltertraceability').val();
                        param.filterContributor             = $('#selectFilterContributor').val();
                        param.filterRTV                     = $('#txtFilterRTV').val();
                        param.dateRangeFrom                 = $('#dateRangeFrom').val();
                        param.dateRangeTo                   = $('#dateRangeTo').val();
                    },
                },
                "columns":[
                    { "data" : "item_number"},
                    { "data" : "quarter"},
                    { "data" : "validity"},
                    { "data" : "date_received"},
                    { "data" : "required_reply"},
                    { "data" : "actual_response"},
                    { "data" : "turn_around_time"},
                    { "data" : "section"},
                    { "data" : "pmi_control_number"},
                    { "data" : "reference_number"},
                    { "data" : "product_details.product_name"},
                    { "data" : "customer_details.customer_name"},
                    { "data" : "model_name"},
                    { "data" : "mode_of_defect"},
                    // { "data" : "TBD",defaultContent: 'TBD'},
                    // { "data" : "shipment_quantity", defaultContent: '1'}, // Commented on 10-05-2023
                    { "data" : "shipment_quantity"},
                    { "data" : "number_of_ng"},
                    { "data" : "Automotive"},
                    { "data" : "Contributor"},
                    { "data" : "Defect Category"},
                    { "data" : "status"},
                ],
                "createdRow": function(row, data, index) {
                    $('td', row).eq(13).css('white-space', 'normal')
                },
            });



            getFilterCustomerId($('#selectFilterCustomerId'));
            
            getFilterProductClassification($('#selectFilterProductClassification'));
            
            // =================== Enable / Disable Select on filter ==================
            $('#checkboxFilterCustomerId').on('click', function(){
                $('#checkboxFilterCustomerId').attr('checked', 'checked');
                
                if($('#checkboxFilterCustomerId').is(':checked')){
                    $('#selectFilterCustomerId').attr('disabled', false);
                }else{
                    $('#checkboxFilterCustomerId').removeAttr('checked');
                    $('#selectFilterCustomerId').attr('disabled', true);
                    $('#selectFilterCustomerId').val('0').trigger('change');
                    // <option value="0" disabled selected>Select One</option>
                }
            });

            $('#checkboxFilterModeOfDefectId').on('click', function(){
                $('#checkboxFilterModeOfDefectId').attr('checked', 'checked');
                
                if($('#checkboxFilterModeOfDefectId').is(':checked')){
                    $('#txtFilterModeOfDefectId').attr('disabled', false);
                }else{
                    $('#checkboxFilterModeOfDefectId').removeAttr('checked');
                    $('#txtFilterModeOfDefectId').attr('disabled', true);
                    $('#txtFilterModeOfDefectId').val('');
                }
            });

            $('#checkboxFilterSection').on('click', function(){
                $('#checkboxFilterSection').attr('checked', 'checked');
                
                if($('#checkboxFilterSection').is(':checked')){
                    $('#selectFilterSection').attr('disabled', false);
                }else{
                    $('#checkboxFilterSection').removeAttr('checked');
                    $('#selectFilterSection').attr('disabled', true);
                    $('#selectFilterSection').val('').trigger('change');

                }
            });

            $('#checkboxModelSeries').on('click', function(){
                $('#checkboxModelSeries').attr('checked', 'checked');
                
                if($('#checkboxModelSeries').is(':checked')){
                    $('#txtFilterModelSeries').attr('disabled', false);
                }else{
                    $('#checkboxModelSeries').removeAttr('checked');
                    $('#txtFilterModelSeries').attr('disabled', true);
                    $('#txtFilterModelSeries').val('');
                }
            });
            
            $('#checkboxProductClassification').on('click', function(){
                $('#checkboxProductClassification').attr('checked', 'checked');
                
                if($('#checkboxProductClassification').is(':checked')){
                    $('#selectFilterProductClassification').attr('disabled', false);
                }else{
                    $('#checkboxProductClassification').removeAttr('checked');
                    $('#selectFilterProductClassification').attr('disabled', true);
                    $('#selectFilterProductClassification').val('0').trigger('change');

                }
            });

            $('#checkboxClass').on('click', function(){
                $('#checkboxClass').attr('checked', 'checked');
                
                if($('#checkboxClass').is(':checked')){
                    $('#selectFilterClass').attr('disabled', false);
                }else{
                    $('#checkboxClass').removeAttr('checked');
                    $('#selectFilterClass').attr('disabled', true);
                    $('#selectFilterClass').val('0').trigger('change');

                }
            });

            $('#checkboxReferenceNo').on('click', function(){
                $('#checkboxReferenceNo').attr('checked', 'checked');
                
                if($('#checkboxReferenceNo').is(':checked')){
                    $('#txtFilterReferenceNo').attr('disabled', false);
                }else{
                    $('#checkboxReferenceNo').removeAttr('checked');
                    $('#txtFilterReferenceNo').attr('disabled', true);
                    $('#txtFilterReferenceNo').val('');
                }
            });

            $('#checkboxControlNo').on('click', function(){
                $('#checkboxControlNo').attr('checked', 'checked');
                
                if($('#checkboxControlNo').is(':checked')){
                    $('#txtFilterControlNo').attr('disabled', false);
                }else{
                    $('#checkboxControlNo').removeAttr('checked');
                    $('#txtFilterControlNo').attr('disabled', true);
                    $('#txtFilterControlNo').val('');
                }
            });

            $('#checkboxtraceability').on('click', function(){
                $('#checkboxtraceability').attr('checked', 'checked');
                
                if($('#checkboxtraceability').is(':checked')){
                    $('#txtFiltertraceability').attr('disabled', false);
                }else{
                    $('#checkboxtraceability').removeAttr('checked');
                    $('#txtFiltertraceability').attr('disabled', true);
                    $('#txtFiltertraceability').val('');
                }
            });

            $('#checkboxContributor').on('click', function(){
                $('#checkboxContributor').attr('checked', 'checked');
                
                if($('#checkboxContributor').is(':checked')){
                    $('#selectFilterContributor').attr('disabled', false);
                }else{
                    $('#checkboxContributor').removeAttr('checked');
                    $('#selectFilterContributor').attr('disabled', true);
                    $('#selectFilterContributor').val('0').trigger('change');
                }
            });

            $('#checkboxRTV').on('click', function(){
                $('#checkboxRTV').attr('checked', 'checked');
                
                if($('#checkboxRTV').is(':checked')){
                    $('#txtFilterRTV').attr('disabled', false);
                }else{
                    $('#checkboxRTV').removeAttr('checked');
                    $('#txtFilterRTV').attr('disabled', true);
                    $('#txtFilterRTV').val('');
                }
            });

            $('#btnFilterMasterlist').on('click', function(){
                console.log($('#formFilterCustomerClaim').serialize());
                console.log($('#selectFilterCustomerId').val());
                console.log($('#txtFilterModeOfDefectId').val());
                console.log($('#selectFilterSection').val());
                console.log($('#txtFilterModelSeries').val());
                console.log($('#selectFilterProductClassification').val());
                console.log($('#selectFilterClass').val());
                console.log($('#txtFilterReferenceNo').val());
                console.log($('#txtFilterControlNo').val());
                console.log($('#txtFiltertraceability').val());
                console.log($('#selectFilterContributor').val());
                console.log($('#txtFilterRTV').val());
                //   dataTablesCustomerClaimCN.draw();
                //   dataTablesCustomerClaimTS.draw();
                //   dataTablesCustomerClaimYF.draw();
                //   dataTablesCustomerClaimPPS.draw();

                dataTablesMasterList.draw();
                $('#modalFilterMasterList').modal('hide');
            });


            $("#formDateRange").submit(function(event) {
                event.preventDefault();
                dataTablesMasterList.ajax.reload(null, false);
            });
        });
    </script>
@endsection