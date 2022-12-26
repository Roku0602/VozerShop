<?php
    include ('../assets/function/connect.php');
    session_start();
?>
<?php
        if(isset($_POST['btn-back'])){
            header("Location: ./product-add-admin.php");
        }
        if(isset($_POST['update-product'])){
           
            
            //Cập nhật số lượng mặt hàng
            if(!empty($_POST['quantity'])){
                foreach($_POST['quantity'] as $id => $quantity){ 
                    $sl = $_POST['quantity'][$id];
                    $id = $id;
                    //var_dump($_POST['quantity'][$id]);exit;
                    if($sl >0){
                        $updatesl = "UPDATE SAN_PHAM 
                                 SET SoLuong = $sl where MaSP = '$id' ";
                    }else{
                        if($sl<=0){
                            $updatesl = "DELETE FROM SAN_PHAM WHERE MaSP = '$id' ";
                        }
                    }
                    
                    $connupdatesl = sqlsrv_query($conn,$updatesl);
                    
                }
            }
            if(!empty($_POST['DMSP'])){
                $loaisp = $_POST['DMSP'];
                //var_dump($loaisp);exit;   
                $uploai= "UPDATE SAN_PHAM 
                            SET Ma_Loai = '$loaisp' WHERE MaSP = '$id'";
                $connuploai = sqlsrv_query($conn,$uploai);
            }
            if(!empty($_POST['Price']) && is_numeric(str_replace('.','',$_POST['Price'])) == true){
                $gia = $_POST['Price'];
                $updateprice = "UPDATE SAN_PHAM 
                                 SET Gia = $gia where MaSP = '$id' ";
                $connupdateprice = sqlsrv_query($conn,$updateprice);
            }
            if(!empty($_POST['nameSP'])){
                $tensp = $_POST['nameSP'];
                $updatename = "UPDATE SAN_PHAM 
                                 SET TenSP = N'$tensp' where MaSP = '$id' ";
                $connupdateprice = sqlsrv_query($conn,$updatename);
            }
            if(!empty($_POST['detail'])){
                $gt = $_POST['detail'];
                
                $updategt = "UPDATE SAN_PHAM 
                                 SET GioiThieuSP = N'$gt' where MaSP = '$id' ";
                $connupdateprice = sqlsrv_query($conn,$updategt);
            }

            include("../assets/function/uploadfile.php");
           if(isset($_FILES['img']) && !empty($_FILES['img']['name'][0])){
                    $uploadimg = $_FILES['img'];
                    $uploadname = $_FILES['img']['name'];
                    //var_dump($uploadimg);
                    $upresult = UpLoadImg($uploadimg);
                    //var_dump($upresult);
                    if(empty($upresult)){
                        $upresult = UpLoadImg($uploadimg);
                        //var_dump($upresult);exit;
                    }
                    if(!empty($upresult)){
                        $upimgdtb = "UPDATE SAN_PHAM 
                                SET HinhAnhSP = '$upresult' where MaSP = '$id' ";
                        $connupimg = sqlsrv_query($conn,$upimgdtb);
                        //header("Location: ./product-admin.php?limit=6&page-num=1");

                    }
            }
            if(isset($_FILES['img1']) && !empty($_FILES['img1']['name'][0])){
                $uploadimg = $_FILES['img1'];
                $uploadname = $_FILES['img1']['name'];
                //var_dump($uploadimg);
                $upresult1 = UpLoadImg($uploadimg);
                //var_dump($upresult);
                if(empty($upresult1)){
                    $upresult1 = UpLoadImg($uploadimg);
                    //var_dump($upresult);exit;
                }
                if(!empty($upresult1)){
                    $upimgdtb1 = "UPDATE SAN_PHAM 
                            SET HinhAnhCT1 = '$upresult1' where MaSP = '$id' ";
                    $connupimg1 = sqlsrv_query($conn,$upimgdtb1);

                }
            }else{
                if(empty($_FILES['img1']['name'][0])){
                    $fileout1 = "SELECT HinhAnhCT1 FROM SAN_PHAM WHERE MaSP = '$id'";
                $connfout1 = sqlsrv_query($conn,$fileout1);
                $showfout1 = sqlsrv_fetch_object($connfout1);
                $tmpimg1 = $showfout1->HinhAnhCT1;
                $upimgdtb1 = "UPDATE SAN_PHAM 
                                SET HinhAnhCT1 = '$tmpimg1' where MaSP = '$id' ";
                        $connupimg1 = sqlsrv_query($conn,$upimgdtb1);
                }
                
            }
            if(isset($_FILES['img2']) && !empty($_FILES['img2']['name'][0])){
                $uploadimg = $_FILES['img2'];
                $uploadname = $_FILES['img2']['name'];
                //var_dump($uploadimg);
                $upresult2 = UpLoadImg($uploadimg);
                //var_dump($upresult2);
                if(empty($upresult2)){
                    $upresult2 = UpLoadImg($uploadimg);
                    //var_dump($upresult2);
                }
                        $upimgdtb2 = "UPDATE SAN_PHAM 
                                SET HinhAnhCT2 = '$upresult2' where MaSP = '$id' ";
                                
                        $connupimg2 = sqlsrv_query($conn,$upimgdtb2);
                        //var_dump($connupimg2);exit;
                
                
            }

            if(isset($_FILES['img3']) && !empty($_FILES['img3']['name'][0])){
                $uploadimg = $_FILES['img3'];
                $uploadname = $_FILES['img3']['name'];
                //var_dump($uploadimg);
                $upresult3 = UpLoadImg($uploadimg);
                //var_dump($upresult);
                if(empty($upresult3)){
                    $upresult3 = UpLoadImg($uploadimg);
                    //var_dump($upresult);exit;
                }
               
                    $upimgdtb3 = "UPDATE SAN_PHAM 
                            SET HinhAnhCT3 = '$upresult3' where MaSP = '$id' ";
                    $connupimg3 = sqlsrv_query($conn,$upimgdtb3);


            }
            if(isset($_FILES['img4']) && !empty($_FILES['img4']['name'][0])){
                $uploadimg = $_FILES['img4'];
                $uploadname = $_FILES['img4']['name'];
                //var_dump($uploadimg);
                $upresult4 = UpLoadImg($uploadimg);
                //var_dump($upresult);
                if(empty($upresult4)){
                    $upresult4 = UpLoadImg($uploadimg);
                    //var_dump($upresult);exit;
                }
               
                    $upimgdtb4 = "UPDATE SAN_PHAM 
                            SET HinhAnhCT4 = '$upresult4' where MaSP = '$id' ";
                    $connupimg4 = sqlsrv_query($conn,$upimgdtb4);

            }
            header("Location: ./product-admin.php?limit=6&page-num=1");
        }
        if(isset($_POST['add-product'])){
            if(!empty($_POST['quantity'])){
                $sl = $_POST['quantity'];
            }
            else{
                $error = '1';
                
            }
            //var_dump($_POST['quantity']);
            if(!empty($_POST['Price']) && is_numeric(str_replace('.','',$_POST['Price'])) == true){
                $gia = $_POST['Price'];
            }else{
                $error='2';
            }
            if(!empty($_POST['nameSP'])){
                $tensp = $_POST['nameSP'];
            }else{
                $error = '3';
            }
            if(!empty($_POST['DMSP'])){
                $loaisp = $_POST['DMSP'];
                
                
            }else{
                $error = '4';
            }
            if(!empty($_POST['DMTH'])){
                $loaith = $_POST['DMTH'];
                
                
            }else{
                $error = '5';
            }
            if(!empty($_POST['detail'])){
                $gt = $_POST['detail'];
              // var_dump($gt);
            }else{
                $error = '6';
            }
            $getid = "SELECT ID FROM SAN_PHAM ORDER BY ID DESC";
            $connget = sqlsrv_query($conn,$getid);
            
            $showid = sqlsrv_fetch_object($connget);
                $masp = $showid->ID;
            if(!empty($masp)){
                $idnew = $masp+1;
                $maspnew = 'SP'.$idnew;
            }else{
                $idnew = 1;  // Nếu chưa có sản phẩm nào thì sẽ là sản phẩm đầu tiên
                $maspnew = 'SP'.$idnew;
            }
            //var_dump($idnew);exit;
            include("../assets/function/uploadfile.php");
            if(isset($_FILES['img']) && !empty($_FILES['img']['name'][0])){
                    $uploadimg = $_FILES['img'];
                    $uploadname = $_FILES['img']['name'];
                    //var_dump($uploadimg);
                    $upresult = UpLoadImg($uploadimg);
                    //var_dump($upresult);
                    if(empty($upresult)){
                        $upresult = UpLoadImg($uploadimg);
                        //var_dump($upresult);exit;
                    }
            }else{
                $upresult = NULL;
            }
            if(isset($_FILES['img1']) && !empty($_FILES['img1']['name'][0])){
                $uploadimg = $_FILES['img1'];
                $uploadname = $_FILES['img1']['name'];
                //var_dump($uploadimg);
                $upresult1 = UpLoadImg($uploadimg);
                //var_dump($upresult);exit;
                if(empty($upresult1)){
                    $upresult1 = UpLoadImg($uploadimg);
                    //var_dump($upresult);exit;
                }
            }else{
                $upresult1 = NULL;
            }
            if(isset($_FILES['img2']) && !empty($_FILES['img2']['name'][0])){
                $uploadimg = $_FILES['img2'];
                $uploadname = $_FILES['img2']['name'];
                //var_dump($uploadimg);
                $upresult2 = UpLoadImg($uploadimg);
                //var_dump($upresult);exit;
                if(empty($upresult2)){
                    $upresult2 = UpLoadImg($uploadimg);
                    //var_dump($upresult);exit;
                }
            }else{
                $upresult2 = NULL;
            }
            if(isset($_FILES['img3']) && !empty($_FILES['img3']['name'][0])){
                $uploadimg = $_FILES['img3'];
                $uploadname = $_FILES['img3']['name'];
                //var_dump($uploadimg);
                $upresult3 = UpLoadImg($uploadimg);
                //var_dump($upresult);exit;
                if(empty($upresult3)){
                    $upresult3 = UpLoadImg($uploadimg);
                    //var_dump($upresult);exit;
                }
            }else{
                $upresult3 = NULL;
            }
            if(isset($_FILES['img4']) && !empty($_FILES['img4']['name'][0])){
                $uploadimg = $_FILES['img4'];
                $uploadname = $_FILES['img4']['name'];
                $upresult4 = UpLoadImg($uploadimg);
                if(empty($upresult4)){
                    $upresult4 = UpLoadImg($uploadimg);
                   
                }
            }else{
                $upresult4 = NULL;
            }
            if(empty($error)){
                $inproductsql = "INSERT INTO SAN_PHAM (MaSP,Ma_Loai, SoLuong,Gia,Ma_TH,TenSP,ID,GioiThieuSP,HinhAnhSP, HinhAnhCT1, HinhAnhCT2, HinhAnhCT3,HinhAnhCT4) 
                    VALUES ('$maspnew','$loaisp','$sl','$gia','$loaith',N'$tensp','$idnew',N'$gt','$upresult','$upresult1','$upresult2','$upresult3','$upresult4')  ";
                $conninproduct = sqlsrv_query($conn,$inproductsql);
                //var_dump($conninproduct);exit;
                header("Location: ./product-admin.php?limit=6&page-num=1");
                
            }else{
                //var_dump($error);exit;
                $error = 'Không được để trống thông tin';
                header("Location: ./product-add-admin.php?error=$error");
            }

        }
        
?>