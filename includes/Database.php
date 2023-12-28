<?php
session_start();

class Database
{
  static $con;

  public static function getConnection()
  {
    if (self::$con == null) {
      return new mysqli("localhost", "root", "", "clothing_store");
    }
    return null;
  }

  public static function query($sql, $types = null, ...$params)
  {
    $con = self::getConnection();

    if ($con) {
      $stmt = $con->prepare($sql);

      if ($stmt) {
        if ($types && $params) {
          $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $con->close();

        return $result;
      } else {
        $con->close();
        return false;
      }
    } else {
      return false;
    }
  }

  public static function getOrderById($orderId) {
    $sql = "SELECT * FROM `order` WHERE order_id = ?";
    $result = self::query($sql, "i", $orderId);

    if ($result && $result->num_rows > 0) {
        $orderInfo = $result->fetch_assoc();
        return $orderInfo;
    } else {
        return null;
    }
}
  public static function updateOrder($orderId, $statusId, $imageOrder)
  {
    $sql = "UPDATE `order`
            SET status_id = $statusId,
                image_order = '$imageOrder'
            WHERE order_id = $orderId";
    return Database::query($sql);
  }
  public static function getOrder($orderId)
  {
    $sql = "SELECT * FROM `order` WHERE order_id = $orderId";
    return Database::query($sql);
  }
  public static function getOrderDetailByOrderId($orderId)
  {
    $sql = "SELECT * FROM order_detail WHERE order_id = $orderId";
    return Database::query($sql);
  }
  public static function getStatus()
  {
    $sql = "SELECT * FROM status";
    return Database::query($sql);
  }
  public static function getLastOrderId()
  {
    $sql = "SELECT order_id FROM `order` ORDER BY order_id DESC LIMIT 1";
    $result = Database::query($sql);

    if ($result) {
      $row = $result->fetch_assoc();
      return $row['order_id'];
    } else {
      return null; // Hoặc xử lý lỗi theo nhu cầu của bạn
    }
  }
  public static function insertOrder($userId, $totalAmount, $orderDate)
  {
    $sql = "INSERT INTO order (user_id, total_amount, order_date) VALUES (?, ?, ?)";
    $types = "ids"; // Assuming user_id is integer, total_amount is double/float, and order_date is string (adjust if needed)

    $result = self::query($sql, $types, $userId, $totalAmount, $orderDate);

    return $result !== false ? $result : false;
  }

  public static function selectAllOrderByUserId($userId)
  {
    $sql = "SELECT * FROM order_detail WHERE order_id IN (SELECT order_id FROM orders WHERE user_id = ?) ";
    $types = "i"; // Assuming user_id is an integer, adjust if needed

    $result = self::query($sql, $types, $userId);

    if ($result !== false) {
      // Fetch the result set as an associative array
      $data = $result->fetch_all(MYSQLI_ASSOC);
      return $data;
    } else {
      return false; // Error occurred during query execution
    }
  }
  public static function updateProduct($productId, $name, $price, $quantity, $category_id, $description, $image1_path, $image2_path, $image3_path)
  {
    // Check if the product with the given ID exists
    $existingProduct = self::getProductById($productId);
    if (!$existingProduct) {
      return false; // Product does not exist
    }

    $sql = "UPDATE products SET product_name = ?, price = ?, category_id = ?, image = ?, image2 = ?, image3 = ?, description = ?, quantity = ? WHERE product_id = ?";

    $types = "sdisssisi"; // Sửa lại kiểu dữ liệu cho đúng

    // Chuyển đổi kiểu dữ liệu nếu cần
    $price = (double) $price;
    $quantity = (int) $quantity;

    $result = self::query($sql, $types, $name, $price, $category_id, $image1_path, $image2_path, $image3_path, $description, $quantity, $productId);

    return $result;
  }

  public static function insertProduct($name, $price, $quantity, $category_id, $description, $image1_path, $image2_path, $image3_path)
  {
    $sql = "INSERT INTO products (product_name, price, category_id, image, image2, image3, description, quantity)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $types = "sdisssis"; // Sửa lại kiểu dữ liệu cho đúng

    // Chuyển đổi kiểu dữ liệu nếu cần
    $price = (double) $price;
    $quantity = (int) $quantity;

    $result = self::query($sql, $types, $name, $price, $category_id, $image1_path, $image2_path, $image3_path, $description, $quantity);

    return $result;
  }

  public static function getCategories()
  {
    $sql = "SELECT * FROM categories";
    $result = self::query($sql);

    $categories = array();

    while ($row = $result->fetch_assoc()) {
      $categories[] = $row;
    }

    return $categories;
  }

  public static function getProductById($productId)
  {
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $result = self::query($sql, "i", $productId);

    if ($result && $result->num_rows > 0) {
      $productInfo = $result->fetch_assoc();
      return $productInfo;
    } else {
      return null;
    }
  }

  public static function getProductCategoryById($productId)
  {
    $sql = "
        SELECT p.*, c.category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.category_id
        WHERE p.product_id = ?
    ";

    $result = self::query($sql, "i", $productId);

    if ($result && $result->num_rows > 0) {
      $productInfo = $result->fetch_assoc();
      return $productInfo;
    } else {
      return null;
    }
  }

  public static function addComment($productId, $userId, $commentText)
  {
    $sql = "INSERT INTO comments (product_id, user_id, comment_text) VALUES (?, ?, ?)";
    return self::query($sql, "iis", $productId, $userId, $commentText);
  }
  public static function addToCart($productId, $userId, $quantity)
  {
    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của người dùng chưa
    $existingCartItem = self::getCartItem($productId, $userId);

    if ($existingCartItem) {
      // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
      $newQuantity = $existingCartItem['quantity'] + $quantity;
      $cartItemId = $existingCartItem['cart_item_id'];

      $sqlUpdate = "UPDATE cart_item SET quantity = ? WHERE cart_item_id = ?";
      return self::query($sqlUpdate, "ii", $newQuantity, $cartItemId);
    } else {
      // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
      $sqlInsert = "INSERT INTO cart_item (cart_id, product_id, quantity) VALUES ((SELECT cart_id FROM cart WHERE user_id = ?), ?, ?)";
      return self::query($sqlInsert, "iii", $userId, $productId, $quantity);
    }
  }

  public static function getCartItem($productId, $userId)
  {
    // Lấy thông tin của một mục trong giỏ hàng dựa trên product_id và user_id
    $sql = "SELECT * FROM cart_item WHERE product_id = ? AND cart_id = (SELECT cart_id FROM cart WHERE user_id = ?)";
    $result = self::query($sql, "ii", $productId, $userId);

    if ($result && $result->num_rows > 0) {
      return $result->fetch_assoc();
    } else {
      return null;
    }
  }

  public static function getCartItemById($userId)
  {
    // Lấy thông tin của tất cả các mục trong giỏ hàng dựa trên user_id
    $sql = "SELECT cart_item.*, products.product_name, products.price
              FROM cart_item
              JOIN products ON cart_item.product_id = products.product_id
              WHERE cart_item.cart_id = (SELECT cart_id FROM cart WHERE user_id = ?)";

    $result = self::query($sql, "i", $userId);

    $cartItems = array();

    while ($row = $result->fetch_assoc()) {
      $cartItems[] = $row;
    }

    return $cartItems;
  }
  public static function getOrderItemsByUserId($userId)
  {
    $sql = "SELECT order_item.*, products.product_name, products.price
              FROM order_item
              JOIN products ON order_item.product_id = products.product_id
              WHERE order_item.order_id IN (SELECT order_id FROM orders WHERE user_id = ?)";

    $result = self::query($sql, "i", $userId);

    $orderItems = array();

    while ($row = $result->fetch_assoc()) {
      $orderItems[] = $row;
    }

    return $orderItems;
  }

  public static function updateToCart($user_id, $productId, $newQuantity)
  {
    // Kiểm tra xem số lượng mới có phải là 0 không
    if ($newQuantity === 0) {
      // Nếu là 0, thực hiện xóa mục khỏi giỏ hàng
      return self::deleteFromCart($user_id, $productId);
    } else {
      // Ngược lại, thực hiện cập nhật số lượng
      $sqlUpdate = "UPDATE cart_item SET quantity = ? WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = ?) AND product_id = ?";
      return self::query($sqlUpdate, "iii", $newQuantity, $user_id, $productId);
    }
  }

  public static function deleteFromCart($user_id, $productId)
  {
    // Chắc chắn rằng bạn đang sử dụng câu lệnh DELETE chính xác
    $sqlDelete = "DELETE FROM cart_item WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = ?) AND product_id = ?";

    // Thực hiện truy vấn DELETE và kiểm tra kết quả
    $result = self::query($sqlDelete, "ii", $user_id, $productId);

    // Kiểm tra xem có lỗi xảy ra hay không
    if ($result) {
      return true; // Xóa thành công
    } else {
      return false; // Xóa thất bại
    }
  }
  public static function deleteAllProductFromCart($user_id)
  {
    // Chắc chắn rằng bạn đang sử dụng câu lệnh DELETE chính xác
    $sqlDelete = "DELETE FROM cart_item WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = ?)";

    // Thực hiện truy vấn DELETE và kiểm tra kết quả
    $result = self::query($sqlDelete, "i", $user_id);

    // Kiểm tra xem có lỗi xảy ra hay không
    if ($result) {
      return true; // Xóa thành công
    } else {
      return false; // Xóa thất bại
    }
  }
  public static function getUserById($userId)
  {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $result = self::query($sql, "i", $userId);

    if ($result && $result->num_rows > 0) {
      return $result->fetch_assoc();
    } else {
      return null;
    }
  }

  public static function getUserId($email)
  {
    $sql = "SELECT user_id FROM users WHERE email = ?";
    $result = self::query($sql, "s", $email);

    if ($result === false) {
      // Xử lý lỗi SQL
      die("SQL error: " . self::getConnection()->error);
    }

    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['user_id'];
    }

    return -1; // Hoặc false
  }

