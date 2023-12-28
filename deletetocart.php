<?php
include('includes/Database.php');
   // Create a Database instance

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Lấy dữ liệu từ form
    
    $user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : "";
    $product_id = isset($_GET["product_id"]) ? $_GET["product_id"] : "";
    
    
    // Lưu ý: Trường 'time_create' trong SQL không có trong dữ liệu bạn đã cung cấp.
    // Nếu bạn muốn thêm ngày giờ, bạn cần cung cấp giá trị thích hợp.
    
    // Thêm giá trị vào cơ sở dữ liệu
    Database::deleteFromCart($user_id, $product_id);

    // Thực hiện các thao tác xử lý hoặc lưu trữ dữ liệu tại đây
    // Ví dụ: lưu dữ liệu vào cơ sở dữ liệu, gửi email, vv.

    // Hiển thị thông điệp thành công hoặc chuyển hướng người dùng đến trang khác
    header("location: cart.php");
} else {
    // Nếu không phải là phương thức GET, có thể thực hiện xử lý khác tại đây
    echo "<h2>Error: Invalid request method</h2>";
}
?>
