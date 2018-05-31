<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$exprData = array();

if ($_POST) {

    $technical_skill_list = "";
    if (!empty($technical_skill)) {
        $technical_skill_list = implode(",", $technical_skill);
    }

    $field = array("technical_skill");
    $value = array($technical_skill_list);
    $tech_array = array_combine($field, $value);

    if ($inquiry_id != "" && $inquiry_id > 0) {
        $obj->update($tech_array, 'registration', array('inquiry_id' => $inquiry_id));
    }

    if ($inquiry_id) {
        echo json_encode(array('status' => true, 'id' => $inquiry_id,'data' => $technical_skill));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>