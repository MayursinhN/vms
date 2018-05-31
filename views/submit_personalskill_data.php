<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$exprData = array();

if ($_POST) {

    $personal_skill_list = "";
    if (!empty($personal_skill)) {
        $personal_skill_list = implode(",", $personal_skill);
    }

    $field = array("personal_skill");
    $value = array($personal_skill_list);
    $pr_array = array_combine($field, $value);

    if ($inquiry_id != "" && $inquiry_id > 0) {
        $obj->update($pr_array, 'registration', array('inquiry_id' => $inquiry_id));
    }

    if ($inquiry_id) {
        echo json_encode(array('status' => true, 'id' => $inquiry_id, "data" => $personal_skill));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>