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

if (isset($SchoolId)) {
  $school = $conn->prepare("SELECT * FROM tblSchool WHERE SchoolId = ".$SchoolId);
  $school->execute();
  $school = $school->fetch();

  if ($school['Name'] != '') {
    echo "<h2>College of ".$school['Name']."</h2>";
  } else {
    include($_SERVER['DOCUMENT_ROOT']."/errors/404.php");
  }
} else {
  echo "<ul>";
  foreach ($conn->query("SELECT * FROM tblSchool ORDER BY Name") as $row) {
    echo "<li>College of " . $row['Name'] . "</li>";
  }
  echo "</ul>";
}

$conn = null;
?>
