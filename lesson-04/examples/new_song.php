<?php

  // start our session
  session_start();

  // get our connection script
  if ( preg_match('/Heroku|georgian\.shaunmckinnon\.ca/i', $_SERVER['HTTP_HOST']) ) {
    // remote server
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $host = $url["host"];
    $dbname = substr($url["path"], 1);
    $username = $url["user"];
    $password = $url["pass"];
  } else { // localhost
    $host = 'localhost';
    $dbname = 'comp-1006-lesson-examples';
    $username = 'root';
    $password = 'root';
  }

  $dbh = new PDO( "mysql:host={$host};dbname={$dbname}", $username, $password );
  $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

  // build the SQL statment with placeholders
  $sql = 'SELECT id, name FROM artists';

  $result = $dbh->query( $sql );
  $row_count = $result->rowCount();

?>

<!DOCTYPE html>
<html>
  <head>
    <link crossorigin='anonymous' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' integrity='sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7' rel='stylesheet'>
    <link crossorigin='anonymous' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css' integrity='sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="http://parsleyjs.org/src/parsley.css">
    <title>Add New Song</title>
  </head>
  <body>

    <?php if ( isset($_SESSION['success']) && !empty ($_SESSION['success']) ): ?>
      <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
    <?php elseif ( isset($_SESSION['fail']) && !empty ($_SESSION['fail']) ): ?>
      <div class="alert alert-danger"><?= $_SESSION['fail'] ?></div>
    <?php endif ?>
    <?php session_unset() // unset the session variables ?>
    
    <div class='container'>
      <div class='row'>
        <div class='col-xs-12'>
          <header>
            <h1 class='page-header'>Add New Song</h1>
          </header>
        </div>
        <div class='col-xs-12'>
          <section>
            <?php if ($row_count > 0 ): ?>
              <form action='add_song.php' method='post' data-parsley-validate="">
                <fieldset>
                  <legend>Song Information</legend>
                  <div class='form-group'>
                    <label for='artist'>
                      Artist
                    </label>
                    <select class='form-control' id='artist' name='artist' type='text' required="">
                      <option value="">...select an artist...</option>
                      <?php foreach ( $result as list( $id, $name ) ): ?>
                        <option value="<?= $id ?>"><?= $name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class='form-group'>
                    <label for='title'>
                      Song Title
                    </label>
                    <input class='form-control' id='title' name='title' placeholder="We're Going to Be Friends" required type='text'>
                  </div>
                  <div class='form-group'>
                    <div class='form-inline'>
                      <div class='input-group'>
                        <label class='input-group-addon'>hours</label>
                        <input class='form-control' id='hours' max='59' min='0' name='length[hours]' type='number'>
                      </div>
                      <div class='input-group'>
                        <label class='input-group-addon'>minutes</label>
                        <input class='form-control' id='minutes' max='59' min='0' name='length[minutes]' type='number'>
                      </div>
                      <div class='input-group'>
                        <label class='input-group-addon'>seconds</label>
                        <input class='form-control' id='seconds' max='59' min='0' name='length[seconds]' type='number'>
                      </div>
                    </div>
                  </div>
                  
                  <div class='form-group'>
                    <button class='btn btn-default'>
                      <i class='fa fa-plus'></i>
                      Add Song
                    </button>
                  </div>
                </fieldset>
              </form>
            <?php else: ?>
              <div class="alert alert-warning">
                You must add an artist first.
              </div>
            <?php endif ?>
          </section>
        </div>
        <div class='col-xs-12'>
          <footer></footer>
        </div>
      </div>
    </div>
    <script crossorigin='anonymous' integrity='sha256-laXWtGydpwqJ8JA+X9x2miwmaiKhn8tVmOVEigRNtP4=' src='https://code.jquery.com/jquery-2.2.3.js'></script>
    <script crossorigin='anonymous' integrity='sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS' src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
    <script type="text/javascript" src="http://parsleyjs.org/dist/parsley.min.js"></script>
  </body>
</html>
