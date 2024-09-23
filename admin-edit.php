<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
	<div class="card mt-4 shadow-sm">
		<div class="card-header">
			<h4 class="mb-0">Edit Admins</h4>
			<a href="admin.php" class="btn btn-danger float-end">Back</a>
		</div>
		<div class="card-body">
			<?php alertMessage();?>
			<form class="" action="code.php" method="post">
				<?php
				if (isset($_GET['id'])) {
				 if ($_GET['id'] != '') {
				    $adminsId = $_GET['id'];
				 }else{
				 	echo '<h4> No Id found</h4>';
				 	return false;
				 }
				}else{
                    echo '<h4> No Id Given in the params</h4>';
				 	return false;
				}
                 $adminData = getById('admins', $adminsId);
                 if ($adminData) {
                 	if ($adminData['status'] == 200) {
                 	?>
                 	<input type="hidden" name="adminid" value = '<?=$adminData['data']['id'];?>' >
                 	<div class="row">
					<div class="col-md-12 mb-3">
						<label for="">Name *</label>
						<input type="text" name="name" value = '<?=$adminData['data']['name'];?>' required class="form-control"/>
					</div>
				</div>
					<div class="row">
					<div class="col-md-12 mb-3">
						<label for="">Email *</label>
						<input type="email" name="email" value = '<?=$adminData['data']['email'];?>' required class="form-control"/>
					</div>
				</div>
					<div class="row">
					<div class="col-md-12 mb-3">
						<label for="">Password *</label>
						<input type="email" name="password" value = '<?=$adminData['data']['email'];?>' required class="form-control"/>
					</div>
				</div>
					<div class="row">
					<div class="col-md-12 mb-3">
						<label for="">Phone Number  *</label>
						<input type="Number" name="phone" value = '<?=$adminData['data']['phone'];?>'  required class="form-control"/>
					</div>
				</div>
					<div class="row">
					<div class="col-md-12 mb-3">
						<label for="">Is Ban *</label>
						<input type="checkbox" name="is_ban"  <?=$adminData['data']['is_ban']== true ? 'checked':''; ?> style="width: 30px; height: 30px;" />
					</div>
						<div class="col-md-12 mb-3 text-end">
					<button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
				   </div>
				</div>
				
                 	<?php 
                 	}
                 }else{
                 	echo "somethings went wrong";
                 	return false;
                 }
				 ?>
				
			</form>
		</div>
	</div>


</div>
<?php include('includes/footer.php'); ?>