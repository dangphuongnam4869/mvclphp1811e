<?php 
if(!defined('APP_PATH')){
	die('Khong the truy cap');
}
?>
<main class="my-5">
	<div class="container">
		<div class="">
			<h2 class="col-lg-12 col-xl-12">
				This is Admin
			</h2>
			<a href="?c=admin&m=add" class="btn btn-primary" title="">Add admin</a>		
			<input type="text" class="ml-5" id="txtKeyword" value="<?= $keyword; ?>">
			<button class="btn btn-info" id="btnSearch">Seacrh</button>	
			<a href="?c=admin" class="btn btn-primary" title="">View all</a>
			<div class="row mt-5">
				<table class="table">
					<thead>
						<tr>
							<th>Number</th>
							<th>Username</th>
							<th>Email</th>
							<th>Role</th>
							<th>Status</th>
							<th>Phone</th>
							<th>Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data['infoAdmin'] as $key => $value): ?>
							<tr>
								<td><?= $value['id']; ?></td>
								<td><?= $value['username']; ?></td>
								<td><?= $value['email']; ?></td>
								<td><?= $value['role'] == -1 ? 'Super Admin' : 'Admin'; ?></td>
								<td><?= $value['status'] == 1 ? 'Active' : 'Deactive'; ?></td>
								<td><?= $value['phone']; ?></td>	
								<td><?= $value['address']; ?></td>
								<td>
									<a href="?c=admin&m=edit&id=<?= $value['id']?>" title="" class="btn btn-info" name="btnEdit" id="btnEdit">Edit</a>
								</td>
								<td>
									<!-- 	<a href="?c=admin&m=delete&id=<?= $value['id']?>" class="btn btn-danger" name="btnDel" id="btnDel">Delete</button> -->
										<!-- 	<button type="button" name="btnDel" id="btnDel" class="btn btn-danger">Delete</button> -->
										<form action="?c=admin&m=delete" method="POST" accept-charset="utf-8">
											<input type="hidden" name="idAdmin" value="<?= $value['id'];?>">
											<button type="submit" name="btnDelete" id="btnDelete" class="btn btn-danger">Delete</button>
										</form>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="mt-3 col-lg-12 col-xl-12">
				<?= $pagination; ?>
			</div>
			</div>
		</div>
		<script type="text/javascript">
			$(function(){
				$('#btnSearch').click(function(){
					let keyword = $('#txtKeyword').val().trim();
					if(keyword.length > 2){
						window.location.href = "?c=admin&m=index&keyword=" + keyword;
;					} else{
						alert('Nhap tu khoa can tim');
					}
				});
			});
		</script>
	</main>