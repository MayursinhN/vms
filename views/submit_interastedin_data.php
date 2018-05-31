<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);
$data = array();

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {

    $field = array('interasted_country_id', "visa_type");
    $value = array($immi_country_id, $visa_type);
    $immi_array = array_combine($field, $value);

    if ($inquiry_id > 0) {
        $obj->update($immi_array, 'inquiry_list', array('inquiry_id' => $inquiry_id));
    }

    if ($inquiry_id) {

        $data['interasted_country_id'] = "";

        if ($immi_country_id > 0) {

            $cond = "country_id=:country_id";
            $params = array(":country_id" => $immi_country_id);
            $countries = $obj->fetchRow('countries', $cond, $params);

            $data['interasted_country_id'] = $countries['name'];
        }

        $data['visa_type'] = $visa_type;

        echo json_encode(array('status' => true, 'id' => $inquiry_id, 'data' => $data));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>