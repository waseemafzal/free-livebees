<?php 
include_once"header.php";
?>
<style>
.post img {
    height: 200px;
    width: 100%;
}
</style>
        <section id="sub-header" style="background:url(frontend/blogs.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                    <h1>Le projects
</h1>
</div>
            </div><!-- End row -->
        </div><!-- End container -->
      </section>
      <div class="clearfix">&nbsp;</div>
<section id="main_content">

    <div class="container">

        <div class="row">

            

            <div class="col-md-12">

                  

<?php 
if($data->num_rows()>0){
	foreach($data->result() as $row){
		//$banner=base_url().'uploads/'.$row->thumbnail;
		
?>
                    <div class="col-md-4 col-xs-12">
  <div class="post">
      <?php 
		 if($row->post_type=='image'){
		$src=base_url().'uploads/'.$row->image;
				echo '<img src="'.$src.'"    class="img-responsive" >';
				
		}
		 ?>              
       
    <div class="post_info ">
      
    
          
    <h4><a href="eblogs/detail/<?=$row->id;?>"><?php echo $row->post_title;?></a></h4>
    <p><?php 
		$post_description = strip_tags($row->post_description);
		//echo mb_substr($post_description,0,115,'UTF-8');
if (strlen($post_description) > 10)
   echo substr($post_description, 0, 150) . '...';		
		?></p>
    <a href="leproject/detail/<?=$row->id;?>" class="btn btn-info ">Lire la suite</a><div class="clearfix">&nbsp;</div>
    
  </div>
</div>
<!-- end post -->
<?php }
}else{
	echo 'No blog found !';
	}
 ?>

                                    <div class="text-center">
                                       <center>  <p class="pagination"><?php echo $links; ?></p>
  
                    <ul class="pagination">
                        
<!--	<li><span aria-current="page" class="page-numbers current">1</span></li>
	<li><a class="page-numbers" href="http://demo.vegatheme.com/learn/blog/page/2/">2</a></li>
	<li><a class="page-numbers" href="http://demo.vegatheme.com/learn/blog/page/3/">3</a></li>
	<li><a class="next page-numbers" href="http://demo.vegatheme.com/learn/blog/page/2/"><i class="fa fa-angle-double-right"></i></a></li>
--></ul>
                    
                </div>

            </div>

        </div>

    </div>

</section>        
        
<?php include_once"footer.php"; ?>
<script>
function filterblog(v){
	window.location="eblogs/index/?query="+v;
	}
</script>
