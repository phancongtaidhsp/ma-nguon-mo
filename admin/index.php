
<?php  require_once __DIR__. "/autoload/autoload.php"; 

    $category = $db->fetchAll("category");
?>
<?php  require_once __DIR__. "/layouts/header.php"; ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Xin chào bạn đến với trang quản trị của admin
            <small>Subheading</small>
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <a href="index.html">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-fw fa-folder"></i>
                Blank Page
            </li>
        </ol>
    </div>
</div>
<?php  require_once __DIR__. "/layouts/footer.php"; ?>
