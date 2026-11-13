{{-- @php
    session_start();
@endphp --}}

{{-- @php $layout = 'layouts.super_user_layout'; @endphp --}}

<!--
    Old
-->
{{-- @auth
    @php
        if(Auth::user()->user_level_id == 1){
            $layout = 'layouts.super_user_layout';
        }
        else if(Auth::user()->user_level_id == 2){
            $layout = 'layouts.admin_layout';
        }
        else if(Auth::user()->user_level_id == 3){
            $layout = 'layouts.user_layout';
        }
    @endphp
@endauth --}}

{{-- @php
    if(isset($_SESSION['rapidx_user_level_id']) && !empty($_SESSION['rapidx_user_level_id'])){
        // if($_SESSION['rapidx_user_level_id'] == 1 || $_SESSION['rapidx_user_level_id'] == 4){
        if($_SESSION['rapidx_user_level_id'] == 1 || $_SESSION['rapidx_user_level_id'] == 4){
        $layout = 'layouts.super_user_layout';
        }
        // else if($_SESSION['rapidx_user_level_id'] == 5){
        else if($_SESSION['rapidx_user_level_id'] == 3){
            $layout = 'layouts.admin_layout';
        }
        else if($_SESSION['rapidx_user_level_id'] == 3){
            $layout = 'layouts.user_layout';
        }
    }else{
        echo '<script type="text/javascript">
                alert("Session Expired! Please Re-login");
                window.location = "../RapidX/";
            </script>';
    }
@endphp --}}

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
@section('title', '8D Report Monitoring')

