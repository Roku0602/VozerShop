<?php
    include ('assets/function/connect.php');
?>
<?php

    //$idlist = $_GET['id'];
   // $sql = " SELECT Ma_Loai,TenLoai FROM Loai_SP WHERE Ma_Loai LIKE '$idlist' ";
    //$stmt = sqlsrv_query($conn,$sql);
    //while($obj = sqlsrv_fetch_object($stmt)){
        //var_dump($obj);
    //}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.2.1-web/fontawesome-free-6.2.1-web/css/all.css">
    <title>shop</title>
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
                    <li><a href="about.html">GIỚI THIỆU</a></li>
                    
                    <li><a class = "active" href="#">DANH MỤC SẢN PHẨM</a>
                        <ul class = "sub-menu">
                            <li><a href = "productlist.php?id=BP">Bàn phím máy tính</a></li>
                            <li><a href = "productlist.php?id=ME">Chuột máy tính</a></li>
                            <li><a href = "">Lót chuột</a></li>
                            <li><a href = "">Bàn máy tính</a></li>
                            <li><a href = "">Ghế ngồi</a></li>
                            <li><a href = "">Màn hình máy tính</a></li>
                            <li><a href = "">Tay nâng màn hình</a></li>
                            <li><a href = "">Giá đỡ laptop</a></li>
                            <li><a href = "">Webcam</a></li>
                        </ul>
                    </li>
                    <li><a href="insurance.html">CHÍNH SÁCH BẢO HIỂM</a></li>
                    <li><a href="cart.php"><i class = "fa fa-shopping-bag"></i></a></li>
                    <li><a href=""><i class = "fa fa-user"></i></a></li>
                </ul>
            </div>
        </section>
    </header>


    <section class = "product-list">
        <?php
            $idlist = $_GET['id'];
            $sql = " SELECT Ma_Loai,TenLoai FROM Loai_SP WHERE Ma_Loai LIKE '$idlist' ";
            $stmt = sqlsrv_query($conn,$sql);
            while($obj = sqlsrv_fetch_object($stmt)){
                echo '<h2>'.$obj->TenLoai.'</h2>';
            }
        ?>
        
        <div class="product-container">
            
                <!-- <a href="#"><i class="fa fa-shopping-cart cart"></i></a> -->
            <?php 
                $idlist = $_GET['id'];
                $tsql = "SELECT MaSP,TenSP, Gia, Ma_Loai, HinhAnhSP,ID FROM SAN_PHAM WHERE Ma_loai = '$idlist' ";
                $stmt = sqlsrv_query($conn, $tsql);
           
                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
                {
                    $tsql_loai = "SELECT TenLoai, Ma_Loai FROM Loai_SP WHERE Ma_Loai = '$idlist'";
                    $stmt_loai = sqlsrv_query($conn,$tsql_loai);
                    while( $row_loai = sqlsrv_fetch_array( $stmt_loai, SQLSRV_FETCH_ASSOC))
                    {
                        if($row['Ma_Loai']==$row_loai['Ma_Loai']  )
                        {
                            echo '<div class="product">
                                <img src="/assets/img/'.$row['HinhAnhSP'].'" alt="">
                                <div class="design">
                                    <span>'.$row_loai['TenLoai'].'</span>
                                    <a href ="product.php?id='.$row['ID'].'"><h5>'.$row['TenSP'].'</h5></a>
                                    <h4>'.number_format($row['Gia'],0,".",".").'đ</h4>
                                </div>
                                </div>';
                
                        }
                    }
                sqlsrv_free_stmt( $stmt_loai);
                }
                sqlsrv_free_stmt( $stmt);
        ?>
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
                        <li><a href="index.php">Trang chủ</a></li>
                        <li><a href="cart.php">Giỏ hàng</a></li>
                    </ul>
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
    <script src="script.js"></script>
</body>
</html>