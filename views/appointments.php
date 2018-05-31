<?php include_once '../include/header.php'; ?>
<?php

$loginid = $objsession->get("log_admin_loginid");

if ($objsession->get('log_admin_type') != 'admin') {
    /*$cond = "is_active =:active AND is_open =:is_open AND DATE(appo_date_time) >=:appo_date_time AND appo_with=:created_by ORDER BY app_id DESC";
    $params = array(":active" => 1, ":is_open" => 1, ":appo_date_time" => date("Y-m-d"), ":created_by" => $loginid);*/

    $cond = "is_active =:active AND is_open =:is_open AND DATE(appo_date_time) >=:appo_date_time ORDER BY appo_date_time DESC";
    $params = array(":active" => 1, ":is_open" => 1, ":appo_date_time" => date("Y-m-d"));

} else {
    $cond = "is_active =:active AND is_open =:is_open AND DATE(appo_date_time) >=:appo_date_time ORDER BY appo_date_time DESC";
    $params = array(":active" => 1, ":is_open" => 1, ":appo_date_time" => date("Y-m-d"));
}

$appoinments = $obj->fetchRowAll('appoinments', $cond, $params);

$cond = "is_active =:active";
$params = array(":active" => 1);

$appoWith = $obj->fetchRowAll('users', $cond, $params);

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
    <h1 class="page-header pull-left"> Appointments Manager</h1>
    <div class="add-button">
        <a href="<?php echo HTTP_SERVER; ?>appointment" class="btn-floating"><i class="material-icons">add</i></a>
    </div>
    <div class="clearfix"></div>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li class="active">Appointment Manager List</li>
    </ol>
