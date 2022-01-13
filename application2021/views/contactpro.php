<?php

include_once "header.php";

?>

<style>
    .post img {

        height: 200px;

        width: 100%;

    }

    .glyphicon {
        margin-bottom: 10px;
        margin-right: 10px;
    }



    small {

        display: block;

        line-height: 1.428571429;

        color: #999;

    }
</style>

<section id="sub-header" style="background:url(frontend/blogs.jpg)">

    <div class="container">

        <div class="row">

            <div class="col-md-10 col-md-offset-1 text-center">

                <h1>
                    <?php echo lang('pest_control_users'); ?>

                </h1>

            </div>

        </div><!-- End row -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $radius = 20;
                    if (isset($_GET['radius']) and $_GET['radius'] != '') {
                        $radius = $_GET['radius'];
                    }
                    ?>
                    <div class="my_flex">

                        <div class="">
                            <div class="slidecontainer">
                                <input type="range" min="20" max="10000" value="<?= $radius ?>" class="slider" id="myRange">
                                <p>Radius: <span id="demo">
                                        <?= $radius ?>
                                    </span> KM</p>
                            </div>
                        </div>


                        <div class="fliter_radius_button"><input type="button" onclick="filterRadius()" id="btnSearch" class="btn btn-info" value="<?php echo lang('submit_radius');   ?>" /></div>
                    </div>


                    <script>
                        var slider = document.getElementById("myRange");
                        var output = document.getElementById("demo");
                        output.innerHTML = slider.value;

                        slider.oninput = function() {
                            output.innerHTML = this.value;
                        }
                    </script>
                </div>
            </div>
        </div>

    </div><!-- End container -->

</section>

<div class="clearfix">&nbsp;</div>

<section id="main_content">



    <div class="container">



        <div class="row">







            <div class="col-md-12">







                <?php

                if ($data->num_rows() > 0) {

                    foreach ($data->result() as $row) {


                        //$banner=base_url().'uploads/'.$row->thumbnail;



                ?>





                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="well well-sm">

                                <div class="row">

                                    <div class="col-sm-6 col-md-4">

                                        <?php

                                        $src = base_url() . 'uploads/' . $row->image;

                                        echo '<img src="' . $src . '"    class="img-rounded img-responsive"  >';



                                        ?>

                                    </div>

                                    <div class="col-sm-6 col-md-8">

                                        <h4>

                                            <?php echo $row->name; ?></h4>

                                        <?php if ($row->address != '') { ?>

                                            <small><cite title="<?php echo $row->address; ?>"><i class="glyphicon glyphicon-map-marker"> <?php echo  $row->address; ?>

                                                    </i></cite></small>

                                        <?php } ?>

                                        <p>



                                            <i class="glyphicon glyphicon-envelope"></i><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a>

                                            <br />





                                            <i class="glyphicon glyphicon-phone"></i><?php echo $row->phone; ?>
                                            <br>
                                            <?php
                                            $user = '';
                                            if ($row->user_type == 3) {
                                                $user = 'Référent';
                                            } elseif ($row->user_type == 4) {
                                                $user = 'Particulier';
                                            } elseif ($row->user_type == 5) {
                                                $user = 'Institution';
                                            } ?>
                                            <i class="glyphicon glyphicon-user"></i><?php echo lang($user); ?>

                                        </p>

                                        <?php if ($row->about != '') { ?>

                                            <p><i class="glyphicon glyphicon-briefcase"></i><?= $row->about ?></p>

                                        <?php } ?>

                                        <div class="btn-group">

                                            <button onClick="myfun(<?php echo $row->id; ?>)" class="btn btn-primary"><?php echo lang('enter_message'); ?></button>

                                        </div>

                                        <div>

                                            <textarea class="hidden" id="<?php echo $row->id; ?>" rows='3' class="form-control"></textarea>

                                        </div>





                                        <!-- Split button -->

                                        <div class="btn-group">



                                            <button type="button" id="btnContact_<?php echo base64_encode($row->id) ?>" onClick="contactWithPro('<?php echo base64_encode($row->id) ?>','<?php echo $row->id ?>','<?php echo $this->session->userdata('user_id') ?>')" class="btn btn-primary">

                                                <?php echo lang('contact_pro');  ?> <span id="loader_spin_<?php echo base64_encode($row->id) ?>;?>" class="hidden"><i class="fa fa-refresh fa-spin" style="font-size:24px"></i></span></button>





                                        </div>

                                    </div>


                                </div>

                            </div>

                        </div>

                        <!-- end post -->

                <?php }
                } else {

                    echo lang('no_data_found');
                }

                ?>



                <div class="text-center">

                    <center>
                        <p class="pagination"><?php echo $links; ?></p>



                        <ul class="pagination">



                            <!--	<li><span aria-current="page" class="page-numbers current">1</span></li>

	<li><a class="page-numbers" href="http://demo.vegatheme.com/learn/blog/page/2/">2</a></li>

	<li><a class="page-numbers" href="http://demo.vegatheme.com/learn/blog/page/3/">3</a></li>

	<li><a class="next page-numbers" href="http://demo.vegatheme.com/learn/blog/page/2/"><i class="fa fa-angle-double-right"></i></a></li>

-->
                        </ul>



                </div>



            </div>



        </div>



    </div>



</section>



<?php include_once "footer.php"; ?>

<script>
    function myfun(val) {

        $("#" + val).removeClass("hidden");

    }

    function filterblog(v) {

        window.location = "eblogs/index/?query=" + v;

    }

    function contactWithPro(pro = '', val = '', sender_id = '') {
        // sender_id->who will send the message
        // val ->who will recieve the message from the sender







        var message = $("#" + val).val();

        if (message == "" || message == undefined) {



            message = " ";

        }





        var formData = new FormData();

        formData.append('pro_id', pro);

        formData.append('message', message);
        formData.append('rec_id', val);
        formData.append('sender_id', sender_id);

        // ajax start

        $.ajax({

            type: "POST",

            url: "<?php echo base_url() . 'chat/contactWithPro'; ?>",

            data: formData,

            cache: false,

            contentType: false,

            processData: false,

            beforeSend: function() {

                $('#loader').removeClass('hidden');

                //$('#form_sample .btn_au').addClass('hidden');

            },

            success: function(data) {

                $("#" + val).addClass('hidden');

                $('#loader').addClass('hidden');

                $('.alert').html("<?php echo lang('success'); ?>");

                $('.alert').show().addClass('alert-success');
                setTimeout(function() {
                    window.location.href = "<?php echo base_url() . 'map/index' ?>";
                }, 3000);



            }

        });



        //ajax end    



    }



    function filterRadius() {
        radius = $('#myRange').val();
        if (radius == "") {
            alert("radius cannot be empty");
            return false;
        }


        var url = '<?= base_url() . 'contact-with-pro?' . $_SERVER['QUERY_STRING']; ?>' + "&radius=" + radius;
        window.location.href = url;
    }
</script>