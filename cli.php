<?php 
if (isset($_SERVER['REMOTE_ADDR'])) {  
	die('Command Line Only!');  
}

ini_set("max_execution_time",0);
$_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'] = $argv[1];  
require 'index.php';