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
    <link rel="stylesheet" href="/admin page/assets/css/customers-admin.css">
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
                    <a class="active" href="customers-admin.php">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <span class="title">Khách hàng</span>
                    </a>
                </li>
                <li>
                    <a href="/admin page/message-admin.php">
                        <span class="icon"><ion-icon name="chatbubble-ellipses-outline"></ion-icon></span>
                        <span class="title">Tin nhắn</span>
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

            <!-- product category -->
            <div class="detail">
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Danh sách khách hàng</h2>
                    </div>
            
        <?php
           if($_SERVER["REQUEST_METHOD"] == "POST"){
                 $word = $_POST['word'];
                    //Get thông tin cần tìm kiếm
            if(!empty($word)){
                $query = "SELECT A.* FROM  KHACH_HANG A WHERE a.MaKH Like '%$word%' or a.HoTenKH like'%$word%' or a.TenDangNhapTK like'%$word%' or a.SDT like'%$word%' or a.Email like'%$word%'";
                $findCustomer = sqlsrv_query($conn, $query);
                while ($row = sqlsrv_fetch_array($findCustomer, SQLSRV_FETCH_ASSOC)) {
                ?>
                <form method="post" action="customsearch.php" >
                <div class="search">
                    <label>
                        <input type ="search" name ="word" class = "search-field" placeholder = "<?=$word?>">
                            <button name = 'searchcus'><ion-icon  name="search-outline"></button>
                    </label>
                </div>
            </form>
        <table>
            <thead>
                <tr>
                    <td>Tên tài khoản</td>
                    <td>Họ tên khách hàng</td>
                    <td>Email</td>
                    <td>Số điện thoại</td>
                     </tr>
            </thead>    
                            <tbody>
                            <tr>
                                <td><?=$row['MaKH']?></td>
                                <td><?=$row['HoTenKH']?></td>
                                <td><?=$row['Email']?></td>
                                <td><?=$row['SDT']?></td>
                                <td><a href="customers-admin2.html">Chi tiết</a></td>
                            </tr>
                            </tbody>
            </table>              
        <?php
                    }   
                }
            }      
        ?>
                     
                </div>
            </div>
        </div>
    </div>
    
    <script src = "/admin page/assets/js/admin-script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>