<?php ob_start(); ?>
<?php session_start(); ?>
<?php $current_page = "My Orders" ?>
<?php require_once("./includes/db.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content />
    <meta name="author" content />
    <title><?php echo $current_page; ?> | Emagazine</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="img/mdabarik.jpg" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"/>


    <link rel="stylesheet" type="text/css" href="css/style-cart-money.css">
    <link href="css/style-number.css" rel="stylesheet" />
</head>
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

                    			<br><br>
			                   <div class="px-4 px-lg-0">
						 		 
								  

								  <div class="pb-5">
								    <div class="container">
								      <div class="row">
								        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

								          <!-- Shopping cart table -->
								          <div class="table-responsive">
								            <table class="table">
								              <thead>
								                <tr>
								                  <th scope="col" class="border-0 bg-light">
								                    <div class="p-2 px-3 text-uppercase">Product</div>
								                  </th>
								                  <th scope="col" class="border-0 bg-light">
								                    <div class="py-2 text-uppercase">Price</div>
								                  </th>
								                  <th scope="col" class="border-0 bg-light">
								                    <div class="py-2 text-uppercase">Quantity</div>
								                  </th>
								                  <th scope="col" class="border-0 bg-light">
								                    <div class="py-2 text-uppercase">Status</div>
								                  </th>
								                </tr>
								              </thead>
								              <tbody>

								<?php


			                    	if(isset($_COOKIE['_uid_']) || isset($_COOKIE['_uiid_']) || isset($_SESSION['login']) )
			                    	{ ?>

			 							<?php


			                                $sql = "SELECT * FROM orders WHERE ord_user_id = :id ORDER BY ord_id DESC";
			                                $stmt = $pdo->prepare($sql);
			                                $stmt->execute([':id' => $user_id ]);
			                                $count_p = $stmt->rowCount();
			                                if($count_p == 0)
			                                	{
			                                		header("Location: index.php");
			                                	}
			                                	
			                                while($orders = $stmt->fetch(PDO:: FETCH_ASSOC))
			                                { 

			                                    $product_id = $orders['ord_prod_id'];
			                                    $qte = $orders['ord_qte'];
			                                    $ord_status = $orders['ord_status'];
			                                    $sql1 = "SELECT * FROM products WHERE product_id = :id";
			                                    $stmt1 = $pdo->prepare($sql1);
			                                    $stmt1->execute([':id' => $product_id ]);
			                                    $product = $stmt1->fetch(PDO::FETCH_ASSOC);
			                                    // get the title, detail ,price of the product 
			                                    $product_title = $product['product_title'];
			                                    
			                                    $product_prix = $product['product_prix'];
			                                    $product_category_id = $product['product_category_id'];
			                                    $product_red = $product['product_red'];
			                                    // get the image _id 
			                                    $image_id = $product['product_image_id'];
			                                    $sql2 = "SELECT * FROM photos WHERE photo_id =:id";
			                                    $stmt2 = $pdo->prepare($sql2);
			                                    $stmt2->execute([':id' => $image_id ]);
			                                    $image = $stmt2->fetch(PDO:: FETCH_ASSOC);
			                                    $photo = $image['photo_img'];
			                                    // bring back the category :
			                                    $sql3 = "SELECT * FROM categories WHERE category_id = :id";
			                                    $stmt3 = $pdo->prepare($sql3);
			                                    $stmt3->execute([':id' => $product_category_id]);
			                                    $category = $stmt3->fetch(PDO::FETCH_ASSOC);
			                                    // and we have now the category name 
			                                    $category_name = $category['category_name'];
			                                     ?>



								                <tr>
								                  <th scope="row" class="border-0">
								                    <div class="p-1">
								                      <img src="./img/<?php echo $photo; ?>" alt="" width="80" class="img-fluid rounded shadow-sm">
								                      <div class="ml-3 d-inline-block align-middle">
								                        <h5 class="mb-0"> <a href="single.php?post_id=<?php echo $product_id; ?>" class="text-dark d-inline-block align-middle"><?php echo $product_title; ?></a></h5><span class="text-muted font-weight-normal font-italic d-block">Category: <?php echo $category_name; ?></span>
								                      </div>
								                    </div>
								                  </th>

								                  <td class="border-0 align-middle">
								                  	<?php

								                  		$pr_new_price = ($product_prix * (1 - $product_red)) * $qte ;


								                  	 ?>
								                  	<strong><?php echo $pr_new_price; ?> MAD</strong>
								                  </td>

								      
								                  <td class="border-0 align-middle">

								                  	<h4><strong class="ml-4" style="color: red" ><?php echo $qte; ?></strong></h4>   
								                  </td>
								                  
							                  	<td>

	                                                <div class="badge badge-<?php echo $ord_status=="passed order"?"success":"danger"; ?> mt-5">
	                                                    <?php echo $ord_status; ?>
	                                                </div>
	                                            </td>	 
								               </tr>

								            <?php }
								            ?>

			                	<?php } else 
			                    	{
			                    		header("Location: index.php");
			                    	}
			                   ?> 	
                    

								              </tbody>
								              
								            </table>
								          </div>				          
								                
								          <!-- End -->
								        </div>
								      </div>

								    </div>
								  </div>
								</div>

								<!-- End Of our content   -->          


                </main>
            </div>
        </div>    

            <div id="layoutDefault_footer">
                <footer class="footer pt-2 pb-4 mt-auto bg-white footer-black">
                    <div class="container">
                        <hr class="mb-1" />
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