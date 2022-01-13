<?php
/*
if($mydata->num_rows()>0){
	echo 'data has rows. '.$mydata->num_rows();
	
	//printer();
	$data=$mydata->result_array();
	foreach($data as $record){ ?>
		
			<a href="home/edit/<?=$record['id']?>"> <?=$record['name']; ?></a> <hr>
	<?php }

}else{
	echo 'No record found';
}

//echo '<hr><pre>';
//print_r($mydata);
*/



?>

<form id="form_add_update">
<input id="name_id" name="name" placeholder="Name" >
<input id="email_id" name="email" placeholder="Email" >
<input type="button" value="Insert" onClick="insert()"> 
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script type="text/javascript">

function insert(){
	
	 var formData = new FormData();
	
	var other_data = $('#form_add_update').serializeArray();
	console.log(other_data);
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });
	   $.ajax({
			type: "POST",
			url: "<?php echo base_url().'home/save'; ?>",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'JSON',
			beforeSend: function() {
			$('#loader').removeClass('hidden');
		//	$('#form_add_update .btn_au').addClass('hidden');
			},
			success: function(data) {
				if(data.status=200){
					alert(data.mymessage);
				}
			//$('#loader').addClass('hidden');
			//$('#form_add_update .btn_au').removeClass('hidden');
		
			
           }
	 });

}

</script>