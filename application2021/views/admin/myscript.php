

<script>




/***************************************************************************************/
$('#datepicker').datetimepicker({
      autoclose: true
    })
$('.datepicker').datetimepicker({
      autoclose: true
    })
	
/*****************add active class*******************************/
$('.sidebar-nav li a').click(function(){	
$('.sidebar-nav li a ').removeClass('active');	
$(this).addClass('active');	

});

$('.data-table').DataTable( {

} );



$(document).ready(function(){
/************************** edit user ***********************************/
	function eidt_user(){
	//alert(id);
    $.ajax({
        url: "<?php echo base_url().'auth/get_user'; ?>",
        type: 'POST',
		 data: {email: $('#email').val(),password:$('#password').val(),
		 first_name:$('#first_name').val(),
		 last_name:$('#last_name').val()
		 },
		 beforeSend: function() {
    $('#loader').show();
  },
        success: function(response) {
            if (response == 'success')
            {   
			 $('#loader').hide();
				//show success message
				//$('#signup').removeClass("in");
				$('#loading').html("");
				 $('#submit').show();
				$('body').addClass("modal-open");
				$('#success').addClass("in");
				$("#success").css("display", "block");
				$("#success" ).attr( "aria-hidden", "true" );
				$('#success').delay(5000).fadeOut('slow');
				$('body').delay(5000).removeClass('modal-open');
				$(".modal-header").css("border-bottom", "0px");	
				$('.modal-backdrop').removeClass("in");			
				//$('#ErrorMessage').delay(5000).fadeOut('slow');
$('#registerForm').find("input[type=text],input[type=email],input[type=password], textarea").val("");
				
            }
           else if (response == 'error')
            {   
		
			$('#loading').html("");
			 $('#submit').show();
			$('#signup_error_div').html('Error ! Some thing went wrong');
			$('#signup_error_div').removeClass('hide');
			$('#signup_error_div').addClass('show');
			$('.alert').hide('slow');
            }
			else if (response == 'exist')
            {   
			$('#loading').html("");
				//Erorr  message
				$('.alert-warning').removeClass('hide');
				 $('#submit').show();
				$('.alert-warning').html('User Aleady Exist !');
            }else  
            {   
			 $('#submit').show();
			$('#loading').html("");
				$('.alert-warning').html(response);
			$('#signup_error_div').removeClass('hide');
			
            }
           }
	 });
	}
	
	
});

	function changeUserStatus(id,status,tblName){
				var rowid= "div_status_"+id;
				var status;
				var tblName;
				var changed;
				if(status==1){
					changed=0;
					}
	else{
		changed=1;
		}
    $.ajax({
        url: "<?php echo base_url().'auth/changeUserStatus'; ?>",
        type: 'POST',
		 data: {id:id,status:status,tblName:tblName},
		dataType : "json",
        success: function(response) {
		   if(response.chaged == true){
			var q="'";
			 if(response.status=="Inactive"){
				 mehtml = '<a href="javascript:void(0);" onclick="changeUserStatus(\''+id+'\',\''+changed+'\',\''+tblName+'\')"><span class="label label-danger">Suspended</span></a>';
				 }
				 else{
					 mehtml = '<a href="javascript:void(0);" onclick="changeUserStatus(\''+id+'\',\''+changed+'\',\''+tblName+'\')"><span class="label label-success">Active</span></a>';
					 }
			 
			 $("#"+rowid).html(mehtml);
			 
			   }
          
           }
	 });
	  } 
function changeStatus(id,status,tblName){
				var id;
				var rowid= "div_status_"+id;
				var status;
				var tblName;
				var changed;
				if(status==1){
					changed=0;
					}
	else{
		changed=1;
		}
    $.ajax({
        url: "<?php echo base_url().'crud/changeStatus'; ?>",
        type: 'POST',
		 data: {id:id,status:status,tblName:tblName},
		dataType : "json",
        success: function(response) {
		   if(response.chaged == true){
			var q="'";
			 if(response.status=="Inactive"){
				 mehtml = '<a href="javascript:void(0);" onclick="changeStatus(\''+id+'\',\''+changed+'\',\''+tblName+'\')"><span class="label label-danger">Inactive</span></a>';
				 }
				 else{
					 mehtml = '<a href="javascript:void(0);" onclick="changeStatus(\''+id+'\',\''+changed+'\',\''+tblName+'\')"><span class="label label-success">active</span></a>';
					 }
			 
			 $("#"+rowid).html(mehtml);
			 
			   }
          
           }
	 });
	 } 
