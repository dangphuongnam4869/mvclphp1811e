<?php
namespace App\Controller;

require 'application/controller/Controller.php';
use App\Controller\Controller;

if(!defined('APP_PATH')){
	die('Khong the truy cap');
}

class ContactController extends Controller{
	public function index(){
		// Load header
		$header = [
			'title' => 'This is Contact page',
			'content' => 'Admin - demo'
		];
		$this->loadHeader($header);

		// Load navbar
		$this->loadNav();

		// Load 1 view
		$data = [];
		$data['job'] = 'Student';
		$this->loadView('application/view/contact/index_view', $data);

		// Load footer
		$this->loadFooter();
	}
}

$contact = new ContactController;
$m = $_GET['m'] ?? 'index';
$contact->$m();