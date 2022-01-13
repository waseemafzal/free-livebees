<?php getHead(); ?>
   
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
      Blogs Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li > <a href="blogpost/add" class="btn btn-sm btn-su">Add Blog</a></li>
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
        <th>Blog Title</th>
       <th>Blog Desc</th>
       
        <th>Type</th>
        <th>Img/vido</th>
        <th>Comments</th>
        <th>Created on</th>
       
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
	if(!empty($data->result())){
	foreach ($data->result() as $row){
		/*
			id
			post_title
			post_date
			post_type
			video_url
		*/
		?>
		<tr id="row_<?php echo$row->id;?>">
        <td><?php echo $row->post_title;?></td>
        <td><?php 
		$post_description = strip_tags($row->post_description);
		//echo mb_substr($post_description,0,115,'UTF-8');
if (strlen($post_description) > 10)
   echo substr($post_description, 0, 50) . '...';		
		?></td>
        <td class="center"><?php echo $row->post_type ?></td>
        <td class="center">
		<?php 
		if($row->post_type=='video'){
		?>
        <video id="my-video" controls preload="auto"  style="width:250px;"
  poster="<?php echo base_url().'uploads/'.$row->thumb; ?>" data-setup="{}">
    <source src="<?php echo base_url().'uploads/'.$row->video_url; ?>" type='video/mp4'>
   
    <p class="vjs-no-js">
      To view this video please enable JavaScript, and consider upgrading to a web browser that
      
    </p>
  </video>
		<?php }
		else if($row->post_type=='image'){
			$post_id = $row->id;
			$where=array('post_id'=>$post_id);
			$ImgData = get_by_where_array($where,'post_images');
			
			foreach($ImgData->result() as $Imgrow){
				$src=base_url().'uploads/'.$Imgrow->file;
				echo '<img src="'.$src.'" width="50" >';
				}
		}
		else if($row->post_type=='embed url'){
		$arr = explode('=',$row->video_url);
		
		 ?>
         <iframe width="250" height="100" src="https://www.youtube.com/embed/<?php echo $arr[1]; ?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
<?php } ?>
         
         </td>
        	 
          <td class="center"><?php echo $row->created_on ?></td>
          <td class="center"><a href="blogpost_comments/index/<?php echo $row->id;?>"><i class="fa fa-comment pull-left"></i> Comments(<?php echo count_where('blogpost_comments',array('blog_id'=>$row->id)) ?>)</a></td>
            
    <td class="center">
            <a data-toggle="tooltip" title=" <?php echo ucwords(this_lang('Edit'));?>" class="btn btn-xs btn-info" href="blogpost/edit/<?php echo $row->id;?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
                
            </a>
            <a data-toggle="tooltip" title=" <?php echo ucwords(this_lang('Delete'));?>" class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="deleteRecord('<?php echo$row->id;?>','blogpost');">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                
            </a>
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
   

  <?php  getFooter(); ?>
<script>
$('#post_table').dataTable( {
  "ordering": false
} );
</script>
  
  
  
  