function changeFieldStatus(id,status,tblName){
				var id;
				var rowid= "validated_div_status_"+id;
				var status;
				var tblName;
				var changed;
				if(status==1){
					changed=0;
					}
	else{
		changed=1;
		}
    $.ajax({
        url: "<?php echo base_url().'crud/changeFieldStatus'; ?>",
        type: 'POST',
		 data: {id:id,status:status,tblName:tblName},
		dataType : "json",
        success: function(response) {
		   if(response.chaged == true){
			var q="'";
			 if(response.status=="Inactive"){
				 mehtml = '<a href="javascript:void(0);" onclick="changeFieldStatus(\''+id+'\',\''+changed+'\',\''+tblName+'\')"><span class="label label-danger">NO</span></a>';
				 }
				 else{
					 mehtml = '<a href="javascript:void(0);" onclick="changeFieldStatus(\''+id+'\',\''+changed+'\',\''+tblName+'\')"><span class="label label-success">YES</span></a>';
					 }
			 
			 $("#"+rowid).html(mehtml);
			 
			   }
          
           }
	 });
	 } 
function get_view(view){
	
		$.ajax({
        url: view,
        type: 'GET',
		beforeSend: function() {
		$('#loader').show();
		$('.tooltip').hide();
		},
        success: function(response) {
			App.init();
		FormsComponents.init();
			setTimeout(function(){
				$('#loader').hide();
				
				},100);  
			setTimeout(function(){
				$('#loader').hide();
				$('.mce-notification').addClass('hidden');
				},500);  
				
					

			if (response.message == 1)
            {   
			$('#page-content').html(response);
			
			App.init();
            }
           else if (response.message ==0)
            {   
			showAlert('error');
            }
			else  
            {   
			$('#page-content').html(response);
				//alert(response);
			
            }
           }
	 });

	}
