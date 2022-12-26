<?php
    include ('../assets/function/connect.php');
    session_start();
?>
<?php
    if(isset($_GET['billid'])){
        $idbill = $_GET['billid'];
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/admin page/assets/css/invoice-admin.css">
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
            <div>
            <form method="POST" action="invoice-confirm.php">
                <?php
                    $tinhtrang = "SELECT * FROM HOA_DON WHERE MaHÐ = '$idbill'";
                    $conntthd = sqlsrv_query($conn,$tinhtrang);
                    while($showtt = sqlsrv_fetch_array($conntthd,SQLSRV_FETCH_ASSOC)){
                        if(empty(strchr($showtt['TinhTrangDH'],'Đang chờ xác nhận'))){
                ?>
                            <div><a href="#" class = "btn" id = "download">In hóa đơn</a></div>
                            <?php
                                if(!empty(strchr($showtt['TinhTrangTT'],'Chưa thanh toán'))){
                            ?>
                           <br> <div><a name = 'Accepted' href="invoice-confirm.php?id=<?=$idbill?>&Done=true" class = "btn" >Xác nhận thanh toán</a></div>
                            
                           <?php
                                }else{
                           ?>
                                <br> <div></div>
                            <?php
                                }
                           ?>
                
                <?php
                        }else{
                ?>
                       
                        <div><a name = 'confirm' href="invoice-confirm.php?id=<?=$idbill?>&confirm=true" class = "btn" >Xác nhận đơn hàng</a></div>
                <?php
                    }
                }
                ?>
            </form>    
            </div>
            <div class="detail" id="invoice">
                <div class="invoice">
                    <div class="container">
                        <div class="row pad-top-botm ">
                            <div class="col-lg-6 col-md-6 col-sm-6 ">
                                <div class="cardHeader">
                                    <img src="/assets/img/logo.png" style="padding-bottom: 20px;">
                                    
                                </div>
                                
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <strong>Shop name</strong>
                                <br>
                                <b>Địa chỉ :</b> VQ4P+249, Phường Tân Phú, Quận 9, TP.Hồ Chí Minh
                            </div>
                        </div>
                        <div class="row text-center contact-info">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <hr>
                                <span>
                                    <strong>E-mail : </strong> nh6pcgear@gmail.com </span><br>
                                <span>
                                    <strong>SĐT : </strong> +0562403407 </span>
                                <hr>
                            </div>
                        </div>
                        <div class="row pad-top-botm client-info">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                
                                <?php
                                    $sqlbill = "SELECT * FROM HOA_DON WHERE MaHÐ= '$idbill'";
                                    $connbill = sqlsrv_query($conn,$sqlbill);
                                    while($showbill = sqlsrv_fetch_array($connbill,SQLSRV_FETCH_ASSOC)){ 
                                        $makhhd = $showbill['MaKH'];
                                        $manvhd = $showbill['MaNV'];
                                        if(!empty($makhhd)){
                                        $customerinfosql = "SELECT * FROM KHACH_HANG Where MaKH = '$makhhd' ";
                                        $conncustomerinfo = sqlsrv_query($conn,$customerinfosql);
                                        while($showinfo = sqlsrv_fetch_array($conncustomerinfo,SQLSRV_FETCH_ASSOC)){
                    
                                ?>
                                <br>
                                <h4>
                                <strong>Thông tin khách hàng</strong>
                                </h4>
                                <b>Họ tên :</b> <?=$showinfo['HoTenKH']?> <br>
                                <b>Địa chỉ :</b> <?=$showinfo['DiaChi']?> <br>
                                <b>SĐT :</b> <?=$showinfo['SDT']?> <br>
                                <b>E-mail :</b> <?=$showinfo['Email']?> <br>
                                <?php
                                        }
                                    }elseif(!empty($manvhd)){
                                        $customerinfosql = "SELECT * FROM NHAN_VIEN Where MaNV = '$manvhd' ";
                                        $conncustomerinfo = sqlsrv_query($conn,$customerinfosql);
                                        while($showinfo = sqlsrv_fetch_array($conncustomerinfo,SQLSRV_FETCH_ASSOC)){
                                ?>
                                <br>
                                <h4>
                                <strong>Thông tin nhân viên</strong>
                                </h4>
                                <b>Họ tên :</b> <?=$showinfo['HoTen']?> <br>
                                <b>Địa chỉ :</b> <?=$showinfo['DiaChi']?> <br>
                                <b>SĐT :</b> <?=$showinfo['SDT']?> <br>
                                <b>E-mail :</b> <?=$showinfo['Email']?> <br>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <br>
                                <h4>
                                <strong>Thông tin thanh toán </strong>
                                </h4>
                                <b>Tổng tiền : <?=number_format($showbill['TongHoaDon'],0,".",".")?>đ </b>
                                <br>Ngày: <?=$showbill['NgayLap']?> <br>
                                <b>Tình trạng thanh toán: <?=$showbill['TinhTrangTT']?> </b>
                                <br>Phương thức thanh toán: <?=$showbill['MaPTTT']?>
                                <br> Tình trạng đơn hàng: <?=$showbill['TinhTrangDH']?> <?php if(empty(strchr($showbill['MaPTTT'],'COD'))){?><br> Ngày thanh toán: 19/12/2022
                                <?php } ?>

                               
                            </div>
                        </div>

                        <div class="list-product">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td>Tên sản phẩm</td>
                                            
                                            <td>Số lượng</td>
                                            <td>Giá sản phẩm</td>
                                            
                                            <td>Tổng số tiền</td>
                                        </tr>
                                    </thead>
                                    <?php
                                    $cthd = "SELECT * FROM CT_HD WHERE MaHÐ= '$idbill'";
                                    $conncthd = sqlsrv_query($conn,$cthd);
                                    while($showcthd = sqlsrv_fetch_array($conncthd,SQLSRV_FETCH_ASSOC)){
                                        $masp = $showcthd['MaSP'];
                                        $nameSPsql = "SELECT * FROM SAN_PHAM WHERE MaSP = '$masp' ";
                                        $connnameSP = sqlsrv_query($conn,$nameSPsql);
                                        while($shownamesp = sqlsrv_fetch_array($connnameSP,SQLSRV_FETCH_ASSOC)){ 
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?=$shownamesp['TenSP']?></td>
                                        <td><?=$showcthd['SoLuong']?></td>
                                        <td><?=number_format($shownamesp['Gia'],0,".",".")?>đ</td>
                                        
                                        <td><?=number_format($showcthd['TongGia'],0,".",".")?>đ</td>
                                    </tr>
                                </tbody>
                                <?php
                                        }
                                    }
                                ?>
                                    
                                </table>
                                </div>
                                <hr>
                                <div class="ttl-amts">
                                    <?php
                                        $tongtienpre = "SELECT TONGGIATIEN=SUM(TongGia) FROM CT_HD WHERE MaHÐ = '$idbill'";
                                        $conntong = sqlsrv_query($conn,$tongtienpre);
                                        $showtongtien = sqlsrv_fetch_object($conntong);
                                        
                                    ?>
                                    <h5> Tổng tiền : <?=number_format($showtongtien->TONGGIATIEN,0,".",".")?>đ </h5>
                                </div>
                                
                                <hr>
                                <div class="ttl-amts">
                                    <h5> Phí vận chuyển: miễn phí </h5>
                                </div>
                                <hr>
                                <div class="ttl-amts">
                                    <h5> Voucher: <?=$showbill['Voucher']?> </h5>
                                </div>
                                <hr>
                                <div class="ttl-amts">
                                    <h4>
                                    <strong>Tổng hóa đơn: <?=number_format($showbill['TongHoaDon'],0,".",".")?>đ</strong>
                                </h4>
                                <?php
                                    
                                }
                                ?>
                                </div>
                            </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
    
    <script src = "/admin page/assets/js/admin-script.js"></script>
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src = "/admin page/assets/js/invoice-download.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>