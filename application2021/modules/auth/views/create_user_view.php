<?php getHead(); ?>

<style>
    form .col-xs-12 {

        margin-bottom: 10px;

    }
</style>

<div class="content-wrapper">

    <section class="content-header">

        <h2><i class="glyphicon glyphicon-user"></i> <?php

                                                        if (isset($row)) {

                                                            $user_type = $row->user_type;

                                                            if ($user_type == 3) {

                                                                $redirect = 'view_users';
                                                            } elseif ($user_type == 2) {
                                                                $redirect = 'agent';
                                                            } else {

                                                                $redirect = 'view-admin';
                                                            }

                                                            echo ucwords(this_lang('Edit Account'));
                                                        } else {

                                                            echo ucwords(this_lang('CREATE_ACCOUNT'));
                                                        } ?></h2>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li> <a href="view_users" class="btn btn-sm btn-su">View</a></li>

        </ol>

    </section>

    <section class="content">

        <div class="row">

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-header">



                    </div>

                    <div class="box-body">

                        <form id="form-register" method="post" class="form-horizontal">

                            <div id="infoMessage" class="alert  hidden"></div>



                            <div class="form-group">

                                <?php



                                if (lasturi() == 'profile') {

                                    echo '<input type="hidden" name="user_type" value="' . get_session('user_type') . '" >';
                                }

                                if (isset($row->user_type) and $row->user_type == SCHOOL) {

                                    echo '<input type="hidden" name="user_type" value="' . SCHOOL . '" >';
                                }

                                if (lasturi() == 'create_user') {





                                ?>

                                    <div class="col-xs-12 col-md-4 col-sm-4">

                                        <label> <?php echo ucwords(this_lang('Select Account Type')); ?></label>

                                        <select class="form-control" name="user_type">





                                            <option value="0"> <?php echo ucwords(this_lang('USER TYPE')); ?></option>

                                            <?php

                                            $data = get_tbl_users_rights(); ?>



                                            <?php $c = 0;

                                            foreach ($data->result() as $user) :

                                                $c++;

                                                $string = $user->group_title;



                                                if (get_session('user_type') != SUPER_ADMIN) {

                                                    if ($c == 1 or $c == 2) {

                                                        continue;
                                                    }
                                                }

                                            ?>



                                                <option <?php if ($row->user_type == $user->id) echo "selected='selected'" ?> value="<?php echo  $user->id ?>">

                                                    <?php



                                                    echo  $string ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </select>

                                    </div>

                                <?php

                                }

                                ?>

                                <div class="col-xs-12 col-md-4 col-sm-4">

                                    <label><?php echo ucwords(this_lang(' Name')); ?></label>

                                    <input id="name" name="name" class="form-control" value="<?php if (isset($row)) {
                                                                                                    echo $row->name;
                                                                                                } ?>" placeholder="John" type="text" required>

                                </div>

                                <div class="col-xs-12 col-md-4 col-sm-4">

                                    <label> <?php echo ucwords(this_lang('enter email')); ?></label>

                                    <input type="text" id="email" value="<?php if (isset($row)) {
                                                                                echo $row->email;
                                                                            } ?>" name="email" class="form-control" placeholder="xyz@gmail.com" required>

                                </div>





                                <div class="col-md-12">

                                    <div class="col-xs-12 col-md-4 pad0 ">

                                        <label> <?php echo ucwords(this_lang('Password')); ?></label>

                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>

                                    </div>

                                    <div class="col-xs-12 col-md-4 ">

                                        <label> <?php echo ucwords(this_lang('Verify Password')); ?></label>

                                        <input type="password" id="register-password-verify" name="password_confirm" class="form-control" placeholder="Verify Password">

                                    </div>

                                    <div class="col-xs-12 col-md-4 ">

                                        <label> <?php echo ucwords(this_lang('Contact')); ?></label>

                                        <input type="text" id="phone" name="phone" value="<?php if (isset($row)) {
                                                                                                echo $row->phone;
                                                                                            } ?>" class="form-control col-md-3" placeholder="phone">

                                    </div>



                                    <!--<div class="col-md-6 col-xs-12 ">

                             <label> <?php echo ucwords(this_lang('Mobile')); ?> </label>

                            <input type="text" id="mobile" name="mobile" class="form-control col-md-3" value="<?php if (isset($row)) {
                                                                                                                    echo $row->mobile;
                                                                                                                } ?>" placeholder="0341 1234567">

                        </div>-->

                                </div>



                                <div class="col-xs-12 col-md-6">

                                    <label>Image</label>

                                    <input type="file" name="file" class=" file" id="file" accept=".png,.PNG,.JPG,.jpg,.jpeg,.JPEG,.gif">

                                </div>



                                <input type="hidden" id="id" name="id" value="<?php if (isset($row)) {
                                                                                    echo $row->id;
                                                                                } ?>">



                            </div>



                            <div class="col-xs-12">

                                <span style="margin:0 !important; display:inline-block">

                                    <?php

                                    if (isset($row->image)) {

                                        $image =  $row->image;

                                        $src  = base_url() . 'uploads/' . $row->image;

                                        echo '<img width="200"  src="' . $src . '" alt="img">';
                                    }



                                    ?>

                                </span>

                            </div>

                            <div class="form-group form-actions">

                                <div class="col-xs-6" style="padding-top: 28px;">





                                    <button type="button" onclick="create_user();" class="btn btn-effect-ripple btn-success pull-right" name="create_user_submit_btn"><i class="fa fa-plus"></i> <?php echo ucwords(this_lang('Save')); ?></button>

                                </div>



                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<?php getFooter(); ?>

<script>
    function check(val) {

        if (val == 1) {

            $(".freeDataDiv").removeClass("hidden");

        } else {

            $(".freeDataDiv").addClass("hidden");

        }

    }
</script>