/*
| -------------------------------------------------------------------------
| Users.
| -------------------------------------------------------------------------
| All user functions.
*/		
function getUser(user_id){
$.ajax({
url : "<?php echo base_url().'auth/get_user'; ?>",
type: 'POST',
data: {id: user_id},
dataType: "json",
success: function(response) {
var user_type = response.user.user_type;
var admin_selectd='';
var member_selectd='';
if(user_type == <?php echo ADMIN_USER; ?> ){
admin_selectd='selected="selected"';
member_selectd='';
}
else {
member_selectd='selected="selected"';
admin_selectd='';
}
if (response.message == 1){  

//populate in  user field 	
$('#first_name').val(response.user.first_name);
$('#last_name').val(response.user.last_name);
$('#email').val(response.user.email);

$('#title').val(response.user.title);
$('#password').val('');
$('#user_id').val(response.user.id);
$('#phone').val(response.user.phone);
$('#mobile').val(response.user.mobile);
$('#start_date').val(response.user.start_date);
$('#end_date').val(response.user.end_date);
$('#specialty').val(response.user.specialty);
$('#licence').val(response.user.licence);
$('#web').val(response.user.web);
$('#twitter').val(response.user.twitter);
$('#url').val(response.user.url);
$('#fb').val(response.user.fb);
$('#images_div').html(response.img_data);
$('#qrcode_div').html(response.qrcodeData);

//alert(response.qrcodeData);
$('#id').val(response.user.id);

$('#user_type_hidden').val(user_type);
$("#user_type .user_type"+response.user.user_type).attr("selected","selected");
$("#city_id .city_id"+response.user.city_id).attr("selected","selected");

$("#cat_id"+response.parent_id).attr("selected","selected");
$("#sub_cat_divs").html(response.option1);
//$(".machine_type_"+response.user.machine_type).attr("selected","selected");

//	var str = response.user.data_to_be_gathered; // a string of checkboxes
// call fucntion to checked all checkbox on base of their values
//get_checkbox_checked(str); //e.g str ='filters_only,hydraulic_oils';
//populate in  user location
/*	$('#address').val(response.location.address);
$('#zipcode').val(response.location.zipcode);
$('#country').val(response.location.country);
$('#city').val(response.location.city);
$('#state').val(response.location.state);
*/

$('#edit_user_Modal').modal('show');
}
else if (response.message == 0)
{   alert('Error : Some thing went wrong');

}
else  
{   
alert('Error : Some thing went wrong');
}
}
});


}                             
function validateForm() {

var allLetters = /^[a-zA-Z,.]+$/;
var letter = /[a-zA-Z]/;
var number = /[0-9]/;

var firstName = document.form_update_user.first_name.value;
var last_name = document.form_update_user.last_name.value;
var email = document.form_update_user.email.value;
var password = document.form_update_user.password.value;

var invalid = [];

/* if (!allLetters.test(firstName)) {
invalid.push("First name must me letter<br>");
}

if (!allLetters.test(last_name)) {
invalid.push("Last Name must me letter<br>");
}
*/
/*if (email.indexOf("@") < 1 || email.lastIndexOf(".") < email.indexOf("@") + 2 || email.lastIndexOf(".") + 2 >= email.length) {
invalid.push("Please provide valid email<br>");
}*/

if(password!=''){
if (password.length < 8 ) {
invalid.push("Password  minimum length must be 8 <br>");
}if (password.length < 8 || !letter.test(password) || !number.test(password)) {
invalid.push("Password  must be contain letter and numbers ");
}
}

if (invalid.length != 0) {
//  alert("Please provide response: \n" + invalid.join("\n"));

$.alert({
title: 'Validation!',
content: 'Please provide the following: <br>'+invalid,
btnClass: 'btn-primary',
});        return false;
}

return true;}

