<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location:index.php");
    exit();
}

$id = $_SESSION["id"];
$firstname = "";
$lastname = "";
$phone = "";
$email = "";
$gender = "";
$level = "";
$oldpw = "";
$typedoldpw = "";
$newpw = "";
$confirmpw = "";

$firstnameErr = "";
$lastnameErr = "";
$phoneErr = "";
$emailErr = "";
$genderErr = "";
$levelErr = "";
$typedoldpwErr = "";
$newpwErr = "";
$confirmpwErr = "";
$message = "";
$flag = 0;

include "connection.php";

$sqs = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($dbc, $sqs);

if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $phone = $row["phone"];
    $email = $row["email"];
    $gender = $row["gender"];
    $level = $row["level"];
    $oldpw = $row["pw"];
} else {
    $message = "User record was not found.";
    $flag = 1;
}

if (($_SERVER["REQUEST_METHOD"] ?? "") == "POST") {
    $id = test_input($_POST["id"]);
    $firstname = test_input($_POST["firstname"]);
    $lastname = test_input($_POST["lastname"]);
    $phone = test_input($_POST["phone"]);
    $email = test_input($_POST["email"]);
    $gender = $_POST["gender"] ?? "";
    $level = $_POST["level"] ?? "";
    $typedoldpw = test_input($_POST["oldpw"]);
    $newpw = test_input($_POST["newpw"]);
    $confirmpw = test_input($_POST["confirmpw"]);

    if ($firstname == "") {
        $firstnameErr = "First name is required!";
        $flag = 2;
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
        $firstnameErr = "Only letters and white space allowed.";
        $flag = 3;
    }

    if ($lastname == "") {
        $lastnameErr = "Last name is required!";
        $flag = 4;
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
        $lastnameErr = "Only letters and white space allowed.";
        $flag = 5;
    }

    if ($phone == "") {
        $phoneErr = "Phone is required!";
        $flag = 6;
    } elseif (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
        $phoneErr = "Invalid phone number!";
        $flag = 7;
    }

    if ($email == "") {
        $emailErr = "Email is required!";
        $flag = 8;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format!";
        $flag = 9;
    }

    if ($gender == "") {
        $genderErr = "Gender is required!";
        $flag = 10;
    }

    if ($level == "" || $level == "---") {
        $levelErr = "Credit hour is required!";
        $flag = 11;
    }

    if ($typedoldpw == "") {
        $typedoldpwErr = "Old password is required!";
        $flag = 12;
    } elseif (!password_verify($typedoldpw, $oldpw) && $typedoldpw != $oldpw) {
        $typedoldpwErr = "Old password is incorrect!";
        $flag = 13;
    }

    if ($newpw == "") {
        $newpwErr = "New password is required!";
        $flag = 14;
    }

    if ($confirmpw == "") {
        $confirmpwErr = "Please confirm the new password!";
        $flag = 15;
    } elseif ($newpw != $confirmpw) {
        $confirmpwErr = "New passwords do not match!";
        $flag = 16;
    }

    if ($flag == 0) {
        $checkEmail = "SELECT * FROM users WHERE email='$email' AND id<>'$id'";
        $emailResult = mysqli_query($dbc, $checkEmail);

        if ($emailResult && mysqli_num_rows($emailResult) != 0) {
            $emailErr = "Email has been used. Please try a different email.";
        } else {
            $hashedNewPw = password_hash($newpw, PASSWORD_DEFAULT);
            $updateSql = "UPDATE users SET firstname='$firstname', lastname='$lastname', phone='$phone', email='$email', gender='$gender', level='$level', pw='$hashedNewPw' WHERE id='$id'";
            mysqli_query($dbc, $updateSql);
            $updated = mysqli_affected_rows($dbc);

            if ($updated >= 0) {
                $message = "Your profile has been updated successfully!";
                $oldpw = $hashedNewPw;
            } else {
                $message = "Update was not successful. Please try again.";
            }
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<html>
<head>
<title> Online Test - User Update Profile </title>
<?php include "site_style.php"; ?>
</head>
<body>
<div class="page-shell">
<div class="card">
<?php include "user_nav.php"; ?>

<h1>Update Your Personal Information</h1>

<?php
if ($message != "") {
    echo "<div class='info-box'><strong>" . $message . "</strong></div>";
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <div class="form-row">ID:<br><input type="text" name="id" value="<?php echo $id; ?>" readonly></div>

    <div class="form-row">First Name:<br><input type="text" name="firstname" value="<?php echo $firstname; ?>"><br>
    <span class="error"> * <?php echo $firstnameErr; ?> </span></div>

    <div class="form-row">Last Name:<br><input type="text" name="lastname" value="<?php echo $lastname; ?>"><br>
    <span class="error"> * <?php echo $lastnameErr; ?> </span></div>

    <div class="form-row">Phone:<br><input type="text" name="phone" value="<?php echo $phone; ?>"><br>
    <span class="error"> * <?php echo $phoneErr; ?> </span></div>

    <div class="form-row">Email:<br><input type="text" name="email" value="<?php echo $email; ?>"><br>
    <span class="error"> * <?php echo $emailErr; ?> </span></div>

    <div class="form-row">Gender:
    <span class="error"> * <?php echo $genderErr; ?> </span><br>
    <input type="radio" name="gender" value="Female" <?php if ($gender=="Female") echo "checked"; ?>> Female
    <input type="radio" name="gender" value="Male" <?php if ($gender=="Male") echo "checked"; ?>> Male
    <input type="radio" name="gender" value="Other" <?php if ($gender=="Other") echo "checked"; ?>> Other
    </div>

    <div class="form-row">The total number of IT credits you have earned:
    <span class="error"> * <?php echo $levelErr; ?> </span>
    <select name="level">
        <option>---</option>
        <option value="Freshmen" <?php if ($level=="Freshmen") echo "selected"; ?>> Less than 30 hours </option>
        <option value="Sophomore" <?php if ($level=="Sophomore") echo "selected"; ?>> More than 30 but less than 60 hours </option>
        <option value="Junior" <?php if ($level=="Junior") echo "selected"; ?>> More than 60 but less than 90 hours </option>
        <option value="Senior" <?php if ($level=="Senior") echo "selected"; ?>> More than 90 hours </option>
    </select>
    </div>

    <div class="form-row">Old Password:<br><input type="password" name="oldpw" maxlength="15">
    <span class="error"> * <?php echo $typedoldpwErr; ?> </span></div>

    <div class="form-row">New Password:<br><input type="password" name="newpw" maxlength="15">
    <span class="error"> * <?php echo $newpwErr; ?> </span></div>

    <div class="form-row">Confirm New Password:<br><input type="password" name="confirmpw" maxlength="15">
    <span class="error"> * <?php echo $confirmpwErr; ?> </span></div>

    <input type="submit" value="Update Profile">
</form>
</div>
</div>

</body>
</html>
