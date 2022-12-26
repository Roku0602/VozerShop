<?php
    include ('../assets/function/connect.php');
    session_start();
    
?>
<?php
    if(isset($_POST['btn-add-brand'])){

        if(isset($_POST['brand-id'])){
            $brandid = $_POST['brand-id'];
        }else{
            $error = '1';
        }

        if(isset($_POST['brand-name'])){
            $brandname = $_POST['brand-name'];
        }else{
            $error = '2';
        }
        if(empty($error)){
            $sqlbrand = "SELECT * FROM THUONG_HIEU WHERE Ma_TH <> '$brandid' and TenTH <> '$brandname'";
            $connbrand = sqlsrv_query($conn,$sqlbrand);
            while($comparebrand = sqlsrv_fetch_array($connbrand,SQLSRV_FETCH_ASSOC)){
            //var_dump($comparetype);
            if(!empty($comparebrand)){
                $insertbrandSQL = "INSERT INTO THUONG_HIEU (Ma_TH, TenTH) VALUES ('$brandid',N'$brandname')";
                $conninsert = sqlsrv_query($conn,$insertbrandSQL);
                //var_dump($conninsert);
                header("Location: ./category-admin.php");
                }
            }
        }else{
            echo "Nhập chưa đủ thông tin!";
        }
    }
?>