<?php 
session_start();
if(file_exists('route/web.php')){
	define('APP_PATH', 'index.php');
	require_once 'application/helper/common_helper.php';
	require 'route/web.php';
} else{
	die('Website dang duoc nang cap, vui long quay lai sau');
}
