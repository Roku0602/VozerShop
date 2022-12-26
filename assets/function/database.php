<?php
 include 'config.php'
?>
 
<?php
Class Database{
   public $host   = SRV_Name;
   public $dbname = DB_NAME;
   public $connectionInfo = array("Database"=>DB_NAME ,"CharacterSet" =>"UTF-8"); 
   public $link;
   public $error;
        
 public function __construct(){
  $this->connectDB();
 }
 
private function connectDB(){
    $conn = sqlsrv_connect( $this->host , $this->connectionInfo);
        
    $this->link = $conn;

   if(!$this->link){
     $this->error ="Error 404".$this->link->connect_error;
    return false;
   }
   else{
            echo "";
   }
 }
//  public function list($query){
//   $conn = sqlsrv_connect( $this->host ,$this->connectionInfo);
//   $stmt =  sqlsrv_query($conn, $query);
//   $listpd = new ArrayListt;
//     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
//       $listpd->Add($row);
//     }  
//  }
// Select or Read data
// public function select($query){
//   $conn = sqlsrv_connect( $this->host ,$this->connectionInfo);
//   $stmt =  sqlsrv_query($conn, $query);
//   $result = sqlsrv_query($conn, $query) or 
//    die($this->link->error.__LINE__);
//   if($result > 0){
//     return $result;
//   } else {
//     return false;
//   }
//  }
public function select($query){
  $conn = sqlsrv_connect( $this->host , $this->connectionInfo);
    $result = sqlsrv_query($conn, $query); //or 
   //die($this->link->error.__LINE__);
  if($result > 0){
    return $result;
  } else {
    return false;
  }
 }
 public function fetch_array($query){
  $conn = sqlsrv_connect( $this->host , $this->connectionInfo);
    $array = sqlsrv_query($conn, $query);
    $in = sqlsrv_fetch_array($array, SQLSRV_FETCH_ASSOC);
    if($in){
      return $in;
    } else {
      return false;
    }
 }

// Insert data
public function insert($query){
  $conn = sqlsrv_connect( $this->host , $this->connectionInfo);
  $insert_row = sqlsrv_query($conn, $query);
   if($insert_row){
     return $insert_row;
   } else {
     return false;
    }
    sqlsrv_free_stmt($insert_row);
 }
  
// Update data
 public function update($query){
    // mysqli_set_charset($this->link,'UTF8');
   $update_row = $this->link->query($query) or 
     die($this->link->error.__LINE__);
   if($update_row){
    return $update_row;
   } else {
    return false;
    }
 }
  
// Delete data
 public function delete($query){
   $delete_row = $this->link->query($query) or 
     die($this->link->error.__LINE__);
   if($delete_row){
     return $delete_row;
   } else {
     return false;
    }
   }
}




