<?php     
    include('includes/Database.php');

    _header('Admin');
   
    
echo' <!--Main Navigation-->
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
        <a href="admin.php" class="list-group-item list-group-item-action py-2 ripple">
          <i class="fas fa-chart-area fa-fw me-3"></i><span>Quản lý sản phẩm</span>
        </a>
       
        <a href="quanlynguoidung.php" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-chart-line fa-fw me-3"></i><span>Quản lý người dùng</span></a
        >
        <a href="quanlydonhang.php" class="list-group-item list-group-item-action py-2 ripple">
          <i class="fas fa-chart-pie fa-fw me-3"></i><span>Quản lý đơn hàng</span>
        </a>
        <a href="quanlydanhmuc.php" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-chart-bar fa-fw me-3"></i><span>Quản lý danh mục</span></a
        >
        <a href="chat.php" class="list-group-item list-group-item-action py-2 ripple active"
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
          placeholder='.'Search (ctrl + "/" to focus)'.'
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

<!--Main Navigation-->

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
                        echo'
                        <li class="nav-item">
                          <a class="nav-link d-flex flex-column text-center" aria-current="page" href="admin.php"><i
                                  class="fas fa-user-friends fa-lg"></i><span class="small">Xin chào '.$name.'!</a>
                      </li>
      
                      <li class="nav-item">
                          <a class="nav-link d-flex flex-column text-center" aria-current="page" href="logoutadmin.php"><i
                                  class="fas fa-comment-dots fa-lg"></i><span class="small">Đăng xuất</span></a>
                      </li>
                    ';
                    } else {
                        echo'
                        <li class="nav-item">
                        <a class="nav-link d-flex flex-column text-center" aria-current="page" href="login_admin.php"><i
                                class="fas fa-comment-dots fa-lg"></i><span class="small">Login</span></a>
                    </li>
                   ';
                    } 
                      echo'
                  </ul>
                  <!-- Left links -->
              </div>
              <!-- Collapsible wrapper -->
          </div>
          <!-- Container wrapper -->
      </nav>
      <!-- Navbar -->
     
      ';
 

    
    
  
      // Xử lý tìm kiếm
      $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
      $search_condition = $search_query ? "WHERE product_name LIKE '%$search_query%'" : '';
    
      // Hiển thị tiêu đề
      echo '
    
          <div class="container">
              <div class="row justify-content-center">
                  <div class="col-12 col-md-10 text-center">
                      <div class="heading pb-4">
                          <h2>Chat</h2>
                          <br>
                      </div>
                  </div>
              </div>
           ';
    

?>