function validateProfile() {
var allLetters = /^[a-zA-Z]+$/;
var letter = /[a-zA-Z]/;
var number = /[0-9]/;

var name = $('#side_profile_name').val();
var email = $('#side_profile_email').val();
var mobile = $('#side_profile_mobile').val();
var password =$('#side_profile_password').val();
var password_confirm =$('#side_profile_password_confirm').val();
alert(name);
var invalid = [];

if (!letter.test(name)) {
invalid.push("Name must me letter<br>");
}
if (!number.test(mobile)) {
invalid.push("Mobile must me number<br>");
}
if (password != password_confirm) {
invalid.push("Password Mismatch<br>");
}



if (email.indexOf("@") < 1 || email.lastIndexOf(".") < email.indexOf("@") + 2 || email.lastIndexOf(".") + 2 >= email.length) {
invalid.push("Please provide valid email<br>");
}

if(password!=''){
if (password.length < 8 ) {
invalid.push("Password  minimum length must be 8 <br>");
}if (password.length < 8 || !letter.test(password) || !number.test(password)) {
invalid.push("Password  must be contain letter and numbers ");
}
}

if (invalid.length != 0) {
//  alert("Please provide response: \n" + invalid.join("\n"));

$.alert({
title: 'Validation!',
content: 'Please provide the following: <br>'+invalid,
btnClass: 'btn-primary',
});        return false;
}

return true;
}



	function updateUser(){
		
	if(!validateForm()){
	return false;
	}
	
	else{
		var inputFile = $('input#file');
		 var filesToUpload = inputFile[0].files;
		 var formData = new FormData();
		// make sure there is file(s) to upload
		if (filesToUpload.length > 0) {
			// provide the form data
			// that would be sent to sever through ajax
			for (var i = 0; i < filesToUpload.length; i++) {
				var file = filesToUpload[i];
				formData.append("file[]", file, file.name);				
			}
	}
	formData.append("qrcode", document.getElementById('qrcode').files[0]);

	var other_data = $('#form_update_user').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
	formData.append('id',$('#id').val());
	$.ajax({
	url: "<?php echo base_url().'auth/updateUser'; ?>",
	type: 'POST',
	data: formData,
	dataType: "json",
	processData: false,
	contentType: false,
	success: function(response) {
	//alert(response.user.user_type);
	if (response.status == 1)
		{   
		if($('#action').val()=='user_acc_update'){
		$('#infoMessage').addClass('alert-success').removeClass('hidden');
		$('#images_div').html(response.images);
		$('#add_images_wrap').addClass('hidden');
		$('#infoMessage').html(response.message);
		setTimeout(function(){
		$('#infoMessage').addClass('hidden');
		},3000);
		}
		else{
		$('#infoMessage').addClass('alert-success').removeClass('hidden');
		$('#infoMessage').html(response.message);
		setTimeout(function(){
			$('#infoMessage').addClass('hidden');
		$('#edit_user_Modal').modal('hide');
		$('#'+response.row_id).html(response.rowdata);
		$('tr').removeClass('just_edited');
		$('#'+response.row_id).addClass('just_edited');
		
		
		},1000);
		/*setTimeout(function(){
		$('#edit_user_Modal').modal('hide');
		var user_type = $('#user_type').val();
		//alert(user_type);
		if(user_type==0){
			get_view('<?php echo base_url(); ?>auth/view_users');
		}
		else{
			get_user_view(user_type);
		}
		},2000);*/
		}
		
		}
	else if (response.status ==0)
	{   
	$('#infoMessage').addClass('alert-danger').removeClass('hidden');
	$('#infoMessage').html(response.message);
	document.getElementById("qrcode").value = "";
	setTimeout(function(){
	$('#infoMessage').addClass('hidden');
	},3000);
	}
	else  
	{   
	
	$('#infoMessage').addClass('alert-success').removeClass('hidden');
	$('#infoMessage').html(response.message);
	
	
	}
	}
	});
	
	}
	
	}                             
	function updateProfile(){
	if(!validateProfile()){
	return false;
	}
	
	else{
	$.ajax({
	url: "<?php echo base_url().'auth/updateProfile'; ?>",
	type: 'POST',
	data: $("#form_profile").serialize(),
	dataType: "json",
	success: function(response) {
	//alert(response.user.user_type);
	if (response.status == 1)
	{   
	
	$('#infoMessageProfile').addClass('alert-success').removeClass('hidden');
	$('#infoMessageProfile').html(response.message);
	setTimeout(function(){
		$('#infoMessageProfile').addClass('hidden');
	},3000);
	
	}
	else if (response.status ==0)
	{   
	$('#infoMessageProfile').addClass('alert-danger').removeClass('hidden');
	$('#infoMessageProfile').html(response.message);
	
	}
	else  
	{   
	
	$('#infoMessageProfile').addClass('alert-success').removeClass('hidden');
	$('#infoMessageProfile').html(response.message);
	
	
	}
	}
	});
	
	}
	
	}   
	                          
	
	function create_user(){
		var inputFile = $('input#file');
		 var filesToUpload = inputFile[0].files;
		 var formData = new FormData();
		// make sure there is file(s) to upload
		if (filesToUpload.length > 0) {
			// provide the form data
			// that would be sent to sever through ajax
			for (var i = 0; i < filesToUpload.length; i++) {
				var file = filesToUpload[i];
				formData.append("file[]", file, file.name);				
			}
	}
	
	
	var other_data = $('#form-register').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
	    $.ajax({
        url: "<?php echo base_url().'auth/save_user'; ?>",
        type: 'POST',
		 data: formData,
		 dataType: "json",
		   processData: false,
    contentType: false,
	beforeSend: function() {
			$('#loader').removeClass('hidden');
			
			},
        success: function(response) {
			$('#loader').addClass('hidden');
			//alert(response.user.user_type);
			if (response.status == 1)
            {   
			showAlert(response.message,'Success','green')
setTimeout(function(){
				window.location=response.redirect;
				},2000);
            }
			
           else if (response.status ==2)
            {  
			showAlert(response.message,title='Success','green');
			
			setTimeout(function(){
				window.location=response.redirect;
				},2000);
			
			
			
            }
         else if (response.status ==0)
            {  
			showAlert(response.message,title='Error','red');
			
            }
        
			else  
            {   
			var text =  response.message;
				text = text.replace(/<[^>]+>/g, '');
			showAlert(text,'validation Error','red')
			
            }
           }
	 });


	}                             



	function passwordMatched(node) {
	 var password= document.getElementById("password").value;
	 var confirm_password= node;
	 if(password !=''){
		if(password!= confirm_password) {
return 0 ;
		}
		else{
			return 1;
		}	

  }
}
      
	  
 function get_checkbox_checked(str){
	var stringFromServer = str;
	var arrayOfValues = stringFromServer.split(",");
	var $checkboxes = $("input[type=checkbox]");
	$checkboxes.each(function(idx, element){
	if(arrayOfValues.indexOf(element.value) != -1){
	element.setAttribute("checked", "checked");
	}
	else{
	element.removeAttribute("checked");
	}
	});
}
 function language(lang_code){
	// alert(lang_code);
	 	    $.ajax({
        url: "<?php echo base_url().'crud/changeLang'; ?>",
        type: 'POST',
		 data:{id: lang_code},
		 dataType: "json",
        success: function(response) {
			;
			//alert(response.user.user_type);
			if (response.status == 1)
            {   
		
		window.location.href = "<?php echo base_url(); ?>dashboard";  
            }
          
			else  
            {   
			alert("Some Thing wrong");
			
            }
           }
	 });
 }
