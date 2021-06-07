<?php getHead(); ?>
<script>
  function redirect(cat) {

    window.location.href = "https://wild-bees.org/translation?cat_id=" + cat;
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Translation Managment

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li> <a href="translation/add" class="btn btn-sm btn-su">Add sentece</a></li>
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
            <div class="col-xs-12 col-md-6">
              <label for="exampleInputEmail1">Category</label>

              <select class="form-control" id="cat_id" onChange="redirect(this.value)" name="cat_id">
                <option value="0">Others</option>
                <?php
                $selected = '';
                foreach ($categories as $cat) {


                ?>
                  <option value="<?= $cat['id'] ?>"><?php echo $cat['title'] ?></option>
                <?php } ?>
              </select>
            </div>
            <table id="post_table" class="table table-striped table-bordered   responsive">
              <thead>
                <tr>
                  <th>Translation Key</th>
                  <th>English Sentence</th>
                  <th>French Sentence</th>
                  <th>Created on</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($data->result())) {
                  foreach ($data->result() as $row) {

                ?>
                    <tr id="row_<?php echo $row->id; ?>">
                      <td><?php echo $row->tkey; ?></td>
                      <td><?php echo $row->english; ?></td>

                      <td class="center"><?php echo $row->french ?></td>


                      <td class="center"><?php echo $row->created_at ?></td>


                      <td class="center">
                        <a data-toggle="tooltip" title=" <?php echo ucwords(this_lang('Edit')); ?>" class="btn btn-xs btn-info" href="translation/edit/<?php echo $row->id; ?>">
                          <i class="glyphicon glyphicon-edit icon-white"></i>

                        </a>
                        <a data-toggle="tooltip" title=" <?php echo ucwords(this_lang('Delete')); ?>" class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="deleteRecord('<?php echo $row->id; ?>','trans_language');">
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