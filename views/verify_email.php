<?php
include_once '../common/config.php';
extract($_GET);
extract($_POST);
$loginid = $objsession->get("log_admin_loginid");
if ($login_id > 0 && $login_id != "") {
    $cond = "email_address=:email_address AND login_id != :login_id";
    $params = array(":email_address" => $email_address, ":login_id" => $login_id);
} else {
    $cond = "email_address=:email_address";
    $params = array(":email_address" => $email_address);
}
$totalUser = $obj->fetchNumOfRow('users', $cond, $params);
if ($totalUser > 0) {
    echo "false";
} else {
    echo "true";
}

?>

