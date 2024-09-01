<?php
// Configuration
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'testtrack';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $primary_key = $_POST['primary_key'];

  // Prepare statement
  $stmt = $conn->prepare("SELECT * FROM trackin WHERE ConsignmentID = ?");
  if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
  }

  // Bind parameter
  $stmt->bind_param("i", $primary_key);

  // Execute statement
  if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
  }

  $result = $stmt->get_result();

  // Display results
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<p>";
      echo "ID: " . $row["ConsignmentID"] . "<br>";
      echo "Column1: " . $row["ORIGIN"] . "<br>";
      echo "Column2: " . $row["CURRENT_LOCATION"] . "<br>";
      echo "Column3: " . $row["DESTINATION"] . "<br>";
      echo "Column4: " . $row["CURRENT_STATUS"] . "<br>";
      echo "Column5: " . $row["NOTES"] . "<br>";
      echo "</p>";
    }
  } else {
    echo "No results found";
  }

  // Close statement
  $stmt->close();
}

// Close connection
$conn->close();
?>
