{{-- @php
    session_start();
@endphp

@php $layout = 'layouts.super_user_layout'; @endphp

@php
    if(isset($_SESSION['rapidx_user_level_id']) && !empty($_SESSION['rapidx_user_level_id'])){
        if($_SESSION['rapidx_user_level_id'] == 1 || $_SESSION['rapidx_user_level_id'] == 4){
        $layout = 'layouts.super_user_layout';
        }
        else if($_SESSION['rapidx_user_level_id'] == 5){
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
    if(!isset($_SESSION)){ 
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
@section('title', 'Customer Claim System')

@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customer Claim</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customer Claim</li>
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
                                <h3 class="card-title" style="margin-top: 8px;">Customer Claim</h3>
                                <button class="btn float-right reload"><i class="fas fa-sync-alt"></i></button>
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
                                    {{-- <input type="text" id="txtCustomerToFilter">
                                    <input type="text" id="txtModeOfDefectToFilter">
                                    <input type="text" id="txtSectionToFilter">
                                    <input type="text" id="txtModeToFilter">
                                    <input type="text" id="txtClassificationToFilter">
                                    <input type="text" id="txtClassToFilter">
                                    <input type="text" id="txtReferenceNoToFilter">
                                    <input type="text" id="txtControlNoToFilter">
                                    <input type="text" id="txttraceabilityToFilter">
                                    <input type="text" id="txtContributorToFilter">
                                    <input type="text" id="txtRTVToFilter"> --}}
                                        
                                    
                                    <div class="tab-pane fade show active" id="cn" value="cn" role="tabpanel" aria-labelledby="cn-tab">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12 col-lg-7 col-xl-6 pt-4">
                                                <form method="get" id="formDateRangeCN">
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
                                            <div class="col-xs-12 col-md-12 col-lg-5 col-xl-6 text-right mt-4">
                                                <button class="btn btn-info" data-toggle="modal" data-target="#modalFilterCustomerClaim" id=""><i class="fas fa-filter fa-md"></i> Filter</button>             
                                                <button class="btn btn-primary btnShowAddCustomerClaimModal" data-toggle="modal" data-target="#modalAddCustomerClaim"  value="CN" id="btnShowAddCustomerClaimModal"><i class="fa fa-plus fa-md"></i> New Customer Claim</button>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="text-right mt-4">      
                                            <button class="btn btn-info" data-toggle="modal" data-target="#modalFilterCustomerClaim" id=""><i class="fas fa-filter fa-md"></i> Filter</button>             
                                            <button class="btn btn-primary btnShowAddCustomerClaimModal" data-toggle="modal" data-target="#modalAddCustomerClaim"  value="CN" id="btnShowAddCustomerClaimModal"><i class="fa fa-plus fa-md"></i> New Customer Claim</button>
                                        </div><br> --}}
                                        <table id="tblCustomerClaimCN" class="table table-responsive table-sm table-bordered table-hover nowrap" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Item No.</th>
                                                    <th>Claim Status</th>
                                                    <th style="min-width: 250px; width: 250px !important;">Uploaded 8D Report File</th>
                                                    <th>Quarter</th>
                                                    <th>Section</th>
                                                    <th>Customer</th>
                                                    <th>Date Received</th>
                                                    <th>Required Reply</th>
                                                    <th>Initial Response</th>
                                                    <th>Actual Response</th>
                                                    <th>TAT</th>
                                                    <th>Validity</th>
                                                    <th>Submitted 8D Report</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="ts" value="ts" role="tabpanel" aria-labelledby="ts-tab">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12 col-lg-7 col-xl-6 pt-4">
                                                <form method="get" id="formDateRangeTS">
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
                                            <div class="col-xs-12 col-md-12 col-lg-5 col-xl-6 text-right mt-4">
                                                <button class="btn btn-info" data-toggle="modal" data-target="#modalFilterCustomerClaim" id=""><i class="fas fa-filter fa-md"></i> Filter</button>             
                                                <button class="btn btn-primary btnShowAddCustomerClaimModal" data-toggle="modal" data-target="#modalAddCustomerClaim" value="TS" id="btnShowAddCustomerClaimModal"><i class="fa fa-plus fa-md"></i> New Customer Claim</button>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="text-right mt-4">     
                                            <button class="btn btn-info" data-toggle="modal" data-target="#modalFilterCustomerClaim" id=""><i class="fas fa-filter fa-md"></i> Filter</button>             
                                            <button class="btn btn-primary btnShowAddCustomerClaimModal" data-toggle="modal" data-target="#modalAddCustomerClaim" value="TS" id="btnShowAddCustomerClaimModal"><i class="fa fa-plus fa-md"></i> New Customer Claim</button>
                                        </div><br> --}}
                                        {{-- <div class="table-responsive"> --}}
                                            <table id="tblCustomerClaimTS" class="table table-responsive table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Item No.</th>
                                                        <th>Claim Status</th>
                                                        <th style="min-width: 250px; width: 250px !important;">Uploaded 8D Report File</th>
                                                        <th>Quarter</th>
                                                        <th>Section</th>
                                                        <th>Customer</th>
                                                        <th>Date Received</th>
                                                        <th>Required Reply</th>
                                                        <th>Initial Response</th>
                                                        <th>Actual Response</th>
                                                        <th>TAT</th>
                                                        <th>Validity</th>
                                                        <th>Submitted 8D Report</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="tab-pane fade" id="yf" value="yf" role="tabpanel" aria-labelledby="yf-tab">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12 col-lg-7 col-xl-6 pt-4">
                                                <form method="get" id="formDateRangeYF">
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
                                            <div class="col-xs-12 col-md-12 col-lg-5 col-xl-6 text-right mt-4">
                                                <button class="btn btn-info" data-toggle="modal" data-target="#modalFilterCustomerClaim" id=""><i class="fas fa-filter fa-md"></i> Filter</button>             
                                            <button class="btn btn-primary btnShowAddCustomerClaimModal" data-toggle="modal" data-target="#modalAddCustomerClaim" value="YF" id="btnShowAddCustomerClaimModal"><i class="fa fa-plus fa-md"></i> New Customer Claim</button>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="text-right mt-4">                   
                                            <button class="btn btn-info" data-toggle="modal" data-target="#modalFilterCustomerClaim" id=""><i class="fas fa-filter fa-md"></i> Filter</button>             
                                            <button class="btn btn-primary btnShowAddCustomerClaimModal" data-toggle="modal" data-target="#modalAddCustomerClaim" value="YF" id="btnShowAddCustomerClaimModal"><i class="fa fa-plus fa-md"></i> New Customer Claim</button>
                                        </div><br> --}}
                                        {{-- <div class="table-responsive"> --}}
                                            <table id="tblCustomerClaimYF" class="table table-responsive table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Item No.</th>
                                                        <th>Claim Status</th>
                                                        <th style="min-width: 250px; width: 250px !important;">Uploaded 8D Report File</th>
                                                        <th>Quarter</th>
                                                        <th>Section</th>
                                                        <th>Customer</th>
                                                        <th>Date Received</th>
                                                        <th>Required Reply</th>
                                                        <th>Initial Response</th>
                                                        <th>Actual Response</th>
                                                        <th>TAT</th>
                                                        <th>Validity</th>
                                                        <th>Submitted 8D Report</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="tab-pane fade" id="pps" value="pps" role="tabpanel" aria-labelledby="pps-tab">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12 col-lg-7 col-xl-6 pt-4">
                                                <form method="get" id="formDateRangePPS">
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
                                            <div class="col-xs-12 col-md-12 col-lg-5 col-xl-6 text-right mt-4">
                                                <button class="btn btn-info" data-toggle="modal" data-target="#modalFilterCustomerClaim" id=""><i class="fas fa-filter fa-md"></i> Filter</button>             
                                                <button class="btn btn-primary btnShowAddCustomerClaimModal" data-toggle="modal" data-target="#modalAddCustomerClaim" value="PPS" id="btnShowAddCustomerClaimModal"><i class="fa fa-plus fa-md"></i> New Customer Claim</button>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="text-right mt-4">          
                                            <button class="btn btn-info" data-toggle="modal" data-target="#modalFilterCustomerClaim" id=""><i class="fas fa-filter fa-md"></i> Filter</button>             
                                            <button class="btn btn-primary btnShowAddCustomerClaimModal" data-toggle="modal" data-target="#modalAddCustomerClaim" value="PPS" id="btnShowAddCustomerClaimModal"><i class="fa fa-plus fa-md"></i> New Customer Claim</button>
                                        </div><br> --}}
                                        {{-- <div class="table-responsive"> --}}
                                            <table id="tblCustomerClaimPPS" class="table table-responsive table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Item No.</th>
                                                        <th>Claim Status</th>
                                                        <th style="min-width: 250px; width: 250px !important;">Uploaded 8D Report File</th>
                                                        <th>Quarter</th>
                                                        <th>Section</th>
                                                        <th>Customer</th>
                                                        <th>Date Received</th>
                                                        <th>Required Reply</th>
                                                        <th>Initial Response</th>
                                                        <th>Actual Response</th>
                                                        <th>TAT</th>
                                                        <th>Validity</th>
                                                        <th>Submitted 8D Report</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Add Customer Claim Modal Start -->
    <div class="modal fade" id="modalAddCustomerClaim" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl-custom">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Customer Claim Details</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formAddCustomerClaim" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div id="smartwizard">
                            <ul class="nav">
                                <li step_status="0"><a href="#step-1"><i class="fas fa-info-circle"></i> Step 1<br /><small>Customer Claim Details</small></a></li>
                                <li step_status="0"><a href="#step-2"><i class="fas fa-info-circle"></i> Step 2<br /><small>Data Verification</small></a></li>
                                <li step_status="1"><a href="#step-3"><i class="fas fa-info-circle"></i> Step 3<br /><small>Unit Verification</small></a></li>
                            </ul>

                            <div class="tab-content mt-2">
                                <div id="step-1">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong><span class="badge badge-secondary">1.</span>&nbsp;Claim Details</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <input type="text" class="form-control form-control-sm customer-claim-input" placeholder="Customer Claim ID" name="customer_claim_id" style="display: none;">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Division/Section</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="section_display" id="txtAddSection" disabled aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                        <input type="hidden" class="form-control" name="section" id="txtAddSectionHidden">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Item Number</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="item_number" id="txtAddItemNumber" disabled placeholder="Auto Generated" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Control Number</span>
                                                        </div>
                                                        <input type="text" class="form-control" arr-index="1" readonly name="pmi_control_number" id="txtAddControlNumber" autocomplete="off" placeholder="ex: CC-0126-001-PPS" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Reference Number</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="reference_number" id="txtAddReferenceNumber" autocomplete="off" placeholder="Optional" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Quarter</span>
                                                        </div>
                                                        <select class="form-control select2bs4 selectQuarter" arr-index="2" name="quarter" id="selectQuarter" aria-label="Default" aria-describedby="inputGroup-sizing-default">
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
                                                        <select class="form-control select2bs4 selectCustomer" arr-index="3" name="customer" id="selectCustomer" aria-label="Default" aria-describedby="inputGroup-sizing-default">
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
                                                        <select class="form-control select2bs4 selectSenderName" arr-index="4" name="sender_name" id="selectSenderName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                            <!-- Auto Generated -->
                                                            <option value="" disabled selected>Select One</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Contributor</span>
                                                        </div>
                                                        <select class="form-control select2bs4 selectContributor" arr-index="5" name="contributor" id="selectContributor" aria-label="Default" aria-describedby="inputGroup-sizing-default">
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
                                                        <select class="form-control select2bs4 selectValidity" arr-index="6" name="validity" id="selectValidity" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                            <option value="" disabled selected>Select One</option>
                                                            <option value="1">Valid</option>
                                                            <option value="2">Information</option>
                                                            <option value="3">Feedback</option>
                                                            <option value="4">Invalid</option>
                                                            <option value="5">N/A</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong><span class="badge badge-secondary">2.</span>&nbsp;Product Details</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Product Classification</span>
                                                        </div>
                                                        <select class="form-control select2bs4 selectProductClassification" arr-index="7" name="product_classification" id="selectProductClassification" aria-label="Default" aria-describedby="inputGroup-sizing-default">
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
                                                        <input type="text" class="form-control" arr-index="8" name="model_name" id="txtAddModelName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Mode of Defect</span>
                                                        </div>
                                                        <input type="text" class="form-control" arr-index="9" name="mode_of_defect" id="txtAddModeOfDefect" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">PO Number</span>
                                                        </div>
                                                        <input type="text" class="form-control" arr-index="10" name="po_number" id="txtAddPONumber" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Lot Traceability</span>
                                                        </div>
                                                        <input type="text" class="form-control" arr-index="10" name="lot_traceability" id="txtAddLotTraceability" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Automotive/Non-Automotive</span>
                                                        </div>
                                                        <select class="form-control select2bs4 selectAutomotive" arr-index="11" name="automotive" id="selectAutomotive" aria-label="Default" aria-describedby="inputGroup-sizing-default">
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
                                                        {{-- <input type="number" class="form-control" arr-index="12" name="quantity" id="txtAddQuantity" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"> --}}
                                                        <input type="text" class="form-control"  name="quantity" id="txtAddQuantity">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Shipment Quantity</span>
                                                        </div>
                                                        {{-- <input type="number" class="form-control" arr-index="12" name="quantity" id="txtAddQuantity" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"> --}}
                                                        <input type="text" class="form-control"  name="shipment_quantity" id="txtAddShipmentQuantity">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Number of NG</span>
                                                        </div>
                                                        <input type="number" class="form-control" arr-index="13" name="number_of_ng" id="txtAddNumberOfNG" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Return to Vendor</span>
                                                        </div>
                                                        <input type="text" class="form-control" arr-index="14" name="return_to_vendor" id="txtAddReturnToVendor" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Defect Category Class(A/B/C)</span>
                                                        </div>
                                                        <select class="form-control select2bs4 selectValidity" arr-index="15" name="defect_category_class" id="selectDefectCategoryClass" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                            <option value="" disabled selected>Select One</option>
                                                            <option value="1">Class A</option>
                                                            <option value="2">Class B</option>
                                                            <option value="3">Class C</option>
                                                            <option value="4">N/A</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong><span class="badge badge-secondary">3.</span>&nbsp;Date Details</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Date Received</span>
                                                        </div>
                                                        {{-- <input type="date" class="form-control datetimepicker" name="date_received" id="txtDateReceived" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                        <input type="text" class="form-control datetimepicker" arr-index="16" name="date_received" id="txtDateReceived" autocomplete="off" placeholder="yyyy/mm/dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                        
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="chkActualDateReceivedClaim" name="chk_actual_date_received_claim">&nbsp;Actual Date Received of Claim</span>
                                                        </div>
                                                        {{-- <input type="date" class="form-control datetimepicker" name="actual_date_received_claim" id="txtAddActualDateReceivedOfClaim" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                        <input type="text" class="form-control datetimepicker" name="actual_date_received_claim" id="txtAddActualDateReceivedOfClaim" autocomplete="off" placeholder="yyyy/mm/dd" disabled aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="chkdateReturnClaim" name="chk_date_return_of_claim">&nbsp;Date Return of Claim Sample</span>
                                                        </div>
                                                        {{-- <input type="date" class="form-control datetimepicker" name="date_return_of_claim" id="txtAddDateReturnOfClaimSample" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                        <input type="text" class="form-control datetimepicker" name="date_return_of_claim" id="txtAddDateReturnOfClaimSample" autocomplete="off"  placeholder="yyyy/mm/dd" disabled aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Required Reply</span>
                                                        </div>
                                                        {{-- <input type="date" class="form-control datetimepicker" name="required_reply" id="txtAddRequiredReply" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                        <input type="text" class="form-control datetimepicker" arr-index="17" name="required_reply" id="txtAddRequiredReply" autocomplete="off" placeholder="yyyy/mm/dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Initial Response</span>
                                                        </div>
                                                        {{-- <input type="date" class="form-control datetimepicker" name="initial_response" id="txtAddInitialResponse" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                        <input type="text" class="form-control datetimepicker" arr-index="18" name="initial_response" id="txtAddInitialResponse" autocomplete="off" placeholder="yyyy/mm/dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Actual Response</span>
                                                        </div>
                                                        {{-- <input type="date" class="form-control datetimepicker" name="actual_response" type="text" onfocus="(this.type='date')" id="txtAddActualResponse" placeholder="Auto Generated" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                        <input type="text" class="form-control datetimepicker" arr-index="19" name="actual_response" type="text" id="txtAddActualResponse" autocomplete="off" placeholder="yyyy/mm/dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                        {{-- <input type="text" class="form-control" name="actual_response" type="text" onfocus="(this.type='date')" id="txtAddActualResponse" placeholder="Auto Generated" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Shipment Date</span>
                                                        </div>
                                                        {{-- <input type="date" class="form-control datetimepicker" name="initial_response" id="txtAddInitialResponse" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                        <input type="text" class="form-control datetimepicker" arr-index="18" name="shipment_date" id="txtAddShipmentDate" autocomplete="off" placeholder="yyyy/mm/dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Turn Around Time</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="turn_around_time" id="txtAddTurnAroundTime" disabled placeholder="Auto Generated" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Remarks</span>
                                                        </div>
                                                        {{-- <input type="date" class="form-control datetimepicker" name="date_return_of_claim" id="txtAddDateReturnOfClaimSample" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                        <textarea type="text" class="form-control" name="remarks" id="txtAddRemarks" rows="2" autocomplete="off"  placeholder="Remarks" aria-label="Default" aria-describedby="inputGroup-sizing-default"></textarea>
                                                    </div>
                                                    
                                                    <div class="input-group finalReport">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Final Report</span>
                                                        </div>
                                                        <div class="w-50" style="border-style: solid; padding-left: 5px; padding-top: 5px; border-width: 1px; border-color: #d5deeb;">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="final_report" id="radioOntime" value="1">
                                                                <label class="form-check-label" for="radioOntime">On Time</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="final_report" id="radioLate" value="2">
                                                                <label class="form-check-label" for="radioLate">Late</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="finalReport" style="float:right;">
                                                    
                                                    </div> --}}
                                                    
                                                    {{-- <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Email Recipient (Attention)</span>
                                                        </div>
                                                        <select class="form-control select2bs4 select2Tags customer-claim-input" name="email_recipient_attention[]" multiple="true" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                            <!-- Auto Generated -->
                                                        </select>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Email Recipient (CC)</span>
                                                        </div>
                                                        <select class="form-control select2bs4 select2Tags customer-claim-input" name="email_recipient_cc[]" multiple="true" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                            <!-- Auto Generated -->
                                                        </select>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong><span class="badge badge-secondary">4.</span>&nbsp;YEC/YED Report Receive (E-mail)</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">YEC/YED Sender Name</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="yec_sender_name" readonly id="txtAddSenderName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">YEC/YED Report Received</span>
                                                        </div>
                                                        <input type="date" class="form-control" name="report_receive" readonly id="txtAddReportReceived" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    {{-- <div class="input-group mb-3" id="fileNameId" style="display: none;">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">YEC/YED Report File</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="report_filename" id="txtReportFileNane" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div> --}}

                                                    <div class="input-group mb-3" id="txtEmailAttachment">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">YEC/YED Report File</span>
                                                        </div>
                                                        <input type="text" name="report_filename" id="txtReportFileName" class="form-control" readonly>
                                                    </div>
                                                    <div class="input-group mb-3" id="fileEmailAttachment">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">YEC/YED Report File</span>
                                                        </div>
                                                        <input type="file" class="form-control" name="email_attachment" id="txtAddReportFile" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3 ml-4 d-none" id="divCheckboxEmailAttachment">
                                                        {{-- <input type="checkbox" id="chkdateReturnClaim" name="chk_date_return_of_claim"> --}}
                                                        <input type="checkbox" class="form-check-input" name="checkbox_email_attachment" id="checkboxEmailAttachment">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Re-upload
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong><span class="badge badge-secondary">5.</span>&nbsp;8D Report</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">8D Filename</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="eight_d_report_name" id="txtAddEightDReportName" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    {{-- <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Date </span>
                                                        </div>
                                                        <input type="date" class="form-control" name="email_date" id="txtAddEmailDate" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div> --}}

                                                    <div class="input-group mb-3" id="divEightDReportFilename">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">8D File</span>
                                                        </div>
                                                        <input type="text" name="eight_d_report_filename" id="txtEightDReportFileName" class="form-control h-100" readonly>
                                                    </div>

                                                    <div class="input-group mb-3" id="divEightDReportFile">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">8D File</span>
                                                        </div>
                                                        <input type="file" class="form-control" name="eight_d_report_file" id="txtAddEightDFileUpload" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3 ml-4" id="divEightDReport">
                                                        <input class="form-check-input" type="checkbox" name="checkbox_eight_d_report" id="checkboxEightDReport">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Re-upload
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card" id="divEmailId">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong><span class="badge badge-secondary">6.</span>&nbsp; Email Recipient</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Email Recipient (Attention)</span>
                                                        </div>
                                                        <select class="form-control select2bs4 select2Tags customer-claim-input" name="email_recipient_attention[]" multiple="true" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                            <!-- Auto Generated -->
                                                        </select>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Email Recipient (CC)</span>
                                                        </div>
                                                        <select class="form-control select2bs4 select2Tags customer-claim-input" name="email_recipient_cc[]" multiple="true" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                            <!-- Auto Generated -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 status">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>Status</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="info-box" style="margin-top: 27px !important">
                                                        <span class="info-box-icon" id="statusBgColor"><i class="fa fa-file"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Status</span>
                                                            <span class="info-box-text" id="spanStatus"></span>
                                                        </div>
                                                        <span class="info-box-icon" id="initialReportBgColor"><i class="fa fa-file"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Initial Report</span>
                                                            <span class="info-box-text" id="spanInitialReport"></span>
                                                        </div>
                                                        <span class="info-box-icon" id="finalReportBgColor"><i class="fa fa-file"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Final Report</span>
                                                            <span class="info-box-text" id="spanFinalReport"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="step-2">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>Data Verification</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div><label for="">1. Is P.O Number traceable to PMI?</label></div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_po_number_traceable" id="is_po_number_traceable_yes" value="1">
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input is_po_number_traceable_no" type="radio" name="is_po_number_traceable" id="is_po_number_traceable_no" value="2">
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                            <div>
                                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                            
                                                                <textarea type="text" name="is_po_number_traceable_remarks" id="is_po_number_traceable_remarks" rows="1" class="form-control col-6" ></textarea>
                                                            </div>
                                                            
                                                            <div><label for="">2. Is the lot identification matches with PMI record?</label></div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_lot_identification_match" id="is_lot_identification_match_yes" value="1">
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_lot_identification_match" id="is_lot_identification_match_no" value="2">
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                            <div>
                                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                            
                                                                <textarea type="text" name="is_lot_identification_match_remarks" id="is_lot_identification_match_remarks" rows="1" class="form-control col-6" ></textarea>
                                                            </div>

                                                            <div><label for="">3. Are there WIP & FGS affected?</label></div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="are_there_wip_fgs_affected" id="are_there_wip_fgs_affected_yes" value="1">
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="are_there_wip_fgs_affected" id="are_there_wip_fgs_affected_no" value="2">
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                            <div>
                                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                            
                                                                <textarea type="text" name="are_there_wip_fgs_affected_remarks" id="are_there_wip_fgs_affected_remarks" rows="1" class="form-control col-6" ></textarea>
                                                            </div>

                                                            <div><label for="">4. Is sorting / reworking necessary?</label></div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_sorting_reworking_necessary" id="is_sorting_reworking_necessary_yes" value="1">
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_sorting_reworking_necessary" id="is_sorting_reworking_necessary_no" value="2">
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>

                                                            <div>
                                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                            
                                                                <textarea type="text" name="is_sorting_reworking_necessary_remarks" id="is_sorting_reworking_necessary_remarks" rows="1" class="form-control col-6" ></textarea>
                                                            </div>

                                                            <div><label for="">5. Is sorting needed at the customer's site?</label></div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_sorting_needed" id="is_sorting_needed_yes" value="1">
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_sorting_needed" id="is_sorting_needed_no" value="2">
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                            <div>
                                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                            
                                                                <textarea type="text" name="is_sorting_needed_remarks" id="is_sorting_needed_remarks" rows="1" class="form-control col-6" ></textarea>
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div><label for="">6. Is the shipment schedule affected?</label></div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_shipment_affected" id="is_shipment_affected_yes" value="1">
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="is_shipment_affected" id="is_shipment_affected_no" value="2">
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                            <div>
                                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                              
                                                                <textarea type="text" name="is_shipment_affected_remarks" id="is_shipment_affected_remarks" rows="1" class="form-control col-6" ></textarea>
                                                            </div>
        
                                                            <div><label for="">7. Are data needed complete & available?</label></div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="are_data_needed_complete_available" id="are_data_needed_complete_available_yes" value="1">
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="are_data_needed_complete_available" id="are_data_needed_complete_available_no" value="2">
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                            <div>
                                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                              
                                                                <textarea type="text" name="are_data_needed_complete_available_remarks" id="are_data_needed_complete_available_remarks" rows="1" class="form-control col-6" ></textarea>
                                                            </div>
                                                            
                                                            <div><label for="">8. Does customer requests production record?</label></div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="does_customer_requests_production_record" id="does_customer_requests_production_record_yes" value="1">
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="does_customer_requests_production_record" id="does_customer_requests_production_record_no" value="2">
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                            <div>
                                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                              
                                                                <textarea type="text" name="does_customer_requests_production_record_remarks" id="does_customer_requests_production_record_remarks" rows="1" class="form-control col-6" ></textarea>
                                                            </div>
        
                                                            <div><label for="">9. Are there some clarifications needed to settle with the customer?</label></div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radioActions" arr-index="9" type="radio" name="are_there_clarifications_needed_to_settle" id="are_there_clarifications_needed_to_settle_yes" value="1">
                                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radioActions" arr-index="9" type="radio" name="are_there_clarifications_needed_to_settle" id="are_there_clarifications_needed_to_settle_no" value="2">
                                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                                            </div>
                                                            <div>
                                                                <label class="form-check-label">Remarks: &nbsp;</label>
                                                                <textarea type="text" name="are_there_clarifications_needed_to_settle_remarks" id="are_there_clarifications_needed_to_settle_remarks" rows="1" class="form-control col-6" ></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="step-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>Unit Verification</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div><label for="">1. Is the actual NG unit available for verification?</label></div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="is_actual_ng_unit_available" id="is_actual_ng_unit_available_yes" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="is_actual_ng_unit_available" id="is_actual_ng_unit_available_no" value="2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                    <div>
                                                        <label class="form-check-label">Remarks: &nbsp;</label>
                                                        <textarea type="text" name="is_actual_ng_unit_available_remarks" id="is_actual_ng_unit_available_remarks" rows="1" class="form-control col-4" ></textarea>
                                                    </div>
                                                    
                                                    <div><label for="">2. Is the unit bearing PMI identification mark?</label></div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="is_unit_bearing_pmi_identification_mark" id="is_unit_bearing_pmi_identification_mark_yes" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="is_unit_bearing_pmi_identification_mark" id="is_unit_bearing_pmi_identification_mark_no" value="2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                    <div>
                                                        <label class="form-check-label">Remarks: &nbsp;</label>
                                                        <textarea type="text" name="is_unit_bearing_pmi_identification_mark_remarks" id="is_unit_bearing_pmi_identification_mark_remarks" rows="1" class="form-control col-4" ></textarea>
                                                    </div>

                                                    <div><label for="">3. Is claim defect identified by the customer tallies with actual received NG unit?</label></div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="is_claim_defect_identified_by_customer" id="is_claim_defect_identified_by_customer_yes" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="is_claim_defect_identified_by_customer" id="is_claim_defect_identified_by_customer_no" value="2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                    <div>
                                                        <label class="form-check-label">Remarks: &nbsp;</label>
                                                        <textarea type="text" name="is_claim_defect_identified_by_customer_remarks" id="is_claim_defect_identified_by_customer_remarks" rows="1" class="form-control col-4" ></textarea>
                                                    </div>

                                                    <div><label for="">4. Does customer requires official corrective and preventive action report?</label></div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="does_customer_requires_official_capa_report" id="does_customer_requires_official_capa_report_yes" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="does_customer_requires_official_capa_report" id="does_customer_requires_official_capa_report_no" value="2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                    <div>
                                                        <label class="form-check-label">Remarks: &nbsp;</label>
                                                        <textarea type="text" name="does_customer_requires_official_capa_report_remarks" id="does_customer_requires_official_capa_report_remarks" rows="1" class="form-control col-4" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <div>
                            <button type="submit" id="btnAddCustomerClaim" class="btn btn-success"><i id="iBtnAddCustomerClaimIcon" class="fa fa-check"></i> Save</button>
                            <button type="button" id="btnAddCustomerClaimNext" class="btn btn-primary"><i id="iBtnAddCustomerClaimNextIcon" class="fa fa-check"></i> Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- Add Customer Claim Modal End -->


    <!-- View Customer Claim Modal Start -->
    <div class="modal fade" id="modalViewCustomerClaim" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl-custom">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="far fa-eye"></i>&nbsp;View Customer Claim Details</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div id="smartwizardView">
                            <ul class="nav">
                                <li step_status="0"><a href="#step-1"><i class="fas fa-info-circle"></i> Step 1<br /><small>Customer Claim Details</small></a></li>
                                <li step_status="0"><a href="#step-2"><i class="fas fa-info-circle"></i> Step 2<br /><small>Data Verification</small></a></li>
                                <li step_status="0"><a href="#step-3"><i class="fas fa-info-circle"></i> Step 3<br /><small>Unit Verification</small></a></li>
                                <li step_status="1"><a href="#step-4"><i class="fas fa-info-circle"></i> Step 4<br /><small>Claim Validation</small></a></li>
                            </ul>

                            <div class="tab-content mt-2">
                                <div id="step-1">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>Claim Details</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <input type="text" class="form-control form-control-sm customer-claim-input" placeholder="Customer Claim ID" name="customer_claim_id" style="display: none;">
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
                                                        <select class="form-control select2bs4 selectViewCustomer" disabled arr-index="3" name="customer" id="selectViewCustomer" aria-label="Default" aria-describedby="inputGroup-sizing-default">
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
                                                        <select class="form-control select2bs4 selectSenderName" disabled arr-index="4" name="sender_name" id="viewSelectSenderName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>Product Details</strong></h3>
                                                </div>
                                                <div class="card-body">
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
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">PO Number</span>
                                                        </div>
                                                        <input type="text" class="form-control" disabled arr-index="10" name="po_number" id="txtViewPONumber" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Lot Traceability</span>
                                                        </div>
                                                        <input type="text" class="form-control" arr-index="10" name="lot_traceability" disabled id="txtViewLotTraceability" aria-label="Default" aria-describedby="inputGroup-sizing-default">
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
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Shipment Quantity</span>
                                                        </div>
                                                        {{-- <input type="number" class="form-control" disabled arr-index="12" name="quantity" id="txtViewQuantity" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"> --}}
                                                        <input type="text" class="form-control" disabled arr-index="12" name="shipment_quantity" id="txtViewShipmentQuantity">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Number of NG</span>
                                                        </div>
                                                        <input type="number" class="form-control" disabled arr-index="13" name="number_of_ng" id="txtViewNumberOfNG" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                                    </div>
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>Date Details</strong></h3>
                                                </div>
                                                <div class="card-body">
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
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Shipment Date</span>
                                                        </div>
                                                        {{-- <input type="date" class="form-control datetimepicker" name="actual_response" type="text" onfocus="(this.type='date')" id="txtViewActualResponse" placeholder="Auto Generated" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                                        <input type="text" class="form-control datetimepicker" disabled arr-index="19" name="shipment_date" type="text" id="txtViewShipmentDate" autocomplete="off" placeholder="yyyy/mm/dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
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
                                                    
                                                    <div class="input-group finalReport">
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
                                                    {{-- <div class="finalReport" style="float:right;">
                                                    
                                                    </div> --}}
                                                    
                                                    {{-- <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Email Recipient (Attention)</span>
                                                        </div>
                                                        <select class="form-control select2bs4 select2Tags customer-claim-input" name="email_recipient_attention[]" multiple="true" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                            <!-- Auto Generated -->
                                                        </select>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Email Recipient (CC)</span>
                                                        </div>
                                                        <select class="form-control select2bs4 select2Tags customer-claim-input" name="email_recipient_cc[]" multiple="true" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                            <!-- Auto Generated -->
                                                        </select>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 statusView">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>Status</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="info-box" style="margin-top: 27px !important">
                                                        <span class="info-box-icon" id="statusViewBgColor"><i class="fa fa-file"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Status</span>
                                                            <span class="info-box-text" id="spanViewStatus"></span>
                                                        </div>
                                                        <span class="info-box-icon" id="initialViewReportBgColor"><i class="fa fa-file"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Initial Report</span>
                                                            <span class="info-box-text" id="spanViewInitialReport"></span>
                                                        </div>
                                                        <span class="info-box-icon" id="finalViewReportBgColor"><i class="fa fa-file"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Final Report</span>
                                                            <span class="info-box-text" id="spanViewFinalReport"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>YEC/YED Report Receive (E-mail)</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">YEC/YED Sender Name</span>
                                                        </div>
                                                        <input type="text" class="form-control" disabled name="yec_sender_name" readonly id="txtViewSenderName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">YEC/YED Report Received</span>
                                                        </div>
                                                        <input type="date" class="form-control" disabled name="report_receive" readonly id="txtViewReportReceived" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    {{-- <div class="input-group mb-3" id="fileNameId" style="display: none;">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">YEC/YED Report File</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="report_filename" id="txtReportFileNane" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div> --}}

                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">YEC/YED Report File</span>
                                                        </div>
                                                        <input type="text" name="report_filename" disabled id="txtViewReportFileName" class="form-control" readonly>
                                                    </div>
                                                    {{-- <div class="input-group mb-3" id="fileEmailAttachment">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">YEC/YED Report File</span>
                                                        </div>
                                                        <input type="file" class="form-control" name="email_attachment" id="txtViewReportFile" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3 ml-4 d-none" id="divCheckboxEmailAttachment">
                                                        <input type="checkbox" class="form-check-input" name="checkbox_email_attachment" id="checkboxViewEmailAttachment">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Re-upload
                                                        </label>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>8D Report</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">8D Filename</span>
                                                        </div>
                                                        <input type="text" class="form-control" disabled name="eight_d_report_name" id="txtViewEightDReportName" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    {{-- <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Date </span>
                                                        </div>
                                                        <input type="date" class="form-control" name="email_date" id="txtViewEmailDate" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div> --}}

                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">8D File</span>
                                                        </div>
                                                        <input type="text" name="eight_d_report_filename" disabled id="txtViewEightDReportFileName" class="form-control" readonly>
                                                    </div>

                                                    {{-- <div class="input-group mb-3" id="divEightDReportFile">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">8D File</span>
                                                        </div>
                                                        <input type="file" class="form-control" name="eight_d_report_file" id="txtViewEightDFileUpload" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                                    </div>
                                                    <div class="input-group mb-3 ml-4" id="divEightDReport">
                                                        <input class="form-check-input" type="checkbox" name="checkbox_eight_d_report" id="checkboxViewEightDReport">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Re-upload
                                                        </label>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="step-2">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>Data Verification</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
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
                                                                <textarea type="text" name="view_is_po_number_traceable_remarks" id="view_is_po_number_traceable_remarks" readonly rows="1" class="form-control col-6" ></textarea>
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
                                                                <textarea type="text" name="view_is_lot_identification_match_remarks" id="view_is_lot_identification_match_remarks" readonly rows="1" class="form-control col-6" ></textarea>
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
                                                                <textarea type="text" name="view_are_there_wip_fgs_affected_remarks" id="view_are_there_wip_fgs_affected_remarks" readonly rows="1" class="form-control col-6" ></textarea>
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
                                                            
                                                                <textarea type="text" name="view_is_sorting_reworking_necessary_remarks" id="view_is_sorting_reworking_necessary_remarks" readonly rows="1" class="form-control col-6" ></textarea>
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
                                                                <textarea type="text" name="view_is_sorting_needed_remarks" id="view_is_sorting_needed_remarks" readonly rows="1" class="form-control col-6" ></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
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
                                                                <textarea type="text" name="view_is_shipment_affected_remarks" id="view_is_shipment_affected_remarks" readonly rows="1" class="form-control col-6" ></textarea>
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
                                                                <textarea type="text" name="view_are_data_needed_complete_available_remarks" id="view_are_data_needed_complete_available_remarks" readonly rows="1" class="form-control col-6" ></textarea>
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
                                                                <textarea type="text" name="view_does_customer_requests_production_record_remarks" id="view_does_customer_requests_production_record_remarks" readonly rows="1" class="form-control col-6" ></textarea>
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
                                                                <textarea type="text" name="view_are_there_clarifications_needed_to_settle_remarks" id="view_are_there_clarifications_needed_to_settle_remarks" readonly rows="1" class="form-control col-6" ></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="step-3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>Unit Verification</strong></h3>
                                                </div>
                                                <div class="card-body">
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
                                                        <textarea type="text" name="view_is_actual_ng_unit_available_remarks" id="view_is_actual_ng_unit_available_remarks" readonly rows="1" class="form-control col-4" ></textarea>
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
                                                        <textarea type="text" name="view_is_unit_bearing_pmi_identification_mark_remarks" id="view_is_unit_bearing_pmi_identification_mark_remarks" readonly rows="1" class="form-control col-4" ></textarea>
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
                                                        <textarea type="text" name="view_is_claim_defect_identified_by_customer_remarks" id="view_is_claim_defect_identified_by_customer_remarks" readonly rows="1" class="form-control col-4" ></textarea>
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
                                                        <textarea type="text" name="view_does_customer_requires_official_capa_report_remarks" id="view_does_customer_requires_official_capa_report_remarks" readonly rows="1" class="form-control col-4" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="step-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="margin-top: 8px;"><strong>Claim Validation</strong></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div><label for="">1. Is the defect NG based on the defined specification?</label></div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="is_the_defect_ng_based_on_specs" id="is_the_defect_ng_based_on_specs_yes" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="is_the_defect_ng_based_on_specs" id="is_the_defect_ng_based_on_specs_no" value="2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                    <div>
                                                        <label class="form-check-label">Remarks: &nbsp;</label>
                                                        <textarea type="text" readonly name="is_the_defect_ng_based_on_specs_remarks" id="is_the_defect_ng_based_on_specs_remarks" rows="1" class="form-control col-6" ></textarea>
                                                    </div>
                                                    
                                                    <div><label for="">2. Is the defect included in PMI check items?</label></div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="is_defect_included_in_pmi" id="is_defect_included_in_pmi_yes" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="is_defect_included_in_pmi" id="is_defect_included_in_pmi_no" value="2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                    <div>
                                                        <label class="form-check-label">Remarks: &nbsp;</label>
                                                        <textarea type="text" readonly name="is_defect_included_in_pmi_remarks" id="is_defect_included_in_pmi_remarks" rows="1" class="form-control col-6" ></textarea>
                                                    </div>
        
                                                    <div><label for="">3. Is the defect detectable at PMI Function Test/Camera recognition checking?</label></div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="is_defect_detectable_at_pmi" id="is_defect_detectable_at_pmi_yes" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="is_defect_detectable_at_pmi" id="is_defect_detectable_at_pmi_no" value="2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                    <div>
                                                        <label class="form-check-label">Remarks: &nbsp;</label>
                                                        <textarea type="text" readonly name="is_defect_detectable_at_pmi_remarks" id="is_defect_detectable_at_pmi_remarks" rows="1" class="form-control col-6" ></textarea>
                                                    </div>
        
                                                    <div><label for="">4. Is the unit undergone Customer assembly process?</label></div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="is_unit_undergone_customer_assembly_process" id="is_unit_undergone_customer_assembly_process_yes" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="is_unit_undergone_customer_assembly_process" id="is_unit_undergone_customer_assembly_process_no" value="2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                    <div>
                                                        <label class="form-check-label">Remarks: &nbsp;</label>
                                                        <textarea type="text" readonly name="is_unit_undergone_customer_assembly_process_remarks" id="is_unit_undergone_customer_assembly_process_remarks" rows="1" class="form-control col-6" ></textarea>
                                                    </div>
        
                                                    <div><label for="">5. Is the defect contributed by PMI process?</label></div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="is_defect_contributed_by_pmi" id="is_defect_contributed_by_pmi_yes" value="1">
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" disabled type="radio" name="is_defect_contributed_by_pmi" id="is_defect_contributed_by_pmi_no" value="2">
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                    <div>
                                                        <label class="form-check-label">Remarks: &nbsp;</label>
                                                        <textarea type="text" readonly name="is_defect_contributed_by_pmi_remarks" id="is_defect_contributed_by_pmi_remarks" rows="1" class="form-control col-6" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <div>
                            {{-- <button type="submit" id="btnAddCustomerClaim" class="btn btn-success"><i id="iBtnAddCustomerClaimIcon" class="fa fa-check"></i> Save</button> --}}
                            <button type="button" id="btnViewCustomerClaimNext" class="btn btn-primary"><i id="iBtnViewCustomerClaimNextIcon" class="fa fa-check"></i> Next</button>
                        </div>
                    </div>
                
            </div>
        </div>
    </div><!-- View Modal End -->

    <!-- Filtering Modal Start -->
    <div class="modal fade" id="modalFilterCustomerClaim" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" style="min-width: 550px;">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title" id="h4ChangeProductClassificationTitle"><i class="fas fa-filter"></i>&nbsp;Filter</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFilterCustomerClaim" autocomplete = 'off'>
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
                                <option value="2">Material</option>
                                <option value="3">Method</option>
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

                        
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default"><input type="checkbox" id="checkboxValidity" name="checkbox_Validity">&nbsp;Validity</span>
                            </div>
                            <select class="form-control" disabled id="selectFilterValidity" name="filter_validity">
                                <option value="" disabled selected>Select One</option>
                                <option value="1">Valid</option>
                                <option value="2">Information</option>
                                <option value="3">Feedback</option>
                                <option value="4">Invalid</option>
                                <option value="5">N/A</option>
                            </select>
                        </div>

                       
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="btnFilterCustomerClaim" class="btn btn-primary"><i class="fa fa-check"></i> Execute</button>
                </div>
            </div>
        </div>
    </div><!-- Filtering Modal End -->


    <!-- Submitted 8D Report Modal Start -->
    <div class="modal fade" id="modalValidateEightDReport" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" style="min-width: 550px;">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;8D Report Validation</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formValidateEightDReport" autocomplete = "off">
                        @csrf
                        <input type="text" name="customer_claim_id" id="customerClaimId" placeholder="Customer Claim Id" class="form-control d-none">
                        <input type="text" name="status" id="status" placeholder="Claim Stats" class="form-control d-none">
                        <div class="row mb-3">
                            <div class="col-12 text-right">
                                <button type="button" id="btnViewRevisionHistory" class="btn btn-info btn-sm" style=""><i class="fa fa-clipboard-check"></i> View Revision History <span class="badge badge-light" id="totalRevision" title="Total revision/s">0</span></button>
                            </div>
                        </div>

                        <div class="input-group mb-3" id="divTxtEightDReportFilename">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default">8D Report Filename</span>
                            </div>
                            <input type="text" name="operation_eight_d_report_filename" readonly id="txtEightDReportFileName" class="form-control">
                        </div>

                        <div class="input-group mb-3" id="divTxtEightDReportFile">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default">8D Report File</span>
                            </div>
                            <a class="form-control h-100" id="txtEightDReportFile" title="Download 8D Report from Operation" href=""><i class="far fa-lg fa-file">&nbsp;</i><span id="spanEightDReportFile"></span></a>
                        </div>
                        
                        <div class="input-group mb-3" id="divTxtEightDReportDate">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default">Submitted Date</span>
                            </div>
                            <input type="date" name="operation_eight_d_report_date" readonly id="txtEightDReportDate" class="form-control">
                        </div>

                        <div class="input-group mb-3" id="divTxtEightDReportSender">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default">Submitted By</span>
                            </div>
                            <input type="text" name="operation_eight_d_report_sender" readonly id="txtEightDReportSender" class="form-control">
                        </div>
                        
                        <div class="input-group mb-3 d-none" id="divTxtEightDReportRemarks">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="inputGroup-sizing-default">Remarks</span>
                            </div>
                            <input type="hidden" name="remarks" readonly id="txtEightDReportRemarks" class="form-control">
                        </div>
                    
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <div>
                        <button type="button" id="btnDisapprovedEightDReport" class="btn btn-secondary"><i class="fa fa-times"></i>&nbsp;Disapproved</button>
                        <button type="button" id="btnApprovedEightDReport" class="btn btn-success"><i class="fa fa-check" id="iBtnApprovedEightDReport"></i>&nbsp;Approved</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div><!-- Submitted 8D Report Modal End -->

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
                        <table id="tblEightDReportHistoryCN" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Revision Count</th>
                                    <th>8D Report Name</th>
                                    <th>8D Report Submitted Date</th>
                                    <th style="min-width: 20% !important; width: 10%">Remarks</th>
                                    {{-- <th>Submitted By</th> --}}
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

    <!-- Add 8D Report Remarks Modal Start -->
    <div class="modal fade" id="modalAddEightDReportRemarks" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" style="min-width: 550px;">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Add Remarks</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAddEightDReportRemarks" autocomplete="off">
                        @csrf
                        <div class="table-responsive">
                            <div>
                                <label class="form-check-label">Remarks: &nbsp;</label>
                                <textarea type="text" name="remarks" id="remarks" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="btnSubmitRemarks" data-dismiss="modal"><i class="fa fa-check"></i>&nbsp;Submit</button>
                </div>
            </div>
        </div>
    </div><!-- Add 8D Report Remarks Modal End -->
@endsection

<!--     {{-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        $(document).ready(function () {

            // auto resize the textareas
            document.querySelectorAll("textarea").forEach(function (size) {
                size.addEventListener("input", function () {
                    var resize = window.getComputedStyle(this);
                    // reset height to allow textarea to shrink again
                    this.style.height = "auto";
                    // when "box-sizing: border-box" we need to add vertical border size to scrollHeight
                    this.style.height = (this.scrollHeight + parseInt(resize.getPropertyValue("border-top-width")) + parseInt(resize.getPropertyValue("border-bottom-width"))) + "px";
                });
            });
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
            $(document).on('click','#tblUsers tbody tr',function(e){
                $(this).closest('tbody').find('tr').removeClass('table-active');
                $(this).closest('tr').addClass('table-active');
            });

            // Disabled type on datepicker
            $(".datetimepicker").keydown(function(event) { 
                return false;
            });
            
            // Disabled holidays
            // var currentYear = new Date().getFullYear(); // sample output: 2021
            // var disabledDays = ["1-1-"+currentYear, "12-2-"+currentYear, "1-4-"+currentYear, "2-4-"+currentYear, "9-4-"+currentYear, "1-5-"+currentYear, "13-5-"+currentYear, "12-6-"+currentYear, "2-6-"+currentYear, "30-8-"+currentYear, "1-11-"+currentYear, "30-11-"+currentYear, "8-12-"+currentYear, "25-12-"+currentYear, "3-12-"+currentYear, "30-12-"+currentYear];
            // $('.datetimepicker').datepicker({
            //     format: 'yyyy/mm/dd',
            //     // format: 'yyyy-mm-dd',
            //     forceParse: false, // prevent from clearing existing values from input when no date selected
            //     autoclose: true, // autoclose date after selecting date
            //     clearBtn: true, // include clear button
            //     daysOfWeekDisabled: [0, 6], // disabled weekends
            //     todayHighlight: true,
            //     // daysOfWeekHighlighted: [1,2,3,4,5],
            //     // datesDisabled: disabledDays,
            //     beforeShowDay: function(date){
            //         dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
            //         if(disabledDays.indexOf(dmy) != -1){
            //             return false;
            //         }
            //         else{
            //             return true;
            //         }
            //     }
            // });


            /*
                Disable holiday
                Added by -CDP
            */
            $.ajax({
                url: "get_holiday_for_date_picker",
                method: "get",
                dataType: "json",
                success: function(response){
                    
                    var currentYear = new Date().getFullYear();
                    var disabledDays = [];

                    for(x = 0; x < response['holiday'].length; x++){
                        var date = "";
                        // date =  response['holiday'][x]['day']+"-"+response['holiday'][x]['month']+"-"+currentYear;
                        date = `${response['holiday'][x]['day']}-${response['holiday'][x]['month']}-${currentYear}`;
                        disabledDays.push(date);
                    }

                    $('.datetimepicker').datepicker({
                        format: 'yyyy/mm/dd',
                        // format: 'yyyy-mm-dd',
                        forceParse: false, // prevent from clearing existing values from input when no date selected
                        autoclose: true, // autoclose date after selecting date
                        clearBtn: true, // include clear button
                        daysOfWeekDisabled: [0, 6], // disabled weekends
                        todayHighlight: true,
                        // daysOfWeekHighlighted: [1,2,3,4,5],
                        // datesDisabled: disabledDays,
                        beforeShowDay: function(date){
                            dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                            if(disabledDays.indexOf(dmy) != -1){
                                return false;
                            }
                            else{
                                return true;
                            }
                        }
                    });
                    console.log(disabledDays);

                },
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

            $('#smartwizardView').smartWizard({
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
                anchorSettings: {
                    anchorClickable: true, // Enable/Disable anchor navigation
                    enableAllAnchors: true, // Activates all anchors clickable all times
                }
            });


            

            // Add validation before accessing Next button
            $("#btnAddCustomerClaimNext").click(function(){
                if(
                    $('#selectQuarter').val() === null ||
                    $('#selectCustomer').val() === null ||
                    $('#selectContributor').val() === null ||
                    $('#selectValidity').val() === null ||
                    $('#selectProductClassification').val() === null ||
                    $('#txtAddModelName').val() === '' ||
                    $('#txtAddModeOfDefect').val() === '' ||
                    $('#selectAutomotive').val() === null ||
                    $('#selectDefectCategoryClass').val() === null ||
                    $('#txtDateReceived').val() === '' ||
                    $('#txtAddRequiredReply').val() === ''
                ){
                    console.log('Some fields has no value');
                    toastr.error('Fill all required fields');
                }else{
                    console.log('All fields has values');
                    $('#smartwizard').smartWizard("next");
                }
            });

            $("#btnViewCustomerClaimNext").click(function(){
              
                $('#smartwizardView').smartWizard("next");
                
            });
            
            // Reset smartWizard steps
            // $("#btnShowAddCustomerClaimModal").click(function(){
            //     $('#smartwizard').smartWizard("reset");
                
            // });

            //To Disable the next Button on smart wizzard
            $('#smartwizard li').on('click', function(){
                if($('.nav-item.active').attr('step_status') == 1){
                    $('#btnAddCustomerClaimNext').prop('disabled', true);
                }
                else{
                    $('#btnAddCustomerClaimNext').prop('disabled', false);
                }
            });
            $('#btnAddCustomerClaimNext').on('click', function(){
                if($('.nav-item.active').attr('step_status') == 1){
                    $('#btnAddCustomerClaimNext').prop('disabled', true);

                }else{
                    $('#btnAddCustomerClaimNext').prop('disabled', false);

                }
            });



            // Testing
            // $('.radioActions').on('click', function(){
            //     let value = $(this).val();
			// 	let arrIndex = $(this).attr('arr-index')
                
            //     console.log('radioActions');
            //     console.log($(this).attr('arr-index'));
            // });


            // kalokohang button
            
                // const arrPixels = [
                //     '23px',
                //     '234px',
                //     '23px',
                //     '75px',
                //     '500px',
                // ];

                // function randomPixel (){
                //     const randomPixels = Math.floor(Math.random() * arrPixels.length);
                //     console.log(arrPixels[randomPixels]);
                // }


                // $("#btnAddCustomerClaim").hover(function(){
                //     // $(this).css({
                //     //         'position', 'fixed',
                //     //         'left', randomPixel()
                //     // });
                //     $(this).css({"position": "fixed","left": Math.random() * window.outerWidth , "top": Math.random() * window.outerHeight});
                // });
                // // $('#myselect').on('mouseover', function () {
                // $('div').find('input').on('mouseover', function () {
                // // ("#modalAddCustomerClaim").hover(function(){
                //     // $(this).css({
                //     //         'position', 'fixed',
                //     //         'left', randomPixel()
                //     // });
                //     $(this).css({"position": "fixed","left": Math.random() * window.outerWidth , "top": Math.random() * window.outerHeight});
                // });

                // $('div').find('select').on('mouseover', function () {
                // // ("#modalAddCustomerClaim").hover(function(){
                //     // $(this).css({
                //     //         'position', 'fixed',
                //     //         'left', randomPixel()
                //     // });
                //     $(this).css({"position": "fixed","left": Math.random() * window.outerWidth , "top": Math.random() * window.outerHeight});
                // });

                // $('button').on('mouseover', function () {
                // // ("#modalAddCustomerClaim").hover(function(){
                //     // $(this).css({
                //     //         'position', 'fixed',
                //     //         'left', randomPixel()
                //     // });
                //     $(this).css({"position": "fixed","left": Math.random() * window.outerWidth , "top": Math.random() * window.outerHeight});
                // });
                // $('table').find('button').on('mouseover', function () {
                // // ("#modalAddCustomerClaim").hover(function(){
                //     // $(this).css({
                //     //         'position', 'fixed',
                //     //         'left', randomPixel()
                //     // });
                //     $(this).css({"position": "fixed","left": Math.random() * window.outerWidth , "top": Math.random() * window.outerHeight});
                // });
                // $('div').find('span').on('mouseover', function () {
                // // ("#modalAddCustomerClaim").hover(function(){
                //     // $(this).css({
                //     //         'position', 'fixed',
                //     //         'left', randomPixel()
                //     // });
                //     $(this).css({"position": "fixed","left": Math.random() * window.outerWidth , "top": Math.random() * window.outerHeight});
                // });

                // $('div').find('a').on('mouseover', function () {
                // // ("#modalAddCustomerClaim").hover(function(){
                //     // $(this).css({
                //     //         'position', 'fixed',
                //     //         'left', randomPixel()
                //     // });
                //     $(this).css({"position": "fixed","left": Math.random() * window.outerWidth , "top": Math.random() * window.outerHeight});
                // });
                
                // $("div").find('input[type="date"]').on('mouseover', function () {
                // // ("#modalAddCustomerClaim").hover(function(){
                //     // $(this).css({
                //     //         'position', 'fixed',
                //     //         'left', randomPixel()
                //     // });
                //     $(this).css({"position": "fixed","left": Math.random() * window.outerWidth , "top": Math.random() * window.outerHeight});
                // });
            


            //============================= Get Email Recipient for Sender Name =============================
            GetEmailRecipient($('#selectSenderName'));


            //============================= Get Product Classification =============================
            GetProductClassification($('#selectProductClassification'));
            GetProductClassification($('#viewSelectProductClassification'));


            //============================= Get Customer Classification =============================
            GetCustomerClassification($('#selectCustomer'));
            GetCustomerClassification($('#selectViewCustomer'));


            //============================= Customer Claim Datatables =============================
            dataTablesCustomerClaimCN = $("#tblCustomerClaimCN").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ claim records",
                    "lengthMenu": "Show _MENU_ claim records",
                },
                "ajax" : {
                    url: "view_customer_claim_cn",
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
                        param.filterValidity                = $('#selectFilterValidity').val();
                        param.dateRangeFrom                 = $('#dateRangeFrom', $('#formDateRangeCN')).val();
                        param.dateRangeTo                   = $('#dateRangeTo', $('#formDateRangeCN')).val();
                    },
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "item_number"},
                    { "data" : "status"},
                    { "data" : "eight_d_report"},
                    { "data" : "quarter"},
                    { "data" : "section"},
                    { "data" : "customer_details.customer_name"},
                    { "data" : "date_received"},
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
                    { "data" : "validity"},
                    { "data" : "operation_eight_d_report_filename",
                        defaultContent: 'N/A',
                    },
                ],
                "columnDefs": [
                    { className: 'align-middle', targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13] },
                ],
                "createdRow": function(row, data, index) {
                    $('td', row).eq(3).css('white-space', 'normal')
                },
            });

            $("#formDateRangeCN").submit(function(event) {
                event.preventDefault();
                dataTablesCustomerClaimCN.ajax.reload(null, false);
            });

            dataTablesCustomerClaimTS = $("#tblCustomerClaimTS").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ claim records",
                    "lengthMenu": "Show _MENU_ claim records",
                },
                "ajax" : {
                    url: "view_customer_claim_ts",
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
                        param.filterValidity                = $('#selectFilterValidity').val();
                        param.dateRangeFrom                 = $('#dateRangeFrom', $('#formDateRangeTS')).val();
                        param.dateRangeTo                   = $('#dateRangeTo', $('#formDateRangeTS')).val();
                    },
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "item_number"},
                    { "data" : "status"},
                    { "data" : "eight_d_report"},
                    { "data" : "quarter"},
                    { "data" : "section"},
                    { "data" : "customer_details.customer_name"},
                    { "data" : "date_received"},
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
                    { "data" : "validity"},
                    { "data" : "operation_eight_d_report_filename",
                        defaultContent: 'N/A',
                    },
                ],
                "columnDefs": [
                    { className: 'align-middle', targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13] },
                ],
                "createdRow": function(row, data, index) {
                    $('td', row).eq(3).css('white-space', 'normal')
                },
            });

            $("#formDateRangeTS").submit(function(event) {
                event.preventDefault();
                dataTablesCustomerClaimTS.ajax.reload(null, false);
            });
            

            dataTablesCustomerClaimYF = $("#tblCustomerClaimYF").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ claim records",
                    "lengthMenu": "Show _MENU_ claim records",
                },
                "ajax" : {
                    url: "view_customer_claim_yf",
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
                        param.filterValidity                = $('#selectFilterValidity').val();
                        param.dateRangeFrom                 = $('#dateRangeFrom', $('#formDateRangeYF')).val();
                        param.dateRangeTo                   = $('#dateRangeTo', $('#formDateRangeYF')).val();
                    },
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "item_number"},
                    { "data" : "status"},
                    { "data" : "eight_d_report"},
                    { "data" : "quarter"},
                    { "data" : "section"},
                    { "data" : "customer_details.customer_name"},
                    { "data" : "date_received"},
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
                    { "data" : "validity"},
                    { "data" : "operation_eight_d_report_filename",
                        defaultContent: 'N/A',
                    },
                ],
                "columnDefs": [
                    { className: 'align-middle', targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13] },
                ],
                "createdRow": function(row, data, index) {
                    $('td', row).eq(3).css('white-space', 'normal')
                },
            });

            $("#formDateRangeYF").submit(function(event) {
                event.preventDefault();
                dataTablesCustomerClaimYF.ajax.reload(null, false);
            });


            dataTablesCustomerClaimPPS = $("#tblCustomerClaimPPS").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ claim records",
                    "lengthMenu": "Show _MENU_ claim records",
                },
                "ajax" : {
                    url: "view_customer_claim_pps",
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
                        param.filterValidity                = $('#selectFilterValidity').val();
                        param.dateRangeFrom                 = $('#dateRangeFrom', $('#formDateRangePPS')).val();
                        param.dateRangeTo                   = $('#dateRangeTo', $('#formDateRangePPS')).val();
                    },
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "item_number"},
                    { "data" : "status"},
                    { "data" : "eight_d_report"},
                    { "data" : "quarter"},
                    { "data" : "section"},
                    { "data" : "customer_details.customer_name"},
                    { "data" : "date_received"},
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
                    { "data" : "validity"},
                    { "data" : "operation_eight_d_report_filename",
                        defaultContent: 'N/A',
                    },
                ],
                "columnDefs": [
                    { className: 'align-middle', targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13] },
                ],
                "createdRow": function(row, data, index) {
                    $('td', row).eq(3).css('white-space', 'normal')
                },
            });

            $("#formDateRangePPS").submit(function(event) {
                event.preventDefault();
                dataTablesCustomerClaimPPS.ajax.reload(null, false);
            });


            //============================= Get Section(CN/TS/YF/PPS) based on the tab ============================= 
            // Onclick tab, this will be passed in the section input inside formAddCustomerClaim(Form) and formViewCustomerClaim(Form)
            $('.tabSection').on('click', function(){
                let section = $(this).attr('value');
                console.log('tabSection ',section);
                // formAddCustomerClaim(Form) for Edit Modal
                // For displaying the section only
                $('input[name="section_display"]','#formAddCustomerClaim').attr('value', '');
                $('input[name="section_display"]','#formAddCustomerClaim').val(section);
                $('input[name="section_display"]','#formAddCustomerClaim').attr('value', section).trigger('change');
                // formViewCustomerClaim(Form) for Viewing Modal
                // For displaying the section only
                $('input[name="section_display"]','#formViewCustomerClaim').attr('value', '');
                $('input[name="section_display"]','#formViewCustomerClaim').val(section);
                $('input[name="section_display"]','#formViewCustomerClaim').attr('value', section).trigger('change');

                // formAddCustomerClaim(Form) for Edit Modal
                // This will be used for $request->section in the controller, since the section is required
                $('input[name="section"]','#formAddCustomerClaim').attr('value', '');
                $('input[name="section"]','#formAddCustomerClaim').val(section);
                $('input[name="section"]','#formAddCustomerClaim').attr('value', section).trigger('change');

                // formViewCustomerClaim(Form) for Viewing Modal
                // This will be used for $request->section in the controller, since the section is required
                $('input[name="section"]','#formViewCustomerClaim').attr('value', '');
                $('input[name="section"]','#formViewCustomerClaim').val(section);
                $('input[name="section"]','#formViewCustomerClaim').attr('value', section).trigger('change');

                // $('#divCheckboxEmailAttachment').addClass('d-none');
                // $('#txtEmailAttachment').addClass('d-none'); 
                // $('#fileEmailAttachment').removeClass('d-none');
                
                // $('#divEightDReportFilename').addClass('d-none');
                // $('#divEightDReport').addClass('d-none');
                // $('#divEightDReportFile').removeClass('d-none');

                // $('#txtAddSenderName').prop('readonly', false);
                // $('#txtAddReportReceived').prop('readonly', false);
                // $('#txtAddEightDReportName').prop('readonly', false);
                // $('#txtAddEightDFileUpload').prop('readonly', false);


                /*
                    Auto Generated control number TS/YF/PPS - CDP
                */
                getClaimControlNumber(section);
            });

            // Onclick tab, this will get the current value of the tab(default is CN tab)
            $('.btnShowAddCustomerClaimModal').on('click', function(){
                console.log('btnShowAddCustomerClaimModal ', $(this).val());
                resetFormValues();
                
                // After clicked the btnShowAddCustomerClaimModal(button) this will get the current value of the tab(default is CN tab) and passed to formAddCustomerClaim(Form)
                let section = $('.tabSection').attr('value');

                // For displaying the section only
                $('input[name="section_display"]','#formAddCustomerClaim').attr('value', '');
                // $('input[name="section_display"]','#formAddCustomerClaim').val(section);
                $('input[name="section_display"]','#formAddCustomerClaim').val($(this).val());
                // $('input[name="section_display"]','#formAddCustomerClaim').attr('value', section).trigger('change');
                $('input[name="section_display"]','#formAddCustomerClaim').attr('value', $(this).val()).trigger('change');

                // This will be used for $request->section in the controller, since the section is required
                $('input[name="section"]','#formAddCustomerClaim').attr('value', '');
                // $('input[name="section"]','#formAddCustomerClaim').val(section);
                $('input[name="section"]','#formAddCustomerClaim').val($(this).val());
                // $('input[name="section"]','#formAddCustomerClaim').attr('value', section).trigger('change');
                $('input[name="section"]','#formAddCustomerClaim').attr('value', $(this).val()).trigger('change');

                // Hide btn-toolbar(Prev/Next) of SmartWizard
                $('.btn-toolbar').attr("style", "display: none !important");
                $('.finalReport').hide();

                // Reset the smartWizard step
                $('#smartwizard').smartWizard("reset");

                $('#divCheckboxEmailAttachment').addClass('d-none');
                $('#txtEmailAttachment').addClass('d-none'); 
                $('#fileEmailAttachment').removeClass('d-none');
                
                $('#divEightDReportFilename').addClass('d-none');
                $('#divEightDReport').addClass('d-none');
                $('#divEightDReportFile').removeClass('d-none');

                $('#txtAddSenderName').prop('readonly', false);
                $('#txtAddReportReceived').prop('readonly', false);
                $('#txtAddEightDReportName').prop('readonly', false);
                $('#txtAddEightDFileUpload').prop('readonly', false);

                $('.status').addClass('d-none');
                /*
                    Auto Generated control number CN - CDP
                */
                getClaimControlNumber($(this).val());
            });

            /*
                Commented because of redundancy
            */
            // $("#btnShowAddCustomerClaimModal").click(function(){
            //     const value = $(this).attr('value');
            //     console.log('value ',value);
            //     // Hide btn-toolbar(Prev/Next) of SmartWizard
            //     $('.btn-toolbar').attr("style", "display: none !important");
            //     $('.finalReport').hide();
                
            //     $('#smartwizard').smartWizard("reset");

            //     $('#divCheckboxEmailAttachment').addClass('d-none');
            //     $('#txtEmailAttachment').addClass('d-none'); 
            //     $('#fileEmailAttachment').removeClass('d-none');
                
            //     $('#divEightDReportFilename').addClass('d-none');
            //     $('#divEightDReport').addClass('d-none');
            //     $('#divEightDReportFile').removeClass('d-none');

            //     $('#txtAddSenderName').prop('readonly', false);
            //     $('#txtAddReportReceived').prop('readonly', false);
            //     $('#txtAddEightDReportName').prop('readonly', false);
            //     $('#txtAddEightDFileUpload').prop('readonly', false);

            //     $('.status').addClass('d-none');
            // });
            

            //============================= Edit/Get Customer Claim Details to edit =============================
            $("#tblCustomerClaimCN").on('click', '.actionEditCustomerClaim', function(){
                let id = $(this).attr('customer-claim-id');
                console.log('id ' +id + ' on formAddCustomerClaim');
                $("input[name='customer_claim_id'", $("#formAddCustomerClaim")).val(id);
                // dataTablesCustomerClaimCN.draw();
                GetCustomerClaimById(id);

                $('#divCheckboxEmailAttachment').removeClass('d-none');
                $('#txtEmailAttachment').removeClass('d-none');
                $('#fileEmailAttachment').addClass('d-none');

                $('#divEightDReportFilename').removeClass('d-none');
                $('#divEightDReport').removeClass('d-none');
                $('#divEightDReportFile').addClass('d-none');

                // Added by -JD for removing/adding of readonly
                $('#txtAddSenderName').prop('readonly', true);
                $('#txtAddReportReceived').prop('readonly', true);
                $('#txtAddEightDReportName').prop('readonly', true);
                $('#txtAddEightDFileUpload').prop('readonly', true);
                
                // Onclick tab on edit button action, after clicked the edit button this will get the current value of the tab(default is CN tab) and passed to formAddCustomerClaim(Form)
                let section = $('.tabSection').attr('value');

                // For displaying the section only
                $('input[name="section_display"]','#formAddCustomerClaim').attr('value', '');
                $('input[name="section_display"]','#formAddCustomerClaim').val(section);
                $('input[name="section_display"]','#formAddCustomerClaim').attr('value', section).trigger('change');

                // This will be used for $request->section in the controller, since the section is required
                $('input[name="section"]','#formAddCustomerClaim').attr('value', '');
                $('input[name="section"]','#formAddCustomerClaim').val(section);
                $('input[name="section"]','#formAddCustomerClaim').attr('value', section).trigger('change');

                // Reset the SmartWizard to first step
                $('#smartwizard').smartWizard("reset");

                // $("#modalAddCustomerClaim").modal('show'); ?

                // Radio buttons show on edit
                $('.finalReport').show(); 

                // Show Status(Card) on edit
                $('.status').removeClass('d-none');
            });

            $("#tblCustomerClaimTS").on('click', '.actionEditCustomerClaim', function(){
                let id = $(this).attr('customer-claim-id');
                console.log('id ' +id + ' on formAddCustomerClaim');
                $("input[name='customer_claim_id'", $("#formAddCustomerClaim")).val(id);
                // dataTablesCustomerClaimTS.draw();
                GetCustomerClaimById(id);
                $("#modalAddCustomerClaim").modal('show');
                
                $('#divCheckboxEmailAttachment').removeClass('d-none');
                $('#txtEmailAttachment').removeClass('d-none');
                $('#fileEmailAttachment').addClass('d-none');

                $('#divEightDReportFilename').removeClass('d-none');
                $('#divEightDReport').removeClass('d-none');
                $('#divEightDReportFile').addClass('d-none');

                // Added by -JD for removing/adding of readonly
                $('#txtAddSenderName').prop('readonly', true);
                $('#txtAddReportReceived').prop('readonly', true);
                $('#txtAddEightDReportName').prop('readonly', true);
                $('#txtAddEightDFileUpload').prop('readonly', true);
                $('#smartwizard').smartWizard("reset");
            });

            $("#tblCustomerClaimYF").on('click', '.actionEditCustomerClaim', function(){
                let id = $(this).attr('customer-claim-id');
                console.log('id ' +id + ' on formAddCustomerClaim');
                $("input[name='customer_claim_id'", $("#formAddCustomerClaim")).val(id);
                // dataTablesCustomerClaimYF.draw();
                GetCustomerClaimById(id);
                $("#modalAddCustomerClaim").modal('show');

                $('#divCheckboxEmailAttachment').removeClass('d-none');
                $('#txtEmailAttachment').removeClass('d-none');
                $('#fileEmailAttachment').addClass('d-none');

                $('#divEightDReportFilename').removeClass('d-none');
                $('#divEightDReport').removeClass('d-none');
                $('#divEightDReportFile').addClass('d-none');

                // Added by -JD for removing/adding of readonly
                $('#txtAddSenderName').prop('readonly', true);
                $('#txtAddReportReceived').prop('readonly', true);
                $('#txtAddEightDReportName').prop('readonly', true);
                $('#txtAddEightDFileUpload').prop('readonly', true);
                $('#smartwizard').smartWizard("reset");
            });

            $("#tblCustomerClaimPPS").on('click', '.actionEditCustomerClaim', function(){
                let id = $(this).attr('customer-claim-id');
                console.log('id ' +id + ' on formAddCustomerClaim');
                $("input[name='customer_claim_id'", $("#formAddCustomerClaim")).val(id);
                // dataTablesCustomerClaimPPS.draw();
                GetCustomerClaimById(id);
                $("#modalAddCustomerClaim").modal('show');

                $('#divCheckboxEmailAttachment').removeClass('d-none');
                $('#txtEmailAttachment').removeClass('d-none');
                $('#fileEmailAttachment').addClass('d-none');

                $('#divEightDReportFilename').removeClass('d-none');
                $('#divEightDReport').removeClass('d-none');
                $('#divEightDReportFile').addClass('d-none');

                // Added by -JD for removing/adding of readonly
                $('#txtAddSenderName').prop('readonly', true);
                $('#txtAddReportReceived').prop('readonly', true);
                $('#txtAddEightDReportName').prop('readonly', true);
                $('#txtAddEightDFileUpload').prop('readonly', true);
                $('#smartwizard').smartWizard("reset");
            });


            //============================= View/Get Customer Claim Details =============================
            $("#tblCustomerClaimCN").on('click', '.actionViewCustomerClaim', function(){
                let id = $(this).attr('view-customer-claim-id');
                console.log('id ' +id + ' on formViewCustomerClaim');
                $("input[name='view_customer_claim_id'", $("#formViewCustomerClaim")).val(id);
                // dataTablesCustomerClaimCN.draw();
                GetCustomerClaimByIdForViewing(id);
                
                $('#smartwizardView').smartWizard("reset");
            });

            //============================= View/Get Submitted 8D Report Details =============================
            $("#tblCustomerClaimCN").on('click', '.actionValidateEightDReport', function(){
                let id = $(this).attr('customer-claim-id');
                console.log('id ' +id + ' on formValidateEightDReport');
                $("input[name='customer_claim_id'", $("#formValidateEightDReport")).val(id);
                GetSubmittedEightDReportById(id); // EightDReport.js
            });

            $("#formValidateEightDReport").on('submit',function(e){
                e.preventDefault();
                const customerClaimId = $("input[name='customer_claim_id'", $("#formValidateEightDReport")).val();
                DisapprovedSubmittedEightDReport(customerClaimId); // EightDReport.js
            });

            // Approve 8D Report & Add Remarks
            $('#btnApprovedEightDReport').on('click', function(){
                console.log('btnApprovedEightDReport');
                const customerClaimId = $("input[name='customer_claim_id'", $("#formValidateEightDReport")).val();
                console.log('customerClaimId', customerClaimId);
                ApprovedSubmittedEightDReport(customerClaimId);
            });

            // Disapprove 8D Report & Add Remarks
            $('#btnDisapprovedEightDReport').on('click', function(){
                $('#modalAddEightDReportRemarks').modal('show');
            });
            
            $('#btnSubmitRemarks').click(function(){
                if($('textarea#remarks', $('#formAddEightDReportRemarks')).val() == ''){
                    toastr.error('Please add remarks!');
                }else{
                    $('#txtEightDReportRemarks'  , $('#formValidateEightDReport')).val($('#remarks', $('#formAddEightDReportRemarks')).val());
                    $('#formValidateEightDReport').trigger('submit');
                }
            });

            dataTablesEightDReportHistoryCN = $("#tblEightDReportHistoryCN").DataTable({
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
                        param.customerClaimId = $('#customerClaimId', $('#formValidateEightDReport')).val();
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
                dataTablesEightDReportHistoryCN.draw();
                // dataTablesEightDReportHistoryTS.draw();
                // dataTablesEightDReportHistoryYF.draw();
                // dataTablesEightDReportHistoryPPS.draw();
            });


            $("#tblCustomerClaimTS").on('click', '.actionViewCustomerClaim', function(){
                let id = $(this).attr('view-customer-claim-id');
                console.log('id ' +id + ' on formViewCustomerClaim');
                $("input[name='view_customer_claim_id'", $("#formViewCustomerClaim")).val(id);
                // dataTablesCustomerClaimCN.draw();
                GetCustomerClaimByIdForViewing(id);
                $('#smartwizardView').smartWizard("reset");
            });

            //============================= View/Get Submitted 8D Report Details =============================
            $("#tblCustomerClaimTS").on('click', '.actionValidateEightDReport', function(){
                let id = $(this).attr('customer-claim-id');
                console.log('id ' +id + ' on formValidateEightDReport');
                $("input[name='customer_claim_id'", $("#formValidateEightDReport")).val(id);
                GetSubmittedEightDReportById(id); // EightDReport.js
            });
            
            // dataTablesEightDReportHistoryTS = $("#tblEightDReportHistoryTS").DataTable({
            //     "processing" : false,
            //     "serverSide" : true,
            //     "responsive": true,
            //     // "order": [[ 0, "desc" ],[ 4, "desc" ]],
            //     "language": {
            //         "info": "Showing _START_ to _END_ of _TOTAL_ report records",
            //         "lengthMenu": "Show _MENU_ report records",
            //     },
            //     "ajax" : {
            //         url: "view_eight_d_report_history",
            //         data: function (param){
            //             param.customerClaimId = $('#customerClaimId', $('#formValidateEightDReport')).val();
            //         },
            //     },
            //     "columns":[
            //         { "data" : "revision_counter"},
            //         { "data" : "remarks"},
            //         { "data" : "submitted_by"},
            //     ],
            // });


            $("#tblCustomerClaimYF").on('click', '.actionViewCustomerClaim', function(){
                let id = $(this).attr('view-customer-claim-id');
                console.log('id ' +id + ' on formViewCustomerClaim');
                $("input[name='view_customer_claim_id'", $("#formViewCustomerClaim")).val(id);
                // dataTablesCustomerClaimCN.draw();
                GetCustomerClaimByIdForViewing(id);
                $('#smartwizardView').smartWizard("reset");
            });

            //============================= View/Get Submitted 8D Report Details =============================
            $("#tblCustomerClaimYF").on('click', '.actionValidateEightDReport', function(){
                let id = $(this).attr('customer-claim-id');
                console.log('id ' +id + ' on formValidateEightDReport');
                $("input[name='customer_claim_id'", $("#formValidateEightDReport")).val(id);
                GetSubmittedEightDReportById(id); // EightDReport.js
            });

            // dataTablesEightDReportHistoryYF = $("#tblEightDReportHistoryYF").DataTable({
            //     "processing" : false,
            //     "serverSide" : true,
            //     "responsive": true,
            //     // "order": [[ 0, "desc" ],[ 4, "desc" ]],
            //     "language": {
            //         "info": "Showing _START_ to _END_ of _TOTAL_ report records",
            //         "lengthMenu": "Show _MENU_ report records",
            //     },
            //     "ajax" : {
            //         url: "view_eight_d_report_history",
            //         data: function (param){
            //             param.customerClaimId = $('#customerClaimId', $('#formValidateEightDReport')).val();
            //         },
            //     },
            //     "columns":[
            //         { "data" : "revision_counter"},
            //         { "data" : "remarks"},
            //         { "data" : "submitted_by"},
            //     ],
            // });


            $("#tblCustomerClaimPPS").on('click', '.actionViewCustomerClaim', function(){
                let id = $(this).attr('view-customer-claim-id');
                console.log('id ' +id + ' on formViewCustomerClaim');
                $("input[name='view_customer_claim_id'", $("#formViewCustomerClaim")).val(id);
                // dataTablesCustomerClaimCN.draw();
                GetCustomerClaimByIdForViewing(id);
                $('#smartwizardView').smartWizard("reset");
            });

            //============================= View/Get Submitted 8D Report Details =============================
            $("#tblCustomerClaimPPS").on('click', '.actionValidateEightDReport', function(){
                let id = $(this).attr('customer-claim-id');
                console.log('id ' +id + ' on formValidateEightDReport');
                $("input[name='customer_claim_id'", $("#formValidateEightDReport")).val(id);
                GetSubmittedEightDReportById(id); // EightDReport.js
            });

            // dataTablesEightDReportHistoryPPS = $("#tblEightDReportHistoryPPS").DataTable({
            //     "processing" : false,
            //     "serverSide" : true,
            //     "responsive": true,
            //     // "order": [[ 0, "desc" ],[ 4, "desc" ]],
            //     "language": {
            //         "info": "Showing _START_ to _END_ of _TOTAL_ report records",
            //         "lengthMenu": "Show _MENU_ report records",
            //     },
            //     "ajax" : {
            //         url: "view_eight_d_report_history",
            //         data: function (param){
            //             param.customerClaimId = $('#customerClaimId', $('#formValidateEightDReport')).val();
            //         },
            //     },
            //     "columns":[
            //         { "data" : "revision_counter"},
            //         { "data" : "remarks"},
            //         { "data" : "submitted_by"},
            //     ],
            // });



            //============================= Checkbox disabled/enabled & reset date values when checked =============================
            $('#chkActualDateReceivedClaim').on('click', function(){
                $('#chkActualDateReceivedClaim').attr('checked', 'checked');
                
                if($('#chkActualDateReceivedClaim').is(':checked')){
                    $('#txtAddActualDateReceivedOfClaim').attr('disabled', false);
                }else{
                    $('#chkActualDateReceivedClaim').removeAttr('checked');
                    $('#txtAddActualDateReceivedOfClaim').attr('disabled', true);
                    $('input[name="actual_date_received_claim"]', $("#formAddCustomerClaim")).val('');
                }
            });

            $('#chkdateReturnClaim').on('click', function(){
                $('#chkdateReturnClaim').attr('checked', 'checked');
                
                if($('#chkdateReturnClaim').is(':checked')){
                    $('#txtAddDateReturnOfClaimSample').attr('disabled', false);
                }else{
                    $('#chkdateReturnClaim').removeAttr('checked');
                    $('#txtAddDateReturnOfClaimSample').attr('disabled', true);
                    $('input[name="date_return_of_claim"]', $("#formAddCustomerClaim")).val('');
                }
            });


            $('select[name="email_recipient_attention[]"]', $("#formAddCustomerClaim")).select2({
                placeholder: "",
                minimumInputLength: 1,
                allowClear: true,
                ajax: {
                    url: "{{ route('get_email_recipients') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        console.log(params);
                        return {
                            search: params.term, // search term
                        };
                    },
                    processResults: function (response) {
                        console.log(response[1]['id']);
                        console.log(response[1]['text']);
                        console.log(response[1]['user_id']);
                        return {
                            results: response
                        };
                    },
                    cache: true
                },
            });


            $('select[name="email_recipient_cc[]"]', $("#formAddCustomerClaim")).select2({
                placeholder: "",
                minimumInputLength: 1,
                allowClear: true,
                ajax: {
                    url: "{{ route('get_email_recipients') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            return {
                            search: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        console.log(response[1]['id']);
                        console.log(response[1]['text']);
                        console.log(response[1]['user_id']);
                        return {
                            results: response
                        };
                    },
                    cache: true
                },
            });


            //============================= Add Customer Claim =============================
            $("#formAddCustomerClaim").submit(function(event){
                event.preventDefault(); // to stop the form submission
                AddCustomerClaim();
            });


            // ========================== For Checkbox in Edit Customer Claim ======================
            $('#checkboxEmailAttachment').on('click', function(){
                if($('input[name="checkbox_email_attachment"]', $("#formAddCustomerClaim")).is(':checked')){
                    
                    $('#fileEmailAttachment').removeClass('d-none');
                    $('#txtEmailAttachment').addClass('d-none');
                    $('#fileNameId').addClass('d-none');
                    
                    $('#txtAddSenderName').prop('readonly', false);
                    $('#txtAddReportReceived').prop('readonly', false);
                }
                else{
                    $('#fileEmailAttachment').addClass('d-none');
                    $('#txtEmailAttachment').removeClass('d-none');
                    $('#fileNameId').removeClass('d-none');

                    $('#txtAddSenderName').prop('readonly', true);
                    $('#txtAddReportReceived').prop('readonly', true);
                }
            });

            $('#checkboxEightDReport').on('click', function(){
                if($('input[name="checkbox_eight_d_report"]', $("#formAddCustomerClaim")).is(':checked')){
                    $('#divEightDReportFilename').addClass('d-none');
                    $('#divEightDReportFile').removeClass('d-none');

                    $('#txtAddEightDReportName').prop('readonly', false);
                    $('#txtAddEightDFileUpload').prop('readonly', false);
                }
                else{
                    $('#divEightDReportFilename').removeClass('d-none');
                    $('#divEightDReportFile').addClass('d-none');

                    $('#txtAddEightDReportName').prop('readonly', true);
                    $('#txtAddEightDFileUpload').prop('readonly', true);
                }

            });


            // ======================= Export Checksheet ===========================
            $("#tblCustomerClaimCN").on('click', '.actionExportChecksheet', function(){
                let customerClaimId = $(this).attr('customer-claim-export-checksheet-id');
                console.log('id ' +customerClaimId + ' on Export');

                // $("input[name='view_customer_claim_id'", $("#formViewCustomerClaim")).val(id);
                // // dataTablesCustomerClaimCN.draw();
                // GetCustomerClaimByIdForViewing(id);
                
                // $('#smartwizardView').smartWizard("reset");
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

            $('#checkboxValidity').on('click', function(){
                $('#checkboxValidity').attr('checked', 'checked');
                
                if($('#checkboxValidity').is(':checked')){
                    $('#selectFilterValidity').attr('disabled', false);

                }else{
                    $('#checkboxValidity').removeAttr('checked');
                    $('#selectFilterValidity').attr('disabled', true);
                    $('#selectFilterValidity').val('').trigger('change');
                }
            });

            $('#btnFilterCustomerClaim').on('click', function(){
                // console.log($('#formFilterCustomerClaim').serialize());
                // console.log($('#selectFilterCustomerId').val());
                // console.log($('#txtFilterModeOfDefectId').val());
                // console.log($('#txtFilterModeOfDefectId').attr('value'));
                // console.log($('#selectFilterSection').val());
                // console.log($('#txtFilterModelSeries').val());
                // console.log($('#selectFilterProductClassification').val());
                // console.log($('#selectFilterClass').val());
                // console.log($('#txtFilterReferenceNo').val());
                // console.log($('#txtFilterControlNo').val());
                // console.log($('#txtFiltertraceability').val());
                // console.log($('#selectFilterContributor').val());
                // console.log($('#txtFilterRTV').val());
                dataTablesCustomerClaimCN.draw();
                dataTablesCustomerClaimTS.draw();
                dataTablesCustomerClaimYF.draw();
                dataTablesCustomerClaimPPS.draw();
                $('#modalFilterCustomerClaim').modal('hide');
            });
        });
    </script>
@endsection