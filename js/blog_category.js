$(document).ready(function(){
  /* Create category */
  $(document).on("click", ".btn-new-category", function(){
      $.confirm({
        title: 'Tạo chuyên mục',
        content: '' +
        '<form action="" class="formCategory">' +
        '<div class="form-group">' +
        '<label>Tên chuyên mục</label>' +
        '<input type="text" placeholder="Tên chuyên mục mới" class="category-name form-control"/>' +
        '</div>' +
        '</form>',
        buttons: {
          formSubmit: {
            text: 'Tạo',
            btnClass: 'btn-blue',
            action: function () {
              category_name = this.$content.find('.category-name').val();
              if(category_name != null && category_name != "") {
                $.ajax({
                  url: "./controller/category_controller.php",
                  method: "POST",
                  data: {
                    new_category: {
                      name: category_name,
                    }
                  },
                  success: function(res){
                    var result = JSON.parse(res);
                    if(result.status == "Success") {
                      var content = "<tr class='category_item' data-id='" + result.category.id + "'>";
                      content += "<td>" + ($(".category_item").length + 1) + "</td>";
                      content += "<td class='ad-category-name'>" + result.category.name + "</td>";
                      content += "<td><span class='btn btn-sm btn-outline-info btn-edit-category'><i class='fas fa-pencil-alt'></i></span> <span class='btn btn-sm btn-outline-danger btn-delete-category'><i class='fas fa-trash-alt'></i></span></td>";
                      content += "</tr>";
                      console.log(content);
                      $("#category_list").append(content);
                      $.alert("Tạo chuyên mục mới thành công");
                    }
                    else if (result.status == "Exists") {
                      $.alert("Tên chuyên mục đã tồn tại");
                    }
                    else {
                      $.alert("Tạo chuyên mục mới thất bại");
                    }
                  },
                  error: function(){
                    $.alert("Tạo chuyên mục mới thất bại");
                  }
                })   
              } else {
                  $.alert("Tên chuyên mục không thể để trống");
                  return false;
              }
            }
          },
          cancel: {
            text: 'Hủy',
            action: function () {
              //close
            }
          }
        },
        onContentReady: function () {
          // bind to events
          var jc = this;
          this.$content.find('.formcategory').on('submit', function (e) {
              // if the user submits the form by pressing enter in the field.
              e.preventDefault();
              jc.$$formSubmit.trigger('click'); // reference the button and click it
          });
        }
        });
        return false;
  })

  /* Edit category */
  $(document).on("click", ".btn-edit-category", function(){
    var instance = this;
    var category_id = $(this).parents(".category_item").data("id");
    var category_old_name = $(this).parents(".category_item").find(".ad-category-name").text();
    $.confirm({
      title: 'Chỉnh sửa chuyên mục',
      content: '' +
      '<form action="" class="formCategory">' +
      '<div class="form-group">' +
      '<label>Tên chuyên mục</label>' +
      '<input type="text" placeholder="Tên chuyên mục mới" class="category-name form-control" value="' + category_old_name + '"/>' +
      '</div>' +
      '</form>',
      buttons: {
        formSubmit: {
          text: 'Cập nhật',
          btnClass: 'btn-info',
          action: function () {
            category_name = this.$content.find('.category-name').val();
            if(category_name != null && category_name != "") {
              $.ajax({
                url: "./controller/category_controller.php",
                method: "POST",
                data: {
                  edit_category: {
                    id: category_id,
                    name: category_name
                  }
                },
                success: function(res){
                  var result = JSON.parse(res);
                  if(result.status == "Success") {
                    $(instance).parents(".category_item").find(".ad-category-name").text(result.category.name);
                    $.alert("Cập nhật chuyên mục thành công");
                  }
                  else if (result.status == "Exists") {
                    $.alert("Tên chuyên mục đã tồn tại");
                  }
                  else {
                    $.alert("Cập nhật chuyên mục thất bại");
                  }
                },
                error: function(){
                  $.alert("Cập nhật chuyên mục thất bại");
                }
              })   
            } else {
                $.alert("Tên chuyên mục không thể để trống");
                return false;
            }
          }
        },
        cancel: {
          text: 'Hủy',
          action: function () {
            //close
          }
        }
      },
      onContentReady: function () {
        // bind to events
        var jc = this;
        this.$content.find('.formcategory').on('submit', function (e) {
            // if the user submits the form by pressing enter in the field.
            e.preventDefault();
            jc.$$formSubmit.trigger('click'); // reference the button and click it
        });
      }
    });
    return false;
  })

  /* Delete category */
  $(document).on("click", ".btn-delete-category", function(){
    var instance = this;
    var category_id = $(this).parents(".category_item").data("id");
    $.confirm({
      title: 'Cảnh báo',
      content: 'Việc xóa chuyên mục này sẽ làm toàn bộ bài viết thuộc chuyên mục này của bạn bị mất. Bạn có muốn xóa chuyên mục này không?',
      buttons: {
        yes: {
          text: 'Xóa',
          btnClass: 'btn-danger',
          action: function () {
            $.ajax({
              url: "./controller/category_controller.php",
              method: "POST",
              data: {
                delete_category: {
                  id: category_id
                }
              },
              success: function(res){
                var result = JSON.parse(res);
                if(result.status == "Success") {
                  $(instance).parents(".category_item").remove();
                  $.alert("Xóa chuyên mục thành công");
                }
                else {
                  $.alert("Xóa chuyên mục thất bại");
                }
              },
              error: function(){
                $.alert("Xóa chuyên mục thất bại");
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
})