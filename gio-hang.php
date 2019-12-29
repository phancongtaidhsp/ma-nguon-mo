<?php  

	require_once __DIR__. "/autoload/autoload.php";
	$sum = 0;
	
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
	$_SESSION['shoppingcart_id'] =$shoppingcart_id;
	$sql = " SELECT c.id as cartitems_id,p.id as product_id,p.name,p.thunbar,c.qty,p.price-(p.price*p.sale/100) as price,p.sale,p.number FROM shoppingcart AS s JOIN cartitems AS c ON s.id=c.shoppingcart_id join product p ON c.product_id=p.id WHERE s.id=$shoppingcart_id ";
	$cart = $db->fetchsql( $sql );
	$_SESSION['cart']= $cart ? $cart : NULL;
?>
<?php  require_once __DIR__. "/layouts/header.php"; ?>
                    <div class="col-md-9">
                        
                        <section class="box-main1">

                            <h3 class="title-main"><a href=""> Giỏ hàng của bạn </a> </h3>
                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success">
                                    <strong style="color: #3c763d">Success !</strong><?php echo $_SESSION['success'] ;unset($_SESSION['success'])?>
                                </div>
                            <?php endif ?>
                            <table class="table table-hover" id='shoppingcart_info'>
                            	<thead>
                            		<tr>
                            			<th>STT</th>
                            			<th>Tên sản phẩm</th>
                            			<th>Hình ảnh</th>
                            			<th>Số lượng</th>
                            			<th>Giá</th>
                            			<th>Tổng tiền</th>
                            			<th>Thao tác</th>
                            		</tr>
                            	</thead>
                            	<tbody >
                            		<?php $stt = 1; foreach ($cart as $value): ?>
                            			<tr>
                            				<td><?php echo $stt ?></td>
                            				<td><?php echo $value['name'] ?></td>
                            				<td>
                            					<img src="<?php echo uploads() ?>product/<?php echo $value['thunbar'] ?>" width="80pc" height="80pc">
                            						
                            				</td>
                            				<td>
                            					<input class="updatecart" data-key=<?php echo $value['cartitems_id']?> type="number" name="qty" value="<?php echo $value['qty'] ?>" class="form-control qty" id="qty" min="1" max="<?php echo $value['number']+$value['qty'] ?>">
                            				</td>
                            				<td><?php echo formatPrice($value['price'])?></td>
                            				<td><?php echo formatPrice($value['price'] * $value['qty'])?></td>
                            				<td>
                            					<a href="remove.php?key=<?php echo $value['cartitems_id']?>" class="btn btn-xs btn-danger" ><i class="fa fa-remove"></i> Remove</a>
                            				</td>
                            			</tr>
                            			<?php $sum += $value['price'] * $value['qty']; $_SESSION['tongtien'] = $sum ; ?>
                            		<?php $stt ++; endforeach ?>
									<tfoot>
										<tr>
											<td><b style="font-size: 16px;"> Tổng cộng </b></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><b style="font-size: 16px;"><?php echo formatPrice($sum) ?></b></td>
											<td></td>
										</tr>
									</tfoot>
                            </table>
							<?php if(isset($_SESSION['cart'])): ?>
								<div class="col-md-5 pull-right">
									<li class="list-group-item">
										<h3> Thông tin đơn hàng </h3>
									</li>
									<li class="list-group-item">
										<span class="badge"><?php echo sale($sum) ?> % </span>
										Giảm giá
									</li>
									<li class="list-group-item">
										<span class="badge"><?php $_SESSION['total'] = $sum - ($sum*sale($sum)/100) ; echo formatPrice($_SESSION['total']) ?></span>
										Tổng tiền thanh toán
									</li>
									<li class="list-group-item">
										<a href="index.php" class="btn btn-success ">Tiếp tục mua hàng</a>
										<a href="thanh-toan.php" class="btn btn-success ">Thanh toán</a>
									</li>
								</div>
                            <?php endif ?>
                        </section>
                    </div>
<?php  require_once __DIR__. "/layouts/footer.php"; ?>
