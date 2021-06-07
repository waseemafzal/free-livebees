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
        Slider  Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li > <a href="slider">View Slider </a></li>
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
             <div class="col-xs-12"><div class="alert hidden"></div></div>
                    <div class="form-group wrap_form">
                    
                    
                  
                    
                    
                    <div class="col-xs-12 col-md-6">
                      <label for="exampleInputEmail1"> Title </label>
                       
<input  class="form-control" id="title"  placeholder="Lorem Ipsum" value="<?php if(isset($row)){ echo $row->title;} ?>" name="title">
                    </div>
                     <!-- <div class="col-xs-12 col-md-6">
                      <label> Slider Url </label>
<input  class="form-control " id="url" autocomplete="off"  placeholder="www.publisher.com" value="<?php if(isset($row)){ echo $row->url;} ?>" name="url">
                    </div>-->
                    
            <div class="clearfix">&nbsp;</div>
                     <div class="col-xs-12 col-md-12">
                                             <label for="exampleInputEmail1"> Description</label>
                        <textarea class="form-control" rows="8" id="editor1" name="description"><?php if(isset($row)){ echo $row->description;} ?></textarea>

                     </div>
                     
                              
           </div> 
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      
      <div class="col-xs-12 col-md-6">
                      <label>  Image</label>
                   <input type="file" name="image" id="image"  /><div class="clearfix">&nbsp;</div>
                    <div class="clearfix">&nbsp;</div>
                   <?php if(isset($row)){ 
				   echo '<img src="'.base_url().'uploads/'.$row->image.'" width="50">';
				   }?> </div> <div class="clearfix">&nbsp;</div>
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
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    
  })
////////////



	
	function getNext(val){
	var formData = new FormData();
formData.append('val',val); 
$.ajax({
        url: "<?php echo base_url().'slider/get_pub_or_doc'; ?>",
        type: 'POST',
		 data:formData,
		 cache: false,
			contentType: false,
			processData: false,
			dataType: 'JSON',
        success: function(response) {
		//var obj = 	jQuery.parseJSON(response)
		
           $("#resource_data" ).html(response.option);
           
           }
	 });
}
  /**********************************save************************************/
	 $('#form_add_update').on("submit",function(e) {
		e.preventDefault();
		
		 var formData = new FormData();
	var other_data = $('#form_add_update').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
	 if($('#image').val()!=''){
		formData.append("image", document.getElementById('image').files[0]);
		}
		
		description = CKEDITOR.instances.editor1.getData();
		formData.append("description", description);
	// ajax start
		    $.ajax({
			type: "POST",
			url: "<?php echo base_url().'slider/save'; ?>",
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
				window.location='slider';
				},2000);
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
				window.location='slider';
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
  