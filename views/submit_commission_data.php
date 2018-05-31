<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$arrData = array();

if ($_POST) {

    $_sem_inx = "";
    if (!empty($sem_inx)) {
        $_sem_inx = implode(",", $sem_inx);
    }

    $_sem_fees = "";
    if (!empty($sem_fees)) {
        $_sem_fees = implode(",", $sem_fees);
    }

    $_commission = "";
    if (!empty($commission)) {
        $_commission = implode(",", $commission);
    }

    $_invoice_date = "";
    if (!empty($invoice_date)) {
        $_invoice_date = implode(",", $invoice_date);
    }

    $_institute_id = "";
    if (!empty($institute_id)) {
        $_institute_id = implode(",", $institute_id);
    }

    $field = array('course_id', 'sem_inx', 'sem_fees', "commission", "invoice_date", "institute_id", "is_active");
    $value = array($student_counrse_id, $_sem_inx, $_sem_fees, $_commission, $_invoice_date, $_institute_id, 1);
    $relative_array = array_combine($field, $value);

    if ($fees_id != "" && $fees_id > 0) {
        $id = $fees_id;
        $id = $obj->update($relative_array, 'student_fees', array('fees_id' => $fees_id));

    } else {
        $id = $obj->insert($relative_array, 'student_fees');
    }

    if ($id) {

        echo json_encode(array('status' => true, 'id' => $id));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>