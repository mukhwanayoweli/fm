<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule</title>
</head>
<body>
  <h1>Schedule</h1>
  
  <?php
  // Include the PHP file to connect to the database
  include("database/conn.php");
  
  // Create a connection
  //$conn = mysqli_connect($servername, $username, $password, $dbname);
  $con=mysqli_connect("localhost","root","","blog_admin_db");

  // for check connection
  if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  // Fetch the schedule data from the database
  $query = "SELECT * FROM schedule WHERE date >= CURDATE() ORDER BY date ASC";
  $result = mysqli_query($con, $query);
  
  if (mysqli_num_rows($result) > 0) {
    // Display the schedule table
    echo '<table>';
    echo '<tr><th>Date</th><th>Time</th><th>Presenter</th><th>Event</th></tr>';
    
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<tr>';
      echo '<td>' . $row['date'] . '</td>';
      echo '<td>' . $row['time'] . '</td>';
      echo '<td>' . $row['presenter'] . '</td>';
      echo '<td>' . $row['event'] . '</td>';
      echo '</tr>';
    }
    
    echo '</table>';
  } else {
    echo 'No upcoming events.';
  }
  
  // Close the database connection
  mysqli_close($con);
  ?>
  
</body>
</html>