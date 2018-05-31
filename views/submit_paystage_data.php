<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$payFees = array();
$payFees = array_combine($master_id, $paymentFees);

if ($_POST) {

    $field = array('inquiry_id', "paymentFrees", "created_by", "created_date", "is_active");
    $value = array($inquiry_id, json_encode($payFees), $loginid, $currentDate, 1);
    $immi_array = array_combine($field, $value);

    if ($stage_id != "" && $stage_id > 0) {
        $id = $stage_id;
        $obj->update($immi_array, 'payment_stage', array('stage_id' => $stage_id));
    } else {

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $passport_number_arr = $obj->fetchRow('payment_stage', $cond, $params);
        if (!empty($passport_number_arr)) {
            $id = $passport_number_arr['stage_id'];
            $obj->update($immi_array, 'payment_stage', array('stage_id' => $passport_number_arr['stage_id']));
        } else {
            if (!empty($payFees)) {
                $id = $obj->insert($immi_array, 'payment_stage');
            }
        }

        $field = array("is_active", "is_register");
        $value = array(1, 1);
        $immi_array = array_combine($field, $value);

        $field_ = array('inquiry_id', "created_by", "created_date", "is_active");
        $value_ = array($inquiry_id, $loginid, $currentDate, 1);
        $reg_array = array_combine($field_, $value_);
        $id = $obj->insert($reg_array, 'registration');

        $objsession->set('ads_message', 'Registration successfully.');
        $obj->update($immi_array, 'inquiry_list', array('inquiry_id' => $inquiry_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $_arr = $obj->fetchRow('follow_up', $cond, $params);
        if (!empty($_arr)) {
            $obj->delete('follow_up', array('inquiry_id' => $inquiry_id));
        }


    }

    if ($id) {
        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>