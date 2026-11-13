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
@section('title', 'Holiday Classification')

@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Holiday Classification</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Holiday Classification</li>
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
                                <h3 class="card-title" style="margin-top: 8px;">Holiday Classification</h3>
                                <button class="btn float-right reload"><i class="fas fa-sync-alt"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="text-right mt-4">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddHoliday"
                                        value="PPS" id="btnShowAddCustomerModal"><i class="fa fa-plus fa-md"></i> Add
                                        Holiday</button>
                                </div><br>
                                <div class="table-responsive">
                                    <table id="tblHoliday" class="table table-sm table-bordered table-hover display nowrap"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Holiday Date</th>
                                                <th>Holiday Name</th>

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
    <div class="modal fade" id="modalAddHoliday" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp; Holiday Details</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formAddHoliday" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For Edit -->
                                    <input type="hidden" class="form-control" name="holiday_id" id="holidayId"
                                        aria-label="Default" aria-describedby="inputGroup-sizing-default">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Holiday
                                                Name</span>
                                        </div>
                                        <input type="text" class="form-control" name="holiday_name" id="txtAddHolidayName"
                                            aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Holiday
                                                Date</span>
                                        </div>
                                        <select class="form-control select2bs4 selectMonth" name="holiday_month"
                                            id="txtAddHolidayMonth" aria-label="Default"
                                            aria-describedby="inputGroup-sizing-default">
                                            <option value="0" selected disabled>-- Select Month --</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>

                                        <select class="form-control select2bs4 w-25 selectDay" name="holiday_day"
                                            id="txtAddHolidayDay" aria-label="Default"
                                            aria-describedby="inputGroup-sizing-default">
                                            <option value="0" selected disabled>-- Select Day --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddHoliday" class="btn btn-primary"><i id="iBtnAddHolidayIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- Add Customer Classification Modal End -->


    <!-- Delete Customer Classification Modal Start -->
    <div class="modal fade" id="modalDeleteHoliday" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title" id="h4ChangeHolidayTitle"><i class="fas fa-info-circle"></i>&nbsp;Delete
                        Holiday</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formDeleteHoliday" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <label id="lblHolidayLabel"></label> <!-- Label -->
                        <input type="hidden" name="holiday_id" placeholder="Holiday Id" id="txtHolidayId">
                        {{-- <input type="hidden" name="status" placeholder="Status" id="txCustomerStatus"> --}}
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" id="btnDeleteHoliday" class="btn btn-primary"><i id="iBtnDeleteHolidayIcon"
                                class="fa fa-check"></i> Yes</button>
                    </div>

                </form>
            </div>
        </div>
    </div><!-- Delete Customer Classification Modal End -->
@endsection

<!--     {{-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        $(document).ready(function() {
            //============================= Defaults =============================
            // Initialize Bootstrap File Input Elements
            bsCustomFileInput.init();

            // Initialize Select2 Elements
            $('.select2').select2();

            // Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $('#txtAddHolidayMonth').on('change', function(e) {
                var selectedMonth = $(this).find(':selected').val();

                var date = new Date();
                var lastDay = new Date(date.getFullYear(), selectedMonth, 0);
                var lastDayOfMonth = lastDay.getDate();

                var days = "";
                for (var i = 1; i <= lastDayOfMonth; i++) {
                    days += '<option value = "' + i + '">' + i + '</option>';
                }

                $('.selectDay').html(days);
            });


            // Onclick <tr> to add active class
            $(document).on('click', '#tblHoliday tbody tr', function(e) {
                $(this).closest('tbody').find('tr').removeClass('table-active');
                $(this).closest('tr').addClass('table-active');
            });


            //============================= Customer Classification Datatables =============================
            dataTablesHoliday = $("#tblHoliday").DataTable({
                "processing": false,
                "serverSide": true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ holiday records",
                    "lengthMenu": "Show _MENU_ holiday records",
                },
                "ajax": {
                    url: "view_holiday",
                },
                "columns": [{
                        "data": "action",
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "holiday_status"
                    },
                    {
                        "data": "holiday_date"
                    },
                    {
                        "data": "name"
                    }
                ],
            });


            //============================= Edit/Get Holiday Details for edit =============================
            $("#tblHoliday").on('click', '.actionEditHoliday', function() {


                let id = $(this).attr('holiday-id');

                $("input[name='holiday_id'", $("#formAddHoliday")).val(id);
                // // dataTablesCustomerClaimCN.draw();
                GetHolidayById(id);
            });


            //============================= Add Holiday =============================
            $("#formAddHoliday").submit(function(event) {
                event.preventDefault(); // to stop the form submission
                AddHoliday();
            });


            //============================= Onclick button for delete =============================
            $(document).on('click', '.actionDeleteHoliday', function() {

                let holidayId = $(this).attr('holiday-id');

                $("#txtHolidayId").val(holidayId);

                $("#lblHolidayLabel").text('Are you sure to delete?');
                $("#h4ChangeHolidayTitle").html('<i class="fas fa-info-circle"></i> Delete Holiday');
            });

            $("#formDeleteHoliday").submit(function(event) {
                event.preventDefault();
                DeleteHoliday();
            });
        });
    </script>
@endsection
