<?php
// themsanpham.php

include('includes/Database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted using POST method

    // Your existing code to process form data...
    $productId = isset($_POST['id']) ? $_POST['id'] : '';
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';




    // Handle file uploads
    $uploadDirectory = 'D:/XAMPP/htdocs/Chapter1/quangphuoc/assets/image_order/';

    // Function to handle file upload
    function handleFileUpload($file, $targetDirectory)
    {
        $targetFile = $targetDirectory . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // File uploaded successfully
            // Return the file name with extension
            return basename($file['name']);
        } else {
            // File upload failed
            // Handle the error as needed
            return false;
        }
    }

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $productInfo = Database::getOrderById($productId);
    // Xử lý ảnh thứ hai
    $file2 = $_FILES['file_img2'];
    $imageName2 = handleFileUpload($file2, $uploadDirectory);
    if (!isset($imageName2) || empty($imageName2)) {
        // Nếu tên ảnh rỗng hoặc null, gán lại bằng tên ảnh hiện tại trong cơ sở dữ liệu
        $imageName2 = $productInfo['image_order'];
    }

    



    // Insert product into the database
    $result = Database::updateOrder($productId, $category_id, $imageName2);

    // Continue with the rest of your form processing...
    // (Ensure that you have validation, sanitization, and other necessary operations here)

    // Redirect or display a success message as needed
    header('Location: quanlydonhang.php');
    exit();
} else {
    // If the form has not been submitted, redirect to the form page
    // header('Location: edit-product.php');
    exit();
}
?>