<?php 
class Blog {
    var $id;
    var $title;
    var $status;
    var $userID;
    var $categoryID;
    var $shortDescription;
    var $content;
    var $imageUrl;
    var $createdAt;
    var $updatedAt;

    function Blog($id, $title, $status, $userID, $categoryID, $shortDescription, $content, $imageUrl, $createdAt, $updatedAt) {
			$this->id = $id;
			$this->title = $title;
			$this->status = $status;
			$this->userID = $userID;
			$this->categoryID = $categoryID;
			$this->shortDescription = $shortDescription;
			$this->content = $content;
			$this->imageUrl = $imageUrl;
			$this->createdAt = $createdAt;
			$this->updatedAt = $updatedAt;
    }

    static function connectToDB() {
			$con = new mysqli("localhost:3308", "root", "", "blog");
			$con->set_charset("utf8");
			if($con->connect_error)
					die("Ket noi that bai khi tao moi. Chi tiet: " . $con->connect_error);
			return $con;
		}

		static function getBlog($userID = null) {
			$con = Blog::connectToDB();
			$sql = "SELECT * FROM Blog ORDER BY CreatedAt DESC";
			if($userID != null) {
				$sql = "SELECT * FROM Blog WHERE UserID = $userID ORDER BY CreatedAt DESC";
			}
			$result = $con->query($sql);
			$arrBlog = [];
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					$blog = new Blog($row["ID"], $row["Title"], $row["BlogStatus"], $row["UserID"], $row["CategoryID"], $row["ShortDescription"], $row["Content"], $row["ImageUrl"], $row["CreatedAt"], $row["UpdatedAt"]);
					array_push($arrBlog, $blog);
				}
			}
			$con->close();
			return $arrBlog;
		}

		static function show($id) {
			$con = Blog::connectToDB();
			$sql = "SELECT * FROM Blog WHERE Blog.ID = $id";
			$result = $con->query($sql);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					$blog = new Blog($row["ID"], $row["Title"], $row["BlogStatus"], $row["UserID"], $row["CategoryID"], $row["ShortDescription"], $row["Content"], $row["ImageUrl"], $row["CreatedAt"], $row["UpdatedAt"]);
					$con->close();
					return $blog;
				}
			}
			$con->close();
		}

    static function create($title, $status, $userID, $categoryID, $shortDescription, $content, $imageUrl) {
			$con = Blog::connectToDB();
			$res = new stdClass();

			$current_time = strftime('%Y-%m-%d %H:%M:%S',time());
			// INSERT TO DB
			$sql = "INSERT INTO Blog (Title, BlogStatus, UserID, CategoryID, ShortDescription, Content, ImageUrl, CreatedAt, UpdatedAt) VALUES ('$title', $status, $userID, $categoryID, '$shortDescription', '$content', '$imageUrl', '$current_time', '$current_time')";
			var_dump($sql);
			$result = $con->query($sql); 
			var_dump($result);           
			if($result) {
				$id = $con->insert_id;
				$blog = new Blog($id, $title, $status, $userID, $categoryID, $shortDescription, $content, $imageUrl, $current_time, $current_time);
				$con->close();
				$res->status = 'Success';
				$res->blog = $blog;
			}
			else {
				$res->status = 'Error';
			}
			return $res;
		}
		
		static function update($id, $title, $status, $categoryID, $shortDescription, $content, $imageUrl) {
      		$con = Blog::connectToDB();
			$res = new stdClass();
			$current_time = strftime('%Y-%m-%d %H:%M:%S',time());

			// UPDATE TO DB
			$sql = "UPDATE Blog SET Title = '$title', BlogStatus = $status, CategoryID = $categoryID, ShortDescription = '$shortDescription', Content = '$content', UpdatedAt = '$current_time' WHERE Blog.ID = $id";
			if(strlen($imageUrl) > 0) {
				$sql = "UPDATE Blog SET Title = '$title', BlogStatus = $status, CategoryID = $categoryID, ShortDescription = '$shortDescription', Content = '$content', ImageUrl = '$imageUrl', UpdatedAt = '$current_time' WHERE Blog.ID = $id";
			}
			$result = $con->query($sql);         
			if($result) {
					$con->close();
					$res->status = 'Success';
			}
			else {
					$res->status = 'Error';
			}
			return $res;
		}
		
		static function delete($id) {
			$con = Blog::connectToDB();
			$res = new stdClass();

			// UPDATE TO DB
			$sql = "DELETE FROM Blog WHERE Blog.ID = $id";
			$result = $con->query($sql);            
			if($result) {
					$res->status = 'Success';
			}
			else {
					$res->status = 'Error';
			}
			return $res;
		}

		static function getBlogByCategoryID($categoryID, $userID = null) {
			$con = Blog::connectToDB();
			$sql = "SELECT * FROM Blog WHERE Blog.CategoryID = $categoryID ORDER BY CreatedAt DESC";
			if($userID != null) {
				$sql = "SELECT * FROM Blog WHERE Blog.CategoryID = $categoryID AND Blog.UserID = $userID ORDER BY CreatedAt DESC";
			}
			$result = $con->query($sql);
			
			$arrBlog = [];
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					$blog = new Blog($row["ID"], $row["Title"], $row["BlogStatus"], $row["UserID"], $row["CategoryID"], $row["ShortDescription"], $row["Content"], $row["ImageUrl"], $row["CreatedAt"], $row["UpdatedAt"]);
					array_push($arrBlog, $blog);
				}
			}
			$con->close();
			return $arrBlog;
		}

		static function searchBlog($info, $userID = null) {
			$con = Blog::connectToDB();

			$sql = "SELECT * FROM Blog WHERE (Blog.Title LIKE '%$info%' OR Blog.ShortDescription LIKE '%$info%' OR Blog.Content LIKE '%$info%') ORDER BY CreatedAt DESC";

			if($userID != null) {
				$sql = "SELECT * FROM Blog WHERE (Blog.Title LIKE '%$info%' OR Blog.ShortDescription LIKE '%$info%' OR Blog.Content LIKE '%$info%') AND Blog.UserID = $userID ORDER BY CreatedAt DESC";
			}
			$result = $con->query($sql);
			$arrBlog = [];
			if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()){
						$blog = new Blog($row["ID"], $row["Title"], $row["BlogStatus"], $row["UserID"], $row["CategoryID"], $row["ShortDescription"], $row["Content"], $row["ImageUrl"], $row["CreatedAt"], $row["UpdatedAt"]);
						array_push($arrBlog, $blog);
					}
			}
			$con->close();
			return $arrBlog;
		}
}
?>