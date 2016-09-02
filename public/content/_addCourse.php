<?php
include($_SERVER['DOCUMENT_ROOT']."/data/classes.php");

// Handle Postback
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $dept    = test_input($_POST["ddlDepartment"]);
  $num     = test_input($_POST["txtCourseNum"]);
  $name    = test_input($_POST["txtName"]);
  $hours   = test_input($_POST["txtHours"]);
  $honors  = (isset($_POST["chkHonors"]) ? 1 : 0);
  $writing = (isset($_POST["chkHonors"]) ? 1 : 0);
  $lab     = (isset($_POST["chkLab"]) ? 1 : 0);

  Course::create($dept, $num, $name, $hours, $honors, $writing, $lab);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h1>Add Course</h1>

<form method='post' action='<?php $_SERVER['DOCUMENT_ROOT']?>/addCourse'>
  <table>
    <thead>
      <tr>
        <th>Department</th>
        <th>Course Number</th>
        <th>Course Name</th>
        <th>Hours</th>
        <th>Honors</th>
        <th>Writing Enhanced</th>
        <th>Lab</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <select name='ddlDepartment'>
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
              $sqlGetDept = 'SELECT * FROM tblDepartment';
              foreach ($conn->query($sqlGetDept) as $row) {
                echo "<option value='" . $row['DepartmentId'] . "'>";
                echo $row['Name'];
                echo "</option>";
              }

              $conn = null;
            ?>
          </select>
        </td>
        <td><input type='number' maxlength='4' name='txtCourseNum'></td>
        <td><input type='text' maxlength='64' name='txtName'></td>
        <td><input type='number' max='6' name='txtHours' value='3'></td>
        <td><input type='checkbox' name='chkHonors'></td>
        <td><input type='checkbox' name='chkWriting'></td>
        <td><input type='checkbox' name='chkLab'></td>
      </tr>
      <tr>
        <td colspan='7'><input type='submit' text='Submit'></td>
      </tr>
    </tbody>
  </table>
</form>
