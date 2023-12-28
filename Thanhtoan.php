<?php
include('includes/Database.php');


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Lấy dữ liệu từ form
    $totalPrice = isset($_GET["totalPrice"]) ? $_GET["totalPrice"] : "";
    $finaltotal = isset($_GET["finaltotal"]) ? $_GET["finaltotal"] : "";
    $address = isset($_GET["address"]) ? $_GET["address"] : "";
    $user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : "";

    // In thông tin vào tệp văn bản
    $user = Database::getUserById($user_id);
    $cartItems = Database::getCartItemById($user_id);

    // Tạo một đơn đặt hàng mới
    $order_date = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
    $order_address = $address; // Thay đổi thành địa chỉ thực tế

    // Thêm đơn đặt hàng mới
    // Thêm đơn đặt hàng mới
    $sqll = "INSERT INTO `order` (user_id, order_date, order_address, status_id, image_order)
    VALUES ('$user_id', '$order_date', '$order_address', 1, '')"; // Giả sử status_id 1 là trạng thái mặc định
    Database::query($sqll);


    $order_id = Database::getLastOrderId();
    foreach ($cartItems as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
    
        $sql = "INSERT INTO order_detail (order_id, product_id, order_quantity)
                VALUES ('$order_id', '$product_id', '$quantity')";
        Database::query($sql);
    }


    $content = "Name: " . $user['name'] . "\nEmail: " . $user['email'] . "\nPhonenumber: " . $user['phonenumber'] . "\nAddress: " . $address . "\n";
    $content .= "=================================================================\nHÓA ĐƠN\n\n";

    foreach ($cartItems as $cart) {
        $tong = $cart['price'] * $cart['quantity'];

        $content .= "Product name: " . $cart['product_name'] . " x " . $cart['quantity'] . "\n";
        $content .= "Price per product: $" . $cart['price'] . "\n";
        $content .= "Total Price: $" . $tong . "\n\n";
    }


    $content .= "=================================================================\n";
    $content .= "Total Price: $" . $totalPrice . "\nFinal Total: $" . $finaltotal . "\n";

    // Ghi thông tin vào tệp văn bản
    $file = fopen("C:\Users\admin\OneDrive\Desktop\orderphp.txt", "w");
    fwrite($file, $content);
    fclose($file);

    // Xóa tất cả sản phẩm từ giỏ hàng sau khi đặt hàng thành công
    Database::deleteAllProductFromCart($user_id);

    // Đặt biến session thông báo
    $_SESSION['order_success'] = true;

    // Chuyển hướng người dùng đến trang index.php
    header("location: index.php");
} else {
    // Nếu không phải là phương thức GET, có thể thực hiện xử lý khác tại đây
    echo "<h2>Error: Invalid request method</h2>";
}
?>