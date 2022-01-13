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
.trmy  th input{
	text-align:center;}
   </style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Users Rights
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
              <p><i class="fa fa-info"></i> This page hold the users rights and what they can do on admin</p></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <form id="form_add_update" name="form_add_update" role="form">
             <div class="col-xs-12">
             <div class="alert hidden"></div></div>
             <table id="post_table" class="table table-striped table-bordered   responsive">
    <thead>
    <tr>
        <th>Id </th>
        <th>User Role</th>
        <th>Add User</th>
        <th>Edit User</th>
        <th>Delete User</th>
       
        
    </tr>
    </thead>
    <tbody>
                    <?php
					foreach($data->result() as $row){?>
                    <tr class="trmy">
        <th><?=$row->id?> <input type="hidden" name="id[]" value="<?=$row->id?>" /> </th>
        <th> <?=$row->group_title?></th>
        <th> <input type="number" min="0" max="1" name="add_users[]" value="<?=$row->add_users?>"   /></th>
        <th> <input type="number" min="0" max="1" name="edit_users[]" value="<?=$row->edit_users?>"   /></th>
        <th> <input type="number" min="0" max="1" name="delete_users[]" value="<?=$row->delete_users?>"   /></th>
        				</tr>
						
						<?php }
					?>
                     
    </tbody>
    </table>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
       <div class="col-xs-12 col-md-6">    
                     <button type="submit" class="btn btn-info">Update Rights</button>
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
  
  

  <script>
  /**********************************save************************************/
	 $('#form_add_update').on("submit",function(e) {
		e.preventDefault();
		 var formData = new FormData();
		
	var other_data = $('#form_add_update').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
	
	// ajax start
		    $.ajax({
			type: "POST",
			url: "<?php echo base_url().'setting/updateUserRight'; ?>",
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
  