function copyToClipBoard(target){
	//Console.clear;
	
	var clipboard = new Clipboard('.copy-button', {
    target: function() {
        return document.querySelector('#'+target);
    }
});

clipboard.on('success', function(e) {
	document.getElementById('audioTag').play();
$("#alert-center").html('Coppied to Clipboard ! <i class="gi gi-bell"></i>' );
    //console.log(e);
});

clipboard.on('error', function(e) {
$("#alert-center").html(e);
});

$("#alert-center").show();
	setTimeout(function(){
$("#alert-center").hide('slow');
				},3000);		


	}
/*
*------------------------------------------------------
Generic functions
-------------------------------------------------------
**/
function is_valid_number(val) {
   var numbers = /^[0-9]+$/;  
      if(val.match(numbers))  
      {  
     
      return true;  
      }  
      else  
      {  
      return false;  
      }  
    
}
 function deleteRecord(id,table){
	     $.confirm({
    title: 'Confirmation!',
    content: 'Are you sure to delete!',
	animation: 'zoom',
    closeAnimation: 'scale',
	autoClose: 'cancel|5000',
	type: 'red',
	buttons: {
        deleteUser: {
            text : 'Yes',
			btnClass: 'btn-primary',
            action: function () {
                // if user click ok the row will be deleted by the following code
				//ajax call to delete	
				$.ajax({
				url: "<?php echo base_url().'crud/delete'; ?>",
				type: 'POST',
				data: {id:id,table:table},
				dataType: "json",
				success: function(response) {
					$(".ui-item").hide();
				if (response.status == 1)
				{   
				
				$("#row_"+id).hide('slow');
				}
				else if (response.status ==0)
				{  
				$.alert('Error',':You could not delete');
				}
				else  
				{  
				$.alert('Error',response);
				
				}
				}
				});


            }
        },
        cancel: function () {
			text : 'Yes'
        },
    }
   
	});  
	} 

