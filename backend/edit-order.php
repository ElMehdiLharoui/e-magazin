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

                    if(isset($_POST['edit-order']))
                    {
                        $order_id = $_POST['ord-id'];
                        $url = "http://localhost/DevZiko/backend/edit-order.php?order_id=".$order_id;
                        header("Location:{$url} ");
                    }
                 ?>

                 <?php

                    if(isset($_GET['order_id']))
                    {
                        $order_id = $_GET['order_id'];
                        $sql = "SELECT * FROM orders WHERE ord_id = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':id' => $order_id]);
                        $order = $stmt->fetch(PDO::FETCH_ASSOC);
                        $order_status = $order['ord_status'];

                    }

                  ?>

                  <?php

                        if(isset($_POST['update-ord']))
                        {
                            
                            
                            $ord_status = $_POST['order-status'];
                            $sql ="UPDATE orders SET ord_status=:status WHERE ord_id = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([

                                ':status' => $ord_status,
                                ':id' => $_GET['order_id']

                            ]);
                                header("Location: pages.php");
                        }

                     ?>


            <div id="layoutSidenav_content">
                <main>
                    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                                    <span>Try Updating Order</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Update order status</div>
                            <div class="card-body">
                                <form action="edit-order.php?order_id=<?php echo $_GET['order_id']; ?>" method="POST">
                                    
                                    
                                    <div class="form-group">
                                        <label for="select-category">Select status:</label>
                                        <select name="order-status" class="form-control" id="select-category">

                                            <?php

                                                $sql = "SELECT * FROM etats";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute();


                                                while($etats = $stmt->fetch(PDO::FETCH_ASSOC))
                                                { ?>

                                                    <option value="<?php echo $etats['etat_status']; ?> " >

                                                        <?php echo $etats['etat_status']; ?>
                                                         
                                                    </option>

                                                <?php }

                                             ?>
                                           
                                        </select>
                                    </div>
                                    
                                    <button name="update-ord" class="btn btn-primary mr-2 my-1" type="submit">Submit now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->

                </main>

<?php require_once('./includes/footer.php'); ?>