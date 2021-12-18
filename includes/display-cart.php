

 <?php


        if(isset($_COOKIE['_uid_']) || isset($_COOKIE['_uiid_']) || isset($_SESSION['login']) )
        { ?>



             <!-- shopping-cart *** -->

                <li class="nav-item dropdown no-caret mr-3 dropdown-notifications">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shopping-cart " style="font-size: 20px"></i>


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


                            $sql = "SELECT * FROM cart WHERE cart_user_id = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([':id' => $user_id ]);
                            $count = $stmt->rowCount();

                            if($count != 0)
                            { ?>
                                <span class="badge badge-red" style="font-size: 10px; margin-left: -2px;margin-top: -5px"><?php echo $count; ?></span>
                            <?php }


                         ?>
                        
                    </a>

                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                        <h6 class="dropdown-header dropdown-notifications-header">
                            <i class="fas fa-shopping-cart mr-3" style="font-size: 20px"></i>
                            CART
                        </h6>

                            <?php


                                $sql = "SELECT * FROM cart WHERE cart_user_id = :id ORDER BY cart_id DESC LIMIT 0,1";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([':id' => $user_id ]);
                                while($cart = $stmt->fetch(PDO:: FETCH_ASSOC))
                                { 

                                    $product_id = $cart['cart_product_id'];
                                    $sql1 = "SELECT * FROM products WHERE product_id = :id";
                                    $stmt1 = $pdo->prepare($sql1);
                                    $stmt1->execute([':id' => $product_id ]);
                                    $product = $stmt1->fetch(PDO::FETCH_ASSOC);
                                    // get the title of the product 
                                    $product_title = $product['product_title'];
                                    $product_detail = substr($product['product_detail'],0,100);
                                    // get the image _id 
                                    $image_id = $product['product_image_id'];
                                    $sql2 = "SELECT * FROM photos WHERE photo_id =:id";
                                    $stmt2 = $pdo->prepare($sql2);
                                    $stmt2->execute([':id' => $image_id ]);
                                    $image = $stmt2->fetch(PDO:: FETCH_ASSOC);
                                    $photo = $image['photo_img'];



                                    ?>

                                    <div class="dropdown-notification" style="margin-left: -30px; margin-top: 20px; margin-bottom: 20px" >

                                        <img style="border-radius: 10px" src="./img/<?php echo $photo; ?>" width="80" height="70">
                                        <a style="font-weight: bolder; font-size: 15px" class="ml-4" href="cart-money.php"> 
                                            
                                            <?php echo $product_title; ?> 
                                        </a>
                                        <p  style="font-weight: bolder; font-size: 15px; float: right;">
                                                <?php echo $cart['cart_date']; ?>
                                        </p>
                                        
                                        <!-- <p class="justify-content-between mb-2" ><i><?php echo $product_detail; ?></i></p> -->   
                                    </div>
                                    
                                    
                                <?php }
                            ?>
                            <?php

                                if($count == 0)
                                { ?>

                                    <h4 class="text-align" style="text-align: center; padding: 10px ; font-weight: bold;"> Your cart is empty !</h4>

                                <?php }

                                else if($count > 1 )
                                { ?>
                                    <hr>
                                    <a class="badge badge-light" style="margin-left: 100px; font-size: 20px; font-weight: bold;" href="cart-money.php">
                                        View All 
                                    </a>
                                    <br><br>
                                <?php }

                             ?>
                            
                    </div>
                </li>    
       <!-- End Shopping-cart -->    
        <?php } 
?>