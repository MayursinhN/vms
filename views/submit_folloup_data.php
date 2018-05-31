<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {
    $is_active = 0;
    if (isset($_POST['btn_follow_yes'])) {
        $is_active = 1;
    }

    $date_of_follow = str_replace('/', '-', $date_of_follow);

    $field = array('inquiry_id', "date_of_follow", "is_active");
    $value = array($inquiry_id, date("Y-m-d", strtotime($date_of_follow)), $is_active);
    $follow_array = array_combine($field, $value);

    if ($follow_up_id > 0) {
        $id = $follow_up_id;
        $obj->update($follow_array, 'follow_up', array('follow_up_id' => $follow_up_id));
    } else {
        $id = $obj->insert($follow_array, 'follow_up');
    }

    if ($reference_by != "") {
        $field = array('reference_by', "sub_agent_by", "is_active");
        $value = array($reference_by, $sub_agent_by, 1);
        $immi_array = array_combine($field, $value);

        $objsession->set('ads_message', 'Inquiry successfully added.');
        $obj->update($immi_array, 'inquiry_list', array('inquiry_id' => $inquiry_id));
    } else {
        $objsession->set('ads_message', 'Folloup added successfully');
    }

    if ($id) {
        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>