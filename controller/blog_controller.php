<?php
	include_once("../model/blog.php");

	/* Get value */
	if(isset($_REQUEST["create_blog"]) || isset($_REQUEST["update_blog"])){
		$title = $_REQUEST["blog_title"];
		$status = $_REQUEST["blog_status"];
		$userID = $_REQUEST["blog_author"];
		$categoryID = $_REQUEST["blog_category_id"];
		$short_description = $_REQUEST["blog_short_description"];
		$content = $_REQUEST["blog_content"];
		$image_url = "";
	}

	/* Move avatar to folder and get avatar_url */
	if(isset($_FILES["image_blog"])){
		if($_FILES["image_blog"]["name"] != "") {
				$image_name = "img_" . time();
				move_uploaded_file($_FILES["image_blog"]["tmp_name"], "../uploads/images/" . $image_name . ".png");
				$image_url = "uploads/images/" . $image_name . ".png";
		}
	}

	/* Insert to DB */
	if(isset($_REQUEST["create_blog"])){
		Blog::create($title, $status, $userID, $categoryID, $short_description, $content, $image_url);
		header("location:../admin_blog.php");
	}
	else if(isset($_REQUEST["update_blog"]))  {
		$id = $_REQUEST["blog_id"];
		Blog::update($id, $title, $status, $categoryID, $short_description, $content, $image_url);
		header("location:../admin_blog.php");
	}

	if(isset($_REQUEST["delete_blog"])){
		echo json_encode(Blog::delete($_REQUEST["delete_blog"]["id"]));
	}

?>