  // Define the generateMD5 function
  public static function generateMD5($input)
  {
    return md5($input);
  }
  public static function insertUser($username, $email, $password, $phoneNumber, $name)
  {
    // Hash the password using MD5 (for demonstration purposes, but consider using a more secure hashing algorithm)
    $md5Password = self::generateMD5($password);

    // Insert user with a prepared statement
    $sqlInsertUser = "INSERT INTO users (username, password, phonenumber, name, email) VALUES (?, ?, ?, ?, ?)";
    $resultInsertUser = self::query($sqlInsertUser, "sssss", $username, $md5Password, $phoneNumber, $name, $email);

    if ($resultInsertUser) {
      // Return the user_id of the newly added user
      return self::getUserId($email);
    }

    return false;
  }

  public static function insertCart($userId)
  {
    // Insert cart with a preparedstatement
    $sqlInsertCart = "INSERT INTO cart (user_id) VALUES (?)";
    $resultInsertCart = self::query($sqlInsertCart, "i", $userId);

    return $resultInsertCart;
  }

  public static function insertUserWithCart($username, $email, $password, $phoneNumber, $name)
  {
    $userId = self::insertUser($username, $email, $password, $phoneNumber, $name);

    $id = self::getUserId($email);
    if ($id !== false) {
      echo "Người dùng được chèn với user_id: " . $id;

      // Kiểm tra giá trị user_id trước khi thêm giỏ hàng
      if (!empty($id)) {
        $resultInsertCart = self::insertCart($id);
      } else {
        echo "Giá trị user_id không hợp lệ";
      }
    }

    return false;
  }



  // Hàm xóa người dùng
  private static function deleteUser($userId)
  {
    $sqlDeleteUser = "DELETE FROM users WHERE user_id = ?";
    self::query($sqlDeleteUser, "i", $userId);
  }


