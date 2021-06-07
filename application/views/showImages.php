]<?php include_once'header.php'; ?>
      
<div class="container">

  <?php
  foreach($nest as $key=>$val){
      $key = str_replace('_',' ',$key);
      if($key=='nest type'){
      if($val==1){
                $val='Asian Hornet';
            }elseif($val==2){
                $val='Eurpion Hornet';	
            }elseif($val==3){
                $val='WASP';	
            }else{
               $val='OTHER';	 
            }
            
      }    
      if($key=='status'){
            if($val==1){
                $val='Active';
            }else{
                $val='In active';
            }
      }
     $key= ucfirst($key);
     $val=ucfirst($val);
  ?>
  <div class="col-xs-6 col-md-3"><b><?=$key?> : </b> <?=$val?></div>
  <?php } ?>
  <div class="clearfix">&nbsp;</div>
  <div class="clearfix">&nbsp;</div>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?=$slider?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
 <hr>
     <?php
     if(isset($data)){
         echo $data;
     }
     ?>
     
</div>

     
    
     </body>

     
