<?php

switch (strtolower($URL->ViewType)) {
  case 'add':

    break;

  case 'detail':

    break;

  case 'edit':

    break;

  case 'list':
    echo '<h1>Department of '.$URL->Department->Title.'</h1>';

    if (strtolower($URL->ItemType) != 'course') {
      echo "<h2>Degree Programs:</h2>";
      echo "<ul>";
      echo "</ul>";
    }

    if (strtolower($URL->ItemType) != 'degree') {
      echo "<h2>Course List:</h2>";
      echo "<ul>";
      foreach ($URL->Department->Courses as $Course) {
        // Dept. code and course number
        $Info = '<b>'.$URL->Department->Code . ' ' . $Course->Num;
        // If lab, append 'L' to course number
        if ($Course->Lab) {$Info = $Info . 'L';}
        // Append credit hour information
        $Info = $Info . ' ('. $Course->Hours . ' hr)';
        // Append course title
        $Info = $Info . ':</b> ' . $Course->Title . '<br/>';
        // Append course description
        $Info = $Info . '<i>' . $Course->Description . '</i>';

        echo "<li>".$Info."</li>";
      }
      echo "</ul>";
    }
    break;
}

$conn = null;
?>
