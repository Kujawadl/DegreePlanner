<?php
define("SERVERNAME", "mysql:host=localhost;dbname=degreeplanner");
define("USERNAME",   "root");
define("PASSWORD",   "root");

abstract class University {
  protected static $TableName;
  protected static $WritableColumns;
  protected static $SearchKeys;
  public  $ID;

  //abstract public function Get($ID);
  abstract public function Update();

  /**
   * Create
   *
   * Creates a new record.
   *
   * @param (array) (Properties) An array of key/value pairs, keys representing writable properties.
   *
   * @throws Exception if invalid columns are specified, nonnull properties are not specified, or if incorrect types are used.
   */
  static public function Create($Properties) {
    $keys   = array();
    foreach ($Properties as $key => $value) {
      if (in_array($key, static::$WritableColumns)) {
        array_push($keys, $key);
      } else {
        throw new Exception('Property '.$key.' does not exist or cannot be modified');
      }
    }

    $sql = 'INSERT INTO '.static::$TableName.'('.implode(',',$keys).') VALUES(:'.implode(',:',$keys).')';

    // Set up database connection
    $conn = new PDO(SERVERNAME, USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert new record
    $update = $conn->prepare($sql);
    $update->execute($Properties);

    // Get new record's course id
    $sql = 'SELECT * FROM '.$TableName;
    foreach ($Properties as $key => $value) {
      $sql += $key.' = :'.$key;
    }
    $search = $conn->prepare($sql);
    $search->execute($Properties);
    $result = $search->fetch();

    $itemID = $result['CourseId'];

    // Disconnect from database
    $conn = null;

    return new static($itemID);
  }

  /**
   * Search
   *
   * Searches the table by all columns defined in the SEARCHKEYS constant.
   *
   * @param (mixed) (searchTerm) The term to search for
   *
   * @return (array) An array of instances of the extending class.
   * @throws Exception if unable to connect to database.
   */
  static public function Search($searchTerm) {
    // Set up database connection
    $conn = new PDO(SERVERNAME, USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $search = $conn->prepare('SET @searchTerm = :searchTerm');
    $search->execute(array('searchTerm' => $searchTerm));
    $sql = 'SELECT * FROM '.static::$TableName.' WHERE `ID` = @searchTerm';
    foreach (static::$SearchKeys as $key) {
      $sql = $sql.' OR '.$key." LIKE @searchTerm";
    }
    $search = $conn->prepare($sql);
    $search->execute();

    // Create an array of objects from results
    $results = array();
    foreach ($search->fetchAll() as $result) {
      array_push($results, new static($result['ID']));
    }

    // Disconnect from database
    $conn = null;

    return $results;
  }

  /**
   * GetAll
   *
   * Gets all results from the tables
   *
   * @param (string) (orderBy) Column to sort by (default = 'Name')
   *
   * @return (array) An array of instances of the extending class.
   *
   * @throws Exception if unable to connect to database.
   */
  static public function GetAll($orderBy = 'Name') {
    $sql = 'SELECT * FROM :tbl ORDER BY :orderBy';

    // Set up database connection
    try {
      $conn = new PDO(SERVERNAME, USERNAME, PASSWORD);
    } catch (Exception $e) {
      throw new Exception("Unable to connect: " . $e->getMessage());
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $search = $conn->prepare($sql);
    $search->debugDumpParams();
    $search->execute(array(
      'tbl' => static::$TableName,
      'orderBy' => $orderBy
    ));

    // Create an array of objects from results
    $results = array();
    foreach ($search->fetchAll() as $result) {
      array_push($results, new static($result['ID']));
    }

    // Disconnect from database
    $conn = null;

    return $results;
  }
}
?>