  private static function getUserIdByEmail($email)
  {
    $sql = "SELECT user_id FROM users WHERE email = ?";
    $result = self::query($sql, "s", $email);

    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['user_id'];
    }

    return null;
  }




}


function _header($title)
{
  $s = '
        <!DOCTYPE html>
          <html lang="vi">
          <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>' . $title . '</title>
              <link rel="stylesheet" href="assets/css/bootstrap.min.css">
              <script src="assets/js/bootstrap.bundle.min.js"></script>
              <script src="https://apis.google.com/js/platform.js" async defer></script>
              <meta name="google-signin-client_id" content="your-client-id.apps.googleusercontent.com">
          </head>     
      ';
  echo $s;
}

function _navbar()
{
  $s = ' 
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <!-- Container wrapper -->
            <div class="container">
                <!-- Navbar brand -->
                <a href="Trangchu.php">
              <img src="assets/icon/husc_logo.png" width="50" height="50" class="ms-auto" style="margin-right: 150px;" alt="HUSC Logo">
          </a>
                <!-- Search form -->
                <form class="input-group mx-auto" style="width: 400px">
                    <input type="search" class="form-control" placeholder="Type query" aria-label="Search" />
                    <button class="btn btn-outline-primary" type="button" data-mdb-ripple-color="dark"
                        style="padding: .45rem 1.5rem .35rem;">
                        Search
                    </button>
                </form>

            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
              data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="Toggle navigation">
              <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Left links -->
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active d-flex flex-column text-center" aria-current="page" href="index.php"><i class="fas fa-home fa-lg"></i><span class="small">Home</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link d-flex flex-column text-center" aria-current="page" href="login.php"><i class="fas fa-briefcase fa-lg"></i><span class="small">
                <img src="assets/icon/cart.png" width="30" height="30" class="ms-auto" alt="HUSC Logo">
                </span></a> 
                <li class="nav-item">
                <a class="nav-link d-flex flex-column text-center" aria-current="page" href="login.php"><i class="fas fa-briefcase fa-lg"></i><span class="small">Login</span></a>
              </li>
              
                  
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex flex-column text-center" aria-current="page" href="login.php"><i class="fas fa-comment-dots fa-lg"></i><span class="small">Logout</span></a>
                </li>            
              </ul>
              <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->
          </div>
          <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
        <br><br><br>
        ';
  echo $s;
}



function _footer()
{
  $s = '
      <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
      <div class="row px-xl-5 pt-5">
          <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
              <a href="Trangchu.php" class="text-decoration-none">
                  <img class="img-fluid rounded mb-4" loading="lazy" src="./assets/Icon/husc_logo.png" width="80" height="100" alt="">
              </a>
              <p>Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.</p>
              <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Lê Lợi ,Huế</p>
              <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
              <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
          </div>
          <div class="col-lg-8 col-md-12">
              <div class="row">
                  <div class="col-md-4 mb-5">
                      <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                      <div class="d-flex flex-column justify-content-start">
                          <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                          <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                          <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                          <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                          <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                          <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                      </div>
                  </div>
                  <div class="col-md-4 mb-5">
                      <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                      <div class="d-flex flex-column justify-content-start">
                          <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                          <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                          <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                          <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                          <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                          <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                      </div>
                  </div>
                  <div class="col-md-4 mb-5">
                      <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                      <form action="">
                          <div class="form-group">
                              <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
                          </div>
                          <br />
                          <div class="form-group">
                              <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                  required="required" />
                          </div>
                          <br />
                          <div>
                              <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                          </div>
                          
                      </form>
                  </div>
              </div>
          </div>
      </div>  
  </div>
      ';
  echo $s;
}


