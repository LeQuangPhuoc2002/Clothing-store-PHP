<?php
    include('includes/Database.php');
 
    echo'<!DOCTYPE html>
    <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Register</title>
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
            <script src="assets/js/bootstrap.bundle.min.js"></script>
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            <meta name="google-signin-client_id" content="your-client-id.apps.googleusercontent.com">
        </head>  
    
        <section class="vh-100" style="background-color: #eee;">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-12 col-xl-11">
                        <div class="card text-black" style="border-radius: 25px;">
                            <div class="card-body p-md-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
    
                                        <a class="mx-1 mx-md-5" href="login.php">QUAY TRỞ LẠI TRANG ĐĂNG NHẬP.</a>
                                        <p class="text-center fw-bold ">THÔNG TIN</p>
                                        <form id="registrationForm" class="mx-1 mx-md-4" method="get" action="dangki.php">
    
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <label class="form-label" for="form3Example1c">Họ và tên</label>
                                                  <input type="text" name="name" class="form-control" required="required" />
    
                                                </div>
                                            </div>
    
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <label class="form-label" for="form3Example1c">Username</label>
                                                     <input type="text" name="username" class="form-control" required="required" />
                                              
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example3c">Email</label>
                                                <input type="text" name="email" id="emailInput" class="form-control" required="required" />
                                                <small id="emailHelp" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                        
                                        <script>
                                            document.getElementById("emailInput").addEventListener("blur", function () {
                                                var emailInput = this.value;
                                                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                        
                                                if (!emailRegex.test(emailInput)) {
                                                    document.getElementById("emailHelp").textContent = "Vui lòng nhập một địa chỉ email hợp lệ.";
                                                } else {
                                                    document.getElementById("emailHelp").textContent = "";
                                                }
                                            });
                                        
                                            document.getElementById("emailInput").addEventListener("invalid", function () {
                                                var emailInput = this.value;
                                                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                        
                                                if (!emailRegex.test(emailInput)) {
                                                    document.getElementById("emailHelp").textContent = "Vui lòng nhập một địa chỉ email hợp lệ.";
                                                } else {
                                                    document.getElementById("emailHelp").textContent = "";
                                                }
                                            });
                                        </script>
                                        
                                        
    
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <label class="form-label" for="form3Example3c">Số điện thoại</label>
                                                    <input type="text" name="phone" class="form-control" required="required" />
                                              
                                                </div>
                                            </div>
    
    
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <label class="form-label" for="form3Example4c">Password</label>
                          <input type="password" name="password" class="form-control" required="required"/>
                                                </div>
                                            </div>
    
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <label class="form-label" for="form3Example4cd">Xác nhận mật khẩu</label>
                                                   <input type="password" name="repassword" class="form-control" required="required"/>
    
                                                </div>
                                            </div>';

                                            if (isset($_SESSION["error"])) {
                                                echo '<div class="alert alert-danger" role="alert">' . $_SESSION["error"] . '</div>';
                                                // Xóa thông báo lỗi từ session sau khi đã hiển thị
                                                unset($_SESSION["error"]);
                                            }
                                            echo '
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
    
?>