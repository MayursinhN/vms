<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {

    if ($other_event_name != "") {

        $field = array('name', 'category_name', "other", "created_date", "is_active");
        $value = array($other_event_name, 'events', "", $currentDate, 1);
        $event_arr = array_combine($field, $value);
        $master_id = $obj->insert($event_arr, 'masters_list');
    }

    $start_held_on = str_replace('/', '-', $start_held_on);
    $end_held_on = str_replace('/', '-', $end_held_on);

    $field = array('inquiry_id', 'master_id', 'title', 'start_date', 'end_date', 'duration', 'place', 'arrange_by', 'is_active');
    $value = array($inquiry_id, $master_id, $title, date("Y-m-d", strtotime($start_held_on)), date("Y-m-d", strtotime($end_held_on)), $duration, $place, $loginid, 1);
    $event_array = array_combine($field, $value);

    if ($event_id > 0) {
        $id = $event_id;
        $obj->update($event_array, 'events', array('event_id' => $event_id));
    } else {
        $id = $obj->insert($event_array, 'events');
    }

    if ($inquiry_id) {

        $cond = "event_id=:event_id";
        $params = array(":event_id" => $event_id);
        $row = $obj->fetchRow('events', $cond, $params);

        if ($row['start_date'] != "1970-01-01" && $row['start_date'] != "0000-00-00") {
            $row['start_date'] = date("d/m/Y",strtotime($row['start_date']));
        } else {
            $row['start_date'] = "";
        }

        if ($row['end_date'] != "1970-01-01" && $row['end_date'] != "0000-00-00") {
            $row['end_date'] = date("d/m/Y",strtotime($row['end_date']));
        } else {
            $row['end_date'] = "";
        }

        $cond = "master_id=:master_id";
        $params = array(":master_id" => $master_id);
        $masters_list = $obj->fetchRow('masters_list', $cond, $params);

        $row["e_name"] = $masters_list['name'];

        echo json_encode(array('status' => true, 'id' => $id,'data' => $row) );
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>