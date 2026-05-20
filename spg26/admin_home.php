<?php
session_start();
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] != 0) {
    header("Location:index.php");
    exit();
}
$firstname = $_SESSION["firstname"] ?? "Admin";
?>
<html>
<head>
    <title> Online Test - Admin User Home </title>
    <?php include "site_style.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="card">
            <h2>Welcome, <?php echo htmlspecialchars($firstname); ?>.</h2>
            <p>This admin area lets you review users, search records, and export the current user list to a CSV file.</p>
            <?php include "admin_nav.php"; ?>
        </div>
    </div>

</body>
</html>
