<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $_array = array('is_active' => 0);
    $obj->update($_array, 'visitor_realtive', array('id' => $overseas_id));

    if ($id) {

        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>