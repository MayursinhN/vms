<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "passport_id=:passport_id";
    $params = array(":passport_id" => $passport_id);
    $row = $obj->fetchRow('passpord_details', $cond, $params);

    if ($row) {

        echo json_encode(array('status' => true, 'id' => $row['passport_id'], 'passport_number' => $row['passport_number'],
            'passport_issue_date' => date("d/m/Y",strtotime($row['passport_issue_date'])),
            'passport_expire_date' => date("d/m/Y",strtotime($row['passport_expire_date'])),
            'name_flag' => $row['name_flag'],
            'passport_lost' => $row['passport_lost'],"details" => $row['details'],"passport_name" => $row['passport_name']));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>