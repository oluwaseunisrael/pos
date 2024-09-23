<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Order View
                <a href="order.php" class="btn btn-danger btn-sm float-end mx-2">Back</a>
            </h4>
        </div>
        <div class="card-body" id="myBillingArea">

            <?php
            if (isset($_GET['track'])) {
                $trackingNo = validation($_GET['track']);
                if ($trackingNo == '') {
                    ?>
                    <div class="text-center py-5">
                        <h5>No Tracking Found</h5>
                        <a href="order.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                    </div>
                    <?php
                } else {
                    $orderQuery = "SELECT o.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id AND tracking_no = '$trackingNo' LIMIT 1";
                    $result = mysqli_query($conn, $orderQuery);

                    if (!$result) {
                        echo "<h5>Something went wrong</h5>";
                        return false;
                    }

                    if (mysqli_num_rows($result) > 0) {
                        $order = mysqli_fetch_assoc($result);
                        ?>
                        <table style="width:100%; margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" colspan="2">
                                        <h4 style="font-size: 23px; line-height: 30px; margin: 2px; padding:0;">Omsinternational company</h4>
                                        <p style="font-size: 16px; line-height: 30px; margin: 2px; padding:0;">Ajegunle street, Lagos</p>
                                        <h4 style="font-size: 16px; line-height: 30px; margin: 2px; padding:0;">Company Limited</h4>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <h5 style="font-size: 20px; line-height: 30px; margin: 2px; padding:0;">Customer Details</h5>
                                        <p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0;">Customer Name: <?= $order['name'] ?></p>
                                        <p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0;">Customer Phone No: <?= $order['phone'] ?></p>
                                        <p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0;">Customer Email Id: <?= $order['email'] ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h5 style="font-size: 20px; line-height: 30px; margin: 2px; padding:0;">Invoice Details</h5>
                                        <p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0;">Invoice No: <?= $order['invoice_no'] ?></p>
                                        <p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0;">Invoice Date: <?= date('d M Y') ?></p>
                                        <p style="font-size: 14px; line-height: 30px; margin: 2px; padding:0;">Address: 1, Sholooata</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        ?>
                        <div class="text-center py-5">
                            <h5>No Tracking Found</h5>
                            <a href="order.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                        </div>
                        <?php
                    }

                    $orderItemQuery = "SELECT oi.quantity as orderquantity, oi.price as orderprice, o.*, oi.*, p.* 
                                       FROM orders o 
                                       JOIN order_items oi ON oi.order_id = o.id 
                                       JOIN products p ON p.id = oi.product_id 
                                       WHERE o.tracking_no = '$trackingNo'";
                    $orderItemQueryRes = mysqli_query($conn, $orderItemQuery);

                    if ($orderItemQueryRes) {
                        if (mysqli_num_rows($orderItemQueryRes) > 0) {
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
                                        while ($row = mysqli_fetch_assoc($orderItemQueryRes)) {
                                            ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['orderprice'], 0); ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['orderquantity']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['orderprice'] * $row['orderquantity'], 0); ?></td>
                                            </tr>
                                            <?php 
                                        } 
                                        ?>
                                        <tr>
                                            <td colspan="4" style="font-weight: bold; text-align: end;">Grand Total:</td>
                                            <td style="font-weight: bold;"><?= number_format($order['total_amount'], 0); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">Payment Mode: <?= $order['payment_mode']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo "<h5>No data found</h5>";
                        }
                    } else {
                        echo "<h5>Something went wrong</h5>";
                    }
                }
            } else {
                ?>
                <div class="text-center py-5">
                    <h5>No Tracking Found</h5>
                    <a href="order.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="mt-4 text-end">
            <button class="btn btn-primary px-4 mx-1" onclick="printBillingArea()">Print</button>
            <button class="btn btn-info px-4 mx-1" onclick="downloadPDF('<?= $order['invoice_no'] ?>')">Download</button>
        </div>
    </div>
</div>

<script>


</script>

<?php include('includes/footer.php'); ?>
