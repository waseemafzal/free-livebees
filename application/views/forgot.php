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

                                                <h4 class="login-title"><?=lang('changepassword')  ?></h4>

                                                <div class="row">

                                                        <form id="form_user_loggedin" method="POST" class="log-form">

                                                                <input type="hidden" name="email" id="email" value="<?php echo $userrecord[0]->email; ?>" />
                                                                <div class="clearfix">&nbsp;</div>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <label><?=lang('newpassword')?></label>
                                                                        <div style="display:flex;align-items:center;">


                                                                                <input type="password" id="password" class="form-control" name="password">
                                                                                <span id="eye_open" style="cursor:pointer;padding: 0px 2px;margin-left: -20px;" class="glyphicon glyphicon-eye-open"></span>
                                                                                <span id="eye_close" style="cursor:pointer;padding: 0px 2px;margin-left: -20px;" class="hidden glyphicon glyphicon-eye-close"></span>

                                                                        </div>
                                                                </div>

                                                                <div class="clearfix">&nbsp;</div>

                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                        <label><?=lang('confirmpassword')?></label>
                                                                        <div style="display:flex;align-items:center;">

                                                                                <input type="password" name="cpassword" id="cpassword" class="form-control" required>
                                                                                <span id="eye_open1" style="cursor:pointer;padding: 0px 2px;margin-left: -20px;" class="glyphicon glyphicon-eye-open"></span>
                                                                                <span id="eye_close1" style="cursor:pointer;padding: 0px 2px;margin-left: -20px;" class="hidden glyphicon glyphicon-eye-close"></span>

                                                                        </div>
                                                                </div>

                                                                <div class="clearfix">&nbsp;</div>



                                                                <div class="hidden" class="col-md-12 col-sm-12 col-xs-12">

                                                                        <div class="check-group flexbox">

                                                                                <label class="check-box">

                                                                                        <input type="checkbox" class="check-box-input" checked>

                                                                                        <span class="remember-text">Se souvenir de mes identifiants </span>

                                                                                </label>



                                                                                <a class="text-muted" href="javascript::void(0)" onclick="showfrm()">Mot de passe oublié?</a>

                                                                        </div>

                                                                </div>

                                                                <div class="clearfix">&nbsp;</div>



                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                        <button type="button" onClick="forgotpass()" id="submit" class="login-btn pinbuttons btn"><?=lang('submit')?></button>

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

                                                </div>

                                        </div>

                                </div>

                        </div>

                </div>

        </div>

</div>
<!---forgot password modal--!>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h2 class="modal-title" id="exampleModalLabel">Mot de passe oublié</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                                <form id="frmforgot">
                                        <label>Votre e-mail</label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="Votre e-mail" />
                                </form>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Fermer</button>
                                <button type="button" onclick="forgotpassword()" class="btn btn-primary">
                                        soumettre</button>
                        </div>
                </div>
        </div>
</div>

<!--end of forgot-->
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
        $("#eye_open1").click(function() {
                $("#cpassword").attr("type", "text");
                $(this).addClass("hidden");
                $("#eye_close1").removeClass("hidden");
        });
        $("#eye_close1").click(function() {
                $("#cpassword").attr("type", "password");
                $(this).addClass("hidden");
                $("#eye_open1").removeClass("hidden");
        });
</script>
<script>
        function forgotpass() {
                var formData = new FormData();
                pass = $('#password').val();
                cpass = $('#cpassword').val();

                formData.append('email', $('#email').val());
                formData.append('password', pass);


                if (pass.length < 8) {

                        $('.alert').show();
                        $('.alert').addClass('alert-success');
                        $('.alert').html("Le mot de passe doit contenir 8 caractères");
                        setTimeout(function() {

                                $('.alert').hide('slow');
                        }, 5000);
                        return false;
                }
                if ($('#password').val() == '') {

                        $('.alert').show();
                        $('.alert').addClass('alert-success');
                        $('.alert').html("veuillez saisir le mot de passe");
                        setTimeout(function() {

                                $('.alert').hide('slow');
                        }, 5000);
                        return false;
                }
                if ($('#cpassword').val() == '') {

                        $('.alert').show();
                        $('.alert').addClass('alert-success');
                        $('.alert').html("veuillez saisir le mot de passe de confirmation");
                        setTimeout(function() {

                                $('.alert').hide('slow');
                        }, 5000);
                        return false;
                }
                if (pass != cpass) {
                        $('.alert').show();
                        $('.alert').addClass('alert-success');
                        $('.alert').html("Le mot de passe et le mot de passe de confirmation ne correspondent pas");
                        setTimeout(function() {

                                $('.alert').hide('slow');
                        }, 5000);
                        return false;
                }

                // ajax start
                $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . 'auth/updatepassword'; ?>",
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
                                        $('.alert').show();
                                        $('.alert').addClass('alert-success');
                                        $('.alert').html(data.message);
                                        setTimeout(function() {
                                                $('.alert').hide('slow');
                                                window.location = "<?php echo base_url() . 'login' ?>";
                                        }, 3000);




                                } else {
                                        $('.alert').show();
                                        $('.alert').addClass('alert-danger');
                                        $('.alert').html(data.message);

                                }
                        }
                });
        }
</script>