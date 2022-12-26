
<?php
    
    $back = !empty($_GET['page-num']) ? $_GET['page-num']-1 : 1;
    if($back >0 ){
    echo '<a href="/admin page/customers-admin.php?limit='.$limititem.'&page-num='.$back.'"><ion-icon name="arrow-back-outline"></ion-icon></a>';
    }else{
        if($back < 1)
            $back = 1;
    }
    for($num = 1;$num <= $totaladminpage; $num++)
    {
        echo '<a href="customers-admin.php?limit='.$limititem.'&page-num='.$num.'">'.$num.'</a>';
         
    }
    $next= !empty($_GET['page-num']) ? $_GET['page-num']+1 : 2;
    if($next <= $totaladminpage)
        echo '<a href="/admin page/customers-admin.php?limit='.$limititem.'&page-num='.$next.'"><ion-icon name="arrow-forward-outline"></ion-icon></a>';
    else{
        if($next >= $totaladminpage)
         $next = $totaladminpage;
    }
?>