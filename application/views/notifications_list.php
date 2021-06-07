<?php include_once"header.php"; ?>
<style>
form>div{ margin-bottom:10px;}
#uln{list-style: none;}
#uln>li{}
#uln li a{}
#uln li .glyphicon-time{}
#uln li .time{}

</style>
         <div class="signup-area page-padding">
            <div class="container">
                <div class="row">
                    <div class=" col-md-12 col-sm-12 col-xs-12">
                        <div class="login-page signup-page">
                            <div class="login-form signup-form">
                                <h4 class="login-title ">Notifications List</h4>
                                <div class="row">
                                
                                       <?php
                                       //pre($notidata);
 if($notifidata->num_rows()>0){
	 echo '<ul id="uln">';
	 foreach($notifidata->result() as $noti){
		 $url='javascript:void(0)';
		 if($noti->resource_type=='nest'){
			 $url='map/nestdetail/'.$noti->resource_id;
			 }
  ?>
                  <li><img src="uploads/noimage.jpg" ><a href="<?=$url?>"><?=ucfirst($noti->body)?></a> <span class="time"><i class="glyphicon glyphicon-time"></i> <?=$noti->created_date?></span></li>
                  
                  <?php } 
				  echo '</ul>';
				  }else { ?>
                  <div class="col-md-12"><p style="padding:10px 5px; border-radius:5px" class="alert-warning">You have no notification yet!</p></div>
                  <?php }?>
                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
        <!-- Start Footer Area -->
       <?php //include_once"footer.php"; ?>
