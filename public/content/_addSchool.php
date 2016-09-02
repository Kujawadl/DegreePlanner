<?php
// Handle Postback
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

  $name    = test_input($_POST["txtName"]);

  $insert = $conn->prepare("INSERT INTO tblSchool(name) VALUES(:name)");
  $insert->execute(array(
    "name" => $name
  ));

  $conn = null;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
  <table>
    <thead>
      <tr>
        <th>School Name</th>
      </tr>
    </thead>
    <tbody>
        <td><input type='text' maxlength='32' name='txtName'></td>
      </tr>
      <tr>
        <td colspan='6'><input type='submit' text='Submit'></td>
      </tr>
    </tbody>
  </table>
</form>
