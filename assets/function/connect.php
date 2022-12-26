<?php
 define('__ROOT__', dirname(dirname(__FILE__))); 
 include (__ROOT__.'/function/config.php');
?>
<?php
         $servername = SRV_Name;
         $connectionInfo = array("Database"=>DB_NAME, "CharacterSet" => "UTF-8");
         $conn = sqlsrv_connect($servername,$connectionInfo);
         sqlsrv_query ($conn,"set character_set_client='utf8'");  
         sqlsrv_query ($conn,"set character_set_results='utf8'");
         sqlsrv_query($conn,"set collation_connection='utf8_general_ci'");
         sqlsrv_query($conn,"SET character_set_results='utf8'");
         mb_language('uni');
         mb_internal_encoding('UTF-8');
?>