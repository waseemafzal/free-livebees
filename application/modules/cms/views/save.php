<?php getHead();

 ?>
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
       CMS Page Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li > <a href="cms">View Pages </a></li>
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
                      <label for="exampleInputEmail1"> Page Title </label>
                        <input type="text" class="form-control" id="post_title"  placeholder="Lorem ipsum post" name="post_title" value="<?php if(isset($row)){ echo $row->post_title;} ?>">

                    </div>
					<div class="col-xs-12 col-md-6">
                      <label for="exampleInputEmail1"> Slug/url </label>
                        <input type="text" class="form-control disable" id="slug"  name="slug" value="<?php if(isset($slug)){ echo $slug;} ?>">

                    </div>
					
                    <div class="clearfix">&nbsp;</div>
                 <div class="col-xs-12 col-md-6 hidden">
                      <label for="exampleInputEmail1"> Page Heading</label>
                        <input type="text" class="form-control"   placeholder="Lorem ipsum post" name="short_heading" value="<?php if(isset($row)){ echo $row->short_heading;} ?>">

                    </div>
                
                     
                  <div class="col-xs-12 col-md-12">
                      <label> Content (English)</label>
                        
						<textarea class="form-control" rows="10" id="editor1" name="post_description">
						<?php if(isset($row)){ echo $row->post_description;} ?></textarea>

                    </div>
                    <div class="clearfix">&nbsp;</div>
                <div class="col-xs-12 col-md-12">
                      <label> Content (French)</label>
                        
						<textarea class="form-control" rows="10" id="editor2" name="post_description_fr">
						<?php if(isset($row)){ echo $row->post_description_fr;} ?></textarea>

                    </div>
                    
                    
					   <div class="clearfix">&nbsp;</div>
                    <div class="col-xs-12 col-md-6 hidden">
                      <label for="exampleInputEmail1"> Top  Banner</label>
                   <input type="file" name="image" id="image"  /><div class="clearfix">&nbsp;</div>
                    <div class="topBanner" style="background-color: rgb(0,0,0,0.7);">
                    
                   <?php if(isset($row)){ 
				   echo '<img src="'.base_url().'uploads/'.$row->post_banner.'" style="width:300px">';
				   }?> </div> </div> 
                   <div class="clearfix">&nbsp;</div>
                  <h4><em>SEO Part</em></h4>
                        <div class="col-xs-12 col-md-6">
                        <label for="exampleInputEmail1">Meta Keyword</label>
                        <input type="text" class="form-control" id="meta_keyword"  placeholder="Meta keyword" name="meta_keyword" value="<?php if(isset($row)){ echo $row->meta_keyword;} ?>">
                        
                        </div>
                          
                 <div class="col-xs-12 col-md-6">
                      <label for="exampleInputEmail1">Meta Title</label>
                        <input type="text" class="form-control"   placeholder="Meta title" name="meta_title" value="<?php if(isset($row)){ echo $row->meta_title;} ?>">

                    </div>
                
                      <div class="clearfix">&nbsp;</div> <div class="clearfix">&nbsp;</div>
                  <div class="col-xs-12 col-md-12">
                      <label> Meta Description</label>
                        
<textarea class="form-control" rows="3" name="meta_description"><?php if(isset($row)){ echo $row->meta_description;} ?></textarea>

                    </div>
                   
                   <div class="clearfix">&nbsp;</div>
                   <div class="clearfix">&nbsp;</div>
                   <h3><em>Sidebar Setting</em></h3>
                   <hr />
                   <div class="col-xs-12 col-md-3">                      
                        <label>Display Sidebar</label>
                        <select class="form-control " id="displaysidebar" name="displaysidebar">
                            <option value="">select</option>
                            <option value="1" <?php if(isset($row) and $row->displaysidebar=='1'){?> selected="selected" <?php }?>>YES </option> 
                            <option value="0" <?php if(isset($row) and $row->displaysidebar=='0'){?> selected="selected" <?php }?>>NO</option>               
                        </select>
                    </div>
                   
               
                     <div class="col-xs-12 col-md-3">                      
                        <label>Display Sidebar Location</label>
                        <select class="form-control " id="sidebar" name="sidebar">  
                            <option value="">select</option>
                            <option value="1" <?php if(isset($row) and $row->sidebar=='1'){?> selected="selected" <?php }?>>Left Side </option> 
                            <option value="0" <?php if(isset($row) and $row->sidebar=='0'){?> selected="selected" <?php }?>>Right Side</option>               
                        </select>
                    </div>
                   <?php 
				   if(isset($row))
				   {
					  $NewID= $row->id;
				   }
				   else
				   {
					    $NewID = getMaxID('id','cms');  
					   
				    } 
				   
				?>
                   
               <a class="btn btn-info fff pull-right" href="sidebarcontent/add?cms_id=<?php echo $NewID;?>"> <i class="fa fa-plus"></i> Add  sidebar content</a>
                     <div class="clearfix">&nbsp;</div>
                   <div class="clearfix">&nbsp;</div>
                   
                   
            </div>
            <div class="clearfix">&nbsp;</div>
             <div class="col-xs-12 col-md-12">
                           <button type="submit" class="btn btn-info">Submit</button>
                        <input type="hidden" id="id"  name="id" value="<?php if(isset($row)){ echo $row->id;} ?>">
                   </div>
           </div> 

                    
                       <div class="clearfix">&nbsp;</div>
                    
                </form>
                 <?php //include_once'edit_img_form.php' ?>
                 </div>
               
              
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
<script type="text/javascript">

  $(function () {
    CKEDITOR.replace('editor1');
 CKEDITOR.replace('editor2');
 
  
});
</script>
  <script>
  /**********************************save************************************/
	 $('#form_add_update').on("submit",function(e) {
		e.preventDefault();	
		 var formData = new FormData();
	var other_data = $('#form_add_update').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
		post_description = CKEDITOR.instances.editor1.getData();

			formData.append("post_description", post_description);

	post_description_fr = CKEDITOR.instances.editor2.getData();

			formData.append("post_description_fr", post_description_fr);



			if($('#image').val()!='')
			{
				formData.append("image", document.getElementById('image').files[0]);
				
			} 
			
	// ajax start
		    $.ajax({
			type: "POST",
			url: "<?php echo base_url().'cms/save'; ?>",
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
				window.location='cms';
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

$("#post_title").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp,'-');
        $("#slug").val(Text);        
});
  
  </script>

  
