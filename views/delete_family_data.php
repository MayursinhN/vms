<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    //$id = $obj->delete('familydetails',array('family_id' => $relative_id));

    $_array = array('is_active' => 0);
    $obj->update($_array, 'familydetails', array('family_id' => $relative_id));

    if ($id) {

        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>