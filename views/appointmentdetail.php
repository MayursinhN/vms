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

$cond = "is_active =:active AND category_name =:category";
$params = array(":active" => 1, ":category" => 'purpose');
$purpose = $obj->fetchRowAll('masters_list', $cond, $params);


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
    <h1 class="page-header"> Appointment Details</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li><a href="<?php echo HTTP_SERVER; ?>appointments">List of Appointments</a></li>
        <li class="active">Appointment Details</li>
    </ol>
</div>
<div id="page-inner">
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="row">
                        <div class="padding20">
                            <form name="frmFirstDetail" method="post" id="frmFirstDetail">
                                <div id="app_first_detail">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Type :</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <?php if (!empty($userTypes)) {
                                                    $selected = "";
                                                    foreach ($userTypes as $key => $val) {
                                                        if (!empty($row)) {
                                                            if ($row['user_type'] == $val['master_id']) {
                                                                echo ucwords($val['name']);
                                                            }
                                                        }
                                                    }
                                                } ?>
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
                                                <?php if (!empty($purpose)) {
                                                    $selected = "";
                                                    foreach ($purpose as $key => $val) {
                                                        if (!empty($row)) {
                                                            if ($row['purpose'] == $val['master_id']) {
                                                                echo ucwords($val['name']);
                                                            }
                                                        }
                                                    }
                                                } ?>
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
                                                <?php if (!empty($appoWith)) {
                                                    $selected = "";
                                                    for ($i = 0; $i < count($appoWith); $i++) {
                                                        if (!empty($row)) {
                                                            if ($row['appo_with'] == $appoWith[$i]['login_id']) {
                                                                echo ucwords($appoWith[$i]['full_name']);
                                                            }
                                                        }
                                                    }
                                                } ?>
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
                                                <?php if (!empty($row)) {
                                                        echo $row['details'];
                                                    } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div id="app_second_detail">

                                        <div class="input-field col s6">

                                            <input id="name" name="name" type="text" class="validate"
                                                   value="<?php if (!empty($row)) {
                                                       echo $row['name'];
                                                   } ?>">
                                            <label for="name">Full Name</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input id="email_address" name="email_address" type="text" class="validate"
                                                   value="<?php if (!empty($row)) {
                                                       echo $row['email_address'];
                                                   } ?>">
                                            <label for="email_address">Email Address</label>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="input-field col s6">
                                            <input id="mobile_no1" name="mobile_no1" type="text" class="validate"
                                                   value="<?php if (!empty($row)) {
                                                       echo $row['mobile_no1'];
                                                   } ?>">
                                            <label for="mobile_no1">Mobile No. 1</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input id="mobile_no2" name="mobile_no2" type="text" class="validate"
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
                                                       echo $row['appo_date_time'];
                                                   } ?>">
                                            <label for="appo_date_time">Appointment Date & Time</label>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <a href="<?php echo HTTP_SERVER; ?>appointments"
                                                   class="waves-effect waves-light btn">BACK</a>

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

        if ($purpose == 0) {
            $field = array('name', 'category_name', 'other');
            $value = array($other_purpose, "purpose", $user_type);
            $purpose_array = array_combine($field, $value);
            $purpose = $obj->insert($purpose_array, 'masters_list');

        }

        if ($appo_with == 0) {
            $field = array('name', 'category_name');
            $value = array($other_with, "Appointment with");
            $with_array = array_combine($field, $value);
            $appo_with = $obj->insert($with_array, 'masters_list');

        }

        $field = array('user_type', 'purpose', "appo_with", "details", "name", "mobile_no1", "mobile_no2", "email_address", "appo_date_time",
            "is_active", "is_open", "created_by", "created_date");
        $value = array($user_types, $purpose, $appo_with, $details, $name, $mobile_no1, $mobile_no2, $email_address, date("Y-m-d H:i", strtotime($appo_date_time)),
            1, 1, $loginid, $currentDate);
        $appo_array = array_combine($field, $value);

        $obj->insert($appo_array, 'appoinments');

        $objsession->set('appo_message', 'Appointment added successfully.');
        redirect(HTTP_SERVER . "appointments");
    }

    if (isset($_POST['btn_update'])) {

        extract($_POST);
        $currentDate = date('Y-m-d');

        if ($purpose == 0) {
            $field = array('name', 'category_name', 'other');
            $value = array($other_purpose, "purpose", $user_type);
            $purpose_array = array_combine($field, $value);
            $purpose = $obj->insert($purpose_array, 'masters_list');

        }

        if ($appo_with == 0) {
            $field = array('name', 'category_name');
            $value = array($other_with, "Appointment with");
            $with_array = array_combine($field, $value);
            $appo_with = $obj->insert($with_array, 'masters_list');

        }

        $field = array('user_type', 'purpose', "appo_with", "details", "name", "mobile_no1", "mobile_no2", "email_address", "appo_date_time",
            "is_active", "is_open", "modify_by", "modify_date");
        $value = array($user_types, $purpose, $appo_with, $details, $name, $mobile_no1, $mobile_no2, $email_address, date("Y-m-d H:i", strtotime($appo_date_time)),
            1, 1, $loginid, $currentDate);
        $appo_array = array_combine($field, $value);

        $obj->update($appo_array, 'appoinments', array('app_id' => $app_id));

        $objsession->set('appo_message', 'Appointment details updated successfully.');
        redirect(HTTP_SERVER . "appointments");
    }

    ?>
    <?php include_once '../include/footer.php'; ?>