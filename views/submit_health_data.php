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

    $field = array('inquiry_id', 'provider_name', 'start_date', 'end_date', 'total_amount', "paid_to", "is_active");
    $value = array($inquiry_id, $provider_name, date("Y-m-d", strtotime($start_date)), date("Y-m-d", strtotime($end_date)), $total_amount, $paid_to, 1);
    $expr_array = array_combine($field, $value);

    if ($insurance_id != "" && $insurance_id > 0) {
        $id = $insurance_id;
        $obj->update($expr_array, 'insurance', array('insurance_id' => $insurance_id));

        $cond = "inquiry_id=:inquiry_id";
        $params = array(":inquiry_id" => $inquiry_id);
        $arrData = $obj->fetchRowAll('insurance', $cond, $params);

    } else {
        $id = $obj->insert($expr_array, 'insurance');
    }

    $clk = "return confirm('Are you sure want to delete?')";

    if ($id) {
        $link = '<a href="javascript:void(0);" data-id="' . $id . '" class="update" onclick="editHealth(' . $id . ');" ><i
                                                                            style="padding: 0px;font-size: 20px;"
                                                                            class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a><a href="javascript:void(0);" data-id="' . $id . '" class="remove"><i style="padding: 5px !important;font-size: 20px;" class="fa fa-times" aria-hidden="true"></i></a>';


        echo json_encode(array('status' => true, 'id' => $id, 'provider_name' => $provider_name, 'start_date' => date("d/m/Y", strtotime($start_date)),
            'end_date' => date("d/m/Y", strtotime($start_date)), 'link' => $link, 'total_amount' => $total_amount, 'data' => $arrData));
    } else {
        echo json_encode(array('status' => false, 'id' => 0));
    }

}

?>