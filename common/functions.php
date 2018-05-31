<?php

function randomString($length = 6) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}

function hashPassword($str) {
	
	$password = "";

	$options = [
	    'cost' => 11,
	    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
	];
	
	$password = password_hash($str ,PASSWORD_BCRYPT, $options);
	return $password;
}

function verifyHashPassword($str, $hash) {

	if (password_verify( $str, $hash )) {
		return true;
	} else {
		return false;
	}
}

function cleanInput($input) {
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
 
    $output = preg_replace($search, '', $input);
    return $output;
  }
  
function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = $this->sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = $this->cleanInput($input);
       //$output = mysql_real_escape_string($input);
    }
    return $input;
}

function encrypt_md5string($str){
	return md5($str);
}

function decrypt_md5string($orinalstring,$str){
	$conver = md5($orinalstring);
	
	if($conver == $str){
		return true;	
	}else{
		return false;	
	}
}

function redirect($url){
	header("Location: ".$url);
}

function deleteImage($imgarr,$path){
		
		unlink(realpath($_SERVER["DOCUMENT_ROOT"]) . $path.'/'.$imgarr);
}