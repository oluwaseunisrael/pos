<?php include('includes/header.php'); 

if (!isset($_SESSION['productItems'])) {
	echo "<script> window.location.href ='create-order.php';</script>";
}
?>


<div class="modal fade" id="addSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
       
     <h5 id="orderplacesuccessmessage"></h5>
      <div class="modal-footer">
        <a href="order.php" class="btn btn-secondary">Close</a>
        <button type="button" class="btn btn-primary "  onclick="printBillingArea()">Print Pdf</button>
        <button type="button" class="btn btn-primary " onclick="downloadPDF('<?= $_SESSION['invoice_no']?>')">Download</button>
      </div>
    </div>
  </div>
</div>
</div>


<div class="container-fluid px-4">
	<div class="row">
		<div class="col-md-12">
			<div class="card mt-4">
				<div class="card-header">
					<h4 class="mb-0">Order Summary
						<a href="create-order.php" class="btn btn-danger float-end">Back to create order</a>
					</h4>
				</div>
				<div class="card-body">
					<?php alertMessage()?>
					<div id="myBillingArea">
						<?php 
                        if (isset($_SESSION['cphone'])) {
                        	$phone = validation($_SESSION['cphone']);
                        	$invioce = validation($_SESSION['invoice_no']);
                        	$customerQuery = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone' LIMIT 1");
                        	if ($customerQuery) {
                        		if (mysqli_num_rows($customerQuery)> 0) {
                        			$result = mysqli_fetch_assoc($customerQuery);
                        			?>
                        			<table style="width:100%; margin-bottom: 20px;">
                        				<thead>
                        					<tr>
                        						<th style="text-align: center;" colspan="2">
                        							<h4 style="font-size: 23px; line-height: 30px; margin: 2px; padding:0 ;">Omsinternational company</h4>
                        							<p style="font-size: 16px; line-height: 30px; margin: 2px; padding:0 ;">Ajegunle street lagos </p>
                        							<h4 style="font-size: 16px; line-height: 30px; margin: 2px; padding:0 ;">Company limited</h4>
                        						</th>
                        					</tr>
                        				</thead>
                        				<tbody>
                        					<tr>
                        						<td colspan="2">
                        							<h5 style="font-size: 20px; line-height: 30px; margin: 2px; padding:0 ;">Customer Details</h5>
                        							<p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0 ;">Customer Name: <?=$result['name']?></p>
                        							<p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0 ;">Customer Phone No: <?=$result['phone']?></p>
                        							<p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0 ;">Customer Email Id: <?=$result['email']?></p>
                        						</td>
                        					</tr>
                        					<tr>
                        						<td colspan="2">
                        							<h5 style="font-size: 20px; line-height: 30px; margin: 2px; padding:0 ;">Invoice Details</h5>
                        							<p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0 ;">Invoice No: <?=$invioce;?></p>
                        							<p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0 ;">Invoice Date: <?=date('d M Y')?></p>
                        							<p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0 ;">Address: 1, sholooata</p>
                        						</td>
                        					</tr>
                        				</tbody>
                        			</table>
                        			<?php
                        		} else {
                        			echo '<h5> No Customer found</h5>';
                        		}
                        	}
                        }
						?>
						<?php  
                        if (isset($_SESSION['productItems'])) {
                            $sessionProduct = $_SESSION['productItems'];
                        ?>
                        <div class="table-responsive mb-3">
                        	<table class="table">
                        		<thead>
                        			<tr>
                        				<th style="border-bottom: 1px solid #ccc; width: 5%;">ID</th>
                        				<th style="border-bottom: 1px solid #ccc; width: 10%;">Product Name</th>
                        				<th style="border-bottom: 1px solid #ccc; width: 10%;">Price</th>
                        				<th style="border-bottom: 1px solid #ccc; width: 10%;">Quantity</th>
                        				<th style="border-bottom: 1px solid #ccc; width: 10%;">Total Price</th>
                        			</tr>
                        		</thead>
                        		<tbody>
                        			<?php
                        			$i = 1;
                        			$totalAmount = 0; 
                        			foreach ($sessionProduct as $key => $row) {
                        				$totalAmount += $row['price'] * $row['quantity'];
                        			?>
                        			<tr>
                        				<td style="border-bottom: 1px solid #ccc;"><?= $i++;?></td>
                        				<td style="border-bottom: 1px solid #ccc;"><?= $row['name'];?></td>
                        				<td style="border-bottom: 1px solid #ccc;"><?= number_format($row['price'], 0);?></td>
                        				<td style="border-bottom: 1px solid #ccc;"><?= $row['quantity'];?></td>
                        				<td style="border-bottom: 1px solid #ccc;"><?= number_format($row['price'] * $row['quantity'], 0);?></td>
                        			</tr>
                        			<?php } ?>
                        			<tr>
                        				<td colspan="4" style="font-weight: bold; text-align: end;">Grand Total:</td>
                        				<td style="font-weight: bold;"><?= number_format($totalAmount, 0);?></td>
                        			</tr>
                        			<tr>
                        				<td colspan="5">Payment Mode: <?= $_SESSION['payment_mode'];?></td>
                        			</tr>
                        		</tbody>
                        	</table>
                        </div>
                        <?php 
                        } else {
                            echo '<h5> No items Added</h5>';
                        }
                        ?>
					</div>
					<?php  if (isset($_SESSION['productItems'])):?> 
						<div class="mt-4 text-end">
							<button class="btn btn-primary px-4 mx-1 " type="button" id="saveorder">saveOrder</button>
							<button type="button" class="btn btn-info "  onclick="printBillingArea()">Print Pdf</button>
        <button type="button" class="btn btn-warning " onclick="downloadPDF('<?= $_SESSION['invoice_no']?>')">Download</button>

					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('includes/footer.php'); ?>
