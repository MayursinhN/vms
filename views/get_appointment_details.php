<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "mobile_no1 =:mobile_no1 ORDER BY app_id DESC";
    $params = array(":mobile_no1" => $mob_number);
    $row = $obj->fetchRow('appoinments', $cond, $params);

    if (!empty($row)) {
        echo json_encode(array('status' => true, 'data' => $row));
    }
}

?>