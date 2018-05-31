<?php
include_once '../common/config.php';

extract($_POST);

$loginid = $objsession->get("log_admin_loginid");

$currentDate = date('Y-m-d');

if ($_POST) {

    if ($other_state != "") {

        $field = array('name', 'country_id', 'is_active');
        $value = array($other_state, $country_id, 1);
        $states = array_combine($field, $value);
        $state_id = $obj->insert($states, 'states');

    }

    if ($other_city != "") {
        $field = array('name', 'state_id', 'is_active');
        $value = array($other_city, $state_id, 1);
        $cities = array_combine($field, $value);
        $city_id = $obj->insert($cities, 'cities');
    }

    if ($login_id > 0) {

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $login_id);
        $row = $obj->fetchRow('inquiry_list', $cond, $params);
        if (!empty($row)) {
            $is_active = $row['is_active'];
        } else {
            $is_active = 0;
        }

        $inquiryDate = $row['inquiry_date'];

    } else {
        $is_active = 0;
        $inquiryDate = date('Y-m-d H:i');
    }

    $adharNumber = "";
    if ($reg_id > 0) {
        $adharNumber = $adharcard_number;
    }

    $date_of_birth = str_replace('/', '-', $date_of_birth);

    $field = array('inquiry_date', "adharcard_number", 'first_name', 'middle_name', "last_name", "gender", "address1", "address2", "address3", "postalcode", "country_id", "state_id", "city_id",
        "date_of_birth", "place_of_birth", "email_address", "mobile_number", "phone_number", "marital_status", "created_by", "is_active");
    $value = array($inquiryDate, $adharNumber, $first_name, "", $last_name, $gender, $address1, $address2, $address3, $postalcode, $country_id, $state_id, $city_id,
        date("Y-m-d", strtotime($date_of_birth)), $place_of_birth, $email_address, $mobile_number, $phone_number, $marital_status, $loginid, $is_active);
    $personal_array = array_combine($field, $value);

    if ($login_id > 0) {
        $id = $login_id;
        $obj->update($personal_array, 'inquiry_list', array('inquiry_id' => $login_id));
    } else {
        $id = $obj->insert($personal_array, 'inquiry_list');
    }

    if ($id) {
        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>