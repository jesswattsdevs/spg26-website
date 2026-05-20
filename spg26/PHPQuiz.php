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
        if ($Q1 == "C") {
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
        if ($Q2 == "A") {
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
        if ($Q3 == "B") {
            $Q3Mesg = "Good job!";
            $quizScore++;
        } else {
            $Q3Mesg = "Sorry, not correct.";
        }
    }

    if ($flag == 0) {
        $quizResult = ($quizScore / 3) * 100;
        include "connection.php";
        $sqs = "UPDATE users SET php=$quizResult WHERE id=$id";
        $returnValue = mysqli_query($dbc, $sqs);

        if ($returnValue) {
            $resultMessage = "Thank you for completing the PHP assessment. Your score is ".$quizResult."%.";
            $resultClass = "success";
        } else {
            $resultMessage = "We have trouble saving your result. Something is wrong...";
            $resultClass = "error";
        }
        mysqli_close($dbc);
    }
}
?>
<html>
<head>
    <title>PHP Evaluation</title>
    <?php include "site_style.php"; ?>
</head>
<body>
<div class="page-shell">
<div class="card">

<?php include "user_nav.php"; ?>

<h1>PHP Evaluation Questions</h1>
<p>This page will help you evaluate your PHP skills.</p>
<?php if ($resultMessage != "") { ?>
<div class="info-box <?php echo $resultClass; ?>"><?php echo $resultMessage; ?></div>
<?php } ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <p>1. Which symbol is used to start a variable in PHP? <span class="error">* <?php echo $Q1Mesg; ?></span><br>
    <input type="radio" name="Q1" value="A" <?php if ($Q1=="A") echo "checked"; ?>> #
    <input type="radio" name="Q1" value="B" <?php if ($Q1=="B") echo "checked"; ?>> &
    <input type="radio" name="Q1" value="C" <?php if ($Q1=="C") echo "checked"; ?>> $
    <input type="radio" name="Q1" value="D" <?php if ($Q1=="D") echo "checked"; ?>> %
    </p>

    <p>2. Which PHP function is used to print text? <span class="error">* <?php echo $Q2Mesg; ?></span><br>
    <input type="radio" name="Q2" value="A" <?php if ($Q2=="A") echo "checked"; ?>> echo
    <input type="radio" name="Q2" value="B" <?php if ($Q2=="B") echo "checked"; ?>> console.log
    <input type="radio" name="Q2" value="C" <?php if ($Q2=="C") echo "checked"; ?>> printline
    <input type="radio" name="Q2" value="D" <?php if ($Q2=="D") echo "checked"; ?>> response.write
    </p>

    <p>3. Which superglobal is commonly used to collect form data sent with method POST? <span class="error">* <?php echo $Q3Mesg; ?></span><br>
    <input type="radio" name="Q3" value="A" <?php if ($Q3=="A") echo "checked"; ?>> $_GET
    <input type="radio" name="Q3" value="B" <?php if ($Q3=="B") echo "checked"; ?>> $_POST
    <input type="radio" name="Q3" value="C" <?php if ($Q3=="C") echo "checked"; ?>> $_DATA
    <input type="radio" name="Q3" value="D" <?php if ($Q3=="D") echo "checked"; ?>> $_FORM
    </p>

    <input type="submit" value="Submit">
</form>
</div>
</div>
</body>
</html>
