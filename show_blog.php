<?php
    include_once('header.php');
    include_once("model/user.php");
    include_once("model/blog.php");
    $blog = Blog::show($_REQUEST["blog_id"]);
?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand text-info" href="blog.php">Duc Phuc.vn</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                <a class="nav-link text-info" href="blog.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-info" href="#">Sea games 30</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-info" href="#">Thời sự</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-info" href="#">Công nghệ</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-info" href="#">Giải trí</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container wrap-content">
    <div class="row my-5">
        <div class="col-md-8 offset-md-2 main-content">
            <div class="text-center header-content">
                <h5 class="text-muted">Chuyên mục</h5>
                <div class="col-4 offset-4">
                    <hr>
                </div>
                <h2 class="blog-title mt-5 mb-3 text-info"><?php echo $blog->title ?></h2>
                <span class="blog-author"><strong>Thanh Hà</strong></span>
                <span class="blog-created text-muted"><?php echo $blog->createdAt ?></span>
            </div>
            <div class="short-description text-center my-4">
                <strong>
                <?php echo $blog->shortDescription ?>
                </strong>
            </div>
            <div class="blog-content">
                <?php echo $blog->content ?>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript -->
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Jquery confirm -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>
<script src="js/shop.js"></script>