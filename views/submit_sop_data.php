<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$exprData = array();

if ($_POST) {

    $field = array("inquiry_id","personal_details","family_details","education_details","cource_details","university_details","country_detils","future_details");
    $value = array($inquiry_id,$personal_backgroud,$family_backgroud,$education_details,$cource_details,$uni_details,$country_details,$future_details);
    $sop_array = array_combine($field, $value);

    $cond = "inquiry_id=:inquiry_id";
    $params = array(":inquiry_id" => $inquiry_id);
    $row = $obj->fetchRow('student_details', $cond, $params);

    if (!empty($row)) {
        $obj->update($sop_array, 'student_details', array('inquiry_id' => $inquiry_id));
    } else {
        $obj->insert($sop_array, 'student_details');
    }

    if ($inquiry_id) {
        echo json_encode(array('status' => true, 'id' => $inquiry_id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>