<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "insurance_id=:insurance_id";
    $params = array(":insurance_id" => $insurance_id);
    $row = $obj->fetchRow('insurance', $cond, $params);

    if ($row) {

        echo json_encode(array('status' => true, 'id' => $row['insurance_id'], 'provider_name' => $row['provider_name'],
            'start_date' => date("d/m/Y", strtotime($row['start_date'])),
            'end_date' => date("d/m/Y", strtotime($row['end_date'])),
            'total_amount' => $row['total_amount'],
            'paid_to' => $row['paid_to']));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>