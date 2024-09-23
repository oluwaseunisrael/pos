<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
	<div class="card mt-4 shadow-sm">
		<div class="card-header">
			<h4 class="mb-0">Customers</h4>
			<a href="customers-create.php" class="btn btn-primary float-end">Add Customer</a>
		</div>
		<div class="card-body">
		 <?php alertMessage();?>
          	<?php
              $customers = getAll('customers');
              if (!$customers) {
              	echo "<h4>Something went wrong</h4>";
              }
              if (mysqli_num_rows($customers)> 0) 
               {
            ?>
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead >
						<tr>
							<td>ID</td>
							<td>Name</td>
							<td>Email</td>
							<td>Phone</td>
							<td>Status</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
					
                          <?php foreach ($customers as $customer): ?> 
							<td><?=$customer['id']?></td>
							<td><?=$customer['name']?></td>
							<td><?=$customer['email']?></td>
							<td><?=$customer['phone']?></td>
							
						    <td>
                            	<?php
                                 if ($customer['status'] == 1) {
                                 	echo '<span class = "badge bg-danger">Hidden</span>';
                                 }else{
                                 	echo '<span class = "badge bg-primary">Visible</span>';

                                 }
                            	?>
                            </td>

						    <td><a href="customers-edit.php?id= <?=$customer['id'];?>" class="btn btn-success btn-sm">Update</a>
						   <a href="customers-delete.php?id= <?=$customer['id'];?>" class="btn btn-danger btn-sm">Delete</a>
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
