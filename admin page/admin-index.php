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
    <link rel="stylesheet" href="/admin page/assets/css/admin-index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>AdminPage</title>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="../index.php">
                        <span class="icon"><ion-icon name="storefront"></ion-icon></span>
                        <span class="title">VZ06</span>
                    </a>
                </li>
                <li>
                    <a class="active" href="#">
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

            <!-- cards -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <?php
                            if(isset($_SESSION['luottruycap'])){
                                if(!empty($_SESSION['luottruycap'])){
                        ?>
                        <div class="number"><?=$_SESSION['luottruycap']?></div>
                        <div class="cardName">Lượt truy cập</div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <?php
                            $sql = "SELECT * FROM SAN_PHAM ";
                            $findtotal = sqlsrv_query($conn, $sql, array(), array("Scrollable" => 
                            'static'));
                            $countitem = sqlsrv_num_rows($findtotal);
                        ?>
                        <div class="number"><?=$countitem?></div>
                        <div class="cardName">Đang bán</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="number">0</div>
                        <div class="cardName">Tin nhắn</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <?php
                        $total=0;
                            $billsql = "SELECT TongHoaDon FROM HOA_DON";
                            $connbill = sqlsrv_query($conn,$billsql);

                            while($sumbill = sqlsrv_fetch_array($connbill,SQLSRV_FETCH_ASSOC)){
                                $total = $total + $sumbill['TongHoaDon'];
                            }
                            
                        ?>
                        <div class="number"><?=number_format($total,0,".",".")?></div>
                        <div class="cardName">Thu nhập</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- order detail list -->
            <div class="detail">
                <div class="recentOders">
                    <div class="cardHeader">
                        <h2>Recent Oders</h2>
                        <a href="#" class = "btn">View All</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Mã đơn hàng</td>
                                <td>Tổng số tiền</td>
                                <td>Tình trạng thanh toán</td>
                                <td>Tình trạng đơn hàng</td>
                            </tr>
                        </thead>
                        <?php
                            
                            $allordersql = "SELECT  * FROM HOA_DON ORDER BY TinhTrangDH DESC";
                            $connorder = sqlsrv_query($conn,$allordersql);
                            
                            while($showallorder = sqlsrv_fetch_array($connorder,SQLSRV_FETCH_ASSOC)){
                        ?>
                        <tbody>
                            <tr>
                                <td><?=$showallorder['MaHÐ']?></td>
                                <td><?=number_format($showallorder['TongHoaDon'],0,".",".")?></td>
                                <td><?=$showallorder['TinhTrangTT']?></td>
                                <?php
                                    if(!empty(strchr($showallorder['TinhTrangDH'],'Đã xác nhận'))){
                                ?>
                                <td><span class = "status pending"><?=$showallorder['TinhTrangDH']?></span></td>
                                <?php
                                    }else{
                                ?>
                                    <td><span class = "status delivered"><?=$showallorder['TinhTrangDH']?></span></td>
                                <?php
                                    }
                                ?>
                                <td><a href = 'invoice-admin.php?billid=<?=$showallorder['MaHÐ']?>'>Chi tiết</a></td>
                            </tr>
                        </tbody>
                        <?php
                            }
                        ?>
                        
                    </table>
                </div>

                <!-- order detail list -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Recent Customers</h2>
                    </div>
                    <table>
                        <?php
                            $allcustomersql = "SELECT * FROM KHACH_HANG";
                            $connallcustomer = sqlsrv_query($conn,$allcustomersql);
                            while($showallcustomers = sqlsrv_fetch_array($connallcustomer,SQLSRV_FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><h4><?=$showallcustomers['HoTenKH']?><br><span><?=$showallcustomers['DiaChi']?></span></h4></td>
                        </tr>
                        <?php
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