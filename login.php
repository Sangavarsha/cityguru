<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cityguru";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['login'])) {
    // Login logic
    $identifier = $_POST['login-identifier'];
    $password = $_POST['login-password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM users WHERE (email=? OR phone=?)");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc(); // Fetch the row as an associative array
      if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['phone'] = $row['phone'];
        $_SESSION['login_message'] = 'Login successful!';
        header('Location: index.php'); // Redirect to home page
        exit();
      } else {
        $_SESSION['login_message'] = 'Invalid credentials!';
      }
    } else {
      $_SESSION['login_message'] = 'Invalid credentials!';
    }

    $stmt->close();
  } elseif (isset($_POST['signup'])) {
    // Signup logic
    $username = $_POST['signup-username'];
    $email = $_POST['signup-email'];
    $phone = $_POST['signup-phone'];
    $password = $_POST['signup-password'];

    // Check if email or phone already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR phone=?");
    $stmt->bind_param("ss", $email, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $_SESSION['signup_message'] = 'Email or phone already exists!';
    } else {
      // Hash password and insert new user
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $username, $email, $phone, $hashed_password);
      if ($stmt->execute()) {
        $_SESSION['signup_message'] = 'Signup successful!';
      } else {
        $_SESSION['signup_message'] = 'Error: ' . $stmt->error;
      }
    }

    $stmt->close();
  }
}

// Clear flash messages after displaying
function display_flash_message($key)
{
  if (isset($_SESSION[$key])) {
    echo "<p>{$_SESSION[$key]}</p>";
    unset($_SESSION[$key]);
  }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login/Signup Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      background-color: #f4f4f4;
    }

    h2 {
      text-align: center;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .form-group input[type="text"],
    .form-group input[type="password"],
    .form-group input[type="tel"],
    .form-group input[type="email"] {
      width: 100%;
      padding: 5px;
      border: 1px solid #ccc;
    }

    .form-group button {
      padding: 8px 12px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      cursor: pointer;
    }

    .form-group button:hover {
      background-color: #45a049;
    }

    .user-info {
      display: flex;
      align-items: center;
    }

    .user-info img {
      border-radius: 50%;
      width: 40px;
      height: 40px;
      margin-right: 10px;
    }

    .user-info a {
      margin-left: 10px;
      text-decoration: none;
      color: #4CAF50;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Login</h2>
    <?php display_flash_message('login_message'); ?>
    <form method="post" action="">
      <div class="form-group">
        <label for="login-identifier">Email or Phone:</label>
        <input type="text" id="login-identifier" name="login-identifier" placeholder="Enter your email or phone number" required>
      </div>
      <div class="form-group">
        <label for="login-password">Password:</label>
        <input type="password" id="login-password" name="login-password" placeholder="Enter your password" required>
      </div>
      <div class="form-group">
        <button type="submit" name="login">Login</button>
      </div>
    </form>

    <h2>Sign Up</h2>
    <?php display_flash_message('signup_message'); ?>
    <form method="post" action="">
      <div class="form-group">
        <label for="signup-username">Username:</label>
        <input type="text" id="signup-username" name="signup-username" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <label for="signup-email">Email:</label>
        <input type="email" id="signup-email" name="signup-email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="signup-phone">Phone:</label>
        <input type="tel" id="signup-phone" name="signup-phone" placeholder="Enter your phone number" required>
      </div>
      <div class="form-group">
        <label for="signup-password">Password:</label>
        <input type="password" id="signup-password" name="signup-password" placeholder="Enter your password" required>
      </div>
      <div class="form-group">
        <button type="submit" name="signup">Sign Up</button>
      </div>
    </form>
  </div>
</body>

</html>