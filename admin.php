<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
	<div class="card mt-4 shadow-sm">
		<div class="card-header">
			<h4 class="mb-0">Admins/Staff</h4>
			<a href="admins-create.php" class="btn btn-primary float-end">Add Admin</a>
		</div>
		<div class="card-body">
		 <?php alertMessage();?>
          	<?php
              $admins = getAll('admins');
              if (!$admins) {
              	echo "<h4>Something went wrong</h4>";
              }
              if (mysqli_num_rows($admins)> 0) 
               {
            ?>
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead >
						<tr>
							<td>ID</td>
							<td>Name</td>
							<td>Email</td>							
							<td>is_ban</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
					   
                          <?php foreach ($admins as $adminitem): ?> 
							<td><?=$adminitem['id']?></td>
							<td><?=$adminitem['name']?></td>
							<td><?=$adminitem['email']?></td>
							<td>
                            	<?php
                                 if ($adminitem['is_ban'] == 1) {
                                 	echo '<span class = "badge bg-danger">Banned</span>';
                                 }else{
                                 	echo '<span class = "badge bg-primary">Active</span>';

                                 }
                            	?>
                            </td>
						    <td><a href="admin-edit.php?id= <?=$adminitem['id'];?>" class="btn btn-success btn-sm">Update</a>
						   <a href="admin-delete.php?id= <?=$adminitem['id'];?>" class="btn btn-danger btn-sm">Delete</a>
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
