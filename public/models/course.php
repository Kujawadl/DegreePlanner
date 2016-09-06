<?php
include_once('models/university.php');

/**
 * Represents a single row of tblCourse, plus links to other tables.
 *
 * @property (int) (ID) Course ID
 * @property (int) (Department) Department ID
 * @property (int) (Number) Course number (e.g. 101)
 * @property (string) (Name) Course Name
 * @property (string) (Description) Detailed course description (may be empty)
 * @property (int) (Hours) Credit Hours
 * @property (bool) (Honors) If the course is an honors course
 * @property (bool) (Writing) If the course is writing enhanced
 * @property (bool) (Lab) If the course is a lab (typically accompanies another course)
 * @property (array) (Prerequisites) A list of courses that must be taken prior to this course
 * @property (array) (Corequisites) A list of courses that must be taken with this course
 */
class Course extends University {
  protected static $TableName = 'tblCourse';
  protected static $WritableColumns = array(
    'Num',
    'Title',
    'Description',
    'Hours',
    'Honors',
    'Writing',
    'Lab'
  );
  protected static $SearchKeys = array(
    'Title',
    'Num'
  );

  public $ID            = null;
  public $Department    = null;
  public $Num           = null;
  public $Title         = null;
  public $Description   = null;
  public $Hours         = null;
  public $Honors        = False;
  public $Writing       = False;
  public $Lab           = False;
  public $Prerequisites = array();
  public $Corequisites  = array();

  public function __construct($ID) {
    // Set up database connection
    $conn = new PDO(SERVERNAME, USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get course by id
    $search = $conn->prepare('SELECT * FROM '.static::$TableName.' WHERE ID = :ID');
    $search->execute(array('ID' => $ID));
    $course = $search->fetch();

    // Instantiate properties
    $this->ID              = (int)    $course['ID'];
    $this->Department      = (int)    $course['Department'];
    $this->Num             = (int)    $course['Num'];
    $this->Title           = (string) $course['Title'];
    $this->Description     = (string) (isset($course['Description']) ?
                                         $course['Description'] :
                                         '');
    $this->Hours           = (int)    $course['Hours'];
    $this->HonorsCredit    = (bool)   $course['Honors'];
    $this->WritingEnhanced = (bool)   $course['Writing'];
    $this->Lab             = (bool)   $course['Lab'];

    // Fill prereq and coreq lists
    /* TODO: Implement tblPrereq
    $search = $conn->prepare('SELECT * FROM tblPreReq WHERE Course = :ID');
    $search->execute(array('ID', $ID));
    foreach ($search->fetchAll() as $row) {
      if ($row['Type'] == 0) {
        array_push($this->Prerequisites, new Course($row['PreReqId']));
      } else {
        array_push($this->Corequisites, new Course($row['PreReqId']));
      }
    }
    */

    // Disconnect
    $course = null;
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
        Num        = :Num,
        Title      = :Title,
        Hours      = :Hours,
        Honors     = :Honors,
        Writing    = :Writing,
        Lab        = :Lab
      WHERE CourseId = " . $this->CourseId);
    $update->execute(array(
      "Num"        => $this->Num,
      "Title"      => $this->Title,
      "Hours"      => $this->Hours,
      "Honors"     => $this->Honors,
      "Writing"    => $this->Writing,
      "Lab"        => $this->Lab
    ));

    // Disconnect from database
    $update = null;
    $conn   = null;
  }
}
?>
