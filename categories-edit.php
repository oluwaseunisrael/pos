<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
	<div class="card mt-4 shadow-sm">
		<div class="card-header">
			<h4 class="mb-0">update Category</h4>
			<a href="categories.php" class="btn btn-primary float-end">Back</a>
		</div>
		<div class="card-body">
			<?php alertMessage();?>
			<form class="" action="code.php" method="post">
				<?php 
                $parmValue = checkParamTd('id');
                if (!is_numeric($parmValue)) {
                	// code...
                	echo '<h5>'.$parmValue.'</h5>';
                	return false;
                }
                 $Category= getById('categories', $parmValue);
                  if (isset($Category['status']) && $Category['status'] == 200 )
                 {
                  ?>
                  
                  <input type="hidden" name="categoryid" value="<?= $Category['data']['id']; ?>" >
               				<div class="row">
					<div class="col-md-12 mb-3">
						<label for="">Name</label>
						<input type="text" name="name" value="<?= $Category['data']['name']; ?>" required class="form-control"/>
					
				</div>
					
					<div class="col-md-12 mb-3">
						<label for="">Description</label>
						<textarea class="form-control" name="description" value="<?= $Category['data']['description']; ?>" rows="3"></textarea>
				
				      </div>
				<div class="col-md-6">
					<label>Status (unchecked= visible, Checked = hidden)</label>
					<input type="checkbox" name="Status" value="<?= $Category['data']['status'] == true ? 'checked' : ''; ?>"  style="width:30px; height: 30px;">
				</div>
					<div class="col-md-12 mb-3 text-end">
					<button type="submit" name="updateCategory" class="btn btn-primary">Save</button>
				   </div>
				</div>

                 <?php

                 }
                 else
                 {
                 echo '<h5>'.$Category['message'].'</h5>';
                 } 

				?>

			</form>
		</div>
	</div>


</div>
<?php include('includes/footer.php'); ?>