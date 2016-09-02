<?php $siteurl = "/site/";?>

<html>
  <head>
    <title>SFA Degree Planner<?php (isset($subtitle) ? " | " . $subtitle : ""); ?></title>
    <link rel="shortcut icon" href="https://www.google.com/s2/favicons?domain=www.sfasu.edu">
    <link rel="stylesheet" href="/css/site.css">
  </head>
  <body>
    <?php include 'Navigation.php'; ?>

    <?php if (isset($content)) {include($content);} else {echo "There's nothing here...";} ?>
  </body>
</html>
