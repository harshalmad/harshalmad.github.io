<?php include 'header.php'; ?>

  <!-- Page content goes here -->
  <div class="container mt-4">
    <h2>Register new user</h2>
    <p>Type your email, first name, and last name, and a user ID will be generated for you.</p>
    <form action="register_submit.php" method="POST">
    <p>
      <label for="email">Enter your email:</label>
      <input type="text" id="email" name="email">
    </p>
    <p>
      <label for="firstname">Enter your first name:</label>
      <input type="text" id="firstname" name="firstname">
    </p>
    <p>
      <label for="lastname">Enter your last name:</label>
      <input type="text" id="lastname" name="lastname">
    </p>
    <input type="submit" value="Register User" name="submituser">
    </form>
  </div>

<?php include 'footer.php'; ?>