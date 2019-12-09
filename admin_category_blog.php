<?php
    session_start(); // luon o tren cung
    if(!isset($_SESSION["user"])) {
      header("location:login.php");
    }
	$current_user = unserialize($_SESSION["user"]);
	include_once('model/category.php');
	$categories = Category::getCategory();
    include_once('header.php');
    include_once('nav.php');
?>

<div class="container pt-5">
	<button class="btn btn-outline-info float-right btn-new-category"><i class="fas fa-plus-circle"></i> Tạo mới</button>
	<!-- <form action="" method="GET">
		<div class="form-group">
				<input class="form-control" name="search-blog"  style="max-width: 600px; display:inline-block;" placeholder="Search">
				<button type="submit" class="btn btn-default" style="margin-left:-50px"><i class="fas fa-search"></i></button>
		</div>
	</form> -->
	<table class="table mt-5">
		<thead class="thead-dark">
			<tr>
					<th>STT</th>
					<th>Tên chuyên mục</th>
					<th>Thao tác</th>
			</tr>
		</thead>
		<tbody id="category_list">
			<?php foreach($categories as $key => $value){ ?>
			<tr class="category_item" data-id="<?php echo $value->id ?>">
				<td><?php echo $key + 1 ?></td>
				<td class="ad-category-name"><?php echo $value->name ?></td>
				<td>
					<a href="admin_blog?category_id=<?php echo $value->id ?>" class="btn btn-sm btn-outline-secondary btn-show-blog"><i class="fas fa-eye"></i></a>
					<span class="btn btn-sm btn-outline-info btn-edit-category"><i class="fas fa-pencil-alt"></i></span>
					<span class="btn btn-sm btn-outline-danger btn-delete-category"><i class="fas fa-trash-alt"></i></span>
				</td>
			</tr>
			<?php } ?>    
		</tbody>
	</table>
</div>
<?php 
    include_once('footer.php');
?>
<script src="js/blog_category.js"></script>