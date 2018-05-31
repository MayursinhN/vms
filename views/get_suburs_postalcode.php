<?php
include_once '../common/config.php';
extract($_GET);
extract($_POST);

$cond = "postcode =:ret_postal_code";
$params = array(":ret_postal_code" => $ret_postal_code);
$data = $obj->fetchRow('postcodes_geo', $cond, $params);

if (!empty($data)) {
    echo json_encode(array("status" => true, 'relative_state_name' => $data['suburb'] . ", " . $data['state']));
} else {
    echo json_encode(array("status" => false, 'message' => ""));
}

?>

