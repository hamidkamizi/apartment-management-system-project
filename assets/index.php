<?php
if (isset($_SESSION['resident_username'])) {
    header("Location: resident-dashboard.php");
    exit();
} elseif (isset($_SESSION['admin_username'])) {
    header("Location: admin-dashboard.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
