
<?php

    function update_cart($add = false){
        foreach($_POST['quantity'] as $id => $quantity){
            if($quantity == 0){
                unset($_SESSION["cart"][$_GET['id']]);
            }
            else{
                if($add){
                    $_SESSION["cart"][$id] += $quantity;
                }
                else{
                    $_SESSION["cart"][$id] = $quantity;
                }
            }
            
        }
    }

    
?>