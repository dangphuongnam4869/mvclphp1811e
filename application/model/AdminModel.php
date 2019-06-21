<?php
namespace App\Model;
require 'application/config/database.php';
use App\config\Database;
// Su dung thu vien co san PDO
use \PDO;
// if(!defined('APP_PATH')){
// 	die('Khong the truy cap');
// }
class AdminModel extends Database{
	public function __construct(){
			// Goi toi __construct cua lop cha de lay ra bien ket noi
		parent::__construct();
		    // Ben duoi nay se la cac logic cua __construct lop con ma chung ta can dinh nghia - xu ly

	}
	public function getDataInfoAdminByPage($start, $rows, $keyword = ''){
		$key = "%".$keyword."%";
		$data = [];
		$sql = "SELECT * FROM admin AS a WHERE a.username LIKE :username OR a.email LIKE :email LIMIT :start,:rows";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':username', $key, PDO::PARAM_STR);
			$stmt->bindParam(':email', $key, PDO::PARAM_STR);
			$stmt->bindParam(':start', $start, PDO::PARAM_STR);
			$stmt->bindParam(':rows', $rows, PDO::PARAM_STR);
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function checkEditUsernameEmailExits($user, $email, $id){
		$flagEdit = false;
		$sql = "SELECT * FROM admin WHERE admin.username = :user AND admin.email = :email AND admin.id <> :id";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':user', $user, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					$flagEdit = true;
				}
			}
			$stmt->closeCursor();
		}
		return $flagEdit;
	}
	public function checkUsernameEmailExits($user, $email){
		$checkFlag = false;
		$sql = "SELECT * FROM admin AS a WHERE a.username = :username OR a.email = :email LIMIT 1 ";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':username', $user, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					$checkFlag = true;
				}
			}
			$stmt->closeCursor();
		}
		return $checkFlag;
	}
	public function deleteAdminById($id){
		$delFlag = false;
		$sql = "DELETE FROM admin WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			if($stmt->execute()){
				$delFlag = true;
			}
			$stmt->closeCursor();	
		}
		return $delFlag;	
	}
	public function getInfoDataById($id){
		$data = [];
		$sql = "SELECT * FROM admin WHERE admin.id = :id";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					$data = $stmt-> fetch(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function updateDataAdminById($username, $password, $email, $role, $status, $phone, $address, $id){
		$flagEdit = false;
		$updated_at = date('Y-m-d H:i:s');
		$sql = "UPDATE admin AS a SET a.username= :username, a.password = :password, a.email = :email, a.role= :role, a.status= :status, a.phone= :phone, a.address= :address, a.updated_at = :updated_at WHERE a.id = :id ";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':role', $role, PDO::PARAM_INT);
			$stmt->bindParam(':status', $status, PDO::PARAM_INT);
			$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
			$stmt->bindParam(':address', $address, PDO::PARAM_STR);
			$stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
			if($stmt->execute()){
				$flagEdit = true;
			}
			$stmt->closeCursor();
		}
		return $flagEdit;
	}
	public function insertDataAdmin($username, $password, $email, $role, $phone, $address ){
		$flagAdd = false;
		$status = 1;
		$created_at = date('Y-m-d H:i:s');
		$updated_at = null;
		$sql = "INSERT INTO admin (username, password, email, role, status, phone, address, created_at, updated_at) VALUES (:username, :password, :email, :role, :status, :phone, :address, :created_at, :updated_at)";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':role', $role, PDO::PARAM_INT);
			$stmt->bindParam(':status', $status, PDO::PARAM_INT);
			$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
			$stmt->bindParam(':address', $address, PDO::PARAM_STR);
			$stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
			$stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
			if($stmt->execute()){
				$flagAdd = true;
			}
			$stmt->closeCursor();
		}
		return $flagAdd;
	}
	public function getAllDataInfoAdmin($keyword = ''){
		$data = [];
		$key = "%".$keyword."%";
		$sql = "SELECT * FROM admin AS a WHERE a.username LIKE :user OR a.email LIKE :email";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':user', $key, PDO::PARAM_STR);
			$stmt->bindParam(':email', $key, PDO::PARAM_STR);
			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
}
?>