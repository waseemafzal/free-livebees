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
#mobile{ 
   border: 1px solid;
    border-radius: 10px;
    background-repeat: no-repeat;
    background-size: cover;
    background-image: url(http://watchthemlearn.com/images/cover.png);
    position: relative;
    padding: 90px 50px 272px 50px;
}
#mheader{
    background-color: <?php if(isset($row)){ echo $row->top_header_color;} ?>;
    color: <?php if(isset($row)){ echo $row->top_header_text_color;} ?>;
    text-align: center;
    padding: 4px;
}
#mbody{
    padding: 10px 10px;
     background-color: <?php if(isset($row)){ echo $row->bg_color;} ?>;
    color: <?php if(isset($row)){ echo $row->text_color;} ?>;
       margin: 5px 0;
}
#mfoot{
    text-align: center;
}
#mfoot .icons{
    font-size: 22px;
    padding: 1px 15px;
    color: <?php if(isset($row)){ echo $row->bottom_icon_color;} ?>;
}
#mfoot .icons .fa{
    
}
.appletColor label{margin-top:10px;font-size: 11px;}
   </style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      App color Settings
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
              <p><i class="fa fa-info"></i> This page hold the setting of app colors </p></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <form id="form_add_update" name="form_add_update" role="form">
             <div class="col-xs-12"><div class="alert hidden"></div></div>
                    <div class="form-group wrap_form">
                   
           
                   
					<div class="clearfix">&nbsp;</div>
                   <div class="col-xs-12 col-md-2 appletColor">
                                 
                    <div class="col-xs-12 ">
                      <label >  Top header Bg color</label>
<input type="color" value="<?php if(isset($row)){ echo $row->top_header_color;} ?>" class="form-control" id="top_header_color"  name="top_header_color">
                    </div>
                    <div class="col-xs-12 ">
                      <label >  Top header text color</label>
<input type="color" value="<?php if(isset($row)){ echo $row->top_header_text_color;} ?>" class="form-control"  name="top_header_text_color">
                    </div>
                    
                    <div class="col-xs-12 ">
                      <label > Body Text color</label>
<input type="color" value="<?php if(isset($row)){ echo $row->text_color;} ?>" class="form-control"  name="text_color" id="text_color">
                    </div>
                    <div class="col-xs-12 ">
                      <label > Body Bg color</label>
<input type="color" value="<?php if(isset($row)){ echo $row->bg_color;} ?>" class="form-control" id="bg_color"  name="bg_color">
                    </div>
                     <div class="col-xs-12 ">
                      <label > Buttons bg color</label>
<input type="color" value="<?php if(isset($row)){ echo $row->buttons_bg_color;} ?>" class="form-control" id="buttons_bg_color"  name="buttons_bg_color">
                    </div>
                    <div class="col-xs-12 ">
                      <label > Bottom icon color</label>
<input type="color" value="<?php if(isset($row)){ echo $row->bottom_icon_color;} ?>" class="form-control" id="bottom_icon_color"  name="bottom_icon_color">
                    </div>
                    	<div class="clearfix">&nbsp;</div>
                   
                    <div class="col-xs-12 col-md-12">    
                     <button type="submit" class="btn btn-info">Update</button>
                        <input type="hidden" id="id"  name="id" value="<?php if(isset($row)){ echo $row->id;} ?>">
                      </div>
                   </div>
                   
                     <div class="col-xs-12 col-md-6">
                         
                         <div id="mobile">
                             <div id="mheader" >Home</div>
                             <div id="mbody" >We are here to help Daycares and Preschools improve there day to day tasks.
                             How to lower children’s Anxiety on there first day at daycare
How to re-assure parents with children attending daycare for the first time. – How to spot children with difficulty learning
How to work with Children with special needs and were to find resources for them and their families
How to improve your Educational Program.
How to attract new parents to your center.
How to Increase your daycare revenues by doing these simple things.
Renovate your center with a small budget.
                             </div>
                         <div id="mfoot" >
                             <span class="icons"><i class="fa fa-home"></i></span>
                             <span class="icons"><i class="fa fa-users"></i></span>
                             <span class="icons"><i class="fa fa-pencil"></i></span>
                             <span class="icons"><i class="fa fa-list"></i></span>
                         </div>
                         </div>
                         
                         </div>
                   
					<div class="clearfix">&nbsp;</div>
					
					
					
                     <div class="clearfix">&nbsp;</div>
                   
					
                     <div class="col-xs-12 col-md-12 hidden" >
                      <label for="exampleInputEmail1"> App Logo</label>
                   <input type="file" name="logo" id="logo"  />
                   <div class="clearfix">&nbsp;</div>
                   
                   <?php 
		$src=base_url().'uploads/'.$row->logo;
		if(empty($row->logo)){
		$src=base_url().'uploads/noimg.png';
		
		}
				echo '<img width="100" class="img-responsive" src="'.$src.'" class="imgs"  >';
			
		 ?></div>
                     <div class="col-xs-12 col-md-12 hidden" >
                      <label for="exampleInputEmail1"> Magzin cover/ splash screen</label>
                   <input type="file" name="bg_image" id="bg_image"  />
                   <div class="clearfix">&nbsp;</div>
                   
                   <?php 
		$src1=base_url().'uploads/'.$row->bg_image;
		if(empty($row->bg_image)){
		$src=base_url().'uploads/noimg.png';
		
		}
				echo '<img style="max-width:300px; height="50px"" class="img-responsive" src="'.$src1.'"    >';
			
		 ?></div>
                   
           </div> 
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
       
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
  

  

  <script>
  $(document).ready(function(){
     $("#top_header_color").change(function(){
        $("#mheader").css("background-color",$("#top_header_color").val());
    });
     $("#top_header_text_color").change(function(){
        $("#mheader").css("color",$("#top_header_text_color").val());
    });
    $("#text_color").change(function(){
        $("#mbody").css("color",$("#text_color").val());
    });
    $("#bg_color").change(function(){
        $("#mbody").css("background-color",$("#bg_color").val());
    });
    $("#bottom_icon_color").change(function(){
        $(".icons > .fa").css("color",$("#bottom_icon_color").val());
    });
    
    
    
});
  /**********************************save************************************/
	 $('#form_add_update').on("submit",function(e) {
		e.preventDefault();
		 var formData = new FormData();
		 if($('#bg_image').val()!=''){
		formData.append("bg_image", document.getElementById('bg_image').files[0]);
		}
		if($('#logo').val()!=''){
		formData.append("logo", document.getElementById('logo').files[0]);
		}
	var other_data = $('#form_add_update').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
	
	
	// ajax start
		    $.ajax({
			type: "POST",
			url: "<?php echo base_url().'appcolors/save'; ?>",
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
  