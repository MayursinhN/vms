<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "email_address =:email_address OR mobile_no1 =:mobile_no1";
    $params = array(":email_address" => $email_mobile_data, ":mobile_no1" => $email_mobile_data);
    $row = $obj->fetchRow('appoinments', $cond, $params);

    if ($row) {
        echo json_encode(array('status' => true, 'name' => ucfirst($row['name']), 'mobile_no1' => $row['mobile_no1'], 'mobile_no2' => $row['mobile_no2'],
            'email_address' => $row['email_address']));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>