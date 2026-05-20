<?php
session_start();
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] != 0) {
    header("Location:index.php");
    exit();
}

include "connection.php";

$sqs = "SELECT id, firstname, lastname, email, phone, level, php, `sql`, htmlcss, pw FROM users ORDER BY firstname ASC";
$result = mysqli_query($dbc, $sqs);
$message = "";
$isError = false;

$exportDir = __DIR__ . "/exports";
if (!file_exists($exportDir)) {
    mkdir($exportDir, 0777, true);
}
@chmod($exportDir, 0777);

$filepath = $exportDir . "/users.csv";
$publicPath = "exports/users.csv";
$file = fopen($filepath, "w");

if ($result && $file) {
    fputcsv($file, array("id", "firstname", "lastname", "email", "phone", "level", "php", "sql", "htmlcss", "pw"));

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($file, $row);
    }

    fclose($file);
    $message = "All users have been exported successfully.";
} else {
    $isError = true;
    $message = "Export failed. Please check the exports folder permissions and try again.";
    if ($file) {
        fclose($file);
    }
}
?>
<html>
<head>
    <title>Export Users</title>
    <?php include "site_style.php"; ?>
</head>
<body>
<div class="page-shell">
<div class="card">
<?php include "admin_nav.php"; ?>
<h2>Export Complete</h2>
<div class="info-box <?php echo $isError ? "error" : "success"; ?>"><?php echo htmlspecialchars($message); ?></div>
<?php if (!$isError) { ?>
<p><a href="<?php echo htmlspecialchars($publicPath); ?>" download>Download the CSV file</a></p>
<?php } ?>
<p><a href="admin_manage.php">Back to Admin Manage</a></p>
</div>
</div>
</body>
</html>
