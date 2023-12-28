<?php
include('includes/Database.php');

_header('Edit_order');
// Kiểm tra xem có cung cấp ID sản phẩm trong URL không
if (isset($_GET['id'])) {
  $productId = $_GET['id'];

  // Truy xuất thông tin sản phẩm từ cơ sở dữ liệu dựa trên ID sản phẩm

   
    $q = Database::getOrderDetailByOrderId($productId);
    $q2 = Database::getOrder($productId);
  if ($q) {
    $product = $q;
  } else {
    $product = null;
  }
  if ($product) {
    // Xử lý việc gửi biểu mẫu (nếu biểu mẫu được gửi)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Trích xuất và làm sạch dữ liệu từ biểu mẫu
      $productName = isset($product['name']) ? htmlspecialchars($product['name']) : '';
      $productPrice = isset($product['price']) ? htmlspecialchars($product['price']) : '';
      $productQuantity = isset($product['quantity']) ? htmlspecialchars($product['quantity']) : '';
      $productDescription = isset($product['description']) ? htmlspecialchars($product['description']) : '';
      $productCategoryID = isset($product['category_id']) ? htmlspecialchars($product['category_id']) : '';


      // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
      $updateQuery = "UPDATE products SET name = '$newName', price = $newPrice, quantity = $newQuantity, status = '$newStatus' WHERE id = $productId";
      Database::query($updateQuery);

      // Chuyển hướng trở lại trang quản lý sản phẩm (admin-page.php)
      header("Location: admin.php");
      exit();
    }
    echo '<!--Main Navigation-->
    <header>
      <!-- Sidebar -->
      <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
          <div class="list-group list-group-flush mx-3 mt-4">
            <a
              href=""
              class="list-group-item list-group-item-action py-2 ripple"
              aria-current="true"
            >
              <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Menu chức năng</span>
            </a>
            <a href="admin.php" class="list-group-item list-group-item-action py-2 ripple ">
              <i class="fas fa-chart-area fa-fw me-3"></i><span>Quản lý sản phẩm</span>
            </a>
           
            <a href="quanlynguoidung.php" class="list-group-item list-group-item-action py-2 ripple "
              ><i class="fas fa-chart-line fa-fw me-3"></i><span>Quản lý người dùng</span></a
            >
            <a href="quanlydonhang.php" class="list-group-item list-group-item-action py-2 ripple active">
              <i class="fas fa-chart-pie fa-fw me-3"></i><span>Quản lý đơn hàng</span>
            </a>
            <a href="quanlydanhmuc.php" class="list-group-item list-group-item-action py-2 ripple"
              ><i class="fas fa-chart-bar fa-fw me-3"></i><span>Quản lý danh mục</span></a
            >
            <a href="chat.php" class="list-group-item list-group-item-action py-2 ripple"
            ><i class="fas fa-chart-bar fa-fw me-3"></i><span>Chat</span></a
          >
          
           
            <a href="thongke.php" class="list-group-item list-group-item-action py-2 ripple"
              ><i class="fas fa-money-bill fa-fw me-3"></i><span>Thống kê</span></a
            >
          </div>
        </div>
      </nav>
      <!-- Sidebar -->
    
      <!-- Navbar -->
      <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <!-- Container wrapper -->
        <div class="container-fluid">
          <!-- Toggle button -->
          <button
            class="navbar-toggler"
            type="button"
            data-mdb-toggle="collapse"
            data-mdb-target="#sidebarMenu"
            aria-controls="sidebarMenu"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <i class="fas fa-bars"></i>
          </button>
    
          <!-- Brand -->
          <a class="navbar-brand" href="#">
            <img
              src="https://mdbcdn.b-cdn.net/img/logo/mdb-transaprent-noshadows.webp"
              height="25"
              alt="MDB Logo"
              loading="lazy"
            />
          </a>
          <!-- Search form -->
          <form class="d-none d-md-flex input-group w-auto my-auto">
            <input
              autocomplete="off"
              type="search"
              class="form-control rounded"
              placeholder=' . 'Search (ctrl + "/" to focus)' . '
              style="min-width: 225px;"
            />
            <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
          </form>
    
          <!-- Right links -->
          <ul class="navbar-nav ms-auto d-flex flex-row">
            <!-- Notification dropdown -->
            <li class="nav-item dropdown">
              <a
                class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-mdb-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="fas fa-bell"></i>
                <span class="badge rounded-pill badge-notification bg-danger">1</span>
              </a>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="navbarDropdownMenuLink"
              >
                <li>
                  <a class="dropdown-item" href="#">Some news</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Another news</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Something else here</a>
                </li>
              </ul>
            </li>
    
            <!-- Icon -->
            <li class="nav-item">
              <a class="nav-link me-3 me-lg-0" href="#">
                <i class="fas fa-fill-drip"></i>
              </a>
            </li>
            <!-- Icon -->
            <li class="nav-item me-3 me-lg-0">
              <a class="nav-link" href="#">
                <i class="fab fa-github"></i>
              </a>
            </li>
    
            <!-- Icon dropdown -->
            <li class="nav-item dropdown">
              <a
                class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow"
                href="#"
                id="navbarDropdown"
                role="button"
                data-mdb-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="flag-united-kingdom flag m-0"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="#"
                    ><i class="flag-united-kingdom flag"></i>English
                    <i class="fa fa-check text-success ms-2"></i
                  ></a>
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item" href="#"><i class="flag-poland flag"></i>Polski</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><i class="flag-china flag"></i>中文</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><i class="flag-japan flag"></i>日本語</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><i class="flag-germany flag"></i>Deutsch</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><i class="flag-france flag"></i>Français</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><i class="flag-spain flag"></i>Español</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><i class="flag-russia flag"></i>Русский</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#"><i class="flag-portugal flag"></i>Português</a>
                </li>
              </ul>
            </li>
    
            <!-- Avatar -->
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-mdb-toggle="dropdown"
                aria-expanded="false"
              >
                <img
                  src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img (31).webp"
                  class="rounded-circle"
                  height="22"
                  alt="Avatar"
                  loading="lazy"
                />
              </a>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="navbarDropdownMenuLink"
              >
                <li>
                  <a class="dropdown-item" href="#">My profile</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Settings</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- Container wrapper -->
      </nav>
      <!-- Navbar -->
    </header>
    <style>
    body {
        background-color: #fbfbfb;
      }
      @media (min-width: 991.98px) {
        main {
          padding-left: 240px;
        }
      }
      
      /* Sidebar */
      .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        padding: 58px 0 0; /* Height of navbar */
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
        width: 240px;
        z-index: 600;
      }
      
      @media (max-width: 991.98px) {
        .sidebar {
          width: 100%;
        }
      }
      .sidebar .active {
        border-radius: 5px;
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
      }
      
      .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: 0.5rem;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
      }
    </style>
    <!--Main layout--><div class="container" style="margin-left:300px">
    <main style="margin-top: 58px;">
      <div class="container pt-4"></div>
    </main>
    <!--Main layout-->
          <!-- Navbar -->
          <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
              <!-- Container wrapper -->
              <div class="container">
                  <!-- Navbar brand -->
                  <a href="admin.php">
                  <img src="assets/icon/husc_logo.png" width="50" height="50" class="ms-auto" style="margin-right: 100px;" alt="HUSC Logo">
              </a>
                            <!-- Search form -->
                 <!-- Biểu mẫu tìm kiếm -->
                 <form class="input-group mx-auto" style="width: 400px" action="admin.php" method="GET">
                 <input type="search" class="form-control" name="search_query" placeholder="Nhập truy vấn" aria-label="Tìm kiếm" />
                 <button class="btn btn-outline-primary" type="submit" data-mdb-ripple-color="dark" style="padding: .45rem 1.5rem .35rem;">
                     Tìm kiếm
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
                      
                          ';
    if (isset($_SESSION['admin'])) {
      $name = $_SESSION['name'];
      $id = $_SESSION['id'];
      echo '
                            <li class="nav-item">
                              <a class="nav-link d-flex flex-column text-center" aria-current="page" href="admin.php"><i
                                      class="fas fa-user-friends fa-lg"></i><span class="small">Xin chào ' . $name . '!</a>
                          </li>
          
                          <li class="nav-item">
                              <a class="nav-link d-flex flex-column text-center" aria-current="page" href="logoutadmin.php"><i
                                      class="fas fa-comment-dots fa-lg"></i><span class="small">Đăng xuất</span></a>
                          </li>
                        ';
    } else {
      echo '
                            <li class="nav-item">
                            <a class="nav-link d-flex flex-column text-center" aria-current="page" href="login_admin.php"><i
                                    class="fas fa-comment-dots fa-lg"></i><span class="small">Login</span></a>
                        </li>
                       ';
    }
    echo '
                      </ul>
                      <!-- Left links -->
                  </div>
                  <!-- Collapsible wrapper -->
              </div>
              <!-- Container wrapper -->
          </nav>
          <!-- Navbar -->
         
          
      <div class="container">
     
        <section class="panel panel-default">
      <div class="panel-heading"> 
      <br>
      <h3 class="panel-title"></h3> 
      </div> 
      <div class="panel-body">
      <div class="panel-heading"> 
      <br>
      <h3 class="panel-title">EDIT PRODUCT</h3> 
      </div> 
      <div class="panel-body">';
      $q2 = Database::query("SELECT `order`.*, status.*
                      FROM `order`
                      JOIN status ON `order`.status_id = status.status_id
                      WHERE `order`.order_id = $productId
                     ");

  
  while ($r2 = $q2->fetch_array()) {
    $totalPrice = 0; // Khởi tạo biến để tính tổng số tiền
    $idd = $r2['order_id'];
        echo'
        <section class="h-100 gradient-custom">
        <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-10 col-xl-8">
            <div class="card" style="border-radius: 10px;">
                <div class="card-header px-4 py-5">
                <h5 class="text-muted mb-0">ID Order: <span style="color: #a8729a;">' . $r2['order_id'] . '</span></h5>
                </div>
                <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="lead fw-normal mb-0" style="color: #a8729a;">Status: ' . $r2['status_value'] . '</p>
                   
                </div>
                ';
                if ($r2['status_id'] == 3) {
                    echo '<a href="javascript:void(0);" onclick="showImage(\'assets/image_order/' . $r2['image_order'] . '\')">
                              Click here to view image
                          </a>';
                }
                
                // JavaScript function
                echo '<script>
                        function showImage(imagePath) {
                            var newWindow = window.open("", "_blank");
                            newWindow.document.write("<html><head><title>Image</title></head><body><img src=\'" + imagePath + "\' alt=\'Image\'></body></html>");
                        }
                      </script>';
                
                echo'
                <div class="card shadow-0 border mb-4">
                    ';
                    $q1 = Database::query("SELECT `order`.*, status.*, order_detail.*, products.*
                    FROM `order`
                    JOIN status ON `order`.status_id = status.status_id
                    LEFT JOIN order_detail ON `order`.order_id = order_detail.order_id
                    LEFT JOIN products ON order_detail.product_id = products.product_id
                    WHERE `order_detail`.order_id = $idd");

                    while ($r1 = $q1->fetch_array()) {
                        echo'
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                <img src="assets/images/' . $r1['image'] . '"
                                    class="img-fluid" alt="Phone">
                                </div>
                                <div class="col-md-5 text-center d-flex justify-content-center align-items-center">
                                <p class="text-muted mb-0">' . $r1['product_name'] . '</p>
                                </div>
                            
                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                <p class="text-muted mb-0 small">$ ' . $r1['price'] . '</p>
                                </div>
                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                <p class="text-muted mb-0 small">x ' . $r1['order_quantity'] . '</p>
                                </div>
                            
                            </div>
                    </div>
                    ';
                    $totalPrice += $r1['price'] * $r1['order_quantity']; // Cộng vào tổng số tiền
                    }
                    $q3 = Database::getUserById($r2['user_id']);
                 
                    echo'
                    
                </div>
    
                <div class="d-flex justify-content-between pt-2">
                    <p class="fw-bold mb-0">Order Details</p>
                    
                </div>
    
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0">Số điện thoại: '.$q3['phonenumber'].'</p>
                  
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0">Email: '.$q3['email'].'</p>
                    
                </div>
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0">Họ và tên: '.$q3['name'].'</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-4">Total Price: </span>'. $totalPrice.'.00$</p>
                </div>
    
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0">Thời gian đặt : '.$r2['order_date'].'</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-4">Ship:</span> 10.00$</p>
                </div>
    
                <div class="d-flex justify-content-between pt-2">
                    <p class="text-muted mb-0">Địa chỉ nhận hàng : '.$r2['order_address'].'</p>
                    <p class="text-muted mb-0"><span class="fw-bold me-4">Total: </span> ' . ($totalPrice + 10) . '.00$</p>
                </div>
                </div>
                <div class="card-footer border-0 px-4 py-5"
                style="background-color: #a8729a; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Total
                    paid : <span class="h2 mb-0 ms-2"> ' . ($totalPrice + 10) . '.00$</span></h5>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
   
    ';
    }   

        echo'
      <form action="suaorder.php" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="'.$productId.'" id="file_img_input2">
                  <div class="form-group">
                  <label for="tech" class="col-sm-3 control-label">Loại sản phẩm</label>
                  <div class="col-sm-3">';
                  $categories = Database::getStatus();

                  echo '
                        <select class="form-control" name="category_id">
              
                                       ';
              
                  // Duyệt qua danh sách danh mục để tạo các tùy chọn
                  foreach ($categories as $category) {
                      echo '<option value="' . $category['status_id'] . '">' . $category['status_value'] . '</option>';
                  }
                  echo '
                      </select>
                  </div>
              </div>
              <div class="col-sm-3">
        <label class="control-label small" for="file_img2">Ảnh 2 (jpg/png):</label>
        <input type="file" name="file_img2" id="file_img_input2">
        <img src="" id="img_preview2" style="max-width: 100px; max-height: 100px; display: none;">
        <button type="button" id="btn_remove_img2" style="display: none;">Xóa ảnh</button>
        <span style="color: red;" id="errImage2"></span>
    </div>';
           
    echo '    

    <div class="form-group">
    <label for="name" class="col-sm-3 control-label">Hãy thêm ảnh sản phẩm</label>
    
    <!-- Ảnh 1 -->
    

 

</div>
        ';
  } else {
    echo 'Không tìm thấy sản phẩm.';
  }
} else {
  echo 'Không có ID sản phẩm được cung cấp.';
}
echo '

        </div> <!-- form-group // -->
        <hr>
        <div class="form-group">
         
          <div class="col-sm-offset-3 col-sm-9">
            <a href="admin.php">
            <button class="btn btn-primary"
                type="button">Thoát</button>
            </a>

            <button type="submit" class="btn btn-primary">Sửa thông tin sản phẩm</button>
          </div>
        </div> <!-- form-group // -->
      </form>
        
      </div><!-- panel-body // -->
      </section><!-- panel// -->

        
      </div> <!-- container// -->
      ';




