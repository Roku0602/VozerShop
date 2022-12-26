<?php
    include ('../assets/function/connect.php');
?>

<?php
    if(isset($_POST['btn-back'])){
        header("Location: ./employee-add-admin.php");
    }
    if(isset($_POST['btn-update-nv'])){
        $manvpre = $_POST['MaNV'];
        $manv = $manvpre;
        //var_dump($manvpre);exit;
        $ssqlpre = "SELECT * From NHAN_VIEN WHERE MaNV LIKE '%$manvpre'";
        $searchtk = sqlsrv_query($conn,$ssqlpre);
        $showpreacc = sqlsrv_fetch_object($searchtk);
            $tmp = $showpreacc->TenDangNhapTK;
    
        if(!empty($_POST['NameNV'])){
            $namenv = $_POST['NameNV'];
            //var_dump($namenv);
            if(empty($_POST['MaNV']))
                $updatename = sqlsrv_query($conn,"UPDATE NHAN_VIEN SET HoTen = N'$namenv' WHERE MaNV = '$manvpre'  ");
            else{
                $updatename = sqlsrv_query($conn,"UPDATE NHAN_VIEN SET HoTen = N'$namenv' WHERE MaNV = '$manv'  ");
            }
        }else{
            $namenv = $showpreacc->HoTen;
        }
        if(!empty($_POST['inphonenum'])){
            $SDT = $_POST['inphonenum'];
            if(empty($_POST['MaNV']))
                $updatename = sqlsrv_query($conn,"UPDATE NHAN_VIEN SET SDT = '$SDT' WHERE MaNV = '$manvpre'  ");
            else{
                $updatename = sqlsrv_query($conn,"UPDATE NHAN_VIEN SET SDT = '$SDT' WHERE MaNV = '$manv'  ");
            }
        }else{
            $SDT = $showpreacc->SDT;
        }
        if(!empty($_POST['inaddress'])){
            $diachi = $_POST['inaddress'];
            if(empty($_POST['MaNV']))
                $updatename = sqlsrv_query($conn,"UPDATE NHAN_VIEN SET DiaChi = N'$diachi' WHERE MaNV = '$manvpre'  ");
            else{
                $updatename = sqlsrv_query($conn,"UPDATE NHAN_VIEN SET DiaChi = N'$diachi' WHERE MaNV = '$manv'  ");
            }
        }else{
            $diachi = $showpreacc->DiaChi;
        }
        if(!empty($_POST['inMail'])){
            $email = $_POST['inMail'];
            if(empty($_POST['MaNV']))
                $updatename = sqlsrv_query($conn,"UPDATE NHAN_VIEN SET Email = '$email' WHERE MaNV = '$manvpre'  ");
            else{
                $updatename = sqlsrv_query($conn,"UPDATE NHAN_VIEN SET Email = '$email' WHERE MaNV = '$manv'  ");
            }
        }else{
            $email = $showpreacc->Email;
        }
        header("Location: ./employee-admin.php?limit=4&page-num=1");
    }
    if(isset($_POST['btn-add-nv'])){
        //var_dump($_POST['DSCV']);
            if(!empty(strchr($_POST['DSCV'],'MA'))){
                $manv = 'QL'.$_POST['MaNV'];
                $username = 'Manage'.$_POST['MaNV'];
                //var_dump($manv);exit;
            }
            if(!empty(strchr($_POST['DSCV'],'NV'))){
                $manv = 'NV'.$_POST['MaNV'];
                $username = 'Employ'.$_POST['MaNV'];
                //var_dump($manv);exit;
            }
            if(!empty(strchr($_POST['DSCV'],'PGD'))){
                $manv = 'VICE'.$_POST['MaNV'];
                $username = 'Vice'.$_POST['MaNV'];
                //var_dump($manv);exit;
            }
            if(!empty($_POST['NameNV'])){
                $namenv = $_POST['NameNV'];
            }else{
                $error = 'Trống mã nhân viên';
                
            }
            if(!empty($_POST['inphonenum'])){
                $SDT = $_POST['inphonenum'];
                
            }else{
                $error ='trống số điện thoại';
                
            }
            if(!empty($_POST['inaddress'])){
                $diachi = $_POST['inaddress'];
            }else{
                $error = 'Trống địa chỉ';
            }
            if(!empty($_POST['inMail'])){
                $email = $_POST['inMail'];
            }
            $cv = $_POST['DSCV'];
            $pass = 123;
             
           if(empty($error)){
            $queryUSER = "INSERT INTO TAI_KHOAN (TenDangNhapTK,MatKhau) VALUES ('$username','$pass')";
            $signupadmin = sqlsrv_query($conn,$queryUSER);
            $insertsql = "INSERT NHAN_VIEN (MaNV, TenDangNhapTK, MaCV, HoTen, SDT, DiaChi, Email) 
                            VALUES ('$manv','$username','$cv', N'$namenv', '$SDT', N'$diachi', '$email')";
            $insertconn = sqlsrv_query($conn,$insertsql);
            header("Location: ./employee-admin.php?limit=4&page-num=1");

           }else{
            header("Location: ./employee-add-admin.php?error=Không được để trống thông tin");
            
           }
            
        }
    
?>