<?php
include('includes/Database.php');
    
_header('Login Page');
_navbar();
    echo '
    <!-- carousel -->
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-mdb-ride="carousel">
      <div class="carousel-indicators">
        <button
          type="button"
          data-mdb-target="#carouselExampleCaptions"
          data-mdb-slide-to="0"
          class="active"
          aria-current="true"
          aria-label="Slide 1"
        ></button>
        <button
          type="button"
          data-mdb-target="#carouselExampleCaptions"
          data-mdb-slide-to="1"
          aria-label="Slide 2"
        ></button>
        <button
          type="button"
          data-mdb-target="#carouselExampleCaptions"
          data-mdb-slide-to="2"
          aria-label="Slide 3"
        ></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="images/banner5.jpg" class="d-block w-100" alt="Wild Landscape"/>
      
          <div class="mask" style="background-color: rgba(0, 0, 0, 0.4)"></div>
          
        </div>        
      </div>
  
     <!--Main layout-->
    <main>
    <div class="container">
      <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mt-3 mb-5 shadow p-2" style="background-color: #607D8B">
      <!-- Container wrapper -->
      <div class="container-fluid">
    
        <!-- Navbar brand -->
        <a class="navbar-brand" href="#">Categories:</a>
    
        <!-- Toggle button -->
        <button 
           class="navbar-toggler" 
           type="button" 
           data-mdb-toggle="collapse" 
           data-mdb-target="#navbarSupportedContent2" 
           aria-controls="navbarSupportedContent2" 
           aria-expanded="false" 
           aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
    
        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent2">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    
            <!-- Link -->
            <li class="nav-item acitve">
              <a class="nav-link text-white" href="Trangchu.php">All</a>
            </li>
            ';
           
            $q1 = Database::query("SELECT categories.* 
            FROM categories"
            );
             while ($r1 = $q1->fetch_array()) {
              echo '
              <li class="nav-item">
                  <a class="nav-link text-white" href="?category=' . $r1['category_id'] . '">' . $r1['category_name'] . '</a>
              </li>';
              }
            echo '
                
    
          </ul>
    
          <!-- Search -->
          <form class="w-auto py-1" style="max-width: 12rem" method="GET" action="Trangchu.php">
    <input type="search" class="form-control rounded-0" placeholder="Search" aria-label="Search" name="search_query">
</form>
        </div>
      </div>
      <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
      
    <!-- Products -->
      <section>
      <div class="text-center">
        <div class="row">';
         // Xử lý tìm kiếm
        // Số sản phẩm hiển thị trên mỗi trang
        $productsPerPage = 25;

        // Lấy trang hiện tại từ tham số URL
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Tính toán vị trí bắt đầu của sản phẩm trên trang hiện tại
        $start = ($page - 1) * $productsPerPage;
         $category_id = isset($_GET['category']) ? $_GET['category'] : null;

         // Xây dựng truy vấn SQL với điều kiện category
         $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
         $search_condition = $search_query ? "WHERE product_name LIKE '%$search_query%'" : '';
        $q1 = Database::query("SELECT products.*, categories.category_name 
                        FROM products 
                        JOIN categories ON products.category_id = categories.category_id 
                        $search_condition
                        LIMIT $start, $productsPerPage");

         // Hiển thị sản phẩm như trước
         while ($r1 = $q1->fetch_array()) {
  echo'
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
              <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light"
                data-mdb-ripple-color="light">
                <img src="assets/images/' . $r1['image'] . '"
                  class="w-100" />
                <a href="#!">
                  <div class="mask">
                    <div class="d-flex justify-content-start align-items-end h-100">
                      <h5><span class="badge bg-dark ms-2">NEW</span></h5>
                    </div>
                  </div>
                  <div class="hover-overlay">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                  </div>
                </a>
              </div>
              <div class="card-body">
                <a href="" class="text-reset">
                  <h5 class="card-title mb-2">'. $r1['product_name'] . '</h5>
                </a>
                <a href="" class="text-reset ">
                  <p>' . $r1['category_name'] . '</p>
                </a>
                <h6 class="mb-3 price">' . $r1['price'] . '$</h6>
              </div>
            </div>
          </div>
    ';}
      // Tính toán tổng số trang
      $totalPages = ceil($q1->num_rows / $productsPerPage);

      // Tạo nút phân trang
      echo '
      <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">
        <ul class="pagination">';

      // Hiển thị nút Previous
      if ($page > 1) {
          echo '<li class="page-item"><a class="page-link" href="?category=' . $category_id . '&page=' . ($page - 1) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
      } else {
          echo '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&laquo;</span></li>';
      }

      // Hiển thị nút trang 1
      echo '<li class="page-item ' . ($page == 1 ? 'active' : '') . '"><a class="page-link" href="?category=' . $category_id . '&page=1">1</a></li>';

      // Hiển thị nút trang 2 (nếu có)
  
          echo '<li class="page-item ' . ($page == 2 ? 'active' : '') . '"><a class="page-link" href="?category=' . $category_id . '&page=2">2</a></li>';
      

    
          echo '<li class="page-item ' . ($page == 3 ? 'active' : '') . '"><a class="page-link" href="?category=' . $category_id . '&page=3">3</a></li>';
      
          echo '<li class="page-item ' . ($page == 4 ? 'active' : '') . '"><a class="page-link" href="?category=' . $category_id . '&page=4">4</a></li>';
      
      
      // Hiển thị nút trang 5 (nếu có)
      if ($totalPages >= 5) {
          echo '<li class="page-item ' . ($page == 5 ? 'active' : '') . '"><a class="page-link" href="?category=' . $category_id . '&page=5">5</a></li>';
      }

      // Hiển thị nút Next
      if ($page < $totalPages) {
          echo '<li class="page-item"><a class="page-link" href="?category=' . $category_id . '&page=' . ($page + 1) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
      } else {
          echo '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&raquo;</span></li>';
      }

      echo '
        </ul>
      </nav>


    <!-- Pagination -->  
    </div>
    </main>
     <!--Main layout-->
    
    ';
    _footer();

?>