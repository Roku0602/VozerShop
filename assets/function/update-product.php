<?php
Class update_cart{
    function update_cart($add = false){
        foreach($_POST['quantity'] as $id => $quantity){
            if($quantity == 0){
                    $masp = $_POST['id'];
                    var_dump($masp);exit;
                    $delete = "DELETE FROM SAN_PHAM WHERE MaSP = '$masp' ";
                    $conndel = sqlsrv_query($conn,$delete);
            }
            else{
                if($add){
                    $_SESSION["cart"][$id] += $quantity;
                }
                else{
                    $_SESSION["cart"][$id] += $quantity;
                }
            }
            
        }
    }
}
    
?>