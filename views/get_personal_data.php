<?php
include_once '../common/config.php';
extract($_GET);
extract($_POST);

$cond = "inquiry_id =:login_id";
$params = array(":login_id" => $login_id);
$data = $obj->fetchRow('inquiry_list', $cond, $params);

$data['full_address'] = $data['address1'] . ", " . $data['address2'] . ", " . $data['address3'];
$data['date_of_birth'] = date("d/m/Y",strtotime($data['date_of_birth']));

$cond = "country_id=:country_id";
$params = array(":country_id" => $data['country_id']);
$countries = $obj->fetchRow('countries', $cond, $params);
$data['country_name'] = $countries['name'];

$cond = "city_id=:city_id";
$params = array(":city_id" => $data['city_id']);
$cities = $obj->fetchRow('cities', $cond, $params);
$data['city_name'] = $cities['name'];

$cond = "state_id=:state_id";
$params = array(":state_id" => $data['state_id']);
$states = $obj->fetchRow('states', $cond, $params);
$data['state_name'] = $states['name'];

if (!empty($data)) {
    echo json_encode(array("status" => true, 'data' => $data));
} else {
    echo json_encode(array("status" => false, 'message' => ""));
}

?>

