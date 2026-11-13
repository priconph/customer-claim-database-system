//============================== ADD HOLIDAY ==============================
function AddHoliday() {
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

    $.ajax({
        url: "add_holiday",
        method: "post",
        data: $('#formAddHoliday').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#iBtnAddHolidayIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddHoliday").prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response['validation'] == 'hasError') {
                toastr.error('Saving holiday failed!');
                if (response['error']['holiday_name'] === undefined) {
                    $("#txtAddHolidayName").removeClass('is-invalid');
                    $("#txtAddHolidayName").attr('title', '');
                }
                else {
                    $("#txtAddHolidayName").addClass('is-invalid');
                    $("#txtAddHolidayName").attr('title', response['error']['holiday_name']);
                }

                if (response['error']['holiday_month'] === undefined) {
                    $("#txtAddHolidayMonth").removeClass('is-invalid');
                    $("#txtAddHolidayMonth").attr('title', '');
                }
                else {
                    $("#txtAddHolidayMonth").addClass('is-invalid');
                    $("#txtAddHolidayMonth").attr('title', response['error']['holiday_month']);
                }

                if (response['error']['holiday_day'] === undefined) {
                    $("#txtAddHolidayDay").removeClass('is-invalid');
                    $("#txtAddHolidayDay").attr('title', '');
                }
                else {
                    $("#txtAddHolidayDay").addClass('is-invalid');
                    $("#txtAddHolidayDay").attr('title', response['error']['holiday_day']);
                }

            } else if (response['result'] == 1) {
                $("#modalAddHoliday").modal('hide');
                $("#formAddHoliday")[0].reset();
                toastr.success('Holiday was succesfully saved!');
                dataTablesHoliday.draw(); // reload the tables after insertion
            }
            else if (response['result'] == 2) {
                // $("#modalAddHoliday").modal('hide');
                // $("#formAddHoliday")[0].reset();
                toastr.warning('Holiday already exists!');
                // dataTablesHoliday.draw(); // reload the tables after insertion
            }

            $("#iBtnAddHolidayIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddHoliday").removeAttr('disabled');
            $("#iBtnAddHolidayIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddHolidayIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddHoliday").removeAttr('disabled');
            $("#iBtnAddHolidayIcon").addClass('fa fa-check');
        }
    });
}

function GetHolidayById(holidayId) {
    $.ajax({
        url: "get_holiday_by_id",
        method: "get",
        data: {
            holidayId: holidayId,
        },
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            // let formAddHoliday = $('#formAddHoliday');
            let holidayDetails = response['result'];
            if (holidayDetails.length > 0) {
                // The user_id is the id stored in the table and that id will be used to reference the user id in the RapidX's user(table) id
                // Since we used val() function to fetch/get the data when edit button is clicked, the user_id will be used to match in the value(attribute) 
                // that we get via ajax to fetch all the users's details including recipient_name, email & user_id
                // $('select[name="Customer_classification_id"]', formAddCustomerClassification).val(CustomerClassification[0].id).trigger('change');
                $("#txtAddHolidayName").val(holidayDetails[0].name);
                $(".selectMonth").val(holidayDetails[0].month).trigger("change");
                $(".selectDay").val(holidayDetails[0].day).trigger("change");
            }
            else {
                toastr.warning('No Holiday records found!');
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function DeleteHoliday() {
    $.ajax({
        url: "delete_holiday",
        method: "post",
        data: $('#formDeleteHoliday').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#iBtnDeleteHolidayIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeleteHoliday").prop('disabled', 'disabled');
        },
        success: function (response) {
            console.log(response);
            if (response['validation'] == 'hasError') {
                toastr.error('Holiday Deletion Failed');
            } else {
                // console.log(response['status']);
                if (response['result'] == 1) {
                    toastr.success('Holiday Deleted!');
                    dataTablesHoliday.draw();
                }
                $("#modalDeleteHoliday").modal('hide');
                $("#formDeleteHoliday")[0].reset();
            }

            $("#iBtnDeleteHolidayIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeleteHoliday").removeAttr('disabled');
            $("#iBtnDeleteHolidayIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnDeleteHolidayIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeleteHoliday").removeAttr('disabled');
            $("#iBtnDeleteHolidayIcon").addClass('fa fa-check');
        }
    });
}