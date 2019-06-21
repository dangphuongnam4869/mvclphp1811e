<?php 

function validationAddDataAdmin($username, $password, $email, $phone, $role){
	$errors = [];
	$errors['username'] = (empty($username) || strlen($username) > 40) ? 'Vui long nhap username va khong lon hon 40 ki tu' : '';
	$errors['password'] = (empty($password) || strlen($password) > 40) ? 'Vui long nhap password va khong lon hon 40 ki tu' : '';
	$errors['email'] = (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) < 40) ? '' : 'Vui long nhap email va khong lon hon 40 ki tu';
	$errors['phone'] = (empty($phone) || strlen($phone) > 20) ? 'Vui long nhap phone va khong lon hon 20 so' : '';
	$errors['role'] = empty($role) ? 'Vui long chon quyen tai khoan' : '';
	return $errors;
}
function validationEditDataAdmin($username, $password, $email, $phone){
	$errors = [];
	$errors['username'] = (empty($username) || strlen($username) > 40) ? 'Vui long nhap username va khong lon hon 40 ki tu' : '';
	$errors['password'] = (empty($password) || strlen($password) > 40) ? 'Vui long nhap password va khong lon hon 40 ki tu' : '';
	$errors['email'] = (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) < 40) ? '' : 'Vui long nhap email va khong lon hon 40 ki tu';
	$errors['phone'] = (empty($phone) || strlen($phone) > 20) ? 'Vui long nhap phone va khong lon hon 20 so' : '';
	// $errors['role'] = empty($role) ? 'Vui long chon quyen tai khoan' : '';
	// $errors['status'] = empty($status) ? 'Vui long chon trang thai tai khoan' : '';
	return $errors;
}
function createLink($data = []){
	// Tao ra duong link phan trang danh cho Controller 
	/*
	$data = [
	'c' => 'admin',
	'm' => 'index',
	'keyword' => 'asd'
	'page' => 1
	]
	 */
	// Tu cai mang data nhu tren chung ta build 1 duong link phan trang dua tren cac thong so do
	// index.php?c=admin&m=index&page=1&keyword=admin
	$link = "";
	foreach ($data as $key => $value) {
		# code...
		$link .= (empty($link)) ? "?{$key}={$value}" : "&{$key}={$value}";
	}
	return "index.php" . $link;
}

function panigation($link, $totalRecord, $currentPage, $rows, $keyword){

	// $link = index.php?c=admin&m=index&page={page}&keyword=

	// 1 : tinh tong so trang : totalPage
	$totalPage = ceil($totalRecord/$rows);
	// 2 : xac dinh lai pham vi cua currentPage
	if($currentPage < 1){
		$currentPage = 1;
	}
	if($currentPage > $totalPage){
		$currentPage = 1;
	}
	// 3 : tinh start
	$start = ($currentPage - 1) * $rows;
	// 4 : tao template HTML phan trang - su dung component panigation cua bootstrap de lam template
	$html = '';
	$html .= "<nav>";
	$html .= "<ul class='pagination'>";
	if($currentPage > 1 && $currentPage <= $totalPage){
		// Hien nut previous
		$html .= "<li class='page-item'>";
		$html .= "<a class='page-link' href='".str_replace('{page}',($currentPage - 1 ), $link)."'>Previous</a>";
		$html .= "</li>";
	}
	// Tao vong lap hien thi cac trang o giua (tu 1 -> totalPage)
	for($i=1; $i <= $totalPage; $i++ ){
		if($i == $currentPage){
			// Trang hien tai
			$html .= "<li class='page-item active'>";
			$html .= "<a class='page-link'>".$currentPage."</a>";
			$html .= "</li>";
		} else{
			// Cac trang con lai
			$html .= "<li class='page-item'>";
			$html .= "<a class='page-link' href='".str_replace('{page}',$i, $link)."'>".$i."</a>";
			$html .= "</li>";
		}
	}
	// Xu ly nut next page (Sang trang tiep theo)
	if($currentPage < $totalPage && $currentPage >= 1){
		$html .= "<li class='page-item'>";
		$html .= "<a class='page-link' href='".str_replace('{page}', ($currentPage + 1), $link)."'>Next</a>";
		$html .= "</li>";
	}
	$html .= "</ul>";
	$html .= "</nav>";
	return [
		'start' => $start,
		'limit' => $rows,
		'keyword' => $keyword,
		'pagination' => $html
	];
}

?>