<?php
namespace App\Model;
require 'application/config/database.php';
use App\config\Database;
// Su dung thu vien co san PDO
use \PDO;
// if(!defined('APP_PATH')){
// 	die('Khong the truy cap');
// }
class HomeModel extends Database{
	public function __construct(){
			// Goi toi __construct cua lop cha de lay ra bien ket noi
		parent::__construct();
		    // Ben duoi nay se la cac logic cua __construct lop con ma chung ta can dinh nghia - xu ly

	}
	public function getDataByCondition($start, $stop){
		$data = [];
		$sql = "SELECT * FROM rooms WHERE id > 2 ORDER BY id  DESC LIMIT :start, :stop";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':start', $start, PDO::PARAM_INT);
			$stmt->bindParam(':stop', $stop, PDO::PARAM_INT);
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getDataByCondition2($keyword){
		$data = [];
		$key = "%{$keyword}%";
		$sql = "SELECT * FROM customers AS a WHERE a.name_customer LIKE :name OR a.phone LIKE :phone OR a.person_id LIKE :cmnd";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':name', $key, PDO::PARAM_STR);
			$stmt->bindParam(':phone', $key, PDO::PARAM_STR);
			$stmt->bindParam(':cmnd', $key, PDO::PARAM_STR);
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getDataByCondition3($start, $stop){
		$data = [];
		$sql = "SELECT * FROM bookings WHERE booking_date BETWEEN CAST(:start AS DATE) AND CAST(:stop AS DATE)";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':start', $start, PDO::PARAM_STR);
			$stmt->bindParam(':stop', $stop, PDO::PARAM_STR);
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getDataByController($id = 3){
		$data = [];
		$sql = "SELECT a.price_room FROM prices AS a 
		INNER JOIN types AS b ON a.id = b.price_id 
		INNER JOIN rooms AS c ON b.id = c.type_id 
		INNER JOIN customers AS d ON c.id = d.rooms_id 
		WHERE d.id = :id"; 
			// :id tham so trong sql string PDO
		$stmt = $this->db->prepare($sql);
		if($stmt){
				// Vi trong sql string PDO co tham so truyen vao nen can kiem tra tham so do
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				// Co bao nhieu tham so thi can phai kiem tra bay nhieu
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					// fetch: tra ve mang don
					// fetchAll: tra ve mang da chieu
					$data = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			}
				// Ngat ket noi de co the thuc hien cac $stmt sql tiep theo neu co
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getAllDataByNameTable($nameTable = 'admin'){
			// Lay toan bo du lieu tu table price trong database
			// Viet theo cach truy van CSDL theo thu vien PDO
			$data = []; // 1 mang du lieu rong de lay du lieu ve
			// 1: Khai bao cau lenh sql
			$sql = "SELECT * FROM {$nameTable}";
			// 2: Su dung  ham preparee de thuc thi - kiem tra cau lenh sql
			$stmt = $this->db->prepare($sql);
			if($stmt){
				// Thuc thi cau lenh
				if($stmt->execute()){
					// Thuc thi thanh cong
					// Kiem tra xem bang du lieu co dong du lieu do khong neu co thi moi lay ve
					if($stmt->rowCount() > 0 ){
						// Lay du lieu ra
						$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
						// PDO::FETCH_ASSOC tra ve mang khong tuan tu voi key la ten cac truong
					}
				}
				// Ngat ket noi execute $stmt de co the execute cac $stmt moi
				$stmt->closeCursor();
				// Vi khong con thuc thi cau lenh nao nua nen dung
			}
			return $data;
		}
		public function getDalData(){
			return [
				[
					'msv' => 113,
					'name' => 'NVA',
					'email' => 'a@gmail.com',
					'address' => 'Ha Noi',
					'money' => 1000
				],
				[
					'msv' => 114,
					'name' => 'NVB',
					'email' => 'b@gmail.com',
					'address' => 'Hai Phong',
					'money' => 2000
				],
				[
					'msv' => 115,
					'name' => 'NVC',
					'email' => 'c@gmail.com',
					'address' => 'Ha Giang',
					'money' => 3000
				]
			];
		}
	}