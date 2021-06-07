   // waseem code start
	  
	  /***********************/
	   $('#formskillsubmitreply_678768_083__nonce_330987b').on("submit",function(e) 
	{   
	     $("#pro").show();
			e.preventDefault();	
			var formData = new FormData();
			var other_data = $('#formskillsubmitreply_678768_083__nonce_330987b').serializeArray();
				$.each(other_data,function(key,input)
				{
					formData.append(input.name,input.value);
				}
			);   
	/**********multiple files**************/		
			
			var inputFile = $('input#file');
		 var filesToUpload = inputFile[0].files;
	if (filesToUpload.length > 0) {
			for (var i = 0; i < filesToUpload.length; i++) {
				var file = filesToUpload[i];
				formData.append("file[]", file, file.name);				
			}
	}
	
	/**********multiple files**************/
	var userId = localStorage.getItem('userId');
var userFuckerName= localStorage.getItem('userFuckerName');
if(userId !=''){
formData.append("userId", userId);
formData.append("name", userFuckerName);
			
}
	
			$.ajax({
			type: "POST",
			url: "https://geonest.org/map/maplocationsave",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'JSON',
			beforeSend: function() {
			$('#loader').removeClass('hidden');
		  //	$('#form_skill_squared_kjnsdjnhsdjs87sd8s7d8s7d .btn_au').addClass('hidden');
			},
			success: function(data) {
				alert("Reported Successfully!");
                                $("#formskillsubmitreply_678768_083__nonce_330987b")[0].reset();
                                $("#pro").hide();
								
				//$("#pro").hide();
                            
                               // window.open("https://infonest.goodbarber.app/");
			
			//return false;
           }
	 });

	//ajax end    
    });
	  
/*******************/
function gbDidSuccessGetLocation ( lat, lng){
//alert('your lat is:'+lat+'your long is:'+long);
 var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
				//	alert(status);
				//	alert("ok");
                    if (results[1]) {
                   //     alert("Location: " + results[1].formatted_address);
					var localAddress = results[1].formatted_address;
					 $("#address").val(localAddress);
checkLogedin();
					// alert(results[1].formatted_address);
					

                    }
                }
            });
}
function gbDidFailGetLocation ( errorMessage ){
//alert(errorMessage);
}
function checkLogedin(){
var userId = localStorage.getItem('userId');
		if(isNaN(userId)){
location.reload();
}
}

$(document).ready(function(){
    $('.tooltipped').tooltip();
//gbAuthenticate();
setTimeout(function(){
	// get local location
gbGetLocation();



// set local id
var LocaluserName = localStorage.getItem("LocaluserName");
if(LocaluserName==null){
	var d = new Date();
  var time = d.getTime();
localStorage.setItem("LocaluserName", time);
}
else if(LocaluserName==''){
	var d = new Date();
  var time = d.getTime();
localStorage.setItem("LocaluserName", time);
	}
},3000);

  });
