<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {

    $field = array('reference_by', "sub_agent_by", "is_active");
    $value = array($reference_by, $sub_agent_by, 1);
    $immi_array = array_combine($field, $value);
    $id = 0;
    if (isset($_POST['btn_reference_register'])) {
        $field = array('reference_by', "sub_agent_by", "is_active", "is_register");
        $value = array($reference_by, $sub_agent_by, 1, 1);
        $immi_array = array_combine($field, $value);

        $field_ = array('inquiry_id', "created_by", "created_date", "is_active");
        $value_ = array($inquiry_id, $loginid, $currentDate, 1);
        $reg_array = array_combine($field_, $value_);
        $id = $obj->insert($reg_array, 'registration');

    }

    $cond = "inquiry_id=:inquiry_id";
    $params = array(":inquiry_id" => $inquiry_id);
    $reg_data = $obj->fetchRow('inquiry_list', $cond, $params);
    if ($reg_data['is_register'] > 0) {
        $id = $reg_data['is_register'];
    }

    if ($inquiry_id > 0) {
        if ($id > 0) {
            $objsession->set('ads_message', 'Client details successfully completed.');
        } else {
            $objsession->set('ads_message', 'Inquiry successfully completed.');
        }

        $obj->update($immi_array, 'inquiry_list', array('inquiry_id' => $inquiry_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $_arr = $obj->fetchRow('follow_up', $cond, $params);
        if (!empty($_arr)) {
            $obj->delete('follow_up', array('inquiry_id' => $inquiry_id));
        }
    }

    if ($inquiry_id) {

        $data = array();
        $data['ref_name'] = "";
        $data['sub_name'] = "";

        if ($reference_by > 0) {
            $cond = "ref_id=:ref_id";
            $params = array(":ref_id" => $reference_by);
            $masters_list = $obj->fetchRow('referance_list', $cond, $params);
            $data['ref_name'] = $masters_list['ref_name'];
        } else {
            $data['ref_name'] = "Sub Agent";
        }

        if ($sub_agent_by > 0) {
            $cond = "ref_id=:ref_id";
            $params = array(":ref_id" => $sub_agent_by);
            $masters_list = $obj->fetchRow('referance_list', $cond, $params);
            $data['sub_name'] = $masters_list['ref_name'];
        }

        echo json_encode(array('status' => true, 'id' => $inquiry_id, "reg_id" => $id, 'data' => $data));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>