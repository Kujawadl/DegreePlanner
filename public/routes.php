<?php
set_include_path(get_include_path() . '.');

include_once('models/url.php');

$URL = new URL();

if ($URL->Valid) {
  if (isset($URL->Item)) {
    // TODO: Degree or course information
  } elseif (isset($URL->ItemType)) {
    // TODO: Degress or courses list
  } elseif (isset($URL->Department)) {
    // TODO: Degrees and courses list
  } elseif (isset($URL->School)) {
    // TODO: Departments list
  } elseif (isset($URL->ViewType)) {
    // TODO: School list
  } else {
    // TODO: Home
  }
} else {
  $content = 'errors/404.php';
}

include ('masters/master.php');
?>
