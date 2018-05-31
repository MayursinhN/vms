<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "inquiry_id =:inquiry_id AND date_of_follow !=:date_of_follow";
    $params = array(":inquiry_id" => $inquiry_id, ':date_of_follow' => "0000-00-00");
    $row = $obj->fetchRowAll('follow_up', $cond, $params);

    if (!empty($row)) {
        for ($i = 0; $i < count($row); $i++) {
            $row[$i]['date_of_follow'] = date("d-m-Y",strtotime($row[$i]['date_of_follow']));
        }
    }

    if ($row) {
        echo json_encode(array('status' => true, 'data' => $row));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>