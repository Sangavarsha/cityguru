<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $rating = $_POST['rating'];
  $review = $_POST['review'];

  $sql = "INSERT INTO reviews (rating, review) VALUES ('$rating', '$review')";

  if ($conn->query($sql) === TRUE) {
    echo "Review submitted successfully!";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Public Reviews</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* (Include the same CSS styles as before) */
    .review-form {
      max-width: 500px;
      margin: 0 auto;
    }

    .heading {
      border-radius: 1rem;
      box-sizing: border-box;
      width: 320px;
      padding: 10px;
      border: 5px solid rgb(11, 11, 11);
      margin: 0;
      background-color: beige;
    }

    .form-group {
      margin-bottom: 10px;
    }

    .rating-input {
      display: flex;
      align-items: center;
    }

    .rate {
      padding-top: 3rem;
    }

    .rating-input input[type="radio"] {
      display: none;
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin: 10px;
    }

    .rating-input label {
      color: #ccc;
      cursor: pointer;
      margin-right: 5px;
    }

    .rating-input label i {
      transition: color 0.3s;
    }

    .rating-input input[type="radio"]:checked~label {
      color: #ffc107;
    }

    .rating-input input[type="radio"]:checked~label i {
      color: #ffc107;
    }

    .btn:hover {
      cursor: pointer;
      background: cadetblue;
    }

    .btn {
      border-radius: 1rem;
      box-sizing: border-box;
      width: 90px;
      padding: 7px;
      border: 5px solid rgb(11, 11, 11);
      margin: 0;
      background-color: azure;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="review-form">
    <h2 class="heading">Rate and Review</h2>

    <form id="reviewForm" method="POST" action="">
      <div class="form-group">
        <label class="rate" for="rating">Rating:</label>
        <div class="rating-input">
          <input type="radio" id="star5" name="rating" value="5" required>
          <label for="star5"><i class="fas fa-star"></i></label>
          <input type="radio" id="star4" name="rating" value="4">
          <label for="star4"><i class="fas fa-star"></i></label>
          <input type="radio" id="star3" name="rating" value="3">
          <label for="star3"><i class="fas fa-star"></i></label>
          <input type="radio" id="star2" name="rating" value="2">
          <label for="star2"><i class="fas fa-star"></i></label>
          <input type="radio" id="star1" name="rating" value="1">
          <label for="star1"><i class="fas fa-star"></i></label>
        </div>
      </div>

      <div class="form-group">
        <label for="review">Review:</label>
        <textarea id="review" name="review" required></textarea>
      </div>

      <button type="submit" class="btn">Submit</button>
    </form>
  </div>

</body>

</html>