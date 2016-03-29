<?php
include_once("database/db_conection.php");

if(count($_FILES) > 0) {
if(is_array($_FILES)) {
if($_POST['id'] && $_POST['sku'] && $_POST['name'] && $_POST['desc'])
{
    $error_flag = false;
    $uploadOk = 1;
    $target_dir = "productuploads/";
    
    $id = $_POST['id'];
    $update_productsku = mysqli_real_escape_string($db_conn,$_POST['sku']);
    $skuname = strtolower(preg_replace('/\s+/', '-', $update_productsku));
    
    $update_productname = mysqli_real_escape_string($db_conn,$_POST['name']);
    $update_productdesc=mysqli_real_escape_string($db_conn,$_POST['desc']);
    $update_productimage=$_POST['updateproductimage']; 
    
    $check_update_sku_query="select * from product WHERE sku='$update_productsku' AND id !='$id' ";    
    $updateresult = mysqli_query($db_conn, $check_update_sku_query);   
    if(mysqli_num_rows($updateresult)>0){
        $error_flag = true;
        echo "skuerror";       
    }
    
    if(is_uploaded_file($_FILES['productajaxfile']['tmp_name'])){         
        
        $target_file = $target_dir . basename($_FILES["productajaxfile"]["name"]);
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["productajaxfile"]["tmp_name"]);
        if($check == false) {
            echo "filenotimage";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["productajaxfile"]["size"] > 5242888) {
            echo "filesizeerror";
            $uploadOk = 0;
        }
        // Allow certain file formats
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);     
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "fileformaterror";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "filenotuploadederror";
        }
        $imageFilename = pathinfo($target_file,PATHINFO_FILENAME);  
        $savefinalimagename = $target_dir.$imageFilename.'_'.time().'.'.$imageFileType;
        $savequeryimage = $imageFilename.'_'.time().'.'.$imageFileType;
            
    }
    
    if (($error_flag == false)&&($uploadOk == 1)){
    move_uploaded_file($_FILES["productajaxfile"]["tmp_name"], $savefinalimagename);
    if ($update_productimage != 'no-image.jpg'){
        unlink("$target_dir$update_productimage");
    }
    $update_query="UPDATE product SET sku='$skuname',name='$update_productname',description='$update_productdesc',image='$savequeryimage' where id='$id'";  
    
    $run_updatequery=mysqli_query($db_conn,$update_query); 
    if($run_updatequery)  
    {  
       echo $savequeryimage;
    }
    }  
    
    //$update_query = "UPDATE product SET sku='".$_POST["sku"]."',name='".$_POST["name"]."',description='".$_POST["desc"]."' where id='".$_POST["id"]."'";
   
    //mysqli_query($db_conn,$update_query);
}
}
} else {
    if($_POST['id'] && $_POST['sku'] && $_POST['name'] && $_POST['desc']){
            
        $update_query = "UPDATE product SET sku='".$_POST["sku"]."',name='".$_POST["name"]."',description='".$_POST["desc"]."' where id='".$_POST["id"]."'";   
        mysqli_query($db_conn,$update_query);
    }
}
?>