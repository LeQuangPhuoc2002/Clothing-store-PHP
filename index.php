<?php
include('includes/Database.php');

echo'
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EShopper - Bootstrap Shop Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid ">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Help</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">';
            // Kiểm tra xem người dùng đã đăng nhập chưa
            if (isset($_SESSION['user'])) {
                
                $q1 = Database::query("SELECT COUNT(*) as cart_count FROM cart_item WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = ?)", "i", $_SESSION['id']);

                if ($q1) {
                    $cart_data = $q1->fetch_assoc();
                    $cart_count = isset($cart_data['cart_count']) ? $cart_data['cart_count'] : 0;
                } else {
                    // Xử lý khi có lỗi truy vấn
                    echo 'Lỗi: ' . Database::getError();
                    $cart_count = 0; // Đặt số lượng giỏ hàng mặc định khi có lỗi
                }

                echo '
                    <a href="#" class="btn border">
                        <i class="fas fa-heart text-primary"></i>
                        <span class="badge">0</span>
                    </a>
                    <a href="cart.php" class="btn border">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        <span class="badge">' . $cart_count . '</span>
                    </a>';
            } else {
                // Xử lý khi người dùng chưa đăng nhập
                echo '
                    <a href="#" class="btn border">
                        <i class="fas fa-heart text-primary"></i>
                        <span class="badge">0</span>
                    </a>
                    <a href="cart.php" class="btn border">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        <span class="badge">0</span>
                    </a>';
            }
            echo ' 

        </div>
        
        </div>
    </div>
    <!-- Topbar End -->';
   
    echo'
    <!-- Navbar Start -->
    <div class="container-fluid mb-5 ">
        <div class="row border-top px-xl-5 ">
            <div class="col-lg-3 d-none d-lg-block ">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 250px">
                    ';
                    $q1 = Database::query("SELECT categories.* 
                    FROM categories"
                    );
                    while ($r1 = $q1->fetch_array()) {
                    echo '
                    <li class="nav-item">               
                        <a href="shop.php?category=' . $r1['category_id'] . '" class="nav-item nav-link">' . $r1['category_name'] . '</a>
                    </li>';
                    }
                    echo '
                     
                    </div>
                </nav>
            </div>
            <div class="col-lg-9 ">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between " id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <a href="shop.php" class="nav-item nav-link">Shop</a>
                            <a href="detail.php" class="nav-item nav-link">Shop Detail</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="cart.php" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.php" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                            <a href="order_history.php" class="nav-item nav-link">Order History</a>

                        </div>
                        ';
                        $id = 1;
                        if (isset($_SESSION['user'])) {
                            $name = $_SESSION['name'];        
                            $id = $_SESSION['id']; 
                            echo "Xin chào $name!";
                            echo '<a href="logout.php" class="nav-item nav-link" >Đăng xuất</a>';
                        } else {
                            echo'
                            <a href="login.php" class="nav-item nav-link">Login</a>
                            <a href="register.php" class="nav-item nav-link">Register</a>';
                        } 
                         
                        echo'                                         
                         
                    </div>
                </nav>
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 410px;">
                            <img class="img-fluid" src="img/carousel-1.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Fashionable Dress</h3>
                                    <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" style="height: 410px;">
                            <img class="img-fluid" src="img/carousel-2.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Reasonable Price</h3>
                                    <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>  
    <!-- Navbar End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
        ';
        $q1 = Database::query("SELECT categories.*, COUNT(products.product_id) AS product_count
                      FROM categories
                      LEFT JOIN products ON categories.category_id = products.category_id
                      GROUP BY categories.category_id"
        );

        while ($r1 = $q1->fetch_array()) {
            echo '
            <div class="col-lg-4 col-md-6 pb-1">            
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">' . $r1['product_count'] . ' Products</p>
                    <a href="shop.php?category=' . $r1['category_id'] . '" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="category_image/' . $r1['category_image'] . '" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">' . $r1['category_name'] . '</h5>
                </div>
            </div>';
}
            
            echo ' 
            
        </div>
    </div>
    <!-- Categories End -->


    <!-- Offer Start -->
    <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="img/offer-1.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Spring Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                    <img src="img/offer-2.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Winter Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Những mẫu quần độc đáo và nổi bật </span></h2>
        </div>
        <div class="row px-xl-5 pb-3">';
        $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
        $search_condition = $search_query ? "AND products.product_name LIKE '%$search_query%'" : '';

        $q1 = Database::query("SELECT products.*, categories.category_name 
                                FROM products 
                                JOIN categories ON products.category_id = categories.category_id 
                                WHERE categories.category_name LIKE '%Quần%'
                                $search_condition
                                LIMIT 8");  // Thêm điều kiện LIMIT 8 để chỉ hiển thị 8 sản phẩm
        
        
         // Hiển thị sản phẩm như trước
         while ($r1 = $q1->fetch_array()) {            
            echo ' 
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100"src="assets/images/' . $r1['image'] . '"" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">'. $r1['product_name'] . '</h6>
                        <div class="d-flex justify-content-center">
                            <h6>$' . $r1['price'] . '</h6><h6 class="text-muted ml-2"><del>$10000</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detail.php?product_id=' . $r1['product_id'] . '" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        <a href="addtocart.php?quantity=1&productId='.$r1['product_id'].'&userId='.$id .'" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    
                    </div>
                </div>
            </div>
            ';}
            echo'
           
    </div>
    <div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Những mẫu giày độc đáo và nổi bật </span></h2>
    </div>
    <div class="row px-xl-5 pb-3">';
    $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
    $search_condition = $search_query ? "AND products.product_name LIKE '%$search_query%'" : '';

    $q1 = Database::query("SELECT products.*, categories.category_name 
                            FROM products 
                            JOIN categories ON products.category_id = categories.category_id 
                            WHERE categories.category_name LIKE '%Giày%'
                            $search_condition
                            LIMIT 8");  // Thêm điều kiện LIMIT 8 để chỉ hiển thị 8 sản phẩm
    
    
     // Hiển thị sản phẩm như trước
     while ($r1 = $q1->fetch_array()) {            
        echo ' 
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100"src="assets/images/' . $r1['image'] . '"" alt="">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">'. $r1['product_name'] . '</h6>
                    <div class="d-flex justify-content-center">
                        <h6>$' . $r1['price'] . '</h6><h6 class="text-muted ml-2"><del>$10000</del></h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                    <a href="addtocart.php?quantity=1&productId='.$r1['product_id'].'&userId='.$id .'" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
            </div>
        </div>
        ';}
        echo'       
    </div>

    <div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Những mẫu áo độc đáo và nổi bật </span></h2>
    </div>
    <div class="row px-xl-5 pb-3">';
    $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
    $search_condition = $search_query ? "AND products.product_name LIKE '%$search_query%'" : '';

    $q1 = Database::query("SELECT products.*, categories.category_name 
                            FROM products 
                            JOIN categories ON products.category_id = categories.category_id 
                            WHERE categories.category_name LIKE '%Áo%'
                            $search_condition
                            LIMIT 8");  // Thêm điều kiện LIMIT 8 để chỉ hiển thị 8 sản phẩm
    
    
     // Hiển thị sản phẩm như trước
     while ($r1 = $q1->fetch_array()) {            
        echo ' 
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100"src="assets/images/' . $r1['image'] . '"" alt="">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">'. $r1['product_name'] . '</h6>
                    <div class="d-flex justify-content-center">
                        <h6>$' . $r1['price'] . '</h6><h6 class="text-muted ml-2"><del>$10000</del></h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                    <a href="addtocart.php?quantity=1&productId='.$r1['product_id'].'&userId='.$id .'" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
            </div>
        </div>
        ';}
        echo'      
    </div>
    <!-- Products End -->

    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-1.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-2.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-3.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-4.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-5.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-6.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-7.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-8.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section style="color: #000; background-color: #f3f2f2;">
    <div class="container py-5">
      <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-xl-8 text-center">
          <h3 class="fw-bold mb-4">Testimonials</h3>
          <p class="mb-4 pb-2 mb-md-5 pb-md-0">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit, error amet
            numquam iure provident voluptate esse quasi, veritatis totam voluptas nostrum
            quisquam eum porro a pariatur veniam.
          </p>
        </div>
      </div>
  
      <div class="row text-center">
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="card">
            <div class="card-body py-4 mt-2">
              <div class="d-flex justify-content-center mb-4">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(10).webp"
                  class="rounded-circle shadow-1-strong" width="100" height="100" />
              </div>
              <h5 class="font-weight-bold">Teresa May</h5>
              <h6 class="font-weight-bold my-3">Founder at ET Company</h6>
              <ul class="list-unstyled d-flex justify-content-center">
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star-half-alt fa-sm text-info"></i>
                </li>
              </ul>
              <p class="mb-2">
                <i class="fas fa-quote-left pe-2"></i>Lorem ipsum dolor sit amet,
                consectetur adipisicing elit. Quod eos id officiis hic tenetur quae quaerat
                ad velit ab hic tenetur.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="card">
            <div class="card-body py-4 mt-2">
              <div class="d-flex justify-content-center mb-4">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(15).webp"
                  class="rounded-circle shadow-1-strong" width="100" height="100" />
              </div>
              <h5 class="font-weight-bold">Maggie McLoan</h5>
              <h6 class="font-weight-bold my-3">Photographer at Studio LA</h6>
              <ul class="list-unstyled d-flex justify-content-center">
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
              </ul>
              <p class="mb-2">
                <i class="fas fa-quote-left pe-2"></i>Autem, totam debitis suscipit saepe
                sapiente magnam officiis quaerat necessitatibus odio assumenda perferendis
                labore laboriosam.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-0">
          <div class="card">
            <div class="card-body py-4 mt-2">
              <div class="d-flex justify-content-center mb-4">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(17).webp"
                  class="rounded-circle shadow-1-strong" width="100" height="100" />
              </div>
              <h5 class="font-weight-bold">Alexa Horwitz</h5>
              <h6 class="font-weight-bold my-3">Front-end Developer in NY</h6>
              <ul class="list-unstyled d-flex justify-content-center">
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="fas fa-star fa-sm text-info"></i>
                </li>
                <li>
                  <i class="far fa-star fa-sm text-info"></i>
                </li>
              </ul>
              <p class="mb-2">
                <i class="fas fa-quote-left pe-2"></i>Cras sit amet nibh libero, in gravida
                nulla metus scelerisque ante sollicitudin commodo cras purus odio,
                vestibulum in tempus viverra turpis.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
    <!-- Vendor End -->
    
    <div>
        <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15235.914620704008!2d107.5949883!3d16.4637131!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142abdbb6af62c5%3A0xc2c4318f0ac7ef8a!2zVMO8IFRo4bqjbyBIdeG7s25nIMSQ4buTbmcgVGjhuqFvIFRo4bqhbyBMw6J5!5e0!3m2!1sen!2s!4v1647409785248!5m2!1sen!2s" frameborder="0" allowfullscreen></iframe>
    </div>


    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">E</span>Shopper</h1>
                </a>
                <p>Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.php"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="detail.php"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-dark mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="checkout.php"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.php"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="detail.php"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-dark mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="checkout.php"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                    required="required" />
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">Your Site Name</a>. All Rights Reserved. Designed
                    by
                    <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a><br>
                    Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>';
    include('chatbot.html');
    echo'
  
    <!-- Footer End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>';
?>