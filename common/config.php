<?php
header('Access-Control-Allow-Origin: *'); 
/*********************************************
VMS - Config file
Date - 10-Nov-2017 10:11
**********************************************/
if ( $_SERVER['HTTP_HOST'] == "localhost") {
	define('HTTP_SERVER',"http://localhost/vms/");
	define('PATH',"http://localhost/vms/");
} else {
	define('HTTP_SERVER',"http://vms/");
	define('PATH',"http://vms/");
}


/**********************Include Loader files***********************/
require_once ("functions.php");
require_once "database.php";

$obj = new Database();

require_once "session.php";
$objsession = new Session();

require_once "xss_clean.php";
$objxssclean = new xssClean();

define('PROJECT_NAME','Client Management System');
define('PROJECT_ADMIN_TITLE','UBP Group');
define('FOOTER_TITLE','Client Management System');
date_default_timezone_set('Asia/Kolkata');