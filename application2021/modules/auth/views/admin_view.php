<?php 

getHead();

 ?>

   

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Admin List 

        

      </h1>

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

              <h3 class="box-title">All Admins</h3>

            </div>

            <!-- /.box-header -->

            <div class="box-body">

             <table class="table table-bordered table-striped data-table">

                     <thead>

                        <tr >

                            <th>ID</th>
                            <th><?php echo ucwords(this_lang('NAME'));?></th>

                            <th style="width: 3%;"><?php echo ucwords(this_lang('EMAIL'));?></th>
                            <?php
if(end($this->uri->segment_array())!='admins'){
?>
                            <th><?php echo ucwords(this_lang('Phone No'));?></th>
                             
                            
<?php } ?>
                            <th><?php echo ucwords(this_lang('Image'));?></th>

                           <?php /*?> <th><?php echo ucwords(this_lang('status'));?></th><?php */?>

                            <th><?php echo ucwords(this_lang('action'));?></th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    foreach ($users as $user):?>

                    <tr id="row_<?PHP echo $user->id;?>" class="user_type<?php echo $user->user_type; 

                    ?>">

                    <td><?php echo htmlspecialchars($user->id,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->name,ENT_QUOTES,'UTF-8');?></td>
<?php
if(end($this->uri->segment_array())!='admins'){
?>
                    <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->phone,ENT_QUOTES,'UTF-8');?></td>
                    <?php  } ?>
                    <td><?php echo htmlspecialchars((!empty($user->email) ? $user->email : 'Not provided') ,ENT_QUOTES,'UTF-8');?></td>
                  

                    <td  class="center">

						<?php

                        $img = $user->image;
					  
                        if(!empty($img) and $img!='noimg.png')
						{
                           $image = base_url().'uploads/'.$img;
						//{
						?>

                            <span style="margin:0 !important; display:inline-block" class="thumbnail">
    
                            <a title="img" href="<?php echo $image; ?>">
    
                            <img width="50" height="50" src="<?php echo $image; ?>" alt="img">
    
                            </a>
    
                            </span>

                        <?php 
						//}

                        } else{

                        echo '<img width="50" height="50" src="'.base_url().'assets/noimg.png">';

                        }

                        ?> 

                    </td>

                    <?php /*?><td class="center">

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

                    </td><?php */?> 

                    <td>
<?php
if(end($this->uri->segment_array())=='admins'){
?>
                        <a href="auth/edit/<?php echo $user->id;?>"  data-toggle="tooltip" title="Edit User" class="btn btn-effect-ripple btn-xs btn-success ">

                        <i class="fa fa-pencil"></i></a>
<?php } ?>    

  <?php if($user->id !=1){?>
                        <a href="javascript:void(0)" onClick="deleteRecord('<?php echo $user->id;?>','users');" data-toggle="tooltip" title="Delete " class="btn btn-effect-ripple btn-xs btn-danger">

                        <i class="fa fa-times">

                        </i>

                        </a>
<?php }?>
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

  