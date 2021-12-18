<?php $current_page = "Search result"; ?>
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
                                </ul>
                                <?php 
                                    $curr_page = basename(__FILE__);
                                    require_once("./includes/registration.php");
                                ?>
                            </div>
                        </div>
                    </nav>


                    <!-- For The pagination  -->
                    <!--  Start -->

                    <?php

                        if(isset($_POST['search-keyword']))
                        {
                            $url = "http://localhost/DevZiko/search.php?key=".$_POST['search-keyword'];
                            header("Location: {$url}"); 
                        }

                    ?>

                    <?php
                        if(isset($_GET['key'])) {
                            $keyword = $_GET['key'];
                            $sql = "SELECT * FROM products WHERE product_title LIKE :title";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                ':title' => '%'. trim($keyword) .'%'
                            ]);
                            $product_found = 0;
                            $count = $stmt->rowCount();
                            if($count == 0) {
                                $product_found = 0;
                            } else {
                                $product_found = $count;
                            }
                        }
                    ?>

                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
                        <div class="page-header-content pt-10">
                            <div class="container text-center">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <h1 class="page-header-title mb-3">Search result for <?php echo $keyword; ?></h1>
                                        <p class="page-header-text">Total products found: <?php echo $product_found; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-rounded text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0" /></svg>
                        </div>
                    </header>
                    <section class="bg-white py-10">
                        <div class="container">


                             <?php

                                $sql = "SELECT * FROM products WHERE product_title LIKE :title";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([

                                        ':title' => '%'. trim($_GET['key']) .'%'

                                ]);

                                $product_count = $stmt->rowCount();
                                $product_per_page = 3;
                                if(isset($_GET['page']))
                                {
                                    $page = $_GET['page'];
                                    if($page == 1)
                                    {
                                        $page_id = 0;
                                    }
                                    else
                                    {
                                        $page_id = ($page * $product_per_page) - $product_per_page;
                                    }

                                }
                                else
                                {
                                    $page = 1;
                                    $page_id = 0;   
                                }

                                $total_pager = ceil($product_count / $product_per_page);
                            ?>

                            
                            <h1>Search Result:</h1>
                            <hr />
                            <div class="row">
                                <?php 
                                    $sql = "SELECT * FROM products WHERE product_title LIKE :title ORDER BY product_id DESC LIMIT $page_id, $product_per_page";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([
                                        ':title' => '%'. trim($keyword) .'%'
                                    ]);
                                    $count = $stmt->rowCount();
                                    if($count == 0) {
                                        echo "No products found! Try again";
                                    } else {
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
                                        $product_image = $photo['photo_img']; ?>

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
                                                                <div class="post-preview-meta-details-name"><?php echo $product_prix .' MAD'; ?></div>
                                                                <br>
                                                                <div class="post-preview-meta-details-date"><?php echo $product_date; ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="post-preview-meta">
                                                            <?php echo $product_views; ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                       <?php }
                                    }
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
                                                                <a class="page-link" href="search.php?key='. $_GET['key'] .'&page='. $previous .'"aria-label="Previous"><span aria-hidden="true">&#xAB;</span>
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

                                                                echo '<li class="page-item active"><a class="page-link" href="search.php?key='. $_GET['key'] .'&page='. $i .'">'. $i .'</a></li>';                                                                
                                                            }
                                                            else
                                                            {
                                                                echo '<li class="page-item"><a class="page-link" href="search.php?key='. $_GET['key'] .'&page='. $i .'">'. $i .'</a></li>';                                                                
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
                                                            echo '<li class="page-item"><a class="page-link" href="search.php?key='.$_GET['key'].'&page=' . $next . '" aria-label="Next"><span aria-hidden="true">&#xBB;</span></a></li>';
                                                        }
                                                    ?>

                                        </ul>
                                    </nav>

                                <?php    
                                }
                            ?>

                        </div>

                        <div class="svg-border-rounded text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0" /></svg>
                        </div>
                    </section>
                </main>
            </div>
            <div id="layoutDefault_footer">
                <footer class="footer pt-4 pb-4 mt-auto bg-dark footer-dark">
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