<?php getHead();

 ?>
   
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo lasturi() ?></h1>
      <ol class="breadcrumb">
       
        <!--<li><a href="#" class="btn btn-info btn-sm">ADD USERS</a></li>
        -->
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All <?php echo lasturi(); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <table class="table table-bordered table-striped data-table">
                     <thead>
                        <tr >
                            <th><?php echo ucwords(this_lang('NAME'));?></th>
                            <th><?php echo ucwords(this_lang('EMAIL'));?></th>
                            <th><?php echo ucwords(this_lang('Image'));?></th>
                            <th><?php echo ucwords(this_lang('status'));?></th>
                            <th><?php echo ucwords(this_lang('action'));?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($users as $user):?>
                    <tr id="row_<?PHP echo $user->id;?>" class="user_type<?php echo $user->user_type; 
                    ?>">
                    <td><?php echo htmlspecialchars($user->name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                    <td  class="center">
						<?php
                        $img = $user->image;
                        if(!empty($img)){
                        $res = explode('.',$img);
                        $name = $res[0];
                        $ext = $res[1];
                        $image = base_url().'uploads/'.$name.'.'.$ext;
                        $thumb = $name.'_thumb.'.$ext;
                        {?>
                        <span style="margin:0 !important; display:inline-block" class="thumbnail">
                        <a class="fancybox" title="img" href="<?php echo $image; ?>">
                        <img width="50" height="50" src="<?php echo $image; ?>" alt="img">
                        </a>
                        </span>
                        <?php }
                        } else{
                        echo '<img class="fancybox" width="50" height="50" src="'.base_url().'img/no-image.png">';
                        }
                        ?> 
                    </td>
                    <td class="center">
						<?PHP if($user->active==0){
                        $class="label-danger";
                        $text='Suspended';
                        }else{
                        $class="label-success";
                        $text='Active';
                        } 
                        ?> 
                        <span id="div_status_<?PHP echo $user->id;?>">
                        <a href="javascript:void(0);"  
                        onclick="changeUserStatus('<?PHP echo $user->id;?>','<?PHP echo $user->active;?>','<?PHP echo 'users';?>');" >
                        <span class="label <?PHP echo $class;?>">
                        <?PHP echo ucwords(this_lang($text));?></span>
                        </a>
                        </span>   
                    </td> 
                    <td>
                    <?php
					$hide='';
					if($title='App Users'){
					//$hide='hidden';
					}
					?>
                        <a href="auth/edit/<?php echo$user->id;?>"  data-toggle="tooltip" title="Edit User" class="<?php echo $hide ?> btn btn-effect-ripple btn-xs btn-success ">
                        <i class="fa fa-pencil"></i></a>
                        <?php 
						if($user->id!=1){?>
						
                        <a href="javascript:void(0)" onClick="deleteRecord('<?php echo$user->id;?>','users');" data-toggle="tooltip" title="Delete " class="btn btn-effect-ripple btn-xs btn-danger">
                        <i class="fa fa-times">
                        </i>
                        </a>
						<?php } ?>
                    </td>
                    </tr>
                    <?php endforeach;?>
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
  