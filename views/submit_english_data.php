<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_loginid");
$currentDate = date('Y-m-d');

if ($_POST) {

    if ($applyed_for == 1) {

        $proficiency_date = str_replace('/', '-', $proficiency_date);

        $field = array('inquiry_id', "applyed_for", "test_type", "proficiency_date", "proficiency_type",
            "listening", "writing", "reading", "speaking", "is_active");
        $value = array($inquiry_id, $applyed_for, $test_type, date("Y-m-d", strtotime($proficiency_date)), $proficiency_type, $listening, $writing
        , $reading, $speaking, 1);
    } else {
        $field = array('inquiry_id', "applyed_for", "is_active");
        $value = array($inquiry_id, $applyed_for, 1);
    }


    $immi_array = array_combine($field, $value);

    if ($english_id > 0) {
        $id = $english_id;
        $obj->update($immi_array, 'english_test', array('test_id' => $english_id));
    } else {
        $id = $obj->insert($immi_array, 'english_test');
    }

    if ($id) {

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $row = $obj->fetchRow('english_test', $cond, $params);

        $cond = "master_id =:master_id";
        $params = array(":master_id" => $row['test_type']);
        $englishExam = $obj->fetchRow('masters_list', $cond, $params);
        $row['test_type'] = $englishExam['name'];

        if ($row['applyed_for'] == 1) {
            $row['applyed_for'] = "Yes";
        } else if ($row['applyed_for'] == 0) {
            $row['applyed_for'] = "No";
        }

        $row['proficiency_date'] = date("d/m/Y", strtotime($row['proficiency_date']));

        echo json_encode(array('status' => true, 'id' => $id, 'data' => $row));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>