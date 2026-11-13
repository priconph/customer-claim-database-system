function uploadYecEightReport(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    let formData = new FormData($('#formYecEightUpload')[0]);

    $.ajax({
        url: "add_yec_eight_d_report",
        method: "post",
        processData: false,
        contentType: false,
        // data: $('#formAddCustomerClaim').serialize(),
        data: formData,
        dataType: "json",
        beforeSend: function(){
            
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Uploading failed!');
                if(response['error']['yec_eight_report'] === undefined){
                    $("#txtAddEightReport").removeClass('is-invalid');
                    $("#txtAddEightReport").attr('title', '');
                }
                else{
                    $("#txtAddEightReport").addClass('is-invalid');
                    $("#txtAddEightReport").attr('title', response['error']['yec_eight_report']);
                }
                if(response['error']['yec_eight_receive'] === undefined){
                    $("#txtAddEightReceived").removeClass('is-invalid');
                    $("#txtAddEightReceived").attr('title', '');
                }
                else{
                    $("#txtAddEightReceived").addClass('is-invalid');
                    $("#txtAddEightReceived").attr('title', response['error']['yec_eight_receive']);
                }
            }
            else{
                toastr.success('Uploading Successful!');
                $('#modalUploadYecEightD').modal('hide');
                dataTablesMasterList.draw();
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function getUploadReportDetails(id){
    $.ajax({
        url: "get_yec_upload_for_edit",
        method: "get",
        // processData: false,
        // contentType: false,
        // data: $('#formAddCustomerClaim').serialize(),
        data: {
            id : id,
        },
        dataType: "json",
        success: function(response){
            console.log(response);
            $('#txtViewEightReport').val(response['result'][0]['yec_eight_report_filename']);
            $('#txtViewEightReportDate').val(response['result'][0]['yec_eight_report_date']);
        },
    });
}