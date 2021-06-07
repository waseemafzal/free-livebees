<?php getHead(); ?>
   <style>
    .box-primary {
	margin:5px 2px;	
		}
    .box-primary img{
		min-width:200px;
		min-height: 200px;
	
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
       Blog Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li > <a href="blogpost">All Blogs </a></li>
      </ol>
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
             <form id="form_add_update" name="form_add_update" role="form">
             <div class="alert hidden"></div>
                    <div class="form-group wrap_form">
                    <div class="col-xs-12 col-md-6">
                      <label for="exampleInputEmail1">   Title</label>
                        <input type="text" class="form-control" id="post_title"  placeholder="Title" name="post_title" value="<?php if(isset($row)){ echo $row->post_title;} ?>">

                    </div>
                    <div class="col-xs-12 col-md-6">
                      <label for="exampleInputEmail1">   Author</label>
                        <input type="text" class="form-control" id="author"  placeholder="Johny" name="author" value="<?php if(isset($row)){ echo $row->author;} ?>">

                    </div>
                
                     <div class="clearfix">&nbsp;</div> 
                      <div class="clearfix">&nbsp;</div>
                    <div class="col-xs-12 col-md-3">                      
                    <label> Type</label>
                    <select class="form-control " id="post_type" name="post_type" onchange="gettype(this.value)">
                    <option value="0">select</option>
                   <?php 
				   $op= array('image'=>'image','video'=>'video','embed url'=>'embed url');
				   foreach($op as $key=>$val){ 
				   if(isset($row)){
				  		 if($row->post_type==$val){
					  	 $selected ='selected="selected"';
					  	 }else{
						    $selected ='';
						   }
				   }
					   echo ' <option '.$selected .' value="'.$val.'">'.$val.' </option>';
					}
					
					$imageDisplay='none';
					$videpDisplay='none';
					$embedDisplay='none';
					if(isset($row)){
					 if($row->post_type=='image'){
						 $imageDisplay='block';
						 }
					else if($row->post_type=='video' ){	
					 $videpDisplay='block';
					} 
					
					else if($row->post_type=='embed url'){	
					 $embedDisplay='block';
					} 
					}	 
				  ?>
                  
                    </select>
                    </div>
                     <div class="clearfix">&nbsp;</div>
                      <div class="clearfix">&nbsp;</div>
                    <div class="col-xs-12 col-md-3">                      
                    <label> Category</label>
                    <select class="form-control " id="category" name="category" >
                   <?php 
				   $op= array('Technology'=>'Technology','Social Media'=>'Social Media','World'=>'World','Science'=>'Science');
				   foreach($op as $key=>$val){ 
				   $selected ='';
				   if(isset($row)){
				  		 if($row->category==$val){
					  	 $selected ='selected="selected"';
					  	 }
				   }
					   echo ' <option '.$selected .' value="'.$val.'">'.$val.' </option>';
					}
					
						 
				  ?>
                  
                    </select>
                    </div>
                    
            <div class="clearfix">&nbsp;</div>
             <div class="clearfix">&nbsp;</div>
                  <div class="col-xs-12 col-md-12">
                      <label>   Content</label>
                        
                        <textarea class=" textarea" id="editor1"  placeholder="Lorem ipsum post" name="post_description"><?php if(isset($row)){ echo $row->post_description;} ?></textarea>

                    </div>
					 
            <div class="clearfix">&nbsp;</div>
            
                      <div id="video_wrap" class="col-xs-12 col-md-6 other_wrap" style="display:<?php echo $embedDisplay ?>">                      
                    <label>Enter url</label>
                        <input type="text" class="form-control" id="video_url"  placeholder="video url" name="video_url" value="<?php if(isset($row)){ echo $row->video_url;} ?>">
                       <br>
                      <img   src="<?php echo $row->thumbnail ?>" class="img-responsive"   />
                    </div>
                      
                      <br>
                  <div id="add_images_wrap" class="col-xs-12 col-md-12 other_wrap" style="display:<?php echo $imageDisplay ?>">                      
                    <label>Add  image</small></label>
                     <input type="file" name="file[]" class=" file"  id="file" accept=".png,.PNG,.JPG,.jpg,.jpeg,.JPEG,.gif"  >
                     
                     
                     <?php
			if(isset($row)){		
					$post_id = $row->id;
			$where=array('post_id'=>$post_id);
			$ImgData = get_by_where_array($where,'post_images');
			
			foreach($ImgData->result() as $Imgrow){
				$src=base_url().'uploads/'.$Imgrow->file;
				{?>
				<div class="col-xs-4 col-md-2  box-primary  img_wrap_<?php echo $Imgrow->id ?>">
                <img id="img_<?php echo $Imgrow->id ?>" src="<?php echo $src ?>" class="img-responsive"  ><br>
                <center>
                <a onclick="getImage('<?php echo $Imgrow->id ?>','post_images')" class="btn btn-xs btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Edit">
<i class="fa fa-pencil"></i></a>
<a class="btn btn-xs btn-danger"  onclick="deleteImage('<?php echo $Imgrow->id ?>','post_images')" href="javascript:void(0)" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Delete"><i class="fa fa-times"></i>
</a>
                </center>
                
                </div>
			<?php }	}
				
			}
					 ?>
                     </div>
                   
                    
            <div class="clearfix">&nbsp;</div>
            
            <div id="upload_video_wrap" class="col-xs-12 col-md-12 other_wrap" style="display:<?php echo $videpDisplay ?>">      
            <div class="col-xs-12 col-md-6">
                     <label>Upload video</label>
                     <input type="file" name="upload_video" class="upload_video"  id="upload_video" accept=".mp4,.MP4"  >
                     
                     <?php 
		if($row->post_type=='video'){
		?>
        <video id="my-video" controls preload="auto"  style="width:250px;"
  poster="<?php echo base_url().'uploads/'.$row->thumbnail; ?>" data-setup="{}">
    <source src="<?php echo base_url().'uploads/'.$row->video_url; ?>" type='video/mp4'>
   
    <p class="vjs-no-js">
      To view this video please enable JavaScript, and consider upgrading to a web browser that
      
    </p>
  </video>
  <?php } ?>

            </div>                
            <div class="col-xs-12 col-md-6">
                     <label>Video thumbnail</label>
                     <input type="file" name="thumbnail" class="thumbnail"  id="thumbnail" accept=".png,.PNG,.JPG,.jpg,.jpeg,.JPEG,.gif"  >
                     <div class="col-xs-12 col-md-6" style="padding: 0px; margin: 30px 0px 0px;">
                     <?php
					 if($row->post_type=='video'){
						 $thumbnail=base_url().'uploads/'.$row->thumbnail;
						 }
						
					 ?>
                      <img   src="<?php echo $thumbnail ?>" class="img-responsive"   />
                     </div>  
            </div>                
            </div>
           </div> 
      <div class="clearfix">&nbsp;</div>
       <div class="col-xs-12 col-md-6">    
                     <button type="submit" class="btn btn-info">Submit</button>
                        <input type="hidden" id="id"  name="id" value="<?php if(isset($row)){ echo $row->id;} ?>">
                      </div>
                      </div>
                    
                 
                  
                    
                    
                </form>
                 <?php include_once'edit_img_form.php' ?>
                 </div>
                <div class="clearfix">&nbsp;</div>
                  <div class="clearfix">&nbsp;</div>
               <script>
               function gettype(val){
					if(val=='video'){
						$('#upload_video_wrap').show();
						$('#video_wrap').hide();
						$('#add_images_wrap').hide();
						
					}else if(val=='image'){
						$('#add_images_wrap').show();
						$('#video_wrap').hide();
						$('#upload_video_wrap').hide();
					}
					else if(val=='embed url'){
						$('#video_wrap').show();
						$('#add_images_wrap').hide();
						$('#upload_video_wrap').hide();
					}
					else{
						$('#video_wrap').hide();
						$('#add_images_wrap').hide();
						$('#upload_video_wrap').hide();
					}
				}
               </script> 
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
  /**********************************save************************************/
	 $('#form_add_update').on("submit",function(e) {
		e.preventDefault();
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
	if($('#post_type').val()=='video'){
	if($('#upload_video').val()!=''){
		formData.append("upload_video", document.getElementById('upload_video').files[0]);
		}
	if($('#thumbnail').val()!=''){
		formData.append("thumbnail", document.getElementById('thumbnail').files[0]);
		}
	}
	
	
	var other_data = $('#form_add_update').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
	post_description = CKEDITOR.instances.editor1.getData();
			formData.append("post_description", post_description);

	// ajax start
		    $.ajax({
			type: "POST",
			url: "<?php echo base_url().'blogpost/save'; ?>",
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
				$(".alert").addClass('hidden');
				},3000);
            }
			else if (data.status == 2)
            {   
			$(".alert").addClass('alert-success');
				$(".alert").html(data.message);
				$(".alert").removeClass('hidden');
				setTimeout(function(){
				window.location='blogpost';
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
 
  /******************************/
  
     $('#form_edit_image').on("submit",function(e) {
	  
	  e.preventDefault();
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
			url: "<?php echo base_url().'blogpost/update_image'; ?>",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#loader').removeClass('hidden');
			//$('#form_sample .btn_au').addClass('hidden');
			},
				success: function(data) {
				$('#loader').addClass('hidden');
				$('#form_sample .btn_au').removeClass('hidden');
				var obj = jQuery.parseJSON(data);
				if (obj.status == 1)
				{   
				var src  =obj.image;
				if (src!=0){
					var src ='<?php echo base_url()?>uploads/'+obj.image;
				$("#img_"+obj.id).attr("src",src);
					}
				setTimeout(function(){
				$('#edit_image_wrap').hide('slow');
				$("#edit_small_image_div img").attr("src",src);
				},2000);
				}
				
				
			}
	 });

	//ajax end    
    });

  
  </script>
  <script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    
  })
</script>

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
	//CKEDITOR.config.contentsLangDirection = 'rtl'; // This line will make right to left
    CKEDITOR.replace('editor1')
    
  })
</script>