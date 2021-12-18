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
                                    <div class="page-header-icon"><i data-feather="activity"></i></div>
                                    <span>Dashboard</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Table-->
                    <div class="container-fluid mt-n10">

                    <!--Card Primary-->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <p>All Products</p>

                                    <?php

                                        $sql = "SELECT * FROM products";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $product_count= $stmt->rowCount();
                                    ?>
                                    <p><?php echo $product_count; ?></p>

                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="all-post.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <p>Comments</p>

                                    <?php

                                        $sql = "SELECT * FROM comments";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $comment_count= $stmt->rowCount();
                                    ?>
                                    <p><?php echo $comment_count; ?></p>

                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="comments.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <!-- Début des commandes  -->    
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-info text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <p>Orders</p>

                                    

                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="pages.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin des commandes  --> 


                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <p>Categories</p>

                                    <?php

                                        $sql = "SELECT * FROM categories ";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $category_count= $stmt->rowCount();
                                    ?>
                                    <p><?php echo $category_count; ?></p>

                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="categories.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <p>Users</p>

                                    <?php

                                        $sql = "SELECT * FROM users ";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $user_count= $stmt->rowCount();
                                    ?>
                                    <p><?php echo $user_count; ?></p>

                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="users.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Card Primary-->

                        <div class="card mb-4">
                            <div class="card-header">Most Popular Products:</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">

                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product Title</th>
                                                <th>Product Category</th>
                                                <th>Total Views</th>
                                                <th>Photo</th>
                                                <th>Posted On</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                                $sql = "SELECT * from products ORDER BY product_views DESC LIMIT 0,5";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute();

                                                while($products = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                                    $product_image_id = $products['product_image_id'];

                                                    $sql5 = "SELECT * FROM photos WHERE photo_id = :id";
                                                    $stmt2 = $pdo->prepare($sql5);
                                                    $stmt2->execute([
                                                        ':id' => $product_image_id
                                                    ]);
                                                    $photo = $stmt2->fetch(PDO::FETCH_ASSOC);


                                                    $product_id = $products['product_id'];
                                                    $product_title = $products['product_title'];
                                                    $product_detail = substr($products['product_detail'], 0, 140);
                                                    $product_prix = $products['product_prix']; 
                                                    $product_date = $products['product_date'];
                                                    $product_views = $products['product_views'];
                                                    $product_image = $photo['photo_img'];
                                                    $product_category_id = $products['product_category_id'];


                                                    $sql1 = "SELECT * FROM categories WHERE category_id = :id ";
                                                    $stmt1 = $pdo->prepare($sql1);
                                                    $stmt1->execute([

                                                            ':id' => $product_category_id
                                                    ]);
                                                    $category = $stmt1->fetch(PDO::FETCH_ASSOC);
                                                    $category_title = $category['category_name'];
                                                ?>    

                                                        <tr>
                                                            <td><?php echo $product_id; ?></td>
                                                            <td>
                                                                <a href="../single.php?post_id=<?php echo $product_id; ?>" target="_blank">
                                                                    <?php echo $product_title; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $category_title; ?></td>
                                                            <td><?php echo $product_views; ?></td>
                                                            <td><img src="../img/<?php echo $product_image; ?>" height=70 width=80 style="margin-left: 40px" ></td>
                                                            <td><?php echo $product_date; ?></td>
                                                        </tr>
                                                <?php
                                                }
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