<?php
include_once '../common/config.php';
extract($_GET);
extract($_POST);
$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');
$obj->delete('meetings', array('inquiry_id' => $inquiry_id));

array_filter($client_question);
array_filter($client_question);

$arrData = array_combine($client_question, $ubp_answer);

if ($client_question != "" && $ubp_answer != "") {
    $field = array('inquiry_id', 'client_question', 'created_by', 'created_date', 'is_active');
    $value = array($inquiry_id, json_encode($arrData), $loginid, $currentDate, 1);
    $meeting_array = array_combine($field, $value);
    $id = $obj->insert($meeting_array, 'meetings');
}

$cond = "inquiry_id=:inquiry_id";
$params = array(":inquiry_id" => $inquiry_id);
$meetings = $obj->fetchRowAll('meetings', $cond, $params);
$aaData = array();

if (count($meetings)) {
    $cnt = 0;
    for ($i = 0; $i < count($meetings); $i++) {
        $client_question = json_decode($meetings[$i]['client_question']);

        foreach ($client_question as $key => $val) {
            if ($key != "") {
                $aaData[$cnt]['que'] = $key;
                $aaData[$cnt]['ans'] = $val;
                $cnt++;
            }

        }
    }
}

if ($aaData) {
    echo json_encode(array("status" => true, 'data' => $aaData));
} else {
    echo json_encode(array("status" => false, 'message' => ""));
}

?>

