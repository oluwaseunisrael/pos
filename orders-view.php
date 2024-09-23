<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
	<div class="card mt-4 shadow-sm">
		<div class="card-header">
			<h4 class="mb-0">Order View
				<a href="order.php" class="btn btn-danger btn-sm float-end mx-2">Back</a>
				<a href="orders-view-print.php?track=<?= $_GET['track']?>" class="btn btn-info btn-sm float-end mx-2"  onclick="printBillingArea()">Print</a>
			</h4>
		</div>
		<div class="card-body">
			<?php alertMessage() ?>
			<?php
			if (isset($_GET['track'])) {
				if ($_GET['track'] == '') {
					?>
				<div class="text-center py-5">
					<h5>No Tracking Found </h5>
					<a href="orders.php" class="btn btn-primary mt-4 w-25">GO back to orders</a>
				</div>
				<?php
					return false;
				}
				$trackingNo = validation($_GET['track']);
				$query = "SELECT * FROM orders o, customers c WHERE c.id = o.customer_id AND tracking_no = '$trackingNo' ORDER BY o.id DESC";
				$orders = mysqli_query($conn, $query);
				if ($orders) {
					if (mysqli_num_rows($orders) > 0) {
						$orderData = mysqli_fetch_assoc($orders);
						$orderId = $orderData['id'];
						?>
						<div class="card card-body shadow border-1 mb-4">
							<div class="row">
								<div class="col-md-6">
									<h4>Order Details</h4>
									<label class="mb-1">
										Tracking No:
										<span><?= $orderData['tracking_no'] ?></span>
									</label>
									<br/>
									<label class="mb-1">
										Order Date:
										<span><?= $orderData['order_date'] ?></span>
									</label>
									<br/>
									<label class="mb-1">
										Order Status:
										<span><?= $orderData['order_status'] ?></span>
									</label>
									<br/>
									<label class="mb-1">
										Payment Mode:
										<span><?= $orderData['payment_mode'] ?></span>
									</label>
									<br/>
								</div>
							</div>
						</div>
						<div class="card card-body shadow border-1 mb-4">
							<div class="row">
								<div class="col-md-6">
									<h4>Customer Details</h4>
									<label class="mb-1">
										Customer Name:
										<span><?= $orderData['name'] ?></span>
									</label>
									<br/>
									<label class="mb-1">
										Email Address:
										<span><?= $orderData['email'] ?></span>
									</label>
									<br/>
									<label class="mb-1">
										Phone Number:
										<span><?= $orderData['phone'] ?></span>
									</label>
									<br/>
								</div>
							</div>
						</div>
						<?php

						$orderItemQuery = "
							SELECT 
								oi.quantity AS orderquantity, 
								oi.price AS orderitemprice, 
								o.id AS order_id, 
								o.customer_id, 
								o.tracking_no, 
								p.id AS product_id, 
								p.name, 
								p.description,
								p.image
							FROM 
								orders AS o
							JOIN 
								order_items AS oi ON oi.order_id = o.id
							JOIN 
								products AS p ON p.id = oi.product_id
							WHERE 
								o.tracking_no = '$trackingNo'";

						$orderItemRes = mysqli_query($conn, $orderItemQuery);
						if ($orderItemRes) {
							if (mysqli_num_rows($orderItemRes) > 0) {
								?>
								<h4>Order Items Details</h4>
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Product</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$totalAmount = 0;
										foreach ($orderItemRes as $item) :
											$total = $item['orderitemprice'] * $item['orderquantity'];
											$totalAmount += $total;
											?>
											<tr>
												<td>
													<img src="<?= $item['image'] != '' ? '../' . $item['image'] : 'no image'; ?>" style="width: 50px; height: 50px;">
													<?= $item['name'] ?>
												</td>
												<td width="15%"><?= number_format($item['orderitemprice'], 0) ?></td>
												<td width="15%"><?= $item['orderquantity'] ?></td>
												<td width="15%"><?= number_format($total, 0) ?></td>
											</tr>
										<?php endforeach ?>
										<tr>
											<td class="text-end fw-bold" colspan="3">Total Price</td>
											<td><?= number_format($totalAmount, 0) ?></td>
										</tr>
									</tbody>
								</table>
								<?php
							} else {
								echo '<h5>No Record Available</h5>';
							}
						} else {
							echo 'Something went wrong';
						}
					} else {
						echo '<h5>No Record Available</h5>';
					}
				} else {
					echo 'Something went wrong';
				}
			}else{
				?>
				<div class="text-center py-5">
					<h5>No Tracking Found </h5>
					<a href="order.php" class="btn btn-primary mt-4 w-25">GO back to orders</a>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
<?php include('includes/footer.php'); ?>
