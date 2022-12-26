<?php
    include ('assets/function/connect.php');
    include ('assets/function/update_cart.php');
?>
<script src = "back.js"></script>
<?php
    
    $error = false;
    $time = time();
    $uptime = date("d/m/y ",$time);
    $date = date("dmyhis",$time);
    $MHD = 'HD'.$date;
    $HD = $MHD;
    $totalsave = 0;
    //$discount=0;
    session_start();
    if(!isset($_SESSION["cart"])){
        $_SESSION["cart"] = array();
        
    }
    
    if(!isset($_SESSION["buy-now"])){
        $_SESSION["buy-now"] = array();
    }
    if(!empty($_SESSION["cart"]))
    {
        $psql = "SELECT * FROM SAN_PHAM WHERE ID IN (".implode(",",array_keys($_SESSION["cart"])).")";
        $product = sqlsrv_query($conn,$psql);
    }
    //Login before buy something
    if(!empty($_SESSION["username"])){
        //Nhân viên không phận sự không thể sử dụng giỏ hàng/mua hàng
        if(empty(strchr($_SESSION["username"],'Staff')) && empty(strchr($_SESSION["username"],'staff')) && empty(strchr($_SESSION["username"],'manage')) && empty(strchr($_SESSION["username"],'Manage')) 
        && empty(strchr($_SESSION["username"],'Vice')) && empty(strchr($_SESSION["username"],'vice'))){
            if(isset($_GET['action'])){
            switch($_GET['action']){
                case 'add':
                    if(isset($_POST['add-cart']))
                    {
                        update_cart(true);
                        header('Location: ./cart.php');
                    }
                    
                    elseif(isset($_POST['buy-it-now'])){
                            
                        
                            if(isset($_SESSION["buy-now"])){
                                    foreach($_POST['quantity'] as $id => $quantity){
                                            $_SESSION["buy-now"][$id] = $quantity;
                                        
                                    }

                                    $timidsql = "SELECT * FROM SAN_PHAM WHERE ID IN (".implode(",",array_keys($_POST['quantity'])).")";
                                    $productidsave = sqlsrv_query($conn,$timidsql);
                                   

                                    //TÌm ID sản phẩm
                                    $idvp = sqlsrv_fetch_object($productidsave);
                                    $idcl = $idvp->ID;
                                    

                                    
                                    $ssql = "SELECT * FROM SAN_PHAM WHERE ID IN (".implode(",",array_keys($_POST['quantity'])).")";
                                    $productsave = sqlsrv_query($conn,$ssql);
                                   


                                    if(!empty(strchr($_SESSION["username"],'Employ')) || !empty(strchr($_SESSION["username"],'employ'))){
                                        $searchcsql = "SELECT MaNV FROM NHAN_VIEN WHERE TenDangNhapTK = '".$_SESSION['username']."'";
                                        $searchcustomer = sqlsrv_query($conn,$searchcsql);
                                        $showcus = sqlsrv_fetch_object($searchcustomer);
                                        $nametmp = $showcus->MaNV;
                                        $cbsql = "INSERT INTO HOA_DON (MaHÐ, NgayLap, MaNV, MaPTTT, TongHoaDon, MaKH, TinhTrangTT, TinhTrangDH) 
                                            VALUES ('$MHD','$uptime', '$nametmp','COD','',NULL, N'Chưa thanh toán',N'Đang chờ xác nhận')";  
                                        
                                    } else{
                                        $searchcsql = "SELECT MaKH FROM KHACH_HANG WHERE TenDangNhapTK = '".$_SESSION['username']."'";
                                        $searchcustomer = sqlsrv_query($conn,$searchcsql);
                                        $showcus = sqlsrv_fetch_object($searchcustomer);
                                        $nametmp = $showcus->MaKH;
                                        $cbsql = "INSERT INTO HOA_DON (MaHÐ, NgayLap, MaNV, MaPTTT, TongHoaDon, MaKH, TinhTrangTT, TinhTrangDH) 
                                            VALUES ('$MHD','$uptime', NULL,'COD','','$nametmp', N'Chưa thanh toán',N'Đang chờ xác nhận')";
                                            
                                    }
                                    
                                
                          //Create Bill
                          //var_dump($nametmp);exit;
                                $createbill = sqlsrv_query($conn,$cbsql);
                                //var_dump($createbill);         
                                
                                
                          //Bill Detail
                                while($row_tmp = sqlsrv_fetch_array($productsave, SQLSRV_FETCH_ASSOC)){
                                    
                                    $totalsave += $row_tmp['Gia'] * $_POST['quantity'][$row_tmp["ID"]];
                                        //var_dump([$row_tmp['ID']]);
                                        $search = "SELECT MaSP FROM SAN_PHAM WHERE ID LIKE '".$row_tmp['ID']."'";
                                        $activesearch = sqlsrv_query($conn,$search);
                                        $row_tmp2 = sqlsrv_fetch_array($activesearch, SQLSRV_FETCH_ASSOC);
                                        $icsql = "INSERT INTO CT_HD (MaHÐ, MaSP, SoLuong, TongGia, MaPTTT, NgayMua) 
                                                VALUES ('$MHD','".$row_tmp2['MaSP']."','".$_SESSION["buy-now"][$row_tmp['ID']]."','$totalsave','COD',N'".$uptime."')";
                                        $insertcart = sqlsrv_query($conn,$icsql);
                                         //var_dump($insertcart);
                                }
                                //var_dump($totalsave);
                                    //var_dump($count);
                                
                                    $ttb = "UPDATE HOA_DON 
                                    SET TongHoaDon= $totalsave WHERE MaHÐ= '$HD'";
                                    $createttb = sqlsrv_query($conn,$ttb);
                               // var_dump($createttb);exit;
                                    unset($_SESSION["buy-now"]);
                                    if(!empty(strchr($_SESSION["username"],'Employ')) || !empty(strchr($_SESSION["username"],'employ'))){
                                        header("Location: /admin page/invoice-admin.php?billid=$HD");
    
                                    }else{
                                        header("Location: ./payment.php?id=$HD");
                                    } 
                                }
                            
    
                        }
          
                        break;
                case 'delete':
                   
                    if(isset($_GET['id'])){
                        unset($_SESSION["cart"][$_GET['id']]);
                        header('Location: ./cart.php');
                    }
                    break;
                case 'normal':
                    if(isset($_POST['up-cart'])){
                        //var_dump($_POST);exit;
                       update_cart();
                       header('Location: ./cart.php');
                    }
                    if(isset($_POST['voucherup'])){
                        if(!isset($_SESSION['voucher-used']))
                        {
                            $_SESSION['voucher-used'] = array();
                        }    
                        if(isset($_SESSION['voucher-used'])){
                            $vouch = $_POST['vouchertxt'];
                            if(!empty($vouch)){
                                $username = $_SESSION['username'];
                                $sqlkhused = "SELECT MaKH FROM KHACH_HANG WHERE TenDangNhapTK = '$username'";
                                $connkhused = sqlsrv_query($conn,$sqlkhused);
                                $showmakh = sqlsrv_fetch_object($connkhused);
                                $tmpmakh = $showmakh->MaKH;
                                //var_dump($tmpmakh);
                                $sqlvoucher = "SELECT Voucher FROM HOA_DON WHERE MaKH = '$tmpmakh' AND Voucher LIKE '$vouch' ";
                                $connvoucher = sqlsrv_query($conn,$sqlvoucher);
                                $showvoucher = sqlsrv_fetch_object($connvoucher);
                                    //var_dump($showvoucher->Voucher);
                                    if(empty($showvoucher->Voucher)){
                                            $_SESSION['voucher-used'] = $vouch;
                                    
                                    }else{
                                            $error= '*Lưu ý: Voucher đã được sử dụng!';
                                        //unset($_SESSION['voucher-used']);exit;
                                    }          
                                
                            }else{
                                $error= '*Lưu ý: Bạn phải thêm voucher!';
                            }
                            
                        }
                        
                    }
                    
                    if(isset($_POST['purschase'])){
                            if(empty($_POST['quantity'])) //If not product in cart
                            {
                                $error= '*Lưu ý: Bạn chưa mua đơn hàng nào!';
                            }
                            else{
                                
                            } 
                            if($error == false && !empty($_POST['quantity']))
                            {

                                

                                // Thanh toán
                                $ssql = "SELECT * FROM SAN_PHAM WHERE ID IN (".implode(",",array_keys($_POST['quantity'])).")";
                                $productsave = sqlsrv_query($conn,$ssql);
                                

                                    //Thanh toán
                                    if(!empty(strchr($_SESSION["username"],'Employ')) || !empty(strchr($_SESSION["username"],'employ'))){
                                        $searchcsql = "SELECT MaNV FROM NHAN_VIEN WHERE TenDangNhapTK = '".$_SESSION['username']."'";
                                        $searchcustomer = sqlsrv_query($conn,$searchcsql);
                                        $showcus = sqlsrv_fetch_object($searchcustomer);
                                        $nametmp = $showcus->MaNV;
                                        $cbsql = "INSERT INTO HOA_DON (MaHÐ, NgayLap, MaNV, MaPTTT, TongHoaDon, MaKH, TinhTrangTT, TinhTrangDH) 
                                            VALUES ('$MHD','$uptime', '$nametmp','COD','',NULL, N'Chưa thanh toán',N'Đang chờ xác nhận')"; 
                                        
                                    } else{
                                        $searchcsql = "SELECT MaKH FROM KHACH_HANG WHERE TenDangNhapTK = '".$_SESSION['username']."'";
                                        $searchcustomer = sqlsrv_query($conn,$searchcsql);
                                        $showcus = sqlsrv_fetch_object($searchcustomer);
                                        $nametmp = $showcus->MaKH;
                                        $cbsql = "INSERT INTO HOA_DON (MaHÐ, NgayLap, MaNV, MaPTTT, TongHoaDon, MaKH,  TinhTrangTT, TinhTrangDH) 
                                            VALUES ('$MHD','$uptime', NULL,'COD','','$nametmp', N'Chưa thanh toán',N'Đang chờ xác nhận')";
                                            
                                    }
                                    
                                
                          //Create Bill
                                
                                $createbill = sqlsrv_query($conn,$cbsql);
                                //var_dump($createbill);exit;
                                
                          //Bill Detail
                                while($row_tmp = sqlsrv_fetch_array($productsave, SQLSRV_FETCH_ASSOC)){

                                    $idcl = $row_tmp['ID'];
                                    
                                    //Lượt mua hàng
                                    if(!isset($_SESSION['luottruycapmh'.$row_tmp['ID']]))
                                    {
                                        $_SESSION['luottruycapmh'.$row_tmp['ID']] = 0;
                                    }
                                    if(isset($_SESSION['luottruycapmh'.$row_tmp['ID']]))
                                    {
                                        $_SESSION['luottruycapmh'.$row_tmp['ID']] +=1*$_POST['quantity'][$row_tmp["ID"]];
                                    }
                                    $sltc = $_SESSION['luottruycapmh'.$row_tmp['ID']];
                                    $upsltcsql = "UPDATE SAN_PHAM SET SLTC = $sltc where ID = $idcl";
                                    $connup = sqlsrv_query($conn,$upsltcsql);
                                    
                                    $totalsavecart = $row_tmp['Gia'] * $_POST['quantity'][$row_tmp["ID"]];
                                    $totalsave+=$totalsavecart;
                                        //var_dump([$row_tmp['ID']]);
                                        $search = "SELECT MaSP FROM SAN_PHAM WHERE ID LIKE '".$row_tmp['ID']."'";
                                        $activesearch = sqlsrv_query($conn,$search);
                                        $row_tmp2 = sqlsrv_fetch_array($activesearch, SQLSRV_FETCH_ASSOC);
                                        $icsql = "INSERT INTO CT_HD (MaHÐ, MaSP, SoLuong, TongGia, MaPTTT, NgayMua) 
                                                VALUES ('$MHD','".$row_tmp2['MaSP']."','".$_SESSION['cart'][$row_tmp['ID']]."','$totalsavecart','COD',N'".$uptime."')";
                                        $insertcart = sqlsrv_query($conn,$icsql);
                                         //var_dump($insertcart);
                                    
                                }
                                
                                //var_dump($totalsave);
                                    //var_dump($count);
                                    
                                // Nếu voucher sử dụng
                                if(isset($_SESSION['voucher-used'])){
                                    $vouchersaved = $_SESSION['voucher-used'];
                                    if($_SESSION['voucher-used'] == 'VZ06' ){ //Nếu thay bằng sql thì sẽ so sánh $SESSION với MaVoucher được lấy ra
                                        $totalsave= $totalsave - (10 * $totalsave)/100; //Số tiền 10 sẽ thay thế bằng Discount của sql
                                        $upvouchsql = "UPDATE HOA_DON 
                                                    SET Voucher = '$vouchersaved' WHERE MaHÐ= '$HD'";
                                        $upvc = sqlsrv_query($conn,$upvouchsql);
                                        unset($_SESSION['voucher-used']);
                                    }
                                }
                                
                                
                                
                                $ttb = "UPDATE HOA_DON 
                                        SET TongHoaDon= $totalsave WHERE MaHÐ= '$HD'";
                                $createttb = sqlsrv_query($conn,$ttb);
                                unset($_SESSION["cart"]);
                                //unset($_SESSION["Voucher"]);
                                header("Location: ./cart.php");
    
                            }
                        }
                    
    
                    
                    break;
    
                    
                }
            } 
            
   
       
        } else{
        header("Location: ./index.php");
        unset($_SESSION['cart']);
    }
    }else{
       
                    header("Location: ./login.html");
    }

