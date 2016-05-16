<?php

  // list all the directories in the project
  $Directory = new RecursiveDirectoryIterator('./');
  $Iterator = new RecursiveIteratorIterator($Directory);
  $Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

?>

<!DOCTYPE HTML>
<html lang="en">

  <head>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <title>Introduction to Web Programming</title>
  </head>

  <body>
    <div class="container">

      <header>
        <h1 class="page-header">Introduction to Web Programming</h1>
      </header>

      <section>
        <ul>
          <?php foreach ($Regex as $name => $object): ?>
            <li><a href="<?= $name ?>" target="_blank"><?= $name ?></a></li>
          <?php endforeach ?>
        </ul>
      </section>
      
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </body>
  
</html>