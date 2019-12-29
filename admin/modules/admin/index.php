
<?php
        $open = "admin";
        require_once __DIR__. "/../../autoload/autoload.php"; 
        if (isset($_GET['page']))
        {
            $p = $_GET['page'];
        }
        else
        {
            $p = 1;
        }
        $sql = "SELECT admin.* FROM admin ORDER BY ID DESC";
        $admin = $db->fetchJone('admin',$sql,$p,2,true);

        if(isset($admin['page']))
        {
            $sotrang = $admin['page'];
            unset($admin['page']);
        }
?>

<?php  require_once __DIR__. "/../../layouts/header.php"; ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Danh sách Admin
                <a href="add.php" class="btn btn-success">Thêm mới</a>
            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <a href="index.html">Dashboard </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fa fa-file"></i>
                        Admin
                </li>
            </ol>
            <div class="clearfix"></div>
            <?php  require_once __DIR__. "/../../../partials/notification.php"; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="dataTable_length">
                                        <label>
                                        Show 
                                        <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                        entries
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div id="dataTable_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable"></label></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="STT: activate to sort column descending" style="width: 58px;">STT</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 63px;">Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 63px;">Email</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending" style="width: 50px;">Phone</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 68px;">Action</th>
                                    
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php $stt = 1; foreach ($admin as $item) :?>
                                    <tr>
                                        <td><?php echo $stt ?></td>
                                        <td><?php echo $item['name'] ?></td>
                                        <td><?php echo $item['email'] ?></td>
                                        <td><?php echo $item['phone'] ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-info" href="edit.php? id=<?php echo $item['id'] ?>">
                                            <i class="fa fa-edit"></i>Sửa</a>
                                            <a class="btn btn-xs btn-danger" href="delete.php? id=<?php echo $item['id'] ?>">
                                            <i class="fa fa-times"></i>Xóa</a>
                                        </td>                                    
                                    </tr>
                                        <?php $stt++ ; endforeach?>
                                </tbody>
                            </table>
                            <div >
                                <nav aria-label="Page navigation" class="clearfix">
                                    <ul class="pagination justify-content-end">
                                        <li>
                                            <a class="page-link" href="" aria-label="Previous" >
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php for( $i = 1; $i <= $sotrang ; $i++ ) : ?>
                                            <?php
                                            if(isset($_GET['page']))
                                            {
                                                $p = $_GET['page'];
                                            }
                                            else
                                            {
                                                $p = 1;
                                            }
                                            ?>
                                            <li class="<?php echo ($i == $p) ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?php echo $i ;?>"><?php echo $i; ?></a>
                                            </li>
                                            <?php endfor;?>

                                            <li>
                                                <a class="page-link" href="" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php  require_once __DIR__. "/../../layouts/footer.php"; ?>
