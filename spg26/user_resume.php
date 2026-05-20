
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if(!isset($_SESSION["id"])) {
header("Location:index.php");
exit();
}

$id = $_SESSION["id"];
$firstname = $_SESSION["firstname"];
$resumeFile = "";
$message = "";

include "connection.php";
include "lib01.php";

// saved resume from database
$sqs = "SELECT * FROM users WHERE id=$id";
$qresult = mysqli_query($dbc, $sqs);
$numberofrows = mysqli_num_rows($qresult);

if ($numberofrows == 1) {
$row = mysqli_fetch_array($qresult);
$resumeFile = $row["resume"];
}

if (isset($_POST["submit"])) {
$tagName = "myresume";
$fileAllowed = "pdf:PDF";
$sizeAllowed = 10000000;
$overwriteAllowed = 1;

$file = uploadFile($tagName, $fileAllowed, $sizeAllowed, $overwriteAllowed);

if ($file != false) {
$resumeFile = $file;
$message = "Resume uploaded successfully!";

$sqs = "UPDATE users SET resume='$resumeFile' WHERE id=$id";
mysqli_query($dbc, $sqs);
} else {
$message = "Sorry, uploading of the resume failed.";
}
}
?>

<html>
<head>
<title>Upload Resume</title>
<?php include "site_style.php"; ?>
</head>
<body>
<div class="page-shell">
<div class="card">
<?php include "user_nav.php"; ?>

<h1>Hello, <?php echo htmlspecialchars($firstname); ?>.</h1>
<h2>Upload Resume Here</h2>
<p>Please upload your resume as a PDF file.</p>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
<div class="form-row">
Select a PDF file to upload:<br>
<input type="file" name="myresume">
</div>
<input type="submit" name="submit" value="UPLOAD RESUME">
</form>

<?php
if ($message != "") {
echo "<div class='info-box success'><strong>$message</strong></div>";
}

if ($resumeFile != "") {
echo "<h2>Your saved resume</h2>";

echo "1. Using Hyperlink <br>";
echo "<a href='" . $resumeFile . "' target='_blank'>Click here to open your resume PDF</a>";

echo "<br><br>2. Using iframe tag <br>";
echo "<iframe src='" . $resumeFile . "' width='500' height='600'></iframe>";

echo "<br><br>3. Using embed tag <br>";
echo "<embed type='application/pdf' src='" . $resumeFile . "' width='600' height='600'>";
}
?>
</div>
</div>
</body>
</html>
