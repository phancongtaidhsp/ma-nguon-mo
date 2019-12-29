<?php  

	require_once __DIR__. "/autoload/autoload.php";
	if(!isset($_SESSION['name_id']))
	{
		echo "<script>alert('Bạn phải đăng nhập mới thực hiện được chức năng này');location.href='dang-nhap.php'</script>";
	}
	$user_id = $_SESSION['name_id'];

	$shoppingcart=$db->fetchOne("shoppingcart"," user_id = $user_id ");
	if(!$shoppingcart){
		$data =
        [
            "user_id"   => $user_id,
            "status"    => 0,
		];
		$shoppingcart_id = $db->insert("shoppingcart",$data);
	}
	else{
		$shoppingcart_id = $shoppingcart['id'];
	}

	$product_id = intval(getInput('id'));

	$cartItems=$db->fetchOne("cartitems"," shoppingcart_id = $shoppingcart_id AND product_id=$product_id ");

	if(!$cartItems['id'])
    {
		$data =
        [
            "shoppingcart_id"   => $shoppingcart_id,
            "product_id"        => $product_id,
            "qty" 				=> 1,
		];
		$db->insert("cartitems",$data);
    }
    else
    {
		$data =
        [
            "shoppingcart_id"   => $shoppingcart_id,
            "product_id"        => $product_id,
            "qty" 				=> $cartItems['qty']+1,
        ];
		$update = $db->update("cartitems",$data,array("id" => $cartItems['id'] ));
    }

    echo "<script>alert('Thêm sản phẩm thành công');location.href='gio-hang.php'</script>";
?>