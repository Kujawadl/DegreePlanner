<?php
include_once('models/university.php');

/**
 * Represents a single row of tblDepartment, plus links to other tables.
 *
 * @property (int) (ID) School ID
 * @property (string) (Name) School Name
 * @property (string) (ShortName) School ShortName (e.g. STEM, LibArts)
 * @property (array) (Departments) An array of departments
 */
class School extends University {
  static protected $TableName = 'tblSchool';
  static protected $WritableColumns = array(
    'Title',
    'ShortName'
  );
  static protected $SearchKeys = array(
    'Title',
    'ShortName'
  );

  public $ID          = null;
  public $Title       = null;
  public $ShortName   = null;
  public $Departments = array();

  public function __construct($ID) {
    // Set up database connection
    $conn = new PDO(SERVERNAME, USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get course by id
    $search = $conn->prepare('SELECT * FROM '.static::$TableName.' WHERE `ID` = :ID');
    $search->execute(array('ID' => $ID));
    $school = $search->fetch();

    // Instantiate properties
    $this->ID        = (int)    $school['ID'];
    $this->Title     = (string) $school['Title'];
    $this->ShortName = (string) $school['ShortName'];

    // Fill prereq and coreq lists
    $search = $conn->prepare('SELECT * FROM tblDepartment WHERE School = :ID ORDER BY Title');
    $search->execute(array('ID' => $this->ID));
    foreach ($search->fetchAll() as $row) {
      array_push($this->Departments, new Department($row['ID']));
    }

    // Disconnect
    $school = null;
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
        Title     = :Title,
        ShortName = :ShortName
      WHERE ID = " . $this->ID);
    $update->execute(array(
      "Title"     => $this->Title,
      "ShortName" => $this->ShortName
    ));

    // Disconnect from database
    $update = null;
    $conn   = null;
  }
}
?>
