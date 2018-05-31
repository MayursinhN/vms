<?php
require_once 'common/config.php';
ob_start();
if ($objsession->get('log_admin_type') != "") {
    redirect(HTTP_SERVER . 'dashboard');
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo PROJECT_NAME; ?> | Login</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/materialize/css/materialize.min.css" media="screen,projection"/>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet"/>
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet"/>
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet"/>
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet"/>
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
    <link rel="stylesheet" href="assets/js/Lightweight-Chart/cssCharts.css">
</head>
<body>
<div class="container">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div>

            <div class="card">
                <div class="card-action">
                    Sign In
                </div>
                <?php if ($objsession->get('log_error') != "") { ?>
                    <div class="alert alert-danger err_1"><span><?php echo $objsession->get('log_error'); ?></span>
                    </div>
                    <?php $objsession->remove('log_error');
                } ?>
                <div class="card-content">
                    <form class="login-form" id="frmLogin" method="post">
                        <div class="form-group">
                            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                            <label class="control-label visible-ie8 visible-ie9">Email</label>
                            <input class="form-control form-control-solid placeholder-no-fix" type="text"
                                   autocomplete="off" name="sEmailID" id="sEmailID"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">Password</label>
                            <input class="form-control form-control-solid placeholder-no-fix" type="password"
                                   autocomplete="off" name="sPassword" id="sPassword"/>
                        </div>
                        <div class="form-actions">
                            <button type="submit" name="btn_login" class="waves-effect waves-light btn">Login</button>
                            <!-- <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a> -->
                        </div>
                    </form>
                </div>


                <!-- /. PAGE INNER  -->
            </div>
        </div>
        <div class="col-md-4"></div>
        <div class="clearfix"></div>
        <!-- /. PAGE WRAPPER  -->
    </div>
</div>

<?php

if (isset($_POST['btn_login'])) {

    extract($_POST);

    $cond = "email_address=:sEmailID";
    $params = array(":sEmailID" => $sEmailID);
    $row = $obj->checkValidLogin("users", $cond, $params);

    if (!empty($row)) {
        /*echo hashPassword($sPassword);
        exit();*/
        if (verifyHashPassword($sPassword, $row['password']) == false) {
            $objsession->set('log_error', "Please check your email or password.");
            redirect(HTTP_SERVER);
        } else {

            if ($row['is_active'] == 0) {
                $objsession->set('log_error', "Sorry, Your account deactivated by administrator.");
                redirect(HTTP_SERVER);
            } else {
                $objsession->set('log_admin_email', $row['email_address']);
                $objsession->set('log_admin_loginid', $row['login_id']);
                $objsession->set('log_admin_type', $row['user_types']);
                if ($row['user_types'] == "admin") {
                    redirect(HTTP_SERVER . "dashboard");
                } else if ($row['user_types'] == 'subadmin') {
                    redirect(HTTP_SERVER . "subadmin_users");
                } else if ($row['user_types'] == 'receptionist') {
                    redirect(HTTP_SERVER . "appointments");
                }

            }
        }

    } else {
        $objsession->set('log_error', "Please check your email or password.");
        redirect(HTTP_SERVER);
    }
}
?>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/materialize/js/materialize.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {

        $.validator.addMethod("customemail",
            function (value, element) {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            },
            "Please enter a valid email"
        );

        $('#frmForgot').validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                forgot_email: {
                    required: true,
                    email: true,
                    customemail: true
                }
            },
            messages: {
                forgot_email: {
                    required: "Email is required.",
                    email: "Please enter valid email"
                }
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {
                $("#err_msg").html('');
                $.ajax({
                    type: "POST",
                    url: "<?php echo HTTP_SERVER;?>forgot_password",
                    data: $("#frmForgot").serialize(),
                    success: function (response) {

                        if ($.trim(response) == "true") {
                            $("#err_msg").css("color", "green");
                            $("#err_msg").html('Please check your inbox or spam for new password.');
                        } else if ($.trim(response) == "false") {
                            $("#err_msg").css("color", "red");
                            $("#err_msg").html('Your email is not registerd yes. Please enter valid email for new password.');
                        }
                    }
                });
            }
        });

        $.validator.addMethod("customemail",
            function (value, element) {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            },
            "Please enter a valid email"
        );

        $("#frmLogin").validate({
            debug: false,
            errorClass: "error",
            errorElement: "span",
            rules: {
                sEmailID: {
                    required: true,
                    email: true,
                    customemail: true
                },
                sPassword: "required",
            },
            messages: {
                sEmailID: {
                    required: "Please enter your email",
                    email: "Please enter valid email",
                },
                sPassword: "Please enter your password",
            },
            highlight: function (element, errorClass) {
                $('input').removeClass('error');
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>
</body>
</html>