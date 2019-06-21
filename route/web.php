<?php

if(!defined('APP_PATH')){
	die('Khong the truy cap');
} 
/**
 * 
 */
class Route
{
	public function home(){
		// http://locahost/mvclphp1811e/?c=home
		// http://locahost/mvclphp1811e
		// echo 'This is route - home';
		//  Dieu huong vao controller home
		 require 'application/controller/HomeController.php';
	}
	public function cart(){
		echo 'This is route - cart';
	}
	public function login(){
		require 'application/controller/LoginController.php';
	}
	public function about(){
		require 'application/controller/AboutController.php';
	}
	public function contact(){
		require 'application/controller/ContactController.php';
	}
	public function __call($req, $res){
		echo "Khong tim thay method";
	}
	public function admin(){
		require 'application/controller/AdminController.php';
	}
}

$route = new Route;
$c = $_GET['c'] ?? 'home';
// $c = isset($_GET['c']) ? $_GET['c'] : 'home';
$route->$c(); 