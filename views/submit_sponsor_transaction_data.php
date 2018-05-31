<?php
include_once '../common/config.php';

extract($_POST);
extract($_GET);

$loginid = $objsession->get("log_admin_loginid");
$currentDate = date('Y-m-d');

$arrData = array();

if ($_POST) {

    if (!empty($family_name)) {
        $family_name = implode(",", $family_name);
    }

    if (!empty($given_name)) {
        $given_name = implode(",", $given_name);
    }

    if (!empty($reason_for_change)) {
        $reason_for_change = implode(",", $reason_for_change);
    }

    $address = "";
    if ($exp_address1 != "") {
        $address .= $exp_address1;
    }

    if ($exp_address2 != "") {
        $address .= "," . $exp_address2;
    }

    if ($exp_address3 != "") {
        $address .= "," . $exp_address3;
    }

    $date_of_birth = str_replace('/', '-', $date_of_birth);

    $field = array('inquiry_id', 'sponsor_name', 'relation_id', 'annual_income', 'date_of_birth', "address", "family_name", "given_name", "reason_for_change", "is_active");
    $value = array($inquiry_id, $sponsor_name, $relation_id, $annual_income, date("Y-m-d",strtotime($date_of_birth)), $address, $family_name, $given_name, $reason_for_change, 1);
    $expr_array = array_combine($field, $value);

    if ($sponsor_id != "" && $sponsor_id > 0) {
        $id = $sponsor_id;
        $obj->update($expr_array, 'sponsor', array('sponsor_id' => $sponsor_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $arrData = $obj->fetchRowAll('sponsor', $cond, $params);

    } else {
        $id = $obj->insert($expr_array, 'sponsor');
    }

    if (!empty($branch_name)) {
        $branch_name = implode(",", $branch_name);
    }

    if (!empty($branch_code)) {
        $branch_code = implode(",", $branch_code);
    }

    if (!empty($account_name)) {
        $account_name = implode(",", $account_name);
    }

    if (!empty($account_number)) {
        $account_number = implode(",", $account_number);
    }

    if (!empty($account_type)) {
        $account_type = implode(",", $account_type);
    }

    if (!empty($balance_in_inr)) {
        $balance_in_inr = implode(",", $balance_in_inr);
    }

    if (!empty($referance_rate_type)) {
        $referance_rate_type = implode(",", $referance_rate_type);
    }

    if (!empty($ref_rate)) {
        $ref_rate = implode(",", $ref_rate);
    }

    if (!empty($available_balance)) {
        $available_balance = implode(",", $available_balance);
    }

    $field_ = array('sponsor_id', 'name_of_institute', 'institude_address', 'branch_name', 'branch_code', "account_name", "account_number", "account_type", "balance_in_inr", "referance_rate_type", "ref_rate", "available_balance", "is_active");
    $value_ = array($id, $name_of_institute, $institude_address, $branch_name, $branch_code, $account_name, $account_number, $account_type, $balance_in_inr, $referance_rate_type, $ref_rate, $available_balance, 1);
    $tra_array = array_combine($field_, $value_);

    if ($sponsor_id != "" && $sponsor_id > 0) {
        $id = $sponsor_id;
        $obj->update($tra_array, 'financial', array('sponsor_id' => $sponsor_id));

    } else {
        $id = $obj->insert($tra_array, 'financial');
    }

    $clk = "return confirm('Are you sure want to delete?')";

    if ($id) {
        $link = '<a href="javascript:void(0);" data-id="' . $id . '" class="update" onclick="editSponsor(' . $id . ');" ><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' . $id . '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';


        echo json_encode(array('status' => true, 'id' => $id, 'sponsor_name' => $sponsor_name, 'relation_name' => $relation_id, 'annual_income' => $annual_income,
            'link' => $link, 'address' => $address, 'data' => $arrData));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>