@php
    session_start();
    $isLogin = false;
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
    }

    $isAuthorized = false;
    $user_level = 0;
@endphp

@if($isLogin)
    @php $layout = 'layouts.super_user_layout'; @endphp
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

            @if(!$isAuthorized)
                <script type="text/javascript">
                    window.location = '../RapidX/';
                </script>
            @else
                @if ($user_level == 4 || $_SESSION['rapidx_user_level_id'] == 1)
                    @extends($layout)
                    @section('title', 'Dashboard')
                    @section('content_page')
                        <div class="content-wrapper">
                            <!-- Main content -->
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
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
                                                    <span class="info-box-number">139</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 mt-4">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-warning"><i class="fa fa-star"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Total Records</span>
                                                    <span class="info-box-number">93,139</span>
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
                            });
                        </script>
                    @endsection
                @elseif ($user_level == 5)
                    @php $layout = 'layouts.admin_layout'; @endphp
                @else
                    <script type="text/javascript">
                        window.location = "../RapidX/";
                    </script>
                @endif <!-- If user_level == 4-QAD Admin or user_level == 5-Other Section -->
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
@endif <!-- If login or not -->

