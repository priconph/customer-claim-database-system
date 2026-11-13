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
@section('title', 'Customer Classification')

@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customer Classification</h1>
                    </div>
                    <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customer Classification</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="margin-top: 8px;">Customer Classification</h3>
                                <button class="btn float-right reload"><i class="fas fa-sync-alt"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="text-right mt-4">                   
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddCustomer" value="PPS" id="btnShowAddCustomerModal"><i class="fa fa-plus fa-md"></i> New Customer</button>
                                </div><br>
                                <div class="table-responsive">
                                    <table id="tblCustomer" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Customer Name</th></th></th>
                                                <th>Customer Classification</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Add Customer Classification Modal Start -->
    <div class="modal fade" id="modalAddCustomer" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp; Customer Details</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formAddCustomer" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For Edit -->
                                    <input type="hidden" class="form-control" name="customer_id" id="customerId" aria-label="Default" aria-describedby="inputGroup-sizing-default">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Customer Name</span>
                                        </div>
                                        <input type="text" class="form-control" name="customer_name" id="txtAddCustomerName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Customer Details</span>
                                        </div>
                                        <input type="text" class="form-control" name="customer_details" id="txtAddCustomerDetails" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddCustomer" class="btn btn-primary"><i id="iBtnAddCustomerIcon" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- Add Customer Classification Modal End -->


    <!-- Delete Customer Classification Modal Start -->
    <div class="modal fade" id="modalDeleteCustomer" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title" id="h4ChangeCustomerTitle"><i class="fas fa-info-circle"></i>&nbsp;Delete Customer</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formDeleteCustomer" autocomplete="off">
                     @csrf
                    <div class="modal-body">
                        <label id="lblCustomerClassificationLabel"></label> <!-- Label -->
                        <input type="hidden" name="customer_id" placeholder="Customer Classification Id" id="txtCustomerId">
                        <input type="hidden" name="status" placeholder="Status" id="txCustomerStatus">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" id="btnDeleteCustomer" class="btn btn-primary"><i id="iBtnDeleteCustomerIcon" class="fa fa-check"></i> Yes</button>
                    </div>
                
                </form>
            </div>
        </div>
    </div><!-- Delete Customer Classification Modal End -->
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
            $(document).on('click','#tblCustomer tbody tr',function(e){
                $(this).closest('tbody').find('tr').removeClass('table-active');
                $(this).closest('tr').addClass('table-active');
            });


            //============================= Customer Classification Datatables =============================
            dataTablesCustomerClassification = $("#tblCustomer").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ customer records",
                    "lengthMenu": "Show _MENU_ customer records",
                },
                "ajax" : {
                    url: "view_customer",
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "customer_classification_status"},
                    { "data" : "customer_name"},
                    { "data" : "customer_details"},

                ],
            });


           //============================= Edit/Get Customer Classification Details for edit =============================
            $("#tblCustomer").on('click', '.actionEditCustomer', function(){
                

                let id = $(this).attr('customer-classification-id');
              
                $("input[name='customer_id'", $("#formAddCustomer")).val(id);
                // // dataTablesCustomerClaimCN.draw();
                GetCustomerById(id);
            });


            //============================= Add Customer Classification =============================
            $("#formAddCustomer").submit(function(event){
                event.preventDefault(); // to stop the form submission
                AddCustomer();
            });


            //============================= Onclick button for delete =============================
            $(document).on('click', '.actionDeleteCustomer', function(){
                let customerClassificationStatus = $(this).attr('status');
                let customerClassificationId = $(this).attr('customer-classification-id');

                $("#txCustomerStatus").val(customerClassificationStatus);
                $("#txtCustomerId").val(customerClassificationId);

                // check if 1-active else 0-inactive
                if(customerClassificationStatus == 1){
                    $("#lblCustomerClassificationLabel").text('Are you sure to delete?');
                    $("#h4ChangeCustomerTitle").html('<i class="fas fa-info-circle"></i> Delete Customer');
                }
                else{
                    $("#lblCustomerClassificationLabel").text('Are you sure to restore?');
                    $("#h4ChangeCustomerTitle").html('<i class="fas fa-info-circle"></i> Restore Customer');
                }
            });

            $("#formDeleteCustomer").submit(function(event){
                event.preventDefault();
                DeleteCustomerClassification();
            });
        });
    </script>
@endsection