function deleteItem(id,controllername){
	
	     $.confirm({
		title: 'Confirmation!',
		content: 'Are you sure to delete!',
		animation: 'zoom',
		closeAnimation: 'scale',
		autoClose: 'cancel|5000',
		type: 'red',
	     buttons: {
        deleteUser: {
            text : 'Yes',
			btnClass: 'btn-primary',
            action: function () {
                // if user click ok the row will be deleted by the following code
				//ajax call to delete	
				$.ajax({
				url: "<?php echo base_url();?>"+controllername+'/delete',
				type: 'POST',
				data: {id:id},
				dataType: "json",
				success: function(response) {
					$(".ui-item").hide();
				if (response.status == 1)
				{   
				
				$("#row_"+id).hide('slow');
				}
				else if (response.status ==0)
				{  
				$.alert('Error',':You could not delete');
				}
				else  
				{  
				$.alert('Error',response);
				
				}
				}
				});


            }
        },
        cancel: function () {
			text : 'Yes'
        },
    }
   
	});  
} 	
	
	
 function deleteCat(id){
	     $.confirm({
    title: 'Confirmation!',
    content: 'Are you sure to delete!',
	animation: 'zoom',
    closeAnimation: 'scale',
	autoClose: 'cancel|5000',
	type: 'red',
	buttons: {
        deleteUser: {
            text : 'Yes',
			btnClass: 'btn-primary',
            action: function () {
                // if user click ok the row will be deleted by the following code
				//ajax call to delete	
				$.ajax({
				url: "<?php echo base_url().'cat/delete'; ?>",
				type: 'POST',
				data: {id:id},
				dataType: "json",
				success: function(response) {
					$(".ui-item").hide();
				if (response.status == 1)
				{   
				
				$("#row_"+id).hide('slow');
				}
				else if (response.status ==0)
				{  
				$.alert('Error',':You could not delete');
				}
				else  
				{  
				$.alert('Error',response);
				
				}
				}
				});


            }
        },
        cancel: function () {
			text : 'Yes'
        },
    }
   
	});  
	} 
	
function noData(Table)// This function will give no data message with number of column because datatable have issue and does not support colspan attribute
{ 
    var ColCount = 0;
    $('#'+Table).find("tr").eq(0).find("th,td").each(function ()
    {
        ColCount += $(this).attr("colspan") ? parseInt($(this).attr("colspan")) : 1;
    });
	
	$row = $('<tr><td>No data!</td>');
	for(var j=1; j<ColCount; j++)
	{
	$row.append("<td>&nbsp;</td>");
	}
	$row.append("</tr>");
	
	$('#'+Table +' tbody').html($row);
   
}

        function GetColumnCount(Table)
{
    var ColCount = 0;
    $('#'+Table).find("tr").eq(0).find("th,td").each(function ()
    {
        ColCount += $(this).attr("colspan") ? parseInt($(this).attr("colspan")) : 1;
    });

    return ColCount;
}
 function autoComplete(txt_elmnt,thisfields,table){
	 	    $.ajax({
        url: "<?php echo base_url().'crud/get'; ?>",
        type: 'POST',
		 data:{thisfields: thisfields,table: table},
		 dataType: "json",
        success: function(response) {
			
			if (response.status == 1)
            {  
			var dataArr = JSON.stringify(response.data);
			var arr = new Array();
			var sourceTags = new Array();
			
			var arr = JSON.parse(dataArr);
			 $.each(arr, function (field, val) {
				sourceTags.push(val.title);
				});
				
			$("#"+txt_elmnt).autocomplete({
			source: sourceTags,
			autoFocus:true
			});
			$('.ui-widget').show();	
		     }
          
			else  
            {   
			alert("Some Thing wrong");
			
            }
           }
	 });
 }
 function duplicate(tableName,primary_key_field,primary_key_val,view){
	 	   
	 
	 
	  $.confirm({
    title: 'Confirmation!',
    content: 'Are you sure to make a duplicate of this record!',
	animation: 'zoom',
    closeAnimation: 'scale',
	autoClose: 'cancel|5000',
	type: 'green',
	buttons: {
        deleteUser: {
            text : 'Yes',
			btnClass: 'btn-primary',
            action: function () {
                // if user click ok the row will be deleted by the following code
						 $.ajax({
        url: "<?php echo base_url().'crud/duplicate'; ?>",
        type: 'POST',
		 data:{table:tableName,primary_key_field: primary_key_field,primary_key_val: primary_key_val},
		 dataType: "json",
        success: function(response) {
			
			if (response.status == 1)
            {  
		     $.alert(' Successfully Duplicated!','Alert');
			 //get_view('<?php echo base_url(); ?>'+view);
		     }
          
			else  
            {   
			alert("Some Thing wrong");
			
            }
           }
	 });

            }
        },
        cancel: function () {
			text : 'No'
        },
    }
   
	});
 }
 /****************************************************************/
 function showAlert(msj,title,type){
	 msj = msj.replace(/<[^>]+>/g, '');
	$.alert({
	title: title,
	content: '<p>'+msj+'</p>',
	type: type,
	icon: 'glyphicon glyphicon-heart',
	closeIcon: true,
	animation: 'rotate',
});
	}
