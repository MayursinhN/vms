<?php include_once '../include/header.php'; ?>
<?php
$row = array();
$loginid = $objsession->get("log_admin_loginid");

$cond = "login_id=:iLoginID";
$params = array(":iLoginID" => $loginid);
$row = $obj->fetchRow('users',$cond,$params);

?>
<div class="header">
      <h1 class="page-header"> Profile </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo HTTP_SERVER;?>">Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </div>
<div id="page-inner">
  <div class="row">
              <div class="col-lg-12">
                <?php if($objsession->get('ads_message') != ""){?>
                <div class="alert alert-success">
                  <?php echo $objsession->get('ads_message'); ?>
                </div>
                <?php $objsession->remove('ads_message');}?>
                <?php if($objsession->get('ads_message') != ""){?>
                <div class="error-message"> <?php echo $objsession->get('ads_message');?> </div>
                <?php $objsession->remove('ads_message');}?>
                <div class="padding20">
                <form name="frmProfile" method="post" id="frmProfile">
                  <div class="row">
                    <div class="col-lg-9">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Email :</label>
                        </div>
                      </div>
                      <div class="col-lg-9">
                        <div class="form-group">
                          <input type="text" name="email_address" class="form-control" id="email_address" value="<?php if(!empty($row)){ echo htmlentities($row['email_address']);} ?>" >
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>New Password : </label>
                        </div>
                      </div>
                      <div class="col-lg-9">
                        <div class="form-group">
                          <input type="password" class="form-control" name="sNewPassword" id="sNewPassword" >
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Confirm Password :</label>
                        </div>
                      </div>
                      <div class="col-lg-9">
                        <div class="form-group">
                          <input type="password" name="cConfirmPassword" class="form-control" id="cConfirmPassword" >
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-lg-3 hidden-xs"></div>
                      <div class="col-lg-9">
                        <input type="submit" class="waves-effect waves-light btn" name="btn_add" value="Submit">
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                  <div class="col-lg-3 hidden-xs"></div>
                  <div class="clearfix"></div>
                  </div>
                </form>
              </div>
            </div>
</div>
<?php

if(isset($_POST['btn_add'])){

  extract($_POST);
  $currentDate = date('Y-m-d');

    if($sNewPassword != ""){
      $field = array('email_address','password');
      $value = array($email_address,hashPassword($sNewPassword));
    }else{
      $field = array('email_address');
      $value = array($email_address);
    }

    $login_array = array_combine($field, $value);
    $obj->update($login_array,'users', array('login_id' => $objsession->get("log_admin_loginid")));
    $objsession->set('ads_message','Profile updated successfully.'); 
    redirect(HTTP_SERVER."profile");
}

?>
<?php include_once '../include/footer.php'; ?>

<script>
$(document).ready(function() {

    $.validator.addMethod("customemail",
        function(value, element) {
            return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
        },
        "Please enter a valid email"
    );

    $("#frmProfile").validate({
        debug: false,
        errorClass: "error",
        errorElement: "span",
        rules: {
            email_address: {
                required: true,
                email: true,
                remote: {
                    url: '<?php echo HTTP_SERVER;?>verify_email?login_id=<?php echo $loginid; ?>',
                    type: 'post'
                },
                customemail: true
            },
            cConfirmPassword: {
                equalTo: "#sNewPassword",
                minlength: 6,
           },

        },
        messages: {
            email_address: {
                required: "Please enter your email",
                email: "Please enter valid email",
                remote: 'Your email is registered yet. Please enter another email'
            },
            cConfirmPassword: {
                equalTo: "Password doesn't match",
            },
        },
        highlight: function(element, errorClass) {
            $('input').removeClass('error');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>