
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="height: 100vh">

    <!-- System title and logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('public/images/pricon_logo2.png') }}"
            alt="OITL"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">

        <span class="brand-text font-weight-light font-size"><h5>Customer Claim</h5></span>
    </a> <!-- System title and logo -->

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="{{ url('../RapidX') }}" class="nav-link">
                        <i class="nav-icon fas fa-arrow-left"></i>
                        <p>Return to RapidX</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                    {{-- <a href="" class="nav-link"> --}}
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header font-weight-bold">USER</li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('eight_d_report') }}" class="nav-link">
                    {{-- <a href="" data-toggle="modal" data-target="#modalOnGoing" class="nav-link"> --}}
                        <i class="nav-icon fas fa-eye"></i>
                        <p>8D Report Monitoring</p></p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('master_list') }}" class="nav-link">
                    {{-- <a href="master_list" data-toggle="modal" data-target="#modalOnGoing" class="nav-link"> --}}
                        <i class="nav-icon far fa-list-alt"></i>
                        <p>Master List</p></p>
                    </a>
                </li>
                <!--
                <li class="nav-item has-treeview">
                    {{-- <a href="{{ route('user_management') }}" class="nav-link"> --}}
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>CAPA Monitoring</p></p>
                    </a>
                </li>
                -->

                <!--
                <li class="nav-header font-weight-bold">EXPORT REPORTS</li>
                <li class="nav-item has-treeview">
                {{-- <a href="{{ route('user_management') }}" class="nav-link"> --}}
                    <a href="" data-toggle="modal" data-target="#modalOnGoing" class="nav-link">
                        <i class="nav-icon fas fa-file-export"></i>
                        <p>Export Checksheet</p></p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                {{-- <a href="{{ route('user_management') }}" class="nav-link"> --}}
                    <a href="" data-toggle="modal" data-target="#modalOnGoing" class="nav-link">
                        <i class="nav-icon fas fa-file-export"></i>
                        <p>Export 8D Report</p></p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                {{-- <a href="{{ route('user_management') }}" class="nav-link"> --}}
                    <a href="" data-toggle="modal" data-target="#modalOnGoing" class="nav-link">
                        <i class="nav-icon fas fa-file-export"></i>
                        <p>Export CAPA Report</p></p>
                    </a>
                </li>
                
                
                <li class="nav-header font-weight-bold"><i class="fas fa-cogs"></i>&nbsp;CONFIGURATION</li>
                <li class="nav-item has-treeview">
                {{-- <a href="{{ route('user_management') }}" class="nav-link"> --}}
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-plus"></i>
                        {{-- <i class="fas fa-plus"></i> --}}
                        {{-- <i class="fas fa-plus-square"></i> --}}
                        {{-- <i class="far fa-plus-square"></i> --}}
                        <p>Add Product Name</p></p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('customer_classification') }}" class="nav-link">
                        <i class="nav-icon fas fa-plus"></i>
                        {{-- <i class="fas fa-plus"></i> --}}
                        {{-- <i class="fas fa-plus-square"></i> --}}
                        {{-- <i class="far fa-plus-square"></i> --}}
                        <p>Add Customer Name</p></p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('holiday_classification') }}" class="nav-link">
                        <i class="nav-icon fas fa-plus"></i>
                        {{-- <i class="fas fa-plus"></i> --}}
                        {{-- <i class="fas fa-plus-square"></i> --}}
                        {{-- <i class="far fa-plus-square"></i> --}}
                        <p>Add Holiday</p></p>
                    </a>
                </li>
                -->
                
                
            </ul>
        </nav>
    </div><!-- Sidebar -->
</aside>