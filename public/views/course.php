<?php
include_once('models/course.php');

if ($Route->ViewType == 'list') {
  if (isset(ROUTE->Item)) {
    // TODO: Implement single item view
    echo '<h1>Course Details</h1>';
    echo "There's nothing here...";
  } else {
    echo '<h1>Course Listing</h1>';
    echo '<ul>';
    foreach (Course::GetAll() as $Course) {
      echo '<li>'.$Course->Name.'</li>';
    }
    echo '</ul>';
  }
} else {
  // TODO: Implement edit view
  echo '<h1>Edit Course Details</h1>';
  echo "There's nothing here...";
}
?>
