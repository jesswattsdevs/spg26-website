<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_SESSION["id"];
$firstname = $_SESSION["firstname"];
$uploadMessage = "";

include "lib01.php";
include "connection.php";

if (isset($_POST["submit"])) {
    $tagName = "myimage";
    $fileAllowed = "png:jpg:jpeg:gif";
    $sizeAllowed = 9000000;
    $overwriteAllowed = 1;

    $file = uploadFile($tagName, $fileAllowed, $sizeAllowed, $overwriteAllowed);

    if ($file != false) {
        $safeFile = mysqli_real_escape_string($dbc, $file);
        $sqs = "UPDATE users SET pic='$safeFile' WHERE id=$id";
        mysqli_query($dbc, $sqs);
        $uploadMessage = "<div class='info-box success'>Upload Successful!</div>";
    } else {
        $uploadMessage = "<div class='info-box error'>Upload Failed. Please choose a valid image file.</div>";
    }
}

$sqs = "SELECT pic FROM users WHERE id=$id";
$qresult = mysqli_query($dbc, $sqs);
$row = mysqli_fetch_array($qresult);
?>

<html>
<head>
    <title> Online Test - User Home </title>
    <?php include "site_style.php"; ?>
</head>
<body>
    <div class="page-shell">
        <div class="card">
            <h1>Hello, <?php echo htmlspecialchars($firstname); ?>.</h1>
            <p>Welcome to the Free Online Testing Site. Feel free to evaluate your Web Development Skills using our tests.</p>

            <?php include "user_nav.php"; ?>

            <?php echo $uploadMessage; ?>

            <h2>Your Profile Picture</h2>
            <?php if ($row && !empty($row["pic"])) { ?>
                <p class="note-text">Your current profile picture:</p>
                <img class="profile-pic" src="<?php echo htmlspecialchars($row["pic"]); ?>" width="200" alt="Profile Picture">
            <?php } else { ?>
                <div class="empty-state">No profile picture found.</div>
            <?php } ?>

            <form action="user_home.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    Upload/Update your profile picture:<br>
                    <input type="file" name="myimage">
                </div>
                <input type="submit" name="submit" value="UPLOAD">
            </form>
        </div>
    </div>
</body>
</html>