function _login_admin()
{

  $thongBaoLoiDangNhap = '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      // Kiểm tra và làm sạch dữ liệu nếu cần thiết

      // Giả sử Database::query là cách an toàn để thực hiện truy vấn để ngăn chặn SQL injection
      $query = Database::query("SELECT * FROM admins WHERE (email = '$email' OR phonenumber = '$email') AND admin_password = '$password'");

      $admin = $query->fetch_array();

      if ($admin) {
        $_SESSION['admin'] = $admin;
        $_SESSION['name'] = $admin['name'];
        $_SESSION['id'] = $admin['admin_id'];
        header("location: admin.php?id=" . $admin['admin_id']);
        exit();
      } else {
        $thongBaoLoiDangNhap = 'Email hoặc mật khẩu không đúng.';
      }
    } else {
      $thongBaoLoiDangNhap = 'Vui lòng điền đầy đủ thông tin đăng nhập.';
    }
  }

  $s = '
    <!-- Login 9 - Bootstrap Brain Component -->
    <section class="bg-primary py-3 py-md-5 py-xl-8">
      <div class="container">
        <div class="row gy-4 align-items-center">
          <div class="col-12 col-md-6 col-xl-7">
            <div class="d-flex justify-content-center text-bg-primary">
              <div class="col-12 col-xl-9">
                <img class="img-fluid rounded mb-4" loading="lazy" src="./assets/Icon/tải xuống.png" width="500" height="150" alt="">
                <hr class="border-primary-subtle mb-4">
                <h2 class="h1 mb-4">
                Giao diện đăng nhập dành cho quản trị viên.</h2>
                <p class="lead mb-5">
                Giao diện đăng nhập cho quản trị viên là nơi chuyên dụng được thiết kế để cung cấp trải nghiệm nhập hệ thống mượt mà và an toàn. Với giao diện này, quản trị viên có thể dễ dàng truy cập vào hệ thống để quản lý và kiểm soát các chức năng quan trọng. Thiết kế tối giản nhưng mạnh mẽ của giao diện giúp tối ưu hóa quá trình đăng nhập, đồng thời tạo ra một không gian làm việc chuyên nghiệp và hiệu quả. Giao diện đồng thời cung cấp các tùy chọn bảo mật linh hoạt, đảm bảo rằng chỉ những người có quyền truy cập được phép nhập hệ thống.               
                </p>
                <div class="text-endx">
                  <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-grip-horizontal" viewBox="0 0 16 16">
                    <path d="M2 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-xl-5">
            <div class="card border-0 rounded-4">
              <div class="card-body p-3 p-md-4 p-xl-5">
                <div class="row">
                  <div class="col-12">
                    <div class="mb-4">
                      <h3>ADMIN ĐĂNG NHẬP</h3>
                      <p>Mời nhập tài khoản và mật khẩu</p>
                    </div>
                  </div>
                </div>  ';

  // Display login error message
  if (!empty($thongBaoLoiDangNhap)) {
    $s .= '<div class="alert alert-danger">' . $thongBaoLoiDangNhap . '</div>';
  }

  $s .= '<form action="" method="POST">
                  <div class="row gy-3 overflow-hidden">
                    <div class="col-12">
                      <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                        <label for="email" class="form-label">Email</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                        <label for="password" class="form-label">Password</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
                        <label class="form-check-label text-secondary" for="remember_me">
                        Giữ tôi đăng nhập
                        </label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-grid">
                        <button class="btn btn-primary btn-lg" type="submit">Đăng nhập</button>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="row">
                  <div class="col-12">
                    <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
                      <a href="#!">Quên mật khẩu</a>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <p class="mt-4 mb-4">
                    Hoặc tiếp tục với</p>
                    <div class="d-flex gap-2 gap-sm-3 justify-content-centerX">
                      <a href="#!" class="btn btn-outline-danger bsb-btn-circle bsb-btn-circle-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                          <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                        </svg>
                      </a>
                      <a href="#!" class="btn btn-outline-primary bsb-btn-circle bsb-btn-circle-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                          <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                        </svg>
                      </a>
                      <a href="#!" class="btn btn-outline-dark bsb-btn-circle bsb-btn-circle-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-apple" viewBox="0 0 16 16">
                          <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43Zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56.244.729.625 1.924 1.273 2.796.576.984 1.34 1.667 1.659 1.899.319.232 1.219.386 1.843.067.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758.347-.79.505-1.217.473-1.282Z" />
                          <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43Zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56.244.729.625 1.924 1.273 2.796.576.984 1.34 1.667 1.659 1.899.319.232 1.219.386 1.843.067.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758.347-.79.505-1.217.473-1.282Z" />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>';
  echo $s;
}

function _password()
{
  $s = '<!DOCTYPE html>
        <html lang="en">
        
        <head>
        <title>Reset Password | Berry Bootstrap 5 Admin Template</title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Berry is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
        <meta name="keywords" content="Berry, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
        <meta name="author" content="CodedThemes">
        
        <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon">
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" id="main-font-link">
        
        <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css">
        
        <link rel="stylesheet" href="../assets/fonts/feather.css">
        
        <link rel="stylesheet" href="../assets/fonts/fontawesome.css">
        
        <link rel="stylesheet" href="../assets/fonts/material.css">
        
        <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link">
        <link rel="stylesheet" href="../assets/css/style-preset.css" id="preset-style-link">
        </head>
        
        
        <body>
        
        <div class="loader-bg">
        <div class="loader-track">
        <div class="loader-fill"></div>
        </div>
        </div>
        
        <div class="auth-main">
        <div class="auth-wrapper v3">
        <div class="auth-form">
        <div class="card mt-5">
        <div class="card-body">
        <a href="#" class="d-flex justify-content-center">
        <img src="../assets/images/logo-dark.svg" alt="image">
        </a>
        <div class="row">
        <div class="d-flex justify-content-center">
        <div class="text-center">
        <h2 class="text-secondary mt-5"><b>Reset Password</b></h2>
        <p class="f-16 mt-3">Please choose your new password.</p>
        </div>
        </div>
        </div>
        <div class="form-floating mt-2">
        <input type="password" class="form-control" id="floatingInput" placeholder="Password">
        <label for="floatingInput">Password</label>
        </div>
        <div class="form-floating mt-3">
        <input type="password" class="form-control" id="floatingInput1" placeholder="Confirm Password">
        <label for="floatingInput1">Confirm Password</label>
        </div>
        <div class="d-grid mt-4">
        <button type="button" class="btn btn-secondary p-2">Reset Password</button>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        
        <script src="../assets/js/plugins/popper.min.js"></script>
        <script src="../assets/js/plugins/simplebar.min.js"></script>
        <script src="../assets/js/plugins/bootstrap.min.js"></script>
        <script src="../assets/js/config.js"></script>
        <script src="../assets/js/pcoded.js"></script>
        <script src="../assets/js/plugins/feather.min.js"></script>
        <div class="pct-c-btn">
        <button class="btn btn-secondary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_layout">
        <i data-feather="settings"></i>
        </button>
        </div>
        <div class="offcanvas pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_layout">
        <div class="offcanvas-header">
        <h5 class="offcanvas-title">Berry Customizer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="pct-body" style="height: calc(100% - 60px)">
        <div class="offcanvas-body">
        <div class="card">
        <div class="card-header">
        <h5>Layout</h5>
        </div>
        <div class="card-body">
        <p class="mb-1">Mode</p>
        <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="layout_mode" id="layoutmodelight" onclick="layout_change(' . 'light' . ')">
        <label class="form-check-label" for="layoutmodelight"> Light </label>
        </div>
        <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="layout_mode" id="layoutmodedark" onclick="layout_change(' . 'dark' . ')">
        <label class="form-check-label" for="layoutmodedark"> Dark </label>
        </div>
        <div class="pc-rtl">
        <p class="mt-3 mb-1">Direction</p>
        <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="layoutmodertl">
        <label class="form-check-label" for="layoutmodertl">RTL</label>
        </div>
        </div>
        </div>
        </div>
        <div class="card">
        <div class="card-header">
        <h5>Preset Color</h5>
        </div>
        <div class="card-body">
        <div class="theme-color preset-color">
        <a href="#!" class="active" data-value="preset-1"><span></span><span></span></a>
        <a href="#!" class data-value="preset-2"><span></span><span></span></a>
        <a href="#!" class data-value="preset-3"><span></span><span></span></a>
        <a href="#!" class data-value="preset-4"><span></span><span></span></a>
        <a href="#!" class data-value="preset-5"><span></span><span></span></a>
        <a href="#!" class data-value="preset-6"><span></span><span></span></a>
        <a href="#!" class data-value="preset-7"><span></span><span></span></a>
        </div>
        </div>
        </div>
        <div class="card">
        <div class="card-header">
        <h5>Font Family</h5>
        </div>
        <div class="card-body">
        <div class="form-check">
        <input class="form-check-input" type="radio" name="layout_font" id="layoutfontRoboto" checked onclick="font_change(' . 'Roboto' . ')">
        <label class="form-check-label" for="layoutfontRoboto"> Roboto </label>
        </div>
        <div class="form-check">
        <input class="form-check-input" type="radio" name="layout_font" id="layoutfontPoppins" onclick="font_change(' . 'Poppins' . ')">
        <label class="form-check-label" for="layoutfontPoppins"> Poppins </label>
        </div>
        <div class="form-check">
        <input class="form-check-input" type="radio" name="layout_font" id="layoutfontInter" onclick="font_change(' . 'Inter' . ')">
        <label class="form-check-label" for="layoutfontInter"> Inter </label>
        </div>
        </div>
        </div>
        <div class="card pc-boxcontainer">
        <div class="card-header">
        <h5>Box Container</h5>
        </div>
        <div class="card-body">
        <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="layoutboxcontainer">
        <label class="form-check-label" for="layoutboxcontainer">Container</label>
        </div>
        </div>
        </div>
        <div class="d-grid">
        <button class="btn btn-light-danger" id="layoutreset">Reset Layout</button>
        </div>
        </div>
        </div>
        </div>
        <script src="../assets/js/customizer.js"></script>
        </body>
        
        </html>
        ';
  echo $s;
}

