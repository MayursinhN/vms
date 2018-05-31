<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "education_id=:education_id";
    $params = array(":education_id" => $education_id);
    $row = $obj->fetchRow('education_details', $cond, $params);

    if ($row) {

        echo json_encode(array('status' => true, 'id' => $row['education_id'], 'name_of_degree' => $row['name_of_degree'],
            'name_of_center' => $row['name_of_center'], 'passed_on' => $row['passed_on'], 'percentage' => $row['percentage'],
            'passed_class' => $row['passed_class'],'medium' => $row['medium']));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>