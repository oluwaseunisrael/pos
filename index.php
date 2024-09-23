<?php include('includes/header.php');


?>
<?php 
$query = "SELECT * FROM customers";
$query_run = mysqli_query($conn,$query);
$row = mysqli_num_rows($query_run);

$query = "SELECT * FROM products";
$query_run = mysqli_query($conn,$query);
$row1 = mysqli_num_rows($query_run);

$query = "SELECT * FROM orders";
$query_run = mysqli_query($conn,$query);
$row2= mysqli_num_rows($query_run);

$query = "SELECT * FROM categories";
$query_run = mysqli_query($conn,$query);
$row2= mysqli_num_rows($query_run);

?>
  <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
          <div class="row">

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-dark text-white mb-4">
                                    <div class="card-body">Customers</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        
                                        <h4><?= $row;?></h4>
                                        
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
    <?php
    ?>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Products</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h4><?= $row1;?></h4>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Orders</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h4><?= $row2;?></h4>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Categories</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                       <h4><?= $row2;?></h4>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
?>
<?php include('includes/footer.php')?>
