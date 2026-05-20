<?php
session_start();
include "lib01.php";

$message = "";
$savedEmail = $_COOKIE["remember_email"] ?? "";
$savedPw = $_COOKIE["remember_pw"] ?? "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"] ?? "");
    $pw = test_input($_POST["pw"] ?? "");
    $savedEmail = $email;
    $savedPw = $pw;

    include "connection.php";

    $safeEmail = mysqli_real_escape_string($dbc, $email);
    $sqs = "SELECT * FROM users WHERE email='$safeEmail'";
    $result = mysqli_query($dbc, $sqs);
    $numrows = $result ? mysqli_num_rows($result) : 0;

    if ($numrows == 1) {
        $row = mysqli_fetch_array($result);
        $dbpw = $row["pw"];
        $dbfirstname = $row["firstname"] ?? "";
        $dbuser_type = $row["user_type"] ?? 1;
        $_SESSION["user_type"] = $dbuser_type;
        $_SESSION["id"] = $row["id"];
        $_SESSION["firstname"] = $dbfirstname;
        $verified = password_verify($pw, $dbpw);

        if ($verified || $pw == $dbpw) {
            setcookie("remember_email", $email, time() + (7 * 24 * 60 * 60), "/");
            setcookie("remember_pw", $pw, time() + (7 * 24 * 60 * 60), "/");

            if ($dbuser_type == 0) {
                header("Location:admin_home.php");
            } else {
                header("Location:user_home.php");
            }
            exit();
        } else {
            $message = "Sorry, Password is NOT correct. Please try again!";
        }
    } elseif ($numrows == 0) {
        $message = "Sorry, your email is not in the system. Please register!";
    } else {
        $message = "Something is wrong. Please try again later.";
    }

    mysqli_close($dbc);
}
?>

<html>
    <head>
        <title> Online-Test Index Page </title>
        <?php include "site_style.php"; ?>
    </head>
    <body>
    <div class="page-shell">
        <div class="card">
            <h1>Welcome to Jimmy's Free Online Testing Site</h1>
            <p>Login cookies will remember your email and password for one week.</p>
            <p>submited by Jessica Watts</p>
            <p class="note-text">That cookie expires automatically after 7 days, so returning users can sign in faster.</p>
            <p>If you do not have an account, please <a href="registration.php">sign up</a>.</p>
            <?php if ($message != "") { ?>
            <div class="info-box error"><?php echo $message; ?></div>
            <?php } ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-row">
                    Email:<br>
                    <input type="text" name="email" maxlength="50" value="<?php echo htmlspecialchars($savedEmail); ?>">
                </div>
                <div class="form-row">
                    Password:<br>
                    <input type="password" name="pw" maxlength="15" id="psw" value="<?php echo htmlspecialchars($savedPw); ?>">
                </div>
                <input type="submit" name="login" value="LOGIN">
            </form>
        </div>
    </div>
    </body>
</html>
