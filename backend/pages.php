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
                                    <div class="page-header-icon"><i data-feather="book-open"></i></div>
                                    <span>All Orders</span>
                                </h1>
                                
                            </div>
                        </div>
                    </div>
                    <!--Table-->
                    <div class="container-fluid mt-n10">

                        <div class="card mb-4">
                            <div class="card-header">All Orders</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                
                                                <th>User Name</th>
                                                <th>Product Title</th>
                                                <th>Photo</th>
                                                <th>Quantity</th>
                                                <th>Passed on</th>
                                                <th>Status</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                                if(isset($_COOKIE['_uid_']))
                                                {
                                                    $user_id = base64_decode($_COOKIE['_uid_']);

                                                }else if(isset($_SESSION['user_id']))
                                                {
                                                    $user_id = $_SESSION['user_id'];
                                                }
                                                else
                                                {
                                                    $user_id = -1;
                                                }
                                            ?>    


                                            <?php 
                                                
                                                $sql = "SELECT * FROM orders";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute();
                                                                                          

                                                while($orders = $stmt->fetch(PDO::FETCH_ASSOC))
                                                {   
                                                    
                                                    $ord_id = $orders['ord_id'];
                                                    $ord_user_id = $orders['ord_user_id'];
                                                    $ord_prod_id= $orders['ord_prod_id'];
                                                    // bring back the quantity of each product ordered
                                                    $ord_qte = $orders['ord_qte'];
                                                    // date 
                                                    $ord_date = $orders['ord_date'];
                                                    // status
                                                    $ord_status = $orders['ord_status'];


                                                    $sql4 = "SELECT * FROM users WHERE user_id = :id";
                                                    $stmt4 = $pdo->prepare($sql4);
                                                    $stmt4->execute([':id'=> $ord_user_id]);
                                                    $user = $stmt4->fetch(PDO::FETCH_ASSOC);
                                                    $username = $user['user_name'];

                                                    

                                                    $sql3= "SELECT * from products where product_id = :id";
                                                    $stmt3 = $pdo->prepare($sql3);
                                                    $stmt3->execute([':id' => $ord_prod_id]);
                                                    $product = $stmt3->fetch(PDO::FETCH_ASSOC);
                                                    $product_title = $product['product_title'];
                                                    $product_image_id = $product['product_image_id'];

                                                    $sql2 = "SELECT * FROM photos WHERE photo_id = :id";
                                                    $stmt2 = $pdo->prepare($sql2);
                                                    $stmt2->execute([':id' => $product_image_id] );
                                                    $photo = $stmt2->fetch(PDO::FETCH_ASSOC);

                                                    $product_image = $photo['photo_img'];
                                                     ?>

                                                    

                                                    <tr>
                                                        
                                                        <td><?php echo $username; ?></td>
                                                        <td><?php echo $product_title; ?></td>
                                                        <td>
                                                            <img src="../img/<?php echo $product_image; ?>" height="50" width ="50">    
                                                        </td>
                                                        <td><?php echo $ord_qte; ?></td>
                                                        <td><?php echo $ord_date; ?></td>
                                                        <td>
                                                            <div class="badge badge-<?php echo $ord_status=="passed order"?"success":"danger"; ?>">
                                                                <?php echo $ord_status; ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <form action="edit-order.php" method="POST">
                                                                <input type="hidden" name="ord-id" value="<?php echo $ord_id; ?>">
                                                                <button name="edit-order" type="submit" class="btn btn-blue btn-icon"><i data-feather="edit"></i></button>
                                                            </form>
                                                            
                                                        </td>
                                                        <td>
                                                            <?php 

                                                                    if(isset($_POST['delete']))
                                                                    {
                                                                        $order_id = $_POST['ord_id'];
                                                                        $sql = "DELETE from orders where ord_id = :id";
                                                                        $stmt = $pdo->prepare($sql);
                                                                        $stmt->execute([':id' => $order_id]);
                                                                        header("Location: pages.php");
                                                                    }
                                                            ?>
                                                            <form action="pages.php" method="POST">
                                                                <input type="hidden" name="ord_id" value="<?php echo $ord_id; ?>">
                                                                <button type="submit" name="delete" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                            </form>
                                                            
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