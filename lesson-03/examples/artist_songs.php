<?php

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

  // get artist name
  $artist_sql = 'SELECT * FROM artists WHERE id = :id';
  $songs_sql = "SELECT * FROM songs WHERE artist_id = :id";

  // assign the GET param to a variable
  $artist_id = $_GET['id'];

  // prepare the SQL statement
  $artist_sth = $dbh->prepare( $artist_sql );

  // fill the placeholders
  $artist_sth->bindParam( ':id', $artist_id, PDO::PARAM_INT );

  // execute the artist SQL
  $artist_sth->execute();

  // store the result
  $artist = $artist_sth->fetch();

  // close the cursor so we can execute the next statement
  $artist_sth->closeCursor();

  // get songs by artist
  $songs_sth = $dbh->prepare( $songs_sql );

  // fill the placeholders
  $songs_sth->bindParam( ':id', $artist_id, PDO::PARAM_INT );

  // execute the songs SQL
  $songs_sth->execute();

  // store the results
  $songs = $songs_sth->fetchAll();

  // close the connection
  $dbh = null;

?>

<!DOCTYPE html>
<html>
  <head>
    <link crossorigin='anonymous' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' integrity='sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7' rel='stylesheet'>
    <link crossorigin='anonymous' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css' integrity='sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O' rel='stylesheet'>
    <title>All Songs By <?= $artist['name'] ?></title>
  </head>
  <body>
    <div class='container'>
      <header>
        <h1 class="page-header">
          <?= $artist['name'] ?>
        </h1>
        <p>
          <small><a href="<?= $artist['bio_link'] ?>"><?= $artist['bio_link'] ?></a></small>
        </p>
      </header>

      <section>
        <table class="table">
          <thead>
            <tr>
              <td>Title</td>
              <td>Length</td>
            </tr>
          </thead>

          <tbody>
            <?php foreach ( $songs as $song ): ?>
              <tr>
                <td><a href="song.php?id=<?= $song['id'] ?>"><?= $song['title'] ?></a></td>
                <td><?= $song['length'] ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </section>
    </div>
  </body>
</html>