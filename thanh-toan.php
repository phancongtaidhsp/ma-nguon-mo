<?php  

	if(!isset($_SESSION['name_id']))
	{
		echo "<script>alert('Bạn phải đăng nhập mới thực hiện được chức năng này');location.href='dang-nhap.php'</script>";
	}
	if(!isset($_SESSION['cart']))
	{
		echo "<script>alert('Bạn chưa có giỏ hàng vui lòng mua sản phẩm');location.href='index.php'</script>";
	}

	require_once __DIR__. "/autoload/autoload.php";
	$user = $db->fetchID("users",intval($_SESSION['name_id']));

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$data =
		[
			'amount'   => $_SESSION['total'],
			'users_id' => $_SESSION['name_id'],
			'note'     => postInput("note")
		];
		$idtran = $db->insert("transaction",$data);
		if($idtran > 0)
		{
			foreach($_SESSION['cart'] as $value)
			{
				$data2 =
				[
					'transaction_id' =>$idtran,
					'product_id'     =>$value['product_id'],
					'qty'            =>$value['qty'],
					'price'          =>$value['price']
				];

				$id_insert = $db->insert("orders",$data2);
			}
			$num = $db->delete("shoppingcart",$_SESSION['shoppingcart_id']);
			unset($_SESSION['cart']);
			$_SESSION['success'] = "Lưu thông tin dơn hàng thành công ! Chúng tôi sẽ liên hệ với bạn sớm nhất !";
			header("location: thong-bao.php");
		}
	}
?>
<?php  require_once __DIR__. "/layouts/header.php"; ?>
                    <div class="col-md-9 ">
                        
                        <section class="box-main1">
                            <h3 class="title-main"><a href=""> Thanh toán đơn hàng </a> </h3>
                            <form action="" method="POST" class="form-horizontal formcustome" role="form" style="margin-top: 20px">
                            	<div class="form-group">
                            		<label class="col-md-2 col-md-offset-1">Tên thành viên </label>
                            		<div class="col-md-8">
                            			<input type="text" readonly="" name="name" placeholder=" Nguyễn Thị Ái Hậu" class="form-control" value="<?php echo $user['name'] ?>">
                            			
                            		</div>
                            	</div>

                            	<div class="form-group">
                            		<label class="col-md-2 col-md-offset-1">Email</label>
                            		<div class="col-md-8">
                            			<input type="email" readonly="" name="email" placeholder="aihau@gmail.com" class="form-control" value="<?php echo $user['email'] ?>">
                            			
                            		</div>
                            	</div>

                            	<div class="form-group">
                            		<label class="col-md-2 col-md-offset-1">Số điện thoại </label>
                            		<div class="col-md-8">
                            			<input type="number" readonly="" name="phone" placeholder="0384300208" class="form-control" value="<?php echo $user['phone'] ?>">
                            			
                            		</div>
                            	</div>

                            	<div class="form-group">
                            		<label class="col-md-2 col-md-offset-1">Địa chỉ</label>
                            		<div class="col-md-8">
                            			<input type="text" readonly="" name="address" placeholder="An Phú-Tp Pleiku-Gia Lai" class="form-control" value="<?php echo $user['address'] ?>">
                            			
                            		</div>
                            	</div>
                            	<div class="form-group">
                            		<label class="col-md-2 col-md-offset-1">Số tiền</label>
                            		<div class="col-md-8">
                            			<input type="text" readonly="" name="price" placeholder="" class="form-control" value="<?php echo formatPrice($_SESSION['total']) ?>">
                            			
                            		</div>
                            	</div>
                            	<div class="form-group">
                            		<label class="col-md-2 col-md-offset-1">Ghi chú</label>
                            		<div class="col-md-8">
                            			<input type="text" name="note" placeholder="" class="form-control" value="">
                            			
                            		</div>
                            	</div>

                            	<button type="submit" class="btn btn-success col-md-2 col-md-offset-5" style="margin-bottom: 20px;">Xác nhận</button>
	
                            </form>
                        </section>
                    </div>
<?php  require_once __DIR__. "/layouts/footer.php"; ?>
