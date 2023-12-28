<?php
include('includes/Database.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $name = isset($_GET["name"]) ? $_GET["name"] : "";
    $username = isset($_GET["username"]) ? $_GET["username"] : "";
    $email = isset($_GET["email"]) ? $_GET["email"] : "";
    $phoneNumber = isset($_GET["phone"]) ? $_GET["phone"] : "";
    $password = isset($_GET["password"]) ? $_GET["password"] : "";
    $repassword = isset($_GET["repassword"]) ? $_GET["repassword"] : "";

    if ($password != $repassword) {
        $_SESSION["error"] = "Mật khẩu và xác nhận mật khẩu không trùng khớp";
        header("location: register.php");
        exit(); // Đảm bảo chuyển hướng là kết thúc ngay lập tức
    }
    Database::insertUserWithCart($username, $email, $repassword, $phoneNumber, $name);
    // Giả sử Database::query là cách an toàn để thực hiện truy vấn để ngăn chặn SQL injection
    $passwords = Database::generateMD5($repassword);
    $query = Database::query("SELECT * FROM users WHERE (email = '$email' OR username = '$username') AND password = '$passwords'");

    $user = $query->fetch_array();

    // Sau khi kiểm tra đăng nhập thành công
    // After verifying the user's credentials and before redirecting

    $_SESSION['user'] = $user;
    $_SESSION['name'] = $user['name']; // Make sure 'name' is a valid key in your user data
    $_SESSION['id'] = $user['user_id']; // Add this line to store user id in session
    header("location: index.php?id=" . $user['user_id']);
    exit();

} else {
    echo "<h2>Error: Invalid request method</h2>";
}
?>