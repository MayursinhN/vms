<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $id = $obj->delete('work_experiance_details',array('exp_id' => $exp_id));

    if ($id) {

        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>