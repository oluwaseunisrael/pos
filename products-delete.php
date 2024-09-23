<?php
require '../config/function.php';

$paraResultId = checkParamTd('id');
if (is_numeric($paraResultId)) {
    $productId = validation($paraResultId);
    $product = getById('products', $productId);

    if ($product['status'] == 200) {
        $response = delete('products', $productId);
        if ($response) {
            redirect('product.php', 'Products deleted successfully');
        } else {
            redirect('product.php', 'Something went wrong');
        }
    } else {
        redirect('product.php', $product['message']);
    }
} else {
    redirect('product.php', 'Something went wrong');
}
?>
