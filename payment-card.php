<?php $current_page = "Payment page"; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
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
    <link rel="stylesheet" type="text/css" href="css/style-card.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,600;1,300&display=swap" rel="stylesheet"> 
    
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
                    
                    <nav class="navbar navbar-marketing navbar-expand-lg bg-white navbar-light">
                        <div class="container">
                            <a class="navbar-brand text-dark" href="index.php">Zack</a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><img src="./img/menu.png" style="height:20px;width:25px" /><i data-feather="menu"></i></button>
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

                            
                        <?php

                               if(isset($_POST['card'])) {

                                        if(empty($_POST['number']) || empty($_POST['month']) || empty($_POST['year']) || empty($_POST['cvc']) 
                                                || empty($_POST['name']) || empty($_POST['email']) )
                                            {
                                                $error_cas = "GO FILL IN the cases";
                                            }

                                        else 
                                        {
                                            $email = trim($_POST['email']);
                                        $sql = "SELECT * FROM users WHERE user_email = :email";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute([
                                            ':email' => $email
                                        ]);
                                        $count = $stmt->rowCount();
                                        if($count == 0) {
                                            $error = "Wrong credentials!";
                                        } else if($count > 1) {
                                            $error = "Wrong credentials!";
                                        } else if($count == 1) {


                                            $success = "Payment is successful!";


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
                                            
                                        }
                                    
                                }

                         ?>

                        <form class="form1" action="payment-card.php" method="POST" >
                            <h1>Payement</h1>
                                <?php
                                        if(isset($success)) {
                                            echo "<p class='alert alert-success'>{$success}</p>";
                                        }
                                        else if(isset($error))  {
                                            echo "<p class='alert alert-danger'>{$error}</p>";
                                        }else if( isset($error_cas))
                                        {
                                            echo "<p class='alert alert-danger'>{$error_cas}</p>";
                                        } 
                                    ?>

                                
                                <label for="name">Payer name </label><br>
                                <input class="box1" type="text" name="name" id="name" placeholder="Enter your name"><br>
                                <label for="Pemail">Email</label><br>
                                <input class="box1" type="email" name="email" id="email" placeholder="Enter your email"><br>
                                <label for="cardnum">Card Number</label><br>
                                <input class="box1" type="number" name="number" id="number" placeholder="1234 1234 1234 1234"><br>
                                
                                
                                
                                <div class="div1">
                                    <label for="cardex">Card expiry month</label><br>
                                    <input class="box2" type="month" name="month" id="month" placeholder="MM"><br>
                                </div>
                                <div class="div1">
                                    <label for="cardye">Card expiry year</label><br>
                                    <input class="box2" type="year" name="year" id="year" placeholder="yyyy"><br>
                                </div>
                                <div class="div1">
                                    <label for="cardCVC">Card CVC</label><br>
                                    <input class="box2" type="cvc" name="cvc" id="cvc" placeholder="cvc"><br>
                                </div>

                                <button style="display: table; margin-bottom: 5px" class="btnn" type="submit" name="card"> Confirm and Pay </button>
                                <a href="paiement.php"><button style="display: table" class="btnn" type="button">Close</button></a>                      
                        </form>
                    
                        

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

<?php require_once("./includes/footer.php"); ?>