<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "course_id=:course_id";
    $params = array(":course_id" => $course_id);
    $row = $obj->fetchRow('student_course', $cond, $params);

    if ($row) {

        echo json_encode(array('status' => true, 'id' => $row['course_id'], 'campus' => $row['campus'],
            'start_date' => date("d/m/Y", strtotime($row['start_date'])),
            'end_date' => date("d/m/Y", strtotime($row['end_date'])),
            'course_code' => $row['course_code'], "course_name" => $row['course_name'], "no_of_semester" => $row['no_of_semester']));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>