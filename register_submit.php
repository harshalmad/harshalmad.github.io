<?php include 'header.php'; ?>

  <!-- Page content goes here -->
  <div class="container mt-4">
  <?php
$x=$_POST['email'];
$y=$_POST['firstname'];
$z=$_POST['lastname'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname="drinksproject";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error . "<br>");
}
// echo "Connected successfully<br>";

$sql = "INSERT INTO customers (email, first_name, last_name, amount_spent, discount, bonus_bucks) VALUES ('$x', '$y', '$z', 0, 0, 0)";
$uniqueid_query = "SELECT id, email, first_name, last_name FROM customers WHERE email='$x'";
	
if ($conn->query($sql) === TRUE) {

  // Execute the query to get the unique customer ID
  $result = $conn->query($uniqueid_query);

  // Check if query was successful
  if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Get info from the array
    $customer_id = $row['id'];
    $email = $row['email'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];

    // Display success message with customer ID
    echo "<p>Your info has been successfully added to the system.</p>
    <p>Your name is: " . $first_name . " " . $last_name . "</p>
    <p>Your email is: " . $email . "</p>
    <p>Your unique customer ID is: " . $customer_id . "</p>";
  } else {
    // Display error if the query fails
    echo "Error fetching customer ID: " . $conn->error;
  }
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
  </div>

<?php include 'footer.php'; ?>