<?php 
if (isset($_POST['place'])) {
	$phone= validation($_POST['cphone']);
	if (is_numeric($phone) && $phone ='') {
		redirect("create-order.php', 'number must be in  numeric");
	}

}
?>
