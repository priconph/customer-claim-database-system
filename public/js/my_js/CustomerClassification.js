function AddCustomer(){
    $.ajax({
        url: "add_customer",
        method: "post",
        // processData: false,
        // contentType: false,
        data: $('#formAddCustomer').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddCustomerIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddCustomer").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Saving customer failed!');
                if(response['error']['customer_name'] === undefined){
                    $("#txtAddCustomerName").removeClass('is-invalid');
                    $("#txtAddCustomerName").attr('title', '');
                }
                else{
                    $("#txtAddCustomerName").addClass('is-invalid');
                    $("#txtAddCustomerName").attr('title', response['error']['customer_name']);
                }
             
            }
            else{
                toastr.success('Customer was succesfully saved!');
                $('#modalAddCustomer').modal('hide');
                // $('#formAddCustomer')[0].reset();
                resetFormValuesCustomerClassification();
            }

            $("#iBtnAddCustomerIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddCustomer").removeAttr('disabled');
            $("#iBtnAddCustomerIcon").addClass('fa fa-check');
            dataTablesCustomerClassification.draw();

            
        },
        error: function(data, xhr, status){
            console.log(data);
            console.log(xhr);
            console.log(status);
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddCustomerIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddCustomer").removeAttr('disabled');
            $("#iBtnAddCustomerIcon").addClass('fa fa-check');
        }
    });
}


function GetCustomerById(customerId){
    $.ajax({
        url: "get_customer_by_id",
        method: "get",
        data: {
            customerId : customerId,
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let formAddCustomerClassification = $('#formAddCustomer');
            let customerClassification = response['result'];
            if(customerClassification.length > 0){
                // The user_id is the id stored in the table and that id will be used to reference the user id in the RapidX's user(table) id
                // Since we used val() function to fetch/get the data when edit button is clicked, the user_id will be used to match in the value(attribute) 
                // that we get via ajax to fetch all the users's details including recipient_name, email & user_id
                // $('select[name="Customer_classification_id"]', formAddCustomerClassification).val(CustomerClassification[0].id).trigger('change');
                $("#txtAddCustomerName").val(customerClassification[0].customer_name);
                $("#txtAddCustomerDetails").val(customerClassification[0].customer_details);
            }
            else{
                toastr.warning('No Customer Classification records found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function DeleteCustomerClassification(){
    $.ajax({
        url: "delete_customer_classification",
        method: "post",
        data: $('#formDeleteCustomer').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnDeleteCustomerIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnDeleteCustomer").prop('disabled', 'disabled');
        },
        success: function(response){
            console.log(response);
            if(response['validation'] == 'hasError'){
                toastr.error('Customer Classification Deletion Failed');
            }else{
                // console.log(response['status']);
                if(response['result'] == 1){
                    if(response['status'] == 0){
                        toastr.success('Customer Classification Deleted!');
                        dataTablesCustomerClassification.draw();
                    }
                    else{
                        toastr.success('Customer Classification Restored!');
                        dataTablesCustomerClassification.draw();
                    }
                }
                $("#modalDeleteCustomer").modal('hide');
                $("#formDeleteCustomer")[0].reset();
            }

            $("#iBtnDeleteCustomerIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeleteCustomer").removeAttr('disabled');
            $("#iBtnDeleteCustomerIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnDeleteCustomerIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnDeleteCustomer").removeAttr('disabled');
            $("#iBtnDeleteCustomerIcon").addClass('fa fa-check');
        }
    });
}

function GetCustomerClassification(cboElement){
	let result = '<option value="0" disabled selected>Select One</option>';
	$.ajax({
		url: 'get_customer_classification',
		method: 'get',
		dataType: 'json',
		beforeSend: function(){
			result = '<option value="0" disabled>Loading</option>';
			cboElement.html(result);
		},
		success: function(response){
			let disabled = '';
			if(response['customerClassifications'].length > 0){
				result = '<option value="0" disabled selected>Select One</option>';
				for(let index = 0; index < response['customerClassifications'].length; index++){
                    result += '<option value="' + response['customerClassifications'][index].id + '">' + response['customerClassifications'][index].customer_name + '</option>';
				}
			}
			else{
				result = '<option value="0" disabled>No Customer Classification found</option>';
			}
			cboElement.html(result);
		},
		error: function(data, xhr, status){
			result = '<option value="0" disabled>Reload Again</option>';
			cboElement.html(result);
            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
	});
}