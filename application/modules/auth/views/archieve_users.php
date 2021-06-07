<?php getHead(); ?>
   
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
      <h1>Archive User Listing</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
       <!-- <li > <a href="cms/add" class="btn btn-sm btn-su">Add Page</a></li>-->
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
                <table id="post_table" class="table table-striped table-bordered   responsive">
    <thead>
        <tr>
                <tr>
                    <th>ID</th>
                    <th ><?php echo ucwords(this_lang('Name'));?></th>
                    <th style="width: 3%;"><?php echo ucwords(this_lang('Email'));?></th>
                    <th><?php echo ucwords(this_lang('Phone No'));?></th>
                    <th><?php echo ucwords(this_lang('Address'));?></th>
                    <th><?php echo ucwords(this_lang('lang'));?></th>
                </tr>
        </tr>
    </thead>
    <tbody>
    		<?php  //refferal_id
	  		 //if(!empty($data->result()))
	  		 //{
				 foreach ($users as $user):
					?>

                        <tr id="row_<?PHP echo $user->id;?>" class="user_type<?php echo $user->user_type; ?>">
                            <td><?php echo htmlspecialchars($user->id,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($user->name,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($user->phone,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars((!empty($user->address) ? $user->address : 'Not provided') ,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($user->lang,ENT_QUOTES,'UTF-8');?></td>
                        </tr>

                   <?php
				    endforeach;
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
  <style  type="text/css">
   #ul_reffered_list,#tbl_refferaldetaillisting {list-style: decimal; width:100%;}
   #ul_reffered_list li{border-bottom: 1px solid #ddd;
background-color: darkgray !important;
font-size: 14px;
padding: 0px 0px 0px 10px;}
.trc{color: cornflowerblue;
font-size: 12px;}
.thbg{background: #ecf0f5;

color: cadetblue;}
.mrg{ margin-left:40%;}
.yesf{ color:green; font-weight:bold;}
.scrolll{ height:500px; overflow:auto;}
  </style>
   


  


  <?php  getFooter(); ?>
<script>
$('#post_table').dataTable( {
  "ordering": false
} );

	
   
  
  
</script>
  
  
  
  