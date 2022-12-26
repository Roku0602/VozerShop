<?php
    include ('../assets/function/connect.php');
    session_start();
?>
<?php
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'deletesp':
                    $limit = $_GET['limit'];
                    $page = $_GET['page-num'];
                    $masp = $_GET['id'];
                    //var_dump($masp);exit;
                    $delete = "DELETE FROM SAN_PHAM WHERE MaSP = '$masp' ";
                    $conndel = sqlsrv_query($conn,$delete);
                    //var_dump($conndel);exit;
                    header("Location: ./product-admin.php?limit=$limit&page-num=$page");
                break;
            }
    }
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
                            $limititem = !empty($_GET['limit']) ? $_GET['limit'] : 6; // Nếu Tồn tại limit, số sản phẩm/trang = số limit, còn kh thì số limit sẽ = 2 
                            $pagenum = !empty($_GET['page-num']) ? $_GET['page-num'] : 1;
                            $upload = $pagenum-1;
                            if($pagenum==1){
                                $offset = $pagenum-1;
                            }    
                            elseif($pagenum != 1){
                                $offset = $upload+$limititem-1;
                                $upload = $offset;
                            }
                            $allproductsql ="SELECT * FROM SAN_PHAM ";
                            $findtotal = sqlsrv_query($conn, $allproductsql, array(), array("Scrollable" => 
                                'static'));
                            $countitem = sqlsrv_num_rows($findtotal);
                            $totaladminpage = ceil($countitem/$limititem);
                            $tsql = "SELECT top $limititem * FROM (
                                select *, ROW_NUMBER() over (order by MaSP DESC) as rowoffset 
                                from SAN_PHAM ) xx where rowoffset > $offset";
                            $connproduct = sqlsrv_query($conn,$tsql);
                            while($showproduct = sqlsrv_fetch_array($connproduct, SQLSRV_FETCH_ASSOC)){
                        ?>
                        <tbody>
                            <tr>
                                <td><img src=<?=$showproduct['HinhAnhSP']?> alt=""></td>
                                <td><?=$showproduct['TenSP']?></td>
                                <td><?=number_format($showproduct['Gia'],0,".",".")?>đ</td>
                                <td><a href="/admin page/product-add-admin.php?product=<?=$showproduct['MaSP']?>">Chi tiết</a></td>
                                <form id = "delete-form" action = 'product-admin.php?limit=6&page-num=<?=$pagenum?>' method="POST" >
                                    <td><a href = "product-admin.php?action=deletesp&id=<?=$showproduct['MaSP']?>&limit=<?=$limititem?>&page-num=<?=$pagenum?>" class = "delete">Xóa sản phẩm</a></td>
                                </form>
                            </tr>
                        </tbody>
                        <?php
                            }
                        ?>

                        
                    </table>
                    <div class="pagigation">
                        <?php
                            include ("./product-admin-pagenum.php");
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