</div>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">

            <?php if ($objsession->get('appo_message') != "") {
                ?>
                <div class="alert alert-success">
                    <?php echo $objsession->get('appo_message'); ?>
                </div>
                <?php $objsession->remove('appo_message');
            } ?>
            <!-- Advanced Tables -->
            <div class="card">
                <div class="card-content">
                    <div class="table-responsive">
                        <div style="float: right;width: 55%;">
                            <div class="col s2">
                                <label for="gender">Filter: &nbsp;&nbsp;&nbsp;</label>
                            </div>
                            <div class="col s8">
                                <input class="with-gap filterDataWithStatus" name="filter_status"
                                       type="radio" id="filterAll"
                                       value="All"/>
                                <label for="filterAll">All</label>

                                <input class="with-gap filterDataWithStatus" name="filter_status"
                                       type="radio" id="filterOpen"
                                       value="1"/>
                                <label for="filterOpen">Open</label>

                                <input class="with-gap filterDataWithStatus" name="filter_status"
                                       type="radio" id="filterClose"
                                       value="0"/>
                                <label for="filterClose">Cancel</label>

                                <input class="with-gap filterDataWithStatus" name="filter_status"
                                       type="radio" id="filterAttended"
                                       value="2"/>
                                <label for="filterAttended">Attended</label>

                                <input class="with-gap filterDataWithStatus" name="filter_status"
                                       type="radio" id="filterExpired"
                                       value="3"/>
                                <label for="filterExpired">Expired</label>
                                <span id="app_status_msg"></span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <form id="masterFrm" method="post">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Appointment With</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Status</th>
                                    <th>Re-appointment</th>
                                    <th>Action</th>
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
                                        if (strtotime($today) <= strtotime($appDate) && $appoinments[$i]['is_open'] == 1) {

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
                                                                            href="<?php echo HTTP_SERVER; ?>appointments/<?php echo $appoinments[$i]['app_id']; ?>"
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
                                                <td width="500"><?php echo $appoinments[$i]['name']; ?></td>
                                                <td width="150"><?php echo $app_with['full_name']; ?></td>
                                                <td width="250"><?php echo date("d/m/Y", strtotime($appoinments[$i]['appo_date_time'])); ?></td>
                                                <td width="250"><?php echo date("H:i", strtotime($appoinments[$i]['appo_date_time'])); ?></td>
                                                <td width="250"><?php echo $appoinments[$i]['email_address']; ?></td>
                                                <td width="250"><?php echo $appoinments[$i]['mobile_no1']; ?></td>
                                                <td width="250"><?php
                                                    $click = "Click";
                                                    if ($ex_appointment == 1) {
                                                        $appo_status = "Expired";
                                                        $cls = "progress-bar-danger change_app_status";
                                                    } else {
                                                        if ($appoinments[$i]['is_open'] == 1) {
                                                            $appo_status = "Open";
                                                            $click = "---";
                                                            $cls = "progress-bar-warning change_app_status";
                                                        } else if ($appoinments[$i]['is_open'] == 0) {
                                                            $appo_status = "Cancel";
                                                            $cls = "progress-bar-danger change_app_status";
                                                        } else if ($appoinments[$i]['is_open'] == 2) {
                                                            $appo_status = "Attended";
                                                            $cls = "progress-bar-success change_app_status";
                                                        }
                                                    }
                                                    ?>

                                                    <a href="javascript:void(0)" style="color: #FFF;padding: 4px;"
                                                       class="<?php echo $cls; ?>"
                                                       data-id="<?php echo $appoinments[$i]['app_id']; ?>"><?php echo $appo_status; ?></a>
                                                </td>
                                                <td width="250"><?php
                                                    $cls = "";

                                                    if ($ex_appointment == 1) {
                                                        $appo_status = "Expired";
                                                        $cls = "re_appointment";
                                                    } else {
                                                        if ($appoinments[$i]['is_open'] == 0) {
                                                            $appo_status = "Cancel";
                                                            $cls = "re_appointment";
                                                        } else if ($appoinments[$i]['is_open'] == 2) {
                                                            $appo_status = "Attended";
                                                            $cls = "re_appointment";
                                                        }
                                                    }
                                                    ?>

                                                    <a style="text-decoration: none;" href="javascript:void(0)"
                                                       class="<?php echo $cls; ?>"
                                                       data-id="<?php echo $appoinments[$i]['app_id']; ?>"
                                                       data-title="<?php echo $appoinments[$i]['appo_with']; ?>"><?php echo $click; ?></a>
                                                </td>
                                                <td width="220" class="text-center">
                                                    <a data-id="<?php echo $appoinments[$i]['app_id']; ?>"
                                                       href="<?php echo HTTP_SERVER; ?>appointment/<?php echo $appoinments[$i]['app_id']; ?>"><i
                                                                style="padding: 0px;font-size: 20px;"
                                                                class="fa fa-pencil-square-o"

                                                                aria-hidden="true"></i></a>
                                                    <a href="#_delete<?php echo $i; ?>" data-toggle="modal"><i
                                                                style="padding: 2px;font-size: 20px;"
                                                                class="fa fa-times"
                                                                aria-hidden="true"></i></a>

                                                    <a href="<?php echo HTTP_SERVER; ?>appointmentdetail/<?php echo $appoinments[$i]['app_id']; ?>"><i
                                                                style="padding: 2px;font-size: 20px;" class="fa fa-eye"
                                                                aria-hidden="true"></i></a>
                                                    <!--<a href="javascript:void(0)" class="reg_btn_pop"
                                                   data-id="<?php /*echo $appoinments[$i]['app_id']; */ ?>"><i
                                                            style="font-size: 20px;" class="fa fa-sign-in"
                                                            aria-hidden="true"></i></a>-->
                                                </td>
                                            </tr>

                                            <?php //$ex_appointment = 0;
                                        }
                                    }
                                } ?>

                                </tbody>
                            </table>
                            <div class="filter-data"></div>
                        </form>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>

    <button type="button" class="btn btn-info btn-lg" id="btn_sts_clk" data-toggle="modal" data-target="#apo_status"
            style="display: none;">Click
    </button>
    <!--Change Appontment staus -->
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

    <button type="button" class="btn btn-info btn-lg" id="btn_re_appo_clk" data-toggle="modal" data-target="#re_appo"
            style="display: none;">Click
    </button>
    <!--Re Appointment for grid -->
    <div id="re_appo" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form id="reAppo" method="post">
                <input id="re_app_id" name="app_id" type="hidden" value="0">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Re - Appointment</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="col-md-12 col-sm-12">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Appointment With :</label>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <select name="appo_with" class="form-control clear_class"
                                                id="appo_with">
                                            <option value="">---Select---</option>
                                            <?php if (!empty($appoWith)) {
                                                $selected = "";
                                                for ($i = 0; $i < count($appoWith); $i++) {
                                                    if (!empty($row)) {
                                                        if ($row['appo_with'] == $appoWith[$i]['login_id']) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                    }
                                                    ?>
                                                    <option <?php echo $selected; ?>
                                                            value="<?php echo $appoWith[$i]['login_id']; ?>">
                                                        <?php echo ucwords($appoWith[$i]['full_name']); ?></option>
                                                    <?php $selected = '';
                                                }
                                            } ?>
                                        </select>
                                        <input type="text" name="other_with" id="other_with"
                                               placeholder="Other Appointment"
                                               style="margin:15px 0px;display:none;" class="form-control"
                                               value="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <div class="input-field col s3">
                                    <label>Appointment Date : </label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="appo_date_time" name="appo_date_time" type="text"
                                           class="validate"
                                           value="<?php if (!empty($row)) {
                                               echo date("d/m/Y H:i", strtotime($row['appo_date_time']));
                                           } ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="alert alert-danger" id="error-msg" style="display: none;">
                                <strong>Oops! Sorry,</strong> <span id="er-msg"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default" name="btn_reg_btn" value="SAVE">
                        <button type="button" class="btn btn-default" id="btn_sts_btn_close" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php

    if (isset($_GET['app_id'])) {
        $data = array('is_active' => 0);
        if ($obj->update($data, 'appoinments', array('app_id' => $_GET['app_id'])) == true) {
            $objsession->set('ads_message', 'Appoinment successfully deleted.');
            redirect(HTTP_SERVER . "appointments");
        }
    }
    ?>
    <?php include_once '../include/footer.php'; ?>

    <script src="<?php echo HTTP_SERVER; ?>assets/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <link href="<?php echo HTTP_SERVER; ?>assets/css/bootstrap-datetimepicker.css" rel="Stylesheet"
          type="text/css"/>

    <script src="<?php echo HTTP_SERVER; ?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo HTTP_SERVER; ?>assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>

        $(document).ready(function () {

            var base_url = "<?php echo HTTP_SERVER; ?>";
            $('#passport_issue_date').datetimepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                minView: 2
            });

            $('#passport_expire_date').datetimepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                minView: 2
            });

            $('#dataTables-example').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ordering": false,
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
            }).on('page.dt', function () {
                $('html, body').animate({
                    scrollTop: $(".page-header").offset().top
                }, 'slow');
            });

            $(document.body).on('click', '.change_app_status', function () {
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
                                } else if (response.appo_status == 2) {
                                    $("#attended").prop('checked', true);
                                } else if (response.appo_status == 0) {
                                    $("#close").prop('checked', true);
                                } else if (response.appo_status == 3) {
                                    $("#expired").prop('checked', true);
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

            $(document.body).on('click', '.re_appointment', function () {
                var id = $(this).data('id');
                var a_with = $(this).data('title');

                if (id > 0) {
                    $("#re_app_id").val(id);
                    $("#btn_re_appo_clk").click();
                }
            });

            $(".filterDataWithStatus").click(function () {

                var id = $(this).val();

                if (id != "") {

                    $.ajax({
                        type: "POST",
                        url: base_url + "get_filter_appointments?appo_id=" + id,
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.status == true) {

                                $('#dataTables-example').dataTable().fnClearTable();

                                if (response.data.length > 0) {

                                    var t = $('#dataTables-example').DataTable();
                                    var strData = "";

                                    for (var i = 0; i < response.data.length; i++) {

                                        strData += '<div class="modal fade" id="_delete' + i + '" tabindex="-1"\n' +
                                            '                                             role="dialog" aria-labelledby="myModalLabel">\n' +
                                            '\n' +
                                            '                                            <div class="modal-dialog" role="document">\n' +
                                            '                                                <div class="modal-content">\n' +
                                            '                                                    <div class="modal-body">\n' +
                                            '                                                        <p class="text-center"><strong>Are you 100% sure about\n' +
                                            '                                                                this?</strong></p>\n' +
                                            '                                                        <br/>\n' +
                                            '                                                        <div class="inputer">\n' +
                                            '                                                            <div class="input-wrapper text-center"><a\n' +
                                            '                                                                        href="<?php echo HTTP_SERVER; ?>appointments/' + response.data[i].app_id + '"\n' +
                                            '                                                                        class="btn btn-success reload">Yes</a>\n' +
                                            '                                                                <button type="button" class="btn btn-success reload"\n' +
                                            '                                                                        data-dismiss="modal" aria-label="Close">No\n' +
                                            '                                                                </button>\n' +
                                            '                                                            </div>\n' +
                                            '                                                        </div>\n' +
                                            '                                                    </div>\n' +
                                            '                                                </div>\n' +
                                            '                                            </div>\n' +
                                            '                                        </div>';

                                        var link = '<a href="<?php echo HTTP_SERVER; ?>appointment/' + response.data[i].app_id + '" ><i\n style="padding: 0px;font-size: 20px;"\n class="fa fa-pencil-square-o"\n aria-hidden="true"></i></a><a href="#_delete' + i + '" data-toggle="modal"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a><a href="<?php echo HTTP_SERVER; ?>appointmentdetail/' + response.data[i].app_id + '" ><i\n style="padding: 2px;font-size: 20px;" class="fa fa-eye"\n aria-hidden="true"></i></a>';

                                        t.row.add([
                                            response.data[i].name,
                                            response.data[i].app_with,
                                            response.data[i].appo_date,
                                            response.data[i].appo_time,
                                            response.data[i].email_address,
                                            response.data[i].mobile_no1,
                                            response.data[i].status,
                                            response.data[i].reApp,
                                            link
                                        ]).draw(false);
                                    }
                                }

                                $(".filter-data").append(strData);

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

            $("#reAppo").validate({
                debug: false,
                errorClass: "error",
                errorElement: "span",
                rules: {
                    appo_date_time: "required",
                },
                messages: {
                    appo_date_time: "Please select appointment date",
                },
                highlight: function (element, errorClass) {
                    $('input').removeClass('error');
                },
                submitHandler: function (form) {

                    var app_id = $("#re_app_id").val();

                    $.ajax({
                        type: "POST",
                        url: base_url + "reappointment",
                        data: $("#reAppo").serialize(),
                        dataType: "json",
                        success: function (response) {
                            console.log(response);

                            $("#error-msg").hide();
                            $("#er-msg").text("");

                            if (response.status == true) {
                                window.location.href = "<?php echo HTTP_SERVER;?>appointments";
                            } else if (response.status == false) {
                                $("#error-msg").show();
                                $("#er-msg").text(response.message);
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 800);
                            }
                        }
                    });

                }
            });

            var startDate = new Date();
            var FromEndDate = new Date();
            var ToEndDate = new Date();
            ToEndDate.setDate(ToEndDate.getDate() + 365);

            $('#appo_date_time').datetimepicker({
                startDate: startDate,
                autoclose: true,
                minuteStep: 30,
                format: "dd/mm/yyyy hh:ii",
            });

        });
    </script>