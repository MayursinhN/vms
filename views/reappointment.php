<?php
include_once '../common/config.php';
extract($_GET);
extract($_POST);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$appo_date_time = str_replace('/', '-', $appo_date_time);

$cond = "appo_date_time =:appo_date_time AND appo_with =:appo_with";
$params = array(":appo_date_time" => date("Y-m-d H:i", strtotime($appo_date_time)), ":appo_with" => $appo_with);

$totalApp = $obj->fetchNumOfRow('appoinments', $cond, $params);

if ($totalApp > 0) {
    echo json_encode(array("status" => false, 'message' => "this time slot is allotted."));
    exit();
} else {

    $_date_time = explode(" ", $appo_date_time);

    $cond = "is_active =:active AND login_id=:login_id AND (from_date <=:from_date AND to_date >=:to_date)  ORDER BY leave_id DESC";
    $params = array(":active" => 1, ":login_id" => $appo_with, ':from_date' => date("Y-m-d", strtotime($_date_time[0])), ':to_date' => date("Y-m-d", strtotime($_date_time[0])));

    $record = $obj->fetchRow('leaves', $cond, $params);

    if (!empty($record)) {

        /*$cond_ = "is_active =:active AND login_id=:login_id AND to_date =:to_date AND to_time >=time(:to_time)";
        $params_ = array(":active" => 1, ":login_id" => $appo_with, ':to_date' => date("Y-m-d", strtotime($_date_time[0])), ':to_time' => $_date_time[1]);

        $record_ = $obj->fetchNumOfRow('leaves', $cond_, $params_);*/

        $toTime = date("H:i", strtotime($record['to_time']));

        if (strtotime($_date_time[1]) < strtotime($toTime) && $record['half_day'] == 1) {
            echo json_encode(array("status" => false, 'message' => "This Person not available for this day."));
            exit();
        } else if ($record['half_day'] == 0) {
            echo json_encode(array("status" => false, 'message' => "This Person not available for this day."));
            exit();
        }
    }

    if ($app_id > 0) {

        $appo_date_time = str_replace('/', '-', $appo_date_time);

        $cond = "app_id=:app_id";
        $params = array(":app_id" => $app_id);
        $row = $obj->fetchRow('appoinments', $cond, $params);

        $field = array('user_type', 'file_number', 'purpose', "appo_with", "details", "name", "mobile_no1", "mobile_no2", "email_address", "appo_date_time",
            "is_active", "is_open", "created_by", "created_date");
        $value = array($row['user_type'], $row['file_number'], $row['purpose'], $appo_with, $row['details'], $row['name'], $row['mobile_no1'], $row['mobile_no2'], $row['email_address'], date("Y-m-d H:i", strtotime($appo_date_time)),
            1, 1, $row['created_by'], $currentDate);
        $appo_array = array_combine($field, $value);

        $obj->insert($appo_array, 'appoinments');

        /*$field = array("appo_with", "appo_date_time", "is_active", "is_open", "modify_by", "modify_date");
        $value = array($appo_with, date("Y-m-d H:i", strtotime($appo_date_time)), 1, 1, $loginid, $currentDate);
        $appo_array = array_combine($field, $value);

        $obj->update($appo_array, 'appoinments', array('app_id' => $app_id));*/

        $objsession->set('appo_message', 'Appointment details updated successfully.');
    }
    echo json_encode(array("status" => true));
}

?>

