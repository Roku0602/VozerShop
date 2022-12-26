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
    <link rel="stylesheet" href="/admin page/assets/css/category-admin.css">
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
                        <span class="title">VZ06</span>
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
                    || !empty(strchr($_SESSION["username"],'Manage') || !empty(strchr($_SESSION["username"],'Vice')) || !empty(strchr($_SESSION["username"],'vice')) ) 
                    ){

                ?>
                <li>
                    <a href="/admin page/employee-admin.php?limit=4&page-num=1">
                        <span class="icon"><ion-icon name="man-outline"></ion-icon></span>
                        <span class="title">Nhân viên</span>
                    </a>
                </li>
                <?php
                    }
                }
                ?>
                <li>
                    <a class="active" href="#">
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
            
            <!-- category -->
            <div class="detail">
                <div class="category">
                    <div class="cardHeader">
                        <h2>Danh mục sản phẩm</h2>
                        <a href="/admin page/category-add-admin.php" class = "btn">Thêm danh mục</a>
                    </div>
                    <!-- <div class="search">
                        <label>
                            <input type="text" placeholder = "Tìm kiếm khách hàng...">
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </div> -->
                    <table>
                        <?php
                            $alltypesql = "SELECT * FROM Loai_SP ";
                            $connalltype = sqlsrv_query($conn,$alltypesql);
                            while($showalltype = sqlsrv_fetch_array($connalltype,SQLSRV_FETCH_ASSOC)){
                        ?>
                        <tbody>
                                <tr>
                                    <form action="category-delete.php?type=<?=$showalltype['Ma_Loai']?>" method="POST">
                                    <td><?=$showalltype['TenLoai']?></td>
                                    <td><a href="#">Chi tiết</a></td>
                                    <td><button name= 'delete' class = "delete">Xóa danh mục</button></td>
                                    </form>
                                </tr>
                        </tbody>
                        <?php
                            }
                        ?>
                    </table>
                </div>

                <div class="brand">
                    <div class="cardHeader">
                        <h2>Thương hiệu</h2>
                        <a href="/admin page/brand-add-admin.php" class = "btn">Thêm thương hiệu</a>
                    </div>
                    <!-- <div class="search">
                        <label>
                            <input type="text" placeholder = "Tìm kiếm khách hàng...">
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </div> -->
                    <table>
                        <tbody>
                            <tr>
                               
                                    <?php
                                        $allbrandsql = "SELECT * FROM THUONG_HIEU ";
                                        $connallbrand= sqlsrv_query($conn,$allbrandsql);
                                        while($showallbrand = sqlsrv_fetch_array($connallbrand,SQLSRV_FETCH_ASSOC)){
                                    ?>
                                     <tr>
                                    <form action="brand-delete.php?id=<?=$showallbrand['Ma_TH']?>" method="POST">
                                    <td><?=$showallbrand['TenTH']?></td>
                                    <td><a href="#">Chi tiết</a></td>
                                    <td><button name='btn-delete-brand' class = "delete">Xóa hãng</button></td>
                                    </form>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                
                                
                            </tr>
                        </tbody>
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