<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$arrData = array();

if ($_POST) {

    $start_date = str_replace('/', '-', $start_date);
    $end_date = str_replace('/', '-', $end_date);

    $field = array('inquiry_id', 'campus', "course_name", "course_code", "start_date", "end_date", "no_of_semester", "is_active");
    $value = array($inquiry_id, $campus, $course_name, $course_code, date("Y-m-d", strtotime($start_date)), date("Y-m-d", strtotime($end_date)), $no_of_semester, 1);
    $expr_array = array_combine($field, $value);

    if ($course_id != "" && $course_id > 0) {
        $id = $course_id;
        $obj->update($expr_array, 'student_course', array('course_id' => $course_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $arrData = $obj->fetchRowAll('student_course', $cond, $params);

        /*for ($i = 0; $i < count($arrData); $i++) {
            $cond = "country_id=:country_id";
            $params = array(":country_id" => $arrData[$i]['country_id']);
            $country = $obj->fetchRow('countries', $cond, $params);
            $arrData[$i]['country_name'] = $country['name'];
        }
        $country['name'] = "";*/

    } else {
        $id = $obj->insert($expr_array, 'student_course');

        /*$cond = "country_id=:country_id";
        $params = array(":country_id" => $country_id);
        $country = $obj->fetchRow('countries', $cond, $params);*/
    }

    $clk = "return confirm('Are you sure want to delete?')";

    if ($id) {
        $link = '<a href="javascript:void(0);" data-id="' . $id . '" class="update" onclick="editCourse(' . $id . ');" ><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' . $id . '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';


        echo json_encode(array('status' => true, 'id' => $id, 'campus' => $campus, 'link' => $link, 'course_name' => $course_name, 'course_code' => $course_code, 'data' => $arrData));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>