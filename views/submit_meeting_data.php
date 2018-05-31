<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {

    /*if (!empty($client_question)) {
        $client_question = implode("|", $client_question);
    }

    if (!empty($ubp_answer)) {
        $ubp_answer = implode("|", $ubp_answer);
    }*/
    array_filter($client_question);
    array_filter($client_question);

    $arrData = array_combine($client_question, $ubp_answer);

    $objsession->set('ads_message', 'Client details successfully updated.');

    if ($client_question != "" && $ubp_answer != "") {
        $field = array('inquiry_id', 'client_question', 'created_by', 'created_date', 'is_active');
        $value = array($inquiry_id, json_encode($arrData), $loginid, $currentDate, 1);
        $meeting_array = array_combine($field, $value);
        $obj->insert($meeting_array, 'meetings');
    }

    echo json_encode(array('status' => true));

}

?>