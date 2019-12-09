<?php
    session_start(); // luon o tren cung
    if(!isset($_SESSION["user"])) {
      header("location:login.php");
    }
	include_once('model/category.php');
	include_once("model/user.php");
	include_once("model/blog.php");
	
	$current_user = unserialize($_SESSION["user"]);
	$categories = Category::getCategory(); 
	$blogs = Blog::getBlog();

	include_once('header.php');
	include_once('nav.php');
?>

<div class="container">
	<div class="row">
		<div class="block-form col-md-10 offset-md-1">
			<div class="col-md-10 offset-md-1 my-5">
				<h4 class="text-info text-center py-3 text-uppercase">Tạo mới bài viết</h4>
					<form action="controller/blog_controller.php" method="POST" enctype="multipart/form-data" class="mt-3" id="formNewBlog">
					<div class="row">
						<div class="md-6">
							<label class="" for="customFile">Chọn ảnh đại diện</label>
							<input type="file" class="" id="customFile" name="image_blog">
						</div>
						<div class="col-md-6 preview">
								<img src="" alt="" class="img-fluid" id="previewImageBlog" width="300" height="300">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
								<label for="txtTitle">Tên bài viết</label>
								<input name="blog_title" type="text" class="form-control" id="txtTitle" required placeholder="Nhập tên bài viết">
						</div>
						<div class="form-group col-md-4">
								<label for="txtStatus">Trạng thái</label>
								<select name="blog_status" id="" class="form-control">
										<option value="1">Công khai</option>
										<option value="0">Riêng tư</option>
								</select>
						</div>
					</div>
					
					<div class="row">
						<div class="form-group col-md-6">
								<label for="txtAuthor">Tác giả</label>
								<input name="blog_author" type="text" class="form-control" id="txtAuthor" required placeholder="" readonly value="<?php echo $current_user->id ?>">
						</div>
						<div class="form-group col-md-6">
								<label for="txtCategory">Chuyên mục</label>
								<select name="blog_category_id" id="" class="form-control">
								<?php foreach($categories as $key => $value){ ?>
									<option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
								<?php } ?>
								</select>
						</div>
					</div>
					<div class="form-group">
							<label for="txtDescription">Mô tả ngắn</label>
							<textarea class="form-control" name="blog_short_description" required>Mô tả ngắn</textarea>
					</div>
					<div class="form-group">
							<label for="txtContent">Nội dung</label>
							<textarea class="form-control" name="blog_content" required>Nội dung bài viết</textarea>
					</div>
					<button name="create_blog" type="submit" class="btn btn-create btn-primary">Tạo mới</button>
					<a href="admin_blog.php" class="btn btn-cancel btn-secondary">Hủy</a>
					</form>
			</div>
		</div>
	</div>
</div>
<?php 
    include_once('footer.php');
?>

