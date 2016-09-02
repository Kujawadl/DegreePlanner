<?php
include($_SERVER['DOCUMENT_ROOT']."/data/classes.php");

// Handle Postback
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $Course       = new Course($CourseId);
  $dept         = $Course->DepartmentId;
  $num          = test_input($_POST["txtCourseNum"]);
  $name         = test_input($_POST["txtCourseName"]);
  $hours        = test_input($_POST["txtHours"]);
  $honors       = (isset($_POST["chkHonors"]) ? 1 : 0);
  $writing      = (isset($_POST["chkHonors"]) ? 1 : 0);
  $lab          = (isset($_POST["chkLab"]) ? 1 : 0);

  $Course->update($dept, $num, $name, $hours, $honors, $writing, $lab);

  echo "<script>window.location.replace('/courses')</script>";
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($CourseId)) {
  $Course       = new Course($CourseId);
  $Department   = new Department($Course->DepartmentId);
  $Department   = $Department->Name;
  $CourseNumber = $Course->CourseNumber;
  $CourseName   = $Course->Name;
  $Hours        = $Course->Hours;
  $Honors       = $Course->HonorsCredit;
  $Writing      = $Course->WritingEnhanced;
  $Lab          = $Course->Lab;
?>
  <h1>Update Course Details</h1>

  <form method='post' action='<?php $_SERVER['DOCUMENT_ROOT']; ?>/courses/<?php echo $CourseId;?>'>
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
          <td><?php echo $Department;?></td>
          <td><input type='number' maxlength='4' name='txtCourseNum' value="<?php echo $CourseNumber;?>"></td>
          <td><input type='text' maxlength='64' name='txtCourseName' value="<?php echo $CourseName;?>"></td>
          <td><input type='number' max='6' name='txtHours' value="<?php echo $Hours;?>"></td>
          <td><input type='checkbox' name='chkHonors' "<?php echo ($Honors ? "checked" : "");?>"></td>
          <td><input type='checkbox' name='chkWriting' "<?php echo ($Writing ? "checked" : "");?>"></td>
          <td><input type='checkbox' name='chkLab' "<?php echo ($Lab ? "checked" : "");?>"></td>
        </tr>
        <tr>
          <td colspan='7'><input type='submit' value='Update'></td>
        </tr>
      </tbody>
    </table>
  </form>
<?php
} else {
  echo "<h1>Course List</h1>";

  foreach (School::getAll() as $School) {
    echo "<h2>".$School->Name."</h2>";
    foreach ($School->Departments as $Department) {
      echo "<h3 style='margin-left:1em;'>".$Department->Name."</h3>";
      echo "<ul style='margin-left:1em;'>";
      foreach ($Department->Courses as $Course) {
        echo "<li><a href='/courses/".$Course->CourseId."'>".$Course->CourseNumber.": ".$Course->Name."</a></li>";
      }
      echo "</ul>";
    }
  }
}
?>
