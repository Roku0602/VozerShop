<?php
    include ('../assets/function/connect.php');
?>
<?php

    if(isset($_GET['id'])){
        $idtmp = $_GET['id'];
        
        //var_dump($idtmp);exit;
        if(isset($_GET['confirm'])){
                $updateconfirm = "UPDATE HOA_DON
                        SET TinhTrangDH = N'Đã xác nhận' WHERE MaHÐ = '$idtmp'";
                $connconf = sqlsrv_query($conn,$updateconfirm);
                header("Location: ./invoice-admin.php?billid=$idtmp");
        }
        if(isset($_GET['Done'])){
            $updateconfirmbill = "UPDATE HOA_DON
                        SET TinhTrangTT = N'Đã thanh toán' WHERE MaHÐ = '$idtmp'";
                $connconfbill = sqlsrv_query($conn,$updateconfirmbill);
                //var_dump($connconfbill);exit;
                header("Location: ./invoice-admin.php?billid=$idtmp");
        }
    
    }

?>



            