<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$passportData = array();

if ($_POST) {

    if (!isset($name_flag)) {
        $name_flag = 0;
    }

    $passport_issue_date = str_replace('/', '-', $passport_issue_date);
    $passport_expire_date = str_replace('/', '-', $passport_expire_date);

    $field = array('inquiry_id', 'passport_number', 'passport_issue_date', "passport_expire_date", "name_flag", "passport_lost",
        "passport_name", "details", "is_active");
    $value = array($inquiry_id, $passport_number, date("Y-m-d", strtotime($passport_issue_date)),
        date("Y-m-d", strtotime($passport_expire_date)), $name_flag, $passport_lost, $passport_name, $passport_details, 1);
    $passport_array = array_combine($field, $value);

    if ($passport_id != "" && $passport_id > 0) {
        $id = $passport_id;
        $obj->update($passport_array, 'passpord_details', array('passport_id' => $passport_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $passportData = $obj->fetchRowAll('passpord_details', $cond, $params);
        for($i = 0; $i<count($passportData);$i++) {
            $passportData[$i]['passport_issue_date'] = date("d/m/Y",strtotime($passportData[$i]['passport_issue_date']));
            $passportData[$i]['passport_expire_date'] = date("d/m/Y",strtotime($passportData[$i]['passport_expire_date']));
        }
    } else {
        $id = $obj->insert($passport_array, 'passpord_details');
    }

    $clk = "return confirm('Are you sure want to delete?');";

    if ($id) {
        $link = '<a href="javascript:void(0);" data-id="' . $id . '" class="update" onclick="editPassport(' . $id . ');" ><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' . $id . '" onclick="' . $clk . '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';
        echo json_encode(array('status' => true, 'id' => $id, 'passport_number' => $passport_number,
            'passport_issue_date' => date("d/m/Y", strtotime($passport_issue_date)),
            'link' => $link, 'passport_expire_date' => date("d/m/Y", strtotime($passport_expire_date)), 'data' => $passportData));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>