function _register()
{
  // Kiểm tra nếu biểu mẫu đã được gửi đi
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoTen = $_POST["hoTen"];
    $email = $_POST["email"];
    $matKhau = $_POST["matKhau"];
    $xacNhanMatKhau = $_POST["xacNhanMatKhau"];

    if (empty($hoTen) || empty($email) || empty($matKhau) || empty($xacNhanMatKhau)) {
      echo "Vui lòng điền đầy đủ thông tin.";
      return;
    }

    if ($matKhau != $xacNhanMatKhau) {
      echo "Mật khẩu và Xác nhận mật khẩu không khớp.";
      return;
    }

    $matKhauMaHoa = password_hash($matKhau, PASSWORD_DEFAULT);

    $conn = Database::getConnection();

    if ($conn->connect_error) {
      die("Kết nối thất bại: " . $conn->connect_error);
    }

    $sql = "INSERT INTO user (name, email, phone, password) VALUES ('$hoTen','$email','','$matKhauMaHoa')";

    if (Database::query($sql) === TRUE) {
      echo "Đăng ký thành công!";
    } else {
      echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
  }

  $s = '<section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
              <div class="card text-black" style="border-radius: 25px;">
                <div class="card-body p-md-5">
                  <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                    
                    <a class="mx-1 mx-md-5" href="login.php">QUAY TRỞ LẠI TRANG ĐĂNG NHẬP.</a>
                      <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">THÔNG TIN</p>
      
                      <form id="registrationForm" class="mx-1 mx-md-4" method="get" action="">
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                          <label class="form-label" for="form3Example1c">Họ và tên</label>
                            <input type="text" id="form3Example1c" class="form-control" />
                         
                          </div>
                        </div>
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                          <label class="form-label" for="form3Example3c">Email</label>
                            <input type="email" id="form3Example3c" class="form-control" />
                          
                          </div>
                        </div>
      
                    

                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                          <label class="form-label" for="form3Example4c">Mật khẩu</label>
                            <input type="password" id="form3Example4c" class="form-control" />
                            
                          </div>
                        </div>
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                          <label class="form-label" for="form3Example4cd">Xác nhận mật khẩu</label>
                            <input type="password" id="form3Example4cd" class="form-control" />
                           
                          </div>
                        </div>
      
                        <div class="form-check d-flex justify-content-center mb-5">
                          <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                          <label class="form-check-label" for="form2Example3">Tôi đồng ý với tất cả các thông tin về <a href="#!">Điều khoản.</a>
                          </label>
                        </div>
                        
      
                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                        <button type="submit" class="btn btn-primary btn-lg">Đăng ký</button>
                    </div>
      
                      </form>
      
                    </div>
                    <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
      
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                        class="img-fluid" alt="Sample image">
                        
                    </div>
                   
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>';
  echo $s;
}

