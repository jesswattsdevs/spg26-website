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
        if ($Q3 == "C") {
            $Q3Mesg = "Good job!";
            $quizScore++;
        } else {
            $Q3Mesg = "Sorry, not correct.";
        }
    }

    if ($flag == 0) {
        $quizResult = ($quizScore / 3) * 100;
        include "connection.php";
        $sqs = "UPDATE users SET htmlcss=$quizResult WHERE id=" . intval($id);
        $returnValue = mysqli_query($dbc, $sqs);

        if ($returnValue) {
            $resultMessage = "Thank you for completing the HTML/CSS assessment. Your score is $quizResult%.";
            $resultClass = "success";
        } else {
            $resultMessage = "We had trouble saving your result: " . mysqli_error($dbc);
            $resultClass = "error";
        }
        mysqli_close($dbc);
    }
}
?>
<html>
<head>
    <title>HTML/CSS Evaluation</title>
    <?php include "site_style.php"; ?>
</head>
<body>
<div class="page-shell">
<div class="card">

<?php include "user_nav.php"; ?>

<h1>HTML/CSS Evaluation Questions</h1>
<p>This page will help you evaluate your web structure and styling skills.</p>
<?php if ($resultMessage != "") { ?>
<div class="info-box <?php echo $resultClass; ?>"><?php echo $resultMessage; ?></div>
<?php } ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <p>1. Which HTML tag is used to define a hyperlink? <span class="error">* <?php echo $Q1Mesg; ?></span><br>
    <input type="radio" name="Q1" value="A" <?php if ($Q1=="A") echo "checked"; ?>> &lt;link&gt;
    <input type="radio" name="Q1" value="B" <?php if ($Q1=="B") echo "checked"; ?>> &lt;a&gt;
    <input type="radio" name="Q1" value="C" <?php if ($Q1=="C") echo "checked"; ?>> &lt;href&gt;
    <input type="radio" name="Q1" value="D" <?php if ($Q1=="D") echo "checked"; ?>> &lt;img&gt;
    </p>

    <p>2. Which CSS property changes background color? <span class="error">* <?php echo $Q2Mesg; ?></span><br>
    <input type="radio" name="Q2" value="A" <?php if ($Q2=="A") echo "checked"; ?>> background-color
    <input type="radio" name="Q2" value="B" <?php if ($Q2=="B") echo "checked"; ?>> color
    <input type="radio" name="Q2" value="C" <?php if ($Q2=="C") echo "checked"; ?>> bgcolor
    <input type="radio" name="Q2" value="D" <?php if ($Q2=="D") echo "checked"; ?>> font-color
    </p>

    <p>3. Which CSS property is used to change text color? <span class="error">* <?php echo $Q3Mesg; ?></span><br>
    <input type="radio" name="Q3" value="A" <?php if ($Q3=="A") echo "checked"; ?>> text-color
    <input type="radio" name="Q3" value="B" <?php if ($Q3=="B") echo "checked"; ?>> font-color
    <input type="radio" name="Q3" value="C" <?php if ($Q3=="C") echo "checked"; ?>> color
    <input type="radio" name="Q3" value="D" <?php if ($Q3=="D") echo "checked"; ?>> background-color
    </p>

    <input type="submit" value="Submit">
</form>
</div>
</div>
</body>
</html>
