

<li class="time-label">
                  <span class="bg-green">
                    <?php echo date('F j, Y, g:i a',strtotime($row->posted_date)); ?>
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-camera bg-purple"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?php echo time_elapsed_string($row->posted_date);?> </span>

                <h3 class="timeline-header"><a ><?php echo $row->teacher_name ?></a> uploaded new photo</h3>

                <div class="timeline-body">
                <p><?php echo $row->title ?></p>
                  <img src="<?php echo base_url().'uploads/'.$row->file ?>" alt="..." class="img-responsive">
                 </div>
              </div>
            </li>
            <!-- END timeline item -->
           
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>