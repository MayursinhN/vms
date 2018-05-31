<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {

    $field = array('is_open', "modify_by", "modify_date", "reason");
    $value = array($app_status, $loginid, $currentDate, $txt_reason);
    $app_update_array = array_combine($field, $value);

    if ($app_id > 0) {
        $id = $app_id;
        $obj->update($app_update_array, 'appoinments', array('app_id' => $id));
    }

    $objsession->set('appo_message', 'Appointment status updated successfully.');

    if ($id) {
        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>