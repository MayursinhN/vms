<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$exprData = array();

if ($_POST) {

    $reason_for_visit_list = "";
    if (!empty($reason_for_visit)) {
        $reason_for_visit_list = implode(",", $reason_for_visit);
    }

    $field = array("inquiry_id", "reason_for_visit");
    $value = array($inquiry_id, $reason_for_visit_list);
    $tech_array = array_combine($field, $value);

    $cond = "inquiry_id=:inquiry_id AND is_active =:is_active";
    $params = array(":inquiry_id" => $inquiry_id, ":is_active" => 1);

    $visitor = $obj->fetchRow('visitor_visa_details', $cond, $params);

    if (!empty($visitor)) {
        $obj->update($tech_array, 'visitor_visa_details', array('inquiry_id' => $inquiry_id));
    } else {
        $id = $obj->insert($tech_array, 'visitor_visa_details');
    }

    if ($inquiry_id) {
        echo json_encode(array('status' => true, 'id' => $inquiry_id, 'data' => $reason_for_visit));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>