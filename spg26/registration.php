<?php
session_start();
include "lib01.php";

$firstname = $lastname = $password1 = $password2 = "";
$phone = "111-222-1234";
$email = $gender = $level = "";
$firstnameErr=$lastnameErr=$passwordErr=$emailErr=$genderErr=$phoneErr=$levelErr="";
$flag = 0; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get information from the form
    $firstname=test_input($_POST["firstname"]);
    $lastname=test_input($_POST["lastname"]);
    $phone=test_input($_POST["phone"]);
    $password1=test_input($_POST["password1"]);
    $password2=test_input($_POST["password2"]);
    $email=test_input($_POST["email"]);
    $gender=$_POST["gender"];
    $level=$_POST["level"];

    // Validation Logic
    if (empty($firstname)) { $firstnameErr = "First name is required!"; $flag = 1; }
    if (empty($lastname)) { $lastnameErr = "Last name is required!"; $flag = 1; }
    if (empty($email)) { $emailErr = "Email is required!"; $flag = 1; }
    if (empty($password1) || $password1 != $password2) { $passwordErr = "Passwords must match!"; $flag = 1; }
    if (empty($gender)) { $genderErr = "Gender is required."; $flag = 1; }
    if ($level == "" || $level == "---") { $levelErr = "IT credits required!"; $flag = 1; }

    if ($flag == 0) {
        include "connection.php";
        // Checking existing email/phone
        $sqs = "SELECT * FROM users WHERE email='$email' OR phone='$phone'";
        $qresult = mysqli_query($dbc, $sqs);
        
        if (mysqli_num_rows($qresult) > 0) {
            $dbError = "Email or Phone Number already exists!";
        } else {
            // Hash password for Phase 2 security
            $hashed_pw = password_hash($password1, PASSWORD_DEFAULT);
            
            // 2. UPDATED INSERT STATEMENT match your database structure exactly
            // Sets default 0 for scores and empty string for pic
            $sql = "INSERT INTO users (firstname, lastname, phone, email, gender, level, pw, user_type, php, `sql`, htmlcss, pic, resume) 
                    VALUES ('$firstname', '$lastname', '$phone', '$email', '$gender', '$level', '$hashed_pw', 1, 0, 0, 0, '', '')";
            
            if (mysqli_query($dbc, $sql)) {
                mysqli_close($dbc);
                header("Location: registrationsuccess.php");
                exit();
            } else {
                $dbError = "Database Error: " . mysqli_error($dbc);
            }
        }
    }
}
?>
<html>
<head>
    <title> Registration </title>
    <?php include "site_style.php"; ?>
</head>
<body>
    <div class="page-shell">
    <div class="card">
    <h2>Registration Form</h2>
    <p class="note-text">Create a general user account to take quizzes, upload a profile picture, and upload a resume.</p>

    <?php if(isset($dbError)) echo "<div class='info-box error'>".htmlspecialchars($dbError)."</div>"; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-row">
        First Name:
        <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>">
        <div class="error"><?php echo $firstnameErr; ?></div>
        </div>

        <div class="form-row">
        Last Name:
        <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>">
        <div class="error"><?php echo $lastnameErr; ?></div>
        </div>

        <div class="form-row">
        Phone Number:
        <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
        <div class="error"><?php echo $phoneErr; ?></div>
        </div>

        <div class="form-row">
        Email:
        <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <div class="error"><?php echo $emailErr; ?></div>
        </div>

        <div class="form-row">
        Password:
        <input type="password" name="password1" maxlength="15">
        <div class="error"><?php echo $passwordErr; ?></div>
        </div>

        <div class="form-row">
        Confirm Password:
        <input type="password" name="password2" maxlength="15">
        </div>

        <div class="form-row">
        Gender:
        <div class="error"><?php echo $genderErr; ?></div>
        <label><input type="radio" name="gender" value="Female" <?php if($gender=="Female") echo "checked";?>> Female</label>
        <label><input type="radio" name="gender" value="Male" <?php if($gender=="Male") echo "checked";?>> Male</label>
        <label><input type="radio" name="gender" value="Other" <?php if($gender=="Other") echo "checked";?>> Prefer not to say</label>
        </div>

        <div class="form-row">
        IT Credits Earned:
        <div class="error"><?php echo $levelErr; ?></div>
        <select name="level">
            <option> --- </option>
            <option value="Freshman" <?php if($level=="Freshman") echo "selected";?>>Less than 30 hours</option>
            <option value="Sophomore" <?php if($level=="Sophomore") echo "selected";?>>30 - 60 hours</option>
            <option value="Junior" <?php if($level=="Junior") echo "selected";?>>60 - 90 hours</option>
            <option value="Senior" <?php if($level=="Senior") echo "selected";?>>More than 90 hours</option>
        </select>
        </div>

        <input type="submit" value="Register">
        <div class="inline-links">
            <a href="index.php">Back to Login</a>
        </div>
    </form>
    </div>
    </div>
</body>
</html>
