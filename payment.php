<?php
    include ('assets/function/connect.php');
    
?>
<script src = "back.js"></script>
<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        //var_dump($_GET['id']);
    }
?>
<?php
    if(isset($_GET['error'])){
        $error = $_GET['error'];
        //var_dump($_GET['id']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/payment-style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="/assets/fonts/fontawesome-free-6.2.1-web/fontawesome-free-6.2.1-web/css/all.css">
    <title>Document</title>
</head>
<body>
    <div class="detail">
        <div class="content">
            <div class="container rounded bg-white">
                <div class="row d-flex justify-content-center pb-5">
                    <div class="col-sm-5 col-md-5 ml-1">
                        <a href="index.html"><img src="/assets/img/logo.png" alt=""></a>
                        <div class="py-4 d-flex flex-row">
                            <h5><span class="fa fa-check-square-o"></span><b>Shop name</b> | </h5><span class="pl-2">thanh toán</span>
                        </div>
                       
                        <?php if(!empty($error)){  ?>  
                            <div id= "error-msg"><?=$error?>.</div> 
                        </form>
                        <?php
                         } else { 
                        ?>
                        <?php
                            
                                $sqlbill = "SELECT * FROM HOA_DON WHERE MaHÐ = '$id'";
                                $connbill = sqlsrv_query($conn,$sqlbill);
                                while($showbill = sqlsrv_fetch_array($connbill,SQLSRV_FETCH_ASSOC)){
                                    $pttt = $showbill['MaPTTT'];
                                    $makh = $showbill['MaKH'];
                                    $cthd = "SELECT * FROM CT_HD WHERE MaHÐ= '$id'";
                                    $conncthd = sqlsrv_query($conn,$cthd);
                                    while($showcthd = sqlsrv_fetch_array($conncthd,SQLSRV_FETCH_ASSOC)){
                                        $masp = $showcthd['MaSP'];
                                        $nameSPsql = "SELECT * FROM SAN_PHAM WHERE MaSP = '$masp' ";
                                        $connnameSP = sqlsrv_query($conn,$nameSPsql);
                                        while($shownamesp = sqlsrv_fetch_array($connnameSP,SQLSRV_FETCH_ASSOC)){ 
                        ?>
                        <h4 class="green"><?=number_format($shownamesp['Gia'],0,".",".")?>đ</h4>
                        <div class="infomation">
                            
                        <?php
                               
                            $khach = "SELECT * FROM KHACH_HANG WHERE MaKH = '$makh'";
                            $connkhach = sqlsrv_query($conn,$khach);
                            while($showkhach = sqlsrv_fetch_array($connkhach,SQLSRV_FETCH_ASSOC)){
                        ?>
                            <label for="">Họ tên</label>
                            <input class = "inputText" type="text" placeholder="<?=$showkhach['HoTenKH']?>">
                            <label for="">Email</label>
                            <input class = "inputText" type="text" placeholder="<?=$showkhach['Email']?>">
                            <label for="">Số điện thoại</label>
                            <input class = "inputText" type="text" placeholder="<?=$showkhach['SDT']?>">
                            <label for="">Địa chỉ</label>
                            <input class = "inputText" type="text" placeholder="<?=$showkhach['DiaChi']?>">
                           
                        </div>
                        <hr>
                        <div class="pt-2">
                            <form class="pb-3">
                                <?php
                                    $ptttsql = "SELECT * FROM PHUONG_THUC_THANH_TOAN WHERE MaPTTT = '$pttt'";
                                    $ptttconn = sqlsrv_query($conn,$ptttsql);
                                    while($showpttt = sqlsrv_fetch_array($ptttconn,SQLSRV_FETCH_ASSOC)){
                                ?>
                                <div class="d-flex flex-row align-content-center">
                                    <div class="pt-2 pr-2"><input type="radio" name="radio1" id="r1" checked></div>
                                    <div class="rounded d-flex w-100 px-2">
                                        <div class="pt-2"><p><i class="fas fa-shipping-fast"></i><?=$showpttt['TenPTTT']?></p></div>
                                        <div class="ml-auto pt-2"><?=$showpttt['MaPTTT']?></div>
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>
                            </form>
                            
                            <div>
                            <form id = 'buy-now-payment' method="POST" action="payment-sys.php?id=<?=$id?>" >
                                <button name= "buy-now-purchase" class="btn btn-primary btn-block">Thanh toán</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-4 offset-md-1 mobile ">
                        <div class="py-4 d-flex justify-content-end">
                            <h6><button name= "back-cart" class="btn btn-primary btn-block">Hủy đơn hàng</button></h6>
                        </div>
                        <div class="bg-light rounded d-flex flex-column payment-details">
                            <div class="product-detail">
                                <div class="p-2 ml-3"><h4>Thông tin mua hàng</h4></div>
                                <div class="p-2 d-flex">
                                    <div class="col-8">Tên hàng</div>
                                    <div class="ml-auto"><?=$shownamesp['TenSP']?></div>
                                </div>
                                <div class="border-top px-4 mx-3">
                                </div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8">Giá sản phẩm</div>
                                    <div class="ml-auto"><?=number_format($shownamesp['Gia'],0,".",".")?>đ</div>
                                </div>
                                <div class="p-2 d-flex">
                                    <div class="col-8">Mã khuyến mãi</div>
                                    <div class="ml-auto"><?=$showbill['Voucher']?></div>
                                </div>
                                <div class="border-top px-4 mx-3"></div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8">Số lượng</div>
                                    <div class="ml-auto"><b><?=$showcthd['SoLuong']?></b></div>
                                </div>
                                <div class="p-2 d-flex">
                                    <div class="col-8">Số tiền</div>
                                    <div class="ml-auto"><b><?=number_format($showbill['TongHoaDon'],0,".",".")?>đ</b></div>
                                </div>
                                <div class="p-2 d-flex">
                                    <div class="col-8">Phí vận chuyển</div>
                                    <div class="ml-auto"><b>Miễn phí</b></div>
                                </div>
                                <div class="border-top px-4 mx-3"></div>
                                <div class="p-2 d-flex pt-3">
                                    <div class="col-8"><b>Tổng tiền</b></div>
                                    <div class="ml-auto"><b class="green"><?=number_format($showbill['TongHoaDon'],0,".",".")?>đ</b></div>
                                </div>
                                
                                <label for="">Voucher</label>
                                <input class = "inputText" name = "vouchertxt" type="text"></input> 
                                <button name= "used-voucher-buy-now" class="btn btn-primary btn-block">Sử dụng</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
                                        }
                                    }
                                }
                            }
                        }
    ?>
</body>
</html>