?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Lắng nghe sự kiện khi người dùng chọn ảnh
    document.getElementById('file_img_input').addEventListener('change', function (event) {
      previewImage(event, 'img_preview1', 'btn_remove_img1', 'errImage1');
    });

    document.getElementById('file_img_input2').addEventListener('change', function (event) {
      previewImage(event, 'img_preview2', 'btn_remove_img2', 'errImage2');
    });

    document.getElementById('file_img_input3').addEventListener('change', function (event) {
      previewImage(event, 'img_preview3', 'btn_remove_img3', 'errImage3');
    });

    // Xử lý sự kiện xóa ảnh
    document.getElementById('btn_remove_img1').addEventListener('click', function () {
      removeImage('file_img_input', 'img_preview1', 'btn_remove_img1', 'errImage1');
    });

    document.getElementById('btn_remove_img2').addEventListener('click', function () {
      removeImage('file_img_input2', 'img_preview2', 'btn_remove_img2', 'errImage2');
    });

    document.getElementById('btn_remove_img3').addEventListener('click', function () {
      removeImage('file_img_input3', 'img_preview3', 'btn_remove_img3', 'errImage3');
    });
  });

  function previewImage(event, imgId, btnRemoveId, errId) {
    var input = event.target;
    var img = document.getElementById(imgId);
    var btnRemove = document.getElementById(btnRemoveId);
    var errSpan = document.getElementById(errId);

    var reader = new FileReader();
    reader.onload = function () {
      img.src = reader.result;
      img.style.display = 'block';
      btnRemove.style.display = 'inline-block';
      errSpan.textContent = ''; // Xóa thông báo lỗi nếu có
    };

    if (input.files && input.files[0]) {
      reader.readAsDataURL(input.files[0]);
    }
  }

  function removeImage(inputId, imgId, btnRemoveId, errId) {
    var input = document.getElementById(inputId);
    var img = document.getElementById(imgId);
    var btnRemove = document.getElementById(btnRemoveId);
    var errSpan = document.getElementById(errId);

    input.value = ''; // Xóa giá trị của input file
    img.src = '';
    img.style.display = 'none';
    btnRemove.style.display = 'none';
    errSpan.textContent = ''; // Xóa thông báo lỗi nếu có
  }

</script>