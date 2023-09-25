<?php

@include 'db.php';


if(isset($_POST['add_product'])){

   $product_title = $_POST['product_title'];
   $product_price = $_POST['product_price'];
   $product_desc = $_POST['product_desc'];
   $product_keywords = $_POST['product_keywords'];
   $product_image = $_FILES['product_image']['title'];
   $product_image_tmp_title = $_FILES['product_image']['tmp_title'];
   $product_image_folder = 'product_images/'.$product_image;

   if(empty($product_title) || empty($product_price) || empty($product_image)){
      $message[] = 'please fill out all';
   }else{
      /////// à affecter keurs variables///////////
      $insert = "INSERT INTO products(product_title, price,qty,desc, image,keywords) VALUES('$product_title','$product_price','$product_desc ', '$product_image','$product_keywords')";
      $upload = mysqli_query($con,$insert);
      if($upload){
         move_uploaded_file($product_image_tmp_title, $product_image_folder);
         $message[] = 'new product added successfully';
      }else{
         $message[] = 'could not add the product';
      }
   }

};


/*
id
cat
band
title
price
qty
desc
image
keywords*/





if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($con, "DELETE FROM products WHERE id = $id");
   header('location:admin_page.php');
};

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css.css">

</head>
<body>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}

?>
   
<div class="container">

   <div class="admin-product-form-container">

      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
         <h3>add a new product</h3>
         <input type="text" placeholder="enter product name" name="product_title" class="box">
         <input type="number" placeholder="enter product price" name="product_price" class="box">
         <input type="text" placeholder="enter product description" name="product_desc" class="box">
         <input type="file" accept="product_image/png, image/jpeg, image/jpg" name="product_image" class="box">
         <input type="text" placeholder="enter product keywords" name="product_keywords" class="box">
         <input type="submit" class="btn" name="add_product" value="add product">
      </form>

   </div>

   <?php

   $select = mysqli_query($con, "SELECT * FROM products");
   
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>product image</th>
            <th>product name</th>
            <th>product price</th>
            <th>product description</th>
            <th>product keywords</th>
            <th>action</th>
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="product_images/<?php echo $row['product_image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['product_title']; ?></td>
            <td><?php echo $row['product_price']; ?>Dhs</td>
            <td><?php echo $row['product_desc']; ?></td>
            <td><?php echo $row['product_keywords']; ?></td>
            <td>
               <a href="admin_update.php?edit=<?php echo $row['product_id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
               <a href="admin_page.php?delete=<?php echo $row['product_id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>

</div>


</body>
</html>