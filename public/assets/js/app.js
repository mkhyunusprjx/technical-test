'use_stric'
$(document).ready(function(){ 
	var api_key = '4j94k2m5m-d0x4f03nd8-m48cjd-2mce-234';
	var api_secret = 'a8b3kn9s8dmv85mc85mca10cm00';
	var api_url = 'http://localhost/restapi/api';
	var customer = {};
	var formData = {};
	function getCustomers(){
		$.ajax({
			type : 'GET',
			dataType : 'json',
			url : api_url+'/get_customers.php',
			beforeSend : function(xhr){
				xhr.setRequestHeader ("Authorization", "Basic " + btoa(api_key + ":" + api_secret));
				xhr.setRequestHeader ("Content-Type", "application/json");
			},
			complete : function(xhr){
				
			},
			success : function(response){
				var code = response.status.code || false;
				var result = response.result || [];
				var output = '<tr><td colspan="7" class="text-center">No records</td></tr>';
				if(code == 200){
					var i = 1;
					if(result.length > 0){
						output ='';	
						var gender = {"F": "Female", "M" : "Male"};
						var marital = {"Y": "Yes", "N" : "No"};
						$.each(result,function(idx, val){
							output +='<tr>';
								output +='<td>'+i+'</td>';
								output +='<td>'+val.name+'</td>';
								output +='<td>'+val.email+'</td>';
								output +='<td>'+gender[val.gender]+'</td>';
								output +='<td>'+marital[val.is_married]+'</td>';
								output +='<td>'+val.address+'</td>';
								output +=`<td>
											<button class="btn btn-sm btn-info view-button" data-toggle="modal" data-target="#global-modal" data-source="view-customer" data-id="${val.id}">View</button>
											<button class="btn btn-sm btn-danger" id="btnDelete" data-id="${val.id}" data-name="${val.name}">Delete</button>
										</td>`;
							output +='</tr>';
							i++;
						})
					}
				}
				$("#data-table tbody").html(output);
			},
			error : function(xhr, error){
				message = xhr.responseJSON.status.message || "error";
				response = xhr.responseJSON.status.response || "error";
				showSuccessMessage("alert-danger", message, response);
			}
		})
	}
	$("body").off('click', "#btnDelete").on('click', '#btnDelete', async function(){
		var cfrm = confirm(`Are you sure you want to delete this ${$(this).attr('data-name')}?`);
		var data = {id : $(this).attr('data-id')};
		if(!cfrm){
			return;
		}
		$.ajax({
			type : 'DELETE',
			dataType : 'json',
			url : api_url+'/delete_customer.php',
			data : JSON.stringify(data),
			beforeSend : function(xhr){
				xhr.setRequestHeader ("Authorization", "Basic " + btoa(api_key + ":" + api_secret));
				xhr.setRequestHeader ("Content-Type", "application/json");
			},
			complete : function(xhr){
				
			},
			success : function(response){
				var code = response.status.code || false;
				var result = response.result || [];
				
				if(code == 200){
					$("#global-modal").modal('hide');
					message = response.status.message || "Success";
					rs = response.status.response || "Success";
					showSuccessMessage("alert-success", message, rs);
					formData = {}
					getCustomers();
				}
			},
			error : function(xhr, error){
				message = xhr.responseJSON.status.message || "error";
				response = xhr.responseJSON.status.response || "error";
				toggleShowMessage("alert-danger", message, response);
			}
		})
		
		console.log(data);
	});
	$("body").off('click', "#btnSave").on('click', '#btnSave', async function(){
		var data = await getFormData();
		$.ajax({
			type : 'POST',
			dataType : 'json',
			url : api_url+'/create_customer.php',
			data : JSON.stringify(data),
			beforeSend : function(xhr){
				xhr.setRequestHeader ("Authorization", "Basic " + btoa(api_key + ":" + api_secret));
				xhr.setRequestHeader ("Content-Type", "application/json");
			},
			complete : function(xhr){
				
			},
			success : function(response){
				var code = response.status.code || false;
				var result = response.result || [];
				
				if(code == 200){
					$("#global-modal").modal('hide');
					message = response.status.message || "Success";
					rs = response.status.response || "Success";
					showSuccessMessage("alert-success", message, rs);
					formData = {}
					getCustomers();
				}
			},
			error : function(xhr, error){
				message = xhr.responseJSON.status.message || "error";
				response = xhr.responseJSON.status.response || "error";
				toggleShowMessage("alert-danger", message, response);
			}
		})
		
		console.log(data);
	});
	$("body").off('click', "#btnUpdate").on('click', '#btnUpdate', async function(){
		var data = await getFormData();
		$.ajax({
			type : 'PUT',
			dataType : 'json',
			url : api_url+'/update_customer.php',
			data : JSON.stringify(data),
			beforeSend : function(xhr){
				xhr.setRequestHeader ("Authorization", "Basic " + btoa(api_key + ":" + api_secret));
				xhr.setRequestHeader ("Content-Type", "application/json");
			},
			complete : function(xhr){
				
			},
			success : function(response){
				var code = response.status.code || false;
				var result = response.result || [];
				
				if(code == 200){
					$("#global-modal").modal('hide');
					message = response.status.message || "Success";
					rs = response.status.response || "Success";
					showSuccessMessage("alert-success", message, rs);
					formData = {}
					getCustomers();
				}
			},
			error : function(xhr, error){
				message = xhr.responseJSON.status.message || "error";
				response = xhr.responseJSON.status.response || "error";
				toggleShowMessage("alert-danger", message, response);
			}
		})
		
		console.log(data);
	});
	function showSuccessMessage(alertType, message, response){
		var alert = `<div class="alert ${alertType} alert-dismissible fade show" role="alert">
      		  <strong>${response}! </strong> ${message}
      		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      		    <span aria-hidden="true">&times;</span>
      		  </button>
      		</div>`;
      	$("#successMessage").html(alert);
	}
	function toggleShowMessage(alertType, message, response){
		var alert = `<div class="alert ${alertType} alert-dismissible fade show" role="alert">
      		  <strong>${response}! </strong> ${message}
      		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      		    <span aria-hidden="true">&times;</span>
      		  </button>
      		</div>`;
      	$("#err").html(alert);
	}
	function getFormData(){
		formData.id = $("input[name='id']").val();
		formData.name = $("input[name='name']").val();
		formData.email = $("input[name='email']").val();
		formData.password = $("input[name='password']").val();
		formData.gender = $('input[name=gender]:checked').val();
		formData.is_married = $("input[name=is_married]:checked").val();
		formData.address = $("textarea[name='address']").val();
		return formData;
	}
	$("body").off('click', ".view-button").on('click', '.view-button', function(){
		$(".switchbtn").hide();
		var id = $(this).attr('data-id');
		var payload = {id : id};
		$.ajax({
			type : 'GET',
			dataType : 'json',
			url : api_url+'/get_customer.php',
			data : payload,
			beforeSend : function(xhr){
				xhr.setRequestHeader ("Authorization", "Basic " + btoa(api_key + ":" + api_secret));
				xhr.setRequestHeader ("Content-Type", "application/json");
			},
			complete : function(xhr){
				
			},
			success : function(response){
				var code = response.status.code || false;
				var result = response.result || [];
				if(code == 200){
					customer = result;
				}
				var viewCustomer = $.Event( "view-customer" );
				$('body').trigger(viewCustomer);
			},
			error : function(xhr, error){
				message = xhr.responseJSON.status.message || "error";
				response = xhr.responseJSON.status.response || "error";
				toggleShowMessage("alert-danger", message, response);
			}
		})
		
	});
	$('#global-modal').on('shown.bs.modal', function (e) {
	  	resetForm();
		$("input[name='name']").trigger('focus');
		$(".switchbtn").hide();
		$(".alert").hide();
	  	var source = $(e.relatedTarget).data('source');
	  	var title = '';
	  	if(source == 'view-customer'){
	  		title = "Detail customer";
	  	}else if(source == 'add-customer'){
	  		title = "Add customer";
	  		$("#btnSave").show();
	  		writeAble();
	  	}
	  	$("#modal-title").text(title);
	})
	$('#global-modal').on('hide.bs.modal', function (e) {
	  	readAble();
	  	customer = {};
	});
	$('body').on('view-customer',function(){
	   $("input[name='id']").val(customer.id);
	   $("input[name='name']").val(customer.name);
	   $("input[name='email']").val(customer.email);
	   $("textarea[name='address']").val(customer.address);
	   var gender = $('input:radio[name=gender]');
       gender.filter('[value='+customer.gender+']').prop('checked', true);
       var is_married = $('input:radio[name=is_married]');
       is_married.filter('[value='+customer.is_married+']').prop('checked', true);
       $("#btnEdit").show();
	});
	$('body').on('edit-customer',function(){
		$("#modal-title").text("Edit Customer");
	});
	$("body").off('click', '#btnEdit').on("click", "#btnEdit", function(){
		$(".switchbtn").hide();
		$("#btnUpdate").show();
		var editCustomer = $.Event( "edit-customer" );
		$('body').trigger(editCustomer);
		writeAble();
	});
	$(".switchbtn").hide();

	function writeAble(){
		$("input[name='name']").prop('readonly', false).focus();
		$("input[name='email']").prop('readonly', false);
		$("input[name='password']").prop('readonly', false);
		$("textarea[name='address']").prop('readonly', false);
		$("input:radio[name=gender]").prop('disabled', false);
		$("input:radio[name=is_married]").prop('disabled', false);
	}
	function readAble(){
		$("input[name='name']").prop('readonly', true);
		$("input[name='email']").prop('readonly', true);
		$("input[name='password']").prop('readonly', true);
		$("textarea[name='address']").prop('readonly', true);
		$("input:radio[name=gender]").prop('disabled', true);
		$("input:radio[name=is_married]").prop('disabled', true);
	}
	function resetForm(){
		$("input[name='name']").val('');
		$("input[name='email']").val('');
		$("input[name='password']").val('');
		$("textarea[name='address']").val('');
		$("input:radio[name=gender]").prop('checked', false);
		$("input:radio[name=is_married]").prop('checked', false);
	}
	getCustomers();
	

});
