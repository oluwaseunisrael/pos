<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
	<div class="card mt-4 shadow-sm">
		<div class="card-header">
			<h4 class="mb-0">Add Category</h4>
			<a href="admin.php" class="btn btn-primary float-end">Back</a>
		</div>
		<div class="card-body">
			<?php alertMessage();?>
			<form class="" action="code.php" method="post">
				<div class="row">
					<div class="col-md-12 mb-3">
						<label for="">Name</label>
						<input type="text" name="name" required class="form-control"/>
				</div>
					<div class="col-md-12 mb-3">
						<label for="">Description</label>
						<textarea class="form-control" name="description" rows="3"></textarea>
				</div>
				<div class="col-md-6">
					<label>Status (unchecked= visible, Checked = hidden)</label>
					<input type="checkbox" name="Status" style="width:30px; height: 30px;">
				</div>
					<div class="col-md-12 mb-3 text-end">
					<button type="submit" name="saveCategory" class="btn btn-primary">Save</button>
				   </div>
				</div>
			</form>
		</div>
	</div>


</div>
<?php include('includes/footer.php'); ?>