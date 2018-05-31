<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "exp_id=:exp_id";
    $params = array(":exp_id" => $exp_id);
    $row = $obj->fetchRow('work_experiance_details', $cond, $params);

    if ($row) {

        $work_task = array();
        if ($row['work_task'] != "") {
            $work_task = explode(",", $row['work_task']);
        }

        $designations_data = "";
        $start_from_data = "";
        $end_to_data = "";

        $designations = array();
        if (!empty($row['designations'])) {
            $designations = explode(",", $row['designations']);
            $designations_data = $designations[0];
        }

        $start_from = array();
        if (!empty($row['start_from'])) {
            $start_from = explode(",", $row['start_from']);
            $start_from_data = $start_from[0];
        }

        $end_to = array();
        if (!empty($row['end_to'])) {
            $end_to = explode(",", $row['end_to']);
            $end_to_data = $end_to[0];
        }

        if ($designations_data == "") {
            $designations_data = $row['designation'];
        }
        echo json_encode(array('status' => true, 'id' => $row['exp_id'], 'name_of_cmp' => $row['name_of_cmp'],
            'exp_address1' => $row['exp_address1'], 'exp_address2' => $row['exp_address2'], 'exp_address3' => $row['exp_address3'], 'business_name' => $row['business_name'], 'designation' => $designations_data,
            'current_emp' => $row['current_emp'], 'start_date' => $start_from_data, 'end_date' => $end_to_data, 'country_id' => $row['country_id'],
            'state_id' => $row['state_id'], 'city_id' => $row['city_id'], 'pincode_number' => $row['pincode_number'], "email_address" => $row['email_address'],
            'website' => $row['website'], 'mobile_number_1' => $row['mobile_number_1'], 'mobile_number_2' => $row['mobile_number_2'],
            'work_task' => $work_task, "designations" => $designations, "start_from" => $start_from, "end_to" => $end_to));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>