<?php include_once '../include/header.php'; ?>
<?php

$row = array();
$loginid = $objsession->get("log_admin_loginid");
$login_id = 0;

if (isset($_GET['login_id'])) {
    $cond = '';
    $login_id = $_GET['login_id'];
    $cond = "login_id=:login_id";
    $params = array(":login_id" => $login_id);
    $row = $obj->fetchRow('users', $cond, $params);
}

$userTypes = array("admin", "receptionist", "councilor", "sels marketing");

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
    <h1 class="page-header"> Manage User </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER; ?>">Home</a></li>
        <li><a href="<?php echo HTTP_SERVER; ?>usermanager">List of User</a></li>
        <li class="active">Manage User</li>
    </ol>
</div>
<div id="page-inner">
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="row">
                        <div class="padding20">
                            <form name="frmUsers" method="post" id="frmUsers" enctype="multipart/form-data">

                                <div class="col-md-6 col-sm-6">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Name :</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="full_name" id="full_name"
                                                   value="<?php if (!empty($row)) {
                                                       echo $row['full_name'];
                                                   } ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Email :</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <input type="text"
                                                   class="form-control" <?php if (empty($row)) { ?> onblur="verifyEmail();" <?php } ?> name="email_address"
                                                   id="email_address"
                                                   value="<?php if (!empty($row)) {
                                                       echo $row['email_address'];
                                                   } ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Password :</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password"
                                                   id="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Confirm Password :</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="cPassword"
                                                   id="cPassword">
                                        </div>
                                    </div>
                                </div>


                                <div class="clearfix"></div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>User Type :</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <select name="user_types" class="form-control" id="user_types">
                                                <option value="">---Select---</option>
                                                <?php if (!empty($userTypes)) {
                                                    $selected = "";
                                                    foreach ($userTypes as $key => $val) {
                                                        if (!empty($row)) {
                                                            if ($row['user_types'] == $val) {
                                                                $selected = 'selected="selected"';
                                                            }
                                                        }
                                                        ?>
                                                        <option <?php echo $selected; ?>
                                                                value="<?php echo $val; ?>">
                                                            <?php echo ucwords($val); ?></option>
                                                        <?php $selected = '';
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Photo :</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group form-control">
                                                    <input type="file" name="profile_image" id="profile_image">
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <?php if (!empty($row)) {
                                                        if ($row['profile_image'] != "") { ?>
                                                            <img src="<?php echo HTTP_SERVER; ?>images/<?php echo $row['profile_image']; ?>"
                                                                 width="130" height="80"
                                                                 style="float: right;margin-top: 0px;border-radius: 5px;">
                                                        <?php }
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <?php if (!empty($row)) { ?>
                                                <input type="submit" name="btn_update"
                                                       class="waves-effect waves-light btn"
                                                       value="SAVE">
                                            <?php } else { ?>
                                                <input type="submit" name="btn_add" class="waves-effect waves-light btn"
                                                       value="SAVE">
                                            <?php } ?>
                                            <a href="<?php echo HTTP_SERVER; ?>usermanager"
                                               class="waves-effect waves-light btn">CANCEL</a>
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

    <button type="button" class="btn btn-info btn-lg" data-backdrop="static"
            data-keyboard="false" data-toggle="modal" data-target="#myModal"
            style="display: none;"
            id="re-register">Open Modal
    </button>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Do you realy want to Re-register ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="btn_reregister">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>

        </div>
    </div>
    <?php

    if (isset($_POST['btn_add'])) {

        extract($_POST);
        $currentDate = date('Y-m-d');

        $profile_image = "";

        if ($_FILES['profile_image']['name'] != "") {

            $rand = rand(1, 99999);
            $profile_image = $rand . $_FILES['profile_image']['name'];
            move_uploaded_file($_FILES['profile_image']['tmp_name'], "../images/" . $profile_image);
        }

        $field = array('profile_image', 'full_name', "email_address", "password", "user_types", "is_active");
        $value = array($profile_image, $full_name, $email_address, hashPassword($password), $user_types, 1);
        $login_array = array_combine($field, $value);

        $obj->insert($login_array, 'users');

        $objsession->set('ads_message', 'User added successfully.');
        redirect(HTTP_SERVER . "usermanager");
    }

    if (isset($_POST['btn_update'])) {

        extract($_POST);
        $currentDate = date('Y-m-d');

        $cond = "login_id=:login_id";
        $params = array(":login_id" => $login_id);
        $row_update = $obj->fetchRow('users', $cond, $params);

        if ($_FILES['profile_image']['name'] != "") {

            if ($row_update['profile_image'] != "") {
                unlink("../images/" . $row_update['profile_image']);
            }

            $rand = rand(1, 99999);
            $profile_image = $rand . $_FILES['profile_image']['name'];
            move_uploaded_file($_FILES['profile_image']['tmp_name'], "../images/" . $profile_image);
        } else {
            $profile_image = $row_update['profile_image'];
        }

        if ($password != '') {
            $field = array('profile_image', 'full_name', "email_address", "password", "user_types");
            $value = array($profile_image, $full_name, $email_address, hashPassword($password), $user_types);
        } else {
            $field = array('profile_image', 'full_name', "email_address", "user_types");
            $value = array($profile_image, $full_name, $email_address, $user_types);
        }

        $login_array = array_combine($field, $value);
        $obj->update($login_array, 'users', array('login_id' => $login_id));

        $objsession->set('ads_message', 'User details updated successfully.');
        redirect(HTTP_SERVER . "usermanager");
    }

    ?>
    <?php include_once '../include/footer.php'; ?>

    <script src="<?php echo HTTP_SERVER; ?>assets/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <link href="<?php echo HTTP_SERVER; ?>assets/css/bootstrap-datetimepicker.css" rel="Stylesheet" type="text/css"/>

    <script>
        $(document).ready(function () {

            $("#frmUsers").validate({
                debug: false,
                errorClass: "error",
                errorElement: "span",
                rules: {
                    full_name: "required",
                    email_address: {
                        required: true,
                        email: true,
                        remote: {
                            url: '<?php echo HTTP_SERVER;?>verify_email?login_id=<?php echo $login_id; ?>',
                            type: 'post'
                        }
                    },
                    <?php if($login_id == 0){ ?>
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 16,
                    },
                    profile_image: {
                        required: true,
                        extension: "png|jpg|jpeg|gif"
                    },
                    <?php } else {?>
                    profile_image: {
                        extension: "png|jpg|jpeg|gif"
                    },
                    <?php } ?>

                    cPassword: {
                        equalTo: "#password"
                    }
                },
                messages: {
                    full_name: "Please enter your first name",
                    email_address: {
                        required: "Please enter your email",
                        email: "Please enter valid email",
                        remote: 'Your email is registered yet. Please enter another email'
                    },
                    <?php if($login_id == 0){?>
                    password: {
                        required: 'Please enter your password',
                        minlength: 'Password minimum length is 6',
                        maxlength: 'Password maximum length is 16',
                    },
                    profile_image: {
                        required: "Please upload your photo",
                        extension: "Please enter only png | jpg | jpeg | gif image."
                    },
                    <?php } else { ?>
                    profile_image: {
                        extension: "Please enter only png | jpg | jpeg | gif image."
                    },
                    <?php } ?>
                    cPassword: "Enter Confirm Password Same as Password"
                },
                highlight: function (element, errorClass) {
                    $('input').removeClass('error');
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });

        <?php if (empty($row)) { ?>

        var base_url = "<?php echo HTTP_SERVER; ?>";

        function verifyEmail() {
            var email_address = $("#email_address").val();

            if (email_address != "") {
                $.ajax({
                    type: "POST",
                    url: base_url + "verify_old_email?email_address=" + email_address,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {
                            $("#re-register").click();
                        }
                    }
                });
            }
        }
        <?php } ?>

        $('#btn_reregister').click(function (e) {

            var id = $("#email_address").val();

            $.ajax({
                type: "POST",
                url: base_url + "update_data_user?email_id=" + id,
                dataType: "json",
                success: function (response) {

                    if (response.status == true) {
                        window.location.href = "<?php echo HTTP_SERVER;?>usermanager";
                    } else if (response.status == false) {
                        alert("Something went wrong...!");
                        return false;
                    }
                }
            });
        });

    </script>