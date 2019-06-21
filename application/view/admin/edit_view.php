<?php 
if(!defined('APP_PATH')){
	die('Khong the truy cap');
}
?>
<main class="my-5">
	<div class="container">
		<div class="row">
			<h2 class="col-lg-12 col-xl-12">
				Form edit
			</h2>
			<?php if($errorsEditData):?>
				<ul style="width:50%;">
					<?php foreach ($errorsEditData as $key => $value): ?>
						<li style="color:red;" > <?= $value;?> </li>
					<?php endforeach; ?>	
				</ul>
			<?php endif; ?>	
			<form action="?c=admin&m=handleedit&id=<?= $info['id'] ?>" method="POST" class="mt-10">
				<label for="txtUsername">Nhập tên user</label>
				<br>
				<input type="text" name="username" id="username" class="form-control" value="<?= $info['username']; ?>">
				<br>
				<label for="txtPassword">Nhập pass</label>
				<br>
				<input type="password" name="password" id="password" class="form-control"value="<?= $info['password']; ?>">
				<br>
				<label for="txtEmail">Nhập email</label>
				<br>
				<input type="email" name="email" id="email" class="form-control" value="<?= $info['email']; ?>">
				<br>
				<label for="txtRole">Nhập role</label>
				<br>
				<select class="form-control" name="role" id="role">
					<!-- <option value=""></option> -->
					<option value="-1" <?= $info['role'] == -1 ? "selected" : ""; ?>>Super Admin</option>}
					<option value="1" <?= $info['role'] == 1 ? "selected" : ""; ?>>Admin</option>
				</select>
				<br>
				<label for="txtStatus">Nhập status</label>
				<br>
				<select class="form-control" name="status" id="status">
					<!-- <option value=""></option> -->
					<option value="0" <?= $info['status'] == 1 ? "selected" : ""; ?>>Deactive</option>}
					<option value="1" <?= $info['status'] == 1 ? "selected" : ""; ?>>Active</option>
				</select>
				<br>
				<label for="txtPhone">Nhập phone</label>
				<br>
				<input type="text" name="phone" id="phone" class="form-control" value="<?= $info['phone']; ?>">
				<br>
				<label for="txtAddress">Nhập address</label>
				<br>
				<textarea name="address" id="address" class="form-control" rows="5"><?= $info['address'] ?></textarea>
				<br><br>
				<button type="submit" class="btn btn-primary" name="btnEdit">Xác nhận</button>
			</form>
		</div>
	</div>
</main>