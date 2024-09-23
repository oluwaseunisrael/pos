<?php
require '../config/function.php';

$paraResultId = checkParamTd('id');
if (is_numeric($paraResultId)) {
    $categoryId = validation($paraResultId);
    $category = getById('categories', $categoryId);

    if ($category['status'] == 200) {
        $response = delete('categories', $categoryId);
        if ($response) {
            redirect('categories.php', 'category deleted successfully');
        } else {
            redirect('categories.php', 'Something went wrong');
        }
    } else {
        redirect('categories.php', $category['message']);
    }
} else {
    redirect('categories.php', 'Something went wrong');
}
?>
