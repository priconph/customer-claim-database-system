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
@section('title', 'Product Classification')

@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product Classification</h1>
                    </div>
                    <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Product Classification</li>
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
                                <h3 class="card-title" style="margin-top: 8px;">Product Classification</h3>
                                <button class="btn float-right reload"><i class="fas fa-sync-alt"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="text-right mt-4">                   
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddProductClassification" value="PPS" id="btnShowAddProductClassificationModal"><i class="fa fa-plus fa-md"></i> New Product Classification</button>
                                </div><br>
                                <div class="table-responsive">
                                    <table id="tblProductClassification" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Product Name</th></th></th>
                                                <th>Product Description</th>
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

    <!-- Add Product Classification Modal Start -->
    <div class="modal fade" id="modalAddProductClassification" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp; Product Classification Details</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formAddProductClassification" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For Edit -->
                                    <input type="text" class="form-control" style="display: none" name="product_classification_id" id="productClassificationId" aria-label="Default" aria-describedby="inputGroup-sizing-default">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Product Name</span>
                                        </div>
                                        <input type="text" class="form-control" name="product_name" id="txtAddProductName" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Product Details</span>
                                        </div>
                                        <input type="text" class="form-control" name="product_details" id="txtAddProductDetails" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddProductClassification" class="btn btn-primary"><i id="iBtnAddProductClassificationIcon" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- Add Product Classification Modal End -->


    <!-- Delete Product Classification Modal Start -->
    <div class="modal fade" id="modalDeleteProductClassification" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title" id="h4ChangeProductClassificationTitle"><i class="fas fa-info-circle"></i>&nbsp;Delete Product Classification</h4>
                    <button type="button" style="color: #fff;" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formDeleteProductClassification" autocomplete="off">
                     @csrf
                    <div class="modal-body">
                        <label id="lblProductClassificationLabel"></label> <!-- Label -->
                        <input type="hidden" name="product_classification_id" placeholder="Product Classification Id" id="txtProductClassificationId">
                        <input type="hidden" name="status" placeholder="Status" id="txtProductClassificationStatus">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" id="btnDeleteProductClassification" class="btn btn-primary"><i id="iBtnDeleteProductClassificationIcon" class="fa fa-check"></i> Yes</button>
                    </div>
                
                </form>
            </div>
        </div>
    </div><!-- Delete Product Classification Modal End -->
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
            $(document).on('click','#tblProductClassification tbody tr',function(e){
                $(this).closest('tbody').find('tr').removeClass('table-active');
                $(this).closest('tr').addClass('table-active');
            });


            //============================= Product Classification Datatables =============================
            dataTablesProductClassification = $("#tblProductClassification").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ product records",
                    "lengthMenu": "Show _MENU_ product records",
                },
                "ajax" : {
                    url: "view_product_classification",
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "product_classification_status"},
                    { "data" : "product_name"},
                    { "data" : "product_details"},

                ],
            });


           //============================= Edit/Get Product Classification Details for edit =============================
            $("#tblProductClassification").on('click', '.actionEditProductClassification', function(){
                let id = $(this).attr('product-classification-id');
                console.log('id ' +id + ' on formAddProductClassification');
                $("input[name='product_classification_id'", $("#formAddProductClassification")).val(id);
                // dataTablesCustomerClaimCN.draw();
                GetProductClassificationById(id);

                $("#modalAddProductClassification").modal('show');
            });


            //============================= Add Product Classification =============================
            $("#formAddProductClassification").submit(function(event){
                event.preventDefault(); // to stop the form submission
                AddProductClassification();
            });


            //============================= Onclick button for delete =============================
            $(document).on('click', '.actionDeleteProductClassification', function(){
                let productClassificationStatus = $(this).attr('status');
                let productClassificationId = $(this).attr('product-classification-id');

                $("#txtProductClassificationStatus").val(productClassificationStatus);
                $("#txtProductClassificationId").val(productClassificationId);

                // check if 1-active else 0-inactive
                if(productClassificationStatus == 1){
                    $("#lblProductClassificationLabel").text('Are you sure to delete?');
                    $("#h4ChangeProductClassificationTitle").html('<i class="fas fa-info-circle"></i> Delete Product Classification');
                }
                else{
                    $("#lblProductClassificationLabel").text('Are you sure to restore?');
                    $("#h4ChangeProductClassificationTitle").html('<i class="fas fa-info-circle"></i> Restore Product Classification');
                }
            });

            $("#formDeleteProductClassification").submit(function(event){
                event.preventDefault();
                DeleteProductClassification();
            });
        });
    </script>
@endsection