@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>8D Report Monitoring</h1>
                    </div>
                    <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">8D Report Monitoring</li>
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
                                <h3 class="card-title" style="margin-top: 8px;">8D Report Monitoring</h3>
                                {{-- <button class="btn float-right reload"><i class="fas fa-sync-alt"></i></button> --}}
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active tabSection" id="cn-tab" data-toggle="tab" href="#cn" value="CN" role="tab" aria-controls="cn" aria-selected="true">CN</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tabSection" id="ts-tab" data-toggle="tab" href="#ts" value="TS" role="tab" aria-controls="ts" aria-selected="false">TS</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tabSection" id="yf-tab" data-toggle="tab" href="#yf" value="YF" role="tab" aria-controls="yf" aria-selected="false">YF</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tabSection" id="pps-tab" data-toggle="tab" href="#pps" value="PPS" role="tab" aria-controls="pps" aria-selected="false">PPS</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="cn" value="cn" role="tabpanel" aria-labelledby="cn-tab">
                                        <div class="mt-4"></div>
                                        <div class="table-responsive">
                                            <table id="tblEightDReportCN" class="table table-sm table-bordered table-hover" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Item No.</th>
                                                        <th>Claim Status</th>
                                                        <th>Model Name</th>
                                                        <th>Mode Of Defect</th>
                                                        <th>Quarter</th>
                                                        <th>Section</th>
                                                        <th>Customer</th>
                                                        <th>Sender</th>
                                                        <th>Required Reply</th>
                                                        <th>Initial Response</th>
                                                        <th>Actual Response</th>
                                                        <th>TAT</th>
                                                        {{-- <th>Validity</th> --}}
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="ts" value="ts" role="tabpanel" aria-labelledby="ts-tab">
                                        <div class="mt-4"></div>
                                        <div class="table-responsive">
                                            <table id="tblEightDReportTS" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Item No.</th>
                                                        <th>Claim Status</th>
                                                        <th>Model Name</th>
                                                        <th>Mode Of Defect</th>
                                                        <th>Quarter</th>
                                                        <th>Section</th>
                                                        <th>Customer</th>
                                                        <th>Sender</th>
                                                        <th>Required Reply</th>
                                                        <th>Initial Response</th>
                                                        <th>Actual Response</th>
                                                        <th>TAT</th>
                                                        {{-- <th>Validity</th> --}}
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="yf" value="yf" role="tabpanel" aria-labelledby="yf-tab">
                                        <div class="mt-4"></div>
                                        <div class="table-responsive">
                                            <table id="tblEightDReportYF" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Item No.</th>
                                                        <th>Claim Status</th>
                                                        <th>Model Name</th>
                                                        <th>Mode Of Defect</th>
                                                        <th>Quarter</th>
                                                        <th>Section</th>
                                                        <th>Customer</th>
                                                        <th>Sender</th>
                                                        <th>Required Reply</th>
                                                        <th>Initial Response</th>
                                                        <th>Actual Response</th>
                                                        <th>TAT</th>
                                                        {{-- <th>Validity</th> --}}
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pps" value="pps" role="tabpanel" aria-labelledby="pps-tab">
                                        <div class="mt-4"></div>
                                        <div class="table-responsive">
                                            <table id="tblEightDReportPPS" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Item No.</th>
                                                        <th>Claim Status</th>
                                                        <th>Model Name</th>
                                                        <th>Mode Of Defect</th>
                                                        <th>Quarter</th>
                                                        <th>Section</th>
                                                        <th>Customer</th>
                                                        <th>Sender</th>
                                                        <th>Required Reply</th>
                                                        <th>Initial Response</th>
                                                        <th>Actual Response</th>
                                                        <th>TAT</th>
                                                        {{-- <th>Validity</th> --}}
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- View 8D Report Modal Start -->
    <div class="modal fade" id="modalEightDReport" data-keyboard="false" data-backdrop="static" style="overflow-y: auto;">
        <div class="modal-dialog modal-xl-custom">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-eye"></i>&nbsp;View Customer Claim Details</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <form id="formCustomerClaim" enctype="multipart/form-data"> --}}
                    {{-- @csrf --}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4 border px-3">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="claim-details-tab" data-toggle="tab" href="#claim-details" role="tab" aria-controls="claim-details" aria-selected="true">Claim Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="product-details-tab" data-toggle="tab" href="#product-details" role="tab" aria-controls="product-details" aria-selected="false">Product Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="date-details-tab" data-toggle="tab" href="#date-details" role="tab" aria-controls="date-details" aria-selected="false">Date Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="data-verification-tab" data-toggle="tab" href="#data-verification" role="tab" aria-controls="data-verification" aria-selected="false">Data Verification</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="unit-verification-tab" data-toggle="tab" href="#unit-verification" role="tab" aria-controls="unit-verification" aria-selected="false">Unit Verification</a>
                                    </li>
                                </ul>
                                <div class="tab-content py-3" id="myTabContent">
                                    <div class="tab-pane fade show active" id="claim-details" role="tabpanel" aria-labelledby="claim-details">
                                        {{-- <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mt-3 border-right"> --}}
                                            <input type="text" class="form-control form-control-sm customer-claim-input" placeholder="Customer Claim ID" id="customerClaimId" name="customer_claim_id" style="display: none;">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Division/Section</span>
                                                </div>
                                                <input type="text" class="form-control" name="section_display" id="txtViewSection" disabled aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                <input type="hidden" class="form-control" disabled name="section" id="txtAddSectionHidden">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Item Number</span>
                                                </div>
                                                <input type="text" class="form-control" disabled name="item_number" id="txtViewItemNumber" disabled placeholder="Auto Generated" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Control Number</span>
                                                </div>
                                                <input type="text" class="form-control" disabled arr-index="1" name="pmi_control_number" id="txtViewControlNumber" autocomplete="off" placeholder="ex: CC-0126-001-PPS" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Reference Number</span>
                                                </div>
                                                <input type="text" class="form-control" disabled name="reference_number" id="txtViewReferenceNumber" autocomplete="off" placeholder="Optional" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Quarter</span>
                                                </div>
                                                <select class="form-control select2bs4 selectQuarter" disabled arr-index="2" name="quarter" id="viewSelectQuarter" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    <option value="" disabled selected>Select One</option>
                                                    <option value="1">Quarter 1</option>
                                                    <option value="2">Quarter 2</option>
                                                    <option value="3">Quarter 3</option>
                                                    <option value="4">Quarter 4</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Customer</span>
                                                </div>
                                                <select class="form-control select2bs4 viewSelectCustomer" disabled arr-index="3" name="customer" id="viewSelectCustomer" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    <!-- Auto Generated -->
                                                    {{-- <option value="" disabled selected>Select One</option>
                                                    <option value="1">Mitsubishi</option>
                                                    <option value="2">Apple</option>
                                                    <option value="3">Panasonic</option>
                                                    <option value="4">Invalid</option>
                                                    <option value="5">N/A</option> --}}
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Sender Name</span>
                                                </div>
                                                <select class="form-control select2bs4 viewSelectSenderName" disabled arr-index="4" name="sender_name" id="viewSelectSenderName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    <!-- Auto Generated -->
                                                    <option value="" disabled selected>Select One</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Contributor</span>
                                                </div>
                                                <select class="form-control select2bs4 selectContributor" disabled arr-index="5" name="contributor" id="viewSelectContributor" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    <option value="" disabled selected>Select One</option>
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
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Validity</span>
                                                </div>
                                                <select class="form-control select2bs4 selectValidity" disabled arr-index="6" name="validity" id="viewSelectValidity" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    <option value="" disabled selected>Select One</option>
                                                    <option value="1">Valid</option>
                                                    <option value="2">Information</option>
                                                    <option value="3">Feedback</option>
                                                    <option value="4">Invalid</option>
                                                    <option value="5">N/A</option>
                                                </select>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="tab-pane fade" id="product-details" role="tabpanel" aria-labelledby="product-details">
                                        {{-- <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mt-3 border-right"> --}}
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Product Classification</span>
                                                </div>
                                                <select class="form-control select2bs4 selectProductClassification" disabled arr-index="7" name="product_classification" id="viewSelectProductClassification" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    <!-- Auto Generated -->
                                                    {{-- <option value="" disabled selected>Select One</option>
                                                    <option value="1">FLEX</option>
                                                    <option value="2">IC Socket</option>
                                                    <option value="3">Connector</option>
                                                    <option value="4">Burn-In</option> --}}
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Model Name</span>
                                                </div>
                                                <input type="text" class="form-control" disabled arr-index="8" name="model_name" id="txtViewModelName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Mode of Defect</span>
                                                </div>
                                                <input type="text" class="form-control" disabled arr-index="9" name="mode_of_defect" id="txtViewModeOfDefect" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Lot/PO/Trace Code/Serial Number</span>
                                                </div>
                                                <input type="text" class="form-control" disabled arr-index="10" name="po_number" id="txtViewPONumber" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Automotive/Non-Automotive</span>
                                                </div>
                                                <select class="form-control select2bs4 selectAutomotive" disabled arr-index="11" name="automotive" id="viewSelectAutomotive" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    <option value="" disabled selected>Select One</option>
                                                    <option value="1">Automotive</option>
                                                    <option value="2">Non-Automotive</option>
                                                    <option value="3">N/A</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Quantity</span>
                                                </div>
                                                {{-- <input type="number" class="form-control" disabled arr-index="12" name="quantity" id="txtViewQuantity" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"> --}}
                                                <input type="text" class="form-control" disabled arr-index="12" name="quantity" id="txtViewQuantity">
                                            </div>
                                            {{-- <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Number of NG</span>
                                                </div>
                                                <input type="number" class="form-control" disabled arr-index="13" name="number_of_ng" id="txtViewNumberOfNG" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                            </div> --}}
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Return to Vendor</span>
                                                </div>
                                                <input type="text" class="form-control" disabled arr-index="14" name="return_to_vendor" id="txtViewReturnToVendor" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Defect Category Class(A/B/C)</span>
                                                </div>
                                                <select class="form-control select2bs4 selectValidity" disabled arr-index="15" name="defect_category_class" id="viewSelectDefectCategoryClass" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    <option value="" disabled selected>Select One</option>
                                                    <option value="1">Class A</option>
                                                    <option value="2">Class B</option>
                                                    <option value="3">Class C</option>
                                                </select>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="tab-pane fade" id="date-details" role="tabpanel" aria-labelledby="date-details">
                                        {{-- <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mt-3 border-right"> --}}
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Date Received</span>
                                                </div>
                                                {{-- <input type="date" class="form-control datetimepicker" name="date_received" id="txtDateReceived" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                <input type="text" class="form-control datetimepicker" disabled arr-index="16" name="date_received" id="txtViewDateReceived" autocomplete="off" placeholder="yyyy/mm/dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" disabled id="chkActualDateReceivedClaim" name="chk_actual_date_received_claim">&nbsp;Actual Date Received of Claim</span>
                                                </div>
                                                {{-- <input type="date" class="form-control datetimepicker" name="actual_date_received_claim" id="txtAddActualDateReceivedOfClaim" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                <input type="text" class="form-control datetimepicker" disabled name="actual_date_received_claim" id="txtViewActualDateReceivedOfClaim" autocomplete="off" placeholder="yyyy/mm/dd" disabled aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" disabled id="chkdateReturnClaim" name="chk_date_return_of_claim">&nbsp;Date Return of Claim Sample</span>
                                                </div>
                                                {{-- <input type="date" class="form-control datetimepicker" name="date_return_of_claim" id="txtViewDateReturnOfClaimSample" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                <input type="text" class="form-control datetimepicker" disabled name="date_return_of_claim" id="txtViewDateReturnOfClaimSample" autocomplete="off"  placeholder="yyyy/mm/dd" disabled aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Required Reply</span>
                                                </div>
                                                {{-- <input type="date" class="form-control datetimepicker" name="required_reply" id="txtViewRequiredReply" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                <input type="text" class="form-control datetimepicker" disabled arr-index="17" name="required_reply" id="txtViewRequiredReply" autocomplete="off" placeholder="yyyy/mm/dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Initial Response</span>
                                                </div>
                                                {{-- <input type="date" class="form-control datetimepicker" name="initial_response" id="txtViewInitialResponse" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                <input type="text" class="form-control datetimepicker" disabled arr-index="18" name="initial_response" id="txtViewInitialResponse" autocomplete="off" placeholder="yyyy/mm/dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Actual Response</span>
                                                </div>
                                                {{-- <input type="date" class="form-control datetimepicker" name="actual_response" type="text" onfocus="(this.type='date')" id="txtViewActualResponse" placeholder="Auto Generated" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                <input type="text" class="form-control datetimepicker" disabled arr-index="19" name="actual_response" type="text" id="txtViewActualResponse" autocomplete="off" placeholder="yyyy/mm/dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                {{-- <input type="text" class="form-control" name="actual_response" type="text" onfocus="(this.type='date')" id="txtViewActualResponse" placeholder="Auto Generated" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Turn Around Time</span>
                                                </div>
                                                <input type="text" class="form-control" disabled name="turn_around_time" id="txtViewTurnAroundTime" disabled placeholder="Auto Generated" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Remarks</span>
                                                </div>
                                                {{-- <input type="date" class="form-control datetimepicker" name="date_return_of_claim" id="txtViewDateReturnOfClaimSample" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                <textarea type="text" class="form-control" disabled name="remarks" id="txtViewRemarks" rows="2" autocomplete="off"  placeholder="Remarks" aria-label="Default" aria-describedby="inputGroup-sizing-default"></textarea>
                                            </div>
                                            
                                            <div class="input-group finalReport d-none">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="inputGroup-sizing-default">Final Report</span>
                                                </div>
                                                <div class="w-50" style="border-style: solid; padding-left: 5px; padding-top: 5px; border-width: 1px; border-color: #d5deeb;">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="final_report" id="radioViewOntime" value="1">
                                                        <label class="form-check-label" for="radioOntime">On Time</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="final_report" id="radioViewLate" value="2">
                                                        <label class="form-check-label" for="radioLate">Late</label>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="tab-pane fade" id="data-verification" role="tabpanel" aria-labelledby="data-verification">
                                        {{-- <div class="row"> --}}
                                            {{-- <div class="col-sm-4 mt-3 border-right"> --}}
                                                <div><label for="">1. Is P.O Number traceable to PMI?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_po_number_traceable" id="view_is_po_number_traceable_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input is_po_number_traceable_no" type="radio" disabled name="view_is_po_number_traceable" id="is_po_number_traceable_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_is_po_number_traceable_remarks" id="view_is_po_number_traceable_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>
                                                
                                                <div><label for="">2. Is the lot identification matches with PMI record?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_lot_identification_match" id="view_is_lot_identification_match_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_lot_identification_match" id="view_is_lot_identification_match_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_is_lot_identification_match_remarks" id="view_is_lot_identification_match_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>

                                                <div><label for="">3. Are there WIP & FGS affected?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="are_there_wip_fgs_affected" id="view_are_there_wip_fgs_affected_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="are_there_wip_fgs_affected" id="view_are_there_wip_fgs_affected_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_are_there_wip_fgs_affected_remarks" id="view_are_there_wip_fgs_affected_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>

                                                <div><label for="">4. Is sorting / reworking necessary?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_sorting_reworking_necessary" id="view_is_sorting_reworking_necessary_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_sorting_reworking_necessary" id="view_is_sorting_reworking_necessary_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_is_sorting_reworking_necessary_remarks" id="view_is_sorting_reworking_necessary_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>

                                                <div><label for="">5. Is sorting needed at the customer's site?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_sorting_needed" id="view_is_sorting_needed_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_sorting_needed" id="view_is_sorting_needed_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_is_sorting_needed_remarks" id="view_is_sorting_needed_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>
                                                <div><label for="">6. Is the shipment schedule affected?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_shipment_affected" id="view_is_shipment_affected_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_shipment_affected" id="view_is_shipment_affected_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_is_shipment_affected_remarks" id="view_is_shipment_affected_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>

                                                <div><label for="">7. Are data needed complete & available?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="are_data_needed_complete_available" id="view_are_data_needed_complete_available_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="are_data_needed_complete_available" id="view_are_data_needed_complete_available_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_are_data_needed_complete_available_remarks" id="view_are_data_needed_complete_available_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>

                                                <div><label for="">8. Does customer requests production record?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="does_customer_requests_production_record" id="view_does_customer_requests_production_record_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="does_customer_requests_production_record" id="view_does_customer_requests_production_record_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_does_customer_requests_production_record_remarks" id="view_does_customer_requests_production_record_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>

                                                <div><label for="">9. Are there some clarifications needed to settle with the customer?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input radioActions" arr-index="9" type="radio" disabled name="are_there_clarifications_needed_to_settle" id="view_are_there_clarifications_needed_to_settle_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input radioActions" arr-index="9" type="radio" disabled name="are_there_clarifications_needed_to_settle" id="view_are_there_clarifications_needed_to_settle_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_are_there_clarifications_needed_to_settle_remarks" id="view_are_there_clarifications_needed_to_settle_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>
                                            {{-- </div> --}}
                                        {{-- </div> --}}
                                    </div>
                                    <div class="tab-pane fade" id="unit-verification" role="tabpanel" aria-labelledby="unit-verification">
                                        {{-- <div class="row"> --}}
                                            {{-- <div class="col-sm-4 mt-3 border-right"> --}}
                                                <div><label for="">1. Is the actual NG unit available for verification?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_actual_ng_unit_available" id="view_is_actual_ng_unit_available_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_actual_ng_unit_available" id="view_is_actual_ng_unit_available_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_is_actual_ng_unit_available_remarks" id="view_is_actual_ng_unit_available_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>
                                                
                                                <div><label for="">2. Is the unit bearing PMI identification mark?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_unit_bearing_pmi_identification_mark" id="view_is_unit_bearing_pmi_identification_mark_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_unit_bearing_pmi_identification_mark" id="view_is_unit_bearing_pmi_identification_mark_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_is_unit_bearing_pmi_identification_mark_remarks" id="view_is_unit_bearing_pmi_identification_mark_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>

                                                <div><label for="">3. Is claim defect identified by the customer tallies with actual received NG unit?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_claim_defect_identified_by_customer" id="view_is_claim_defect_identified_by_customer_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="is_claim_defect_identified_by_customer" id="view_is_claim_defect_identified_by_customer_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_is_claim_defect_identified_by_customer_remarks" id="view_is_claim_defect_identified_by_customer_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>

                                                <div><label for="">4. Does customer requires official corrective and preventive action report?</label></div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="does_customer_requires_official_capa_report" id="view_does_customer_requires_official_capa_report_yes" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" disabled name="does_customer_requires_official_capa_report" id="view_does_customer_requires_official_capa_report_no" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div>
                                                    <label class="form-check-label">Remarks: &nbsp;</label>
                                                    <textarea type="text" name="view_does_customer_requires_official_capa_report_remarks" id="view_does_customer_requires_official_capa_report_remarks" readonly rows="1" class="form-control col-12" ></textarea>
                                                </div>
                                            {{-- </div> --}}
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-8">
                                <form id="formEightDReport" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <!-- Root Cause Action -->

                                    <!--
                                    <div class="card" id="rootCauseActionCard">
                                        <div class="card-header">
                                            <h3 class="card-title" style="margin-top: 8px;"><strong>Root Cause Action</strong></h3>
                                            <input type="text" class="form-control form-control-sm" placeholder="Edit Data" name="edit_data" id="editData" value="" style="display: none;">
                                            <button type="button" class="btn btn-sm btn-info float-right" id="add_row_root_cause_action"><i class="fa fa-plus"></i> Add Row</button>
                                            <button type="button" class="btn btn-sm btn-danger float-right mr-2 d-none" id="remove_row_root_cause_action"><i class="fas fa-times"></i> Remove Row</button>
                                        </div>
                                        <div class="card-body">
                                            <div id="divRootCauseAction">
                                                {{-- <input type="hidden" name="txt_max_row" id="txt_max_row" value="1"> --}}
                                                <input type="hidden" name="rapidx_user_id" id="rapidx_user_id" value="<?php echo isset($_SESSION['rapidx_user_id']) ? $_SESSION['rapidx_user_id'] : ''?>">
                                                <input type="hidden" name="root_cause_action_code" id="root_cause_action_code" value="1">
                                                <input type="hidden" name="root_cause_action_counter" id="root_cause_action_counter" value="1">
                                                <h6><span class="badge badge-secondary"># 1.</span></h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Date</i></span>
                                                            </div>
                                                            <input type="date" class="form-control form-control-sm" id="root_cause_date" name="root_cause_date" placeholder="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 40%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-sm" id="root_cause_in_charge" name="root_cause_in_charge" placeholder="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>
                                                            </div>
                                                            <textarea type="text" class="form-control form-control-sm" id="root_cause_corrective_action" name="root_cause_corrective_action" placeholder="required"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>
                                                            </div>
                                                            <textarea class="form-control form-control-sm" rows="2" id="root_cause_remarks" name="root_cause_remarks" placeholder="required"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

                                    
                                    <!-- Escapee Cause Action -->
                                    <!--
                                    <div class="card" id="escapeeCauseActionCard">
                                        <div class="card-header">
                                            <h3 class="card-title" style="margin-top: 8px;"><strong>Escapee Cause Action</strong></h3>
                                            <button type="button" class="btn btn-sm btn-info float-right" id="add_row_escapee_cause_action"><i class="fa fa-plus"></i> Add Row</button>
                                            <button type="button" class="btn btn-sm btn-danger float-right mr-2  d-none" id="remove_row_escapee_cause_action"><i class="fas fa-times"></i> Remove Row</button>
                                        </div>
                                        <div class="card-body">
                                            <div id="divEscapeeCauseAction">
                                                {{-- <input type="hidden" name="txt_max_row" id="txt_max_row" value="1"> --}}
                                                <input type="hidden" name="escapee_cause_action_code" id="escapee_cause_action_code" value="2">
                                                <input type="hidden" name="escapee_cause_action_counter" id="escapee_cause_action_counter" value="1">
                                                <h6><span class="badge badge-secondary"># 1.</span></h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Date</i></span>
                                                            </div>
                                                            <input type="date" class="form-control form-control-sm" id="escapee_cause_date" name="escapee_cause_date" placeholder="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 40%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-sm" id="escapee_cause_in_charge" name="escapee_cause_in_charge" placeholder="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>
                                                            </div>
                                                            <textarea type="text" class="form-control form-control-sm" id="escapee_cause_corrective_action" name="escapee_cause_corrective_action" placeholder="required"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>
                                                            </div>
                                                            <textarea class="form-control form-control-sm" rows="2" id="escapee_cause_remarks" name="escapee_cause_remarks" placeholder="required"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <!-- Systemic Action -->
                                    <!-- 
                                    <div class="card" id="systemicActionCard">
                                        <div class="card-header">
                                            <h3 class="card-title" style="margin-top: 8px;"><strong>Systemic Action</strong></h3>
                                            <button type="button" class="btn btn-sm btn-info float-right" id="add_row_systemic_action"><i class="fa fa-plus"></i> Add Row</button>
                                            <button type="button" class="btn btn-sm btn-danger float-right mr-2 d-none" id="remove_row_systemic_action"><i class="fas fa-times"></i> Remove Row</button>
                                        </div>
                                        <div class="card-body">
                                            <div id="divSystemicAction">
                                                {{-- <input type="hidden" name="txt_max_row" id="txt_max_row" value="1"> --}}
                                                <input type="hidden" name="systemic_action_code" id="systemic_action_code" value="3">
                                                <input type="hidden" name="systemic_action_counter" id="systemic_action_counter" value="1">
                                                <h6><span class="badge badge-secondary"># 1.</span></h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Date</i></span>
                                                            </div>
                                                            <input type="date" class="form-control form-control-sm" id="systemic_date" name="systemic_date" placeholder="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 40%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-sm" id="systemic_in_charge" name="systemic_in_charge" placeholder="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>
                                                            </div>
                                                            <textarea type="text" class="form-control form-control-sm" id="systemic_corrective_action" name="systemic_corrective_action" placeholder="required"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>
                                                            </div>
                                                            <textarea class="form-control form-control-sm" rows="2" id="systemic_remarks" name="systemic_remarks" placeholder="required"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <!-- Fan-out Action -->
                                    <!--
                                    <div class="card" id="fanoutActionCard">
                                        <div class="card-header">
                                            <h3 class="card-title" style="margin-top: 8px;"><strong>Fan-out Action</strong></h3>
                                            <button type="button" class="btn btn-sm btn-info float-right" id="add_row_fanout_action"><i class="fa fa-plus"></i> Add Row</button>
                                            <button type="button" class="btn btn-sm btn-danger float-right mr-2 d-none" id="remove_row_fanout_action"><i class="fas fa-times"></i> Remove Row</button>
                                        </div>
                                        <div class="card-body">
                                            <div id="divFanOutAction">
                                                {{-- <input type="hidden" name="txt_max_row" id="txt_max_row" value="1"> --}}
                                                <input type="hidden" name="fanout_action_counter" id="fanout_action_counter" value="1">
                                                <h6><span class="badge badge-secondary"># 1.</span></h6>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Due Date</i></span>
                                                            </div>
                                                            <input type="date" class="form-control form-control-sm" id="fanout_due_date" name="fanout_due_date" placeholder="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Product Name</i></span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-sm" id="fanout_product_name" name="fanout_product_name" placeholder="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 40%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-sm" id="fanout_in_charge" name="fanout_in_charge" placeholder="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>
                                                            </div>
                                                            <textarea type="text" class="form-control form-control-sm" id="fanout_corrective_action" name="fanout_corrective_action" placeholder="required"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend" style="width: 30%;">
                                                                <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>
                                                            </div>
                                                            <textarea class="form-control form-control-sm" rows="2" id="fanout_remarks" name="fanout_remarks" placeholder="required"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <!-- Upload 8D Report -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title" style="margin-top: 8px;"><strong><span class="badge badge-secondary">1.</span>&nbsp;Upload 8D Report</strong></h3>
                                            <div class="col-12 text-right">
                                                <button type="button" id="btnViewRevisionHistory" class="btn btn-info btn-sm" style=""><i class="fa fa-clipboard-check"></i> View Revision History <span class="badge badge-light" id="totalRevision" title="Total revision/s">0</span></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="divEightDReport">
                                                <div class="input-group mb-3" id="divTxtEightDReportFilename">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="inputGroup-sizing-default">8D Report Filename</span>
                                                    </div>
                                                    <input type="text" name="eight_d_report_filename" readonly id="txtEightDReportFileName" class="form-control">
                                                </div>

                                                <div class="input-group mb-3 d-none" id="divFileEightDReportFile">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="inputGroup-sizing-default">8D Report File</span>
                                                    </div>
                                                    <input type="file" class="form-control" name="eight_d_report_file" id="fileEightDReportFile" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                </div>
                                                <div class="input-group mb-3" id="divTxtEightDReportFile">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="inputGroup-sizing-default">8D Report File</span>
                                                    </div>
                                                    <input type="text" class="form-control" readonly name="txt_eight_d_report_file" id="txtEightDReportFile" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                </div>
                                                <div class="input-group mb-3" id="divTxtEightDReportSender">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="inputGroup-sizing-default">Submitted By:</span>
                                                    </div>
                                                    <input type="text" readonly class="form-control" readonly name="operation_eight_d_report_sender" id="txtEightDReportSender" value="<?php echo isset($_SESSION['rapidx_name']) ? $_SESSION['rapidx_name'] : ''?>" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    <input type="hidden" class="form-control" name="operation_eight_d_report_sender_by_rapidx_id" id="txtEightDReportSenderByRapidXId" value="<?php echo isset($_SESSION['rapidx_user_id']) ? $_SESSION['rapidx_user_id'] : ''?>" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                </div>

                                                <div class="input-group ml-4" id="divCheckboxEightDReport">
                                                    {{-- <input type="checkbox" id="chkdateReturnClaim" name="chk_date_return_of_claim"> --}}
                                                    <input type="checkbox" class="form-check-input" name="checkbox_eight_d_report" id="checkboxEightDReport">
                                                    <label class="form-check-label" for="checkboxEightDReport">
                                                        Re-upload
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title" style="margin-top: 8px;"><strong><span class="badge badge-secondary">2.</span>&nbsp;Claim Validation</strong></h3>
                                        </div>
                                        <div class="card-body">
                                            <div><label for="">1. Is the defect NG based on the defined specification?</label></div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_the_defect_ng_based_on_specs" id="is_the_defect_ng_based_on_specs_yes" value="1">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_the_defect_ng_based_on_specs" id="is_the_defect_ng_based_on_specs_no" value="2">
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                            <div>
                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                <textarea type="text" name="is_the_defect_ng_based_on_specs_remarks" id="is_the_defect_ng_based_on_specs_remarks" rows="1" class="form-control col-6" ></textarea>
                                            </div>
                                            
                                            <div><label for="">2. Is the defect included in PMI check items?</label></div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_defect_included_in_pmi" id="is_defect_included_in_pmi_yes" value="1">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_defect_included_in_pmi" id="is_defect_included_in_pmi_no" value="2">
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                            <div>
                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                <textarea type="text" name="is_defect_included_in_pmi_remarks" id="is_defect_included_in_pmi_remarks" rows="1" class="form-control col-6" ></textarea>
                                            </div>

                                            <div><label for="">3. Is the defect detectable at PMI Function Test/Camera recognition checking?</label></div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_defect_detectable_at_pmi" id="is_defect_detectable_at_pmi_yes" value="1">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_defect_detectable_at_pmi" id="is_defect_detectable_at_pmi_no" value="2">
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                            <div>
                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                <textarea type="text" name="is_defect_detectable_at_pmi_remarks" id="is_defect_detectable_at_pmi_remarks" rows="1" class="form-control col-6" ></textarea>
                                            </div>

                                            <div><label for="">4. Is the unit undergone Customer assembly process?</label></div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_unit_undergone_customer_assembly_process" id="is_unit_undergone_customer_assembly_process_yes" value="1">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_unit_undergone_customer_assembly_process" id="is_unit_undergone_customer_assembly_process_no" value="2">
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                            <div>
                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                <textarea type="text" name="is_unit_undergone_customer_assembly_process_remarks" id="is_unit_undergone_customer_assembly_process_remarks" rows="1" class="form-control col-6" ></textarea>
                                            </div>

                                            <div><label for="">5. Is the defect contributed by PMI process?</label></div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_defect_contributed_by_pmi" id="is_defect_contributed_by_pmi_yes" value="1">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="is_defect_contributed_by_pmi" id="is_defect_contributed_by_pmi_no" value="2">
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                            <div>
                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                <textarea type="text" name="is_defect_contributed_by_pmi_remarks" id="is_defect_contributed_by_pmi_remarks" rows="1" class="form-control col-6" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <div>
                                <button type="submit" id="btnAddEightDReport" class="btn btn-success"><i id="iBtnAddEightDReportIcon" class="fa fa-check"></i> Save</button>
                            </div>
                        </div>
                </form>
                {{-- </form> --}}
            </div>
        </div>
    </div>


    <!-- View 8D Report History Modal Start -->
    <div class="modal fade" id="modalEightDReportHistory" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" style="min-width: 550px;">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;8D Report Revision History</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tblEightDReportHistory" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Revision Count</th>
                                    <th>8D Report Name</th>
                                    <th>8D Report Submitted Date</th>
                                    <th style="min-width: 20% !important; width: 10%">Remarks</th>
                                    {{-- <th>Sender</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div><!-- View 8D Report History Modal End -->

    <!-- Upload Modal Start -->
    <div class="modal fade" id="modalReUploadOperationEightDReport" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" style="min-width: 550px;">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title" id="h4ChangeProductClassificationTitle"><i class="fas fa-file-upload"></i>&nbsp; Operation 8D Report Upload</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formReUploadOperationEightDReport" autocomplete="off" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" id="txtIdForEdit" name="edit_id"> --}}
                        <input type="hidden" id="txtCustomerClaimId" name="customer_claim_id">

                        <div class="input-group mb-3" id="divTxtEightDReportFilename">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default">8D Report Filename</span>
                            </div>
                            <input type="text" name="eight_d_report_filename" id="txtEightDReportFileName" class="form-control">
                        </div>

                        <div class="input-group mb-3 d-none" id="divFileEightDReportFile">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default">8D Report File</span>
                            </div>
                            <input type="file" class="form-control" name="eight_d_report_file" id="fileEightDReportFile" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                        </div>
                        
                        <div class="input-group mb-3" id="divTxtEightDReportFile">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default">8D Report File</span>
                            </div>
                            <input type="text" class="form-control" name="txt_eight_d_report_file" id="txtEightDReportFile" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                        </div>
                        <!--
                        <div class="input-group mb-3" id="divTxtEightDReportSender">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default">Submitted By:</span>
                            </div>
                            <input type="text" readonly class="form-control" readonly name="operation_eight_d_report_sender" id="txtEightDReportSender" value="<?php echo isset($_SESSION['rapidx_name']) ? $_SESSION['rapidx_name'] : ''?>" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                            <input type="hidden" class="form-control" name="operation_eight_d_report_sender_by_rapidx_id" id="txtEightDReportSenderByRapidXId" value="<?php echo isset($_SESSION['rapidx_user_id']) ? $_SESSION['rapidx_user_id'] : ''?>" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                        </div>
                        -->

                        <div class="input-group mb-3 ml-4" id="divCheckboxEightDReport">
                            <input class="form-check-input" type="checkbox" name="checkbox_operation_eight_d_report" id="checkboxReUploadEightDReport">
                            <label class="form-check-label" for="flexCheckDefault">
                                Re-upload
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="btnUpploadOperationEightDReport" class="btn btn-primary d-none"><i class="fa fa-check"></i> Upload</button>
                </div>
            </div>
        </div>
    </div><!-- Upload Modal End -->
    
@endsection

<!--     {{-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        $(document).ready(function () {
            //============================= Defaults =============================
            // Initialize Bootstrap File Input Elements
            bsCustomFileInput.init();

            // Initialize Select2 Elements
            $('.select2').select2();

            // Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            // Onclick <tr> to add active class
            $(document).on('click','#tblEightDReport tbody tr',function(e){
                $(this).closest('tbody').find('tr').removeClass('table-active');
                $(this).closest('tr').addClass('table-active');
            });

            //============================= SmartWizard =============================
            // Initialize SmartWizard   
            $('#smartwizard').smartWizard({
                selected: 0,
                theme: 'arrows',
                autoAdjustHeight:true,
                transitionEffect:'fade',
                showStepURLhash: false,
                keyNavigation: false, // Enable/Disable key navigation(left and right keys are used if enabled)
                enableAllSteps: false,
                // transition: {
                //     animation: 'slide-horizontal', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
                //     speed: '400', // Transion animation speed
                // },
            });


            //============================= Get Email Recipient for Sender Name =============================
            GetEmailRecipient($('#viewSelectSenderName'));


            //============================= Get Product Classification =============================
            GetProductClassification($('#viewSelectProductClassification'));


            //============================= Get Customer Classification =============================
            GetCustomerClassification($('#viewSelectCustomer'));
            

            ///============================= Customer Claim Datatables =============================
            dataTablesCustomerClaimCN = $("#tblEightDReportCN").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ claim records",
                    "lengthMenu": "Show _MENU_ claim records",
                },
                "ajax" : {
                    url: "view_eight_d_report_cn",
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "item_number"},
                    { "data" : "status"},
                    { "data" : "model_name"},
                    { "data" : "mode_of_defect"},
                    { "data" : "quarter"},
                    { "data" : "section"},
                    { "data" : "customer_details.customer_name"},
                    { "data" : "sender_name",
                        defaultContent: 'N/A',
                    },
                    { "data" : "required_reply",
                        defaultContent: 'N/A',
                    },
                    { "data" : "initial_response",
                        defaultContent: 'N/A',
                    },
                    { "data" : "actual_response",
                        defaultContent: 'N/A',
                    },
                    { "data" : "turn_around_time",
                        defaultContent: 'N/A',
                    },
                    // { "data" : "validity"},
                ],
                "columnDefs": [
                    { className: 'px-3', targets: [0] },
                ],
            });

            //============================= Edit/Get Customer Claim Details CN =============================
            $("#tblEightDReportCN").on('click', '.actionAddEightDReport', function(){
                let id = $(this).attr('eight-d-report-id');
                console.log('id ' +id + ' on formEightDReport');
                let editData = $(this).attr('edit-data'); // came from controller once click the edit button and pass this value to edit_data(input)
                console.log('editData ' +editData);

                $("input[name='customer_claim_id'").val(id);
                // Validation For adding CAPA
                if(editData != 0){
                    $("input[name='edit_data'").attr('value',editData);
                }else{
                    $("input[name='edit_data'").attr('value',0);
                }
                
                GetEightDReportById(id);

                // Radio buttons show on edit
                $('.finalReport').show(); 
            });

            $("#tblEightDReportCN").on('click', '.actionReUploadEightDReport', function(){
                let id = $(this).attr('eight-d-report-id');
                let reUpload = $(this).attr('re-upload');

                $("input[name='customer_claim_id'").val(id);
                console.log('actionReUploadEightDReport');
                console.log('id ', id);
                console.log('reUpload ', reUpload);
                
                if(reUpload == 0){
                    $("#btnUpploadOperationEightDReport").removeClass('d-none');
                }else{
                    $("#btnUpploadOperationEightDReport").addClass('d-none');
                }
                GetEightDReportByIdForReUpload(id);
            });

            $('#checkboxReUploadEightDReport').on('click', function(){
                
                if($('input[name="checkbox_operation_eight_d_report"]', $("#formReUploadOperationEightDReport")).is(':checked')){
                    $('#divTxtEightDReportFile', $('#formReUploadOperationEightDReport')).addClass('d-none');
                    $('#divFileEightDReportFile', $('#formReUploadOperationEightDReport')).removeClass('d-none');

                    $("#txtEightDReportFileName", $('#formReUploadOperationEightDReport')).prop('readonly', false);
                    $("#txtEightDReportFile", $('#formReUploadOperationEightDReport')).prop('readonly', false);

                    $("#btnUpploadOperationEightDReport").removeClass('d-none');
                }
                else{
                    $('#divTxtEightDReportFile', $('#formReUploadOperationEightDReport')).removeClass('d-none');
                    $('#divFileEightDReportFile', $('#formReUploadOperationEightDReport')).addClass('d-none');

                    $("#txtEightDReportFileName", $('#formReUploadOperationEightDReport')).prop('readonly', true);
                    $("#txtEightDReportFile", $('#formReUploadOperationEightDReport')).prop('readonly', true);

                    $("#btnUpploadOperationEightDReport").addClass('d-none');
                }

            });


            dataTablesCustomerClaimTS = $("#tblEightDReportTS").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ claim records",
                    "lengthMenu": "Show _MENU_ claim records",
                },
                "ajax" : {
                    url: "view_eight_d_report_ts",
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "item_number"},
                    { "data" : "status"},
                    { "data" : "model_name"},
                    { "data" : "mode_of_defect"},
                    { "data" : "quarter"},
                    { "data" : "section"},
                    { "data" : "customer_details.customer_name"},
                    { "data" : "sender_name",
                        defaultContent: 'N/A',
                    },
                    { "data" : "required_reply",
                        defaultContent: 'N/A',
                    },
                    { "data" : "initial_response",
                        defaultContent: 'N/A',
                    },
                    { "data" : "actual_response",
                        defaultContent: 'N/A',
                    },
                    { "data" : "turn_around_time",
                        defaultContent: '0 day/s',
                    },
                    // { "data" : "validity"},
                ],
            });

            //============================= Edit/Get Customer Claim Details TS =============================
            $("#tblEightDReportTS").on('click', '.actionAddEightDReport', function(){
                let id = $(this).attr('eight-d-report-id');
                console.log('id ' +id + ' on formEightDReport');
                let editData = $(this).attr('edit-data'); // came from controller once click the edit button and pass this value to edit_data(input)
                console.log('editData ' +editData);

                $("input[name='customer_claim_id'").val(id);
                // Validation For adding CAPA
                if(editData != 0){
                    $("input[name='edit_data'").attr('value',editData);
                }else{
                    $("input[name='edit_data'").attr('value',0);
                }

                GetEightDReportById(id);

                // Radio buttons show on edit
                $('.finalReport').show(); 
            });

            $("#tblEightDReportTS").on('click', '.actionReUploadEightDReport', function(){
                let id = $(this).attr('eight-d-report-id');
                let reUpload = $(this).attr('re-upload');

                $("input[name='customer_claim_id'").val(id);
                console.log('actionReUploadEightDReport');
                console.log('id ', id);

                if(reUpload == 0){
                    $("#btnUpploadOperationEightDReport").removeClass('d-none');
                }else{
                    $("#btnUpploadOperationEightDReport").addClass('d-none');
                }
                
                GetEightDReportByIdForReUpload(id);
            });


            dataTablesCustomerClaimYF = $("#tblEightDReportYF").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ claim records",
                    "lengthMenu": "Show _MENU_ claim records",
                },
                "ajax" : {
                    url: "view_eight_d_report_yf",
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "item_number"},
                    { "data" : "status"},
                    { "data" : "model_name"},
                    { "data" : "mode_of_defect"},
                    { "data" : "quarter"},
                    { "data" : "section"},
                    { "data" : "customer_details.customer_name"},
                    { "data" : "sender_name",
                        defaultContent: 'N/A',
                    },
                    { "data" : "required_reply",
                        defaultContent: 'N/A',
                    },
                    { "data" : "initial_response",
                        defaultContent: 'N/A',
                    },
                    { "data" : "actual_response",
                        defaultContent: 'N/A',
                    },
                    { "data" : "turn_around_time",
                        defaultContent: '0 day/s',
                    },
                    // { "data" : "validity"},
                ],
            });

            //============================= Edit/Get Customer Claim Details YF =============================
            $("#tblEightDReportYF").on('click', '.actionAddEightDReport', function(){
                let id = $(this).attr('eight-d-report-id');
                console.log('id ' +id + ' on formEightDReport');
                let editData = $(this).attr('edit-data'); // came from controller once click the edit button and pass this value to edit_data(input)
                console.log('editData ' +editData);
                
                $("input[name='customer_claim_id'").val(id);
                // Validation For adding CAPA
                if(editData != 0){
                    $("input[name='edit_data'").attr('value',editData);
                }else{
                    $("input[name='edit_data'").attr('value',0);
                }

                GetEightDReportById(id);

                // Radio buttons show on edit
                $('.finalReport').show(); 
            });

            $("#tblEightDReportYF").on('click', '.actionReUploadEightDReport', function(){
                let id = $(this).attr('eight-d-report-id');
                let reUpload = $(this).attr('re-upload');

                $("input[name='customer_claim_id'").val(id);
                console.log('actionReUploadEightDReport');
                console.log('id ', id);

                if(reUpload == 0){
                    $("#btnUpploadOperationEightDReport").removeClass('d-none');
                }else{
                    $("#btnUpploadOperationEightDReport").addClass('d-none');
                }
                
                GetEightDReportByIdForReUpload(id);
            });


            dataTablesCustomerClaimPPS = $("#tblEightDReportPPS").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ claim records",
                    "lengthMenu": "Show _MENU_ claim records",
                },
                "ajax" : {
                    url: "view_eight_d_report_pps",
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "item_number"},
                    { "data" : "status"},
                    { "data" : "model_name"},
                    { "data" : "mode_of_defect"},
                    { "data" : "quarter"},
                    { "data" : "section"},
                    { "data" : "customer_details.customer_name"},
                    { "data" : "sender_name",
                        defaultContent: 'N/A',
                    },
                    { "data" : "required_reply",
                        defaultContent: 'N/A',
                    },
                    { "data" : "initial_response",
                        defaultContent: 'N/A',
                    },
                    { "data" : "actual_response",
                        defaultContent: 'N/A',
                    },
                    { "data" : "turn_around_time",
                        defaultContent: '0 day/s',
                    },
                    // { "data" : "validity"},
                ],
            });

            //============================= Edit/Get Customer Claim Details YF =============================
            $("#tblEightDReportPPS").on('click', '.actionAddEightDReport', function(){
                let id = $(this).attr('eight-d-report-id');
                console.log('id ' +id + ' on formEightDReport');
                let editData = $(this).attr('edit-data'); // came from controller once click the edit button and pass this value to edit_data(input)
                console.log('editData ' +editData);
                
                $("input[name='customer_claim_id'").val(id);
                // Validation For adding CAPA
                if(editData != 0){
                    $("input[name='edit_data'").attr('value',editData);
                }else{
                    $("input[name='edit_data'").attr('value',0);
                }

                GetEightDReportById(id);

                // Radio buttons show on edit
                $('.finalReport').show(); 
            });

            $("#tblEightDReportPPS").on('click', '.actionReUploadEightDReport', function(){
                let id = $(this).attr('eight-d-report-id');
                let reUpload = $(this).attr('re-upload');

                $("input[name='customer_claim_id'").val(id);
                console.log('actionReUploadEightDReport');
                console.log('id ', id);

                if(reUpload == 0){
                    $("#btnUpploadOperationEightDReport").removeClass('d-none');
                }else{
                    $("#btnUpploadOperationEightDReport").addClass('d-none');
                }

                GetEightDReportByIdForReUpload(id);
            });


            //============================= Add 8D Report =============================
            $("#formEightDReport").submit(function(event){
                event.preventDefault(); // to stop the form submission
                AddEightDReport();
            });

            $('#checkboxEightDReport').on('click', function(){
                
                if($('input[name="checkbox_eight_d_report"]', $("#formEightDReport")).is(':checked')){
                    $('#divTxtEightDReportFile').addClass('d-none');
                    $('#divFileEightDReportFile').removeClass('d-none');

                    $('#txtEightDReportFileName').prop('readonly', false);
                    $('#fileEightDReportFile').prop('readonly', false);
                }
                else{
                    $('#divTxtEightDReportFile').removeClass('d-none');
                    $('#divFileEightDReportFile').addClass('d-none');
                    
                    $('#txtEightDReportFileName').prop('readonly', true);
                    $('#fileEightDReportFile').prop('readonly', true);
                }

            });


            //============================= Root Cause Action =============================
            let rootCauseActionCounter = 1;// counter
            $('#add_row_root_cause_action').click(function(){
                let rootCauseActionCounterForEdit =  $('#root_cause_action_counter').val();
                let editData = $('#editData').val();
                
                if(editData != 0){
                    rootCauseActionCounterForEdit++;
                    if(rootCauseActionCounterForEdit > 1){
                        $('#remove_row_root_cause_action').removeClass('d-none');
                    }
                    console.log('Add row rootCauseActionCounterForEdit ', rootCauseActionCounterForEdit);
                    
                    let root_cause_action_counter = $("input[name='root_cause_action_counter']", $('#divRootCauseAction')).val();
                    var html =  '     <div class="divHeader_'+rootCauseActionCounterForEdit+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ rootCauseActionCounterForEdit +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv" id="row_'+ rootCauseActionCounterForEdit +'">';
                        html += '       <div class="col-md-6">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                        html += '               </div>';
                        html += '               <input type="date" class="form-control form-control-sm" id="root_cause_date_'+rootCauseActionCounterForEdit+'" name="root_cause_date_'+rootCauseActionCounterForEdit+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';
                        
                        html += '       <div class="col-md-6" id="row_'+rootCauseActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 40%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                        html += '               </div>';
                        html += '               <input type="text" class="form-control form-control-sm" id="root_cause_in_charge_'+rootCauseActionCounterForEdit+'" name="root_cause_in_charge_'+rootCauseActionCounterForEdit+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+rootCauseActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" id="root_cause_corrective_action_'+rootCauseActionCounterForEdit+'" name="root_cause_corrective_action_'+rootCauseActionCounterForEdit+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+rootCauseActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" rows="2" id="root_cause_remarks_'+rootCauseActionCounterForEdit+'" name="root_cause_remarks_'+rootCauseActionCounterForEdit+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '   </div>';
                    $('#root_cause_action_counter').val(rootCauseActionCounterForEdit);
                    $('#divRootCauseAction').append(html);
                    // if(customerClaimId != null){}
                }else{
                    rootCauseActionCounter++;
                    if(rootCauseActionCounter > 1){
                        $('#remove_row_root_cause_action').removeClass('d-none');
                    }
                    console.log('Add row rootCauseActionCounter ', rootCauseActionCounter);

                    let root_cause_action_counter = $("input[name='root_cause_action_counter']", $('#divRootCauseAction')).val();
                    var html =  '     <div class="divHeader_'+rootCauseActionCounter+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ rootCauseActionCounter +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv" id="row_'+ rootCauseActionCounter +'">';
                        html += '       <div class="col-md-6">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                        html += '               </div>';
                        html += '               <input type="date" class="form-control form-control-sm" id="root_cause_date_'+rootCauseActionCounter+'" name="root_cause_date_'+rootCauseActionCounter+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';
                        
                        html += '       <div class="col-md-6" id="row_'+rootCauseActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 40%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                        html += '               </div>';
                        html += '               <input type="text" class="form-control form-control-sm" id="root_cause_in_charge_'+rootCauseActionCounter+'" name="root_cause_in_charge_'+rootCauseActionCounter+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+rootCauseActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" id="root_cause_corrective_action_'+rootCauseActionCounter+'" name="root_cause_corrective_action_'+rootCauseActionCounter+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+rootCauseActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" rows="2" id="root_cause_remarks_'+rootCauseActionCounter+'" name="root_cause_remarks_'+rootCauseActionCounter+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '   </div>';
                    $('#root_cause_action_counter').val(rootCauseActionCounter);
                    $('#divRootCauseAction').append(html);
                    // if(customerClaimId != null){}
                }
            });

            $("#rootCauseActionCard").on('click', '#remove_row_root_cause_action', function(e){
                let rootCauseActionCounterForEdit =  $('#root_cause_action_counter').val();
                
                if($('#editData').val() == 1){
                    if(rootCauseActionCounterForEdit > 1){
                        $('.divHeader_'+rootCauseActionCounterForEdit).remove();
                        $('#rootCauseActionCard').find('#row_'+rootCauseActionCounterForEdit).remove();
                        console.log('Total of rootCauseActionCounterForEdit before removing row: ', rootCauseActionCounterForEdit);
                        rootCauseActionCounterForEdit--;
                        $('#root_cause_action_counter').val(rootCauseActionCounterForEdit).trigger('change');
                        console.log('Total of rootCauseActionCounterForEdit after removing row: ' + rootCauseActionCounterForEdit);
                    }

                    if(rootCauseActionCounterForEdit < 2){
                        $('#remove_row_root_cause_action').addClass('d-none');
                    }
                }else{
                    if(rootCauseActionCounter > 1){
                        $('.divHeader_'+rootCauseActionCounter).remove();
                        $('#rootCauseActionCard').find('#row_'+rootCauseActionCounter).remove();
                        console.log('Total of rootCauseActionCounter before removing row: ', rootCauseActionCounter);
                        rootCauseActionCounter--;
                        $('#root_cause_action_counter').val(rootCauseActionCounter).trigger('change');
                        console.log('Total of rootCauseActionCounter after removing row: ' + rootCauseActionCounter);
                    }

                    if(rootCauseActionCounter < 2){
                        $('#remove_row_root_cause_action').addClass('d-none');
                    }
                }
            });


            //============================= Escapee Cause Action =============================
            let escapeeActionCounter = 1;
            $('#add_row_escapee_cause_action').click(function(){
                let escapeeCauseActionCounterForEdit =  $('#escapee_cause_action_counter').val();
                let editData = $('#editData').val();

                if(editData != 0){
                    escapeeCauseActionCounterForEdit++;
                    if(escapeeCauseActionCounterForEdit > 1){
                        $('#remove_row_escapee_cause_action').removeClass('d-none');
                    }
                    console.log('Add row escapeeCauseActionCounterForEdit ', escapeeCauseActionCounterForEdit);

                    var html =  '     <div class="divHeader_'+escapeeCauseActionCounterForEdit+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ escapeeCauseActionCounterForEdit +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv"  id="row_'+escapeeCauseActionCounterForEdit+'">';
                        html += '       <div class="col-md-6">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                        html += '               </div>';
                        html += '               <input type="date" class="form-control form-control-sm" id="escapee_cause_date_'+escapeeCauseActionCounterForEdit+'" name="escapee_cause_date_'+escapeeCauseActionCounterForEdit+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';
                        
                        html += '       <div class="col-md-6" id="row_'+escapeeCauseActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 40%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                        html += '               </div>';
                        html += '               <input type="text" class="form-control form-control-sm" id="escapee_cause_in_charge_'+escapeeCauseActionCounterForEdit+'" name="escapee_cause_in_charge_'+escapeeCauseActionCounterForEdit+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+escapeeCauseActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" id="escapee_cause_corrective_action_'+escapeeCauseActionCounterForEdit+'" name="escapee_cause_corrective_action_'+escapeeCauseActionCounterForEdit+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+escapeeCauseActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" rows="2" id="escapee_cause_remarks_'+escapeeCauseActionCounterForEdit+'" name="escapee_cause_remarks_'+escapeeCauseActionCounterForEdit+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '   </div>';
                    $('#escapee_cause_action_counter').val(escapeeCauseActionCounterForEdit);
                    $('#divEscapeeCauseAction').append(html);
                }else{
                    escapeeActionCounter++;
                    if(escapeeActionCounter > 1){
                        $('#remove_row_escapee_cause_action').removeClass('d-none');
                    }
                    console.log('Add row escapeeCauseActionCounter ', escapeeActionCounter);

                    let escapee_cause_action_counter = $("input[name='escapee_cause_action_counter']", $('#divEscapeeCauseAction')).val();
                    // let customerClaimId = $("input[name='customer_claim_id'", $("#formCustomerClaim")).val();
                    // console.log('customerClaimId ', customerClaimId);
                    var html =  '     <div class="divHeader_'+escapeeActionCounter+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ escapeeActionCounter +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv"  id="row_'+escapeeActionCounter+'">';
                        html += '       <div class="col-md-6">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                        html += '               </div>';
                        html += '               <input type="date" class="form-control form-control-sm" id="escapee_cause_date_'+escapeeActionCounter+'" name="escapee_cause_date_'+escapeeActionCounter+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';
                        
                        html += '       <div class="col-md-6" id="row_'+escapeeActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 40%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                        html += '               </div>';
                        html += '               <input type="text" class="form-control form-control-sm" id="escapee_cause_in_charge_'+escapeeActionCounter+'" name="escapee_cause_in_charge_'+escapeeActionCounter+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+escapeeActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" id="escapee_cause_corrective_action_'+escapeeActionCounter+'" name="escapee_cause_corrective_action_'+escapeeActionCounter+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+escapeeActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" rows="2" id="escapee_cause_remarks_'+escapeeActionCounter+'" name="escapee_cause_remarks_'+escapeeActionCounter+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '   </div>';
                    $('#escapee_cause_action_counter').val(escapeeActionCounter);
                    $('#divEscapeeCauseAction').append(html);
                }
            });

            $("#escapeeCauseActionCard").on('click', '#remove_row_escapee_cause_action', function(e){
                let escapeeCauseActionCounterForEdit =  $('#escapee_cause_action_counter').val();

                if($('#editData').val() == 1){
                    if(escapeeCauseActionCounterForEdit > 1){
                        $('.divHeader_'+escapeeCauseActionCounterForEdit).remove();
                        $('#escapeeCauseActionCard').find('#row_'+escapeeCauseActionCounterForEdit).remove();
                        console.log('Total of escapeeCauseActionCounterForEdit before removing row: ', escapeeCauseActionCounterForEdit);
                        escapeeCauseActionCounterForEdit--;
                        $('#escapee_cause_action_counter').val(escapeeCauseActionCounterForEdit).trigger('change');
                        console.log('Total of escapeeCauseActionCounterForEdit after removing row: ' + escapeeCauseActionCounterForEdit);
                    }

                    if(escapeeCauseActionCounterForEdit < 2){
                        $('#remove_row_escapee_cause_action').addClass('d-none');
                    }
                }else{
                    if(escapeeActionCounter > 1){
                        $('.divHeader_'+escapeeActionCounter).remove();
                        $('#escapeeCauseActionCard').find('#row_'+escapeeActionCounter).remove();
                        console.log('Total of escapeeActionCounter before removing row: ', escapeeActionCounter);
                        escapeeActionCounter--;
                        $('#escapee_cause_action_counter').val(escapeeActionCounter).trigger('change');
                        console.log('Total of escapeeActionCounter after removing row: ' + escapeeActionCounter);
                    }

                    if(escapeeActionCounter < 2){
                        $('#remove_row_escapee_cause_action').addClass('d-none');
                    }
                }
                
            });


            //============================= Systemic Action =============================
            let systemicActionCounter = 1; // counter for txt_max_row
            $('#add_row_systemic_action').click(function(){
                let systemicActionCounterForEdit =  $('#systemic_action_counter').val();
                let editData = $('#editData').val();

                if(editData != 0){
                    systemicActionCounterForEdit++;
                    if(systemicActionCounterForEdit > 1){
                        $('#remove_row_systemic_action').removeClass('d-none');
                    }
                    console.log('Add row systemicActionCounterForEdit ', systemicActionCounterForEdit);
                    var html =  '     <div class="divHeader_'+systemicActionCounterForEdit+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ systemicActionCounterForEdit +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv" id="row_'+systemicActionCounterForEdit+'">';
                        html += '       <div class="col-md-6">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                        html += '               </div>';
                        html += '               <input type="date" class="form-control form-control-sm" id="systemic_date_'+systemicActionCounterForEdit+'" name="systemic_date_'+systemicActionCounterForEdit+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';
                        
                        html += '       <div class="col-md-6" id="row_'+systemicActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 40%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                        html += '               </div>';
                        html += '               <input type="text" class="form-control form-control-sm" id="systemic_in_charge_'+systemicActionCounterForEdit+'" name="systemic_in_charge_'+systemicActionCounterForEdit+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+systemicActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" id="systemic_corrective_action_'+systemicActionCounterForEdit+'" name="systemic_corrective_action_'+systemicActionCounterForEdit+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+systemicActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" rows="2" id="systemic_remarks_'+systemicActionCounterForEdit+'" name="systemic_remarks_'+systemicActionCounterForEdit+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '   </div>';
                    $('#systemic_action_counter').val(systemicActionCounterForEdit);
                    $('#divSystemicAction').append(html);
                }else{
                    systemicActionCounter++;
                    if(systemicActionCounter > 1){
                        $('#remove_row_systemic_action').removeClass('d-none');
                    }

                    console.log('Add row systemicActionCounter ', systemicActionCounter);
                    var html =  '     <div class="divHeader_'+systemicActionCounter+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ systemicActionCounter +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv" id="row_'+systemicActionCounter+'">';
                        html += '       <div class="col-md-6">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                        html += '               </div>';
                        html += '               <input type="date" class="form-control form-control-sm" id="systemic_date_'+systemicActionCounter+'" name="systemic_date_'+systemicActionCounter+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';
                        
                        html += '       <div class="col-md-6" id="row_'+systemicActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 40%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                        html += '               </div>';
                        html += '               <input type="text" class="form-control form-control-sm" id="systemic_in_charge_'+systemicActionCounter+'" name="systemic_in_charge_'+systemicActionCounter+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+systemicActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" id="systemic_corrective_action_'+systemicActionCounter+'" name="systemic_corrective_action_'+systemicActionCounter+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+systemicActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" rows="2" id="systemic_remarks_'+systemicActionCounter+'" name="systemic_remarks_'+systemicActionCounter+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '   </div>';
                    $('#systemic_action_counter').val(systemicActionCounter);
                    $('#divSystemicAction').append(html);
                }
                
            });

            $("#systemicActionCard").on('click', '#remove_row_systemic_action', function(e){
                let systemicActionCounterForEdit =  $('#systemic_action_counter').val();

                if($('#editData').val() == 1){
                    if(systemicActionCounterForEdit > 1){
                        $('.divHeader_'+systemicActionCounterForEdit).remove();
                        $('#systemicActionCard').find('#row_'+systemicActionCounterForEdit).remove();
                        console.log('Total of systemicActionCounterForEdit before removing row: ', systemicActionCounterForEdit);
                        systemicActionCounterForEdit--;
                        $('#systemic_action_counter').val(systemicActionCounterForEdit).trigger('change');
                        console.log('Total of systemicActionCounterForEdit after removing row: ', systemicActionCounterForEdit);
                    }

                    if(systemicActionCounterForEdit < 2){
                        $('#remove_row_systemic_action').addClass('d-none');
                    }
                }else{
                    if(systemicActionCounter > 1){
                        $('.divHeader_'+systemicActionCounter).remove();
                        $('#systemicActionCard').find('#row_'+systemicActionCounter).remove();
                        console.log('Total of systemicActionCounter before removing row: ', systemicActionCounter);
                        systemicActionCounter--;
                        $('#systemic_action_counter').val(systemicActionCounter).trigger('change');
                        console.log('Total of systemicActionCounter after removing row: ', systemicActionCounter);
                    }

                    if(systemicActionCounter < 2){
                        $('#remove_row_systemic_action').addClass('d-none');
                    }
                }
            });


            //============================= Fanout Action =============================
            let fanOutActionCounter = 1;
            $('#add_row_fanout_action').click(function(){
                let fanOutActionCounterForEdit =  $('#fanout_action_counter').val();
                let editData = $('#editData').val();

                if(editData != 0){
                    fanOutActionCounterForEdit++;
                    if(fanOutActionCounterForEdit > 1){
                        $('#remove_row_fanout_action').removeClass('d-none');
                    }
                    console.log('Add row fanOutActionCounterForEdit ', fanOutActionCounterForEdit);

                    var html =  '     <div class="divHeader_'+fanOutActionCounterForEdit+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ fanOutActionCounterForEdit +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv" id="row_'+fanOutActionCounterForEdit+'">';
                        html += '       <div class="col-md-4">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                        html += '               </div>';
                        html += '               <input type="date" class="form-control form-control-sm" id="fanout_due_date_'+fanOutActionCounterForEdit+'" name="fanout_due_date_'+fanOutActionCounterForEdit+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';
                        
                        html += '       <div class="col-md-4" id="row_'+fanOutActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 40%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Product Name</i></span>';
                        html += '               </div>';
                        html += '               <input type="text" class="form-control form-control-sm" id="fanout_product_name_'+fanOutActionCounterForEdit+'" name="fanout_product_name_'+fanOutActionCounterForEdit+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-4" id="row_'+fanOutActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 40%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                        html += '               </div>';
                        html += '               <input type="text" class="form-control form-control-sm" id="fanout_in_charge_'+fanOutActionCounterForEdit+'" name="fanout_in_charge_'+fanOutActionCounterForEdit+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+fanOutActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" id="fanout_corrective_action_'+fanOutActionCounterForEdit+'" name="fanout_corrective_action_'+fanOutActionCounterForEdit+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+fanOutActionCounterForEdit+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" rows="2" id="fanout_remarks_'+fanOutActionCounterForEdit+'" name="fanout_remarks_'+fanOutActionCounterForEdit+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '   </div>';
                    $('#fanout_action_counter').val(fanOutActionCounterForEdit);
                    $('#divFanOutAction').append(html);
                }else{
                    fanOutActionCounter++;
                    if(fanOutActionCounter > 1){
                        $('#remove_row_fanout_action').removeClass('d-none');
                    }
                    console.log('Add row fanOutActionCounter ', fanOutActionCounter);

                    var html =  '     <div class="divHeader_'+fanOutActionCounter+' generatedDivHeader"><h6><span class="badge badge-secondary"> # '+ fanOutActionCounter +'.</span></h6></div>';
                        html += '	  <div class="row mt-2 generatedDiv" id="row_'+fanOutActionCounter+'">';
                        html += '       <div class="col-md-4">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Date</i></span>';
                        html += '               </div>';
                        html += '               <input type="date" class="form-control form-control-sm" id="fanout_due_date_'+fanOutActionCounter+'" name="fanout_due_date_'+fanOutActionCounter+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';
                        
                        html += '       <div class="col-md-4" id="row_'+fanOutActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 40%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Product Name</i></span>';
                        html += '               </div>';
                        html += '               <input type="text" class="form-control form-control-sm" id="fanout_product_name_'+fanOutActionCounter+'" name="fanout_product_name_'+fanOutActionCounter+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-4" id="row_'+fanOutActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 40%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">In-charge</i></span>';
                        html += '               </div>';
                        html += '               <input type="text" class="form-control form-control-sm" id="fanout_in_charge_'+fanOutActionCounter+'" name="fanout_in_charge_'+fanOutActionCounter+'" placeholder="required">';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+fanOutActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Corrective Action</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" id="fanout_corrective_action_'+fanOutActionCounter+'" name="fanout_corrective_action_'+fanOutActionCounter+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';

                        html += '       <div class="col-md-12" id="row_'+fanOutActionCounter+'">';
                        html += '           <div class="input-group input-group-sm mb-3">';
                        html += '                <div class="input-group-prepend" style="width: 30%;">';
                        html += '                   <span class="input-group-text w-100" id="basic-addon1">Remarks</i></span>';
                        html += '               </div>';
                        html += '               <textarea class="form-control form-control-sm" rows="2" id="fanout_remarks_'+fanOutActionCounter+'" name="fanout_remarks_'+fanOutActionCounter+'" placeholder="required"></textarea>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '   </div>';
                    $('#fanout_action_counter').val(fanOutActionCounter);
                    $('#divFanOutAction').append(html);
                }
                
            });

            $("#fanoutActionCard").on('click', '#remove_row_fanout_action', function(e){
                let fanOutActionCounterForEdit =  $('#fanout_action_counter').val();
                
                if($('#editData').val() == 1){
                    if(fanOutActionCounterForEdit > 1){
                        $('.divHeader_'+fanOutActionCounterForEdit).remove();
                        $('#fanoutActionCard').find('#row_'+fanOutActionCounterForEdit).remove();
                        console.log('Total of fanOutActionCounterForEdit before removing row: ', fanOutActionCounterForEdit);
                        fanOutActionCounterForEdit--;
                        $('#fanout_action_counter').val(fanOutActionCounterForEdit).trigger('change');
                        console.log('Total of fanOutActionCounterForEdit after removing row: ' + fanOutActionCounterForEdit);
                    }

                    if(fanOutActionCounterForEdit < 2){
                        $('#remove_row_fanout_action').addClass('d-none');
                    }
                }else{
                    if(fanOutActionCounter > 1){
                        $('.divHeader_'+fanOutActionCounter).remove();
                        $('#fanoutActionCard').find('#row_'+fanOutActionCounter).remove();
                        console.log('Total of fanOutActionCounter before removing row: ', fanOutActionCounter);
                        fanOutActionCounter--;
                        $('#fanout_action_counter').val(fanOutActionCounter).trigger('change');
                        console.log('Total of fanOutActionCounter after removing row: ' + fanOutActionCounter);
                    }

                    if(fanOutActionCounter < 2){
                        $('#remove_row_fanout_action').addClass('d-none');
                    }z
                }
                
            });


            dataTablesEightDReportHistory = $("#tblEightDReportHistory").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ report records",
                    "lengthMenu": "Show _MENU_ report records",
                },
                "ajax" : {
                    url: "view_eight_d_report_history",
                    data: function (param){
                        // param.customerClaimId = $('input[type="customer_claim_id"]').val();
                        param.customerClaimId = $('#customerClaimId').val();
                    },
                },
                "columns":[
                    { "data" : "revision_counter"},
                    { "data" : "customer_info.operation_eight_d_report_name"},
                    { "data" : "customer_info.operation_eight_d_report_date"},
                    { "data" : "remarks"},
                    // { "data" : "submitted_by"},
                ],
            });

            $('#btnViewRevisionHistory').on('click', function(){
                $('#modalEightDReportHistory').modal('show');
                dataTablesEightDReportHistory.draw();
            });


            $("#btnUpploadOperationEightDReport").click(function(event){
                event.preventDefault(); // to stop the form submission
                UploadOperationEightDReportForValidatedClaim();
            });
        });
    </script>
@endsection