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
    <link rel="stylesheet" href="/admin page/assets/css/product-admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="product-add-admin.html">
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
                    <a href="/admin page/category-admin.php">
                        <span class="icon"><ion-icon name="reorder-four-outline"></ion-icon></span>
                        <span class="title">Danh mục sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a class="active" href="product-admin.php?limit=6&page-num=1">
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

            <!-- product category -->
            <div class="detail">
                <div class="recentProducts">
                    <div class="cardHeader">
                        <h2>Danh sách sản phẩm</h2>
                        <a href="/admin page/product-add-admin.php" class = "btn">Thêm sản phẩm</a>
                    </div>
                    <form method="post" action="searchproduct.php" >
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
                                <td>Hình ảnh</td>
                                <td>Tên sản phẩm</td>
                                <td>Giá</td>
                            </tr>
                        </thead>
<?php
    //Get thông tin cần tìm kiếm
    if(isset($_POST['word'])){
        $word = $_POST['word'];
    }
    if(!empty($word)){
        $query = "SELECT A.* FROM SAN_PHAM A,Loai_SP B,THUONG_HIEU C WHERE A.Ma_Loai=B.Ma_Loai And A.Ma_TH = C.Ma_TH and (A.TenSP like'%$word%' or B.TenLoai like'%$word%' or C.TenTH like'%$word%')";
        $findProduct = sqlsrv_query($conn, $query);
        while ($row = sqlsrv_fetch_array($findProduct, SQLSRV_FETCH_ASSOC)){ 
 ?>
                        <tbody>
                            <tr>
                                <td><img src=<?=$row['HinhAnhSP']?> alt=""></td>
                                <td><?=$row['TenSP']?></td>
                                <td><?=number_format($row['Gia'],0,".",".")?>đ</td>
                                <td><a href="/admin page/product-add-admin.php?product=<?=$row['MaSP']?>">Chi tiết</a></td>
                                <form id = "delete-form" action = 'product-admin.php?limit=6&page-num=1' method="POST" >
                                    <td><a href = "product-admin.php?action=deletesp&id=<?=$row['MaSP']?>&limit=6&page-num=1" class = "delete">Xóa sản phẩm</a></td>
                                </form>
                            </tr>
                        </tbody>
 <?php
        }
    }else{
        echo "Chưa nhập sản phẩm!";
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