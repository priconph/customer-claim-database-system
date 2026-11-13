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
@section('title', 'Dashboard')

@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Email Recipient</h1>
                    </div>
                    <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Email Recipient</li>
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
                                <h3 class="card-title" style="margin-top: 8px;">Email Recipient</h3>
                                <button class="btn float-right reload"><i class="fas fa-sync-alt"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="text-right mt-4">                   
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddEmailRecipient" value="PPS" id="btnShowAddEmailRecipientModal"><i class="fa fa-plus fa-md"></i> New Email Recipient</button>
                                </div><br>
                                <div class="table-responsive">
                                    <table id="tblEmailRecipient" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Dept/Section</th>
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


    <!-- Add Email Recipient Modal Start -->
    <div class="modal fade" id="modalAddEmailRecipient" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Email Recipient Details</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formAddEmailRecipient" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For User Id -->
                                    <input type="text" class="form-control" style="display: none" name="user_id" id="userId" aria-label="Default" aria-describedby="inputGroup-sizing-default">

                                    <!-- For Edit -->
                                    <input type="text" class="form-control" style="display: none" name="email_recipient_id" id="emailRecipient" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    
                                    <!-- For User Name -->
                                    <input type="text" class="form-control" style="display: none" name="recipient_name" id="recipientName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Name of Recipients</span>
                                        </div>
                                        <select class="form-control select2bs4 selectRecipientName" name="recipient_name_display" id="selectRecipientName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            <!-- Auto Generated -->
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Email</span>
                                        </div>
                                        <input type="text" class="form-control" name="email" id="txtAddEmail" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Dept/Section</span>
                                        </div>
                                        <input type="text" class="form-control" name="section" id="txtAddSection" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                        {{-- <select class="form-control select2bs4 selectSection" name="section" id="selectSection" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            <!-- Auto Generated -->
                                        </select> --}}
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddEmailRecipient" class="btn btn-primary"><i id="iBtnAddEmailRecipientIcon" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- Add Email Recipient Modal End -->


    <!-- Delete Email Recipient Modal Start -->
    <div class="modal fade" id="modalDeleteEmailRecipient" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title" id="h4ChangeEmailRecipientTitle"><i class="fas fa-info-circle"></i>&nbsp;Delete Email Recipient</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formDeleteEmailRecipient">
                     @csrf
                    <div class="modal-body">
                        <label id="lblEmailRecipientLabel"></label>
                        <input type="hidden" name="email_recipient_id" placeholder="Email Recipient Id" id="txtEmailRecipientId">
                        <input type="hidden" name="status" placeholder="Status" id="txtEmailRecipientStatus">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" id="btnDeleteEmailRecipient" class="btn btn-primary"><i id="iBtnDeleteEmailRecipientIcon" class="fa fa-check"></i> Yes</button>
                    </div>
                
                </form>
            </div>
        </div>
    </div><!-- Delete Email Recipient Modal End -->
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
            $(document).on('click','#tblEmailRecipient tbody tr',function(e){
                $(this).closest('tbody').find('tr').removeClass('table-active');
                $(this).closest('tr').addClass('table-active');
            });


            //============================= Customer Claim Datatables =============================
            dataTablesEmailRecipient = $("#tblEmailRecipient").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ recipient records",
                    "lengthMenu": "Show _MENU_ recipient records",
                },
                "ajax" : {
                    url: "view_email_recipient",
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "email_recipient_status"},
                    { "data" : "name"},
                    { "data" : "email"},
                    { "data" : "section"},
                ],
            });


            //============================= Get User's Name, Email & Section =============================
            GetRapidXUser($('#selectRecipientName')); // get name as recipient_name(attr), email as email(attr), id as value(attr)
            GetSection($('#selectSection')); // get section


           //============================= Auto Generated Dropdown values =============================
           // Pass the user_id(name attr) and email in the email(name attr) to hidden input when selected
            $("select#selectRecipientName").change(function(){
                var selectedUserId = $(this).children("option:selected").attr('value');
                var selectedEmail = $(this).children("option:selected").attr('email');
                var selectedName = $(this).children("option:selected").attr('recipient_name');
                var selectedNDepartment = $(this).children("option:selected").attr('department');
                console.log(selectedUserId);
                console.log(selectedEmail);
                console.log(selectedName);
                console.log(selectedNDepartment);

                $('#txtAddSection').val(selectedNDepartment);
                $("input[name='email']", $('#formAddEmailRecipient')).val(selectedEmail); // auto generated when selecting users in dropdown

                // hidden input fields that will be use for insert/update operation
                $("input[name='user_id']", $('#formAddEmailRecipient')).val(selectedUserId); // auto generated when selecting users in dropdown
                $("input[name='recipient_name']", $('#formAddEmailRecipient')).val(selectedName); // auto generated when selecting users in dropdown
            });


           //============================= Edit/Get Customer Claim Details for edit =============================
            $("#tblEmailRecipient").on('click', '.actionEditEmailRecipient', function(){
                let id = $(this).attr('email-recipient-id');
                console.log('id ' +id + ' on formAddEmailRecipient');
                $("input[name='email_recipient_id'", $("#formAddEmailRecipient")).val(id);
                // dataTablesCustomerClaimCN.draw();
                GetEmailRecipientById(id);

                $("#modalAddEmailRecipient").modal('show');
            });


            //============================= Add Customer Claim =============================
            $("#formAddEmailRecipient").submit(function(event){
                event.preventDefault(); // to stop the form submission
                AddEmailRecipient();
            });


            //============================= Onclick button for delete =============================
            $(document).on('click', '.actionDeleteEmailRecipient', function(){
                let emailRecipientStatus = $(this).attr('status');
                let emailRecipientId = $(this).attr('email-recipient-id');

                $("#txtEmailRecipientStatus").val(emailRecipientStatus);
                $("#txtEmailRecipientId").val(emailRecipientId);

                // check if 1-active else 0-inactive
                if(emailRecipientStatus == 1){
                    $("#lblEmailRecipientLabel").text('Are you sure to delete?');
                    $("#h4ChangeEmailRecipientTitle").html('<i class="fas fa-info-circle"></i> Delete Email Recipient');
                }
                else{
                    $("#lblEmailRecipientLabel").text('Are you sure to restore?');
                    $("#h4ChangeEmailRecipientTitle").html('<i class="fas fa-info-circle"></i> Restore Email Recipient');
                }
            });

            $("#formDeleteEmailRecipient").submit(function(event){
                event.preventDefault();
                DeleteEmailRecipient();
            });
        });
    </script>
@endsection