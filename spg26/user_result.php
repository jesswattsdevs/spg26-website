<?php
session_start();
$id=$_SESSION["id"];
$firstname=$_SESSION["firstname"];

?>

<html> 
<head>
    <title> Online Test- Result </title>
    <?php include "site_style.php"; ?>
</head>
<body> 
<div class="page-shell">
<div class="card">
<?php include "user_nav.php"; ?>
<h1>Hi <?php echo htmlspecialchars($firstname); ?>, here's your evaluation result.</h1>

<?php
include "connection.php";

$sqs="SELECT * FROM users WHERE id='$id'";
        $result=mysqli_query($dbc, $sqs);
        $numrows=mysqli_num_rows($result);
        //echo" Num of rows is".$numrows;
        if($numrows==1){
            $row=mysqli_fetch_array($result);
            $dbphp=$row["php"];
            $dbsql=$row["sql"];
            $dbhtmlcss=$row["htmlcss"];
            echo "<div class='info-box'>";
            echo "The PHP evaluation result is: ".$dbphp.".<br>";
            echo "The SQL evaluation result is: ".$dbsql.".<br>";
            echo "The HTML/CSS evaluation result is: ".$dbhtmlcss.".<br>";
            echo "</div>";
        }
        else {
            echo "<div class='info-box error'>Sorry, we are having trouble with your evaluation result.</div>";
        }

?>
</div>
</div>
</body>
</html>
