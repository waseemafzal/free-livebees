<?php getHead(); ?>
   <style>
    .box-primary {
	margin:5px 2px;	
		}
    .col-md-6 img{
		width: 200px;
    height: 200px;
	}
	div.center{
background-color: #fff;
    border-radius: 5px;
    box-shadow: -2px 2px 7px 1px;
    left: 0;
    margin-left: -100px;
    padding: 11px;
    position: absolute;
    top: 10%;
    width: 50%;
}

   </style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      App  Settings
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
            <div class="col-xs-12">
              <p><i class="fa fa-info"></i> This page hold the setting of website logo , home page top banner ,footer message, email and contact info on contact form </p></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <form id="form_add_update" name="form_add_update" role="form">
             <div class="col-xs-12"><div class="alert hidden"></div></div>
                    <div class="form-group wrap_form">
                   
                     <div class="clearfix">&nbsp;</div>
                  
					<div class="col-xs-12 col-md-3 hidden">
                      <label >  Status</label>
                      <?php if(isset($row)){ 
					  $openSelect='';
					  $closeSelect='';
					  if($row->status==1){
						 $openSelect='selected="selected"'; 
						 }
					  if($row->status==0){
						 $closeSelect='selected="selected"'; 
						 }
					  } ?>
<select class="form-control" name="status">
<option <?php echo $openSelect ?> value="1">open</option>
<option <?php echo $closeSelect ?> value="0">close</option>
</select>
                    </div>
                     
                    <div class="col-xs-12 col-md-4">
                      <label >  Email</label>
<input type="text" value="<?php if(isset($row)){ echo $row->email;} ?>" class="form-control"  name="email">
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label >  Address</label>
<input type="text" value="<?php if(isset($row)){ echo $row->address;} ?>" class="form-control"  name="address">
                    </div>
                     <div class="col-xs-12 col-md-4">
                      <label >  phone</label>
<input type="text" value="<?php if(isset($row)){ echo $row->phone;} ?>" class="form-control"  name="phone">
                    </div>
                    
                   
					<div class="clearfix">&nbsp;</div>
					
					
					
                     <div class="clearfix">&nbsp;</div>
                    <div class="col-xs-12 col-md-12">
                      <label >  Message</label>
<textarea class="form-control" rows="10" id="editor1" name="description"><?php if(isset($row)){ echo $row->description;} ?></textarea>
                    </div>
					   <div class="clearfix">&nbsp;</div>
                  
					
                     <div class="col-xs-12 col-md-12" >
                      <label for="exampleInputEmail1"> App Logo</label>
                   <input type="file" name="image" id="image"  />
                   <div class="clearfix">&nbsp;</div>
                   
                   <?php 
		$src=base_url().'uploads/'.$row->image;
		if(empty($row->image)){
		$src=base_url().'uploads/noimg.png';
		
		}
				echo '<img width="100" class="img-responsive" src="'.$src.'" class="imgs"  >';
			
		 ?></div>
                     <div class="col-xs-12 col-md-12 " >
                      <label for="exampleInputEmail1"> Magzin cover/ splash screen</label>
                   <input type="file" name="banner" id="banner"  />
                   <div class="clearfix">&nbsp;</div>
                   
                   <?php 
		$src1=base_url().'uploads/'.$row->banner;
		if(empty($row->banner)){
		$src=base_url().'uploads/noimg.png';
		
		}
				echo '<img style="max-width:300px; height="50px"" class="img-responsive" src="'.$src1.'"    >';
			
		 ?></div>
                   
           </div> 
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
       <div class="col-xs-12 col-md-6">    
                     <button type="submit" class="btn btn-info">Submit</button>
                        <input type="hidden" id="id"  name="id" value="<?php if(isset($row)){ echo $row->id;} ?>">
                      </div>
                      </div>
                    
                 
                  
                    
                    
                </form>
                 </div>
                <div class="clearfix">&nbsp;</div>
                  <div class="clearfix">&nbsp;</div>
                
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
  
  
<script src="bower_components/ckeditor/ckeditor.js"></script>
 <script>

  $(function () {
    CKEDITOR.replace('editor1')
})
</script>
  

  <script>
  /**********************************save************************************/
	 $('#form_add_update').on("submit",function(e) {
		e.preventDefault();
		 var formData = new FormData();
		 if($('#image').val()!=''){
		formData.append("image", document.getElementById('image').files[0]);
		}
		if($('#banner').val()!=''){
		formData.append("banner", document.getElementById('banner').files[0]);
		}
	var other_data = $('#form_add_update').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
	
	post_description = CKEDITOR.instances.editor1.getData();

			formData.append("description", post_description);


	// ajax start
		    $.ajax({
			type: "POST",
			url: "<?php echo base_url().'setting/save'; ?>",
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
				},3000);
            }
           else if (data.status ==0)
            {  
			$(".alert").addClass('alert-danger');
				$(".alert").html(data.message);
				$(".alert").removeClass('hidden');
				setTimeout(function(){
				location.reload();
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
            {   alert(data.status);
			$(".alert").addClass('alert-warning');
				$(".alert").html(data.message);
				$(".alert").removeClass('hidden');
				
            }
			
           }
	 });

	//ajax end    
    });
 
  </script>
  