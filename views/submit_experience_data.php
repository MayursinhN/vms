<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$exprData = array();

if ($_POST) {

    if ($other_expr_country != "") {

        $field = array('name', 'is_active');
        $value = array($other_expr_country, 1);
        $countries = array_combine($field, $value);
        $expr_country_id = $obj->insert($countries, 'countries');
    }

    if ($other_expr_state != "") {

        $field = array('name', 'country_id', 'is_active');
        $value = array($other_expr_state, $expr_country_id, 1);
        $states = array_combine($field, $value);
        $state_expr_id = $obj->insert($states, 'states');
    }

    if ($other_expr_city != "") {
        $field = array('name', 'state_id', 'is_active');
        $value = array($other_expr_city, $state_expr_id, 1);
        $cities = array_combine($field, $value);
        $city_expr_id = $obj->insert($cities, 'cities');
    }

    if (!isset($current_emp)) {
        $current_emp = 0;
    }

    /*if () {

    }*/

    $field = array('inquiry_id', 'name_of_cmp', 'exp_address1', 'exp_address2', 'exp_address3', "business_name", "designation", "current_emp", "start_from", "end_to", "country_id", "state_id", "city_id", "pincode_number", "is_active");
    $value = array($inquiry_id, $name_of_cmp, $exp_address1, $exp_address2, $exp_address3, $business_name, $designation, $current_emp, $start_date, $end_date, $expr_country_id, $state_expr_id, $city_expr_id, $pincode_number, 1);
    $expr_array = array_combine($field, $value);

    if ($exp_id != "" && $exp_id > 0) {
        $id = $exp_id;
        $obj->update($expr_array, 'work_experiance_details', array('exp_id' => $exp_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $exprData = $obj->fetchRowAll('work_experiance_details', $cond, $params);

        for ($i = 0; $i < count($exprData); $i++) {

            $cond = "city_id=:city_id";
            $params = array(":city_id" => $exprData[$i]['city_id']);
            $cities = $obj->fetchRow('cities', $cond, $params);
            $exprData[$i]['city_id'] = $cities['name'];
        }

        $cities['name'] = "";

    } else {
        $id = $obj->insert($expr_array, 'work_experiance_details');
    }

    $clk = "return confirm('Are you sure want to delete?')";

    if ($id) {
        $link = '<a href="javascript:void(0);" data-id="' . $id . '" class="update" onclick="editExperience(' . $id . ');" ><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' . $id . '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';

        $cond = "city_id=:city_id";
        $params = array(":city_id" => $city_expr_id);
        $cities = $obj->fetchRow('cities', $cond, $params);

        echo json_encode(array('status' => true, 'id' => $id, 'name_of_cmp' => $name_of_cmp, 'business_name' => $business_name, 'city_id' => $cities['name'],
            'link' => $link, 'designation' => $designation, 'current_emp' => $current_emp, 'start_date' => date('d-m-Y', strtotime($start_date)),
            'end_date' => date('d-m-Y', strtotime($end_date)), 'postalcode' => $pincode_number, 'data' => $exprData));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>