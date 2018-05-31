<?php include_once '../include/header.php';

$cond = "is_active=:is_active";
$params = array(":is_active" => 1);
$previous_inquiry = $obj->fetchNumOfRow('inquiry_list', $cond, $params);
$register_list = $obj->fetchNumOfRow('registration', $cond, $params);
$row = array();

$loginid = $objsession->get("log_admin_loginid");

$type = $objsession->get("log_admin_type");

$cond = "leaves.to_date >=:to_date AND users.login_id =:login_id AND leaves.is_active =:is_active";
$params = array(":to_date" => date("Y-m-d"), ":login_id" => $loginid, ":is_active" => 1);

if ($type == 'admin') {
    $cond = "leaves.to_date >=:to_date AND leaves.is_active =:is_active";
    $params = array(":to_date" => date("Y-m-d"), ":is_active" => 1);
}

$leaves = $obj->fetchRowwithjoin('leaves', 'users', 'login_id', 'login_id', $cond, $params);

if (isset($_GET['type'])) {
    if ($_GET['type'] == 'edit') {
        $cond = "leave_id =:leave_id";
        $params = array(":leave_id" => $_GET['leave_id']);
        $row = $obj->fetchRow('leaves', $cond, $params);
    }
}

?>

<div class="header">
    <h1 class="page-header"> Dashboard </h1>
    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Dashboard</a></li>
        <li class="active">Data</li>
    </ol>
