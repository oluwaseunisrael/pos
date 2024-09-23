<?php
require '../config/function.php';

$paraResultId = checkParamTd('id');
if (is_numeric($paraResultId)) {
    $adminsId = validation($paraResultId);
    $admins = getById('admins', $adminsId);

    if ($admins['status'] == 200) {
        $adminDeleteRes = delete('admins', $adminsId);
        if ($adminDeleteRes) {
            redirect('admin.php', 'Admin deleted successfully');
        } else {
            redirect('admin.php', 'Something went wrong');
        }
    } else {
        redirect('admin.php', $admins['message']);
    }
} else {
    redirect('admin.php', 'Something went wrong');
}
?>
