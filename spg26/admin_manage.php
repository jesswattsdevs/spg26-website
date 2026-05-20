<?php
session_start();
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] != 0) {
    header("Location:index.php");
    exit();
}
?>
<html>
<head>
    <title>Online Test - Admin Manage Users</title>
    <?php include "site_style.php"; ?>
</head>

<body>
<div class="page-shell">
<div class="card">
<h2>Hello, Welcome to Admin-Manage Users Page!</h2>

<?php
include "admin_nav.php";
include "connection.php";

echo "<div class='info-box'><a href='admin_export_users.php'>Export Users CSV</a></div>";

$sqs = "SELECT * FROM users ORDER BY firstname ASC";
$result = mysqli_query($dbc, $sqs);

echo "<table class='data-table'>";
echo "<tr>
<th>Edit</th>
<th>Delete</th>
<th>ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Phone</th>
<th>Email</th>
<th>Level</th>
<th>PHP Quiz</th>
<th>SQL Quiz</th>
<th>HTML/CSS Quiz</th>
<th>PW</th>
</tr>";

while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td><a href='admin_edit.php?id=".$row["id"]."'>edit</a></td>";
    echo "<td><a href='admin_delete.php?id=".$row["id"]."'>delete</a></td>";
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
?>
</div>
</div>

</body>
</html>
