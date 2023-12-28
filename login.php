<?php
include('includes/Database.php');

_header('Login Page');

$thongBaoLoiDangNhap = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $emailOrUsername = $_POST['email'];
        $password = $_POST['password'];

        // Kiểm tra và làm sạch dữ liệu nếu cần thiết

        // Giả sử Database::query là cách an toàn để thực hiện truy vấn để ngăn chặn SQL injection
        $passwords = Database::generateMD5($password);
        $query = Database::query("SELECT * FROM users WHERE (email = '$emailOrUsername' OR username = '$emailOrUsername') AND password = '$passwords'");

        $user = $query->fetch_array();

        // Sau khi kiểm tra đăng nhập thành công
        // After verifying the user's credentials and before redirecting
        if ($user) {
            if ($user['role'] == 'admin') {
                header("location: admin.php?id=" . $user['id']);
                exit();
            } else {
                $_SESSION['user'] = $user;
                $_SESSION['name'] = $user['name']; // Make sure 'name' is a valid key in your user data
                $_SESSION['id'] = $user['user_id']; // Add this line to store user id in session
                header("location: index.php?id=" . $user['user_id']);
                exit();
            }
        } else {
            $thongBaoLoiDangNhap = 'Email hoặc tên đăng nhập và mật khẩu không đúng.';
        }
    } else {
        $thongBaoLoiDangNhap = 'Vui lòng điền đầy đủ thông tin đăng nhập.';
    }
}


require 'google-api/vendor/autoload.php';

// Creating a new Google client instance
$client = new Google_Client();

// Enter your Client ID
$client->setClientId('146210714064-4qib02l3dbkqogsebt2819526soe2be6.apps.googleusercontent.com');
// Enter your Client Secret
$client->setClientSecret('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');
// Enter the Redirect URL
$client->setRedirectUri('http://localhost:8085/chapter1/quangphuoc/logingoogle.php');

// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token["error"])) {
        $client->setAccessToken($token['access_token']);

        // Getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        // Print the information without storing in the database
        echo "Google ID: " . $google_account_info->id . "<br>";
        echo "Full Name: " . $google_account_info->name . "<br>";
        echo "Name: " . $google_account_info->givenName . "<br>"; // Adding the 'Name' field
        echo "Email: " . $google_account_info->email . "<br>";
        Database::insertUserWithCart($google_account_info->givenName, $google_account_info->email, $google_account_info->name, $google_account_info->id, $google_account_info->name);

    } else {
        header('Location: login.php');
        exit;
    }
} else {
    // Google Login Url
    $googleLoginUrl = $client->createAuthUrl();
    // ... (rest of your code)

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
                    <h2 class="h1 mb-4">Chúng tôi tạo ra các sản phẩm số nhằm tạo nên sự nổi bật cho bạn.</h2>
                    <p class="lead mb-5">Khám phá một thế giới không giới hạn các khả năng tại cửa hàng trực tuyến của chúng tôi, nơi bạn sẽ đắm chìm trong một bảo tàng ảo của những sản phẩm độc đáo và chất lượng, được tổ chức một cách cẩn thận để đáp ứng mọi nhu cầu và sở thích của bạn.

                    Chúng tôi tự hào giới thiệu một bộ sưu tập đa dạng từ thời trang, đồ điện tử cho đến đồ gia dụng, mang đến cho bạn trải nghiệm mua sắm đích thực và đẳng cấp. Với sự thuận tiện chỉ cần vài cú click chuột.</p>
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
                            <h3>ĐĂNG NHẬP</h3>
                            <p>Chưa có tài khoản? <a href="register.php">
                            Đăng ký</a></p>
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
                            <input type="text" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                            <label for="email" class="form-label">Email or Username</label>
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
                        <!-- Thêm nút đăng nhập Google -->
                        <a href="'.$googleLoginUrl.'" onclick="startGoogleSignIn()" class="btn btn-outline-danger bsb-btn-circle bsb-btn-circle-2xl">
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
?>