function _body_admin()
{
  // Xử lý tìm kiếm
  $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
  $search_condition = $search_query ? "WHERE product_name LIKE '%$search_query%'" : '';

  // Hiển thị tiêu đề
  echo '
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-12 col-md-10 text-center">
                  <div class="heading pb-4">
                      <h2>Quản lý sản phẩm</h2>
                      <br>
                  </div>
              </div>
          </div>
                
          <a href="addproduct.php">
              <button class="btn btn-primary" type="button">Thêm sản phẩm</button>
          </a>
          <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
          <div class="container">
              <div class="row">
                  <div class="col-lg-14">
                      <div class="main-box clearfix">
                          <div class="table-responsive">
                              <table class="table user-list">
                                  <thead>
                                      <tr>
                                          <th><span>STT</span></th>                                          
                                          <th><span>Ảnh</span></th>
                                          <th><span>Id sản phẩm</span></th>
                                          <th><span>Tên sản phẩm</span></th>                                        
                                          <th><span>Mô tả</span></th>
                                          <th><span>Loại sản phẩm</span></th>
                                          <th><span>Giá sản phẩm</span></th>                                          
                                          <th class="text-center"><span>Số lượng</span></th>
                                          <th><span>Quản lý</span></th>
                                          <th>&nbsp;</th>
                                      </tr>
                                  </thead>
                                  <tbody>';


  // Truy vấn cơ sở dữ liệu với điều kiện tìm kiếm
  $q1 = Database::query("SELECT products.*, categories.category_name 
      FROM products 
      JOIN categories ON products.category_id = categories.category_id $search_condition");

  $count = 1; // Biến đếm số thứ tự
  while ($r1 = $q1->fetch_array()) {
    echo '<tr>
              <td class="text-center">
                  <span class="label label-default">' . $count . '</span>
              </td>
              <td>
                  <span class="label label-default"><img src="assets/images/' . $r1['image'] . '" width="100" height="100"></span>
              </td>
              <td  class="text-center">
                  <span class="label label-default">' . $r1['product_id'] . '</span>
              </td>
              <td>
                  <span class="label label-default">' . $r1['product_name'] . '</span>
              </td>
              <td>
                  <span class="label label-default">' . $r1['description'] . '</span>
              </td>
              <td>
                  <span class="label label-default">' . $r1['category_name'] . '</span>
              </td>
              <td>' . $r1['price'] . ' $</td>
              <td class="text-center">
                  <span class="label label-default">' . $r1['quantity'] . '</span>
              </td>
         
                      <td style="width: 7%;">
                    <a href="edit-product.php?id=' . $r1['product_id'] . '" class="table-link">
                        <span class="fa-stack">
                            <i class="fa fa-square fa-stack-2x"></i>
                            <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <a href="delete-product.php?id=' . $r1['product_id'] . '" class="table-link danger delete-product" onclick="return confirm(\'Bạn có chắc chắn muốn xóa sản phẩm này không?\');">
                        <span class="fa-stack">
                            <i class="fa fa-square fa-stack-2x"></i>
                            <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                </td>
          </tr>';
    $count++; // Tăng giá trị của biến đếm
  }

  // Đóng table và các container
  echo '</tbody></table></div></div></div></div></div>';
}

function _addproduct()
{
  $errName = $errPrice = $errQuantity = $errDescription = $errImage = $errImage2 = $errImage3 = '';
  $successMessage = ''; // Thêm biến để lưu thông báo thành công

  if (isset($_POST['name'])) {
    // Kiểm tra các điều kiện cần thiết
    if (empty($_POST['name'])) {
      $errName = 'Vui lòng nhập tên sản phẩm.';
    }

    if (empty($_POST['price'])) {
      $errPrice = 'Vui lòng nhập giá sản phẩm.';
    }

    if (empty($_POST['quantity'])) {
      $errQuantity = 'Vui lòng nhập số lượng sản phẩm.';
    }

    // Thêm điều kiện kiểm tra loại sản phẩm
    if (empty($_POST['category_id'])) {
      // Nếu không có loại sản phẩm được chọn
      echo '<script>alert("Vui lòng chọn loại sản phẩm.")</script>';
    }

    // Thêm điều kiện kiểm tra mô tả sản phẩm
    if (empty($_POST['description'])) {
      $errDescription = 'Vui lòng nhập mô tả sản phẩm.';
    }

    // Kiểm tra ảnh 1
    if (empty($_FILES['file_img']['name'])) {
      $errImage = '<br/>Vui lòng chọn ảnh sản phẩm.';
    }

    // Kiểm tra ảnh 2
    if (empty($_FILES['file_img2']['name'])) {
      $errImage2 = '<br/>Vui lòng chọn ảnh sản phẩm.';
    }

    // Kiểm tra ảnh 3
    if (empty($_FILES['file_img3']['name'])) {
      $errImage3 = '<br/>Vui lòng chọn ảnh sản phẩm.';
    }

    // Kiểm tra các điều kiện cần thiết
    if ($errName == '' && $errPrice == '' && $errQuantity == '' && $errDescription == '' && $errImage == '' && $errImage2 == '' && $errImage3 == '') {
      $imageExtension = strtolower(pathinfo($_FILES['file_img']['name'], PATHINFO_EXTENSION));

      // Kiểm tra định dạng file, chỉ chấp nhận jpg hoặc png
      if ($imageExtension != 'jpg' && $imageExtension != 'png') {
        $errImage = 'Chỉ chấp nhận định dạng ảnh JPG hoặc PNG.';
      } else {
        $imageName = $_POST['name'] . "." . $imageExtension;

        // Lưu ảnh vào thư mục uploads
        $uploadDir = "D:/XAMPP/htdocs/Chapter1/DoAnWebCuoiKy/assets/images/";

        move_uploaded_file($_FILES['file_img']['tmp_name'], $uploadDir . $imageName);
        move_uploaded_file($_FILES['file_img2']['tmp_name'], $uploadDir . $_FILES['file_img2']['name']);
        move_uploaded_file($_FILES['file_img3']['tmp_name'], $uploadDir . $_FILES['file_img3']['name']);

        $sql = "INSERT INTO products (product_name, price, category_id, image, image2, image3, description, quantity) VALUES (
                      '" . $_POST['name'] . "', 
                      '" . $_POST['price'] . "', 
                      '" . $_POST['category_id'] . "', 
                      '" . $imageName . "',
                      '" . $_FILES['file_img2']['name'] . "',
                      '" . $_FILES['file_img3']['name'] . "',
                      '" . $_POST['description'] . "',
                      '" . $_POST['quantity'] . "'
                  )";

        $q = Database::query($sql);

        if ($q) {
          $successMessage = 'Thêm sản phẩm ' . $_POST['name'] . ' thành công'; // Lưu thông báo thành công
          header("Location: admin.php"); // Chuyển hướng đến trang thành công
          exit();
        } else {
          echo "Lỗi khi thêm sản phẩm vào cơ sở dữ liệu.";
        }
      }
    }
  }
  echo '
      <div class="container">
     
        <section class="panel panel-default">
      <div class="panel-heading"> 
      <br>
      <h3 class="panel-title">ADD PRODUCT</h3> 
      </div> 
      <div class="panel-body">
      <div class="panel-heading"> 
      <br>
      <h3 class="panel-title">THÊM SẢN PHẨM</h3> 
      </div> 
      <div class="panel-body">
      
        
      <form action="" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
      <div class="form-group">
      <label for="name" class="col-sm-3 control-label">Tên sản phẩm</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="name" placeholder="Áo...">
        <span style="color: red;">' . $errName . '</span>
      </div>
    </div> <!-- form-group // -->
    

    <div class="form-group">
      <label for="name" class="col-sm-3 control-label">Giá</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="price" placeholder="$$...">
        <span style="color: red;">' . $errPrice . '</span>
      </div>
    </div> <!-- form-group // -->
    

    <div class="form-group">
      <label for="qty" class="col-sm-3 control-label">Số lượng</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="quantity" placeholder="...">
        <span style="color: red;">' . $errQuantity . '</span>
      </div>
      
                  <div class="form-group">
                  <label for="tech" class="col-sm-3 control-label">Loại sản phẩm</label>
                  <div class="col-sm-3">';

  // Lấy dữ liệu danh mục
  $categories = Database::getCategories();

  echo '
          <select class="form-control" name="category_id">

                         ';

  // Duyệt qua danh sách danh mục để tạo các tùy chọn
  foreach ($categories as $category) {
    echo '<option value="' . $category['category_id'] . '">' . $category['category_name'] . '</option>';
  }
  echo '
          </select>
      </div>
  </div>';
  echo '    

        <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Hãy thêm ảnh sản phẩm</label>
        <div class="col-sm-3">
          <label class="control-label small" for="file_img">Ảnh 1 (jpg/png):</label> <input type="file" name="file_img">
          <span style="color: red;">' . $errImage . '</span>
        </div>

        <div class="col-sm-3">
          <label class="control-label small" for="file_img2">Ảnh 2 (jpg/png):</label> <input type="file" name="file_img2">
          <span style="color: red;">' . $errImage2 . '</span>
        </div>

        <div class="col-sm-3">
          <label class="control-label small" for="file_img3">Ảnh 3 (jpg/png):</label> <input type="file" name="file_img3">
          <span style="color: red;">' . $errImage3 . '</span>
        </div>
      </div> <!-- form-group // -->
      <br/>

          

        <div class="form-group">
        <label for="about" class="col-sm-3 control-label">Mô tả sản phẩm</label>
        <div class="col-sm-9">
          <textarea class="form-control" name="description" placeholder="Sản phẩm ..."></textarea>
          <span style="color: red;">' . $errDescription . '</span>
        </div>
      </div> <!-- form-group // -->


        </div> <!-- form-group // -->
        <hr>
        <div class="form-group">
         
          <div class="col-sm-offset-3 col-sm-9">
            <a href="admin.php">
            <button class="btn btn-primary"
                type="button">Thoát</button>
            </a>

            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
          </div>
        </div> <!-- form-group // -->
      </form>
        
      </div><!-- panel-body // -->
      </section><!-- panel// -->

        
      </div> <!-- container// -->
      ';

}

