<?php
require_once "config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['user-role'] == 'admin') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);
        $admin = mysqli_fetch_assoc($result);

        if ($admin) {
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_name'] = $admin['name'];
            header("Location: admin-dashboard.php");
            exit();
        }
        $loginErr = "نام کاربری یا رمز عبور صحیح نیست.";
    } elseif ($_POST['user-role'] == 'resident') {
        $contact = $_POST['username'];
        $password = $_POST['password'];

        // Use prepared statement to prevent SQL injection
        $query = "SELECT * FROM residents WHERE contact = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $contact, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $resident = mysqli_fetch_assoc($result);

        if ($resident) {
            $_SESSION['resident_username'] = $resident['name']; // Store name in session
            $_SESSION['resident_id'] = $resident['id']; // Store resident ID in session
            header("Location: resident-dashboard.php");
            exit();
        }
        $loginErr = "نام کاربری یا رمز عبور صحیح نیست.";
    } else {
        $loginErr = "نقش کاربری به درستی انتخاب نشده است.";
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="rtl">


<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ورود به حساب کاربری | <?= SITE_TITLE ?></title>

    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="assets/css/main.min.css" />

</head>

<body>

    <!-- Page wrapper starts -->
    <div class="page-wrapper">

        <!-- Auth container starts -->
        <div class="auth-container">

            <div class="d-flex justify-content-center">

                <!-- Form starts -->
                <form method="POST">

                    <!-- Logo starts -->
                    <a href="index-2.html" class="auth-logo mt-5 mb-3">
                        <img src="assets/images/logo.svg" alt="Bootstrap Gallery" />
                    </a>
                    <!-- Logo ends -->

                    <!-- Authbox starts -->
                    <div class="auth-box">

                        <h4 class="mb-4"> خوش آمدید</h4>
                        <?php if (isset($loginErr)) : ?>
                            <div class="alert border-danger alert-dismissible fade show text-danger" role="alert">
                                <?= $loginErr ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label" for="username">نام کاربری <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="text" id="username" name="username" class="form-control" placeholder="ایمیل">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="password">رمز عبور<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="رمز عبور">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-2">
                            <!-- <label class="form-label" for="email">نقش خود را انتخاب کنید: <span class="text-danger">*</span></label> -->
                            <select class="form-select" id="user-role" name="user-role">
                                <option selected="">نقش کاربری *</option>
                                <option value="admin">مدیر</option>
                                <option value="resident">ساکن</option>
                            </select>
                        </div>

                        <!-- <div class="d-flex justify-content-end mb-3">
                            <a href="forgot-password.html" class="text-decoration-underline">رمز عبور خود را فراموش کرده اید؟</a>
                        </div> -->

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">ورود</button>
                            <a href="resident-register.php" class="btn btn-outline-secondary"> ثبت نام نکرده اید؟ ثبت نام </a>
                        </div>

                    </div>
                    <!-- Authbox ends -->

                </form>
                <!-- Form ends -->

            </div>

        </div>
        <!-- Auth container ends -->

    </div>
    <!-- Page wrapper ends -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>
    <script src="assets/js/custom.js"></script>
</body>


<!-- Mirrored from kodingwife.com/demos/templatemonster/one/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 07 May 2024 10:00:23 GMT -->

<!-- Mirrored from onepanel.liara.run/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 25 Jun 2024 13:04:34 GMT -->

</html>