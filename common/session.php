<?php

class Session{
	
	function __construct(){
		session_start();
	}
	
	function set($sessionName,$sessionValue){
		try{
			if(!empty($sessionValue) || $sessionValue == 0)
					$_SESSION[$sessionName] = $sessionValue;
			else
				throw new Exception('Pass session value proper.');
				
		}catch(Exception $e){
			echo $e->getMessage();
		}
		
	}
	
	function get($sessionName){
		try{
			if(!empty($sessionName))
				if(isset($_SESSION[$sessionName])){ return $_SESSION[$sessionName];}else{ return '';}
			else
				throw new Exception('Pass session name proper.');
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	function remove($sessionName){
		try{
			if(!empty($sessionName))
				unset($_SESSION[$sessionName]);
			else
				throw new Exception('Pass session name proper.');
		}catch(Exception $e){
			echo $e->getMessage();
		}	
	}
}