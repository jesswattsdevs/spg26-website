<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location:index.php");
    exit();
}

$id = $_SESSION["id"];
$Q1Mesg = $Q2Mesg = $Q3Mesg = "";
$Q1 = $Q2 = $Q3 = "";
$flag = 0;
$quizScore = 0;
$resultMessage = "";
$resultClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Q1"])) {
        $Q1Mesg = "Please answer this question.";
        $flag = 1;
    } else {
        $Q1 = $_POST["Q1"];
        if ($Q1 == "B") {
            $Q1Mesg = "Good job!";
            $quizScore++;
        } else {
            $Q1Mesg = "Sorry, not correct.";
        }
    }

    if (empty($_POST["Q2"])) {
        $Q2Mesg = "Please answer this question.";
        $flag = 1;
    } else {
        $Q2 = $_POST["Q2"];
        if ($Q2 == "C") {
            $Q2Mesg = "Good job!";
            $quizScore++;
        } else {
            $Q2Mesg = "Sorry, not correct.";
        }
    }

    if (empty($_POST["Q3"])) {
        $Q3Mesg = "Please answer this question.";
        $flag = 1;
    } else {
        $Q3 = $_POST["Q3"];
        if ($Q3 == "A") {
            $Q3Mesg = "Good job!";
            $quizScore++;
        } else {
            $Q3Mesg = "Sorry, not correct.";
        }
    }

    if ($flag == 0) {
        $quizResult = ($quizScore / 3) * 100;
        include "connection.php";
        $sqs = "UPDATE users SET `sql`=$quizResult WHERE id=$id";
        $returnValue = mysqli_query($dbc, $sqs);

        if ($returnValue) {
            $resultMessage = "Thank you for completing the SQL assessment. Your score is ".$quizResult."%.";
            $resultClass = "success";
        } else {
            $resultMessage = "We have trouble with your result. Something is wrong...";
            $resultClass = "error";
        }
        mysqli_close($dbc);
    }
}
?>
<html>
<head>
    <title>SQL Evaluation</title>
    <?php include "site_style.php"; ?>
</head>
<body>
<div class="page-shell">
<div class="card">
<?php include "user_nav.php"; ?>
<h1>SQL Evaluation Questions</h1>
<p>This page will help you evaluate your SQL skills.</p>
<?php if ($resultMessage != "") { ?>
<div class="info-box <?php echo $resultClass; ?>"><?php echo $resultMessage; ?></div>
<?php } ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <p>1. Which SQL statement is used to get data from a table? <span class="error">* <?php echo $Q1Mesg; ?></span><br>
    <input type="radio" name="Q1" value="A" <?php if ($Q1=="A") echo "checked"; ?>> OPEN
    <input type="radio" name="Q1" value="B" <?php if ($Q1=="B") echo "checked"; ?>> SELECT
    <input type="radio" name="Q1" value="C" <?php if ($Q1=="C") echo "checked"; ?>> GET
    <input type="radio" name="Q1" value="D" <?php if ($Q1=="D") echo "checked"; ?>> EXTRACT
    </p>

    <p>2. Which clause is used to filter rows in SQL? <span class="error">* <?php echo $Q2Mesg; ?></span><br>
    <input type="radio" name="Q2" value="A" <?php if ($Q2=="A") echo "checked"; ?>> ORDER BY
    <input type="radio" name="Q2" value="B" <?php if ($Q2=="B") echo "checked"; ?>> GROUP BY
    <input type="radio" name="Q2" value="C" <?php if ($Q2=="C") echo "checked"; ?>> WHERE
    <input type="radio" name="Q2" value="D" <?php if ($Q2=="D") echo "checked"; ?>> LIMIT BY
    </p>

    <p>3. Which SQL command is used to add a new row to a table? <span class="error">* <?php echo $Q3Mesg; ?></span><br>
    <input type="radio" name="Q3" value="A" <?php if ($Q3=="A") echo "checked"; ?>> INSERT
    <input type="radio" name="Q3" value="B" <?php if ($Q3=="B") echo "checked"; ?>> UPDATE
    <input type="radio" name="Q3" value="C" <?php if ($Q3=="C") echo "checked"; ?>> MODIFY
    <input type="radio" name="Q3" value="D" <?php if ($Q3=="D") echo "checked"; ?>> CREATE
    </p>

    <input type="submit" value="Submit">
</form>
</div>
</div>
</body>
</html>
