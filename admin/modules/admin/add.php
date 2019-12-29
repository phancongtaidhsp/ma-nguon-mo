<?php  
    $open = "admin";
    require_once __DIR__. "/../../autoload/autoload.php"; 
    $data =
        [
            "name"        => postInput('name'),
            "email"       => postInput("email"),
            "phone"       => postInput("phone"),
            "password"    => MD5(postInput("password")),
            "address"     => postInput("address"),
            "level"       => postInput("level"),
        ];
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
        
            $error = [];

            if(postInput('name') == '')
            {
                $error['name'] = "Mời bạn nhập đầy đủ họ và tên";
            }
            if(postInput('email') == '')
            {
                $error['email'] = "Mời bạn nhập email";
            }
            else
            {
                $is_check = $db->fetchOne("admin"," email = '".$data['email']."' ");
                if($is_check != NULL)
                {
                    $error['email'] = " Email đã tồn tại ";
                }
            }
            if(postInput('phone') == '')
            {
                $error['phone'] = "Mời bạn nhập số điện thoại";
            }
            if(postInput('address') == '')
            {
                $error['address'] = 'Mời bạn nhập địa chỉ';
            }
            if(postInput('password') == '')
            {
                $error['password'] = "Mời bạn nhập mật khẩu ";
            }
            if($data['password'] != MD5(postInput("re_password")))
            {
                $error['password'] = "Mật khẩu không khớp ";
            }
        
        if(empty($error))
        {
            
            $id_insert = $db->insert("admin",$data);
            if($id_insert)
            {
                $_SESSION['success'] = "Thêm mới thành công ";
                redirectAdmin("admin");
            }
            else
            {
                $_SESSION['error'] = "Thêm mới thất bại ";
            }
        
        }
    }
?>


<?php  require_once __DIR__. "/../../layouts/header.php"; ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Thêm mới Admin
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <a href="index.html">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <i ></i>
                <a href="">Admin</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fa fa-file"></i>
                Thêm mới
            </li>
        </ol>
        <div class="clearfix"></div>
         <?php  require_once __DIR__. "/../../../partials/notification.php"; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Họ và tên</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmail3" placeholder="Tên admin" name="name"
            value="<?php echo $data['name']?>">
            <?php if (isset($error['name'])):?>
                <p class="text-danger"> <?php echo $error['name']?></p>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-8">
            <input type="email" class="form-control" id="inputEmail3" placeholder="aihau@gmail.com" name="email"
            value="<?php echo $data['email']?>">
            <?php if (isset($error['email'])):?>
                <p class="text-danger"> <?php echo $error['email']?></p>
            <?php endif ?>
        </div> 
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Phone</label>
        <div class="col-sm-8">
            <input type="number" class="form-control" id="inputEmail3" placeholder="0" name="phone"
            value="<?php echo $data['phone']?>">
            <?php if (isset($error['phone'])):?>
                <p class="text-danger"> <?php echo $error['phone']?></p>
            <?php endif ?>
        </div> 
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="inputEmail3" placeholder="************" name="password">
            <?php if (isset($error['password'])):?>
                <p class="text-danger"> <?php echo $error['password']?></p>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 col-form-label">ConfigPassword</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="inputEmail3" placeholder="************" name="re_password" required="">
            <?php if (isset($error['re_password'])):?>
                <p class="text-danger"> <?php echo $error['re_password']?></p>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Address</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmail3" placeholder="Tp Pleiku-GiaLai" name="address"
            value="<?php echo $data['address']?>">
            <?php if (isset($error['address'])):?>
                <p class="text-danger"> <?php echo $error['address']?></p>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Level</label>
        <div class="col-sm-8">
            <select type="text" class="form-control" name="level">
                <option value="1" <?php echo isset($data['level']) && $data['level'] == 1 ? "selected = 'selected'" : ''?>>CTV</option>
                <option value="2" <?php echo isset($data['level']) && $data['level'] == 2 ? "selected = 'selected'" : ''?>>Admin</option>
            </select>
            <?php if (isset($error['level'])):?>
                <p class="text-danger"> <?php echo $error['level']?></p>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group ">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success">Lưu</button>
        </div>
    </div>
</form>
    </div>
</div>
<?php  require_once __DIR__. "/../../layouts/footer.php"; ?>
