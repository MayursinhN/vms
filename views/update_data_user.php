<?php
include_once '../common/config.php';
extract($_GET);
extract($_POST);
$loginid = $objsession->get("log_admin_loginid");

$field = array('is_active');
$value = array(1);
$personal_array = array_combine($field, $value);

$id = $obj->update($personal_array, 'users', array('email_address' => $email_id, 'is_active' => 0));

if ($id) {
    echo json_encode(array("status" => true, 'message' => ""));
} else {
    echo json_encode(array("status" => false, 'message' => ""));
}

?>

