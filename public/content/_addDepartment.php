<?php
// Handle Postback
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $school    = test_input($_POST["ddlSchool"]);
  $name      = test_input($_POST["txtName"]);

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

  $insert = $conn->prepare("INSERT INTO tblDepartment(Name, SchoolId) VALUES(:name, :id)");
  $insert->execute(array(
    "name" => $name,
    "id" => $school
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
        <th>School</th>
        <th>Department Name</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <select name='ddlSchool'>
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

              // Create department drop down
              $sqlGetDept = 'SELECT * FROM tblSchool';
              foreach ($conn->query($sqlGetDept) as $row) {
                echo "<option value='" . $row['SchoolId'] . "'>";
                echo "College of " . $row['Name'];
                echo "</option>";
              }

              $conn = null;
            ?>
          </select>
        </td>
        <td><input type='text' maxlength='32' name='txtName'></td>
      </tr>
      <tr>
        <td colspan='2'><input type='submit' text='Submit'></td>
      </tr>
    </tbody>
  </table>
</form>
