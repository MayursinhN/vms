<?php
include_once '../common/config.php';

extract($_GET);

if ($_GET) {

    $cond = "sponsor_id=:sponsor_id";
    $params = array(":sponsor_id" => $sponsor_id);
    $row = $obj->fetchRow('sponsor', $cond, $params);

    if ($row) {

        $cond = "sponsor_id=:sponsor_id";
        $params = array(":sponsor_id" => $sponsor_id);
        $financial = $obj->fetchRow('financial', $cond, $params);

        $reta_address1 = "";
        $reta_address2 = "";
        $reta_address3 = "";

        if (!empty($row['address'])) {
            $address = explode(",", $row['address']);
            $reta_address1 = $address[0];
            $reta_address2 = $address[1];
            $reta_address3 = $address[2];
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

        $branchData = array();
        $branch_name = "";

        if ($financial['branch_name'] != "") {
            $branchData = explode(",", $financial['branch_name']);
            $branch_name = $branchData[0];
        }

        $branchCodeData = array();
        $branch_code = "";

        if ($financial['branch_code'] != "") {
            $branchCodeData = explode(",", $financial['branch_code']);
            $branch_code = $branchCodeData[0];
        }

        $accountData = array();
        $account_name = 0;

        if ($financial['account_name'] != "") {
            $accountData = explode(",", $financial['account_name']);
            $account_name = $accountData[0];
        }

        $accountNumData = array();
        $account_number = "";

        if ($financial['account_number'] != "") {
            $accountNumData = explode(",", $financial['account_number']);
            $account_number = $accountData[0];
        }

        $accountTypeData = array();
        $account_type = "";

        if ($financial['account_type'] != "") {
            $accountTypeData = explode(",", $financial['account_type']);
            $account_type = $accountTypeData[0];
        }

        $balanceData = array();
        $balance_in_inr = "";

        if ($financial['balance_in_inr'] != "") {
            $balanceData = explode(",", $financial['balance_in_inr']);
            $balance_in_inr = $balanceData[0];
        }

        $referanceData = array();
        $referance_rate_type = "";

        if ($financial['referance_rate_type'] != "") {
            $reasonData = explode(",", $financial['referance_rate_type']);
            $referance_rate_type = $reasonData[0];
        }

        $refData = array();
        $ref_rate = "";

        if ($financial['ref_rate'] != "") {
            $refData = explode(",", $financial['ref_rate']);
            $ref_rate = $refData[0];
        }

        $availableData = array();
        $available_balance = "";

        if ($financial['available_balance'] != "") {
            $availableData = explode(",", $financial['available_balance']);
            $available_balance = $availableData[0];
        }
        echo json_encode(array('status' => true, 'id' => $row['sponsor_id'], 'sponsor_name' => $row['sponsor_name'],
            'relation_id' => $row['relation_id'], 'exp_address1' => $reta_address1, 'exp_address2' => $reta_address2, 'exp_address3' => $reta_address3,
            'date_of_birth' => date("d/m/Y", strtotime($row['date_of_birth'])), 'annual_income' => $row['annual_income'], "family_name" => $f_name, "given_name" => $g_name,
            "reason_for_change" => $reason_id, "branch_name" => $branch_name, "branch_code" => $branch_code,
            "account_name" => $account_name, 'account_number' => $account_number, 'account_type' => $account_type, 'balance_in_inr' => $balance_in_inr,
            "referance_rate_type" => $referance_rate_type, "ref_rate" => $ref_rate, 'familyData' => $familyData,
            'givenData' => $gnameData, 'reasonData' => $reasonData, 'branchData' => $branchData, "branchCodeData" => $branchCodeData, "accountData" => $accountData,
            "accountNumData" => $accountNumData, "accountTypeData" => $accountTypeData, "balanceData" => $balanceData, "referanceData" => $referanceData,
            "availableData" => $availableData, "available_balance" => $available_balance, "name_of_institute" => $financial['name_of_institute'], "institude_address" => $financial['institude_address']));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>