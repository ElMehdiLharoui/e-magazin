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
                            <div class="page-header-content d-flex align-items-center justify-content-between text-white">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="chevrons-up"></i></div>
                                    <span>Categories</span>
                                </h1>
                                <a href="new-category.php" title="Add new category" class="btn btn-white">
                                    <div class="page-header-icon"><i data-feather="plus"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--Table-->
                    <div class="container-fluid mt-n10">

                        <div class="card mb-4">
                            <div class="card-header">All Categories</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Category Name</th>
                                                <th>Total Products</th>
                                                <th>Created By</th>
                                                <th>Status</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 

                                                $sql = "SELECT * FROM categories";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute();

                                                while($category=$stmt->fetch(PDO::FETCH_ASSOC))
                                                {
                                                    $cat_id = $category['category_id'];
                                                    $cat_name= $category['category_name'];
                                                    $cat_total_product = $category['category_total_products'];
                                                    $cat_product_views = $category['total_products_views'];
                                                    $cat_status = $category['category_status'];
                                                    $cred_by = $category['created_by'];
                                                ?>
                                                    <tr>
                                                        <td><?php echo $cat_id; ?></td>
                                                        <td>
                                                            <?php 

                                                                    if($cat_total_product == 0)
                                                                    { 
                                                                    ?>

                                                                        <?php echo $cat_name; ?>

                                                                    <?php 
                                                                    } else
                                                                    { 
                                                                    ?>

                                                                        <a href="../categories.php?category_id=<?php echo $cat_id; ?>&category_name=<?php echo $cat_name; ?>" target="_blank" >
                                                                            <?php echo $cat_name; ?>
                                                                        </a>

                                                                    <?php 
                                                                    }
                                                            ?>
                                                            
                                                        </td>
                                                        <td><?php echo $cat_total_product; ?></td>
                                                        <td><?php echo $cred_by; ?></td>
                                                        <td>

                                                            <?php

                                                                if($cat_status == 'Published')
                                                                {
                                                                ?>

                                                                    <div class="badge badge-success"><?php echo $cat_status; ?>
                                                                    </div>

                                                                <?php
                                                                }
                                                                else
                                                                {?>

                                                                    <div class="badge badge-warning"><?php echo $cat_status; ?>
                                                                    </div>

                                                                <?php
                                                                }
                                                            ?>
                                                                
                                                        </td>
                                                        <td>
                                                            <form action="edit-category.php" method="POST">
                                                                <input type="hidden" name="edit-id" value="<?php echo $cat_id; ?>">
                                                                <button name="edit" type="submit" class="btn btn-blue btn-icon"><i data-feather="edit"></i></button>
                                                            </form>
                                                            
                                                        </td>
                                                        <td>
                                                            <?php 

                                                                if(isset($_POST['delete-category']))
                                                                {
                                                                    $sql = "DELETE FROM categories WHERE category_id = :id";
                                                                    $stmt= $pdo->prepare($sql);
                                                                    $stmt->execute([
                                                                        ':id' => $_POST['id']
                                                                    ]);
                                                                    header("Location: categories.php");
                                                                }
                                                            ?>

                                                            <?php 

                                                                if($cat_total_product == 0)
                                                                {
                                                                ?>
                                                                    <form action="categories.php" method="POST">
                                                                        <input type="hidden" name="id" value="<?php echo $cat_id; ?>">
                                                                        <button name="delete-category" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                                    </form>

                                                                <?php 
                                                                }
                                                                else
                                                                { ?>
                                                                    <button title="You can't delete a category having a product!" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                                <?php    
                                                                }
                                                            ?>
                                                            
                                                            
                                                        </td>
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
                </main>

<?php require_once('./includes/footer.php'); ?>