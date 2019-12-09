/* Config CK Editor */
CKEDITOR.config.filebrowserBrowseUrl = '/cms/ckfinder/ckfinder.html';
CKEDITOR.config.filebrowserImageBrowseUrl = '/cms/ckfinder/ckfinder.html?type=Images';
CKEDITOR.config.filebrowserFlashBrowseUrl = '/cms/ckfinder/ckfinder.html?type=Flash';
CKEDITOR.config.filebrowserUploadUrl = '/cms/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
CKEDITOR.config.filebrowserImageUploadUrl = '/cms/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
CKEDITOR.config.filebrowserFlashUploadUrl = '/cms/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

CKEDITOR.replace( 'blog_content', {
    height: 400
});

/* Upload image_blog */
$('#upload').on('click', function() {
    var file_data = $('#customFile').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('upload', file_data);
    alert(form_data);                             
    $.ajax({
            url: 'upload_image.php', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(php_script_response){
                    console.log(JSON.parse(php_script_response)); // display response from the PHP script, if any
            }
    });
});

/* Preview image upload */
$(document).on("change", "#customFile", function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#previewImageBlog').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
})

$(document).on("click", ".btn-delete-blog", function(){
    var instance = this;
    var blog_id = $(this).parents(".blog_item").data("id");
    $.confirm({
      title: 'Thông báo',
      content: 'Bạn có muốn xóa bài viết này không?',
      buttons: {
        yes: {
          text: 'Xóa',
          btnClass: 'btn-danger',
          action: function () {
            $.ajax({
              url: "./controller/blog_controller.php",
              method: "POST",
              data: {
                delete_blog: {
                  id: blog_id
                }
              },
              success: function(res){
                console.log(res);
                var result = JSON.parse(res);
                if(result.status == "Success") {
                  $(instance).parents(".blog_item").remove();
                  $.alert("Xóa bài viết thành công");
                }
                else {
                  $.alert("Xóa bài viết thất bại");
                }
              },
              error: function(){
                $.alert("Xóa bài viết thất bại");
              }
            })   
          }
        },
        no: {
          text: 'Hủy',
          action: function () {
            //close
          }
        }
      }
    });
    return false;
})