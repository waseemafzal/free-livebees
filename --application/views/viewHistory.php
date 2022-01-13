<?php include_once 'header.php';



?>

<style>
    .btn {

        padding: 5px 5px;

    }



    .abc {

        position: absolute;

        width: 50px;

    }



    .info {

        margin: 0 0 0 5px;

        font-size: 20px;

    }



    .diaparo {

        position: absolute;

        width: 302px;

        background: #fff;

        padding: 2px 7px;



        box-shadow: 0px 2px 7px 2px #ece9bc;

    }

    #post_table {}

    #post_table_filter {

        display: none;

    }



    #post_table>tbody>tr {}
</style>

<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css">



<div class="col-xs-12">



    <div class="box-body">

        <br>



        <table class="table table-striped table-bordered" style="">

            <thead>

                <tr>

                    <th colspan="2" align="center" style="text-align: center;"><?= lang('first_observation') ?></th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td><?= lang('site_code_modal'); ?></td>

                    <td> <?= $nest->uniqid; ?></td>

                </tr>

                <tr>

                    <td> <?= lang('date'); ?></td>
                    <?php

                    $date = $nest->date;
                    $date_val = explode("-", $date);

                    ?>
                    <td><?= $date_val[2] . '-' . $date_val[1] . '-' . $date_val[0]; ?></td>

                </tr>

                <tr>

                    <td><?= lang('name_nest_modal'); ?></td>

                    <td> <?= $nest->name; ?></td>

                </tr>

                <tr>

                    <td><?= lang('address_nest_modal'); ?></td>

                    <td><?= $nest->address; ?></td>

                </tr>

                <tr>

                    <td><?= lang('height_m'); ?></td>

                    <td><?= $nest->colonie_hauteur; ?></td>

                </tr>

                <tr>



                </tr>

                <tr>

                    <td><?= lang('law_nest_modal'); ?></td>

                    <td><?= lang1($nest->place); ?></td>

                </tr>



                <tr>

                    <td><?= lang('support'); ?></td>

                    <td><?php

                        if ($nest->nesting_type == 'Autre') {

                            $nest->nesting_type =  $nest->e_nesting_type_info;
                        }

                        echo lang1($nest->nesting_type); ?>



                    </td>

                </tr>









            </tbody>

        </table>

        <p><b><?= lang('colonie_search') . ':'; ?></b></td>

            <td><?= lang1(getetatdelacolonyStatus($nest_id)) ?>

        </p>

        <p><b><?= lang('observer_date') . ':'; ?></b></td>

            <td>

                <?

                if (!empty($latest_observer_data)) {

                    $observer_Date = explode("-", $latest_observer_data);

                    echo $observer_Date[2] . '-' . $observer_Date['1'] . '-' . $observer_Date['0'];
                }

                ?>

        </p>

        <br>



        <a class="btn btn-success" href="map/follow_controller/<?= $nest_id ?>"> <i class="glyphicon glyphicon-plus icon-white"></i> <?= lang('new_observation') ?></a>

        <br><br>

        <div class="table-responsive">



            <table id="post_table" cell-padding="10" cell-spacing="5" class="table table-striped table-bordered   responsive">



                <thead>



                    <tr>



                        <th class="text-center"><?= lang('date'); ?></th>

                        <th class="text-center"><?= lang('name_suivi'); ?></th>





                        <th class="text-center"><?= lang('activity_suivi'); ?></th>

                        <th class="text-center"><?= lang('Pollen_suivi'); ?></th>

                        <th class="text-center"><?= lang('temperature_nest_modal'); ?></th>

                        <th class="text-center"><?= lang('weather_suivi'); ?></th>



                        <th class="text-center"> <?= lang('faded') ?></th>



                        <th class="text-center"> <?= lang('busy') ?></th>

                        <th class="text-center"><?= lang('colonie_search'); ?></th>

                        <th class="text-center"><?= lang('info') ?></th>



                        <th class="text-center"><?= lang('media'); ?></th>







                        <th><?= lang('actions'); ?></th>



                    </tr>



                </thead>



                <tbody>



                    <?php



                    if (!empty($data)) {





                        foreach ($data->result() as $row) {









                    ?>



                            <tr id="row_<?php echo $row->id; ?>">



                                <td><?php echo date('d-m-Y', strtotime($row->date)); ?></td>

                                <td><?php echo $row->name; ?></td>







                                <td class="center"><?php echo lang1($row->activity) ?></td>



                                <td class="center"><?php echo lang1($row->pollen) ?></td>

                                <td class="center"><?php echo $row->temperature ?></td>



                                <td class="center"><?php echo lang2($row->weather_situation) ?></td>



                                <td class="center"><?php echo lang1($row->disappeared);



                                                    if ($row->disappeared == 'Oui') {

                                                        echo '<a class="info" href="javascript:void(0)" onClick="diaparo(' . $row->id . ')"><i class="glyphicon glyphicon-info-sign"></i></a>';

                                                        $info = '<div style="display:none" class="diaparo" id="diaparo' . $row->id . '" >';

                                                        $info .= '<p title=""><b>' . lang('picked_up_beekeeper') . '</b>: ' . lang1($row->pickedup) . ' </p>';

                                                        $info .= '<p><b>' . lang('cavity_suive') . '</b>: ' . lang1($row->cavity_occupied) . ' </p>';

                                                        if ($row->cavity_occupied == 'Oui') {

                                                            $info .= '<p><b>' . lang('specify_suive') . '</b>: ' . $row->pouvezvous . ' </p>';
                                                        }





                                                        $info .= '</div>';



                                                        echo $info;
                                                    }

                                                    //pickedup

                                                    ?></td>





                                <td class="center">
                                <?php
                                
                                if($row->cavity_occupied=="Oui"){
                                    echo $row->pouvezvous;
                                }
                                else{

                                    echo lang1($row->cavity_occupied);
                                }
                                
                                 ?>
                                </td>

                                <td class="center"><?php echo lang1($row->etat_de_la_colonie); ?></td>



                                <td class="center"><?php echo $row->a_information ?></td>



                                <td class="center">



                                    <?php







                                    $post_id = $row->id;



                                    $where = array('follow_id' => $post_id);



                                    $ImgData = get_by_where_array($where, 'tbl_follow_images');



                                    $j = 0;



                                    foreach ($ImgData->result() as $Imgrow) {

                                        $arr = explode('.', $Imgrow->file);



                                        if ($arr[1] == 'jpg' or $arr[1] == 'JPG' or $arr[1] == 'png' or $arr[1] == 'PNG') {

                                            $src = base_url() . 'uploads/' . $Imgrow->file;



                                            echo '<a data-toggle="tooltip" title="Click to see all media" href="' . $src . '" rel="gallery' . $row->id . '" class="fancybox abc"><img src="' . base_url() . 'uploads/' . $ImgData->result()[0]->file . '" width="25" height="25" >';
                                        }
                                    }







                                    ?>







                                </td>











                                <td class="center">



                                    <a data-toggle="tooltip" title=" <?php echo ucwords(this_lang('Edit')); ?>" class="btn btn-xs btn-info" href="map/editFollow/<?php echo $row->id; ?>">



                                        <i class="glyphicon glyphicon-edit icon-white"></i>







                                    </a>



                                    <a data-toggle="tooltip" title=" <?php echo ucwords(this_lang('Delete')); ?>" class="btn btn-xs btn-danger" href="javascript:void(0)" onClick="deleteFollow('<?php echo $row->id; ?>');">



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

        <div class="clearfix">&nbsp;</div>

        <div class="clearfix">&nbsp;</div>

    </div>



</div>



<div class="clearfix">&nbsp;</div>

<div class="clearfix">&nbsp;</div>



</body>







</html>

<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>

<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>



<script>
    function diaparo(id) {

        if ($('#diaparo' + id).hasClass('shown')) {

            $('#diaparo' + id).hide();

            $('#diaparo' + id).removeClass('shown');

        } else {

            $('#diaparo' + id).show();

            $('#diaparo' + id).addClass('shown');

        }

    }



    function deleteFollow(id) {



        if (!confirm("Confirmer la suppression du nid")) {



            //User Pressed okay. Delete



            return false;



        }



        $.ajax({



            url: "<?= base_url() ?>map/deleteFollow",



            type: 'POST',



            data: {



                id: id



            },



            dataType: "json",



            success: function(response) {



                $('#row_' + id).hide('slow');



            }



        });







    }
</script>

<script src="fancybox/source/jquery.fancybox.js"></script>



<script>
    $('#post_table').dataTable({

        "paging": false,

        "ordering": false,

        "info": false

    });

    $(".fancybox").fancybox();
    $(document).ready(function(){
        $("form :input").prop("disabled", true);
    });
</script>