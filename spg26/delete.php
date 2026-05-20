<?php
session_start();
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] != 0) {
    header("Location:index.php");
    exit();
}

$message = "No delete request was submitted.";
$messageClass = "error";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "connection.php";
    $id = intval($_POST["id"]);
    $email = $_POST["email"];

    $sqs = "DELETE FROM users WHERE id=$id";
    mysqli_query($dbc, $sqs);

    if (mysqli_affected_rows($dbc) == 1) {
        $message = "This user with email " . htmlspecialchars($email) . " has been deleted.";
        $messageClass = "success";
    } else {
        $message = "Something is wrong with the delete.";
    }
}
?>
<html>
<head>
    <title>Delete User</title>
    <?php include "site_style.php"; ?>
</head>
<body>
<div class="page-shell">
<div class="card">
<?php include "admin_nav.php"; ?>
<div class="info-box <?php echo $messageClass; ?>"><?php echo $message; ?></div>
<p><a href="admin_manage.php">Click here to go back.</a></p>
</div>
</div>
</body>
</html>
