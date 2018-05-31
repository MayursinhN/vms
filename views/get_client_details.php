<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "registration.is_active =:active AND registration.reg_id =:id ORDER BY registration.reg_id DESC";
    $params = array(":active" => 1, ":id" =>$id);
    $row = $obj->fetchRowwithjoin('inquiry_list', 'registration', 'inquiry_id', 'inquiry_id', $cond, $params);

    if (!empty($row)) {
        echo json_encode(array('status' => true, 'data' => $row));
    } else {
        echo json_encode(array('status' => false, 'data' => array()));
    }

}

?>