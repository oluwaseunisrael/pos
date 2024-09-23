<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
	<div class="card mt-4 shadow-sm">
		<div class="card-header">
			<h4 class="mb-0">Orders</h4>
		</div>
		<div class="col-md-12">
			<form action="" method="get">
				<div class="row g-1">
					<div class="col-md-3">
						<input type="date" name="date" class="form-control" value="<?= isset($_GET['date']) ? $_GET['date'] : ''; ?>"/>
					</div>
					<div class="col-md-3">
						<select class="form-select" name="payment_mode">
							<option value="">Select payment</option>
							<option value="cash payment" <?= isset($_GET['payment_mode']) && $_GET['payment_mode'] == 'cash_payment' ? 'selected' : ''; ?>>Cash Payment</option>
							<option value="online payment" <?= isset($_GET['payment_mode']) && $_GET['payment_mode'] == 'online payment' ? 'selected' : ''; ?>>Online Payment</option>
						</select>
					</div>
					<div class="col-md-3">
						<button type="submit" class="btn btn-primary">Filter</button>
						<a href="order.php" class="btn btn-danger">Reset</a>
					</div>
				</div>
			</form>
		</div>
		<div class="card-body">
			<?php
			

			if (isset($_GET['date']) || isset($_GET['payment_mode'])) {
				$orderdate = isset($_GET['date']) ? $_GET['date'] : '';
				$paymentstatus = isset($_GET['payment_mode']) ? $_GET['payment_mode'] : '';
				$orderdate = mysqli_real_escape_string($conn, $orderdate);
				$paymentstatus = mysqli_real_escape_string($conn, $paymentstatus);

				$query = "SELECT * FROM orders o, customers c WHERE c.id = o.customer_id";
				
				if ($orderdate != '') {
					$query .= " AND o.order_date = '$orderdate'";
				}
				if ($paymentstatus != '') {
					$query .= " AND o.payment_mode = '$paymentstatus'";
				}
				$query .= " ORDER BY o.id DESC";
				
				$orders = mysqli_query($conn, $query);
			} else {
				$query = "SELECT * FROM orders o, customers c WHERE c.id = o.customer_id ORDER BY o.id DESC";
				$orders = mysqli_query($conn, $query);
			}

			if ($orders && mysqli_num_rows($orders) > 0) {
			?>
				<table class="table table-striped table-bordered align-items-center justify-content-center">
					<tr>
						<th>Tracking No</th>
						<th>C Name</th>
						<th>C Phone</th>
						<th>Order Date</th>
						<th>Order Status</th>
						<th>Payment Status</th>
						<th>Action</th>
					</tr>
					<tbody>
						<?php while ($orderItem = mysqli_fetch_assoc($orders)) : ?>
							<tr>
								<td class="fw-bold"><?= htmlspecialchars($orderItem['tracking_no']) ?></td>
								<td><?= htmlspecialchars($orderItem['name']) ?></td>
								<td><?= htmlspecialchars($orderItem['phone']) ?></td>
								<td><?= date('d M Y', strtotime($orderItem['order_date'])) ?></td>
								<td><?= htmlspecialchars($orderItem['order_status']) ?></td>
								<td><?= htmlspecialchars($orderItem['payment_mode']) ?></td>
								<td>
									<a href="orders-view.php?track=<?= htmlspecialchars($orderItem['tracking_no']) ?>" class="btn btn-success mb-0 px-4 btn-sm">View</a>
									<a href="orders-view-print.php?track=<?= htmlspecialchars($orderItem['tracking_no']) ?>" class="btn btn-info mb-0 px-4 btn-sm">Print</a>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			<?php
			} else {
				echo '<h5>No Record Available</h5>';
			}
			?>
		</div>
	</div>
</div>
<?php include('includes/footer.php'); ?>
