<?php
    include ('../assets/function/connect.php');
    session_start();
?>
<?php
    if(isset($_POST['btn-add-type'])){
        if(isset($_POST['MaDM'])){
            //var_dump($_POST['MaDM']);
            $idtype = $_POST['MaDM'];
        }else{
            $error = '1';
        }
        if(isset($_POST['TenDM'])){
            $nametype = $_POST['TenDM'];
            //var_dump($_POST['TenDM']);
        }else{
            $error = '2';
        }
        if(empty($error)){
            $sqltype = "SELECT * FROM Loai_SP WHERE Ma_Loai <> '$idtype' and TenLoai <> '$nametype'";
            $conntype = sqlsrv_query($conn,$sqltype);
            while($comparetype = sqlsrv_fetch_array($conntype,SQLSRV_FETCH_ASSOC)){
            //var_dump($comparetype);
            if(!empty($comparetype)){
                $inserttypeSQL = "INSERT INTO Loai_SP(Ma_Loai, TenLoai) VALUES ('$idtype',N'$nametype')";
                $conninsert = sqlsrv_query($conn,$inserttypeSQL);
                //var_dump($conninsert);
                header("Location: ./category-admin.php");
            }
            }
        }else{
            echo "Nhập chưa đủ thông tin!";
        }
        
    }

?>