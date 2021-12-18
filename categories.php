<?php $current_page = "Categories"; ?>
<?php require_once("./includes/header.php"); ?>

        <div id="layoutDefault">
            <div id="layoutDefault_content">
                <main>

                    <nav class="navbar navbar-marketing navbar-expand-lg bg-white navbar-light">
                        <div class="container">
                            <a class="navbar-brand text-dark" href="index.php">Emagazine</a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><img src="img/menu.png" style="height:20px;width:25px" /><i data-feather="menu"></i></button>
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

                    <header class="page-header page-header-dark bg-secondary">
                        <div class="page-header-content">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-xl-8 col-lg-10 text-center">

                                        <h1 class="page-header-title">Welcome to <?php echo $_GET['category_name']; ?> Category</h1>
                                        <p class="page-header-text mb-5">Are you searching for some content that you haven't found yet? Try searching in the search box below!</p>
                                        <form class="page-header-signup mb-2 mb-md-0" action="category-search.php" method="POST">
                                            <div class="form-row justify-content-center">
                                                <div class="col-lg-6 col-md-8">
                                                    <div class="form-group mr-0 mr-lg-2">
                                                        <input name="search-keyword" class="form-control form-control-solid rounded-pill" type="text" placeholder="Search keyword..."/>
                                                        <input name="category-id" value="<?php echo $_GET['category_id']; ?>" type="hidden"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4"><button class="btn btn-teal btn-block btn-marketing rounded-pill" type="submit">Search</button></div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-waves text-white">
                            <svg class="wave" style="pointer-events: none" fill="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
                                <defs>
                                    <style>
                                        .a {
                                            fill: none;
                                        }
                                        .b {
                                            clip-path: url(#a);
                                        }
                                        .d {
                                            opacity: 0.5;
                                            isolation: isolate;
                                        }
                                    </style>
                                    <clipPath id="a"><rect class="a" width="1920" height="75" /></clipPath>
                                </defs>
                                <title>wave</title>
                                <g class="b"><path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48" /></g>
                                <g class="b"><path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10" /></g>
                                <g class="b"><path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24" /></g>
                                <g class="b"><path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150" /></g>
                            </svg>
                        </div>
                    </header>
                    <section class="bg-white py-10">
                        <!--Start-->
                        <div class="container">
                        <h1>Most popular product:</h1>
                        <hr />
                            <?php 
                            $sql4 = "SELECT * FROM products WHERE product_category_id = :id ORDER BY product_views DESC LIMIT 0, 1";
                            $stmt = $pdo->prepare($sql4);
                            $stmt->execute([
                                ':id' => $_GET['category_id']
                            ]);

                            $product = $stmt->fetch(PDO::FETCH_ASSOC);

                            $product_image_id = $product['product_image_id'];

                            $sql5 = "SELECT * FROM photos WHERE photo_id = :id";
                            $stmt1 = $pdo->prepare($sql5);
                            $stmt1->execute([
                                ':id' => $product_image_id
                            ]);
                            $photo = $stmt1->fetch(PDO::FETCH_ASSOC);
                            
                            
                            $product_id = $product['product_id'];
                            $product_title = $product['product_title'];
                            $product_detail = substr($product['product_detail'], 0, 300);
                            $product_prix = $product['product_prix'];
                            $product_date = $product['product_date'];
                            $product_image = $photo['photo_img'];
                            $product_red = $product['product_red'];
                        ?>
                            <a class="card post-preview post-preview-featured lift mb-5" href="single.php?post_id=<?php echo $product_id; ?>">
                                <div class="row no-gutters">
                                    <div class="col-lg-5"><div class="post-preview-featured-img" style='background-image: url("./img/<?php echo $product_image; ?>")'></div></div>
                                    <div class="col-lg-7">
                                        <div class="card-body">
                                            <div class="py-5">
                                                <h5 class="card-title"><?php echo $product_title; ?></h5>
                                                <p class="card-text">
                                                    <?php echo $product_detail; ?>
                                                </p>
                                            </div>
                                            <hr />
                                            <div class="post-preview-meta">
                                                
                                                <div class="post-preview-meta-details">
                                                    <div class="post-preview-meta-details-name mb-4">
                                                        
                                                                <?php

                                                                        if($product_red == 0.0)
                                                                        { ?>
                                                                          
                                                                          <?php echo $product_prix .' MAD'; ?>

                                                                        <?php }
                                                                        else
                                                                        { 
                                                                                $pr_new_price = $product_prix * (1 - $product_red);
                                                                                
                                                                            ?>
                                                                            
                                                                            <span><?php echo $pr_new_price.' MAD'; ?></span>
                                                                            <small>
                                                                                <s><small><b class="badge-pill"><?php echo $product_prix; ?> <small>MAD</small> </b></small></s>
                                                                            </small>

                                                                        <?php }

                                                                     ?>

                                                            
                                                    </div>
                                                    <div class="post-preview-meta-details-name">                                                                
                                                        
                                                        <!-- add to cart -->
                                                        <?php require_once("./includes/add-to-cart.php"); ?>

                                                    </div>
                                                    <div class="post-preview-meta-details-date"><?php echo $product_date; ?></div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <?php
                                $sql = "SELECT * FROM products WHERE product_category_id = :id";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([
                                    ':id' => $_GET['category_id']
                                ]);
                                $product_count = $stmt->rowCount();
                                $product_per_page = 3;
                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                    if($page == 1) {
                                        $page_id = 0;
                                    } else {
                                        $page_id = ($page * $product_per_page) - $product_per_page;
                                    }
                                } else {
                                    $page = 1;
                                    $page_id = 0;
                                }
                                $total_pager = ceil($product_count / $product_per_page);
                            ?>

                            <h1>Recent products:</h1>
                            <hr />
                            <div class="row">
                                <?php
                                    $sql = "SELECT * FROM products WHERE  product_category_id = :id ORDER BY product_id DESC LIMIT $page_id, $product_per_page";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([
        
                                        ':id' => $_GET['category_id']
                                    ]);
                                    while($products = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                        $product_image_id = $products['product_image_id'];

                                        $sql5 = "SELECT * FROM photos WHERE photo_id = :id";
                                        $stmt1 = $pdo->prepare($sql5);
                                        $stmt1->execute([
                                            ':id' => $product_image_id
                                        ]);
                                        $photo = $stmt1->fetch(PDO::FETCH_ASSOC);

                                        $product_id = $products['product_id'];
                                        $product_title = $products['product_title'];
                                        $product_detail = substr($products['product_detail'], 0, 140);
                                        $product_prix = $products['product_prix']; 
                                        $product_date = $products['product_date'];
                                        $product_views = $products['product_views'];
                                        $product_image = $photo['photo_img'];
                                        $product_red = $products['product_red'];
                                        ?>

                                            <div class="col-md-6 col-xl-4 mb-5">
                                                <a class="card post-preview lift h-100" href="single.php?post_id=<?php echo $product_id; ?>"
                                                    ><img class="card-img-top" src="./img/<?php echo $product_image; ?>" alt="<?php echo $product_image; ?>" />
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo $product_title; ?></h5>
                                                        <p class="card-text"><?php echo $product_detail; ?></p>
                                                    </div>
                                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                                        <div class="post-preview-meta">
                                                            
                                                            <div class="post-preview-meta-details">
                                                                <div class="post-preview-meta-details-name mb-4">

                                                                    <?php

                                                                        if($product_red == 0.0)
                                                                        { ?>
                                                                          
                                                                          <?php echo $product_prix .' MAD'; ?>

                                                                        <?php }
                                                                        else
                                                                        { 
                                                                                $pr_new_price = $product_prix * (1 - $product_red);
                                                                                
                                                                            ?>
                                                                            
                                                                            <span><?php echo $pr_new_price.' MAD'; ?></span>
                                                                            <small>
                                                                                <s><small><b class="badge-pill"><?php echo $product_prix; ?> <small>MAD</small> </b></small></s>
                                                                            </small>

                                                                        <?php }

                                                                     ?>
                                                                    
                                                                </div>
                                                                <div class="post-preview-meta-details-name">
                                                                    
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
                                                        // $url = "https://localhost/DevZiko/";
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
                                            

                                                                </div>
                                                                <div class="post-preview-meta-details-date"><?php echo $product_date; ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="post-preview-meta mb-1"  style="color: black; font-family: cursive; font-size: 15px; font-weight: bold">

                                                            <?php echo $product_views; ?>  
                                                            <i class="far fa-eye"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                    <?php }
                                ?>
                            </div>

                            <?php 
                                if($product_count > $product_per_page)
                                {
                                ?>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination pagination-blog justify-content-center">

                                            <!-- Previous Page -->
                                                <?php

                                                    if(isset($_GET['page']))
                                                    {
                                                      
                                                        $previous = $_GET['page'] -1 ;
                                                        
                                                    }
                                                    else
                                                    {
                                                        $previous = 0;
                                                    }

                                                    if($previous+1 > 1 )
                                                    {
                                                        

                                                        echo '<li class="page-item">
                                                                <a class="page-link" href="categories.php?category_id='. $_GET['category_id'].'&category_name='. $_GET['category_name'] .'&page='. $previous .'"aria-label="Previous"><span aria-hidden="true">&#xAB;</span>
                                                                </a>
                                                            </li>';    
                                                    }
                                                    else
                                                    {
                                                        echo '<li class="page-item disabled">
                                                                <a class="page-link" href="!#" aria-label="Previous"><span aria-hidden="true">&#xAB;</span>
                                                                </a>
                                                            </li>';

                                                    }

                                                ?>



                                                    <?php

                                                        if(isset($_GET['page']))
                                                        {
                                                            $active = $_GET['page'];
                                                        }
                                                        else
                                                        {
                                                            $active = 1;

                                                        }


                                                        for($i =1; $i<= $total_pager ; $i++)
                                                        {
                                                            if($i == $active)
                                                            {

                                                                echo '<li class="page-item active"><a class="page-link" href="categories.php?category_id='. $_GET['category_id'].'&category_name='. $_GET['category_name'] .'&page='. $i .'">'. $i .'</a></li>';                                                                
                                                            }
                                                            else
                                                            {
                                                                echo '<li class="page-item"><a class="page-link" href="categories.php?category_id='. $_GET['category_id'].'&category_name='. $_GET['category_name'] .'&page='. $i .'">'. $i .'</a></li>';                                                                
                                                            }
                                                        }

                                                    ?>


                                                   
                                                    <!-- Pagination Nexe -->

                                                    <?php 

                                                       if(isset($_GET['page']))
                                                        {
                                                            $next = $_GET['page'] +1;
                                                        }
                                                        else
                                                        {
                                                            $next =2;
                                                        }
                                                            
                                                        if($next - 1 >= $total_pager) {
                                                            echo '<li class="page-item disabled"><a class="page-link" href="#!" aria-label="Next"><span aria-hidden="true">&#xBB;</span></a></li>';
                                                        } else {
                                                            echo '<li class="page-item"><a class="page-link" href="categories.php?category_id='.$_GET['category_id'].'&category_name='.$_GET['category_name'].'&page=' . $next . '" aria-label="Next"><span aria-hidden="true">&#xBB;</span></a></li>';
                                                        }

                                                    ?>

                                        </ul>
                                    </nav>

                                <?php    
                                }
                            ?>


                            <h1 class="pt-5">Most viewed products:</h1>
                            <hr />
                            <div class="row">
                                <?php 
                                    $sql2 = "SELECT * FROM products WHERE  product_category_id = :id ORDER BY product_views DESC LIMIT 0, 3";
                                    $stmt = $pdo->prepare($sql2);
                                    $stmt->execute([
                                        ':id' => $_GET['category_id']
                                    ]);
                                    while($products = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                        $product_image_id = $products['product_image_id'];

                                        $sql5 = "SELECT * FROM photos WHERE photo_id = :id";
                                        $stmt1 = $pdo->prepare($sql5);
                                        $stmt1->execute([
                                            ':id' => $product_image_id
                                        ]);
                                        $photo = $stmt1->fetch(PDO::FETCH_ASSOC);

                                        $product_id = $products['product_id'];
                                        $product_title = $products['product_title'];
                                        $product_detail = substr($products['product_detail'], 0, 140);
                                        $product_prix = $products['product_prix']; 
                                        $product_date = $products['product_date'];
                                        $product_views = $products['product_views'];
                                        $product_image = $photo['photo_img'];
                                        $product_red = $products['product_red']; ?>

                                            <div class="col-md-6 col-xl-4 mb-5">
                                                <a class="card post-preview lift h-100" href="single.php?post_id=<?php echo $product_id; ?>"
                                                    ><img class="card-img-top" src="./img/<?php echo $product_image; ?>" alt="<?php echo $product_image; ?>" />
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo $product_title; ?></h5>
                                                        <p class="card-text"><?php echo $product_detail; ?></p>
                                                    </div>
                                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                                        <div class="post-preview-meta">
                                                            
                                                            <div class="post-preview-meta-details">
                                                               <div class="post-preview-meta-details-name mb-4">

                                                                    <?php

                                                                        if($product_red == 0.0)
                                                                        { ?>
                                                                          
                                                                          <?php echo $product_prix .' MAD'; ?>

                                                                        <?php }
                                                                        else
                                                                        { 
                                                                                $pr_new_price = $product_prix * (1 - $product_red);
                                                                                
                                                                            ?>
                                                                            
                                                                            <span><?php echo $pr_new_price.' MAD'; ?></span>
                                                                            <small>
                                                                                <s><small><b class="badge-pill"><?php echo $product_prix; ?> <small>MAD</small> </b></small></s>
                                                                            </small>

                                                                        <?php }

                                                                     ?>
                                                                    
                                                                        
                                                                </div>
                                                                <div class="post-preview-meta-details-name">
                                                                    
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
                                        // $url = "https://localhost/DevZiko/";
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
                        
                                                                </div>
                                                                <div class="post-preview-meta-details-date"><?php echo $product_date; ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="post-preview-meta mb-1"  style="color: black; font-family: cursive; font-size: 15px; font-weight: bold">

                                                            <?php echo $product_views; ?>  
                                                            <i class="far fa-eye"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                    <?php }
                                ?>
                            </div>

                        </div>
                        <!--End-->   
                        <!--Waves-->
                        <div class="svg-border-waves text-dark">
                            <svg class="wave" style="pointer-events: none" fill="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
                                <defs>
                                    <style>
                                        .a {
                                            fill: none;
                                        }
                                        .b {
                                            clip-path: url(#a);
                                        }
                                        .d {
                                            opacity: 0.5;
                                            isolation: isolate;
                                        }
                                    </style>
                                    <clipPath id="a"><rect class="a" width="1920" height="75" /></clipPath>
                                </defs>
                                <title>wave</title>
                                <g class="b"><path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48" /></g>
                                <g class="b"><path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10" /></g>
                                <g class="b"><path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24" /></g>
                                <g class="b"><path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150" /></g>
                            </svg>
                        </div>  
                        <!--End Waves-->            

                </main>
            </div>

            <div id="layoutDefault_footer">
                <footer class="footer pt-2 pb-4 mt-auto bg-dark footer-dark">
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