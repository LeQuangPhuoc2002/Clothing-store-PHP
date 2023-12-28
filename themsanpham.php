<?php
// Bao gồm lớp Database
include('includes/Database.php');

// Kiểm tra nếu biểu mẫu đã được gửi đi
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Lấy dữ liệu từ biểu mẫu
    $name = $_GET['name'];
    $price = $_GET['price'];
    $quantity = $_GET['quantity'];
    $category_id = $_GET['category_id'];
    $description = $_GET['description'];
    $image = $_GET['file_img'];
    $image2 = $_GET['file_img2'];
    $image3 = $_GET['file_img3'];
    
    if (empty($name) || empty($price) || empty($quantity) || empty($category_id) || empty($description)) {
        // Hiển thị thông báo lỗi và dừng lại
        echo 'Vui lòng điền đầy đủ thông tin sản phẩm.';
        exit();
    }
    // Xử lý ảnh đã tải lên
    

    // Xử lý tải lên tệp
    $uploadedImages = handleImageUpload();

    // Chèn dữ liệu vào cơ sở dữ liệu
    $result = Database::insertProduct($name, $price, $quantity, $category_id, $description, $image, $image2, $image3);


    header('Location: admin.php');
    exit();

} else {
    // Nếu biểu mẫu chưa được gửi đi, chuyển hướng về trang biểu mẫu
    header('Location: addproduct.php');
    exit();
}

// Hàm di chuyển tệp tin đã tải lên và trả về đường dẫn mớ

?>