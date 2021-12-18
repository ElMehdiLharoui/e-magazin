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


            <div id="layoutSidenav_content">
                <main>
                    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                                    <span>Try Creating New Product</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <?php

                        if(isset($_POST['new-product']))
                        {
                            $product_title = trim($_POST['product-title']);
                            $product_prix = $_POST['product-prix'];
                            $product_category_id = $_POST['product-category'];
                            $product_photo = $_FILES['product-photo']['name'];
                            $product_photo_tmp = $_FILES['product-photo']['tmp_name'];
                            move_uploaded_file("{$product_photo_tmp}", "../img/{$product_photo}");
                            $product_detail = $_POST['product-detail'];
                            $product_tags = $_POST['product-tags'];

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


                            $sql = "INSERT INTO products (product_category_id,product_title, product_detail,product_prix,product_date,product_image_id,product_views, product_comment_count,product_tags) VALUES (:id,:title,:detail,:prix,:date,:image,:views,:comment,:tags)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([

                                ':id' =>  $product_category_id,
                                ':title' => $product_title,
                                ':detail' => $product_detail,
                                ':prix' => $product_prix,
                                ':date' => date("M n, Y") . ' at ' . date("h:i A"),
                                ':image' => $product_image_id,
                                ':views' => 0,
                                ':comment' => 0,
                                ':tags' => $product_tags

                            ]);
                                header("Location: all-post.php");
                        }

                     ?>

                    <!--Start Form-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Create New Product</div>
                            <div class="card-body">
                                <form action="add-new.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="post-title">Product Title:</label>
                                        <input name="product-title" class="form-control" id="post-title" type="text" placeholder="Product title ..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="post-title">Product Prix:</label>
                                        <input name="product-prix" class="form-control" id="post-title" type="text" placeholder="Product prix ..." />
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

                                                    <option value="<?php echo $cats['category_id']; ?>"> <?php echo $cats['category_name']; ?></option>

                                                <?php }

                                             ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="post-title">Choose photo:</label>
                                        <input name="product-photo" class="form-control" id="post-title" type="file" />
                                    </div>

                                    <div class="form-group">
                                        <label for="post-content">Product Details:</label>
                                        <textarea name="product-detail" class="form-control" placeholder="Type here..." id="post-content" rows="9"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="post-tags">Product Tags:</label>
                                        <textarea name="product-tags" class="form-control" placeholder="Tags..." id="post-tags" rows="3"></textarea>
                                    </div>
                                    <button name="new-product" class="btn btn-primary mr-2 my-1" type="submit">Submit now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Form-->

                </main>

<?php require_once('./includes/footer.php'); ?>