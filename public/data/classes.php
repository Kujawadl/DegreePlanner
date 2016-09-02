<?php
define("_SERVERNAME", "mysql:host=localhost;dbname=scotchbox");
define("_USERNAME", "root");
define("_PASSWORD", "root");

class Course {
  public $CourseId        = -1;
  public $DepartmentId    = -1;
  public $CourseNumber    = -1;
  public $Name            = '';
  public $Hours           = -1;
  public $HonorsCredit    = False;
  public $WritingEnhanced = False;
  public $Lab             = False;
  public $Prerequisites   = array();
  public $Corequisites    = array();

  public function __construct($id) {
    // Set up database connection
    try {
      $conn = new PDO(_SERVERNAME, _USERNAME, _PASSWORD);
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get course by id
    $course = $conn->prepare("SELECT * FROM tblCourseInfo WHERE CourseId = ".$id);
    $course->execute();
    $course = $course->fetch();

    // Instantiate properties
    $this->CourseId        = $course['CourseId'];
    $this->DepartmentId    = $course['DepartmentId'];
    $this->CourseNumber    = $course['CourseNumber'];
    $this->Name            = $course['Name'];
    $this->Hours           = $course['Hours'];
    $this->HonorsCredit    = (bool)$course['HonorsCredit'];
    $this->WritingEnhanced = (bool)$course['WritingEnhanced'];
    $this->Lab             = (bool)$course['Lab'];

    // Fill prereq and coreq lists
    foreach ($conn->query("SELECT * FROM tblPreReq WHERE CourseId = ".$id) as $row) {
      if ($row['Type'] == 0) {
        array_push($this->Prerequisites, new Course($row['PreReqId']));
      } else {
        array_push($this->Corequisites, new Course($row['PreReqId']));
      }
    }

    // Disconnect
    $conn = null;
  }

  public function update($dept, $number, $name, $hours, $honors, $writing, $lab) {
    // Set up database connection
    try {
      $conn = new PDO(_SERVERNAME, _USERNAME, _PASSWORD);
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $update = $conn->prepare("UPDATE tblCourseInfo SET DepartmentId = :newDept, CourseNumber = :newNum, Name = :newName, Hours = :newHours, HonorsCredit = :newHonors, WritingEnhanced = :newWriting, Lab = :newLab WHERE CourseId = " . $this->CourseId);
    $update->execute(array(
      "newDept" => $dept,
      "newNum" => $number,
      "newName" => $name,
      "newHours" => $hours,
      "newHonors" => $honors,
      "newWriting" => $writing,
      "newLab" => $lab
    ));

    $this->DepartmentId    = $dept;
    $this->CourseNumber    = $number;
    $this->Name            = $name;
    $this->Hours           = $hours;
    $this->HonorsCredit    = $honors;
    $this->WritingEnhanced = $writing;
    $this->Lab             = $lab;

    $conn = null;
  }

  static public function create($dept, $number, $name, $hours, $honors, $writing, $lab) {
    // Set up database connection
    try {
      $conn = new PDO(_SERVERNAME, _USERNAME, _PASSWORD);
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert new record
    $update = $conn->prepare("INSERT INTO tblCourseInfo(DepartmentId, CourseNumber, Name, Hours, HonorsCredit, WritingEnhanced, Lab) Values(:newDept, :newNum, :newName, :newHours, :newHonors, :newWriting, :newLab)");
    $update->execute(array(
      "newDept" => $dept,
      "newNum" => $number,
      "newName" => $name,
      "newHours" => $hours,
      "newHonors" => $honors,
      "newWriting" => $writing,
      "newLab" => $lab
    ));

    // Get new record's course id
    $course = $conn->prepare("SELECT * FROM tblCourseInfo WHERE DepartmentId = :Dept AND CourseNumber = :Num AND Name = :Name AND Hours = :Hours AND HonorsCredit = :Honors AND WritingEnhanced = :Writing AND Lab = :Lab");
    $course->execute(array(
      "Dept" => $dept,
      "Num" => $number,
      "Name" => $name,
      "Hours" => $hours,
      "Honors" => $honors,
      "Writing" => $writing,
      "Lab" => $lab
    ));
    $course = $course->fetch();

    $NewCourseId = $course['CourseId'];

    $conn = null;

    return new Course($NewCourseId);
  }
}

class Department {
  public $DepartmentId = -1;
  public $Name         = '';
  public $SchoolId     = -1;
  public $Courses      = array();

  public function __construct($id) {
    // Set up database connection
    try {
      $conn = new PDO(_SERVERNAME, _USERNAME, _PASSWORD);
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get department by id
    $dept = $conn->prepare("SELECT * FROM tblDepartment WHERE DepartmentId = ".$id);
    $dept->execute();
    $dept = $dept->fetch();

    // Instantiate properties
    $this->DepartmentId = $dept['DepartmentId'];
    $this->Name = "Department of ".$dept['Name'];
    $this->SchoolId = $dept['SchoolId'];

    // Fill courses list
    foreach ($conn->query("SELECT * FROM tblCourseInfo WHERE DepartmentId = ".$id." ORDER BY CourseNumber") as $row) {
      array_push($this->Courses, new Course($row['CourseId']));
    }

    // Disconnect
    $conn = null;
  }

  public function update($name, $schoolid) {
    // Set up database connection
    try {
      $conn = new PDO(_SERVERNAME, _USERNAME, _PASSWORD);
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $update = $conn.prepare("UPDATE tblDepartment SET Name = :newName, SchoolId = :newSchoolId WHERE DepartmentId = " . $this->DepartmentId);
    $conn->execute(array(
      "newName" => $name,
      "newSchoolId" => $schoolid
    ));

    $this->Name     = $name;
    $this->SchoolId = $schoolid;

    // Disconnect
    $conn = null;
  }

  static public function create($name, $schoolid) {
    // Set up database connection
    try {
      $conn = new PDO(_SERVERNAME, _USERNAME, _PASSWORD);
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert new record
    $update = $conn.prepare("INSERT INTO tblDepartment(Name, SchoolId) VALUES(:newName, :newSchoolId)");
    $update->execute(array(
      "newName" => $name,
      "newSchoolId" => $schoolid
    ));

    // Get new record's course id
    $dept = $conn.prepare("SELECT * FROM tblDepartment WHERE Name = :name AND SchoolId = :schoolid");
    $dept->execute(array(
      "name" => $name,
      "schoolid" => $schoolid
    ));
    $dept = $course->fetch();

    $NewDeptId = $dept['DepartmentId'];

    // Disconnect
    $conn = null;

    // Return Department object
    return new Department($NewDeptId);
  }
}

class School {
  public $SchoolId    = -1;
  public $Name        = '';
  public $Departments = array();

  public function __construct($id) {
    // Set up database connection
    try {
      $conn = new PDO(_SERVERNAME, _USERNAME, _PASSWORD);
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get department by id
    $dept = $conn->prepare("SELECT * FROM tblSchool WHERE SchoolId = ".$id);
    $dept->execute();
    $dept = $dept->fetch();

    // Instantiate properties
    $this->SchoolId = $dept['SchoolId'];
    $this->Name = "College of ".$dept['Name'];

    // Fill department list
    foreach ($conn->query("SELECT * FROM tblDepartment WHERE SchoolId = ".$id." ORDER BY Name") as $row) {
      array_push($this->Departments, new Department($row['DepartmentId']));
    }

    // Disconnect
    $conn = null;
  }

  static public function getAll() {
    // Set up database connection
    try {
      $conn = new PDO(_SERVERNAME, _USERNAME, _PASSWORD);
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get all schools
    $arr = array();
    foreach ($conn->query("SELECT * FROM tblSchool ORDER BY Name") as $row) {
      array_push($arr, new School($row['SchoolId']));
    }

    // Disconnect
    $conn = null;

    return $arr;
  }
}
?>
