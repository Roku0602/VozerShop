<?php
    include ('../assets/function/connect.php');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/admin page/assets/css/employee-admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="storefront"></ion-icon></span>
                        <span class="title">Shop name</span>
                    </a>
                </li>
                <li>
                    <a href="/admin page/admin-index.php">
                        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>
                <li>
                    <a href="/admin page/customers-admin.php?limit=4&page-num=1">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <span class="title">Khách hàng</span>
                    </a>
                </li>
                
                <?php
                
                if(!empty($_SESSION["username"])){
                    if(!empty(strchr($_SESSION["username"],'Staff')) || !empty(strchr($_SESSION["username"],'staff')) || !empty(strchr($_SESSION["username"],'manage')) 
                    || !empty(strchr($_SESSION["username"],'Manage')) 
                    ){
                
                ?>
                <li>
                    <a class="active" href="/admin page/employee-admin.php?limit=4&page-num=1">
                        <span class="icon"><ion-icon name="man-outline"></ion-icon></span>
                        <span class="title">Nhân viên</span>
                    </a>
                </li>
                <?php
                    }
                }
                ?>
                <li>
                    <a href="/admin page/category-admin.php">
                        <span class="icon"><ion-icon name="reorder-four-outline"></ion-icon></span>
                        <span class="title">Danh mục sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a href="/admin page/product-admin.php?limit=6&page-num=1">
                        <span class="icon"><i class='bx bx-box'></i></span>
                        <span class="title">Sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a href="../logout.php">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="title">Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- main -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <!-- <div class="search">
                    <label>
                        <input type="text" placeholder = "Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div> -->
            </div>
            <div class="detail">
                <div class="recentEmployees">
                    <div class="cardHeader">
                        <h2>Danh sách nhân viên</h2>
                        <a href="/admin page/employee-add-admin.php" class = "btn">Thêm nhân viên</a>
                    </div>
                    <form method="post" action="searchNhanVien.php" >
                        <div class="search">
                            <label>
                                <input type ="search" name ="word" class = "search-field" placeholder = "Tìm kiếm sản phẩm...">
                                <button name = 'searchcus'><ion-icon  name="search-outline"></button>
                            </label>
                        </div>
                    </form>
                    <table>
                        <thead>
                            <tr>
                                <td>Mã số nhân viên</td>
                                <td>Tên nhân viên</td>
                                <td>Chức vụ</td>
                                <td>Số lương</td>
                            </tr>
                        </thead>
<?php
    //Get thông tin cần tìm kiếm
    if(isset($_POST['word'])){
        $word = $_POST['word'];
        //var_dump($word);
    }
    if (!empty($word)) {
        $query = "SELECT A.* FROM NHAN_VIEN A WHERE a.HoTen like'%$word%' or a.TenDangNhapTK like'%$word%' or a.MaNV like'%$word%' or a.SDT like'%$word%' and a.MaCV <> 'GD'";
        $find = sqlsrv_query($conn, $query);
        while ($row = sqlsrv_fetch_array($find, SQLSRV_FETCH_ASSOC)) {
     ?>
                <tbody>
                            <tr>
                                <td><?=$row['MaNV']?></td>
                                <td><?=$row['HoTen']?></td>
                                <?php
                                    $chucvu = $row['MaCV'];
                                    $idlog = $_SESSION['username'];
                                    $CVsql = "SELECT * FROM CHUC_VU WHERE MaCV = '$chucvu'";
                                    $connCV = sqlsrv_query($conn,$CVsql);
                                    while($showCV = sqlsrv_fetch_array($connCV,SQLSRV_FETCH_ASSOC)){
                                ?>
                                    <form id = "delete-form" action = 'employee-admin.php?limit=4&page-num=<?=$pagenum?>&action=deletenv' method="POST" >
                                    <td><?=$showCV['ChucVu']?></td>
                                    <?php
                                        if(!empty(strchr($showCV['ChucVu'],'Nhân viên')))
                                        {
                                    ?>
                                    <td>5.000.000đ</td>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        if(!empty(strchr($showCV['ChucVu'],'Quản lý')))
                                        {
                                    ?>
                                    <td>7.000.000đ</td>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        if(!empty(strchr($showCV['ChucVu'],'Phó Giám Đốc')))
                                        {
                                    ?>
                                    <td>15.000.000đ</td>
                                    <?php
                                        } 
                                    ?>
                                   
                                    <td><a href="employee-add-admin.php?membersid=<?=$row['MaNV']?>">Chi tiết</a></td>
                                    
                                        
                                        <td><a href = "employee-admin.php?limit=4&page-num=1&action=deletenv&id=<?=$row['MaNV']?>" class = "delete">Xóa nhân viên</a></td>
                                    </form>
                                    
                            </tr>
                        </tbody>
                        <?php
                                }
                                ?>

     <?php

        }   
        
    }else{
            echo "Chưa nhập từ khóa";
    }
        
?>
  </table>
                    
                </div>
            </div>
        </div>
    </div>
    
    <script src = "/admin page/assets/js/admin-script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>