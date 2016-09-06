<?php
include_once('models/school.php');
include_once('models/department.php');
//include_once('models/degree.php');
include_once('models/course.php');

class URL {

  public $Valid = false;
  public $ViewType;
  public $School;
  public $Department;
  public $ItemType;
  public $Item;

  public function __construct() {
    // Parse the routes from the uri using / as delimiter
    $base_url = URL::getCurrentUri();
    $routes = array();
    foreach (explode('/', $base_url) as $route) {
      if (trim($route) != '') {
        array_push($routes, $route);
      }
    }

    // No routes, go home
    if (count($routes) == 0) {
      $this->Valid = true;
    } else {
      if (count($routes) > 0) {
        $this->ViewType   = $routes[0];
      }
      if (count($routes) > 1) {
        $this->School     = $routes[1];
      }
      if (count($routes) > 2) {
        $this->Department = $routes[2];
      }
      if (count($routes) > 3) {
        $this->ItemType   = $routes[3];
      }
      if (count($routes) > 4) {
        $this->Item       = $routes[4];
      }

      $this->validate();
    }
  }

  private function validate() {
    // If ViewType is invalid, default to list view
    if (strtolower($this->ViewType) != 'list'
        && strtolower($this->ViewType) != 'edit') {
      $this->ViewType = 'list';
    }

    // Validate the parameters
    try {
      // Search for school
      if (isset($this->School)) {
        $this->School = School::Search($this->School)[0];
      }

      // Search for department
      if (isset($this->Department)) {
        $this->Department = Department::Search($this->Department)[0];
      }

      // Check item type is degree or course
      if (isset($this->ItemType) &&
          strtolower($this->ItemType) != 'degree' &&
          strtolower($this->ItemType) != 'course') {
        throw new Exception();
      }

      // Search for degree or course
      if (isset($this->Item)) {
        switch (strtolower($this->ItemType)) {
          case 'degree':
            $this->Item = Degree::Search($this->Item);
            break;
          case 'course':
            $this->Item = Course::Search($this->Item);
            break;
        }
      }

      // If we've made it this far, all is good
      $this->Valid = true;
    } catch (Exception $ex) {
      highlight_string("<?php\n\$data =\n" . var_export($ex, true) . ";\n?>");
      $this->Valid = false;
      $this->ViewType = null;
      $this->School = null;
      $this->Department = null;
      $this->ItemType = null;
      $this->Item = null;
    }
  }

  // Gets everything in the uri after the base path, not including query strings
  private static function getCurrentUri() {
    $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
    $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
    if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
    $uri = '/' . trim($uri, '/');
    return $uri;
  }
}
?>
