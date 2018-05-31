<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {

    $date_of_follow = str_replace('/', '-', $date_of_follow);

    $field = array('inquiry_id', "date_of_follow", "is_active");
    $value = array($inquiry_id, date("Y-m-d", strtotime($date_of_follow)), 1);
    $follow_array = array_combine($field, $value);

    $id = $obj->insert($follow_array, 'follow_up');

    $objsession->set('ads_message', 'Followup date successfully added.');

    if ($id) {
        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>