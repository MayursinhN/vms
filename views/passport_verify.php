<?php
include_once '../common/config.php';
extract($_GET);
extract($_POST);
$loginid = $objsession->get("log_admin_loginid");

$cond = "immigration_id = :immigration_id";
$params = array(":immigration_id" => $immi_id);

$userPass = $obj->fetchRow('immigration_details', $cond, $params);

if ($immi_id > 0 && $immi_id != "") {
    $cond = "passport_number=:passport_number AND immigration_id != :immigration_id";
    $params = array(":passport_number" => $passport_number, ":immigration_id" => $immi_id);
} else {
    $cond = "passport_number=:passport_number";
    $params = array(":passport_number" => $passport_number);
}
$totalUser = $obj->fetchNumOfRow('immigration_details', $cond, $params);
if (!empty($userPass)) {
    if ($passport_number == $userPass['passport_number']) {
        echo "true";
    } else {
        echo "false";
    }
} else {

    if ($totalUser > 0) {
        echo "false";
    } else {
        echo "true";
    }
}

?>

