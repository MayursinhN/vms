<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $id = $obj->delete('relationship_details',array('relation_id' => $relative_id));

    if ($id) {

        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>