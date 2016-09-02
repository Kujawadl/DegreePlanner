<?php
// Gets everything in the uri after the base path, not including query strings
function getCurrentUri() {
  $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
  $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
  if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
  $uri = '/' . trim($uri, '/');
  return $uri;
}

// Parse the routes from the uri using / as delimiter
$base_url = getCurrentUri();
$tmp = $routes = array();
$tmp = explode('/', $base_url);
foreach ($tmp as $route) {
  if (trim($route) != '') {
    array_push($routes, $route);
  }
}
if (count($routes) == 0) {array_push($routes, "home");}
switch(strtolower($routes[0])) {
  case "home":
  case "index":
  case "index.htm":
  case "index.html":
  case "index.php":
    $content = $_SERVER['DOCUMENT_ROOT']."/content/_home.php";
    break;
  case "schools":
    if (isset($routes[1])) {
      $SchoolId = $routes[1];
    }
    $content = $_SERVER['DOCUMENT_ROOT']."/content/_schools.php";
    break;
  case "addschool":
    $content = $_SERVER['DOCUMENT_ROOT']."/content/_addSchool.php";
    break;
  case "departments":
    $content = $_SERVER['DOCUMENT_ROOT']."/content/_departments.php";
    break;
  case "adddepartment":
    $content = $_SERVER['DOCUMENT_ROOT']."/content/_addDepartment.php";
    break;
  //case "degrees":
  //  $content = $_SERVER['DOCUMENT_ROOT']."/content/_degrees.php";
  //  break;
  //case "adddegree":
  //  $content = $_SERVER['DOCUMENT_ROOT']."/content/_addDegree.php";
  //  break;
  case "courses":
    if (isset($routes[1])) {
        $CourseId = $routes[1];
    }
    $content = $_SERVER['DOCUMENT_ROOT']."/content/_courses.php";
    break;
  case "addcourse":
    $content = $_SERVER['DOCUMENT_ROOT']."/content/_addCourse.php";
    break;
  default:
    $content = $_SERVER['DOCUMENT_ROOT']."/errors/404.php";
    break;
}

include ($_SERVER['DOCUMENT_ROOT']."/masters/master.php");
?>
