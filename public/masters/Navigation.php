<div id="header">
  <div id="nameplate">
    <h1>Degree Planner</h1>
  </div>

  <div id="navigation">
    <ul>
      <li><a href='/home'>Home</a></li>
      <li class="dropdown">
        <a href='/schools'>Schools</a>
        <div class="dropdown-content">
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

          foreach ($conn->query("SELECT * FROM tblSchool ORDER BY Name") as $row) {
            echo "<a href='/schools/" . $row['SchoolId'] . "'>College of " . $row['Name'] . "</a>";
          }

          $conn = null;
          ?>
          <a href="/addSchool">Add School</a>
        </div>
      </li>
      <li class="dropdown">
        <a href='/departments'>Departments</a>
        <div class="dropdown-content">
          <a href="/addDepartment">Add Department</a>
        </div>
      </li>
      <li class="dropdown">
        <a href='/degrees'>Degrees</a>
        <div class="dropdown-content">
          <a href="/addDegree">Add Degree Plan</a>
        </div>
      </li>
      <li class="dropdown">
        <a href='/courses'>Courses</a>
        <div class="dropdown-content">
          <a href="/addCourse">Add Course</a>
        </div>
      </li>
    </ul>
  </div>
</div>
