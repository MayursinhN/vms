<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$arrData = array();

if ($_POST) {

    if (!empty($familyAddress)) {
        $familyAddress = implode(",",$familyAddress);
    }

    if (!empty($family_name)) {
        $family_name = implode(",",$family_name);
    }

    if (!empty($given_name)) {
        $given_name = implode(",",$given_name);
    }

    if (!empty($reason_for_change)) {
        $reason_for_change = implode(",",$reason_for_change);
    }

    $date_of_birth = str_replace('/', '-', $date_of_birth);
    $marriage_date = str_replace('/', '-', $marriage_date);

    $field = array('inquiry_id', 'applicant_name', 'master_id', "marriage_date", "address", "date_of_birth", "passport_number", "passport_issue_date",
        "passport_expire_date", "migrate_with_client", "family_name", "given_name", "reason_for_change", "created_date", "is_active");
    $value = array($inquiry_id, $applicant_name, $relationship, date("Y-m-d", strtotime($marriage_date)), $familyAddress, date("Y-m-d", strtotime($date_of_birth)),
        "", "", "", 0, $family_name, $given_name, $reason_for_change, $currentDate, 1);
    $relative_array = array_combine($field, $value);

    if ($relation_id != "" && $relation_id > 0) {

        $id = $obj->update($relative_array, 'familydetails', array('family_id' => $relation_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $arrData = $obj->fetchRowAll('familydetails', $cond, $params);

        for ($i = 0; $i < count($arrData); $i++) {

            $cond = "master_id =:master_id";
            $params = array(":master_id" => $arrData[$i]['master_id']);
            $raltionName = $obj->fetchRow('masters_list', $cond, $params);
            $arrData[$i]['relation'] = $raltionName['name'];
            $arrData[$i]['date_of_birth'] = date("d/m/Y",strtotime($date_of_birth));
        }

        $raltionName['name'] = "";
    } else {
        $id = $obj->insert($relative_array, 'familydetails');

        $cond = "master_id =:master_id";
        $params = array(":master_id" => $relationship);
        $raltionName = $obj->fetchRow('masters_list', $cond, $params);
    }

    $clk = "return confirm('Are you sure want to delete?')";

    if ($id) {
        $link = '<a href="javascript:void(0);" data-id="' . $id . '" class="update" onclick="editRelative(' . $id . ');" ><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a>
                 <a href="javascript:void(0);" data-id="' . $id . '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';

        echo json_encode(array('status' => true, 'id' => $id, 'applicant_name' => $applicant_name, 'relation' => $raltionName['name'],
            'address' => $familyAddress, 'date_of_birth' => date("d/m/Y",strtotime($date_of_birth)),
            "reason_for_change" =>$reason_for_change, 'link' => $link,'data' => $arrData));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>