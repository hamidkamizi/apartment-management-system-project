<?php
require_once 'config.php'; // Database connection

// Fetch apartment numbers for dropdown
$query_apartments = "SELECT id, apartment_number FROM apartments";
$result_apartments = mysqli_query($conn, $query_apartments);
$apartment_options = '';
while ($row = mysqli_fetch_assoc($result_apartments)) {
    $apartment_options .= '<option value="' . $row['id'] . '">' . $row['apartment_number'] . '</option>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $apartment_id = $_POST['apartment_id'];
    $contact = $_POST['contact'];
    $password = $_POST['password']; // New password field
    $is_primary_resident = isset($_POST['is_primary_resident']) ? 1 : 0;

    // Use prepared statement to prevent SQL injection
    $query = "INSERT INTO residents (name, apartment_id, contact, password, is_primary_resident) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sissi", $name, $apartment_id, $contact, $password, $is_primary_resident);

    if (mysqli_stmt_execute($stmt)) {
        session_start();
        $_SESSION['resident_username'] = $name;
        $_SESSION['resident_id'] = mysqli_insert_id($conn); // Store resident ID in session
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
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
                <form method="post" action="resident-register.php">

                    <!-- Logo starts -->
                    <a href="index-2.html" class="auth-logo mt-5 mb-3">
                        <img src="assets/images/logo.svg" alt="Bootstrap Gallery" />
                    </a>
                    <!-- Logo ends -->

                    <!-- Authbox starts -->
                    <div class="auth-box">

                        <h4 class="mb-4">ثبت نام</h4>

                        <div class="mb-3">
                            <label class="form-label" for="name">نام<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name" id="name" class="form-control" placeholder="نام خود را وارد نمائید" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="apartment_id">شماره آپارتمان <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-building"></i>
                                </span>
                                <select name="apartment_id" id="apartment_id" class="form-control" required>
                                    <?php echo $apartment_options; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="contact">تماس <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-phone"></i>
                                </span>
                                <input type="text" name="contact" id="contact" class="form-control" placeholder="شماره تماس خود را وارد نمائید" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">رمز عبور<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="رمز عبورخود را وارد نمائید" required>
                            </div>
                            <div class="form-text">
                                رمز عبور شما باید 8 تا 20 کاراکتر باشد.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-check-label" for="is_primary_resident">ساکن اصلی</label>
                            <div class="input-group">
                                <input type="checkbox" name="is_primary_resident" id="is_primary_resident" class="form-check-input" value="1">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">ثبت نام</button>
                            <a href="login.php" class="btn btn-outline-secondary"> از قبل حساب کاربری دارید؟ ورود</a>
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

</body>

</html>