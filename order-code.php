<?php
include '../config/function.php';

// Initialize session variables if not set
if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}
if (!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}

// Adding an item to the cart
if (isset($_POST['addItem'])) {
    $productId = validation($_POST['product_id']);
    $quantity = validation($_POST['quantity']);
    
    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id ='$productId' LIMIT 1");
    if ($checkProduct && mysqli_num_rows($checkProduct) > 0) {
        $row = mysqli_fetch_assoc($checkProduct);
        if ($row['quantity'] < $quantity) {
            redirect('create-order.php', 'Only ' . $row['quantity'] . ' quantity available');
        }
        
        $productData = [
            'product_id' => $row['id'],
            'name' => $row['name'],
            'image' => $row['image'],
            'price' => $row['price'],
            'quantity' => $quantity
        ];

        if (!in_array($row['id'], $_SESSION['productItemIds'])) {
            $_SESSION['productItemIds'][] = $row['id'];
            $_SESSION['productItems'][] = $productData;
        } else {
            foreach ($_SESSION['productItems'] as $key => $prodSessionItem) {
                if ($prodSessionItem['product_id'] == $row['id']) {
                    $newQuantity = $prodSessionItem['quantity'] + $quantity;
                    $_SESSION['productItems'][$key]['quantity'] = $newQuantity;
                }
            }
        }
        redirect('create-order.php', 'Item added: ' . $row['name']);
    } else {
        redirect('create-order.php', 'No such record found');
    }
}

// Updating the quantity of an item in the cart
if (isset($_POST['productIncDec'])) {
    $productId = validation($_POST['product_id']);
    $quantity = validation($_POST['quantity']);
    $flag = false;

    foreach ($_SESSION['productItems'] as $key => $item) {
        if ($item['product_id'] == $productId) {
            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }

    if ($flag) {
        jsonResponse(200, 'success', 'Quantity updated');
    } else {
        jsonResponse(500, 'error', 'Something went wrong, refresh');
    }
}

// Proceeding to place the order
if (isset($_POST['proceedToPlace'])) {
    $phone = validation($_POST['phones']);
    $payment = validation($_POST['payment_mode']);

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone' LIMIT 1");
    if ($checkCustomer) {
        if (mysqli_num_rows($checkCustomer) > 0) {
            $_SESSION['invoice_no'] = "INV-" . rand(111111, 999999);
            $_SESSION['cphone'] = $phone;
            $_SESSION['payment_mode'] = $payment;
            jsonResponse(200, 'success', 'Customer found');
        } else {
            $_SESSION['cphone'] = $phone;
            jsonResponse(404, 'warning', 'Customer not found');
        }
    } else {
        jsonResponse(500, 'error', 'Something went wrong');
    }
}

// Adding a customer from the modal
if (isset($_POST['saveCustomer'])) {
    $name = validation($_POST['name']);
    $phone = validation($_POST['phone']);
    $email = validation($_POST['email']);

    if ($name != '' && $phone != '') {
        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email
        ];

        $result = insert('customers', $data);
        if ($result) {
            jsonResponse(200, 'success', 'Customer created successfully');
        } else {
            jsonResponse(500, 'error', 'Something went wrong');
        }
    } else {
        jsonResponse(422, 'warning', 'Please fill all fields');
    }
}

// Placing the order
if (isset($_POST['saveorder'])) {
    $phone = validation($_SESSION['cphone']);
    $invoice_no = validation($_SESSION['invoice_no']);
    $payment_mode = validation($_SESSION['payment_mode']);
    
    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone' LIMIT 1");

    if (!$checkCustomer) {
        jsonResponse(500, 'error', 'Something went wrong');
    }

    if (mysqli_num_rows($checkCustomer) > 0) {
        $customerdata = mysqli_fetch_assoc($checkCustomer);
        if (!isset($_SESSION['productItems'])) {
            jsonResponse(404, 'error', 'No item to place order');
        }

        $sessionProduct = $_SESSION['productItems'];

        $totalAmount = 0;
        foreach ($sessionProduct as $amItems) {
            $totalAmount += $amItems['price'] * $amItems['quantity'];
        }

        $data = [
            'customer_id' => $customerdata['id'],
            'tracking_no' => rand(11111, 99999),
            'invoice_no' => $invoice_no,
            'total_amount' => $totalAmount,
            'order_date' => date('Y-m-d'),
            'order_status' => 'booked',
            'payment_mode' => $payment_mode,
        ];

        $result = insert('orders', $data);
        if (!$result) {
            jsonResponse(500, 'error', 'Failed to place order');
        }

        $lastOrderId = mysqli_insert_id($conn);

        foreach ($sessionProduct as $productItem) {
            $productId = $productItem['product_id'];
            $price = $productItem['price'];
            $quantity = $productItem['quantity'];

            $dataOrderItem = [
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity
            ];
            $orderItemQuery = insert('order_items', $dataOrderItem);
            if (!$orderItemQuery) {
                jsonResponse(500, 'error', 'Failed to insert order item');
            }

            // Update product quantity in the products table
            $checkProductQuantityQuery = mysqli_query($conn, "SELECT * FROM products WHERE id ='$productId'");
            $productQtyData = mysqli_fetch_assoc($checkProductQuantityQuery);
            $currentQuantity = $productQtyData['quantity'];
            $totalProductQuantity = $currentQuantity - $quantity;

            $dataupdate = [
                'quantity' => $totalProductQuantity
            ];
            $updateProductQty = updateds('products', $dataupdate, $productId);
            if (!$updateProductQty) {
                jsonResponse(500, 'error', 'Failed to update product quantity');
            }
        }

        // Clear session variables after placing order
        unset($_SESSION['productItemIds']);
        unset($_SESSION['productItems']);
        unset($_SESSION['cphone']);
        unset($_SESSION['payment_mode']);
        unset($_SESSION['invoice_no']);

        jsonResponse(200, 'success', 'Order placed successfully');
    } else {
        jsonResponse(404, 'warning', 'No customer found');
    }
}


?>
