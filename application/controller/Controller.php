<?php
namespace App\Controller;

if(!defined('APP_PATH')){
	die('Khong the truy cap');
}

class Controller{
	protected function loadHeader($header = []){
		$title = $header['title'] ?? '';
		$content = $header['content'] ?? '';
		require 'application/view/common/header_view.php';
	}

	protected function loadNav(){
		require 'application/view/common/nav_view.php';
	}

	protected function loadView($path, $data=[]){
		extract($data);
		// extract: chuyen key cua mang thanh 1 bien
		// $arr = [
		// 	'a' == 10,
		// 	'b' == 20
		// ];
		// extract($arr);
		// echo $a; //10
		// echo $b; //20
		require $path . '.php';
	}

	protected function loadFooter(){
		require 'application/view/common/footer_view.php';
	}
}