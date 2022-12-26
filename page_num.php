<?php
    if(isset($_GET['TH'])){
        for($num = 1;$num <= $totalpage; $num++)
        {
            echo '<a href="category.php?id='.$idlist.'&limit='.$limititem.'&page-num='.$num.'&TH='.$idth.'">'.$num.'</a>';
         
        }
        $next= !empty($_GET['page-num']) ? $_GET['page-num']+1 : 1;
        if($next <= $totalpage)
            echo '<a href="?id='.$idlist.'&limit='.$limititem.'&page-num='.$next.'&TH='.$idth.'"><i class = "fa-solid fa-arrow-right"></i></a>';
        else{
            $next = $totalpage;
        }
    }else{
    for($num = 1;$num <= $totalpage; $num++)
    {
        echo '<a href="category.php?id='.$idlist.'&limit='.$limititem.'&page-num='.$num.'">'.$num.'</a>';
         
    }
    $next= !empty($_GET['page-num']) ? $_GET['page-num']+1 : 1;
    if($next <= $totalpage)
        echo '<a href="?id='.$idlist.'&limit='.$limititem.'&page-num='.$next.'"><i class = "fa-solid fa-arrow-right"></i></a>';
    else{
        $next = $totalpage;
    }
    }
?>