function _editproduct()
{
  $errName = $errPrice = $errQuantity = $errDescription = $errImage = $errImage2 = $errImage3 = '';
  $successMessage = ''; // Thêm biến để lưu thông báo thành công

  if (isset($_POST['name'])) {
    // Kiểm tra các điều kiện cần thiết
    if (empty($_POST['name'])) {
      $errName = 'Vui lòng nhập tên sản phẩm.';
    }

    if (empty($_POST['price'])) {
      $errPrice = 'Vui lòng nhập giá sản phẩm.';
    }

    if (empty($_POST['quantity'])) {
      $errQuantity = 'Vui lòng nhập số lượng sản phẩm.';
    }

    // Thêm điều kiện kiểm tra loại sản phẩm
    if (empty($_POST['category_id'])) {
      // Nếu không có loại sản phẩm được chọn
      echo '<script>alert("Vui lòng chọn loại sản phẩm.")</script>';
    }

    // Thêm điều kiện kiểm tra mô tả sản phẩm
    if (empty($_POST['description'])) {
      $errDescription = 'Vui lòng nhập mô tả sản phẩm.';
    }

    // Kiểm tra ảnh 1
    if (empty($_FILES['file_img']['name'])) {
      $errImage = '<br/>Vui lòng chọn ảnh sản phẩm.';
    }

    // Kiểm tra ảnh 2
    if (empty($_FILES['file_img2']['name'])) {
      $errImage2 = '<br/>Vui lòng chọn ảnh sản phẩm.';
    }

    // Kiểm tra ảnh 3
    if (empty($_FILES['file_img3']['name'])) {
      $errImage3 = '<br/>Vui lòng chọn ảnh sản phẩm.';
    }

    // Kiểm tra các điều kiện cần thiết
    if ($errName == '' && $errPrice == '' && $errQuantity == '' && $errDescription == '') {
      // Tiếp tục xử lý cập nhật sản phẩm trong cơ sở dữ liệu
      $productId = $_GET['id'];

      $name = $_POST['name'];
      $price = $_POST['price'];
      $categoryId = $_POST['category_id'];
      $description = $_POST['description'];
      $quantity = $_POST['quantity'];

      // Lấy thông tin cũ của sản phẩm từ cơ sở dữ liệu
      $oldProductInfo = Database::getProductById($productId);

      // Xóa ảnh cũ trước khi cập nhật đường dẫn mới
      unlink('D:/XAMPP/htdocs/Chapter1/DoAnWebCuoiKy/assets/images/' . $oldProductInfo['image']);
      unlink('D:/XAMPP/htdocs/Chapter1/DoAnWebCuoiKy/assets/images/' . $oldProductInfo['image2']);
      unlink('D:/XAMPP/htdocs/Chapter1/DoAnWebCuoiKy/assets/images/' . $oldProductInfo['image3']);

      // Xử lý tệp hình ảnh mới và lưu vào thư mục
      $image = handleImageUpload('file_img');
      $image2 = handleImageUpload('file_img2');
      $image3 = handleImageUpload('file_img3');


      $sql = "UPDATE products SET 
            product_name = '$name',
            price = '$price',
            category_id = '$categoryId',
            description = '$description',
            quantity = '$quantity',
            image = '$image',
            image2 = '$image2',
            image3 = '$image3'
            WHERE product_id = '$productId'";

      $q = Database::query($sql);

      if ($q) {
        $successMessage = 'Cập nhật thông tin sản phẩm thành công';
      } else {
        echo "Lỗi khi cập nhật thông tin sản phẩm vào cơ sở dữ liệu.";
      }
    }
  }
  // Lấy thông tin cũ của sản phẩm từ cơ sở dữ liệu
  $productId = $_GET['id'];
  $productInfo = Database::getProductById($productId);
  echo '
      <div class="container">
            <section class="panel panel-default">
                <div class="panel-heading"> 
                    <br>
                    <h3 class="panel-title">EDIT PRODUCT</h3> 
                </div> 
                <div class="panel-body">
                    <div class="panel-heading"> 
                        <br>
                        <h3 class="panel-title">SỬA SẢN PHẨM</h3> 
                    </div> 
      <div class="panel-body">
      
        
      <form action="" class="form-horizontal" role="form" method="post">
      <div class="form-group">
      <label for="name" class="col-sm-3 control-label">Tên sản phẩm</label>
      <div class="col-sm-9">
          <input type="text" class="form-control" name="name" placeholder="Áo sơ mi trắng" value="' . $productInfo['product_name'] . '">
          <span style="color: red;">' . $errName . '</span>
      </div>
  </div>
  <!-- Các trường khác tương tự, thêm giá trị mặc định cho value -->
  <div class="form-group">
      <label for="price" class="col-sm-3 control-label">Giá</label>
      <div class="col-sm-9">
          <input type="text" class="form-control" name="price" placeholder="$$" value="' . $productInfo['price'] . '">
          <span style="color: red;">' . $errPrice . '</span>
      </div>
  </div>

    <div class="form-group">
      <label for="qty" class="col-sm-3 control-label">Số lượng</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="quantity" placeholder="100" value="' . $productInfo['quantity'] . '">
        <span style="color: red;">' . $errQuantity . '</span>
      </div>';

  echo '
      <div class="form-group">
          <label for="tech" class="col-sm-3 control-label">Loại sản phẩm</label>
          <div class="col-sm-3">';

  // Lấy dữ liệu danh mục
  $categories = Database::getCategories();

  echo '<select class="form-control" name="category_id">';

  // Duyệt qua danh sách danh mục để tạo các tùy chọn
  foreach ($categories as $category) {
    $selected = ($category['category_id'] == $productInfo['category_id']) ? 'selected' : '';
    echo '<option value="' . $category['category_id'] . '" ' . $selected . '>' . $category['category_name'] . '</option>';
  }
  echo '</select>
      </div>
      </div>
      <br/>';
  echo '    

          <div class="col-md-12 mx-auto mb-4">
            <label for="file_img" class="col-sm-3 control-label">Ảnh 1</label>
              <div class="tm-product-img-edit mx-auto">
                <img src="assets/images/' . $productInfo['image'] . '" alt="Product image" width="300" height="300">
                <i
                  class="fas fa-cloud-upload-alt tm-upload-icon"
                  onclick="document.getElementById(' . 'fileInput' . ').click();"
                ></i>
              </div>
              <div class="custom-file mt-3 mb-3">
                <input  id="fileInput" type="file" style="display:none;" />
                <input type="file" name="file_img2">
              
              </div>
          </div>

          <div class="col-md-12 mx-auto mb-4">
          <label for="file_img" class="col-sm-3 control-label">Ảnh 1</label>
            <div class="tm-product-img-edit mx-auto">
              <img  src="assets/images/' . $productInfo['image2'] . '" alt="Product image" width="300" height="300">
              <i
                class="fas fa-cloud-upload-alt tm-upload-icon"
                onclick="document.getElementById(' . 'fileInput' . ').click();"
              ></i>
            </div>
            <div class="custom-file mt-3 mb-3">
              <input  id="fileInput" type="file" style="display:none;" />
              <input type="file" name="file_img2">
              
            </div>
        </div>
        
        <div class="col-md-12 mx-auto mb-4">
        <label for="file_img" class="col-sm-3 control-label">Ảnh 1</label>
          <div class="tm-product-img-edit mx-auto">
            <img src="assets/images/' . $productInfo['image3'] . '" alt="Product image" width="300" height="300">
            <i
              class="fas fa-cloud-upload-alt tm-upload-icon"
              onclick="document.getElementById(' . 'fileInput' . ').click();"
            ></i>
          </div>
          <div class="custom-file mt-3 mb-3">
            <input  id="fileInput" type="file" style="display:none;" />
            <input type="file" name="file_img2">
            
          </div>
      </div>

      <div class="form-group">
    <label for="about" class="col-sm-3 control-label">Mô tả sản phẩm</label>
    <div class="col-sm-9">
        <textarea class="form-control" name="description" placeholder="Sản phẩm ...">' . $productInfo['description'] . '</textarea>
        <span style="color: red;">' . $errDescription . '</span>
    </div>
</div> <!-- form-group // -->


        </div> <!-- form-group // -->
        <hr>
        <div class="form-group">
         
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <a href="admin.php" class="btn btn-primary" type="button">Thoát</a>
                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            </div>
        </div>
      </form>
        
      </div><!-- panel-body // -->
      </section><!-- panel// -->

        
      </div> <!-- container// -->
      ';

}

?>