<!DOCTYPE html>
<html lang="en">

<?php
    include_once('model/category.php');
	include_once("model/user.php");
	include_once("model/blog.php");
	
	$categories = Category::getCategory(); 
    $blogs = Blog::getBlogByCategoryID($_REQUEST["category_id"]);
    
    $category = Category::show($_REQUEST["category_id"]);

    $total_blog = sizeof($blogs);
    $blog_per_page = 8;
    $count_of_page = ($total_blog % $blog_per_page == 0) ? $total_blog / $blog_per_page : floor($total_blog / $blog_per_page) + 1;
    $page = 1;
    if(isset($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
    }
    if (sizeof($blogs) > $page * $blog_per_page) {
        $blogs = array_slice($blogs, $page * $blog_per_page - $blog_per_page, $blog_per_page);
    } else {
        $blogs = array_slice($blogs, $page * $blog_per_page - $blog_per_page, sizeof($blogs));
    }
?>

<head>
  <title>Duc Phuc</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link href="https://fonts.googleapis.com/css?family=B612+Mono|Cabin:400,700&display=swap" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">

  <link rel="stylesheet" href="css/jquery.fancybox.min.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">

  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="css/aos.css">
  <link href="css/jquery.mb.YTPlayer.min.css" media="all" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/blog.css">


</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>


    
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 d-flex">
                <a href="blog.php" class="site-logo">
                    <img src="images/branch.png" alt="">
                </a>

                <a href="#" class="ml-auto d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>

                </div>
                <div class="col-12 col-lg-6 ml-auto d-flex">
                <div class="ml-md-auto top-social d-none d-lg-inline-block">
                    <a href="#" class="d-inline-block p-3"><span class="icon-facebook"></span></a>
                    <a href="#" class="d-inline-block p-3"><span class="icon-twitter"></span></a>
                    <a href="#" class="d-inline-block p-3"><span class="icon-instagram"></span></a>
                </div>
                <form action="#" class="search-form d-inline-block">

                    <div class="d-flex">
                    <input type="email" class="form-control" placeholder="Search...">
                    <button type="submit" class="btn btn-secondary" ><span class="icon-search"><i class="fa fa-search"></i></span></button>
                    </div>
                </form>
                </div>
                <div class="col-6 d-block d-lg-none text-right">          
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="site-navbar py-2 js-sticky-header site-navbar-target d-none pl-0 d-lg-block" role="banner">
            <div class="container">
                <div class="d-flex align-items-center">
                
                <div class="mr-auto">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                    <ul class="site-menu main-menu js-clone-nav mr-auto d-none pl-0 d-lg-block">
                        <li class="active">
                        <a href="blog.php" class="nav-link text-left">Trang chủ</a>
                        </li>
                        <?php foreach($categories as $key => $value){ ?>
                        <li>
                        <a href="blog_category.php?category_id=<?php echo $value->id ?>" class="nav-link text-left"><?php echo $value->name ?></a>
                        </li>
                        <?php } ?>
                    </ul>                                                                                
                    </nav>
                </div>
                
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-9">
            <div class="section-title">
              <span class="caption d-block small">Chuyên mục</span>
              <h2><?php echo $category->name ?></h2>
            </div>
            <?php foreach($blogs as $key => $value){ ?>
            <div class="post-entry-2 d-flex">
              <div class="thumbnail order-md-2" style="background-image: url(<?php echo $value->imageUrl ?>)"></div>
              <div class="contents order-md-1 pl-0">
                <h2><a href="detail_blog.php?blog_id=<?php echo $value->id ?>"><?php echo $value->title ?></a></h2>
                <p class="mb-3"><?php echo $value->shortDescription ?></p>
                <div class="post-meta">
                  <span class="d-block"><?php echo User::getUserByID((int)$value->userID)->fullName ?></span>
                  <span class="date-read"><?php echo $value->createdAt ?></span>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
          <div class="col-lg-3 social-content">
            <div class="section-title">
              <h2>Kết nối</h2>
            </div>

            <ul class="social-list">
                <li class="social-item"><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li>
                <li class="social-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li class="social-item"><a href="#"><i class="fab fa-google-plus"></i></a></li>
                <li class="social-item"><a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a></li>
                <li class="social-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <ul class="custom-pagination list-unstyled">
              <?php for($i = 1; $i <= $count_of_page; $i++) { ?>
              <li class="<?php echo $i == $page ? "active" : "" ?>"><a href="blog_category.php?category_id=<?php echo $category->id ?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section subscribe bg-light">
      <div class="container">
        <form action="#" class="row align-items-center">
          <div class="col-md-5 mr-auto">
            <h2>Nhận thông báo khi có bài viết mới</h2>
            <p>Nhập email của bạn để chúng tôi có thể gửi đến bạn những bài viết mới, nổi bật nhất</p>
          </div>
          <div class="col-md-6 ml-auto">
            <div class="d-flex">
              <input type="email" class="form-control" placeholder="Enter your email">
              <button type="submit" class="btn btn-secondary" ><span class="icon-paper-plane"><i class="fa fa-envelope"></i></span></button>
            </div>
          </div>
        </form>
      </div>
    </div>


    
    <div class="footer">
      <div class="container">
        

        <div class="row">
          <div class="col-12">
            <div class="copyright">
                <p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    

  </div>
  <!-- .site-wrap -->


  <!-- loader -->
  <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#ff5e15"/></svg></div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/jquery.mb.YTPlayer.min.js"></script>




  <script src="js/main.js"></script>

</body>

</html>