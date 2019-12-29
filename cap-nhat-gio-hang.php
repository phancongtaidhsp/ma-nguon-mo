<?php
	require_once __DIR__. "/autoload/autoload.php";
	$key = intval(getInput('key'));
	$qty = intval(getInput('qty'));
	$data = [
		"qty" => $qty,
	];
	$update = $db->update("cartitems",$data,array("id" => $key ));

	echo $update;



?>