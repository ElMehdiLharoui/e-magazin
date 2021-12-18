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

                        if(isset($_POST['confirm']))
                        {

                            if(empty($_POST['sum']))
                            {
                                $error_empty="GO FILL IN THE CASE ";
                            }
                            else
                            {
                                $somme = $_POST['sum'];

                                $sql = "SELECT * FROM orders where ord_user_id =:id and ord_status =:status ";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([':id' => $user_id, ':status' => 'passed order' ]);

                                $sum_ord = 0;
                                while($orders = $stmt->fetch(PDO::FETCH_ASSOC))
                                {
                                    $sum_ord = $sum_ord + $orders['ord_price'];
                                }

                                
                                if($somme < 0)
                                {
                                    $error_neg = "Vous avez entré une somme négatif!";
                                }
                                else if($somme == $sum_ord )
                                {
                                    $msgpay= "vous avez payé votre commande";
                                }
                                else
                                {
                                    $tranche = $sum_ord/$somme;
                                    $message = "Vous allez payez ". $tranche ." par mois!";
                                }
                            }
                            


                        }

                     ?>

                    <div style="margin-top: 100px">
                        <form action="check-payment.php" method="POST" class="form1">
                            <?php

                                if(isset($error_empty))
                                {
                                    echo "<p class='alert alert-danger text-md-center'>{$error_empty}</p>";
                                }
                                if(isset($error_neg))
                                {
                                    echo "<p class='alert alert-danger text-md-center'>{$error_neg}</p>";
                                }
                                else if(isset($msgpay))
                                {
                                    echo "<p class='alert alert-success text-md-center'>{$msgpay}</p>";
                                }
                                else if(isset($message))
                                {
                                    echo "<p class='alert alert-orange text-md-center'>{$message}</p>";
                                }
                             ?>
                            <h1>Check Payement</h1>
                            <label for="name">Check </label><br>
                            <input class="box1" type="text" name="sum" id="name" placeholder="Enter your check sum"><br>
                            <label for="Pemail">IL vous reste : </label><br>
                            <input class="box1" type="email" name="email" value="0" readonly><br>
                            

                            <button class="btnn" name="confirm" type="submit"> Confirm and Pay </button>
                            <a href="paiement.php"><button class="btnn" type="button">Close</button></a>                      
                        </form>
                    </div>
                        
                    
                            
                    

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