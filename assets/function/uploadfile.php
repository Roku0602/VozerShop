
<?php
function UpLoadImg($imgupload){
    $file= array();
    $error = array();
    $returnfile = array();
    foreach($imgupload as $key => $values){
        if(is_array($values)){
            foreach($values as $in => $value ){
                $file[$in][$key] = $value;
            }
        }else{
            $file[$key] = $values;
        }
    }
    
   
    $cfilename = substr($file['name'],0,strrpos($file['name'],"."));
    //var_dump($filename);exit;
    //var_dump($file);
    $uploadpath = "../img/".$cfilename;
    //var_dump($uploadpath);exit;
    if(!is_dir($uploadpath)){
        mkdir($uploadpath,0777,true);
    }
    else{
        if(is_array(reset($file))){
            foreach($file as $img ){
                $result = validupload($img,$uploadpath);
                //var_dump($img);exit;
                if($result != false){
                    move_uploaded_file($img['tmp_names'],$uploadpath.'/'.$img['name']);
                    $filedirect[] = $uploadpath.'/'.$file['name']; 
                    return $filedirect;
                }
                else{
                    $error = "File không khả dụng !";
                }
            }
            return $error;
        }else{
            $result = validupload($file,$uploadpath);
                //var_dump($img);exit;
                if($result != false){
                    move_uploaded_file($file['tmp_name'],$uploadpath.'/'.$file['name']);
                    $imgdirect = $uploadpath.'/'.$file['name'];
                    //var_dump($imgdirect);exit;
                    if(!empty($imgdirect)){
                        //var_dump($imgdirect);exit;
                        return $imgdirect;
                    }else{
                        move_uploaded_file($file['tmp_name'],$uploadpath.'/'.$file['name']);
                        $imgdirect = $uploadpath.'/'.$file['name'];
                        //var_dump($imgdirect);exit;
                        return $imgdirect;
                    }
                    
                }
                else{
                    $error = "NULL";
                    return $error;
                }
               
        }
        
    }
}

function validupload($file, $uploadpath){
    //shcek size of the file input
    if($file['size'] > 7 * 1024 * 1024){
        return false;
    }
    //Check valid typ of files
    $validfile = array("jpg","jepg","png","bmp");
    $filetype = substr($file['name'],strpos($file['name']," . ") -3);
    if(!in_array($filetype,$validfile)){
        return false;
    }
    $num = 1;
    $filename = substr($file['name'],0,strrpos($file['name'],"."));
    while(file_exists($uploadpath.'/'.$filename.' . '.$filetype)){
        $filename = $filename."(".$num.")";
        $num++;
    }
    $file['name'] = $filename . " . ".$filetype;
    return $file;
}
?>