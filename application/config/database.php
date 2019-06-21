<?php 
namespace App\config;
if(!defined('APP_PATH')){
	die('Khong the truy cap');
}
// Su dung thu vien co san PDO
use \PDO;
class Database{
	protected $db;
	public function __construct(){
		// Tao ra bien ket noi de cho cac class model ke thua su dung
		$this->db = $this->connection();
	}
	public function __destruct(){
		// Ngat ket noi toi db
		$this->db = null;
	}
	private function connection(){
		try {
			$dbh = new PDO('mysql:host=localhost;dbname=lphp1811e;charset=utf8', 'root', '');
			$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			return $dbh;
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();

		}
	}
}