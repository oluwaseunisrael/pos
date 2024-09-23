<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Customer</h4>
            <a href="customer.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form class="" action="code.php" method="post">

                <?php 
                $parmValue = checkParamTd('id');
                if (!is_numeric($parmValue)) {
                    echo '<h5>Invalid parameter value</h5>';
                    return false;
                }

                $customer = getById('customers', $parmValue);
                if (isset($customer['status']) && $customer['status'] == 200 && isset($customer['data'])) {
                ?>
                    <input type="hidden" name="customerid" value="<?= htmlspecialchars($customer['data']['id']); ?>">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($customer['data']['name']); ?>" required class="form-control"/>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Email id</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($customer['data']['email']); ?>" class="form-control"/>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Phone</label>
                            <input type="number" name="phone" value="<?= htmlspecialchars($customer['data']['phone']); ?>" class="form-control"/>
                        </div>
                        <div class="col-md-6">
                            <label>Status (unchecked = visible, checked = hidden)</label>
                            <input type="checkbox" name="status" <?= $customer['data']['status'] == true ? 'checked' : ''; ?> style="width:30px; height: 30px;">
                        </div>
                        <div class="col-md-12 mb-3 text-end">
                            <button type="submit" name="updateCustomer" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                <?php
                } else {
                    echo '<h5>' . htmlspecialchars($customer['message']) . '</h5>';
                    return false;
                }
                ?>
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
