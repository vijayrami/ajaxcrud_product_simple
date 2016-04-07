<?php
include_once("database/db_conection.php");

if($_POST['addproductsku'] && $_POST['addproductname'] && $_POST['add_admin_productdesc']){
    
	$mark = "'";
    $error_flag = false;
    $uploadOk = 1;
    $target_dir = "productuploads/";
    
    $add_productsku = mysqli_real_escape_string($db_conn,$_POST['addproductsku']);
    $skuname = strtolower(preg_replace('/\s+/', '-', $add_productsku));
    
    $add_productname = mysqli_real_escape_string($db_conn,$_POST['addproductname']);
    
    
    $add_productdesc=mysqli_real_escape_string($db_conn,$_POST['add_admin_productdesc']);
    
    
    $check_product_sku_query="select * from product WHERE sku='$add_productsku'";
    $addproductresult = mysqli_query($db_conn, $check_product_sku_query);   
    if(mysqli_num_rows($addproductresult)>0){
        $error_flag = true;
        echo "skuerror";       
    }
	
    if(is_uploaded_file($_FILES['productfile']['tmp_name'])){           
        
        $target_file = $target_dir . basename($_FILES["productfile"]["name"]);
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["productfile"]["tmp_name"]);
        if($check == false) {
            echo "filenotimage";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["productfile"]["size"] > 5242888) {
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
        $addfinalimagename = $target_dir.$imageFilename.'_'.time().'.'.$imageFileType;
        $addqueryimage = $imageFilename.'_'.time().'.'.$imageFileType;
            
    } else {
        $addfinalimagename = $target_dir.'no-image.jpg';
        $addqueryimage = 'no-image.jpg';
    }
    if (($error_flag == false) && ($uploadOk == 1)){
    
	if (isset($_FILES['productfile'])){
    move_uploaded_file($_FILES["productfile"]["tmp_name"], $addfinalimagename);
	}
    $add_product_query="insert into product (sku,name,description,image) VALUE ('$skuname','$add_productname','$add_productdesc','$addqueryimage')";  
    
    $run_addproductquery=mysqli_query($db_conn,$add_product_query); 
    if($run_addproductquery)  
    {
       $insert_id = mysqli_insert_id($db_conn);
                  echo '<tr id="'.$insert_id.'" class="tredit">                     
                        <td class="col-md-2 col-sm-2">
                            <span id="first_'.$insert_id.'" class="text">' . $_POST["addproductsku"] . '</span>
                            <input type="text" class="form-control ajax" name="addajxproductsku" id="first_ajax_'.$insert_id.'" value="'.$_POST["addproductsku"].'" placeholder="Product_SKU"  maxlength="100" required  autofocus>
                        </td>
                        <td class="col-md-2 col-sm-2">
                            <span id="second_'.$insert_id.'" class="text">' . $_POST["addproductname"] . '</span>
                            <input type="text" class="form-control ajax" name="addajaxproductname" value="'.$_POST["addproductname"].'" id="second_ajax_'.$insert_id.'" placeholder="Product name" required  autofocus>
                        </td>
                        <td class="col-md-3 col-sm-3">
                            <span id="third_'.$insert_id.'" class="text">' . $_POST["add_admin_productdesc"] . '</span>
                            <textarea cols="18" rows="5" class="ajax" name="add_ajax_productdesc" id="third_ajax_'.$insert_id.'">' . $_POST["add_admin_productdesc"] . '</textarea>
                        </td>
                        <td class="col-md-2 col-sm-2">
                            <img id="fourth_'.$insert_id.'" alt="'.$_POST["addproductname"].'" class="text" height="100px" width="100px" src="productuploads/'.$addqueryimage.'">
                            <form id="uploadAjaxForm" action="" method="post">
                            <span class="ajaximage" id="fourth_ajax_'.$insert_id.'">                            
                                <input type="file" name="productajaxfile"> 
                                <input type="submit" value="Submit" class="btnSubmit" />
                                <input type="hidden" name="updateproductimage" id="updateproductimage" value="'.$addqueryimage.'">                           
                            </span>
                            </form>
                        </td>
                        <td class="col-md-2 col-sm-2" style="width: 5%;">
                            <input type="submit" onClick="deleteAction('.$insert_id.','.$mark.$addqueryimage.$mark.')" class="ajax btn btn-danger delete" name="deleteproduct" id="fifth_ajax_' . $insert_id . '" value="Delete">
                        </td>
                        </tr>';  
    }
    }
}
?>
