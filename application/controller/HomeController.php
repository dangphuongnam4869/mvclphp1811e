<?php 
namespace App\Controller;

if(!defined('APP_PATH')){
	die('Khong the truy cap');
}
require 'application/controller/Controller.php';
require 'application/model/HomeModel.php';
use App\Controller\Controller;
use App\Model\HomeModel;


class HomeController extends Controller{
	private $db;
	public function __construct(){
		$this->db = new HomeModel;
	}
	public function index(){
	$data = [];
		// Test
		$db = $this->db->getDalData();
		// $dataPrice = $this->db->getAllDataByNameTable();
		// $priceRoom = $this->db->getDataByController();
		// $roomDesc = $this->db->getDataByCondition(3,7);
		// $person = $this->db->getDataByCondition2('Tèo');
		// $today = date('y-m-d');
		// $week = date('y-m-d',strtotime('-1week'));
		// $booking = $this->db->getDataByCondition3($week, $today);
		// echo "<pre>";
		// print_r($dataPrice);
		// print_r($priceRoom);
		// print_r($roomDesc);
		// print_r($person);
		// print_r($booking);
		$data['name'] = 'Admin';
		$data['info'] = $db;
		//  HAY XU LY XONG TOAN BO DU LIEU ROI MOI LOAD CAC VIEW
		// echo "<pre>";
		// print_r($db);
		// die;
		// Load header
		$header = [
			'title' => 'This is Home page',
			'content' => 'Admin - demo'
		];
		$this->loadHeader($header);

		// Load navbar
		$this->loadNav();

		// Load 1 view
		// $data = [];
		// $data['name'] = 'Admin';
		$this->loadView('application/view/home/index_view', $data);

		// Load footer
		$this->loadFooter();
	}
}

$home = new HomeController;
$m = $_GET['m'] ?? 'index';
$home->$m();