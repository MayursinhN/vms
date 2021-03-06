<?php include_once '../include/header.php'; ?>
<?php
$cond = "is_active =:active AND category_name =:category";
$params = array(":active" => 1, ":category" => 'events');

$marital = $obj->fetchRowAll('masters_list', $cond, $params);

?>

<style>
    .filled-in {
        position: inherit !important;
        opacity: 1 !important;
    }

    .waves-input-wrapper01 {
        margin-top: -80px;
    }
</style>
<div class="header">
    <h1 class="page-header pull-left"> CPD Event Master </h1>
    <div class="add-button"><a href="<?php echo HTTP_SERVER; ?>manageevent" class="btn-floating"><i
                    class="material-icons">add</i></a></div>
    <div class="clearfix"></div>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li class="active">CPD Event Master</li>
    </ol>
</div>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">

            <?php if ($objsession->get('ads_message') != "") {
                ?>
                <div class="alert alert-success">
                    <?php echo $objsession->get('ads_message'); ?>
                </div>
                <?php $objsession->remove('ads_message');
            } ?>
            <?php if ($objsession->get('ads_message') != "") {
                ?>
                <div class="error-message"> <?php echo $objsession->get('ads_message'); ?> </div>
                <?php $objsession->remove('ads_message');
            } ?>

            <!-- Advanced Tables -->
            <div class="card">
                <div class="card-content">
                    <div class="table-responsive">

                        <form name="frm_user" method="post" action="export">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (count($marital)) {

                                    for ($i = 0; $i < count($marital); $i++) {

                                        ?>
                                        <div class="modal fade" id="_delete<?php echo $i; ?>" tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel">

                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <p class="text-center"><strong>Are you 100% sure about
                                                                this?</strong></p>
                                                        <br/>
                                                        <div class="inputer">
                                                            <div class="input-wrapper text-center"><a
                                                                        href="<?php echo HTTP_SERVER; ?>events/<?php echo $marital[$i]['master_id']; ?>"
                                                                        class="btn btn-success reload">Yes</a>
                                                                <button type="button" class="btn btn-success reload"
                                                                        data-dismiss="modal" aria-label="Close">No
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <tr class="odd gradeX">
                                            <td><?php echo $marital[$i]['name']; ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo HTTP_SERVER; ?>manageevent/<?php echo $marital[$i]['master_id']; ?>"><i
                                                            style="padding: 8px;font-size: 20px;"
                                                            class="fa fa-pencil-square-o"

                                                            aria-hidden="true"></i></a>
                                                <a href="#_delete<?php echo $i; ?>" data-toggle="modal"><i
                                                            style="font-size: 20px;" class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                            </td>
                                        </tr>

                                    <?php }
                                } ?>

                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>

    <?php

    if (isset($_GET['master_id'])) {
        $data = array('is_active' => 0);
        if ($obj->update($data, 'masters_list', array('master_id' => $_GET['master_id'])) == true) {
            $objsession->set('ads_message', 'Event successfully deleted.');
            redirect(HTTP_SERVER . "events");
        }
    }
    ?>
    <?php include_once '../include/footer.php'; ?>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>

        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                "ordering": false,
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
            }).on('page.dt', function () {
                $('html, body').animate({
                    scrollTop: $(".page-header").offset().top
                }, 'slow');
            });
        });
    </script>