<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "inquiry_id =:inquiry_id";
    $params = array(":inquiry_id" => $inquiry_id);
    $row = $obj->fetchRow('inquiry_list', $cond, $params);
    $visa_id = "";
    $cond = "is_active =:active AND category_name =:category AND doc_id =:doc_id";
    $params = array(":active" => 1, ":category" => 'PaymentStage', ":doc_id" => 1);

    if ($row['visa_type'] > 0) {
        $visa_id = $row['visa_type'];
        $cond = "is_active =:active AND category_name =:category AND FIND_IN_SET(:find_string,other) AND doc_id =:doc_id";
        $params = array(":active" => 1, ":category" => 'PaymentStage', ":find_string" => $visa_id, ":doc_id" => 1);
    }

    $stages = $obj->fetchRowAll('masters_list', $cond, $params);

    if ($row) {
        echo json_encode(array('status' => true, 'data' => $stages));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>