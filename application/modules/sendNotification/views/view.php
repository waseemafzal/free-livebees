<?php getHead(); ?>
   
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        NOTIFICATIONS
        
      </h1>
      <ol class="breadcrumb">
     <!--<a class="btn btn-info fff pull-right" href="slider/add" class="btn btn-sm btn-su"> <i class="fa fa-plus"></i> Add Slide</a>
    -->      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              
            </div>
            <!-- /.box-header -->
                        <div class="box-body">
                         <div class="col-xs-12"><div class="alert hidden"></div></div>
<form id="form_add_update" name="form_add_update" role="form">
<div class="col-xs-12 col-md-12">
                      <label >  Enter Message</label>
<textarea class="form-control" rows="5"  name="description"></textarea>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="col-xs-12 col-md-12">    
                     <button type="submit" class="btn btn-info pull-right">Send </button>
                       </div>
</form>
<div class="clearfix">&nbsp;</div>
                <table id="post_table" class="table table-striped table-bordered   responsive">
    <thead>
    <tr>
    
    <th><input type="checkbox" id="checkAll" /> check All</th>       
    
    <th>Student Picture </th>       
        <th>StudentName </th>
        <th>ParentName </th>
        <th>parentEmail </th>
         
    </tr>
    </thead>
    <tbody>
    <?php
	if(!empty($data->result())){
	foreach ($data->result() as $row){
		
		?>
		<tr id="row_<?php echo$row->id;?>">
         <td><input type="checkbox" id="device_id<?php echo$row->id;?>" name="device_ids[]" value="<?php echo $row->device_id;?>" /></td>
        
        <td class="center ">
        
		<?php 
		$src=base_url().'uploads/'.$row->image;
		if(empty($row->image)){
		$src=base_url().'uploads/noimg.png';
		}
		echo '<a class="fancybox" href="'.$src.'"><img  src="'.$src.'" width="100" ></a>';	
		 ?>    
         </td>
        <td><?php echo $row->studentName;?></td>
        <td><?php echo $row->parentName;?></td>
        <td><?php echo $row->parentEmail;?></td>
        
       
        
    </tr>
    
		<?php }
	}
		
	?>
    
    </tbody>
    </table>
                    
                    
                
                </div>
          
          </div>
          
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
   

  <?php  getFooter(); ?>
<script>
$('#post_table').dataTable( {
  "ordering": false
} );

$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});

	 $('#form_add_update').on("submit",function(e) {
		e.preventDefault();
		 var formData = new FormData();
		
 var device_ids = [];
        $("[name='device_ids[]']:checked").each(function (i) {
			
        device_ids[i] = $(this).val();
    });
	var other_data = $('#form_add_update').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
	formData.append('device_ids',device_ids);
	
	
	
		// ajax start
		    $.ajax({
			type: "POST",
			url: "<?php echo base_url().'sendNotification/send'; ?>",
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
			$('#loader').addClass('hidden');
			$('#form_add_update .btn_au').removeClass('hidden');
			//alert(data.status);
			//var obj = jQuery.parseJSON(data);
            if (data.status == 1)
            {   
				$(".alert").addClass('alert-success');
				$(".alert").html(data.message);
				$(".alert").removeClass('hidden');
				setTimeout(function(){
				$(".alert").addClass('hidden');
				$('#form_add_update')[0].reset();
				location.reload();
				},3000);
            }
           else if (data.status ==0)
            {  
			$(".alert").addClass('alert-danger');
				$(".alert").html(data.message);
				$(".alert").removeClass('hidden');
				setTimeout(function(){
				
				},3000);
            }
			else if (data.status == 2)
            {   
			$(".alert").addClass('alert-success');
				$(".alert").html(data.message);
				$(".alert").removeClass('hidden');
				setTimeout(function(){
				location.reload();
				},1000);
            }
			else if (data.status == "validation_error")
            {   
			$(".alert").addClass('alert-warning');
				$(".alert").html(data.message);
				$(".alert").removeClass('hidden');
				
            }
			
           }
	 });

	//ajax end    
    });


</script>
  
  
  
  