</div>
<div id="page-inner">
    <div class="row">
        <?php if ($objsession->get('leave_message') != "") {
            ?>
            <div class="alert alert-success">
                <?php echo $objsession->get('leave_message'); ?>
            </div>
            <?php $objsession->remove('leave_message');
        } ?>
        <div class="clearfix"></div>

        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="card horizontal cardIcon waves-effect waves-dark">
                <div class="card-image blue"><i class="fa fa-users fa-5x"></i></div>
                <div class="card-stacked">
                    <div class="card-content">
                        <h3><?php if ($previous_inquiry > 0) {
                                echo $previous_inquiry;
                            } else {
                                echo "0";
                            } ?></h3>
                    </div>
                    <div class="card-action"><strong> No. of Inquiry</strong></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="card horizontal cardIcon waves-effect waves-dark">
                <div class="card-image"><i class="fa fa-users fa-5x"></i></div>
                <div class="card-stacked">
                    <div class="card-content">
                        <h3><?php if ($register_list > 0) {
                                echo $register_list;
                            } else {
                                echo "0";
                            } ?></h3>
                    </div>
                    <div class="card-action"><strong> No. of Client</strong></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-6 col-md-12">
            <div class="card horizontal cardIcon waves-dark">
                <div class="card-stacked">

                    <form method="post" id="frmLeave">
                        <input type="hidden" name="leave_id" value="<?php if (!empty($row)) {
                            echo $row['leave_id'];
                        } else {
                            echo "0";
                        } ?>">
                        <div class="input-field col s1">
                            <label for="from_date_time">For Half Day </label>
                        </div>
                        <div class="input-field col s4">
                            <?php
                            $yes = '';
                            $no = 'checked=""';

                            if (!empty($row)) {
                                if ($row['half_day'] == 1) {
                                    $yes = 'checked=""';
                                    $no = "";
                                }

                                if ($row['half_day'] == 0) {
                                    $no = 'checked=""';
                                    $yes = "";
                                }

                                $f_date = $row['from_date'] . " " . $row['from_time'];
                                $t_date = $row['to_date'] . " " . $row['to_time'];
                            }
                            ?>
                            <input class="with-gap" name="half_day"
                                   type="radio" <?php echo $yes; ?> id="test1"
                                   value="1"/>
                            <label for="test1">Yes</label>

                            <input class="with-gap" name="half_day"
                                   type="radio" <?php echo $no; ?> id="test2"
                                   value="0"/>
                            <label for="test2">No</label>
                        </div>
                        <div class="clearfix"></div>
                        <div class="input-field col s4">
                            <input id="from_date_time" name="from_date_time" type="text"
                                   class="validate" value="<?php if (!empty($row)) {
                                echo date('d/m/Y H:i', strtotime($f_date));
                            } ?>">
                            <label for="from_date_time">From Date</label>
                        </div>
                        <div class="input-field col s4">
                            <input id="to_date_time" name="to_date_time" type="text"
                                   class="validate" value="<?php if (!empty($row)) {
                                echo date('d/m/Y H:i', strtotime($t_date));
                            } ?>">
                            <label for="appo_date_time">To Date</label>
                        </div>
                        <div class="col-lg-4 text-right">
                            <label>&nbsp;</label>
                            <div class="form-group">
                                <input type="submit" name="btn_update"
                                       class="waves-effect waves-light btn"
                                       value="SAVE">
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <div class="card-action" style="padding: 10px;">
                        Leave list
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-Leave">
                        <thead>
                        <tr>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Leave</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($leaves)) {

                            for ($i = 0; $i < count($leaves); $i++) {

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
                                                                href="<?php echo HTTP_SERVER; ?>dashboard/<?php echo $leaves[$i]['leave_id']; ?>/delete"
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
                                    <td width="250"><?php echo date("d/m/Y", strtotime($leaves[$i]['from_date'])) . " " . date("H:i", strtotime($leaves[$i]['from_time'])); ?></td>
                                    <td width="250"><?php echo date("d/m/Y", strtotime($leaves[$i]['to_date'])) . " " . date("H:i", strtotime($leaves[$i]['to_time'])); ?></td>
                                    <td>
                                        <?php
                                        if ($leaves[$i]['half_day'] == 0) {
                                            echo "Full Day";
                                        } else {
                                            echo "Half Day";
                                        }
                                        ?>
                                    </td>
                                    <td width="220" class="text-center">
                                        <a href="<?php echo HTTP_SERVER; ?>dashboard/<?php echo $leaves[$i]['leave_id']; ?>/edit"><i
                                                    style="padding: 8px;font-size: 20px;"
                                                    class="fa fa-pencil-square-o"

                                                    aria-hidden="true"></i></a>
                                        <a href="#_delete<?php echo $i; ?>" data-toggle="modal"><i
                                                    style="padding: 2px;font-size: 20px;"
                                                    class="fa fa-times"
                                                    aria-hidden="true"></i></a>
                                    </td>
                                </tr>

                            <?php }
                        } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php

    if (isset($_GET['type'])) {
        if ($_GET['type'] == 'delete') {
            $data = array('is_active' => 0);
            if ($obj->update($data, 'leaves', array('leave_id' => $_GET['leave_id'])) == true) {
                $objsession->set('leave_message', 'Leaves successfully deleted.');
                redirect(HTTP_SERVER . "dashboard");
            }
        }
    }

    if (isset($_POST['btn_update'])) {

        extract($_POST);
        $currentDate = date('Y-m-d');

        $from_date_time = str_replace('/', '-', $from_date_time);
        $to_date_time = str_replace('/', '-', $to_date_time);

        $from_date_time = explode(" ", $from_date_time);
        $to_date_time = explode(" ", $to_date_time);

        $cond = "(DATE(appo_date_time) BETWEEN :f_date AND :t_date) AND appo_with =:appo_with";
        $params = array(":f_date" => date("Y-m-d", strtotime($from_date_time[0])), ":t_date" => date("Y-m-d", strtotime($to_date_time[0])), ":appo_with" => $loginid);

        $totalApp = $obj->fetchNumOfRow('appoinments', $cond, $params);

        if ($totalApp > 0) {
            $objsession->set('leave_message', 'Sorry, You can not leave on this date because you have to appointment for other person on this date');
            if ($leave_id > 0) {
                redirect(HTTP_SERVER . "dashboard/".$_GET['leave_id']."/".$_GET['type']);
            } else {
                redirect(HTTP_SERVER . "dashboard");
            }

            exit();
        }

        $field = array('login_id', "from_date", "to_date", "from_time", "to_time", "half_day", "is_active");
        $value = array($loginid, date("Y-m-d", strtotime($from_date_time[0])), date("Y-m-d", strtotime($to_date_time[0])), trim($from_date_time[1]), trim($to_date_time[1]), $half_day, 1);
        $staus_array = array_combine($field, $value);

        if ($leave_id > 0) {
            $obj->update($staus_array, 'leaves', array('leave_id' => $leave_id));
        } else {
            $obj->insert($staus_array, 'leaves');
        }

        $objsession->set('leave_message', 'Leave added successfully.');

        redirect(HTTP_SERVER . "dashboard");

    }

    $cond = "inquiry_list.is_active =:active AND inquiry_list.is_register =:is_register AND follow_up.date_of_follow =:date_of_follow AND follow_up.is_active =:follow_up_active ";
    $params = array(":active" => 1, ':is_register' => 0, ":date_of_follow" => date("Y-m-d"), ":follow_up_active" => 1);
    $previousInquiry = $obj->fetchRowwithjoin('inquiry_list', 'follow_up', 'inquiry_id', 'inquiry_id', $cond, $params);

    ?>

    <?php
    $cond = "is_active =:active AND DATE(appo_date_time) =:appo_date_time AND is_open=:is_open ORDER BY app_id DESC";
    $params = array(":active" => 1, ':appo_date_time' => date("Y-m-d"), ":is_open" => 1);
    $appoinments = $obj->fetchRowAll('appoinments', $cond, $params);

    ?>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-action">
                    Today's Followup LIst
                </div>
                <div class="card-content">
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
                    <ul class="collapsible" data-collapsible="accordion">
                        <li class="active">
                            <div class="collapsible-header active"><i class="material-icons">filter_drama</i>Click</div>
                            <div class="collapsible-body">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Mobile No</th>
                                        <th>Date of Birth</th>
                                        <th>No of Inquiry</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($previousInquiry)) {

                                        for ($i = 0; $i < count($previousInquiry); $i++) {

                                            $cond = "inquiry_id =:inquiry_id AND date_of_follow !=:date_of_follow";
                                            $params = array(":inquiry_id" => $previousInquiry[$i]['inquiry_id'], ':date_of_follow' => "0000-00-00");
                                            $no_of_inquiry = $obj->countInquiry('follow_up', 'follow_up_id', $cond, $params);

                                            ?>
                                            <tr class="odd gradeX">
                                                <td width="200"><?php echo $previousInquiry[$i]['first_name'] . " " . $previousInquiry[$i]['middle_name'] . " " . $previousInquiry[$i]['last_name']; ?></td>
                                                <td width="250"><?php echo $previousInquiry[$i]['address1']; ?></td>
                                                <td width="250"><?php echo $previousInquiry[$i]['email_address']; ?></td>
                                                <td width="250"><?php echo $previousInquiry[$i]['mobile_number']; ?></td>
                                                <td width="250"><?php echo date("d-m-Y", strtotime($previousInquiry[$i]['date_of_birth'])); ?></td>
                                                <td width="250">
                                                    <a class="no_of_count" title="No of Inquiry"
                                                       data-id="<?php echo $previousInquiry[$i]['inquiry_id']; ?>"
                                                       href="javascipt:void(0)" class="next_btn_pop">
                                                        <?php echo $no_of_inquiry['list_of_count']; ?>
                                                    </a>
                                                </td>
                                                <td width="180" class="text-center">
                                                    <a title="Appointment"
                                                       data-id="<?php echo $previousInquiry[$i]['inquiry_id']; ?>"
                                                       href="javascipt:void(0)" class="next_btn_pop"><i
                                                                style="padding: 0px;font-size: 20px;"
                                                                class="fa fa-calendar"

                                                                aria-hidden="true"></i></a>
                                                    <a data-id="<?php echo $previousInquiry[$i]['email_address']; ?>"
                                                       href="javascipt:void(0)" class="mail_btn_pop"
                                                       title="Send Mail"><i
                                                                style="padding: 5px;font-size: 20px;"
                                                                class="fa fa-envelope"
                                                                aria-hidden="true"></i></a>
                                                </td>
                                            </tr>

                                        <?php }
                                    } ?>

                                    </tbody>
                                </table>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="card">
                <div class="card-action">
                    Today's Appointment List
                </div>
                <div class="card-content">
                    <?php if ($objsession->get('appo_message') != "") {
                        ?>
                        <div class="alert alert-success">
                            <?php echo $objsession->get('appo_message'); ?>
                        </div>
                        <?php $objsession->remove('appo_message');
                    } ?>
                    <ul class="collapsible" data-collapsible="accordion">
                        <li class="active">
                            <div class="collapsible-header active"><i class="material-icons">filter_drama</i>Click</div>
                            <div class="collapsible-body">
                                <table class="table table-striped table-bordered table-hover"
                                       id="dataTables-Appointment">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Appointment With</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Email</th>
                                        <th>Mobile No</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($appoinments)) {
                                        $ex_appointment = 0;
                                        $today = date("Y-m-d H:i");

                                        for ($i = 0; $i < count($appoinments); $i++) {

                                            $cond = "login_id = :master_id";
                                            $params = array(":master_id" => $appoinments[$i]['appo_with']);

                                            $app_with = $obj->fetchRow('users', $cond, $params);


                                            $appDate = $appoinments[$i]['appo_date_time'];

                                            if (strtotime($today) <= strtotime($appDate)) {


                                                ?>
                                                <tr class="odd gradeX">
                                                    <td width="200"><?php echo $appoinments[$i]['name']; ?></td>
                                                    <td width="250"><?php echo $app_with['full_name']; ?></td>
                                                    <td width="250"><?php echo date("d/m/Y", strtotime($appoinments[$i]['appo_date_time'])); ?></td>
                                                    <td width="250"><?php echo date("H:i", strtotime($appoinments[$i]['appo_date_time'])); ?></td>
                                                    <td width="250"><?php echo $appoinments[$i]['email_address']; ?></td>
                                                    <td width="250"><?php echo $appoinments[$i]['mobile_no1']; ?></td>
                                                    <td width="250"><?php
                                                        if ($appoinments[$i]['is_open'] == 1 && $ex_appointment == 0) {
                                                            $appo_status = "Open";
                                                            $cls = "progress-bar-success change_app_status";
                                                        } else {
                                                            $appo_status = "Close";
                                                            $cls = "progress-bar-danger";
                                                        }
                                                        ?>

                                                        <a href="javascript:void(0)" style='color: #FFF;padding: 4px;'
                                                           class='<?php echo $cls; ?>'
                                                           data-id="<?php echo $appoinments[$i]['app_id']; ?>"><?php echo $appo_status; ?></a>
                                                    </td>
                                                </tr>

                                                <?php $ex_appointment = 0;
                                            }
                                        }
                                    } ?>

                                    </tbody>
                                </table>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <!--Popup for Send Mail-->
    <button type="button" class="btn btn-info btn-lg" id="firstPopup" data-toggle="modal" data-target="#popupCalander"
            style="display: none;">Open Modal
    </button>
    <!-- Modal -->
    <div id="popupCalander" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form id="frmFollowup" class="wizard clearfix fv-form fv-form-bootstrap"
                  method="post">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Next Appointment</h4>
                    </div>
                    <div class="modal-body">
                        <input id="inquiry_id" name="inquiry_id" type="hidden" value="0">
                        <input id="date_of_follow" name="date_of_follow" type="text"
                               class="validate"
                               value="<?php if (!empty($follow_up_data)) {
                                   if (date("Y-m-d", strtotime($follow_up_data['date_of_follow'])) != "1970-01-01") {
                                       echo date("d-m-Y H:i", strtotime($follow_up_data['date_of_follow']));
                                   }
                               } ?>">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="waves-effect waves-light btn"
                               name="btn_follow_yes" value="Folloup">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Popup for Send Mail-->
    <button type="button" class="btn btn-info btn-lg" id="secondPopup" data-toggle="modal"
            data-target="#popupInquiryCount" style="display: none;">Open Modal
    </button>
    <!-- Modal -->
    <div id="popupInquiryCount" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form id="frmFollowup" class="wizard clearfix fv-form fv-form-bootstrap"
                  method="post">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">List of Inquiry Dates</h4>
                    </div>
                    <div class="modal-body">
                        <ul class="bind_in_count"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Popup for Send Mail-->
    <button type="button" class="btn btn-info btn-lg" id="thirdPopup" data-toggle="modal" data-target="#popupMail"
            style="display: none;">Open Modal
    </button>
    <!-- Modal -->
    <div id="popupMail" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form id="frmFollowupMail" class="wizard clearfix fv-form fv-form-bootstrap"
                  method="post">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Inquiry Folloup Mail</h4>
                    </div>
                    <div class="modal-body">
                        <span id="err-msg-mail"></span>
                        <input type="hidden" name="user_email_id" id="user_email_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="send_confirm_mail" class="btn btn-default">Confirm</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Appointment Popup-->
    <button type="button" class="btn btn-info btn-lg" id="btn_sts_clk" data-toggle="modal" data-target="#apo_status"
            style="display: none;">Open Modal
    </button>
    <!-- Modal -->
    <div id="apo_status" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form id="updateAppDetails" method="post">
                <input id="app_id" name="app_id" type="hidden" value="0">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Appointment Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="input-field col s1">
                                <label>Name : </label>
                            </div>
                            <div class="input-field col s6">
                                <p id="name"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s3">
                                <label>Appointment With : </label>
                            </div>
                            <div class="input-field col s6">
                                <p id="app_with"></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col s12">
                                <div class="input-field col s1">
                                    <label for="gender">Status</label>
                                </div>
                                <div class="input-field col s7">
                                    <input class="with-gap" name="app_status"
                                           type="radio" id="open"
                                           value="1"/>
                                    <label for="open">Open</label>

                                    <input class="with-gap" name="app_status"
                                           type="radio" id="close"
                                           value="0"/>
                                    <label for="close">Cancel</label>

                                    <input class="with-gap" name="app_status"
                                           type="radio" id="attended"
                                           value="2"/>
                                    <label for="attended">Attended</label>
                                    <input class="with-gap" name="app_status"
                                           type="radio" id="expired"
                                           value="1"/>
                                    <label for="expired">Expired</label>
                                    <span id="app_status_msg"></span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">

                            <div class="col s1">
                                <label for="reason">Reason</label>
                            </div>
                            <div class="col s6">
                                <textarea name="txt_reason" id="txt_reason"></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default" name="btn_reg_btn" value="CHANGE">
                        <button type="button" class="btn btn-default" id="btn_sts_btn_close" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include_once '../include/footer.php'; ?>
    <script src="<?php echo HTTP_SERVER; ?>assets/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <link href="<?php echo HTTP_SERVER; ?>assets/css/bootstrap-datetimepicker.css" rel="Stylesheet"
          type="text/css"/>
    <style>
        #dataTables-example_wrapper {
            margin-top: 15px;
        }

        #dataTables-Appointment_wrapper {
            margin-top: 15px;
        }

        .bind_in_count li {
            display: inline-block;
            width: 48%;
        }
    </style>
    <script src="<?php echo HTTP_SERVER; ?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo HTTP_SERVER; ?>assets/js/dataTables/dataTables.bootstrap.js"></script>

    <script>
        $(document).ready(function () {

            var startDate = new Date();
            var FromEndDate = new Date();
            var ToEndDate = new Date();
            ToEndDate.setDate(ToEndDate.getDate() + 365);

            $('#from_date_time').datetimepicker({
                startDate: startDate,
                autoclose: true,
                minuteStep: 30,
                format: "dd/mm/yyyy hh:ii",
            });

            $('#to_date_time').datetimepicker({
                startDate: startDate,
                autoclose: true,
                minuteStep: 30,
                format: "dd/mm/yyyy hh:ii",
            });

            var base_url = "<?php echo HTTP_SERVER;?>";

            $('#dataTables-Leave').DataTable({
                "ordering": false,
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
            });

            $('#dataTables-example').DataTable({
                "ordering": false,
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
            });

            $('#dataTables-Appointment').DataTable({
                "ordering": false,
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
            });

            $("#frmLeave").validate({
                debug: false,
                errorClass: "error",
                errorElement: "span",
                rules: {
                    from_date_time: "required",
                    to_date_time: "required",
                },
                messages: {
                    from_date_time: "Please enter your start date",
                    to_date_time: "Please enter your to date",
                },
                highlight: function (element, errorClass) {
                    $('input').removeClass('error');
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

            $(".next_btn_pop").click(function () {
                var id = $(this).data('id');
                if (id > 0) {
                    $("#inquiry_id").val(id);
                    $("#firstPopup").click();
                }
            });

            $(".mail_btn_pop").click(function () {
                var id = $(this).data('id');

                $("#err-msg-mail").text("");
                if (id == "") {
                    $("#err-msg-mail").text("Mail id not found");
                } else {
                    $("#err-msg-mail").text("Send Inquiry Folloup on this mail id : " + id);
                }
                $("#user_email_id").val(id);
                $("#thirdPopup").click();
            });

            $(".no_of_count").click(function () {
                var id = $(this).data('id');
                if (id > 0) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "get_folloup_date?inquiry_id=" + id,
                        data: $("#frmFollowup").serialize(),
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            var str = "";
                            if (response.status == true) {

                                for (var i = 0; i < response.data.length; i++) {
                                    str += "<li>" + response.data[i].date_of_follow + "</li>";
                                }

                                $(".bind_in_count").html(str);

                                $("#secondPopup").click();

                            } else if (response.status == false) {
                                alert("Something went wrong...!");
                                return false;
                            }
                        }
                    });
                }
            });

            $('#date_of_follow').datetimepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                minView: 2
            });

            $('#frmFollowupMail').on('click', '#send_confirm_mail', function (e) {

                $.ajax({
                    type: "POST",
                    url: base_url + "send_followup_mail",
                    data: $("#frmFollowupMail").serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {

                            window.location.href = "<?php echo HTTP_SERVER; ?>dashboard";

                        } else if (response.status == false) {
                            alert("Something went wrong...!");
                            return false;
                        }
                    }
                });
            });

            $("#frmFollowup").validate({
                debug: false,
                errorClass: "error",
                errorElement: "span",
                rules: {
                    date_of_follow: "required",
                },
                messages: {
                    date_of_follow: "Please select your folloup date",
                },
                highlight: function (element, errorClass) {
                    $('input').removeClass('error');
                },
                submitHandler: function (form) {

                    var inquiry_id = $("#inquiry_id").val();

                    $.ajax({
                        type: "POST",
                        url: base_url + "submit_folloup_date",
                        data: $("#frmFollowup").serialize(),
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.status == true) {

                                window.location.href = "<?php echo HTTP_SERVER; ?>dashboard";

                            } else if (response.status == false) {
                                alert("Something went wrong...!");
                                return false;
                            }
                        }
                    });

                }
            });

            /*Appointment section*/
            $(".change_app_status").click(function () {
                var id = $(this).data('id');

                if (id > 0) {
                    $("#app_id").val(id);

                    $.ajax({
                        type: "POST",
                        url: base_url + "get_appo_details?appo_id=" + id,
                        data: $("#reg_form").serialize(),
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.status == true) {
                                $("#name").text(response.name);
                                $("#app_with").text(response.app_with);
                                if (response.appo_status == 1) {
                                    $("#open").prop('checked', true);
                                } else {
                                    $("#close").prop('checked', true);
                                }
                                if (response.reason != "") {
                                    $("#txt_reason").text(response.reason);
                                }
                                $("#name").text(response.name);
                                $("#btn_sts_clk").click();
                            } else if (response.status == false) {
                                alert("Something went wrong...!");
                                return false;
                            }
                        }
                    });
                }
            });

            $("#updateAppDetails").validate({
                debug: false,
                errorClass: "error",
                errorElement: "span",
                rules: {
                    app_status: "required",
                },
                messages: {
                    app_status: "Please enter passport number",
                },
                highlight: function (element, errorClass) {
                    $('input').removeClass('error');
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "app_status") {
                        error.insertAfter("#app_status_msg");
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {

                    var app_id = $("#app_id").val();

                    $.ajax({
                        type: "POST",
                        url: base_url + "update_appointment_status?app_id=" + app_id,
                        data: $("#updateAppDetails").serialize(),
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.status == true) {
                                window.location.reload();
                            } else if (response.status == false) {
                                alert("Something went wrong...!");
                                return false;
                            }
                        }
                    });

                }
            });
        });
    </script>