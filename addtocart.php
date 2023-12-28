<?php
include('includes/Database.php');
   // Create a Database instance

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Lấy dữ liệu từ form
    
    $quantity = isset($_GET["quantity"]) ? $_GET["quantity"] : "";
    $productId = isset($_GET["productId"]) ? $_GET["productId"] : "";
    $userId = isset($_GET["userId"]) ? $_GET["userId"] : "";
    
    // Lưu ý: Trường 'time_create' trong SQL không có trong dữ liệu bạn đã cung cấp.
    // Nếu bạn muốn thêm ngày giờ, bạn cần cung cấp giá trị thích hợp.
    
    // Thêm giá trị vào cơ sở dữ liệu
    Database::addToCart($productId, $userId, $quantity);

    // Thực hiện các thao tác xử lý hoặc lưu trữ dữ liệu tại đây
    // Ví dụ: lưu dữ liệu vào cơ sở dữ liệu, gửi email, vv.

    // Hiển thị thông điệp thành công hoặc chuyển hướng người dùng đến trang khác
    $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

    // Chuyển hướng về trang trước đó
    header("Location: $previousPage");
    exit();
} else {
    // Nếu không phải là phương thức GET, có thể thực hiện xử lý khác tại đây
    echo "<h2>Error: Invalid request method</h2>";
}
?>
