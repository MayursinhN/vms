<?php
extract($_POST);
include_once '../common/config.php';
if (isset($user_email_id) && $user_email_id != "") {
    $subject = "Inquiry Folloup";
    $msg = "Test";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: Client Management System <webmaster@ezgifting.com>' . "\r\n";

    if (mail($user_email_id, $subject, $msg, $headers)) {
        $objsession->set('ads_message', 'Followup mail send successfully');
        echo json_encode(array('status' => true));
    } else {
        /*print_r(error_get_last());*/
        echo json_encode(array('status' => false));
    }
} else {
    echo json_encode(array('status' => false));
}
?>