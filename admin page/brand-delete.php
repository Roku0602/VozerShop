<?php
    include ('../assets/function/connect.php');
    session_start();
    
?>
<?php
    if(isset($_GET['id'])){
        //var_dump($_GET['type']);exit;
        $idbrand = $_GET['id'];
        
        $deletesql = "DELETE FROM THUONG_HIEU WHERE Ma_TH = '$idbrand' ";
        $conndeltype = sqlsrv_query($conn,$deletesql);
        //var_dump($conndeltype);exit;
        header("Location: ./category-admin.php");
    }
?>