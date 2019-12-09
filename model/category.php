<?php 
	class Category {
		var $id;
		var $name;

		function Category($id, $name) {
			$this->id = $id;
			$this->name = $name;
		}

		static function connectToDB() {
			$con = new mysqli("localhost:3308", "root", "", "blog");
			$con->set_charset("utf8");
			if($con->connect_error)
					die("Ket noi that bai. Chi tiet: " . $con->connect_error);
			return $con;
		}

		static function getCategory(){
			$con = Category::connectToDB();
			$sql = "SELECT * FROM Category";
			//$sql = "SELECT Category.* FROM Category, Blog WHERE Blog.CategoryID = Category.ID GROUP BY Category.Name";
			$result = $con->query($sql);
			$arrCategory = [];
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					$category = new Category($row["ID"], $row["Name"]);
					array_push($arrCategory, $category);
				}
			}
			$con->close();
			return $arrCategory;
		}

		static function create($name){
			$con = Category::connectToDB();
			$res = new stdClass();

			// Check if category name is already exists
			$arrCategory = Category::getCategory();
			foreach($arrCategory as $key => $value){
					if($value->name == $name) {
							$res->status = 'Exists';
							return $res;
					}
			}

			// INSERT TO DB
			$sql = "INSERT INTO Category (Name) VALUES ('$name')";
			$result = $con->query($sql);            
			if($result) {
					$id = $con->insert_id;
					$category = new Category($id, $name);
					$con->close();
					$res->status = 'Success';
					$res->category = $category;
			}
			else {
					$res->status = 'Error';
			}
			return $res;
		}

		static function update($id, $name){
			$con = Category::connectToDB();
			$res = new stdClass();

			// Check if category name is already exists
			$arrCategory = Category::getCategory();
			foreach($arrCategory as $key => $value){
					if($value->name == $name) {
							$res->status = 'Exists';
							return $res;
					}
			}

			// UPDATE TO DB
			$sql = "UPDATE Category SET Name = '$name' WHERE Category.ID = $id";
			$result = $con->query($sql);            
			if($result) {
					$category = new Category($id, $name);
					$con->close();
					$res->status = 'Success';
					$res->category = $category;
			}
			else {
					$res->status = 'Error';
			}
			return $res;
		}

		static function delete($id){
			$con = Category::connectToDB();
			$res = new stdClass();

			// UPDATE TO DB
			$sql = "DELETE FROM Category WHERE Category.ID = $id";
			$result = $con->query($sql);            
			if($result) {
				$res->status = 'Success';
			}
			else {
				$res->status = 'Error';
			}
			return $res;
		}

		static function show($id) {
			$con = Category::connectToDB();
			$res = new stdClass();

			$sql = "SELECT * FROM Category WHERE Category.ID = $id";
			$result = $con->query($sql);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					$category = new Category($row["ID"], $row["Name"]);
					$con->close();
					return $category;
				}
			}
			$con->close();    
		}
	}

?>