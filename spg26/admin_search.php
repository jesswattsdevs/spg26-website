<?php
session_start();
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] != 0) {
    header("Location:index.php");
    exit();
}

include "connection.php";
include "lib01.php";

$search_type = "all";
$search_term = "";
$result = false;
$message = "";
$allowedColumns = array(
    "id" => "id",
    "firstname" => "firstname",
    "lastname" => "lastname",
    "email" => "email",
    "phone" => "phone",
    "level" => "level"
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_type = $_POST["search_type"] ?? "all";
    $search_term = test_input($_POST["search_term"] ?? "");

    if ($search_type == "all" || $search_term == "all" || $search_term == "*") {
        $sqs = "SELECT * FROM users ORDER BY firstname ASC";
    } else {
        $column = isset($allowedColumns[$search_type]) ? $allowedColumns[$search_type] : "firstname";
        $safeSearch = mysqli_real_escape_string($dbc, $search_term);
        $sqs = "SELECT * FROM users WHERE $column LIKE '%$safeSearch%' ORDER BY firstname ASC";
    }

    $result = mysqli_query($dbc, $sqs);
    if ($result && mysqli_num_rows($result) == 0) {
        $message = "No users matched your search.";
    }
}
?>
<html>
<head>
    <title>Admin Search</title>
    <?php include "site_style.php"; ?>
</head>
<body>
<div class="page-shell">
<div class="card">
<?php include "admin_nav.php"; ?>

<h1>Search Users</h1>
<p class="note-text">This page is available only after an admin login.</p>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<div class="form-row">
Search Type:<br>
<select id="search_type" name="search_type">
    <option value="all" <?php if ($search_type == "all") echo "selected"; ?>>List all users</option>
    <option value="id" <?php if ($search_type == "id") echo "selected"; ?>>ID</option>
    <option value="firstname" <?php if ($search_type == "firstname") echo "selected"; ?>>Firstname</option>
    <option value="lastname" <?php if ($search_type == "lastname") echo "selected"; ?>>Lastname</option>
    <option value="email" <?php if ($search_type == "email") echo "selected"; ?>>Email</option>
    <option value="phone" <?php if ($search_type == "phone") echo "selected"; ?>>Phone</option>
    <option value="level" <?php if ($search_type == "level") echo "selected"; ?>>Credit Hour Level</option>
</select>
</div>
<div class="form-row">
Search Term:<br>
<input type="text" id="search_term" name="search_term" value="<?php echo htmlspecialchars($search_term); ?>">
</div>

<input type="submit" value="Search">
</form>

<?php if ($message != "") { ?>
<div class="empty-state"><?php echo htmlspecialchars($message); ?></div>
<?php } ?>

<?php
if ($result) {
    echo "<table class='data-table'>";
    echo "<tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Level</th>
    <th>PHP</th>
    <th>SQL</th>
    <th>HTML/CSS</th>
    <th>PW</th>
    </tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>".htmlspecialchars($row["id"])."</td>";
        echo "<td>".htmlspecialchars($row["firstname"])."</td>";
        echo "<td>".htmlspecialchars($row["lastname"])."</td>";
        echo "<td>".htmlspecialchars($row["phone"])."</td>";
        echo "<td>".htmlspecialchars($row["email"])."</td>";
        echo "<td>".htmlspecialchars($row["level"])."</td>";
        echo "<td>".htmlspecialchars($row["php"])."</td>";
        echo "<td>".htmlspecialchars($row["sql"])."</td>";
        echo "<td>".htmlspecialchars($row["htmlcss"])."</td>";
        echo "<td>".htmlspecialchars($row["pw"])."</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
</div>
</div>
</body>
</html>
