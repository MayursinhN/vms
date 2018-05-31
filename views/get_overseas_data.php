<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "id=:overseas_id";
    $params = array(":overseas_id" => $overseas_id);
    $row = $obj->fetchRow('visitor_realtive', $cond, $params);

    if ($row) {

        echo json_encode(array('status' => true, 'id' => $row['id'], 'family_name' => $row['family_name'],
            'given_name' => $row['given_name'], 'relation_id' => $row['relation_id'], 'address' => $row['address'],
            'phone_number' => $row['phone_number'], 'email_address' => $row['email_address']));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>