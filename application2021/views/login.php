<?php include_once "header.php"; ?>



<!-- header end -->

<!-- Start breadcumb Area -->



<!-- End breadcumb Area -->

<!-- Start Slider Area -->

<div class="login-area page-padding">

        <div class="container">

                <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">

                                <div class="login-page">

                                        <div class="login-form">

                                                <h4 class="login-title"><?= lang("start_session"); ?> :</h4>

                                                <div class="row">

                                                        <form id="form_user_loggedin" method="POST" class="log-form">

                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                        <label><?= lang("connection_identifier"); ?></label>

                                                                        <input type="email" id="identity" class="form-control" name="identity">

                                                                </div>

                                                                <div class="clearfix">&nbsp;</div>

                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                        <label><?= lang("pwd"); ?></label>
                                                                        <div style="display:flex;align-items:center;">
                                                                                <input type="password" name="password" id="password" class="form-control" required>
                                                                                <span id="eye_open" style="cursor:pointer;padding: 0px 2px;margin-left: -20px;" class="glyphicon glyphicon-eye-open"></span>
                                                                                <span id="eye_close" style="cursor:pointer;padding: 0px 2px;margin-left: -20px;" class="hidden glyphicon glyphicon-eye-close"></span>
                                                                        </div>



                                                                </div>

                                                                <div class="clearfix">&nbsp;</div>



                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                        <div class="check-group flexbox">

                                                                                <label class="check-box">

                                                                                        <input type="checkbox" class="check-box-input" checked>

                                                                                        <span class="remember-text"><?= lang('remember_username'); ?></span>

                                                                                </label>



                                                                                <a class="text-muted" href="#" data-toggle="modal" data-target="#forgotModal"><?= lang('forgot_password'); ?></a>

                                                                        </div>

                                                                </div>

                                                                <div class="clearfix">&nbsp;</div>



                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                        <button type="button" onClick="loggedin_user()" id="submit" class="login-btn btnCustom"><?= lang('login'); ?></button>

                                                                        <div id="msgSubmit" class="h3 text-center hidden"></div>

                                                                        <div class="clearfix"></div>

                                                                </div>

                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                        <div class="clear"></div>

                                                                        <!--  <div class="separetor"><span>Or with Sign</span></div>

                                          -->
                                                                        <div class="sign-icon">

                                                                                <!-- <ul>

                                                    <li><a class="facebook" href="#">Facebook</a></li>

                                                    <li><a class="twitter" href="#">twitter</a></li>

                                                    <li><a class="google" href="#">google+</a></li>

                                                </ul>-->

                                                                                <div class="acc-not hidden" style="display:none">vous n'avez pas de compte? <a href="signup">S'inscrire</a></div>

                                                                        </div>

                                                                </div>

                                                        </form>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                        <h2 class="modal-title" id="exampleModalLabel"><?php echo lang('forgot_your_password'); ?></h2>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                   <div class="alertForgot " style="display:none"></div>                     <form id="frmforgot">
                                                                                                <label><?php echo lang('your_email'); ?></label>
                                                                                                <input type="email" id="email" class="form-control" name="email" placeholder="<?php echo lang('your_email'); ?>" />
                                                                                        </form>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                                                <?php echo lang('to_close'); ?></button>
                                                                                        <button type="button" onclick="forgotpassword()" class="btn btn-primary">
                                                                                                <?php echo lang('submit_forget'); ?></button>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>

                                                        <!--end of forgot-->

                                                </div>

                                        </div>

                                </div>

                        </div>

                </div>

        </div>

</div>

<!-- all js here -->

<!-- Start Footer Area -->

<?php include_once "footer.php"; ?>

<?php include_once "includes/js/user.php"; ?>
<script>
        $("#eye_open").click(function() {
                $("#password").attr("type", "text");
                $(this).addClass("hidden");
                $("#eye_close").removeClass("hidden");
        });
        $("#eye_close").click(function() {
                $("#password").attr("type", "password");
                $(this).addClass("hidden");
                $("#eye_open").removeClass("hidden");
        });
</script>
<script>
        function forgotpassword() {
                var formData = new FormData();

                formData.append('email', $('#email').val());


                if ($('#email').val() == '') {

                        alert('veuillez saisir votre e-mail');

                        return false;
                }

                // ajax start
                $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . 'home/forgotpassemail'; ?>",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'JSON',
                        beforeSend: function() {
                                $('#loader').removeClass('hidden');
                        },
                        success: function(data) {
                                $('#loader').addClass('hidden');
                                if (data.status == 200) {
                                        $('#forgotModal').modal('hide');
                                        $('.alertForgot').show();
                                        $('.alertForgot').addClass('alert-success');
                                        $('.alertForgot').html(data.message);
                                        setTimeout(function() {
                                                $('.alert').hide('slow');
                                        }, 5000);




                                } else {
                                        $('.alertForgot').show();
                                        $('.alertForgot').addClass('alert-danger');
                                        $('.alertForgot').html(data.message);

                                }
                        }
                });
        }
</script>