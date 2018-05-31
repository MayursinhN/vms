<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {

    $field = array('career_overview');
    $value = array($career_overview);
    $career_array = array_combine($field, $value);

    if ($inquiry_id > 0) {
        $obj->update($career_array, 'registration', array('inquiry_id' => $inquiry_id));
    }

    if ($inquiry_id) {

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $row = $obj->fetchRow('registration', $cond, $params);

        echo json_encode(array('status' => true, 'id' => $inquiry_id, 'data' => $row));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>