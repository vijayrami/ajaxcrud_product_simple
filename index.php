<?php

include_once("database/db_conection.php");

include_once("header.php");
?>
  <body>

    <div class="container">
    <div class="row">
        <div class="table-scrol"> 
        <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <h1 align="center">Add the Products</h1> 
        </div>  
        </div>
        <p></p>
        <div id="errormsg"></div>
        <div class="row">
        <div class="table-responsive"><!--this is used for responsive display in mobile and other devices-->  
      
      
        <table id="example" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
            <thead>
            <tr>  
                <th class="col-md-2 col-sm-2">Product Sku</th>
                <th class="col-md-2 col-sm-2">Product Name</th>             
                <th class="col-md-2 col-sm-2">Product Description</th>   
                <th class="col-md-2 col-sm-2">Product Image</th>
                <th style="width: 5%;">Action</th>              
            </tr>  
            </thead> 
            <tfoot>
            <tr>  
               
                 <th class="col-md-2 col-sm-2">Product Sku</th>
                <th class="col-md-2 col-sm-2">Product Name</th>               
                <th class="col-md-2 col-sm-2">Product Description</th>   
                <th class="col-md-2 col-sm-2">Product Image</th>
                <th width="5%">Action</th>                              
            </tr>  
            </tfoot>  
            <tbody>
            <tr id="product-list-box">
                <img src="LoaderIcon.gif" id="loaderIcon" style="display:none;" />
            </tr> 
            <?php  
            
            $view_product_query="select * from product";//select query for viewing users. 
            $run=mysqli_query($db_conn,$view_product_query);//here run the sql query.  
            if(mysqli_num_rows($run)>0){
            while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.  
            {  
                $product_id=$row[0];  
                $product_sku=$row[1];
                $product_name=$row[2];   
                $product_des=$row[3];   
                $product_image=$row[4];  
                
            ?>  
            
            <tr class="tredit" id="<?php echo $product_id;?>">  
                <!--here showing results in the table -->  
                
                <td class="col-md-2 col-sm-2">
                   <span id="first_<?php echo $product_id; ?>" class="text"><?php echo $product_sku; ?></span>
                   <input type="text" class="form-control ajax" name="addajxproductsku" id="first_ajax_<?php echo $product_id; ?>" value="<?php echo $product_sku; ?>" placeholder="Product_SKU"  maxlength="100" required  autofocus>
                </td>
                <td class="col-md-2 col-sm-2">
                    <span id="second_<?php echo $product_id; ?>" class="text"><?php echo $product_name; ?></span>
                    <input type="text" class="form-control ajax" name="addajaxproductname" value="<?php echo $product_name; ?>" id="second_ajax_<?php echo $product_id; ?>" placeholder="Product name" required  autofocus>
                </td> 
                <td class="col-md-3 col-sm-3">
                    <span id="third_<?php echo $product_id; ?>" class="text"><?php echo $product_des; ?></span>
                    <textarea cols="18" rows="5" class="ajax" name="add_ajax_productdesc" id="third_ajax_<?php echo $product_id; ?>"><?php echo $product_des; ?></textarea>
                </td>
                <td class="col-md-2 col-sm-2">
                    <img id="fourth_<?php echo $product_id; ?>" alt="<?php echo $product_name;?>" class="text" height="100px" width="100px" src="productuploads/<?php echo $product_image;?>">
                    <form id="uploadAjaxForm" action="" method="post">
                        <span class="ajaximage" id="fourth_ajax_<?php echo $product_id; ?>">
                        <input type="file" name="productajaxfile" id="productajaxfile">
                        <input type="hidden" name="updateproductimage" id="updateproductimage" value="<?php echo $product_image;?>">
                        <input type="submit" value="Submit" class="btnSubmit" id="ajaxsubmit"/>
                        </span>
                    </form>
                </td>  
                <td class="col-md-2 col-sm-2" style="width: 5%;">                   
                    <input type="submit" class="ajax btn btn-danger delete" id="fifth_ajax_<?php echo $product_id; ?>" name="deleteproduct" value="Delete" onClick="deleteAction(<?php echo $product_id; ?>,'<?php echo $product_image; ?>')">
                </td> <!--btn btn-danger is a bootstrap button to show danger-->                 
                
                
            </tr>  
            
            <?php }
            } /*else {
                echo "<tr><td colspan='6'><h3 class='text-center'>No Products Found</h3></tr></td>";
            }*/
            
            ?>   
            
            </tbody>
        </table> 
        
        </div>  
        </div>
        
            <div class="container">
                <div class="row">
                <h2>Add Products</h2>
                
            
              <form id="uploadForm" action="" method="post">
              <div class="form-group">
                <label for="addproductsku11">Product Sku</label>                
                <input type="text" class="form-control" name="addproductsku" id="addproductsku" value="" placeholder="Product_SKU"  maxlength="100" required  autofocus>
              </div>
              <div class="form-group">
                <label for="addproductname11">Product Name</label>
                <input type="text" class="form-control" name="addproductname" value="" id="addproductname" placeholder="Product name" required  autofocus>
              </div>
              
              <div class="form-group">
                <label for="addproductdesc11">Product Description</label>
                <textarea cols="142" rows="5" class="ckeditor" name="add_admin_productdesc" id="add_admin_productdesc"><?php echo (!empty($final_adduserdesc))?$final_adduserdesc:"";?></textarea>
            </div>  
              <div class="form-group">
                <label for="exampleProductFile">Product Image</label>
                <input type="file" name="productfile" id="productfile">       
            </div>
              <input class="btn btn-lg btn-success btn-block" type="submit" value="Add Product" name="addproductbtn">
            </div>
            </form>
        </div>
        
        
    </div>
    </div>  
    </div> 

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="lib/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function (e) {
        $("#uploadForm").on('submit',(function(e) {
            e.preventDefault();
            $("#loaderIcon").show();
            var formData = new FormData(this);
            //formData.append("sku", $("#addproductsku").val());
            //formData.append("name", $("#addproductname").val());
            //formData.append("description", $("#add_admin_productdesc").val()); 
            
            $.ajax({
            url: "crud_action.php",            
            type: "POST",
            data: formData,
            async : true,
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false, 
            success:function(data){
               
              if (data == "skuerror"){                   
                   $("#errormsg").html("<div role='alert' class='alert alert-warning alert-dismissible fade in'>Product SKU is already exist in our database, Please try another one!</div>");     
               } else if (data == "filenotimage"){
                   $("#errormsg").html("<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>File is not an image.</strong></div>");  
               } else if (data == "filesizeerror"){
                   $("#errormsg").html("<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, your file is too large.</strong></div>");  
               } else if (data == "fileformaterror"){
                   $("#errormsg").html("<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</strong></div>");
               } else if (data == "filenotuploadederror"){
                   $("#errormsg").html("<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, your file was not uploaded.</strong></div>");
               } else {
                   $("#product-list-box").after(data); 
               }
               
                $("#addproductsku").val('');
                $("#addproductname").val('');
                $("#add_admin_productdesc").val('');
                $("#productfile").val('');
                $("#loaderIcon").hide();
            },
            error:function (){
            },
            timeout: 3000 // sets timeout to 3 seconds
            });
            
        }));
    });
    function deleteAction(id,img_name) {
        
        var info = 'id=' + id + '&img_name='+img_name;
		
        if(confirm("Are you sure you want to delete this?"))
        {
         $.ajax({
           type: "POST",
           url: "delete_products.php",
           data: info,
           success: function(){
            
            }
        });
          //$(this).parents("tr").animate({backgroundColor: "#003" }, "slow").animate({opacity: "hide"}, "slow").remove();
         // $(this).parents("tr").remove(); 
            $( ".tredit#"+id ).hide( 1200, function() {
            $( ".tredit#"+id ).remove();
            });
         }
        return false;
    }
    </script>
    <script> 
    
        function ajaxeditinline() {
        $(".tredit").click(function(){
                     
            var ID=$(this).attr('id');
            
            $("#first_"+ID).hide();
            $("#second_"+ID).hide();
            $("#third_"+ID).hide();
            //$("#fourth_"+ID).hide();
            $("#first_ajax_"+ID).show();
            $("#second_ajax_"+ID).show();
            $("#third_ajax_"+ID).show();
            $("#fourth_ajax_"+ID).show();
            $("#fifth_ajax_"+ID).show();
        }).change(function(){
            var ID=$(this).attr('id');
            var first=$("#first_ajax_"+ID).val();
            var second=$("#second_ajax_"+ID).val();            
            var third=$("#third_ajax_"+ID).val();
            ///var fourth=$("#updateproductimage").val();
            var dataString = 'id='+ ID +'&sku='+first+'&name='+second+'&desc='+third;
            
            $("#first_"+ID).html('<img src="load.gif" />');
            if(first.length && second.length && third.length > 0)
            {
                $.ajax({
                type: "POST",
                url: "post_tabel.php",
                data: dataString,
                async : true,
                cache: false,
                success: function(html)
                    {                
                        $("#first_"+ID).html(first);
                        $("#second_"+ID).html(second);
                        $("#third_"+ID).html(third);
                        //$("#fourth_"+ID).html(fourth);
                    }
                });
            }
            else {
            alert('Enter something.');
            }
            
            $("#uploadAjaxForm").on('submit',(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("id", ID);
                formData.append("sku", first);
                formData.append("name", second);
                formData.append("desc", third); 
                $("#first_"+ID).html('<img src="load.gif" />');
                if(first.length && second.length && third.length > 0) {                    
                    $.ajax({
                    type: "POST",
                    url: "post_tabel.php",
                    data: formData,
                    async : true,
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false, 
                    success: function(html)
                        {   
                            if (html == "skuerror"){                   
                                   $("#errormsg").html("<div role='alert' class='alert alert-warning alert-dismissible fade in'>Product SKU is already exist in our database, Please try another one!</div>");     
                               } else if (html == "filenotimage"){
                                   $("#errormsg").html("<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>File is not an image.</strong></div>");  
                               } else if (html == "filesizeerror"){
                                   $("#errormsg").html("<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, your file is too large.</strong></div>");  
                               } else if (html == "fileformaterror"){
                                   $("#errormsg").html("<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</strong></div>");
                               } else if (html == "filenotuploadederror"){
                                   $("#errormsg").html("<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, your file was not uploaded.</strong></div>");
                               } else {                                       
                                   $("#first_"+ID).html(first);
                                   $("#second_"+ID).html(second);
                                   $("#third_"+ID).html(third);                                    
                                   $("#fourth_"+ID).attr('src', 'productuploads/'+html);
                                   $('#updateproductimage').val(html);
                               }   
                            
                        }
                    });
                }else {
                    alert('Enter something.');
                }
                
            }));  
        });
        
        $(".ajax, .ajaximage").mouseup(function(){
            return false;
        });
        
        $(document).mouseup(function(){
            $(".ajax").hide();
            $(".ajaximage").hide();
            $(".text").show();
        });
        }
    
    $(document).ajaxComplete(function(){
        ajaxeditinline ();
    });
    $(document).ready(function(){
        ajaxeditinline ();
        $("#errormsg").val('');
    });
    </script>
    
  </body>
</html>
