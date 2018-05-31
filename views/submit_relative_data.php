<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$arrData = array();

if ($_POST) {

    $field = array('inquiry_id', 'first_name', 'middle_name', "last_name", "reta_address1","reta_address2","reta_address3","postalcode", "relationship", "immigration_state", "immigration_city", "since", "immigration_status", "is_active");
    $value = array($inquiry_id, $relative_first_name, "", $relative_last_name, $reta_address1,$reta_address2,$reta_address3,$ret_postal_code, $relationship, $relative_state_id, $relative_city_id, $since, $immigration_status, 1);
    $relative_array = array_combine($field, $value);

    if ($relation_id != "" && $relation_id > 0) {

        $id = $obj->update($relative_array, 'relationship_details', array('relation_id' => $relation_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $arrData = $obj->fetchRowAll('relationship_details', $cond, $params);
//print_r($arrData);
        for ($i = 0; $i < count($arrData); $i++) {

            $arrData[$i]['full_name_'] = $arrData[$i]['first_name'] . " " . $arrData[$i]['middle_name'] . " " . $arrData[$i]['last_name'];

           /* $cond = "state_id=:state_id";
            $params = array(":state_id" => $arrData[$i]['immigration_state']);
            $states = $obj->fetchRow('states', $cond, $params);
            $arrData[$i]['relative_stete'] = $states['name'];*/

            $arrData[$i]['relative_stete'] = $arrData[$i]['immigration_state'];
            $cond = "state_id=:city_id";
            $params = array(":city_id" => $arrData[$i]['immigration_city']);
            $cities = $obj->fetchRow('states', $cond, $params);
            $arrData[$i]['relative_city'] = $cities['name'];

        }
        $cities['name'] = "";
        $states['name'] = "";
    } else {
        $id = $obj->insert($relative_array, 'relationship_details');
    }

    $clk = "return confirm('Are you sure want to delete?')";

    if ($id) {
        $link = '<a href="javascript:void(0);" data-id="' . $id . '" class="update" onclick="editRelative(' . $id . ');" ><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a>
                 <a href="javascript:void(0);" data-id="' . $id . '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';

        $cond = "state_id=:city_id";
        $params = array(":city_id" => $relative_city_id);
        $cities = $obj->fetchRow('states', $cond, $params);

        /*$cond = "state_id=:state_id";
        $params = array(":state_id" => $relative_state_id);
        $states = $obj->fetchRow('states', $cond, $params);*/
        $states['name'] = $relative_state_id;

        $full_name = $relative_first_name . " " . $relative_last_name;

        echo json_encode(array('status' => true, 'id' => $id, 'full_name' => $full_name, 'since' => $since, 'relative_city' => $cities['name'], 'relative_stete' => $states['name'],
            'link' => $link, 'relationship' => $relationship, 'immigration_status' => $immigration_status, 'data' => $arrData));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>