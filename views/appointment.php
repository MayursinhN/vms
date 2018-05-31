<?php include_once '../include/header.php'; ?>
<?php

$row = array();
$loginid = $objsession->get("log_admin_loginid");
$app_id = 0;

if (isset($_GET['app_id'])) {
    $cond = '';
    $app_id = $_GET['app_id'];
    $cond = "app_id=:app_id";
    $params = array(":app_id" => $app_id);
    $row = $obj->fetchRow('appoinments', $cond, $params);
}

$cond = "is_active =:active";
$params = array(":active" => 1);

$appoWith = $obj->fetchRowAll('users', $cond, $params);

$cond = "is_active =:active AND category_name =:category";
$params = array(":active" => 1, ":category" => 'Visitor');
$userTypes = $obj->fetchRowAll('masters_list', $cond, $params);

?>
<style type="text/css">
    .fa {
        padding: 0px !important;
    }

    #profile_image-error {
        padding-top: 12px;
        display: block;
    }
</style>
<div class="header">
    <h1 class="page-header"> Appointment </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li><a href="<?php echo HTTP_SERVER; ?>appointments">List of Appointments</a></li>
        <li class="active">Manage Appointment</li>
    </ol>
</div>
<div id="page-inner">
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="alert alert-danger" id="error-msg" style="display: none;">
                    <strong>Oops! Sorry,</strong> <span id="er-msg"></span>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="row">
                        <div class="padding20">
                            <form name="frmFirstDetail" method="post" id="frmFirstDetail">
                                <input type="hidden" name="app_id" id="app_id" value="<?php echo $app_id; ?>">

                                <?php if (empty($row)) { ?>
                                    <div id="app_second_detail">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>You have previous appointment :</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="with-gap have-app" name="hve_app"
                                                       type="radio" id="app_yes"
                                                       value="1"/>
                                                <label for="app_yes">Yes</label>

                                                <input class="with-gap have-app" name="hve_app"
                                                       type="radio" id="app_no"
                                                       value="0"/>
                                                <label for="app_no">No</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-6 col-sm-6" style="display: none;" id="appointment-div">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Mobile No.</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <input id="mob_number" name="mob_number" type="text"
                                                           class="validate"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="clearfix"></div>
                                <div id="app_first_detail" <?php if (empty($row)) { ?> style="display: none;"<?php } ?>>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Type :</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">

                                                <input id="purpose_hidden" name="purpose_hidden" type="hidden"
                                                       class="validate"
                                                       value="">

                                                <input id="purpose_id" name="purpose_id" type="hidden" class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['purpose'];
                                                       } ?>">

                                                <select name="user_types" class="form-control clear_class"
                                                        id="user_types">
                                                    <option value="">---Select---</option>
                                                    <?php if (!empty($userTypes)) {
                                                        $selected = "";
                                                        foreach ($userTypes as $key => $val) {
                                                            if (!empty($row)) {
                                                                if ($row['user_type'] == $val['master_id']) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                            }
                                                            ?>
                                                            <option <?php echo $selected; ?>
                                                                    value="<?php echo $val['master_id']; ?>">
                                                                <?php echo ucwords($val['name']); ?></option>
                                                            <?php $selected = '';
                                                        }
                                                    } ?>
                                                    <option value="0">Other</option>
                                                </select>
                                                <input type="text" name="other_types" id="other_types"
                                                       placeholder="Other Visitor Type"
                                                       style="margin:15px 0px;display:none;" class="form-control"
                                                       value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Purpose :</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <select name="purpose" class="form-control clear_class" id="purpose">
                                                    <option value="">---Select---</option>
                                                </select>
                                                <input type="text" name="other_purpose" id="other_purpose"
                                                       placeholder="Other Purpose Name"
                                                       style="margin:15px 0px;display:none;" class="form-control"
                                                       value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-sm-6">
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
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Details</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <textarea name="details" class="clear_class"
                                                          id="details"><?php if (!empty($row)) {
                                                        echo $row['details'];
                                                    } ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-sm-6" style="display: none;" id="file-div">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>File No.</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <input id="file_number" name="file_number" type="text" class="validate"
                                                       value="<?php if (!empty($row)) {
                                                           echo $row['file_number'];
                                                       } ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div id="app_second_detail">

                                        <div class="input-field col s6">
                                            <input id="app_id" name="app_id" type="hidden"
                                                   value="<?php if (!empty($row)) {
                                                       echo $row['app_id'];
                                                   } else {
                                                       echo "0";
                                                   } ?>">

                                            <input id="name" name="name" type="text" class="validate clear_class"
                                                   value="<?php if (!empty($row)) {
                                                       echo $row['name'];
                                                   } ?>">
                                            <label for="name">Full Name</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input id="email_address" name="email_address" type="text"
                                                   class="validate clear_class"
                                                   value="<?php if (!empty($row)) {
                                                       echo $row['email_address'];
                                                   } ?>">
                                            <label for="email_address">Email Address</label>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="input-field col s6">
                                            <input id="mobile_no1" name="mobile_no1" type="text"
                                                   class="validate clear_class"
                                                   value="<?php if (!empty($row)) {
                                                       echo $row['mobile_no1'];
                                                   } ?>">
                                            <label for="mobile_no1">Mobile No. 1</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input id="mobile_no2" name="mobile_no2" type="text"
                                                   class="validate clear_class"
                                                   value="<?php if (!empty($row)) {
                                                       echo $row['mobile_no2'];
                                                   } ?>">
                                            <label for="mobile_no2">Mobile No. 2</label>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="input-field col s6">
                                            <input id="appo_date_time" name="appo_date_time" type="text"
                                                   class="validate"
                                                   value="<?php if (!empty($row)) {
                                                       echo date("d/m/Y H:i", strtotime($row['appo_date_time']));
                                                   } ?>">
                                            <label for="appo_date_time">Appointment Date & Time</label>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php if (!empty($row)) { ?>
                                                    <input type="submit" name="btn_update"
                                                           class="waves-effect waves-light btn"
                                                           value="SAVE">
                                                <?php } else { ?>
                                                    <input type="submit" name="btn_add"
                                                           class="waves-effect waves-light btn"
                                                           value="SAVE">
                                                <?php } ?>
                                                <a href="<?php echo HTTP_SERVER; ?>appointments"
                                                   class="waves-effect waves-light btn">CANCEL</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    if (isset($_POST['btn_add'])) {

        extract($_POST);

        $currentDate = date('Y-m-d');

        if ($user_types == 0) {
            $field = array('name', 'category_name', 'is_active');
            $value = array($other_types, "Visitor", 1);
            $types_array = array_combine($field, $value);
            $user_types = $obj->insert($types_array, 'masters_list');
        }

        if ($purpose == 0) {
            $field = array('name', 'category_name', 'other', 'is_active');
            $value = array($other_purpose, "purpose", $user_types, 1);
            $purpose_array = array_combine($field, $value);
            $purpose = $obj->insert($purpose_array, 'masters_list');

        }

        if ($appo_with == 0) {
            $field = array('name', 'category_name', 'is_active');
            $value = array($other_with, "Appointment with", 1);
            $with_array = array_combine($field, $value);
            $appo_with = $obj->insert($with_array, 'masters_list');

        }

        $fileNo = "";
        if ($user_types == 108) {
            $fileNo = $file_number;
        }

        $appo_date_time = str_replace('/', '-', $appo_date_time);

        $field = array('user_type', 'file_number', 'purpose', "appo_with", "details", "name", "mobile_no1", "mobile_no2", "email_address", "appo_date_time",
            "is_active", "is_open", "created_by", "created_date");
        $value = array($user_types, $fileNo, $purpose, $appo_with, $details, $name, $mobile_no1, $mobile_no2, $email_address, date("Y-m-d H:i", strtotime($appo_date_time)),
            1, 1, $loginid, $currentDate);
        $appo_array = array_combine($field, $value);

        $obj->insert($appo_array, 'appoinments');

        $objsession->set('appo_message', 'Appointment added successfully.');
        redirect(HTTP_SERVER . "appointments");
    }

    if (isset($_POST['btn_update'])) {

        extract($_POST);
        $currentDate = date('Y-m-d');

        if ($user_types == 0) {
            $field = array('name', 'category_name', 'is_active');
            $value = array($other_types, "Visitor", 1);
            $types_array = array_combine($field, $value);
            $user_types = $obj->insert($types_array, 'masters_list');
        }

        if ($purpose == 0) {
            $field = array('name', 'category_name', 'other', 'is_active');
            $value = array($other_purpose, "purpose", $user_types, 1);
            $purpose_array = array_combine($field, $value);
            $purpose = $obj->insert($purpose_array, 'masters_list');

        }

        if ($appo_with == 0) {
            $field = array('name', 'category_name', 'is_active');
            $value = array($other_with, "Appointment with", 1);
            $with_array = array_combine($field, $value);
            $appo_with = $obj->insert($with_array, 'masters_list');

        }

        $fileNo = "";
        if ($user_types == 108) {
            $fileNo = $file_number;
        }

        $field = array('user_type', 'file_number', 'purpose', "appo_with", "details", "name", "mobile_no1", "mobile_no2", "email_address", "appo_date_time",
            "is_active", "is_open", "modify_by", "modify_date");
        $value = array($user_types, $fileNo, $purpose, $appo_with, $details, $name, $mobile_no1, $mobile_no2, $email_address, date("Y-m-d H:i", strtotime($appo_date_time)),
            1, 1, $loginid, $currentDate);
        $appo_array = array_combine($field, $value);

        $obj->update($appo_array, 'appoinments', array('app_id' => $app_id));

        $objsession->set('appo_message', 'Appointment details updated successfully.');
        redirect(HTTP_SERVER . "appointments");
    }

    ?>
    <?php include_once '../include/footer.php'; ?>

    <script src="<?php echo HTTP_SERVER; ?>assets/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <link href="<?php echo HTTP_SERVER; ?>assets/css/bootstrap-datetimepicker.css" rel="Stylesheet"
          type="text/css"/>

    <script>
        $(document).ready(function () {

            var base_url = "<?php echo HTTP_SERVER; ?>";

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

            $('#frmFirstDetail').on('click', '.have-app', function (e) {
                var haveApp = $(this).val();
                $("#app_first_detail").hide();
                $("#appointment-div").hide();
                if (haveApp == 1) {
                    $("#appointment-div").show();
                } else {
                    $(".clear_class").val("");
                    $("#file-div").hide();
                    $("#app_first_detail").show();
                    $("#mob_number").val("");
                }
            });

            $('#mob_number').on('keyup keypress blur change', function (e) {
                var mob_number = $(this).val();
                $(".clear_class").val("");
                $("#file-div").hide();

                if (mob_number > 0) {

                    $.ajax({
                        type: "POST",
                        url: base_url + "get_appointment_details?mob_number=" + mob_number,
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.status == true) {
                                $("#name").val(response.data.name);
                                $("#email_address").val(response.data.email_address);
                                $("#mobile_no1").val(response.data.mobile_no1);
                                $("#mobile_no2").val(response.data.mobile_no2);
                                $("#user_types").val(response.data.user_type);
                                $("#appo_with").val(response.data.appo_with);
                                $("#details").val(response.data.details);
                                $("#user_types").change();
                                $("#file_number").val(response.data.file_number);

                                if (response.data.user_type == 108) {

                                    $("#file-div").show();
                                }

                                $("#app_first_detail").show();
                                $("#purpose_hidden").val(response.data.purpose)
                            }
                        }
                    });
                }
            });

            $('#file_number').on('keyup keypress blur change', function (e) {
                var fileNo = $(this).val();
                $(".clear_class").val("");

                if (fileNo > 0) {

                    $.ajax({
                        type: "POST",
                        url: base_url + "get_client_details?id=" + fileNo,
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.status == true) {
                                $("#name").val(response.data[0].first_name + " " + response.data[0].middle_name + " " + response.data[0].last_name);
                                $("#email_address").val(response.data[0].email_address);
                                $("#mobile_no1").val(response.data[0].mobile_number);
                                $("#mobile_no2").val(response.data[0].phone_number);
                            }
                        }
                    });
                }
            });

            $('#frmFirstDetail').on('change', '#user_types', function (e) {

                var user_types = $(this).val();
                var purpose_id = $("#purpose_id").val();

                if (purpose_id == "") {
                    purpose_id = $("#purpose_hidden").val();
                }

                $("#other_types").hide();
                if (user_types == "0") {
                    $("#other_types").show();
                }

                $("#file-div").hide();
                <?php if(empty($row)){?>
                $('#file_number').val('');
                <?php } ?>
                if (user_types == "108") {
                    $("#file-div").show();
                }

                $.ajax({
                    type: "POST",
                    url: base_url + "get_purpose_data?user_types=" + user_types + "&purpose_id=" + purpose_id,
                    dataType: "html",
                    success: function (response) {
                        console.log(response);
                        $('#purpose').html(response);
                        $("#purpose_id").val(purpose_id);
                        if (user_types == "") {
                            $("#purpose").trigger("change");
                            $('#purpose').html("<option value=''>---Select---</option>");
                        }
                    }
                });

            });

            $('#frmFirstDetail').on('change', '#purpose', function (e) {

                var purpose = $(this).val();
                $("#other_purpose").hide();
                if (purpose != "" && purpose == 0) {
                    $("#other_purpose").show();
                }
            });

            $('#frmFirstDetail').on('change', '#appo_with', function (e) {

                var appo_with = $(this).val();
                $("#other_with").hide();
                if (appo_with != "" && appo_with == 0) {
                    $("#other_with").show();
                }
            });

            $.validator.addMethod("customemail",
                function (value, element) {
                    return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
                },
                "Please enter a valid email"
            );

            var app_id = 0;

            $("#appo_with").change(function () {
                app_id = 0;
                if ($(this).val() > 0) {
                    app_id = $(this).val();
                }
            });

            $("#frmFirstDetail").validate({
                debug: false,
                errorClass: "error",
                errorElement: "span",
                rules: {
                    user_types: "required",
                    appo_with: "required",
                    name: "required",
                    mobile_no1: {
                        required: true,
                        number: true
                    },
                    appo_date_time: {
                        required: true,
                    },
                    email_address: {
                        required: true,
                        email: true,
                        customemail: true
                    },
                },
                messages: {
                    user_types: "Please select appointment type",
                    appo_with: "Please select appointment person",
                    name: "Please enter fullname",
                    appo_date_time: "Please enter appointment datetime",
                    email_address: {
                        required: "Please enter email address",
                        email: "Please enter valid email address"
                    },
                    mobile_no1: {
                        required: "Please enter mobile number",
                        number: "Enter only number"
                    },
                },
                highlight: function (element, errorClass) {
                    $('input').removeClass('error');
                },
                submitHandler: function (form) {

                    $.ajax({
                        type: "POST",
                        url: base_url + "verify_appointment_date",
                        data: $("#frmFirstDetail").serialize(),
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

            <?php if (!empty($row)) { ?>
            $("#user_types").trigger("change");
            <?php } ?>
        });

    </script>