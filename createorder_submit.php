<?php include 'header.php'; ?>

  <!-- Page content goes here -->
  <div class="container mt-4">
  <?php
$w=$_POST['id'];
$x=$_POST['size'];
$y=$_POST['drinktype'];
$q=$_POST['quantity'];
$z=$_POST['totalPrice'];
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

$sql = "SELECT id, first_name FROM customers WHERE id = '$w'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

  $customerData = $result-> fetch_assoc();
  $firstName = $customerData['first_name'];

  $sql = "INSERT INTO orders (id, size, drink_type, quantity, total_price) VALUES ('$w', '$x', '$y', '$q', '$z')";
  
  if ($conn->query($sql) === TRUE) {
    $sql = "SELECT SUM(total_price) AS total_sum FROM orders WHERE id = '$w'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $data = $result->fetch_assoc();
      $totalSum = $data['total_sum'];
      $formattedPrice = number_format($totalSum, 2);
      echo "Thank you, $firstName! Your order was processed successfully.<br>
      Your past orders are displayed below. So far, you have spent a total of $$formattedPrice.<br>
      (Warning: refreshing this page may result in your order being submitted another time.)";
    } else {
      echo "Error retrieving total sum: " . $conn->error;
    }
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  $sql = "SELECT size, drink_type, quantity, total_price FROM orders WHERE id='$w'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    echo "<table>";
    echo "<tr>
    <th>Size</th>
    <th>Drink Type</th>
    <th>Quantity</th>
    <th>Total Price</th>
    </tr>";
    while($row = $result->fetch_assoc()) {
      $formattedPrice = number_format($row["total_price"], 2);
      echo "<tr>
        <td>" . $row["size"]. "</td>
        <td> " . $row["drink_type"]. "</td>
        <td> " . $row["quantity"]. "</td>
        <td> $" . $formattedPrice . "</td>
      </tr>";
	  }
	  echo "</table>";
    $sql = "UPDATE customers
    SET Amount_Spent = (
        SELECT SUM(orders.Total_Price)
        FROM orders
        WHERE orders.ID = customers.ID
    );";
    $result = $conn->query($sql);
  } else {
	  echo "0 results";
  }
} else {
  echo "The User ID you have given ($w) was not found in our database. Please register for a new user account if you have not already.";
}

$conn->close();
?>
  </div>

<?php include 'footer.php'; ?>