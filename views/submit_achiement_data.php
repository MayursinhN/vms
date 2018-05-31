<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$exprData = array();

if ($_POST) {

    $achievement_list = "";
    if (!empty($achievement)) {
        $achievement_list = implode(",", $achievement);
    }

    $field = array("achievement");
    $value = array($achievement_list);
    $ach_array = array_combine($field, $value);

    if ($inquiry_id != "" && $inquiry_id > 0) {
        $obj->update($ach_array, 'registration', array('inquiry_id' => $inquiry_id));
    }

    if ($inquiry_id) {
        echo json_encode(array('status' => true, 'id' => $inquiry_id,'data' => $achievement));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>