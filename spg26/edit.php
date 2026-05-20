<?php
session_start();
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] != 0) {
    header("Location:index.php");
    exit();
}

$message = "No update request was submitted.";
$messageClass = "error";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    include "connection.php";
    $firstname = mysqli_real_escape_string($dbc, trim($_POST["firstname"]));
    $lastname = mysqli_real_escape_string($dbc, trim($_POST["lastname"]));
    $email = mysqli_real_escape_string($dbc, trim($_POST["email"]));
    $phone = mysqli_real_escape_string($dbc, trim($_POST["phone"]));
    $pw = mysqli_real_escape_string($dbc, trim($_POST["pw"]));

    $sqs = "UPDATE users SET firstname='$firstname', lastname='$lastname', email='$email', phone='$phone', pw='$pw' WHERE id='$id'";
    mysqli_query($dbc, $sqs);

    if (mysqli_affected_rows($dbc) >= 0) {
        $message = "You have successfully updated this user with email ".$email.".";
        $messageClass = "success";
    } else {
        $message = "Something is wrong with the update.";
    }
    mysqli_close($dbc);
}
?>
<html>
<head>
    <title>Update User</title>
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
