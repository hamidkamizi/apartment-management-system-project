<?php
require_once "config.php";

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apartment_number = $_POST['apartment_number'];
    $floor = $_POST['floor'];
    $number_of_rooms = $_POST['number_of_rooms'];
    $owner_name = $_POST['owner_name'];
    $owner_contact = $_POST['owner_contact'];

    $query = "INSERT INTO apartments (apartment_number, floor, number_of_rooms, owner_name, owner_contact) VALUES ('$apartment_number', '$floor', '$number_of_rooms', '$owner_name', '$owner_contact')";

    if (mysqli_query($conn, $query)) {
        $addResponse = ['success', "افزودن آپارتمان با موفقیت انجام شد"];
    } else {
        $addResponse = ['danger', "Error: " . mysqli_error($conn)];
    }
}
$adminSidebarMenuItems['add-apartment']['is-active'] = true;
?>

<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>داشبورد مدیر | <?= SITE_TITLE ?></title>
    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="assets/css/main.min.css" />
    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />
    <!-- Toastify CSS -->
    <link rel="stylesheet" href="assets/vendor/toastify/toastify.css" />
</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->
        <div class="main-container">

            <!-- Sidebar wrapper start -->
            <nav id="sidebar" class="sidebar-wrapper">

                <!-- App brand starts -->
                <div class="app-brand px-3 py-2 d-flex align-items-center">
                    <a href="index-2.html">
                        <img src="assets/images/logo.svg" class="logo" alt="Bootstrap Gallery" />
                    </a>
                </div>
                <!-- App brand ends -->

                <!-- Sidebar profile starts -->
                <div class="sidebar-profile">
                    <img src="assets/images/user6.png" class="img-3x me-3 rounded-3" alt="Admin Dashboard" />
                    <div class="m-0">
                        <p class="m-0">سلام &#128075;</p>
                        <h6 class="m-0 text-nowrap"><?= $_SESSION['admin_name']; ?></h6>
                    </div>
                </div>
                <!-- Sidebar profile ends -->

                <!-- Sidebar menu starts -->
                <div class="sidebarMenuScroll">
                    <ul class="sidebar-menu">
                        <?php foreach ($adminSidebarMenuItems as $url => $item) : ?>
                            <li <?php if ($item['is-active']) echo ' class="active current-page"'; ?>>
                                <a href="<?= $url ?>.php">
                                    <i class="bi bi-<?= $item['icon'] ?>"></i>
                                    <span class="menu-text"><?= $item['text'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- Sidebar menu ends -->

            </nav>
            <!-- Sidebar wrapper end -->

            <!-- App container starts -->
            <div class="app-container">

                <!-- App header starts -->
                <div class="app-header">

                    <!-- Toggle buttons start -->
                    <div class="d-flex">
                        <button class="btn btn-outline-info btn-sm me-3 toggle-sidebar" id="toggle-sidebar">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <button class="btn btn-outline-info btn-sm me-3 pin-sidebar" id="pin-sidebar">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                    </div>
                    <!-- Toggle buttons end -->

                    <!-- App brand start -->
                    <div class="app-brand-sm">
                        <a href="index-2.html" class="d-lg-none d-md-block">
                            <img src="assets/images/logo-sm.svg" class="logo" alt="Bootstrap Gallery">
                        </a>
                    </div>
                    <!-- App brand end -->

                    <!-- App header actions start -->
                    <div class="header-actions">

                        <div class="dropdown ms-2">
                            <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="icon-box md bg-info text-white rounded-5"><?= mb_substr($_SESSION['admin_name'], 0, 1) . " " . mb_substr($_SESSION['admin_name'], mb_strpos($_SESSION['admin_name'], " ") + 1, 1) ?></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-start">
                                <a class="dropdown-item d-flex align-items-center" href="logout.php"><i class="bi bi-escape fs-4 me-2"></i>خروج</a>
                            </div>
                        </div>
                    </div>
                    <!-- App header actions end -->

                </div>
                <!-- App header ends -->

                <!-- App hero header starts -->
                <div class="app-hero-header d-flex align-items-center">

                    <!-- Breadcrumb start -->
                    <ol class="breadcrumb d-none d-lg-flex">
                        <li class="breadcrumb-item">
                            <i class="bi bi-house lh-1"></i>
                            <a href="resident-dashboard.php" class="text-decoration-none">خانه</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            داشبورد
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            آپارتمان ها
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            اضافه کردن آپارتمان
                        </li>
                    </ol>
                    <!-- Breadcrumb end -->



                </div>
                <!-- App Hero header ends -->

                <!-- App body starts -->
                <div class="app-body">
                    <form method="POST">
                        <h5 class="card-title" style="margin-bottom: 15px;">افزودن آپارتمان</h5>
                        <?php if (isset($addResponse)) : ?>
                            <div class="alert bg-<?= $addResponse[0] ?> alert-dismissible d-flex align-items-center fade show" role="alert">
                                <?= $addResponse[0] == 'danger' ? '<i class="bi bi-x-circle fs-2 me-2 lh-1"></i>' : '<i class="bi bi-check-circle fs-2 me-2 lh-1"></i>' ?>
                                <?= $addResponse[1] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="m-0">
                                            <label class="form-label" for="a1">شماره آپارتمان</label>
                                            <input type="text" class="form-control" id="a1" name="apartment_number" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="m-0">
                                            <label class="form-label" for="a2">طبقه</label>
                                            <input type="number" class="form-control" id="a2" name="floor" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="m-0">
                                            <label class="form-label" for="a3">تعداد اتاق‌ها</label>
                                            <input type="number" class="form-control" id="a3" name="number_of_rooms" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="m-0">
                                            <label class="form-label" for="a4">نام مالک</label>
                                            <input type="text" class="form-control" id="a4" name="owner_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="m-0">
                                            <label class="form-label" for="a5">شماره تماس مالک</label>
                                            <input type="text" class="form-control" id="a5" name="owner_contact">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="card mb-12">
                                    <div class="card-body">
                                        <div class="m-0">
                                            <input type="submit" class="btn btn-primary" value="افزودن آپارتمان">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- App body ends -->

                <!-- App footer start -->
                <div class="app-footer">
                    <span>پیاده سازی توسط حمید کمیزی</span>
                </div>
                <!-- App footer end -->

            </div>
            <!-- App container ends -->

        </div>
        <!-- Main container end -->

    </div>
    <!-- Page wrapper end -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- Overlay Scroll JS -->
    <script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>
    <!-- Toastify JS -->
    <script src="assets/vendor/toastify/toastify.js"></script>
    <script src="assets/vendor/toastify/custom.js"></script>
    <!-- Apex Charts -->
    <script src="assets/vendor/apex/apexcharts.min.js"></script>
    <script src="assets/vendor/apex/custom/dash1/visitors.js"></script>
    <script src="assets/vendor/apex/custom/dash1/sales.js"></script>
    <script src="assets/vendor/apex/custom/dash1/orders.js"></script>
    <script src="assets/vendor/apex/custom/dash1/sparkline.js"></script>
    <script src="assets/vendor/apex/custom/dash1/tasks.js"></script>

    <!-- Vector Maps -->
    <script src="assets/vendor/jvectormap/jquery-jvectormap-2.0.5.min.js"></script>
    <script src="assets/vendor/jvectormap/gdp-data.js"></script>
    <script src="assets/vendor/jvectormap/us_aea.js"></script>
    <script src="assets/vendor/jvectormap/usa.js"></script>
    <script src="assets/vendor/jvectormap/custom/map-usa4.js"></script>

    <!-- Custom JS files -->
    <script src="assets/js/custom.js"></script>
</body>

</html>