<?php getHead(); ?>
   <style>
   .pagination a{
	   padding:10px;
	   font-size:20px;
	   
	   }
   </style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
       Nests Management
        
      </h1>
      <ol class="breadcrumb">
     <a class="btn btn-info fff pull-right" id="btnImport" href="javascript:void(0)" class="btn btn-sm btn-su"> <i class="fa fa-plus"></i> Import Nests</a>
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
<center><span class="pagination"><?php echo $links; ?></span></center>
                <table id="" class="table table-striped table-bordered   responsive">
    <thead>
    <tr>
        <th>UniqueID </th>
        <th>Name </th>
        <th>Site </th>
        <th>Address  </th>
         <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
	if($data){
	foreach ($data->result() as $row){
		
		?>
		<tr id="row_<?php echo$row->id;?>">
        <td><?php echo $row->uniqid;?></td>
        <td><?php echo $row->name;?></td>
        <td class="center"><?php echo $row->place; ?></td>
        <td class="center"><?php echo $row->address; ?></td>
         <td class="center">
            <a data-toggle="tooltip" title=" <?php echo ucwords(this_lang('Edit'));?>" class="btn hidden btn-info" href="a/edit/<?php echo $row->id;?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
                Edit
            </a>
            <a data-toggle="tooltip" title=" <?php echo ucwords(this_lang('Delete'));?>" class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="deleteRecord('<?php echo$row->id;?>','tbl_loc');">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                
        </td>
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
   <div id="ApplyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="padding-left:3%">Import json</h4>
      </div>
           <form id="form_add_update" method="post" name="form_add_update" role="form">
        
      <div class="modal-body">
       
             <div class="col-xs-12"><div class="alert hidden"></div></div>
        
      <div class="col-xs-12 col-md-12">
                      <label>  Attach your json file <span class="text-danger">*</span></label>
                   <input type="file" name="file" id="file"  />
                   
                  
</div>
 <div class="clearfix">&nbsp;</div>
        
      </div>
      <div class="modal-footer">
                             <button type="button"  onClick="return mySubmitFunction(event)"  class="btnCustom pull-right">Submit <span class="btn_au hidden"><i class="fa fa-cog fa-spin" style="font-size:24px"></i></span></button>

      </div>
      </form>
    </div>

  </div>
</div>

  <?php  getFooter(); ?>
  
<script>
$("#btnImport").click(function(){
	
	 $('#ApplyModal').modal('show');
	
	});
$('#post_table').dataTable( {
  "ordering": false
} );
</script>
<script type="text/javascript">
function mySubmitFunction(e){

		e.preventDefault();
		
		 var formData = new FormData();
	var other_data = $('#form_add_update').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });   
	 if($('#file').val()!=''){
		formData.append("file", document.getElementById('file').files[0]);
		}
		
	// ajax start
		    $.ajax({
			type: "POST",
			url: "<?php echo base_url().'allnests/importcsv'; ?>",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'JSON',
			beforeSend: function() {
			//$('#loader').removeClass('hidden');
			$('#form_add_update .btn_au').removeClass('hidden');
			
			},
			success: function(data) {
			$('#form_add_update .btn_au').addClass('hidden');
			  if (data.status == 1)
            {   
				$(".alert").addClass('alert-success');
				$(".alert").html(data.message);
				$(".alert").removeClass('hidden');
				setTimeout(function(){
				$(".alert").addClass('hidden');
				$('#form_add_update')[0].reset();
				$('#ApplyModal').modal('hide');
				
				//window.location=data.redirect;
				},5000);
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
			
			
           }
	 });

	//ajax end    
    
	}
</script>
  
  
  
  