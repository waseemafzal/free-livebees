<?php

include_once "header.php";

if (isset($row)) {



    $post_banner = base_url() . 'uploads/' . $row->post_banner;
}



?>

<style>
    #sub-header {

        padding: 0 0 15px 0;

        margin-bottom: 5px;

    }

    #title {

        background: rgb(252, 227, 3);

        display: inline-block;

        padding: 1% 5%;

        font-size: 50px;

        color: #666;

    }
</style>

<section id="sub-header" style="background:url(<?= $post_banner ?>);background-size: 100%;background-position: 50%; display:none">

    <div id="tintBG">

        <div class="container">

            <div class="row">

                <div class="col-md-10 col-md-offset-1 text-center">

                    <h1 id="title"><?php if (isset($row)) {
                                        echo $row->short_heading;
                                    } ?>

                    </h1>





                </div>

            </div><!-- End row -->

        </div><!-- End container -->

    </div>

</section>



<section class="vc_rows wpb_rows vc_rows-fluid vc_custom_1488790902404 " id="main-features" style="padding-top:20px !important">

    <div class="container">

        <?php if (isset($row)) {

            $mainContainer = 'col-xs-12 col-sm-12 col-md-12';

            if ($row->displaysidebar == 1) {

                $mainContainer = 'col-xs-12 col-sm-8 col-md-8';

                $sidebarPosition =    $row->sidebar;

                if ($sidebarPosition == 0) {

                    $positionClass = 'pull-right';
                }

                if ($sidebarPosition == 1) {

                    $positionClass = 'pull-left';
                }

        ?>

                <aside class="col-xs-12 col-sm-4 col-md-4 <?= $positionClass ?>">

                    <?php

                    foreach ($imgdata->result() as $sidebar) {

                        $src = base_url() . 'uploads/' . $sidebar->image;

                    ?>

                        <div class="thumbnail">

                            <a target="_blank" href="<?= $sidebar->url ?>" class="fancybox"> <img src="<?= $src ?>" class="img-responsive" alt="<?= $sidebar->title ?>"></a>

                            <div class="caption">

                                <p><?= $sidebar->title ?></p>

                            </div>

                        </div>



                    <?php } ?>

                </aside>

        <?php }
        } ?>

        <div class="<?= $mainContainer ?> ">



            <?php if (isset($row)) {

                if (get_session('lang') == 'english') {
                    echo $row->post_description;
                } else {

                    echo $row->post_description_fr;
                }
            } ?>

        </div>



    </div>



</section>





<?php include_once "footer.php"; ?>

<script type="text/javascript">
    $(document).ready(function() {



        $('table').addClass('table table-striped');

    });
</script>