function is_valid_number(val) {
   var numbers = /^[0-9]+$/;  
      if(val.match(numbers))  
      {  
     
      return true;  
      }  
      else  
      {  
      return false;  
      }  
    
}
 /****************************************************************/
 
  function deleteImage(id){
	 $.confirm({
		title: 'Confirmation!',
		content: 'Are you sure to delete!',
		animation: 'zoom',
		closeAnimation: 'scale',
		autoClose: 'cancel|5000',
		type: 'red',
		buttons: {
		deleteUser: {
		text : 'Yes',
		btnClass: 'btn-primary',
		action: function () {
		//ajax call to delete	
		$.ajax({
		url: "<?php echo base_url().'crud/deleteImage'; ?>",
		type: 'POST',
		data: {id:id},
		dataType: "json",
		success: function(response) {
		if (response.status == 1){   
			$(".img_wrap_"+id).hide('slow');
			}
		else if (response.status ==0){  
			showAlert('Error :You could not delete');
		}
		else{   
			showAlert(response);
		}
		}
		});
		}
		},
		cancel: function () {
		text : 'Yes'
		},
		}
		
		});  
	}                             
	/*********************************************************/
 
 	   function deleteImage(id,table){
	 $.confirm({
		title: 'Confirmation!',
		content: 'Are you sure to delete!',
		animation: 'zoom',
		closeAnimation: 'scale',
		autoClose: 'cancel|5000',
		type: 'red',
		buttons: {
		deleteUser: {
		text : 'Yes',
		btnClass: 'btn-primary',
		action: function () {
		//ajax call to delete	
		$.ajax({
		url: "<?php echo base_url().'crud/deleteImage'; ?>",
		type: 'POST',
		data: {id:id,table:table},
		dataType: "json",
		success: function(response) {
		if (response.status == 1){   
			$(".img_wrap_"+id).hide('slow');
			}
		else if (response.status ==0){  
			showAlert('Error :You could not delete');
		}
		else{   
			showAlert(response);
		}
		}
		});
		}
		},
		cancel: function () {
		text : 'Yes'
		},
		}
		
		});  
	}                             
/**************************************************************************/
function open_edit_image_form(id){ 	
// will get single entitty	and show its image in modal
/*if($('#edit_image_wrap').hasClass('shown')){
$('#edit_image_wrap').removeClass('shown');
$('#edit_image_wrap').hide('slow');
$('#form_edit_image').find("input[type=text],input[type=email],input[type=file], textarea").val("");

}
else{*/
	$('#edit_image_wrap').show('slow');
	$('#edit_image_wrap').addClass('shown');
		    $.ajax({
			url: "<?php echo base_url().'crud/edit'; ?>",
			type: 'POST',
			data: {id:id,table:'<?php echo TBL_PAGES_CONTENT_IMAGES ?>'},
			dataType: "json",
			success: function(response) {
			if (response.status == 1)
            {   
			//populating data in form field
			// 	 	
			App.init(); 	 	 	 	 	 	 	
			var dataArr = response.data;
				$.each(dataArr, function (field, val) {
					$('#form_edit_image #'+field).val(val);
				});
				$('#edit_img_id').val(id);
				var src ='<?php echo base_url()?>uploads/'+response.data.image;
				
				$('#edit_small_image_div').html('<img src="'+src+'" width="50">');
				$('#edit_image_hidden').val(response.data.image);
				
			}
			else  
			{   
			showAlert('response error');
			}
			}
		});

	
	
//}
	   
	}