?>
                        
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/cart-style.css">
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.2.1-web/fontawesome-free-6.2.1-web/css/all.css">
    <title>Document</title>
</head>
<body>
    <header>
        <section id = "header">
            <a href = "#"><img src="/assets/img/logo.png" class = "logo" alt=""></a>
            <form method="POST" action="search.php?action=Search" onsubmit="return submitSearch(this);" enctype="application/x-www-form-urlencoded">
            <div class="Card">
                <div class="CardInner">
                <div class="container">
                    <div class="Icon">
                        <button class = "btn-search"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#657789" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></button>
                    </div>
                    <div class="InputContainer">
                        <input class="input-search" name ="word" placeholder="Tìm kiếm sản phẩm..."/>
                    </div> 
                </div>
               </div>
            </div>
            </form>
            
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
                    <li><a class = "active" href="cart.php"><i class = "fa fa-shopping-bag"></i></a></li>
                    <li><a href="user.php"><i class = "fa fa-user"></i></a>
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
    
    
    <section id = "cart" class = "section-p1"> 
        <h2>GIỎ HÀNG</h2>
        
        <form id = "cart-form" action = 'cart.php?action=normal' method="POST" >
        <?php if(!empty($error)){  ?>  
                <div id= "error-msg"><?=$error?>.<button class="normal" onclick="goBack()">Quay lại</button></div> 
        <?php
            } else { 
        ?>
        
        <table width="100%">
            <thead>
                <tr>
                    <td>Xóa khỏi giỏ hàng</td>
                    <td>Hình ảnh</td>
                    <td>Tên sản phẩm</td>
                    <td>Giá</td>
                    <td>Số lượng</td>
                    <td>Tổng tiền</td>
                </tr>
            </thead>
            
            <tbody>
                    <?php 
                        $total=0;
                        if(!empty($_SESSION["cart"])){
                            while($row = sqlsrv_fetch_array($product, SQLSRV_FETCH_ASSOC)){  
                                echo '<tr>
                                <td><a href="cart.php?action=delete&id='.$row['ID'].'"><i class = "far fa-times-circle"></i></a></td>
                                <td><img src = "'.$row['HinhAnhSP'].'" alt=""></td>
                                <td><a href ="product.php?id='.$row['ID'].'">'.$row['TenSP'].'</a></td>
                                <td>'.number_format($row['Gia'],0,".",".").'đ</td>
                                <td><input type="number" value = "'.$_SESSION['cart'][$row['ID']].'" name="quantity['.$row['ID'].']"></td>                             
                                <td>'.number_format($row['Gia'] * $_SESSION['cart'][$row['ID']],0,".",".").'đ</td>
                            </tr>';
                            $total+= $row['Gia'] * $_SESSION['cart'][$row['ID']];
                            }
                        }
                        else{
                            echo "";
                        }
                        
                    ?>
                
            </tbody>
            
        </table>
        <button class = "normal" name = 'up-cart'>Cập nhật giỏ hàng</button>
    </section>

    <section id = "cart-add" class = "section-p1">
        <div id = "coupon">
            <h3>Sử dụng mã giảm giá</h3>
            <div>
                <input name='vouchertxt' class="coupon-input" type = "text" placeholder = "Sử dụng mã giảm giá ở đây">
                <button class = "normal" name="voucherup">Sử dụng</button>
            </div>
        </div>

        <div id = "subtotal">
            <h3>Tổng tiền</h3>
            <table>
                <tr>
                    <td>Số tiền</td>
                    <?php
                        echo '<td><strong>'.number_format($total,0,".",".").'đ</strong></td>'
                    ?>
                </tr>
                <tr>
                    <td>Phí vận chuyển</td>
                    <td>free</td>
                </tr>
                <tr>
                    <td><strong>Tổng số tiền</strong></td>
                    <?php
                        if(isset($_SESSION['voucher-used'])){
                            if($_SESSION['voucher-used'] == 'VZ06' ){
                                $tongtien = $total- (10 * $total)/100;
                        
                            }else{
                                $tongtien=$total;
                            }

                        }else{
                            $tongtien=$total;
                        }

                       
                        echo '<td><strong>'.number_format($tongtien,0,".",".").'đ</strong></td>';
                        
                    ?>
                </tr>
            </table>
            <button class = "normal" name="purschase">Thanh toán</button>
            <?php }?></form>
        </div>
    </section>

    <footer class = "footer">
        <div class = "footer-container">
            <div class = "row">
                <div class = "footer-col">
                    <h4>Cửa hàng</h4>
                    <ul>
                        <li><a href="about.php">Giới thiệu</a></li>
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
