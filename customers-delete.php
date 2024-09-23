<?php
require '../config/function.php';

$paraResultId = checkParamTd('id');
if (is_numeric($paraResultId)) {
    $customerId = validation($paraResultId);
    $customer = getById('customers', $customerId);

    if ($customer['status'] == 200) {
        $response = delete('customers', $customerId);
        if ($response) {
            redirect('customer.php', 'customer deleted successfully');
        } else {
            redirect('customer.php', 'Something went wrong');
        }
    } else {
        redirect('customer.php', $customer['message']);
    }
} else {
    redirect('customer.php', 'Something went wrong');
}
?>
