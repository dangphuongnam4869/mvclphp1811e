<?php
namespace App\Controller;

require 'application/controller/Controller.php';
use App\Controller\Controller;

if(!defined('APP_PATH')){
	die('Khong the truy cap');
} 

class AboutController extends Controller{
	public function index(){
		// echo "This is about";
		// Load header
		$header = [
			'title' => 'This is About page',
			'content' => 'Admin - demo'
		];
		$this->loadHeader($header);

		// Load navbar
		$this->loadNav();

		// Load 1 view
		$data = [];
		$data['age'] = '20';
		$this->loadView('application/view/about/index_view', $data);

		// Load footer
		$this->loadFooter();
	}
}

$about = new AboutController;
$m = $_GET['m'] ?? 'index';
$about->$m();