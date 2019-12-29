<?php
	require_once __DIR__. "/autoload/autoload.php";
	$key = intval(getInput('key'));
	
	$num = $db->delete("cartitems",$key);
	if($number>0) $_SESSION['success'] = "Xóa sản phẩm trong giỏ hàng thành công !";
	header("location:gio-hang.php");

?>