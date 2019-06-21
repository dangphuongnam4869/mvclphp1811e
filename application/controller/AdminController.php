<?php
namespace App\Controller;
if(!defined('APP_PATH')){
	die('Khong the truy cap');
}
require 'application/controller/Controller.php';
require 'application/model/AdminModel.php';
use App\Controller\Controller;
use App\Model\AdminModel;
class AdminController extends Controller{
	private $db;
	public function __construct(){
		$this->db = new AdminModel;
	}
	public function index(){
		$data = [];
		$keyword = $_GET['keyword'] ?? '';
		$keyword = strip_tags($keyword);
		$page = $_GET['page'] ?? '';
		$page = (is_numeric($page) && $page > 0) ? $page : 1; 
		$arrayLink = [
			'c' => 'admin',
			'm' => 'index',
			'page' => '{page}',
			'keyword' => $keyword
		];
		$strLink = createLink($arrayLink);
		// echo $strLink;
		// $data['infoAdmin'] = $this->db->getAllDataInfoAdmin($keyword);
		$infoAdmin = $this->db->getAllDataInfoAdmin($keyword);
		$totalRecord = count($infoAdmin);

		// Goi ham phan trang
		$arrPagination = panigation($strLink, $totalRecord, $page, 2, $keyword);
		// echo "<pre>";
		// print_r($arrPagination);
		$data['infoAdmin'] = $this->db->getDataInfoAdminByPage($arrPagination['start'], $arrPagination['limit'], $arrPagination['keyword']);

		$data['keyword'] = $keyword;
		$data['pagination'] = $arrPagination['pagination'];
		$header = [
			'title' => 'This is Admin Page',
			'content' => 'Admin - Demo'
		];
		$this->loadHeader($header);

		// Load navbar
		$this->loadNav();

		// Load 1 view
		$this->loadView('application/view/admin/admin_view',$data);

		// Load footer
		$this->loadFooter();
		// echo "<pre>";
		// print_r($data);
	}
	public function add(){
		$data = [];
		$data['errorAddData'] = $_SESSION['errorsAdd'] ?? [];

		$header = [
			'title' => 'This is Add Admin Page',
			'content' => 'Add Admin - Demo'
		];
		$this->loadHeader($header);
		$this->loadNav();
		$this->loadView('application/view/admin/add_view',$data);
		$this->loadFooter();
	}
	public function edit(){
		$data = [];
		$data['errorsEditData'] = $_SESSION['errorsEdit'] ?? [];
		$id = $_GET['id'];
		$id = is_numeric($id) ? $id : '';
		// echo $id;
		// Lay thong tin cua user admin thong qua id cua no
		$infoAdmin = $this->db->getInfoDataById($id);
		// echo "<pre>";
		// print_r($infoAdmin);
		$header = [
			'title' => 'This is Edit Page',
			'content' => 'Edit - Demo'
		];
		$data['info'] = $infoAdmin;
		$this->loadHeader($header);
		$this->loadNav();
		if($infoAdmin){
			$this->loadView('application/view/admin/edit_view',$data);
		} else{
			$this->loadView('application/view/admin/notfound_view');
		}
		$this->loadFooter();
	}
	public function handleedit(){

		if(isset($_POST['btnEdit'])){
			$username = $_POST['username'] ?? '';
			$username = strip_tags($username);

			$password = $_POST['password'] ?? '';
			$password = strip_tags($password);

			$email = $_POST['email'] ?? '';
			$email = strip_tags($email);

			$role = $_POST['role'] ?? '';
			$role = is_numeric($role) ? $role : '';

			$status = $_POST['status'] ?? '';
			$status = is_numeric($status) ? $status : '';

			$address = $_POST['address'] ?? '';
			$address = strip_tags($address);

			$phone = $_POST['phone'] ?? '';
			$phone = is_numeric($phone) ? $phone : '';

			$id = $_GET['id'] ?? '';
			$id = is_numeric($id) ? $id : '';
			// Validate du lieu truoc khi update
			// VE LAM
			$errorsEdit = validationEditDataAdmin($username, $password, $email, $phone);
			$flagCheck = true;
			foreach ($errorsEdit as $key => $value) {
				# code...
				if(!empty($value)){
					$flagCheck = false;
					// break;
				}
			}
			if($flagCheck){
				if(isset($_SESSION['errorsEdit'])){
					unset($_SESSION['errorsEdit']);
				}
			// Kiem tra xem nguoi dung thay doi username hoac email da ton tai trong db hay chua?
			// Neu da ton tai khong cho sua - update theo gia tri day
			// Nguoc lai cho sua - update theo gia tri do
				$checkEdit = $this->db->checkEditUsernameEmailExits($username, $email, $id);
				if($checkEdit){
				// Khong cho update
					header("Location:?c=admin&m=edit&state=Exits&id=".$id);
				} else{
				// Cho update
					$up = $this->db->updateDataAdminById($username, $password, $email, $role, $status, $phone, $address, $id);
					if($up){
						header('Location:?c=admin&state=UpdateSuccess');
					} else{
						header('Location:?c=admin&m=edit&state=UpdateFail');
					}
				}
			} else{
				$_SESSION['errorsEdit'] = $errorsEdit;
				header("Location: ?c=admin&m=edit&id={$id}&state=Error");
			}
		}
	}
		public function delete(){
		// $id = $_GET['id'];
		// $id = is_numeric($id) ? $id : '';
		// $delAdmin = $this->db->deleteDataAdmin($id);
		// if($delAdmin){
		// 	header('Location:?c=admin&state=DeleteSuccess');
		// }else{
		// 	header('Location:?c=admin&state=DeleteFail');
		// }
			if(isset($_POST['btnDelete'])){
				$idAdmin = $_POST['idAdmin'] ?? '';
				$idAdmin = is_numeric($idAdmin) ? $idAdmin : '';
			// echo $idAdmin;
				$delete = $this->db->deleteAdminById($idAdmin);
				if($delete){
					header('Location:?c=admin&state=DeleteSuccess');
				} else{
					header('Location:?c=admin&state=DeleteFail');
				}
			}
		}
		public function handleadd(){
			if(isset($_POST['btnConfirm'])){
				$username = $_POST['username'] ?? '';
				$username = strip_tags($username);

				$password = $_POST['password'] ?? '';
				$password = strip_tags($password);

				$email = $_POST['email'] ?? '';
				$email = strip_tags($email);

				$role = $_POST['role'] ?? '';
				$role = is_numeric($role) ? $role : '';

				$address = $_POST['address'] ?? '';
				$address = strip_tags($address);

				$phone = $_POST['phone'] ?? '';
				$phone = is_numeric($phone) ? $phone : '';
			// validate du lieu truoc khi insert vao database
			// kiem tracac du lieu form gui len co hop le hay khong (can cu vao trong thiet ke database)
				$errorsAdd = validationAddDataAdmin($username, $password, $email, $phone, $role);
				echo "<pre>";
				print_r($errorsAdd);

				$flagCheck = true;
				foreach ($errorsAdd as $key => $value) {
					if(!empty($value)){
						$flagCheck = false;
						break;
					}
				}
				if($flagCheck){
				// Nguoi dung nhap du lieu hop le - cho add vao db
				// Neu ton tai session loi thi xoa di
					if(isset($_SESSION['errorsAdd'])){
						unset($_SESSION['errorsAdd']);
					}
				// Kiem tra xem username va email da ton tai trong db hay chua Neu chua cho insert
				// neu ton tai thi bao loi
					$checkAdd = $this->db->checkUsernameEmailExits($username, $email);
					if($checkAdd){
					// da ton tai khong cho them moi
						header("Location: ?c=admin&m=add&state=Fail");
					} else{
					// cho them moi
						$add = $this->db->insertDataAdmin($username, $password, $email, $role, $phone, $address);
						if($add){
							header("Location: ?c=admin&state=Succes");
						} else{
						// da ton tai khong cho them moi
							header("Location: ?c=admin&m=add&state=AddFail");
						}
					}
				} else {
				// Nguoi dung nhap sai du lieu - thong bao loi
				// Gan loi vao session
					$_SESSION['errorsAdd'] = $errorsAdd;
					header("Location: ?c=admin&m=add&state=error");
				}
			}
		}
	}

	$admin = new AdminController;
	$m = $_GET['m'] ?? 'index';
	$admin->$m();