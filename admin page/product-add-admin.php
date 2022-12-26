<?php
    include ('../assets/function/connect.php');
    session_start();
?>
<?php
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/admin page/assets/css/product-add-admin.css">
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
                    <a href="/admin page/admin-index.html">
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
                    <a class="active" href="/admin page/product-admin.php?limit=6&page-num=1">
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
                    
                    <div class="product_add">
                        
                            <?php
                                if(isset($_GET['product'])){
                            ?>
                            <div class="cardHeader">
                                <h2>Cập nhật sản phẩm</h2>
                            </div>
                            <?php
                                
                                    $msp = $_GET['product'];
                                    $spinfsql = "SELECT * FROM SAN_PHAM WHERE MaSP = '$msp' ";
                                    $connspinf = sqlsrv_query($conn,$spinfsql);
                                    while($showinfproduct = sqlsrv_fetch_array($connspinf,SQLSRV_FETCH_ASSOC)){ 
                                        $ttsp = $showinfproduct['GioiThieuSP'];
                                        $typepr = $showinfproduct['Ma_Loai'];
                            ?>
                            <form action="add-product.php" method="post" enctype="multipart/form-data">
                            <label for="">Nhập tên sản phẩm <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text"  placeholder = "<?=$showinfproduct['TenSP']?>" name= "nameSP">
                            <label for="">Chọn danh mục <span style="color:red;">*</span></label>
                            <?php
                                 $loaispsql1 = "SELECT * FROM Loai_SP WHERE Ma_Loai = '$typepr'";
                                 $connloai1 = sqlsrv_query($conn,$loaispsql1);
                                 while($showlisttype1 = sqlsrv_fetch_array($connloai1,SQLSRV_FETCH_ASSOC)){
                                    $invalidtype = $showlisttype1['Ma_Loai'];
                            ?>
                            <select name="DMSP" id="">
                                <option value="<?=$showlisttype1['Ma_Loai']?>"><?=$showlisttype1['TenLoai']?></option>
                            <?php
                                $loaispsql = "SELECT * FROM Loai_SP WHERE Ma_Loai <> '$invalidtype'";
                                $connloai = sqlsrv_query($conn,$loaispsql);
                                while($showlisttype = sqlsrv_fetch_array($connloai,SQLSRV_FETCH_ASSOC)){
                                   
                            ?>
                                
                                <option value="<?=$showlisttype['Ma_Loai']?>"><?=$showlisttype['TenLoai']?></option>
                            <?php
                                } 
                            }
                            ?>
                            
                            </select>
                            
                            <label for="">Chọn số lượng mặt hàng <span style="color:red;">*</span></label>
                            <input type = "number" value = "<?=$showinfproduct['SoLuong']?>" name="quantity[<?=$showinfproduct['MaSP']?>]">
                            <label for="">Nhập giá sản phẩm <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text"  placeholder = "<?=$showinfproduct['Gia']?>" name= "Price" >
                            <label for="">Nhập mô tả sản phẩm <span style="color:red;">*</span></label>
                            <textarea name="detail" value = "" id="GioiThieuSP" cols="30" rows="10"  ><?=$showinfproduct['GioiThieuSP']?></textarea>
                            <label for="">Ảnh sản phẩm (ảnh chính) <span style="color:red;">*</span></label>
                            <input class = "inputImg" type="file" name= "img">
                            <label for="">Ảnh sản phẩm (ảnh mô tả 1) <span style="color:red;">*</span></label>
                            <input class = "inputImg" type="file" name= "img1">
                            <label for="">Ảnh sản phẩm (ảnh mô tả 2) <span style="color:red;">*</span></label>
                            <input class = "inputImg" type="file" name= "img2">
                            <label for="">Ảnh sản phẩm (ảnh mô tả 3) <span style="color:red;">*</span></label>
                            <input class = "inputImg" type="file" name= "img3">
                            <label for="">Ảnh sản phẩm (ảnh mô tả 4) <span style="color:red;">*</span></label>
                            <input class = "inputImg" type="file" name= "img4">
                            <!--<label for="">Ảnh sản phẩm (ảnh mô tả) <span style="color:red;">*</span></label>
                            <input class = "inputImg" multiple type="file">-->
                            <button name = "update-product" type = "submit">Cập nhật</button>
                            </form>
                            <?php
            
                                    }
                                
                                }else{
                            ?>
                            
                            <div class="cardHeader">
                            <h2>Thêm sản phẩm</h2>
                            </div>
                            <form action="add-product.php" method="post" enctype="multipart/form-data">
                            <?php
                                if(!empty($_GET['error'])){ 
                                    $error = $_GET['error']?>
                                    <div id= "error-msg"><?=$error?>.<br>
                                    <button class="" name = 'btn-back'>Quay lại</button></div> 
                            <?php
                                } else { 
                            ?>
                            
                            <label for="">Nhập tên sản phẩm <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name= "nameSP">
                            <label for="">Chọn danh mục <span style="color:red;">*</span></label>
                            <select name="DMSP" id="">
                            <?php
                                $loaispsql = "SELECT * FROM Loai_SP";
                                $connloai = sqlsrv_query($conn,$loaispsql);
                                while($showlisttype = sqlsrv_fetch_array($connloai,SQLSRV_FETCH_ASSOC)){
                                   
                            ?>
                                
                                <option value="<?=$showlisttype['Ma_Loai']?>"><?=$showlisttype['TenLoai']?></option>
                            <?php
                                } 
                            ?>
                            </select>
                            <label for="">Chọn số lượng mặt hàng <span style="color:red;">*</span></label>
                            <input type = "number" value = "1" name="quantity">
                            <label for="">Nhập giá sản phẩm <span style="color:red;">*</span></label>
                            <input class = "inputText" type="text" name= "Price">
                            <label for="">Chọn thương hiệu <span style="color:red;">*</span></label>
                            <select name="DMTH" id="">
                            <?php
                                $loaithsql = "SELECT * FROM THUONG_HIEU";
                                $connloaith = sqlsrv_query($conn,$loaithsql);
                                while($showlistth = sqlsrv_fetch_array($connloaith,SQLSRV_FETCH_ASSOC)){
                                   
                            ?>
                                
                                <option value="<?=$showlistth['Ma_TH']?>"><?=$showlistth['TenTH']?></option>
                            <?php
                                } 
                            ?>
                            </select>
                            <label for="">Nhập mô tả sản phẩm <span style="color:red;">*</span></label>
                            <textarea name="detail" id="" cols="30" rows="10"></textarea>
                            <label for="">Ảnh sản phẩm (ảnh chính) <span style="color:red;">*</span></label>
                            <input class = "inputImg" type="file" name= "img">
                            <label for="">Ảnh sản phẩm (ảnh mô tả 1) <span style="color:red;">*</span></label>
                            <input class = "inputImg" type="file" name= "img1">
                            <label for="">Ảnh sản phẩm (ảnh mô tả 2) <span style="color:red;">*</span></label>
                            <input class = "inputImg" type="file" name= "img2">
                            <label for="">Ảnh sản phẩm (ảnh mô tả 3) <span style="color:red;">*</span></label>
                            <input class = "inputImg" type="file" name= "img3">
                            <label for="">Ảnh sản phẩm (ảnh mô tả 4) <span style="color:red;">*</span></label>
                            <input class = "inputImg" type="file" name= "img4">
                            <!--<label for="">Ảnh sản phẩm (ảnh mô tả) <span style="color:red;">*</span></label>
                            <input class = "inputImg" multiple type="file">-->
                            <button name = "add-product" type = "submit">Thêm sản phẩm</button>
                            </form>
                            <?php
                                }
                            }
                            ?>

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