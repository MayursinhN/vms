<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {

    if (!isset($visa_type_applied)) {
        $visa_type_applied = "";
    }

    if (!isset($visa_granted)) {
        $visa_granted = "";
    }

    if (!isset($did_travel)) {
        $did_travel = "";
        $from_travel = "00/00/0000";
        $to_travel = "00/00/0000";
    }

    $from_travel = str_replace('/', '-', $from_travel);
    $to_travel = str_replace('/', '-', $to_travel);

    $field = array('inquiry_id', "visa_type_applied", "applied_country", "visa_granted",
        "is_travel", "from_date", "to_date", "previous_assign", "remark");
    $value = array($inquiry_id, $visa_type_applied, $applied_country, $visa_granted, $did_travel,
        date("Y-m-d", strtotime($from_travel)), date("Y-m-d", strtotime($to_travel)), $previously_assign_by, $remark);
    $immi_array = array_combine($field, $value);

    if ($immi_id > 0) {
        $id = $immi_id;
        $obj->update($immi_array, 'immigration_details', array('immigration_id' => $immi_id));
    } else {
        $id = $obj->insert($immi_array, 'immigration_details');
    }

    if ($id) {

        $cond = "immigration_id=:immigration_id";
        $params = array(":immigration_id" => $id);
        $row = $obj->fetchRow('immigration_details', $cond, $params);

        if ($row['applied_country'] > 0) {

            $cond = "country_id=:country_id";
            $params = array(":country_id" => $row['applied_country']);
            $countries = $obj->fetchRow('countries', $cond, $params);

            $row['applied_country'] = $countries['name'];
        } else {
            $row['applied_country'] = "";
        }
        if ($row['from_date'] != "1970-01-01" && $row['from_date'] != "0000-00-00") {
            $row['from_date'] = date("d/m/Y",strtotime($row['from_date']));
        } else {
            $row['from_date'] = "";
        }

        if ($row['to_date'] != "1970-01-01" && $row['to_date'] != "0000-00-00") {
            $row['to_date'] = date("d/m/Y",strtotime($row['to_date']));
        } else {
            $row['to_date'] = "";
        }

        echo json_encode(array('status' => true, 'id' => $id, "data" => $row));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>