<?php
// Start the session at the beginning of the script
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cityguru";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, set a flash message and redirect to the login page
    $_SESSION['flash_message'] = "You must be logged in to book a worker.";
    header("Location: login.php");
    exit(); // Ensure no further code is executed
}

// Initialize message variable
$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email']; // Added email field
    $profession = $_POST['profession'];
    $location = $_POST['location'];
    $age = $_POST['age'];
    $charge = $_POST['charge'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];

    // Handle the image upload
    $imageData = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $message = "<p class='error'>Error uploading image.</p>";
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO worker (name, email, image, profession, location, age, charge, rating, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssids", $name, $email, $imageData, $profession, $location, $age, $charge, $rating, $description);
    $stmt->send_long_data(2, $imageData); // Send binary data

    // Execute the query
    if ($stmt->execute()) {
        $message = "<p class='success'>New worker added successfully!</p>";
    } else {
        $message = "<p class='error'>Error: " . $stmt->error . "</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Worker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .message {
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
            text-align: left;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="file"],
        input[type="number"],
        input[type="email"],
        /* Added for email field */
        textarea,
        select {
            width: calc(100% - 22px);
            /* Ensure it fits within the container */
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            display: inline-block;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success {
            color: #4CAF50;
        }

        .error {
            color: #f44336;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Worker Registration Form</h2>
        <div class="message">
            <?php echo $message; ?>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="profession">Profession:</label>
                <select id="profession" name="profession" required>
                    <option value="Electrician">Electrician</option>
                    <option value="Gardener">Gardener</option>
                    <option value="Homemaid">Homemaid</option>
                    <option value="Hair Dresser">Hair Dresser</option>
                    <option value="Carpenter">Carpenter</option>
                    <option value="Beautician">Beautician</option>
                </select>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>

            <div class="form-group">
                <label for="charge">Charge:</label>
                <input type="number" id="charge" name="charge" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="rating">Rating:</label>
                <input type="number" id="rating" name="rating" step="0.01" value="0.00" max="5.00" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description"></textarea>
            </div>

            <input type="submit" value="Add Worker">
        </form>
    </div>
</body>

</html>