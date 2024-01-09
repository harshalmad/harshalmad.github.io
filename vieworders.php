<?php include 'header.php'; ?>

<!-- Page content goes here -->
<div class="container mt-4">

    <h2>View orders</h2>

    <!-- HTML form to input customer ID -->
    <form method="post" action="">
        <label for="customer_id">Enter Customer ID:</label>
        <input type="text" name="customer_id" required>
        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $enteredCustomerId = $_POST['customer_id'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "drinksproject";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the entered ID exists in the customers table
        $checkSql = "SELECT id, first_name, last_name, email, amount_spent FROM customers WHERE id = '$enteredCustomerId'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            $customerData = $checkResult->fetch_assoc();
            $firstName = $customerData['first_name'];
            $lastName = $customerData['last_name'];
            $email = $customerData['email'];
            $amountSpent = number_format($customerData['amount_spent'], 2);

            // Determine status based on amount spent
            $status = "";
            if ($amountSpent < 50.00) {
                $status = "Regular";
                $remainingAmount = number_format(50.00 - $amountSpent, 2);
                $statusMessage = "Spend $" . $remainingAmount . " to reach Gold status";
            } elseif ($amountSpent >= 50.00 && $amountSpent < 200.00) {
                $status = "Gold";
                $remainingAmount = number_format(200.00 - $amountSpent, 2);
                $statusMessage = "Spend $" . $remainingAmount . " more to reach Platinum status";
            } elseif ($amountSpent >= 200.00) {
                $status = "Platinum";
                $statusMessage = "Congratulations! You have reached Platinum status";
            }

            // Display customer information
            echo "<p><strong>Customer Name:</strong> $firstName $lastName</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Total Amount Spent:</strong> $$amountSpent</p>";
            echo "<p><strong>Status:</strong> $status</p>";

            // Display status-related message
            if (isset($statusMessage)) {
                echo "<p>$statusMessage</p>";
            }

            // Fetch and display orders
            $sql = "SELECT size, drink_type, quantity, total_price FROM orders WHERE id = '$enteredCustomerId'";
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
                while ($row = $result->fetch_assoc()) {
                    $formattedPrice = number_format($row["total_price"], 2);
                    echo "<tr>
                            <td>" . $row["size"] . "</td>
                            <td>" . $row["drink_type"] . "</td>
                            <td>" . $row["quantity"] . "</td>
                            <td>$" . $formattedPrice . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "No orders found for Customer ID: $enteredCustomerId";
            }
        } else {
            echo "Customer ID $enteredCustomerId not found";
        }

        $conn->close();
    }
    ?>

</div>

<?php include 'footer.php'; ?>
