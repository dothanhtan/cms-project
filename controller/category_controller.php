<?php 
    include_once('../model/category.php');

    // Create label
    if(isset($_REQUEST["new_category"])) {
        $name = $_REQUEST["new_category"]["name"];
        $category = Category::create($name);
        echo json_encode($category);
    }

    if(isset($_REQUEST["edit_category"])) {
        $id = $_REQUEST["edit_category"]["id"];
        $name = $_REQUEST["edit_category"]["name"];
        $category = Category::update($id, $name);
        echo json_encode($category);
    }

    if(isset($_REQUEST["delete_category"])) {
        $id = $_REQUEST["delete_category"]["id"];
        $category = Category::delete($id);
        echo json_encode($category);
    }
    

    // Create contact
    // if(isset($_REQUEST["new_contact"])) {
    //     $user_id = $_REQUEST["new_contact"]["user_id"];
    //     $label_id = $_REQUEST["new_contact"]["label_id"];
    //     $name = $_REQUEST["new_contact"]["name"];
    //     $phone = $_REQUEST["new_contact"]["phone"];
    //     $email = $_REQUEST["new_contact"]["email"];

    //     $contact = Contact::create($name, $phone, $email, $user_id, $label_id);
    //     echo json_encode($contact);
    // }
?>