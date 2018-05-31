<?php
include_once '../common/config.php';
extract($_GET);
extract($_POST);

if ($iLoginID > 0 && $iLoginID != "") {
	$cond = "username=:username AND login_id != :iLoginID";
	$params = array(":username" => $username, ":iLoginID" => $iLoginID);
} else {
	$cond = "username=:username";
	$params = array(":username" => $username);
}
$totalUser = $obj->fetchNumOfRow('login',$cond,$params);
	if($totalUser > 0){
		echo "false";
	}else{ 
	echo "true";
} 

?>

