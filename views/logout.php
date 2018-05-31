<?php
include_once '../common/config.php';
$objsession->remove("log_admin_loginid");
$objsession->remove("log_admin_type");
redirect(HTTP_SERVER.'');
?>