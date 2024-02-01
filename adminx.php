<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
</head>
<body>
  <h1>Admin Panel</h1>

  <!-- Add Presenter Form -->
  <h2>Add Presenter</h2>
  <form action="admin.php" method="POST">
    <label for="presenterName">Presenter Name:</label>
    <input type="text" name="presenterName" id="presenterName" required>

    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>

    <label for="time">Time:</label>
    <input type="time" name="time" id="time" required>

    <label for="event">Event:</label>
    <input type="text" name="event" id="event" required>

    <input type="submit" value="Add Presenter">
  </form>

  <?php
  // Include the PHP file to connect to the database
  include 'connect.php';

  // Check if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $presenterName = $_POST['presenterName'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $event = $_POST['event'];

    // Create a connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
      die('Connection failed: ' . mysqli_connect_error());
    }

    // Insert the new presenter into the database
    $query = "INSERT INTO schedule (presenter, date, time, event) VALUES ('$presenterName', '$date', '$time', '$event')";
    if (mysqli_query($conn, $query)) {
      echo 'Presenter added successfully.';
    } else {
      echo 'Error adding presenter: ' . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
  }
  ?>

  <!-- Presenters List -->
  <h2>Presenters</h2>
  <?php
  // Fetch the presenters data from the database
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $query = "SELECT * FROM schedule";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr><th>Presenter Name</th><th>Date</th><th>Time</th><th>Event</th><th>Action</th></tr>';

    while ($row = mysqli_fetch_assoc($result)) {
      echo '<tr>';
      echo '<td>' . $row['presenter'] . '</td>';
      echo '<td>' . $row['date'] . '</td>';
      echo '<td>' . $row['time'] . '</td>';
      echo '<td>' . $row['event'] . '</td>';
      echo '<td><a href="admin.php?delete=' . $row['id'] . '">Delete</a></td>';
      echo '</tr>';
    }

    echo '</table>';
  } else {
    echo 'No presenters found.';
  }

  // Handle presenter deletion
  if (isset($_GET['delete'])) {
    $presenterId = $_GET['delete'];

    // Delete the presenter from the database
    $query = "DELETE FROM schedule WHERE id = '$presenterId'";
    if (mysqli_query($conn, $query)) {
      echo 'Presenter deleted successfully.';
    } else {
      echo 'Error deleting presenter: ' . mysqli_error($conn);
    }
  }

  // Close the database connection
  mysqli_close($conn);
  ?>

</body>
</html>