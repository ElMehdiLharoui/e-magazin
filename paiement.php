<?php ob_start(); ?>
<?php session_start(); ?>
<?php $current_page = "CART-BUY" ?>
<?php require_once("./includes/db.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content />
    <meta name="author" content />
    <title><?php echo $current_page; ?> | Emagazine</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="img/mdabarik.jpg" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" />
    <link rel="stylesheet" type="text/css" href="css/style-cart-money.css">
    <link rel="stylesheet" type="text/css" href="css/style-pop.css">
    <link href="css/style-number.css" rel="stylesheet" />
 
    
</head>


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
                            {
                                // its ok  
                            }
                            else
                            {
                                header("Location: index.php");
                            }


                         ?>

<body>

        <div id="layoutDefault">
            <div id="layoutDefault_content">
                <main>

                    <nav class="navbar navbar-marketing navbar-expand-lg bg-white  navbar-light">
                        <div class="container">
                            <a class="navbar-brand text-dark" href="index.php">Emagazine</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <img src="img/menu.png" style="height:20px;width:25px" /><i data-feather="menu"></i>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto mr-lg-5">
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php">Home </a>
                                    </li>
                                    <li class="nav-item dropdown no-caret">
                                        <a class="nav-link" href="contact.php">Contact</a>
                                    </li>
                                    <li class="nav-item dropdown no-caret">
                                        <a class="nav-link" href="about.php">About</a>
                                    </li>

                                    <!-- For displaying the cart of the client! -->

                                   <?php require_once("./includes/display-cart.php"); ?>

                                </ul>    

                  
                                
                                <?php 
                                    $curr_page = basename(__FILE__);
                                    require_once("./includes/registration.php");
                                ?>

                            </div>
                        </div>
                    </nav>


                    		<!-- Start Of our content   -->

                    			<br>
			                   <div class=" px-4 px-lg-2 mr-10 ml-10">
						 		 
								  
								      <div class="row py-5 p-1 bg-light rounded shadow-sm">
								        
                                        <div class="col-lg-6">
								          <div class="bg-info rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
								          <div class="p-4">
								            <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>
								            <div class="input-group mb-4 border rounded-pill p-2">
								              <input style="border-radius: 15px;" type="text" placeholder="Apply coupon" aria-describedby="button-addon3" class="form-control border-2">
								              <div class="input-group-append border-0">
								                <button id="button-addon3" type="button" class="btn btn-warning ml-2 px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Apply coupon</button>
								              </div>
								            </div>
								          </div>

                                    	</div>

                                        
								        <div class="col-lg-6">
								          <div class="bg-info rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary </div>
								          <div class="p-4">


								            <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p>
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

                                    $sql = "SELECT * FROM cart where cart_user_id =:id ";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([':id' => $user_id]);
                                    $somme = 0;
                                    while($cart = $stmt->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $cart_qte = $cart['cart_qte'];
                                        $sql1 = "SELECT * FROM products where product_id = :id";
                                        $stmt1 = $pdo->prepare($sql1);
                                        $stmt1->execute([':id' => $cart['cart_product_id']]);
                                        $product = $stmt1->fetch(PDO::FETCH_ASSOC);

                                        $price = $product['product_prix'] * (1 - $product['product_red']);
                                        $price = $price * $cart_qte;
                                        $somme = $somme + $price;
                                        
                                    }
                                    
                                    ?>
                                    <ul class="list-unstyled mb-4">
                                      <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong><?php echo $somme.' MAD'; ?></strong></li>
                                      <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping and handling</strong><strong>0.00</strong></li>
                                      <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax</strong><strong>0.00</strong></li>
                                      <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                                        <h5 class="font-weight-bold"><?php echo $somme.' MAD'; ?></h5>
                                      </li>
                                    </ul>

                                 
                                    <div class="d-flex justify-content-center ">
                                        <a href="payment-card.php">
                                            <button class="btn btn-danger py-2 px-4" ><b>Card Payment</b><i class="far fa-credit-card ml-2"></i>
                                            </button>
                                        </a>
                                        <a href="check-payment.php">
                                            <button class="btn btn-secondary py-2 px-4 ml-2 " ><b>Check Payment</b> <i class="fas fa-money-check"></i>
                                            </button>
                                        </a>
                                        <center>
                                            <div class="popup center">
                                              <div class="icon">
                                                <i class="fa fa-check"></i>
                                              </div>
                                              <div class="title">
                                                Success
                                              </div>
                                              <div class="description">
                                                 CASH on delivery. 
                                              </div>
                                              <div class="dismiss-btn">

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

                                                    if(isset($_POST['cash']))
                                                    {  


                                                        $sql = "SELECT * FROM cart where cart_user_id = :id";
                                                        $stmt = $pdo->prepare($sql);
                                                        $stmt->execute([':id' => $user_id]);
                                                        

                                                       
                                                         while($cart = $stmt->fetch(PDO::FETCH_ASSOC))
                                                            { 

                                                                $cart_prod_id = $cart['cart_product_id'];
                                                                $cart_prod_qte = $cart['cart_qte'];

                                                                $sql1 = "SELECT * FROM products where product_id = :id";
                                                                $stmt1 = $pdo->prepare($sql1);
                                                                $stmt1->execute([':id' => $cart_prod_id]);
                                                                $product = $stmt1->fetch(PDO::FETCH_ASSOC);

                                                                $price = $product['product_prix'] * (1 - $product['product_red']);
                                                                $price = $price * $cart_prod_qte;
                                                                

                                                                
                                                                // if it exist in the orders
                                                                $sql = "INSERT INTO orders (ord_prod_id, ord_user_id,ord_date,ord_qte,ord_price,ord_status) VALUES (:id,:u_id,:date,:qte,:price,:status)";
                                                                $stmt = $pdo->prepare($sql);
                                                                $stmt->execute([

                                                                    ':id' => $cart_prod_id,
                                                                    ':u_id' => $user_id,
                                                                    ':date' => date("M n, Y") . ' at ' . date("h:i A"),
                                                                    ':qte' => $cart_prod_qte,
                                                                    ':price' => $price,
                                                                    ':status' => 'passed order'

                                                                ]);

                                                                $sql1 = "DELETE FROM cart where cart_user_id = :id";
                                                                $stmt1 = $pdo->prepare($sql1);
                                                                $stmt1->execute([':id' => $user_id]); 
                                                                header("Refresh:1;url=index.php");
                                                            }
                                                           
                                                    }

                                                ?>
                                                <form action="paiement.php" method="POST">
                                                    
                                                    <button id="dismiss-popup-btn" type="submit" name="cash">
                                                      Dismiss
                                                    </button>
                                                </form>
                                                
                                              </div>
                                            </div>
                                        </center>

                                        
                                        <button id="open-popup" class="btn btn-pink py-2 px-4 ml-2 " name="cash" ><b>Cash Payment</b> <i class="fas fa-cash-register"></i>
                                        </button>
                                        
                                        
                                        
                                    </div>
                                    
                                    
                                            

								          </div>
								        </div>
								      </div>

								    </div>
								  </div>
								</div>
								    
								<!-- End Of our content   -->          
                        

                </main>
                         
            </div>
                            

                <div id="layoutDefault_footer">
                <footer style="background-color: #fbedd6" class="footer pt-4 pb-4 mt-auto footer-secondary">
                    <div class="container">
                        <hr class="my-1" />
                        <div class="row align-items-center">
                            <div class="col-md-6 small">Copyright &#xA9; Emagazine 2021</div>
                            <div class="col-md-6 text-md-right small">
                                <a href="privacy-policy.php">Privacy Policy</a>
                                &#xB7;
                                <a href="terms-conditions.php">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>


        <script src="js/script-pop.js"></script>
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/js-number.js"></script>
    </body>
</html>
