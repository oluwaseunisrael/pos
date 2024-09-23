<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
	<div class="card mt-4 shadow-sm">
		<div class="card-header">
			<h4 class="mb-0">Add Product</h4>
			<a href="product.php" class="btn btn-primary float-end">Back</a>
		</div>
		<div class="card-body">
			<?php alertMessage();?>
			<form class="" action="code.php" method="post" enctype="multipart/form-data">

				<?php 
				$parmValue = checkParamTd('id');
				if (!is_numeric($parmValue)) {
				  echo '<h5> Id is not an integer</h5>';
				}

				$product = getById('products', $parmValue);
				if($product) {
			          if ($product['status']  == 200)
			           {
			          	// code...
			         
				?>
				<input type="hidden" name="product_id" value=" <?=$product['data']['id']?>">
				<div class="row">
					<div class="col-md-12 mb-3">
						<label>Select Category</label>
						<select name="category_id" class="form-select">
						<option value="">Select Category</option>
					
						<?php
                          $categories = getAll('categories');
                        if ($categories) {

                        	if (mysqli_num_rows($categories) > 0 ) {
                        		
                        	foreach ($categories as $cateItem) {
                        		?>
                                        <option value="<?= $cateItem['id'];?> "
                                       <?=$product['data']['category_id'] == $cateItem['id'] ?  'selected' :'';  ?> >
                                        <?=$cateItem['name']; ?>

                                        </option>;

                        		<?php
                        	}
                        	}
                        	else{
                               echo'<option value="">No categories found</option>';
                        	}
                        }else
                        {
                        	echo'<option value="">Somethings went wrong</option>';
                        }



						 ?>
						</select>
					</div>
					<div class="col-md-4 mb-3">
						<label for="">Product Name</label>
						<input type="text" name="name" value="<?=$product['data']['name'] ?>" required class="form-control"/>
				    </div>
				
					<div class="col-md-12 mb-3">
						<label for="">Description</label>
						<textarea class="form-control" name="description" rows="3"><?=$product['data']['description']; ?> </textarea>
			     	</div>
				   <div class="col-md-4 mb-3">
						<label for="">Price</label>
						<input type="text" name="price" value="<?=$product['data']['price']; ?>"required class="form-control"/>
				    </div>
				    <div class="col-md-4 mb-3">
						<label for="">Quantity</label>
						<input type="text" name="quantity"value="<?=$product['data']['quantity']; ?>" required class="form-control"/>
				    </div>
				    <div class="col-md-12 mb-3">
						<label for="">Image</label>
						<input type="file" name="image" class="form-control"/>
						<img src="../<?=$product['data']['image'] ;?>">
				    </div>
				    <div class="col-md-6">
					<label>Status (unchecked= visible, Checked = hidden)</label>
					<input type="checkbox" value="<?=$product['data']['status']==true ? 'checked':''; ?>"name="Status" style="width:30px; height: 30px;">
				    </div>
					<div class="col-md-12 mb-3 text-end">
					<button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
				   </div>
				</div>
			</form>
			<?php 
                       }
			          else
			          {
			          	echo '<h5>'.$product['message'].'</h5>';
			          }
				}else
				{
                              echo '<h5> Something went wrong</h5>';
                              return false;
				}
                                      


			?>
		</div>
	</div>


</div>
<?php include('includes/footer.php'); ?>