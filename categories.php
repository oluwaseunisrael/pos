<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
	<div class="card mt-4 shadow-sm">
		<div class="card-header">
			<h4 class="mb-0">Categories</h4>
			<a href="categories-create.php" class="btn btn-primary float-end">Add Category</a>
		</div>
		<div class="card-body">
		 <?php alertMessage();?>
          	<?php
              $categories = getAll('categories');
              if (!$categories) {
              	echo "<h4>Something went wrong</h4>";
              }
              if (mysqli_num_rows($categories)> 0) 
               {
            ?>
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead >
						<tr>
							<td>ID</td>
							<td>Name</td>
							<td>Status</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
					
                          <?php foreach ($categories as $item): ?> 
							<td><?=$item['id']?></td>
							<td><?=$item['name']?></td>
							
						    <td>
                            	<?php
                                 if ($item['status'] === 1) {
                                 	echo '<span class = "badge bg-danger">Hidden</span>';
                                 }else{
                                 	echo '<span class = "badge bg-primary">Visible</span>';

                                 }
                            	?>
                            </td>

						    <td><a href="categories-edit.php?id= <?=$item['id'];?>" class="btn btn-success btn-sm">Update</a>
						   <a href="categorie-delete.php?id= <?=$item['id'];?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
						</tr>
					<?php endforeach; ?>
                       
				     </tbody>
				</table>
			</div>
			 <?php 
                         }
                         else
                         {

                         
                         ?>
                         <tr>
                         	<h4 class="mb-0">No Record Found</h4>
                         </tr>
                         <?php

                     }
                     ?>
		</div>
	</div>


</div>
<?php include('includes/footer.php'); ?>
