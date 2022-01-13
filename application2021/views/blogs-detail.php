<?php 
include_once"header.php";

?>
        <section id="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                    <h1>E Blogs
</h1>
</div>
            </div><!-- End row -->
        </div><!-- End container -->
      </section>
      <div class="clearfix">&nbsp;</div>
<section id="main_content">

    <div class="container">
  <div class="row">

            <aside class="col-md-4">
                	<div id="sidebar" class="sidebar box_style_1">
	<div id="search-2" class="widget widget_search">
    </div><div id="recentpost_widget-2" class="widget widget_recentpost_widget"><h4 class="widget_title">Recent Posts</h4>
    <ul>

        <?php 
		foreach($recentPost->result() as $rpost){
		?>
        <li>
            <i class="icon-calendar-empty"></i> <?=date('F , j Y',strtotime($rpost->created_on))?>            <div><a href="<?=$rpost->id?>"><?=$rpost->post_title?></a></div>
        </li>
        <?php } ?>
       
        
    </ul>
    </div>

	</div>
            </aside>

                        <div class="col-md-8">
              <!--<div class="post single-post">
                
                                                                                                                                                          <img src="http://demo.vegatheme.com/learn/wp-content/uploads/2015/08/blog-1-1.jpg" alt="">
                                                            
                
                <div class="post_info clearfix">
                  <div class="post-left">
                    <ul>
                      <li><i class="icon-calendar-empty"></i>On <span>August 3, 2015</span></li>
                      <li><i class="icon-user"></i>By <a href="http://demo.vegatheme.com/learn/author/admin/" title="Posts by John Smith" rel="author">John Smith</a></li>
                      <li><i class="icon-tags"></i>Tags  <a href="http://demo.vegatheme.com/learn/tag/book/" rel="tag">book</a>, <a href="http://demo.vegatheme.com/learn/tag/library/" rel="tag">library</a></li>                    </ul>
                  </div>
                  <div class="post-right"><i class="icon-comment"></i>0 comment</div>
                </div>

                <h2>Cum sociis natoque penatibus et magnis dis parturient montes</h2>

                <h4>Aenean volutpat aliquet diam</h4>
<p>Venenatis nisi faucibus sit amet. In hac habitasse platea dictumst. Integer vel sem est. Nulla pharetra, justo vitae placerat dapibus, dui massa pellentesque magna, a sagittis magna lorem a massa. Integer convallis augue eu felis euismod vel iaculis velit pretium. Nam et diam ut sem aliquet ultrices non eu ante.lectus. Nam blandit odio nisl, ac malesuada lacus fermentum sit amet. Vestibulum vitae aliquet felis, ornare feugiat elit. Nulla varius condimentum elit, sed pulvinar leo sollicitudin vel.</p>
<p>Morbi rutrum massa eget mi gravida, sit amet mollis magna gravida. Morbi sodales, ligula quis ornare bibendum, magna erat convallis ipsum, id posuere ligula massa vitae leo. Morbi laoreet dui ullamcorper massa pulvinar faucibus. Proin quis nisi viverra, laoreet enim sit amet, adipiscing tellus.</p>
<p>Curabitur libero diam, lacinia a eros a, molestie lobortis magna. Duis pulvinar mattis diam, ac condimentum felis euismod eu. Proin libero felis, malesuada eget fringilla ut, dapibus ut tellus. Nulla facilisi. Quisque hendrerit aliquet commodo. Nullam placerat commodo varius. Morbi egestas iaculis bibendum. Donec mauris felis, consectetur pulvinar est eu, accumsan auctor nunc. Pellentesque semper mi non est auctor, vel viverra risus dictum. Nulla nec ligula vitae ipsum</p>

                
              </div>-->
          
              
	<div class="post post-single">
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
		<?php }
		else if($row->post_type=='image'){
		$src=base_url().'uploads/'.$row->image;
				echo '<img src="'.$src.'"  class="img-responsive" >';
				
		}
		else if($row->post_type=='embed url'){
		$arr = explode('=',$row->video_url);
		
		 ?>
         <iframe width="250" height="100" src="https://www.youtube.com/embed/<?php echo $arr[1]; ?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
<?php } ?>              
       
    <div class="post_info clearfix">
      <div class="post-left">
        <ul>
        <?php 
		$author='Admin';
		if($row->author!=''){ 
		  echo $author = $row->author;
		  }
		 
		  ?>
          <li><i class="icon-calendar-empty"></i>On <span><?=date('F , j Y',strtotime($row->created_on))?></span></li>
          <li><i class="icon-user"></i>By <a href="" title="<?=$author ?>" rel="author"><?=$author ?></a></li>
      </div>
      <div class="post-right"><i class="icon-comment"></i><?php echo count_where('blogpost_comments',array('blog_id'=>$row->id)) ?> comment</div>
    </div>
    <h2><?php echo $row->post_title;?></h2><br>
    <?php 
		echo $row->post_description;	
		?>
        
         <?php
	if($comments->num_rows()>0){
		echo '<hr><h4><i class="fa fa-comment"></i> Comments</h4>';
		foreach($comments->result() as $commentRow){
		?>
        <div class="col-xs-12 col-md-12">
        <span class="fa fa-user"></span><b> <?php echo ucfirst($commentRow->name) ?></b> <span ><i class="fa fa-clock"></i> <?php  echo date('F,j,Y',strtotime($commentRow->created_on)) ?></span>
        </div>
		<div class="col-md-12">
       <p> <?php echo ucfirst($commentRow->body) ?></p>
        </div>
		<?php }
		
		}
		
	?>
  </div>
              <?php
			  if($comments->num_rows()>0){
			  echo '<div class="clearfix">&nbsp;</div><hr>';
			  }
			   ?>
<div class="commentsform ">
    <div id="addcomments">
   
        <div id="respond" class="comment-respond">
                    	<div id="respond" class="comment-respond">
		<h3 id="reply-title" class="comment-reply-title">Leave a comment </h3>
       <?php
	   $cppexuser='';
	   $cppexemail='';
if(isset($_COOKIE['cppexuser'])) {
    $cppexuser=$_COOKIE['cppexuser'];
}
if(isset($_COOKIE['cppexemail'])) {
    $cppexemail=$_COOKIE['cppexemail'];
}
?>
        <form  method="post" id="form_add_update" class="comment-form" novalidate=""><p class="comment-notes"><span id="email-notes">Your email address will not be published.</span> Required fields are marked <span class="required">*</span></p><p class="comment-form-comment"><textarea id="comment" class="form-control" name="body" placeholder="Message..." cols="45" rows="8"></textarea></p><p class="comment-form-author"><input id="author" class="form-control" name="name" type="text" value="<?=$cppexuser?>" placeholder="Enter Name" size="30"></p>
<p class="comment-form-email"><input id="email" class="form-control" name="email" type="email" value="<?=$cppexemail?>" placeholder="Enter Email" size="30"></p>
<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="saved" type="checkbox" value="yes"> <label for="wp-comment-cookies-consent">Save my name, email, and website in this browser for the next time I comment.</label></p>
 <div class="alert hidden"></div>
<p class="form-submit"><input name="submit" type="submit" id="submit" class="btnCustom" value="Post Comment"> <input type="hidden" name="blog_id" value="<?=lasturi()?>" id="blog_id">
</p></form>	</div><!-- #respond -->
	        </div>
    </div>
</div><!-- //LEAVE A COMMENT -->
                
            </div>
            
        </div>

    </div>

</section>        
        
<?php include_once"footer.php"; ?>
<script>
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
			url: "<?php echo base_url().'eblogs/saveComment'; ?>",
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