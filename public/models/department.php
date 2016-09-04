<?php
include_once('models/university.php');

/**
 * Represents a single row of tblDepartment, plus links to other tables.
 *
 * @property (int) (ID) Department ID
 * @property (int) (School) School ID
 * @property (string) (Name) Department Name
 * @property (string) (Code) Department shortcode (e.g. CSC)
 * @property (array) (Courses) An array of courses
 */
class Department extends University {
  protected static $TableName = 'tblDepartment';
  protected static $WritableColumns = array(
    'Title',
    'Code'
  );
  protected static $SearchKeys = array(
    'Title',
    'Code'
  );

  public $ID      = null;
  public $School  = null;
  public $Title   = null;
  public $Code    = null;
  public $Courses = array();

  public function __construct($ID) {
    // Set up database connection
    $conn = new PDO(SERVERNAME, USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get course by id
    $search = $conn->prepare('SELECT * FROM '.static::$TableName.' WHERE ID = :ID');
    $search->execute(array('ID' => $ID));
    $dept = $search->fetch();

    // Instantiate properties
    $this->ID     = (int)    $dept['ID'];
    $this->School = (int)    $dept['School'];
    $this->Title  = (string) $dept['Title'];
    $this->Code   = (string) $dept['Code'];

    // Fill prereq and coreq lists
    $search = $conn->prepare('SELECT * FROM tblCourse WHERE Department = :ID ORDER BY NUM');
    $search->execute(array('ID' => $this->ID));
    foreach ($search->fetchAll() as $row) {
      array_push($this->Courses, new Course($row['ID']));
    }

    // Disconnect
    $dept   = null;
    $search = null;
    $conn   = null;
  }

  /**
   * Update
   *
   * If no values are passed in, the current property values are used.
   * e.g.:
   *  $course->Update(array('Name' => 'Introduction to Moral Philosophy'));
   * - or -
   *  $course->Name = 'Introduction to Moral Philosophy';
   *  $course->Update();
   *
   * @param (array) (Properties) An array of key/value pairs, keys representing writable properties.
   *
   * @throws Exception if invalid columns are specified, nonnull properties are not specified, or if incorrect types are used.
   */
  public function Update($Properties = array()) {
    foreach ($Properties as $key => $value) {
      if (in_array($key, $WritableColumns)) {
        $this->$key = $value;
      } else {
        throw new Exception('Property '.$key.' does not exist or cannot be modified');
      }
    }

    // Set up database connection
    $conn = new PDO(SERVERNAME, USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $update = $conn->prepare("UPDATE tblCourseInfo SET
        Title  = :Title,
        Code   = :Hours
      WHERE ID = " . $this->ID);
    $update->execute(array(
      "Title"  => $this->Title,
      "Code"   => $this->Code
    ));

    // Disconnect from database
    $update = null;
    $conn   = null;
  }
}
?>
