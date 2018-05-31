<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$arrData = array();

if ($_POST) {

    $field = array('inquiry_id', 'family_name', 'given_name', 'relation_id', 'address', "phone_number", "email_address", "is_active");
    $value = array($inquiry_id, $family_name, $given_name, $relation_id, $address, $phone_number, $email_address, 1);
    $expr_array = array_combine($field, $value);

    if ($overseas_id != "" && $overseas_id > 0) {
        $id = $overseas_id;
        $obj->update($expr_array, 'visitor_realtive', array('id' => $overseas_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $arrData = $obj->fetchRowAll('visitor_realtive', $cond, $params);

    } else {
        $id = $obj->insert($expr_array, 'visitor_realtive');
    }

    $clk = "return confirm('Are you sure want to delete?')";

    if ($id) {
        $link = '<a href="javascript:void(0);" data-id="' . $id . '" class="update" onclick="editOverseas(' . $id . ');" ><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' . $id . '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';


        echo json_encode(array('status' => true, 'id' => $id, 'family_name' => $family_name, 'given_name' => $given_name,
            'link' => $link, 'address' => $address, 'phone_number' => $phone_number, 'email_address' => $email_address, 'data' => $arrData));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>