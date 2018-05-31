<?php
include_once '../common/config.php';
extract($_GET);
extract($_POST);
$loginid = $objsession->get("log_admin_loginid");

$cond = "email_address=:email_address AND is_active =:is_active";
$params = array(":email_address" => $email_address, ":is_active" => 1);
$totalUser = $obj->fetchNumOfRow('users', $cond, $params);

if ($totalUser > 0) {
    echo json_encode(array("status" => false, 'message' => ""));
} else {

    $cond = "email_address=:email_address AND is_active =:is_active";
    $params = array(":email_address" => $email_address, ":is_active" => 0);
    $totalUser = $obj->fetchNumOfRow('users', $cond, $params);

    if ($totalUser > 0) {
        echo json_encode(array("status" => true, 'message' => ""));
    } else {
        echo json_encode(array("status" => false, 'message' => ""));
    }

}

?>

