<?php include_once '../include/header.php'; ?>
<?php
$cond = "registration.is_active =:active ORDER BY registration.reg_id DESC";
$params = array(":active" => 1);
$previousInquiry = $obj->fetchRowwithjoin('inquiry_list','registration','inquiry_id','inquiry_id', $cond, $params);


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
    <h1 class="page-header pull-left"> Registration Manager</h1>
    <div class="add-button">
        <a href="<?php echo HTTP_SERVER; ?>inquiry" class="btn-floating"><i class="material-icons">add</i></a>
    </div>
    <div class="clearfix"></div>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li class="active">Registration Manager List</li>
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
                                    <th>Reg No.</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Date of Birth</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (count($previousInquiry)) {

                                    for ($i = 0; $i < count($previousInquiry); $i++) {

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
                                                                        href="<?php echo HTTP_SERVER; ?>registrationmanager/<?php echo $previousInquiry[$i]['reg_id']; ?>"
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
                                            <td width="250"><?php echo "#".$previousInquiry[$i]['reg_id']; ?></td>
                                            <td width="200"><?php echo $previousInquiry[$i]['first_name']." ".$previousInquiry[$i]['middle_name']." ".$previousInquiry[$i]['last_name']; ?></td>
                                            <td width="250"><?php echo $previousInquiry[$i]['address1']; ?></td>
                                            <td width="250"><?php echo $previousInquiry[$i]['email_address']; ?></td>
                                            <td width="250"><?php echo $previousInquiry[$i]['mobile_number']; ?></td>
                                            <td width="250"><?php echo date("d-m-Y",strtotime($previousInquiry[$i]['date_of_birth'])); ?></td>
                                            <td width="180" class="text-center">

                                                <a href="<?php echo HTTP_SERVER; ?>inquiry/<?php echo $previousInquiry[$i]['inquiry_id']; ?>/tabs"><i
                                                            style="padding: 0px;font-size: 20px;"
                                                            class="fa fa-pencil-square-o"

                                                            aria-hidden="true"></i></a>
                                                <a href="#_delete<?php echo $i; ?>" data-toggle="modal"><i
                                                            style="padding: 5px;font-size: 20px;" class="fa fa-times"
                                                            aria-hidden="true"></i></a>

                                                <a href="<?php echo HTTP_SERVER; ?>viewinquiry/<?php echo $previousInquiry[$i]['inquiry_id']; ?>"><i style="font-size: 20px;" class="fa fa-eye" aria-hidden="true"></i></a>

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

    if (isset($_GET['reg_id'])) {
        $data = array('is_active' => 0);
        if ($obj->update($data, 'registration', array('reg_id' => $_GET['reg_id'])) == true) {
            $objsession->set('ads_message', 'Record successfully deleted.');
            redirect(HTTP_SERVER . "registrationmanager");
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
            });
        });
    </script>