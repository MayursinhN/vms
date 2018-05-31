<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "relation_id=:relation_id";
    $params = array(":relation_id" => $relation_id);
    $row = $obj->fetchRow('relationship_details', $cond, $params);

    if ($row) {

        echo json_encode(array('status' => true, 'id' => $row['relation_id'], 'relative_first_name' => $row['first_name'],
            'relative_middel_name' => $row['middle_name'], 'relative_last_name' => $row['last_name'], 'reta_address1' => $row['reta_address1'],'reta_address2' => $row['reta_address2'],'reta_address3' => $row['reta_address3'],
            'relationship' => $row['relationship'],'immigration_state' => $row['immigration_state'],'immigration_city' => $row['immigration_city'],'since' => $row['since'],
            'immigration_status' => $row['immigration_status'],"postalcode" => $row['postalcode']));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>