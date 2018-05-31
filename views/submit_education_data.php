<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$eduData = array();

if ($_POST) {

    $field = array('inquiry_id', 'name_of_degree', 'name_of_center', "medium", "passed_on", "percentage", "passed_class", "is_active");
    $value = array($inquiry_id, $name_of_degree, $name_of_center, $medium, $passed_on, $percentage, $passed_class, 1);
    $education_array = array_combine($field, $value);

    if ($education_id != "" && $education_id > 0) {
        $id = $education_id;
        $obj->update($education_array, 'education_details', array('education_id' => $education_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $eduData = $obj->fetchRowAll('education_details', $cond, $params);
    } else {
        $id = $obj->insert($education_array, 'education_details');
    }

    $clk = "return confirm('Are you sure want to delete?');";

    if ($id) {
        $link = '<a href="javascript:void(0);" data-id="' . $id . '" class="update" onclick="editEdution(' . $id . ');" ><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' . $id . '" onclick="' . $clk . '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';
        echo json_encode(array('status' => true, 'id' => $id, 'name_of_degree' => $name_of_degree, 'name_of_center' => $name_of_center,
            'link' => $link, 'passed_on' => $passed_on, 'percentage' => $percentage, 'passed_class' => $passed_class, 'data' => $eduData));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>