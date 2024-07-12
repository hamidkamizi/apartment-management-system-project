<?php
session_start();
$servername = "localhost";
$username = "consiste_apartmentcms"; // Replace with your database username
$password = "!+6heBF]#oHj"; // Replace with your database password
$dbname = "consiste_apartmentcms"; // Replace with your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set UTF-8 encoding
mysqli_set_charset($conn, "utf8");

// Optionally, set collation (if needed)
mysqli_query($conn, "SET collation_connection = 'utf8_general_ci'");
define('SITE_TITLE', 'مدیریت شارژ ساختمان کمیزی');
$sidebarMenuItems = [
    'resident-dashboard' => ['text' => "داشبورد", 'icon' => 'pie-chart', 'is-active' => false],
    'pay-elevator-charge' => ['text' => "پرداخت شارژ آسانسور", 'icon' => 'grip-vertical', 'is-active' => false],
    'pay-parking-charges' => ['text' => "پرداخت شارژ پارکینگ", 'icon' => 'p-circle', 'is-active' => false],
    'pay-charge-monthly-apartment' => ['text' => "پرداخت شارژ ماهانه", 'icon' => 'house', 'is-active' => false],
    'logout' => ['text' => "خروج", 'icon' => 'box-arrow-left', 'is-active' => false],
];
$adminSidebarMenuItems = [
    'admin-dashboard' => ['text' => "داشبورد", 'icon' => 'pie-chart', 'is-active' => false],
    'add-apartment' => ['text' => "اضافه کردن آپارتمان", 'icon' => 'plus-circle', 'is-active' => false],
    'view-apartment' => ['text' => "مشاهده آپارتمان‌ها", 'icon' => 'eye', 'is-active' => false],
    'view-resident' => ['text' => "مشاهده ساکنین", 'icon' => 'list', 'is-active' => false],
    'add-late-penalty' => ['text' => "اضافه کردن جریمه دیرکرد", 'icon' => 'plus-circle', 'is-active' => false],
    'calculation-of-late-penalty' => ['text' => "محاسبه جریمه دیرکرد", 'icon' => 'calculator', 'is-active' => false],
    'view-late-penalty' => ['text' => "مشاهده جریمه‌های دیرکرد", 'icon' => 'list', 'is-active' => false],
    // 'add-resident' => ['text' => "اضافه کردن ساکن", 'icon' => 'plus-circle', 'is-active' => false],
    'view-charges' => ['text' => "مشاهده شارژها", 'icon' => 'receipt', 'is-active' => false],
    'logout' => ['text' => "خروج", 'icon' => 'box-arrow-left', 'is-active' => false],
];
require_once 'jdf.php';
