<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $id = $obj->delete('passpord_details',array('passport_id' => $passport_id));

    if ($id) {

        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>