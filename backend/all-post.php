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
                                    <div class="page-header-icon"><i data-feather="layout"></i></div>
                                    <span>All Products</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">All Products</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Prix</th>
                                                <th>Category</th>
                                                <th>Image</th>
                                                <th>Date</th>
                                                <th>Details</th>                                                
                                                <th>Comments</th>
                                                <th>Views</th>
                                                <th>Tags</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tfoot> 
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Prix</th>
                                                <th>Category</th>
                                                <th>Image</th>
                                                <th>Date</th>
                                                <th>Details</th>                                                
                                                <th>Comments</th>
                                                <th>Views</th>
                                                <th>Tags</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            <?php

                                                    if(isset($_POST['delete']))
                                                    {
                                                        $product_id = $_POST['prod-id'];
                                                        $sql = "DELETE FROM products WHERE product_id = :id";
                                                        $stmt = $pdo->prepare($sql);
                                                        $stmt->execute([':id' => $product_id] );

                                                        header("Location: all-post.php");

                                                    }

                                             ?>

                                            <?php

                                                $sql = "SELECT * FROM products";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute();

                                                while($product = $stmt->fetch(PDO::FETCH_ASSOC))
                                                {

                                                    $product_id = $product['product_id'];
                                                    $product_title = $product['product_title'];
                                                    $product_detail = substr($product['product_detail'],0,10);
                                                    $product_prix = $product['product_prix'];
                                                    $product_date = $product['product_date'];
                                                    $product_tags = $product['product_tags'];
                                                    // we need the id of the category for bring back the name of it 
                                                    $product_category_id = $product['product_category_id'];

                                                    // we nned the id of the image fot bring back the path of the it
                                                    $product_image_id = $product['product_image_id'];
                                                    $product_views = $product['product_views'];
                                                    $product_comment_count = $product['product_comment_count'];

                                                    // bring back category_name

                                                    $sql1 = "SELECT * FROM categories WHERE category_id = :id";
                                                    $stmt1 = $pdo->prepare($sql1);
                                                    $stmt1->execute([':id' => $product_category_id]);
                                                    $category = $stmt1->fetch(PDO::FETCH_ASSOC);
                                                    $product_cat_name = $category['category_name'];

                                                    // bring back image 

                                                    $sql2 = "SELECT * FROM photos WHERE photo_id = :id";
                                                    $stmt2 = $pdo->prepare($sql2);
                                                    $stmt2->execute([':id' => $product_image_id] );
                                                    $photo = $stmt2->fetch(PDO::FETCH_ASSOC);

                                                    $product_image = $photo['photo_img'];

                                                    ?> 

                                                    <tr>
                                                        <td><?php echo $product_id; ?></td>
                                                        <td>
                                                            <a href="../single.php?post_id=<?php echo $product_id; ?>" target="_blank"><?php echo $product_title; ?></a>
                                                        </td>
                                                        <td><?php echo $product_prix; ?></td>
                                                        <td><?php echo $product_cat_name; ?></td>
                                                        <td>
                                                            <img src="../img/<?php echo $product_image; ?>" height="50" width ="50">    
                                                        </td>
                                                        <td><?php echo $product_date; ?></td>
                                                        <td><?php echo $product_detail; ?></td>
                                                        <td>
                                                            <a href="comments.php"><?php echo $product_comment_count; ?></a>
                                                        </td>
                                                        <td><?php echo $product_views; ?></td>
                                                        <td><?php echo $product_tags; ?></td>
                                                        <td>
                                                            <form action="edit-post.php" method="POST">
                                                                
                                                                <input type="hidden" name="product-id" value="<?php  echo $product_id; ?>" >
                                                                <button name="edit-product" type="submit" class="btn btn-blue btn-icon"><i data-feather="edit"></i></button>

                                                            </form>
                                                            
                                                        </td>
                                                        <td>
                                                            <form action="all-post.php" method="POST">
                                                                <input type="hidden" name="prod-id" value="<?php echo $product_id; ?>">
                                                                <button name="delete" type="submit" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                            </form>
                                                            
                                                        </td>
                                                    </tr>  




                                                <?php }



                                             ?>

                                            
                                                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->

                </main>

<?php require_once('./includes/footer.php'); ?>