<?php
// Set up database connection
$servername = "mysql:host=localhost;dbname=scotchbox";
$username = "root";
$password = "root";

try {
  $conn = new PDO($servername, $username, $password);
} catch (Exception $e) {
  die("Unable to connect: " . $e->getMessage());
}
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "<ul>";
foreach ($conn->query("SELECT * FROM tblDepartment ORDER BY Name") as $row) {
  echo "<li>Department of " . $row['Name'] . "</li>";
}
echo "</ul>";

$conn = null;
?>
