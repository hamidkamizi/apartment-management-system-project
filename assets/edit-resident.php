<?php
require_once 'config.php';
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
} elseif (!isset($_GET['rId'])) {
    header("Location: view-resident.php?action=danger&text=شناسه ساکن برای ویرایش یافت نشد.");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resident_id = $_POST['resident_id'];
    $name = $_POST['name'];
    $apartment_id = $_POST['apartment_id'];
    $contact = $_POST['contact'];
    $is_primary_resident = isset($_POST['is_primary_resident']) ? 1 : 0;
    $password = (empty($_POST['password'])) ? '' : ", password='$_POST[password]'";
    $query = "UPDATE residents SET name = '$name', apartment_id = '$apartment_id', contact = '$contact', is_primary_resident = '$is_primary_resident'$password WHERE id = '$resident_id'";

    if (mysqli_query($conn, $query)) {
        header("Location: view-resident.php?action=success&text=اطلاعات $name با موفقیت بروزرسانی شد.");
    } else {
        header("Location: view-resident.php?action=danger&text=" . mysqli_error($conn));
    }
}
$resident_id = $_GET['rId'];
$query = "SELECT * FROM residents WHERE id = '$resident_id'";
$result = mysqli_query($conn, $query);
$resident = mysqli_fetch_assoc($result);

$query_apartments = "SELECT id, apartment_number FROM apartments";
$result_apartments = mysqli_query($conn, $query_apartments);
$apartment_options = '';
while ($row = mysqli_fetch_assoc($result_apartments)) {
    $apCheck = ($resident['apartment_id'] == $row['id']) ? 'selected' : '';
    $apartment_options .= '<option value="' . $row['id'] . '" ' . $apCheck . '>' . $row['apartment_number'] . '</option>';
}
?>

<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ویرایش اطلاعات ساکن| <?= SITE_TITLE ?></title>
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
                    <input type="hidden" name="resident_id" value="<?= $resident_id ?>">
                    <!-- Logo starts -->
                    <a href="index-2.html" class="auth-logo mt-5 mb-3">
                        <img src="assets/images/logo.svg" alt="Bootstrap Gallery" />
                    </a>
                    <!-- Logo ends -->

                    <!-- Authbox starts -->
                    <div class="auth-box">

                        <h4 class="mb-4">ویرایش اطلاعات ساکن</h4>

                        <div class="mb-3">
                            <label class="form-label" for="name">نام<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name" id="name" class="form-control" placeholder="نام خود را وارد نمائید" value="<?= $resident['name']; ?>" required>
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
                                <input type="text" name="contact" id="contact" class="form-control" placeholder="شماره تماس خود را وارد نمائید" value="<?= $resident['contact']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">رمز عبور</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="رمز عبورخود را وارد نمائید">
                            </div>
                            <div class="form-text">
                                رمز عبور شما باید 8 تا 20 کاراکتر باشد.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-check-label" for="is_primary_resident">ساکن اصلی</label>
                            <div class="input-group">
                                <input type="checkbox" name="is_primary_resident" id="is_primary_resident" class="form-check-input" value="1" <?= $resident['is_primary_resident'] ? 'checked' : ''; ?>>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">ویرایش اطلاعات</button>
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