<?php
// Kết nối cơ sở dữ liệu và kiểm tra kết nối
include_once 'includes/Database.php';
$database = new Database();
$db = $database->getConnection();

// Kiểm tra xem 'id' có được truyền từ URL không
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Truy vấn SQL để xóa sản phẩm
    $query = "DELETE FROM products WHERE product_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);

    // Thực hiện truy vấn
    if($stmt->execute()){
        // Chuyển hướng trở lại trang quản lý sản phẩm
        header("Location: admin.php");
        exit();
    } else {
        echo "Xóa sản phẩm thất bại.";
    }

    // Đóng kết nối và statement
    $stmt->close();
    $db->close();
} else {
    echo "ID sản phẩm không hợp lệ.";
}
?>
