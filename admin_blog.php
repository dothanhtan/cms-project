<?php
    session_start(); // luon o tren cung
    if(!isset($_SESSION["user"])) {
      header("location:login.php");
    }
    include_once("model/user.php");
    include_once("model/blog.php");
    include_once("model/category.php");

    $current_user = unserialize($_SESSION["user"]);
    if(isset($_REQUEST["category_id"])) {
        $blogs = Blog::getBlogByCategoryID($_REQUEST["category_id"], $current_user->id);
    }
    else if(isset($_REQUEST["blog_info"])) {
        $blogs = Blog::searchBlog($_REQUEST["blog_info"], $current_user->id);
    }
    else {
        $blogs = Blog::getBlog($current_user->id);
    }
    $categories = Category::getCategory();
    
    $total_blog = sizeof($blogs);
    $blog_per_page = 5;
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
    include_once('header.php');
    include_once('nav.php');
?>

<div class="container pt-5">
    <a class="btn btn-outline-info float-right btn-new-blog" href="create_blog.php"><i class="fas fa-plus-circle"></i> Tạo mới</a>
    <form action="" method="GET">
        <div class="form-group">
            <input class="form-control" name="blog_info"  style="max-width: 600px; display:inline-block;" placeholder="Search">
            <button type="submit" class="btn btn-default" style="margin-left:-50px"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <table class="table mt-5">
        <thead class="thead-dark">
            <tr class="text-center">
                <th colspan="2">Tiêu đề</th>
                <th>Author</th>
                <th>Mô tả ngắn</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody id="blog_list">
            <?php foreach($blogs as $key => $value){ ?>
            <tr class="blog_item" data-id="<?php echo $value->id ?>">
                <td><img src="<?php echo $value->imageUrl ?>" alt="" width="80" height="80"></td>
                <td class="ad-blog-title"><?php echo $value->title ?></td>
                <td class="ad-blog-author"><?php echo User::getUserByID((int)$value->userID)->fullName ?></td>
                <td class="ad-blog-short-description"><?php echo $value->shortDescription ?></td>
                <td class="ad-blog-created-at"><?php echo $value->createdAt ?></td>
                <td>
                    <a href="detail_blog?blog_id=<?php echo $value->id ?>" target='_blank' class="btn btn-sm btn-outline-secondary btn-show-blog"><i class="fas fa-eye"></i></a>
                    <a href="edit_blog.php?blog_id=<?php echo $value->id ?>" class="btn btn-sm btn-outline-info btn-edit-blog"><i class="fas fa-pencil-alt"></i></a>
                    <span class="btn btn-sm btn-outline-danger btn-delete-blog"><i class="fas fa-trash-alt"></i></span>
                </td>
            </tr>
            <?php } ?>    
        </tbody>
    </table>

    <nav class="mt-4" aria-label="Page navigation sample">
        <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= $count_of_page; $i++) { 
                if(isset($_REQUEST["category_id"])) {
            ?>
            <li class="page-item <?php echo $i == $page ? "active" : "" ?>"><a class="page-link" href="admin_blog.php?category_id=<?php echo  $_REQUEST["category_id"]?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
            <?php } else if(isset($_REQUEST["blog_info"])) {?>
            <li class="page-item <?php echo $i == $page ? "active" : "" ?>"><a class="page-link" href="admin_blog.php?blog_info=<?php echo  $_REQUEST["blog_info"]?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
            <?php } else { ?>
            <li class="page-item <?php echo $i == $page ? "active" : "" ?>"><a class="page-link" href="admin_blog.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
            <?php } } ?>
        </ul>
    </nav>
</div>
<?php 
    include_once('footer.php');
?>