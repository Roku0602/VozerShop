<?php
    require 'assets/function/database.php';
    $db = new Database();
    
    session_start();
    
        if(isset($_POST['btn-reglog'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            if(!empty(strchr($username,'Staff')) || !empty(strchr($username,'staff')) || !empty(strchr($username,'manage')) || !empty(strchr($username,'Manage')) 
            || !empty(strchr($username,'Employ')) || !empty(strchr($username,'employ')) || !empty(strchr($username,'Vice')) || !empty(strchr($username,'vice')))
            {
                $fnhanvien = "SELECT * from TAI_KHOAN B,NHAN_VIEN A WHERE B.TenDangNhapTK LIKE '$username' and B.MatKhau='$password' and A.TenDangNhapTK=B.TenDangNhapTK";
        
                $row_nv=$db->fetch_array($fnhanvien);
                if(!isset($_SESSION["username"])){
                    $_SESSION["username"] = array();
                }
                if(!isset($_SESSION["Chuc-vu"])){
                    $_SESSION["chuc-vu"] = array();
                }
                if(!empty($row_nv)){
                    if(isset($_SESSION["username"])){
                        $getcvsql = "SELECT A.MaCV FROM CHUC_VU A, NHAN_VIEN B WHERE B.TenDangNhapTK LIKE '$username' and A.MaCV = B.MaCV ";
                        $row_cv = $db->fetch_array($getcvsql);
                        $_SESSION["chuc-vu"] = $row_cv;
                        
                        
                       
                        $_SESSION["username"] = $row_nv['TenDangNhapTK'];
                    //var_dump($_SESSION["username"]);exit;
                    header("Location: ./admin page/admin-index.php");
                    }
                }else{

                    echo '<p style="color:red">Không tồn taị tài khoản này!</p>';
                    
                }
            }
                
            
            
            else{
                $encryppass = md5($password);
                $query = "SELECT * from TAI_KHOAN B,KHACH_HANG A WHERE B.TenDangNhapTK='$username'  and B.MatKhau= '$encryppass' and A.TenDangNhapTK=B.TenDangNhapTK  ";
        
                $row=$db->fetch_array($query);
            //$row=sqlsrv_fetch_object($result);
            //var_dump($row);
            //die;
                
                if(!isset($_SESSION["username"])){
                $_SESSION["username"] = array();
                }
                if(!empty($row)){
                if(isset($_SESSION["username"])){
                
                    $_SESSION["username"] = $row['TenDangNhapTK'];
                //var_dump($_SESSION["username"]);
                header("Location: ./index.php");
                }
                }else{
                echo '<p style="color:red">Tên đăng nhập hoặc mật khẩu không đúng!</p>';
                
                }
            }
            
        }

?>