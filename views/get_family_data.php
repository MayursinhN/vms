<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "family_id=:relation_id";
    $params = array(":relation_id" => $relation_id);
    $row = $obj->fetchRow('familydetails', $cond, $params);

    if ($row) {

        $reta_address1 = "";
        $reta_address2 = "";
        $reta_address3 = "";

        $passport_no = "";
        $pass_i_date = "";
        $pass_e_date = "";

        if (!empty($row['address'])) {
            $address = explode(",", $row['address']);
            $reta_address1 = $address[0];
            $reta_address2 = $address[1];
            $reta_address3 = $address[2];
        }

        $passport = array();
        if (!empty($row['passport_number'])) {
            $passport = explode(",", $row['passport_number']);
            $passport_no = $passport[0];
        }

        $passport_issue_date = array();
        if (!empty($row['passport_issue_date'])) {
            $passport_issue_date = explode(",", $row['passport_issue_date']);
            $pass_i_date = $passport_issue_date[0];
        }

        $passport_expire_date = array();
        if (!empty($row['passport_expire_date'])) {
            $passport_expire_date = explode(",", $row['passport_expire_date']);
            $pass_e_date = $passport_expire_date[0];
        }

        $familyData = array();
        $f_name = "";
        if ($row['family_name'] != "") {
            $familyData = explode(",", $row['family_name']);
            $f_name = $familyData[0];
        }

        $gnameData = array();
        $g_name = "";
        if ($row['given_name'] != "") {
            $gnameData = explode(",", $row['given_name']);
            $g_name = $gnameData[0];
        }

        $reasonData = array();
        $reason_id = 0;

        if ($row['reason_for_change'] != "") {
            $reasonData = explode(",", $row['reason_for_change']);

            $cond = "category_name =:category_name AND is_active =:is_active";
            $params = array(":category_name" => 'migrate_name', ":is_active" => 1);
            $reason_for_change = $obj->fetchRowAll('masters_list', $cond, $params);

            $reason_id = $reasonData[0];
        }

        echo json_encode(array('status' => true, 'id' => $row['family_id'], 'applicant_name' => $row['applicant_name'],
            'relationship' => $row['master_id'], 'reta_address1' => $reta_address1, 'reta_address2' => $reta_address2, 'reta_address3' => $reta_address3,
            'date_of_birth' => date("d/m/Y", strtotime($row['date_of_birth'])), 'marriage_date' => date("d/m/Y", strtotime($row['marriage_date'])),
            'passport_number_data' => $passport, 'passport_issue_date_data' => $passport_issue_date, "passport_expire_date_data" => $passport_expire_date,
            'migrate_with_client' => $row['migrate_with_client'], "family_name" => $f_name, "given_name" => $g_name,
            "reason_for_change" => $reason_id, "passport_number" => $passport_no, "passport_issue_date" => $pass_i_date,
            "passport_expire_date" => $pass_e_date, 'familyData' => $familyData, 'givenData' => $gnameData, 'reasonData' => $reasonData));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>