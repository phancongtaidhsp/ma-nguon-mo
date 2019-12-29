<?php
    require_once __DIR__. "/autoload/autoload.php";
    $user = $db->fetchID("users",intval($_SESSION['name_id']));

    if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$data =
		[
			'name'   => postInput("name"),
			'phone' => postInput("phone"),
			'address'     => postInput("address")
		];
        $id_update = $db->update("users",$data,array("id" => intval($_SESSION['name_id']) ));
        if($id_update > 0)
            {
                $_SESSION['success'] = "Cập nhật thành công ";
            }
            else
            {
                $_SESSION['error'] = "Cập nhật thất bại ";
            }
	}
?>



<?php  require_once __DIR__. "/layouts/header.php"; ?>

<div class="col-md-9 ">
    
    <section class="box-main1">
        <h3 class="title-main"><a href=""> Thông tin khách hàng</a> </h3>
        <?php if (isset($_SESSION['error'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['error'] ;unset($_SESSION['error'])?>
            </div>
        <?php endif ?>
        <?php if (isset($_SESSION['success'])):?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success'] ;unset($_SESSION['success'])?>
            </div>
        <?php endif ?>
        <form action="" method="POST" class="form-horizontal formcustome" role="form" style="margin-top: 20px">
            <div class="form-group">
                <label class="col-md-2 col-md-offset-1">Tên thành viên </label>
                <div class="col-md-8">
                    <input type="text" name="name" class="form-control" value="<?php echo $user['name'] ?>">
                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 col-md-offset-1">Số điện thoại </label>
                <div class="col-md-8">
                    <input type="text" name="phone" class="form-control" value="<?php echo $user['phone'] ?>">
                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 col-md-offset-1">Địa chỉ</label>
                <div class="col-md-8">
                    <input type="text" name="address" class="form-control" value="<?php echo $user['address'] ?>">
                    
                </div>
            </div>

            <button type="submit" class="btn btn-success col-md-2 col-md-offset-5" style="margin-bottom: 20px;">Cập nhập thông tin</button>

        </form>
    </section>
</div>

<?php  require_once __DIR__. "/layouts/footer.php"; ?>