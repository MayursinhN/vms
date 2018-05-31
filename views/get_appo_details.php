<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "app_id=:app_id";
    $params = array(":app_id" => $appo_id);
    $row = $obj->fetchRow('appoinments', $cond, $params);

    $cond = "master_id=:master_id";
    $params = array(":master_id" => $row['appo_with']);
    $app_with = $obj->fetchRow('masters_list', $cond, $params);
    $today = date("Y-m-d H:i");

    if ($row['is_open'] == 1) {
        if (strtotime($today) > strtotime($row['appo_date_time'])) {
            $row['is_open'] = 3;
        }
    }

    if ($row) {
        echo json_encode(array('status' => true, 'name' => ucfirst($row['name']), 'app_with' => $app_with['name'],
            'appo_status' => $row['is_open'], 'reason' => $row['reason']));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>