 <?php                            
    if(isset($_COOKIE['_uid_']) || isset($_COOKIE['_uiid_']) || isset($_SESSION['login']) )
    { ?>

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

                if(isset($_POST['submit']))
                {
                    

                    $product_id = $_POST['product_id'];


                    $sql1 = "SELECT * FROM cart WHERE cart_product_id = :id AND cart_user_id = :id_u";
                    $stmt1 =$pdo->prepare($sql1);
                    $stmt1->execute([':id' => $product_id, ':id_u' => $user_id ]);
                    $count_product= $stmt1->rowCount();

                    if($count_product == 0)
                    {
                        
                        $sql = "INSERT INTO cart (cart_product_id, cart_user_id, cart_date ,cart_qte ) VALUES (:id_c, :id_u, :date, :qte )";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([

                            ':id_c' => $product_id,
                            ':id_u' =>  $user_id,
                            ':date' => date("M n, Y") . ' at ' . date("h:i A"),
                            ':qte' => 1
                        ]);

                        header("Location: index.php");

                            //  $url = "https://localhost/DevZiko/";
                            // if(isset($_GET['category_id']))
                            // {
                                
                            //     $cat_id = $_GET['category_id'];
                            //     $cat_name= $_GET['category_name'];
                            //     $url.="categories.php";
                            //     $url.="?category_id".$cat_id."?category_name".$cat_name;
                            // }
                            // else
                            // {
                            //     $url.="index.php";
                                
                            // }

                    } else
                    {
                        // $message = "The Product is already exist in the cart!";
                        // echo "<script> alert('$message')</script>";
                    }

                }
             ?>


    

    <form action="index.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    
        <button name="submit" class="btn btn-orange btn-block btn-marketing rounded-pill" type="submit" >Add to Cart <i class="fas fa-cart-plus ml-2" style="font-size: 18px" ></i>
        </button>

    </form>     


    <?php }
?>