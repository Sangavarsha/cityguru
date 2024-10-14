<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cityguru"; // Updated to the correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to get all carpenters
$sql = "SELECT * FROM worker WHERE profession='Carpenter'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carpenters</title>
  <style>
    .people-section {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .person-card {
      width: 300px;
      padding: 20px;
      margin: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      background-color: #f9f9f9;
    }

    .person-name {
      font-weight: bold;
      margin-bottom: 10px;
    }

    .person-age,
    .person-location,
    .cost,
    .person-info {
      margin-bottom: 5px;
    }

    .img {
      width: 10em;
      height: 10em;
      border-radius: 50%;
      border: 5px solid var(--seagreen);
      padding: 3px;
      margin-bottom: 1em;
    }

    .btn {
      background-color: teal;
      color: #fff;
      font-size: 1rem;
      text-transform: uppercase;
      font-weight: 600;
      border: none;
      padding: .5em;
      border-radius: .5em;
      margin-top: .5em;
      cursor: pointer;
    }

    .btn:hover {
      color: rosybrown;
    }
  </style>
</head>

<body>
  <section class="people-section">
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        // Convert binary image data to base64
        $imageData = base64_encode($row['image']);
        $imageSrc = "data:image/jpeg;base64," . $imageData;

        echo "<div class='person-card'>
                        <img class='img' src='" . $imageSrc . "' alt='Worker Image'>
                        <h2 class='person-name'>" . htmlspecialchars($row['name']) . "</h2>
                        <p class='person-age'>Age: " . htmlspecialchars($row['age']) . "</p>
                        <p class='person-location'>Location: " . htmlspecialchars($row['location']) . "</p>
                        <p class='cost'>Rs." . htmlspecialchars($row['charge']) . " per hour</p>
                        <p class='person-info'>" . htmlspecialchars($row['description']) . "</p>
                        <button class='btn'>Accept</button>
                        <button class='btn'>Decline</button>
                    </div>";
      }
    } else {
      echo "<p>No results found.</p>";
    }
    $conn->close();
    ?>
  </section>
</body>

</html>