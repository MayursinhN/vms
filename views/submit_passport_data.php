<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {

    $passport_issue_date = str_replace('/', '-', $passport_issue_date);
    $passport_expire_date = str_replace('/', '-', $passport_expire_date);

    $field = array('inquiry_id', "passport_number", "passport_issue_date", "passport_expire_date", "is_active");
    $value = array($inquiry_id, $passport_number, date("Y-m-d", strtotime($passport_issue_date)), date("Y-m-d", strtotime($passport_expire_date)), 1);
    $immi_array = array_combine($field, $value);

    if ($passport_id != "" && $passport_id > 0) {
        $id = $passport_id;
        $obj->update($immi_array, 'passpord_details', array('passport_id' => $passport_id));
    } else {

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $passport_number_arr = $obj->fetchRow('passpord_details', $cond, $params);
        if (!empty($passport_number_arr)) {
            $id = $passport_number_arr['passport_id'];
            $obj->update($immi_array, 'passpord_details', array('passport_id' => $passport_number_arr['passport_id']));
        } else {
            $id = $obj->insert($immi_array, 'passpord_details');
        }

    }

    if ($id) {
        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>