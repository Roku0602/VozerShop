<?php
    include ('assets/function/connect.php');
?>
<?php
    session_start();
    if(!empty($_SESSION["username"])){
        if(!empty(strchr($_SESSION["username"],'Staff')) || !empty(strchr($_SESSION["username"],'staff')) || !empty(strchr($_SESSION["username"],'manage')) 
            || !empty(strchr($_SESSION["username"],'Manage')) || !empty(strchr($_SESSION["username"],'Vice')) || !empty(strchr($_SESSION["username"],'vice'))
            || !empty(strchr($_SESSION["username"],'Employ')) || !empty(strchr($_SESSION["username"],'employ'))
        ){
            header("Location: ./admin page/admin-index.php");
        }else{
            $loginname = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.2.1-web/fontawesome-free-6.2.1-web/css/all.css">
    <title>Document</title>
</head>
<body>
    <header>
        <section id = "header">
            <a href = "#"><img src="/assets/img/logo.png" class = "logo" alt=""></a>
            <div class = "header-search-container">
                <input type = "search" name = "search" class = "search-field" placeholder = "Tìm kiếm sản phẩm..."> 
                <a href=""><i class = "fa fa-search search"></i></a>
            </div>
            
            <div>
                <ul id = "navbar">
                    <li><a href="index.php">TRANG CHỦ</a></li>
                    <li><a href="about.php">GIỚI THIỆU</a></li>
                    <li><a href="#">DANH MỤC SẢN PHẨM</a>
                        <ul class = "sub-menu">
                        <?php
                                $DMsql = "SELECT * FROM Loai_SP";
                                $connDM = sqlsrv_query($conn,$DMsql);
                                while($rowDM = sqlsrv_fetch_array($connDM, SQLSRV_FETCH_ASSOC)){ 
                                    $danhmuc = $rowDM['Ma_Loai'];
                            ?>
                            <li><a href = "category.php?id=<?=$rowDM['Ma_Loai']?>&limit=8&page-num=1"><?=$rowDM['TenLoai']?></a></li>
                            <?php
                                    $sqlthsp = "SELECT C.TenTH,C.Ma_TH
                                    from SAN_PHAM A ,Loai_SP B,THUONG_HIEU C
                                     WHERE A.Ma_Loai=B.Ma_Loai AND A.Ma_TH=C.Ma_TH AND B.Ma_Loai='$danhmuc'
                                    GROUP BY C.TenTH,C.Ma_TH";
                                    $connth = sqlsrv_query($conn,$sqlthsp);
                                    while($showth= sqlsrv_fetch_array($connth,SQLSRV_FETCH_ASSOC)){
                                    if(!empty($showth['TenTH'])){
                                        $math = $showth['TenTH'];
                                ?>
                                <ul class = "brand">
                                    <li><a href="category.php?id=<?=$rowDM['Ma_Loai']?>&limit=8&pagenum=1&TH=<?=$showth['Ma_TH']?>" ><?=$math?></a></li>
                                </ul>
                                <?php
                                    }else{
                                ?>
                                <ul class = "brand">
                                    <li></li>
                                </ul>
                            <?php
                                    }   
                                    }
                                }
                            ?>
                        </ul>
                    </li>
                    <li><a href="insurance.php">CHÍNH SÁCH BẢO HIỂM</a></li>
                    
                    <li><a href="cart.php"><i class = "fa fa-shopping-bag"></i></a></li>
                    <li><a  class = "active" href="user.php"><i class = "fa fa-user"></i></a>
                    <ul class = "sub-menu-user">
                            <?php
                                if(empty($_SESSION["username"])){
                            ?>
                            <li><a href="login.php">Login</a></li>
                            <?php
                                }else {

                            ?>
                            <li><a href="logout.php">Logout</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
    </header>

    <section id = "user-profile" class = "section-p1">
        <div class = "profile">
            <h2>THÔNG TIN TÀI KHOẢN</h2>
            <form action="#" class="signup-form autocomplete = "off"">
                <?php
                    $profilenamesql = "SELECT * FROM KHACH_HANG WHERE TenDangNhapTK LIKE '$loginname' "; 
                    $profilename = sqlsrv_query($conn,$profilenamesql);
                    $showname = sqlsrv_fetch_array($profilename,SQLSRV_FETCH_ASSOC);
                ?>
                <label for="user" id = "user" class="profile-label">Tên tài khoản</label>
                <?php
                    echo '<input type="text" class="profile-input" placeholder = "'.$loginname.'">';
                ?>
                <label for="name" id = "name" class="profile-label">Họ tên</label>
                <?php
                    echo '<input type="text" class="profile-input" placeholder = "'.$showname['HoTenKH'].'">';
                ?>
                <label for="email" id = "email" class="profile-label">Email</label>
                <?php
                    echo '<input type="text" class="profile-input" placeholder = "'.$showname['Email'].'">';
                ?>
                <label for="phone" id = "phone" class="profile-label">Số điện thoại</label>
                <?php
                    echo '<input type="text" class="profile-input" placeholder = "'.$showname['SDT'].'">';
                ?>
                <label for="address" id = "address" class="profile-label">Địa chỉ</label>
                <?php
                    echo '<input type="text" class="profile-input" placeholder = "'.$showname['DiaChi'].'">';
                ?>
            </form>
        </div>
    </section>

    <footer class = "footer">
        <div class = "footer-container">
            <div class = "row">
                <div class = "footer-col">
                    <h4>Cửa hàng</h4>
                    <ul>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Dịch vụ</a></li>
                        <li><a href="#">Giấy phép</a></li>
                    </ul>
                </div>
                <div class = "footer-col">
                    <h4>Hổ trợ</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Phương thức thanh toán</a></li>
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class = "footer-col">
                    <h4>Online Shopping</h4>
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Giỏ hàng</a></li>
                    </ul>
                </div>
                <div class = "footer-col">
                    <h4>follow us</h4>
                    <div class = "social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
<?php
        }
    }else{
        header("Location: ./login.html");
        }
?>        