/**************************************************************************/
function getImage(id,tbl){ 	// will get single entitty	and show its image in modal

	$('#edit_image_wrap').show('slow');
	$('#edit_image_wrap').addClass('shown');
		    $.ajax({
			url: "<?php echo base_url().'crud/edit'; ?>",
			type: 'POST',
			data: {id:id,table:tbl},
			dataType: "json",
			success: function(response) {
			if (response.status == 1)
            {   
			//populating data in form field
				var dataArr = response.data;
				$.each(dataArr, function (field, val) {
					$('#form_edit_image #'+field).val(val);
				});
				$('#edit_img_id').val(id);
				var src ='<?php echo base_url()?>uploads/'+response.data.image;
				
				$('#edit_small_image_div').html('<div class="col-xs-2"><img src="'+src+'" class="pull-left" width="100"></div>');
				$('#edit_image_hidden').val(response.data.image);
				
			}
			else  
			{   
			showAlert('response error');
			}
			}
		});

	
	
//}
	   
	}
	
	
	
/**************************************************************************/

function save_image(e){
	
		var inputFile = $('input#edit_image');
		 var filesToUpload = inputFile[0].files;
		 var formData = new FormData();
		 
		// make sure there is file(s) to upload
		if (filesToUpload.length > 0) {
			// provide the form data
			// that would be sent to sever through ajax
			for (var i = 0; i < filesToUpload.length; i++) {
				var file = filesToUpload[i];
				formData.append("file[]", file, file.name);				
			}
	}
	var other_data = $('#form_edit_image').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
	
	// ajax start
		    $.ajax({
			type: "POST",
			url: "<?php echo base_url().'crud/update_content_management_image'; ?>",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#loader_box').removeClass('hidden');
			//$('#form_sample .btn_au').addClass('hidden');
			},
				success: function(data) {
				$('#loader_box').addClass('hidden');
				$('#form_sample #loader_box').removeClass('hidden');
				var obj = jQuery.parseJSON(data);
				if (obj.status == 1)
				{   
				var src  =obj.image;
				if (src!=0){
					var src ='<?php echo base_url()?>uploads/'+obj.image;
				$("#img_"+obj.id).attr("src",src);
				//alert(obj.description);
				$("#description"+obj.id).text(obj.description);
				$("#edit_small_image_div img").attr("src",src);
				}
					
				setTimeout(function(){
				$('#form_sample #loader_box').addClass('hidden');	
				$('#edit_image_wrap').hide('slow');
				},2000);
				}
				
				
			}
	 });


	}
	/////////////////////////////////////////////////////
 function hide_this(el){
					$("#"+el).hide('slow');
					}
					
				////////////////////////////////////////
		
function getSubCategories(parentId,level){
			if(parentId=='none')
				return false;
				else
					    
						var parentId;
						var level;
						 var newLevel = parseInt(level)+parseInt(1);
						var catLevel = document.getElementById('sub_category_level').value =newLevel;
						
		  $.ajax({
			url: "<?php echo base_url().'categories/getSubCategories'; ?>",
			type: 'POST',
			data: {id:parentId,level:level},
			dataType: "json",
			success: function(response) {
			if (response.status == 1)
            {   
			//populating data in form field
			if(level==0){
			$('#sub_cat_divs').html('<div id="sub_block"></div> ');
			$('#sub_block').append(response.data);
				
			}
			else{
				$('#sub_block').append(response.data);
				}
			}
			else  
			{   
			if(level==0){
			$('#sub_cat_divs').html('<div id="sub_block"></div> ');
			$('#sub_block').append(response.data);
				
			}
			else{
				$('#sub_block').append(response.data);
				}
			}
			}
		});
						
						
}
//////////////

    </script>