<?php
session_start();
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] != 0) {
    header("Location:index.php");
    exit();
}

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$dbfirstname = "";
$dblastname = "";
$dbemail = "";
$dbphone = "";
$dbpw = "";
$dbid = $id;
$message = "";

include "connection.php";
$sqs = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($dbc, $sqs);
$num = $result ? mysqli_num_rows($result) : 0;

if ($num == 1) {
    $row = mysqli_fetch_array($result);
    $dbfirstname = $row["firstname"];
    $dblastname = $row["lastname"];
    $dbemail = $row["email"];
    $dbphone = $row["phone"];
    $dbpw = $row["pw"];
    $dbid = $row["id"];
} else {
    $message = "Something is wrong. User was not found.";
}
?>
<html>
<head>
    <title> Admin Edit Users </title>
    <?php include "site_style.php"; ?>
</head>
<body>
<div class="page-shell">
<div class="card">
<?php include "admin_nav.php"; ?>
<h1>Update User</h1>
<?php if ($message != "") { ?>
<div class="info-box error"><?php echo $message; ?></div>
<?php } else { ?>
<p>Are you sure you want to update the following user?</p>
<form action="edit.php" method="post">
    <input type="hidden" name="id" value="<?php echo $dbid; ?>">
    <div class="form-row">First Name:<br><input type="text" name="firstname" value="<?php echo htmlspecialchars($dbfirstname); ?>"></div>
    <div class="form-row">Last Name:<br><input type="text" name="lastname" value="<?php echo htmlspecialchars($dblastname); ?>"></div>
    <div class="form-row">Email:<br><input type="text" name="email" value="<?php echo htmlspecialchars($dbemail); ?>"></div>
    <div class="form-row">Phone:<br><input type="text" name="phone" value="<?php echo htmlspecialchars($dbphone); ?>"></div>
    <div class="form-row">Password:<br><input type="text" name="pw" value="<?php echo htmlspecialchars($dbpw); ?>"></div>
    <input type="submit" name="update" value="CONFIRM UPDATE">
</form>
<?php } ?>
</div>
</div>
</body>
</html>
