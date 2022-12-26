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
    <link rel="stylesheet" href="/admin page/assets/css/employee-add-admin.css">
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
                    <a class = "active" href="/admin page/employee-admin.php?limit=4&page-num=1">
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

            <!-- add product -->
            <div class="detail">
                <div class="admin-content">
                            <?php
                                if(isset($_GET['membersid'])){
                                    $manv = $_GET['membersid'];
                                    $sqlmem = "SELECT * FROM NHAN_VIEN WHERE MaNV = '$manv'";
                                    $connmem = sqlsrv_query($conn, $sqlmem);
                                    while($showmem = sqlsrv_fetch_array($connmem,SQLSRV_FETCH_ASSOC)){
                                        $cv= $showmem['MaCV'];
                                        $chucvupre = "SELECT MaCV,ChucVu FROM CHUC_VU WHERE MaCV <> 'GD' and MaCV = '$cv'";
                                        $conncvpre = sqlsrv_query($conn,$chucvupre);
                                        $cvpreshow = sqlsrv_fetch_object($conncvpre);
                            ?>
                    <div class="cardHeader">
                        <h2>Cập nhật nhân viên</h2>
                    </div>
                    <div class="product_add">
                        <form action="insertnv.php" method="post">
                       
                            <label for="">Nhập mã số nhân viên <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name = "MaNV" value="<?=$showmem['MaNV']?>" placeholder="<?=$showmem['MaNV']?>" readonly>
                            <label for="">Nhập nhân viên <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name = "NameNV" placeholder="<?=$showmem['HoTen']?>">
                            <label for="">Nhập số điện thoại <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name = "inphonenum" placeholder="<?=$showmem['SDT']?>">
                            <label for="">Nhập địa chỉ <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name = "inaddress" placeholder="<?=$showmem['DiaChi']?>">
                            <label for="">Nhập Email <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name = "inMail" placeholder="<?=$showmem['Email']?>">
                            <label for="">Chọn chức vụ <span style="color:red;">*</span></label>
                            <select id="cbbCV" name="DSCV" >
                            <option value="<?=$cvpreshow->MaCV?>"><?=$cvpreshow->ChucVu?></option>    
                            
                            </select>
                            <button href= "" type = "submit" name = "btn-update-nv">Cập nhật</button>
                            
                            <?php
                                }
                            }else{
                            ?>
                            <?php
                                if(!empty($_GET['error'])){ 
                                    $error = $_GET['error']?>
                                    <div id= "error-msg"><?=$error?>.<br>
                                    <button class="" name = 'btn-back'>Quay lại</button></div> 
                            <?php
                                } else { 
                            ?>
                            <div class="cardHeader">
                        <h2>Thêm nhân viên</h2>
                            </div>
                        <div class="product_add">
                        <form action="insertnv.php" method="post">
                       
                            <label for="">Nhập mã số nhân viên <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name = "MaNV" >
                            <label for="">Nhập nhân viên <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name = "NameNV" >
                            <label for="">Nhập số điện thoại <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name = "inphonenum">
                            <label for="">Nhập địa chỉ <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name = "inaddress" >
                            <label for="">Nhập Email <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name = "inMail" >
                            <label for="">Chọn chức vụ <span style="color:red;">*</span></label>
                           
                            <select id="cbbCV" name="DSCV" >
                            <?php
                            if(!empty($_SESSION["username"])){
                                if(!empty(strchr($_SESSION["username"],'Staff')) || !empty(strchr($_SESSION["username"],'staff')))
                                {
                                    $chucvushow = "SELECT MaCV,ChucVu FROM CHUC_VU WHERE MaCV <> 'GD'";
                                    $connchv = sqlsrv_query($conn,$chucvushow);
                                    while($chucvu = sqlsrv_fetch_array($connchv,SQLSRV_FETCH_ASSOC)){
                            ?>
                                <option value="<?=$chucvu['MaCV']?>"><?=$chucvu['ChucVu']?></option>
                            <?php
                                    }
                                }if(!empty(strchr($_SESSION["username"],'Manage')) || !empty(strchr($_SESSION["username"],'manage')) 
                                || !empty(strchr($_SESSION["username"],'Vice')) || !empty(strchr($_SESSION["username"],'vice'))){
                                    $chucvushow = "SELECT MaCV,ChucVu FROM CHUC_VU WHERE MaCV <> 'GD' and MaCV <> 'PGD' and MaCV <> 'MA' ";
                                    $connchv = sqlsrv_query($conn,$chucvushow);
                                    while($chucvu = sqlsrv_fetch_array($connchv,SQLSRV_FETCH_ASSOC)){
                            ?>
                                <option value="<?=$chucvu['MaCV']?>"><?=$chucvu['ChucVu']?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                            </select>
                            <button href= "" type = "submit" name = "btn-add-nv">Thêm nhân viên</button>
                            <?php
                                }
                            ?>
                            <?php
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src = "/admin page/assets/js/admin-script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>