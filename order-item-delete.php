<?php


require  '../config/function.php';
$paraResult = checkParamTd('index');
if (is_numeric($paraResult)) {
	$indexValue = validation($paraResult);
	if (isset($_SESSION['productItems']) && isset($_SESSION['productItemIds'])) {
		// code...
		unset($_SESSION['productItems'][$indexValue]);
		unset($_SESSION['productItemIds'][$indexValue]);
		redirect('create-order.php', 'item Removed');
	}
	else{
		redirect('create-order.php', 'There is no item');
	}
}else{
		redirect('create-order.php', 'param not working');
	}

?>















?>