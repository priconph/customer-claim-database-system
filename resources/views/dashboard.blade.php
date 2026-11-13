@php
    session_start();
    $isLogin = false;
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
    }

    $isAuthorized = false;
    $user_level = 0;
    $layout = 'layouts.super_user_layout';
@endphp
@if($isLogin)
    @if(isset($layout))
        @if($_SESSION['rapidx_user_level_id'] == 3 || $_SESSION['rapidx_user_level_id'] == 1) <!-- 1-Super User, 2-Administrator, 3-User, 4-QAD Admin, 5-Other Section -->
            @if(count($_SESSION['rapidx_user_accesses']) > 0) <!-- Count the rapidx_user_accesses session based on RapidX session -->
                @for($index = 0; $index < count($_SESSION['rapidx_user_accesses']); $index++) <!-- Loop the rapidx_user_accesses session based on RapidX session -->
                    @if($_SESSION['rapidx_user_accesses'][$index]['module_id'] == 11) <!-- 11-Customer Claim Database System Module -->
                        @php
                            $isAuthorized = true;
                            $user_level = $_SESSION['rapidx_user_accesses'][$index]['user_level_id']; // Collect the user_level_id on user_accesses(table)
                        @endphp
                        @break
                    @endif
                @endfor

                @php
                    $_SESSION['qad_session_user_level_id'] = $user_level // make it global so that you can access it anywhere in your project
                @endphp

                @php
                    if(isset($_SESSION['rapidx_user_level_id']) && !empty($_SESSION['rapidx_user_level_id'])){
                        if($user_level == 4 || $_SESSION['rapidx_user_level_id'] == 1){ // 4-QAD Admin or 1-Super User
                            $layout = 'layouts.super_user_layout';
                            // echo $user_level;
                        }
                        else if($user_level == 5){ // 5-Other Section
                            $layout = 'layouts.admin_layout';
                            // echo $user_level;
                        }
                    }else{
                        echo '<script type="text/javascript">
                                alert("Session Expired! Please Re-login");
                                window.location = "../RapidX/";
                            </script>';
                    }
                @endphp

                @if(!$isAuthorized)
                    <script type="text/javascript">
                        window.location = '../RapidX/';
                    </script>
                @else
                    @extends($layout)
                    @section('title', 'Dashboard')
                    @section('content_page')
                        <div class="content-wrapper">
                            <!-- Main content -->
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <!--
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info"><i class="fas fa-tachometer-alt"></i></span>
                                                <div class="info-box-content">
                                                    {{-- <b>{{ "rapidx_user_level_id ".$_SESSION['rapidx_user_level_id'] }}</b> --}}
                                                    <span class="info-box-text">Total Reports </span>
                                                    <span class="info-box-number">3,773</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-success"><i class="fa fa-file"></i></span>
                                                <div class="info-box-content">
                                                    {{-- <b>{{ "user_level ".$user_level }}</b> --}}
                                                    <span class="info-box-text">Total Claim </span>
                                                    <span class="info-box-number">233</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info"><i class="fa fa-user"></i></span>
                                                <div class="info-box-content">
                                                    {{-- <b>{{ "isLogin ".$isLogin }}</b> --}}
                                                    <span class="info-box-text">Total CAPA </span></span>
                                                    <span class="info-box-number">9,139</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-black"><i class="fa fa-users"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Users</span>
                                                    <span class="info-box-number">9,132</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-danger"><i class="fa fa-star"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Pending</span>
                                                    <span class="info-box-number" id="pendingClaim">139</span>
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-success"><i class="fa fa-file"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Masterlist Records</span>
                                                    <span class="info-box-number" id="totalClaimRecords"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-warning"><i class="fa fa-file"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Pending Claim</span>
                                                    <span class="info-box-number" id="pendingClaim"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-primary"><i class="fas fa-mail-bulk"></i></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Email Recipient Records</span>
                                                    <span class="info-box-number" id="totalEmailRecipientRecords"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info"><i class="fas fa-sitemap"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Product Classification Records</span>
                                                    <span class="info-box-number" id="totalProductClassificationRecords"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-secondary"><i class="fas fa-building"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Customer Classification Records</span>
                                                    <span class="info-box-number" id="totalCustomerClassificationRecords"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endsection
                
                    <!--     {{-- JS CONTENT --}} -->
                    @section('js_content')
                        <script type="text/javascript">
                            $(document).ready(function () {
                                function getDataForDashboard(){
                                    $.ajax({
                                        url: "get_data_for_dashboard",
                                        method: "get",
                                        dataType: "json",
                                        success: function(response){
                                            console.log('response ', response['pendingClaim']);
                                            $('#pendingClaim').text(response['pendingClaim']);
                                            $('#totalClaimRecords').text(response['totalClaim']);
                                            $('#totalEmailRecipientRecords').text(response['totalEmailRecipient']);
                                            $('#totalProductClassificationRecords').text(response['totalProductClassification']);
                                            $('#totalCustomerClassificationRecords').text(response['totalCustomerClassification']);
                                        },
                                    });
                                }
                                getDataForDashboard();
                            });
                        </script>
                    @endsection
                @endif <!-- If isAuthorized or not -->
            @else
                <script type="text/javascript">
                    window.location = '../RapidX/';
                </script>
            @endif <!-- If has rapidx_user_accesses > 0 -->
        @else
            <script type="text/javascript">
                window.location = "../RapidX/";
            </script>
        @endif <!-- If rapidx_user_level_id == user/admin or not -->
    @else
        <script type="text/javascript">
            window.location = '../RapidX/';
        </script>
    @endif
@else
    <script type="text/javascript">
        window.location = '../RapidX/';
    </script>
@endif <!-- If login or not -->

