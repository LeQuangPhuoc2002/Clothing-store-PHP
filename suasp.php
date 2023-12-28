<?php
// themsanpham.php

include('includes/Database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted using POST method

    // Your existing code to process form data...
    // (Ensure that you have validation, sanitization, and other necessary operations here)
    $productId = isset($_POST['id']) ? $_POST['id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';


    $ab = $description;

    if (empty($name) || empty($price) || empty($quantity) || empty($category_id) || empty($description)) {
        // Display an error message and stop execution
        echo 'Vui lòng điền đầy đủ thông tin sản phẩm.';
        exit();
    }

    // Handle file uploads
    $uploadDirectory = 'D:/XAMPP/htdocs/Chapter1/quangphuoc/assets/images/';

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
    $productInfo = Database::getProductById($productId);

    // Xử lý ảnh đầu tiên
    $file1 = $_FILES['file_img'];
    $imageName1 = handleFileUpload($file1, $uploadDirectory);
    if (!isset($imageName1) || empty($imageName1)) {
        // Nếu tên ảnh rỗng hoặc null, gán lại bằng tên ảnh hiện tại trong cơ sở dữ liệu
        $imageName1 = $productInfo['image'];
    }

    // Xử lý ảnh thứ hai
    $file2 = $_FILES['file_img2'];
    $imageName2 = handleFileUpload($file2, $uploadDirectory);
    if (!isset($imageName2) || empty($imageName2)) {
        // Nếu tên ảnh rỗng hoặc null, gán lại bằng tên ảnh hiện tại trong cơ sở dữ liệu
        $imageName2 = $productInfo['image2'];
    }

    // Xử lý ảnh thứ ba
    $file3 = $_FILES['file_img3'];
    $imageName3 = handleFileUpload($file3, $uploadDirectory);
    if (!isset($imageName3) || empty($imageName3)) {
        // Nếu tên ảnh rỗng hoặc null, gán lại bằng tên ảnh hiện tại trong cơ sở dữ liệu
        $imageName3 = $productInfo['image3'];
    }



    // Insert product into the database
    $result = Database::updateProduct($productId, $name, $price, $quantity, $category_id, $description, $imageName1, $imageName2, $imageName3);

    // Continue with the rest of your form processing...
    // (Ensure that you have validation, sanitization, and other necessary operations here)

    // Redirect or display a success message as needed
    header('Location: admin.php');
    exit();
} else {
    // If the form has not been submitted, redirect to the form page
    header('Location: edit-product.php');
    exit();
}
?>