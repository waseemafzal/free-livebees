<?php getHead(); ?>



<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <h1>

      Main Menu



    </h1>

    <ol class="breadcrumb">

      <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

      <li> <a href="mainmenu/add" class="btn btn-sm btn-su">Add Main Menu</a></li>

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

                  <th>Clean Url</th>

                  <th>Actual Url</th>



                  <th>French Title</th>
                  <th>English Title</th>

                  <th>Want To Show?</th>

                  <th>Icon Class</th>





                  <th>Actions</th>

                </tr>

              </thead>

              <tbody>

                <?php

                if (!empty($data->result())) {

                  foreach ($data->result() as $row) {



                ?>

                    <tr id="row_<?php echo $row->id; ?>">

                      <td><?php echo $row->slug; ?></td>

                      <td><?php

                          echo $row->controller;

                          // //echo m b_substr($post_description,0,115,'UTF-8');

                          // if (strlen($post_description) > 10)

                          //   echo substr($post_description, 0, 50) . '...';

                          ?></td>

                      <td class="center"><?php echo $row->title_french ?></td>
                      <td class="center"><?php echo $row->title_english ?></td>





                      <td class="center"><?php echo $row->show_in_nav ?></td>

                      <td class="center"><?php echo $row->icon_class ?></td>





                      <td class="center">

                        <a data-toggle="tooltip" title=" <?php echo ucwords(this_lang('Edit')); ?>" class="btn btn-xs btn-info" href="mainmenu/edit/<?php echo $row->id; ?>">

                          <i class="glyphicon glyphicon-edit icon-white"></i>



                        </a>

                        <a data-toggle="tooltip" title=" <?php echo ucwords(this_lang('Delete')); ?>" class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="deleteRecord('<?php echo $row->id; ?>','app_routes');">

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





<?php getFooter(); ?>

<script>
  $('#post_table').dataTable({

    "ordering": false

  });
</script>