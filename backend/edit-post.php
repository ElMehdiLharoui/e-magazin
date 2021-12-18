<?php require_once('./includes/header.php'); ?>

    <body class="nav-fixed">
        <?php require_once("./includes/top-navbar.php"); ?>

        <!--Side Nav-->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                    <?php

                        $curr_page = basename(__FILE__);
                        require_once("./includes/left-sidebar.php");
                    ?>
            </div>

                <?php

                    if(isset($_POST['edit-product']))
                    {
                        $product_id = $_POST['product-id'];
                        $url = "http://localhost/DevZiko/backend/edit-post.php?product_id=".$product_id;
                        header("Location:{$url} ");
                    }
                 ?>

                 <?php

                    if(isset($_GET['product_id']))
                    {
                        $product_id = $_GET['product_id'];
                        $sql = "SELECT * FROM products WHERE product_id = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':id' => $product_id]);
                        $product = $stmt->fetch(PDO::FETCH_ASSOC);

                        $product_id = $product['product_id'];
                        $product_title = $product['product_title'];
                        $product_detail = $product['product_detail'];
                        $product_prix = $product['product_prix'];
                        $product_tags = $product['product_tags'];
                        $product_red = $product['product_red'];
                        // we have to get the category name of the product
                        $product_category_id = $product['product_category_id'];
                        
                        // we have to get the path of the photo 
                        $product_image_id = $product['product_image_id'];
                        $sql2 = "SELECT * FROM photos WHERE photo_id = :id";
                        $stmt2 = $pdo->prepare($sql2);
                        $stmt2->execute([':id' => $product_image_id] );
                        $photo = $stmt2->fetch(PDO::FETCH_ASSOC);

                        $product_image = $photo['photo_img'];


                    }

                  ?>

                  <?php

                        if(isset($_POST['update']))
                        {
                            $product_title = trim($_POST['product-title']);
                            $product_prix = $_POST['product-prix'];
                            $product_category_id = $_POST['product-category'];
                            $product_photo = $_FILES['product-photo']['name'];
                            $product_photo_tmp = $_FILES['product-photo']['tmp_name'];
                            move_uploaded_file("{$product_photo_tmp}", "../img/{$product_photo}");
                            $product_detail = $_POST['product-detail'];
                            $product_tags = $_POST['product-tags'];
                            $product_red = $_POST['product-red'];

                            if(empty($product_photo))
                            {
                                $sql3 = "SELECT * FROM products WHERE product_id = :id ";
                                $stmt3 = $pdo->prepare($sql3);
                                $stmt->execute([':id' => $_GET['product_id']]);
                                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                                $product_image_id = $product['product_image_id'];

                            } else                  
                            {
                                // insert into photos the photo of the product first then we have to insert the id of this photo into products table ;
                                $sql1 = "INSERT INTO photos (photo_img) VALUES (:photo)";
                                $stmt1 = $pdo->prepare($sql1);
                                $stmt1->execute([':photo' => $product_photo]);

                                // bring back the id of the image that we insert 

                                $sql2 = "SELECT * FROM photos WHERE photo_img = :img";
                                $stmt2 = $pdo->prepare($sql2);
                                $stmt2->execute([':img' => $product_photo] );
                                $photo = $stmt2->fetch(PDO::FETCH_ASSOC);

                                // Now we have it 
                                $product_image_id = $photo['photo_id']; 
                            }

                            

                            $sql ="UPDATE products SET product_category_id= :cat_id, product_title =:title, product_detail=:detail, product_prix=:prix, product_image_id=:image, product_views=:views, product_comment_count=:comment, product_tags=:tags, product_red=:red WHERE product_id = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([

                                ':cat_id' =>  $product_category_id,
                                ':title' => $product_title,
                                ':detail' => $product_detail,
                                ':prix' => $product_prix,
                                ':image' => $product_image_id,
                                ':views' => 0,
                                ':comment' => 0,
                                ':tags' => $product_tags,
                                ':red' => $product_red,
                                ':id' => $_GET['product_id']

                            ]);
                                header("Location: all-post.php");
                        }

                     ?>


            <div id="layoutSidenav_content">
                <main>
                    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                                    <span>Try Updating Product</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Update Product</div>
                            <div class="card-body">
                                <form action="edit-post.php?product_id=<?php echo $_GET['product_id']; ?>" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="post-title">Product Title:</label>
                                        <input name="product-title" value="<?php echo $product_title; ?>" class="form-control" value="" id="post-title" type="text" placeholder="Product title ..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="post-title">Product Prix:</label>
                                        <input name="product-prix" value="<?php echo $product_prix; ?>" class="form-control" value="" id="post-title" type="text" placeholder="Product prix ..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="post-title">Product Reduction:</label>
                                        <input name="product-red" value="<?php echo $product_red; ?>" class="form-control" value="" id="post-title" type="text" placeholder="Product reduction ..." />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="select-category">Select Category:</label>
                                        <select name="product-category" class="form-control" id="select-category">

                                            <?php

                                                $sql = "SELECT * FROM categories WHERE category_status = :status";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute([':status' => 'Published']);


                                                while($cats = $stmt->fetch(PDO::FETCH_ASSOC))
                                                { ?>

                                                    <option value="<?php echo $cats['category_id']; ?>" <?php echo $cats['category_id']==$product_category_id?"selected":""; ?> >

                                                        <?php echo $cats['category_name']; ?>
                                                         
                                                    </option>

                                                <?php }

                                             ?>
                                           
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="post-title">Choose photo:</label>
                                        <input name="product-photo" class="form-control" id="post-title" type="file" />
                                        <img src="../img/<?php echo $product_image; ?>" width="100" height="100">
                                    </div>

                                    <div class="form-group">
                                        <label for="post-content">Product Details:</label>
                                        <textarea name="product-detail"  class="form-control" placeholder="Type here..." id="post-content" rows="9"><?php echo $product_detail; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="post-tags">Product Tags:</label>
                                        <textarea name="product-tags"  class="form-control" placeholder="Tags..." id="post-tags" rows="3"><?php echo $product_tags; ?></textarea>
                                    </div>
                                    <button name="update" class="btn btn-primary mr-2 my-1" type="submit">Submit now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->

                </main>

<?php require_once('./includes/footer.php'); ?>