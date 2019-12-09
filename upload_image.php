<?php
    if(isset($_FILES["upload"])){
        if($_FILES["upload"]["name"] != ""); {
            $image_name = "img_" . time();
            move_uploaded_file($_FILES["upload"]["tmp_name"], "uploads/images" . $image_name . ".png");
            if(isset($_REQUEST['CKEditorFuncNum'])) {
                $function_number = $_REQUEST['CKEditorFuncNum'];
                $url = 'uploads/images/' . $image_name . '.png';
                $message = '';
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message')</script>";
            }
            else {
                $response = new stdClass();
                $response->status = "Success";
                $response->url = "uploads/images/" . $image_name . ".png";
                echo json_encode($response);
            }
        }
    }
    
?>
