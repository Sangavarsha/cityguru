<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City_Guru</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="cg.css">
    <script>
        // Function to get the user's location
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendPositionToServer, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // Function to send location data to the server
        function sendPositionToServer(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Create an XMLHttpRequest object
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "save_location.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Handle the response from the server
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    console.log("Location sent to server successfully.");
                    console.log("Server response:", xhr.responseText);
                }
            };

            // Send the location data to the server
            xhr.send("latitude=" + latitude + "&longitude=" + longitude);
        }

        // Function to handle errors in getting location
        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }

        // Call the function to get the user's location when the page loads
        window.onload = getLocation;
    </script>
</head>

<body>
    <header>
        <input type="checkbox" name="checkbox" id="toggler">
        <label for="toggler" class="fas fa-bars"></label>
        <a href="#" class="logo">CityGuru</a>
        <nav class="navbar">
            <a href="#Home">Home</a>
            <a href="#about">About</a>
            <a href="#swiper">Service</a>
            <a href="customers.php">Public Review</a>
            <a href="#contact">Contact</a>
            <a href="workers.php">Worker Registration</a>
        </nav>
        <div class="icons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php" class="fas fa-user"></a>
            <?php else: ?>
                <a href="login.php" class="fas fa-user"></a>
            <?php endif; ?>
        </div>
    </header>
    <section class="Home" id="Home" onload="slider">
        <div class="banner">
            <div class="slider">
                <img src="image/home.jpg" id="slideImg">
            </div>
            <div class="overlay">
                <div class="content">
                    <h2>City Guru</h2>
                    <h3>City Guru's mission is to empower millions of professionals worldwide and provide reliable and convenient services to customers.
                        By leveraging technology and a strong network of skilled professionals, City Guru aims to revolutionize the way people access
                        and experience home and local services.</h3>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Wrap the code inside an event listener
        window.addEventListener('load', function() {
            var slideImg = document.getElementById("slideImg");
            var images = [
                "image/home.jpg",
                "image/hair.jpg",
                "image/garden.jpg",
                "image/homemaid.jpg",
                "image/beauti.jpg",
                "image/elec.jpg",
                "image/carp.jpg"
            ];
            var len = images.length;
            var i = 0;

            function slider() {
                if (i > len - 1) {
                    i = 0;
                }
                slideImg.src = images[i];
                i++;
                setTimeout(slider, 3000); // Remove the quotes around the function name
            }

            slider(); // Call the slider function to start the slideshow
        });
    </script>
    <section class="about" id="about">
        <h1 class="heading"> <span>About</span> us</h1>
        <div class="row">
            <div class="imagecontainer">
                <img src="image/Banner.png">
            </div>
            <div class="Content">
                <h3>Why Choose Us</h3>
                <pre>
                    City Guru is a trusted platform that connects customers with verified and skilled professionals for a wide range of services. 
                    With a focus on convenience, quality, and safety, City Guru offers easy booking, transparent pricing, and a reliable service experience. 
                    Customers benefit from the peace of mind of hiring professionals who have undergone background checks and meet high standards. 
                    The platform's presence in multiple cities and commitment to community empowerment make it a popular choice for those seeking reliable and convenient service solutions.
                </pre>
                <a href="#" class="btn">learn more</a>
            </div>
        </div>
    </section>
    <section class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="card swiper-slide">
                <div class="card__image">
                    <img src="image/beautian.jpeg" alt="card_image">
                </div>
                <div class="card__content">
                    <span class="card__title"> Beautician</span>
                    <a href="beautician.php" target="_blank">
                        <button class="card__btn">View More</button>
                    </a>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="card__image">
                    <img src="image/carpenter.jpeg" alt="card_image">
                </div>
                <div class="card__content">
                    <span class="card__title"> Carpenter</span>
                    <a href="carpenter.php" target="_blank">
                        <button class="card__btn">View More</button>
                    </a>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="card__image">
                    <img src="image/eletrician.jpeg" alt="card_image">
                </div>
                <div class="card__content">
                    <span class="card__title"> Electrician</span>
                    <a href="electricain.php" target="_blank">
                        <button class="card__btn">View More</button>
                    </a>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="card__image">
                    <img src="image/gardener.jpeg" alt="card_image">
                </div>
                <div class="card__content">
                    <span class="card__title"> Gardener</span>
                    <a href="gardener.php" target="_blank">
                        <button class="card__btn">View More</button>
                    </a>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="card__image">
                    <img src="image/hairdresser.jpeg" alt="card_image">
                </div>
                <div class="card__content">
                    <span class="card__title"> Hairdresser</span>
                    <a href="hairdresser.php" target="_blank">
                        <button class="card__btn">View More</button>
                    </a>
                </div>
            </div>
            <div class="card swiper-slide">
                <div class="card__image">
                    <img src="image/homemaid.jpeg" alt="card_image">
                </div>
                <div class="card__content">
                    <span class="card__title"> Maid</span>
                    <a href="homemaid.php" target="_blank">
                        <button class="card__btn">View More</button>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 300,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
            },
        });
    </script>
    <section class="contact" id="contact">
        <h1 class="heading"> <span>Contact</span> Us</h1>
        <div class="row">
            <form action="contact_form.php" method="post">
                <input type="text" placeholder="name" class="box" name="name" required>
                <input type="email" placeholder="email" class="box" name="email" required>
                <input type="number" placeholder="number" class="box" name="number" required>
                <textarea name="message" class="box" placeholder="message" id="" cols="30" rows="10" required></textarea>
                <input type="submit" value="send message" class="btn">
            </form>
        </div>
    </section>
    <section class="footer">
        <div class="boxcontainer">
            <div class="box">
                <h3>quicklinks</h3>
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Service</a>
                <a href="#">Public Review</a>
                <a href="#">Contact</a>
            </div>
            <div class="box">
                <h3>Extra Links</h3>
                <a href="#">My Account</a>
            </div>
            <div class="box">
                <h3>Locations</h3>
                <a href="#">Hanamkonda</a>
                <a href="#">Kazipet</a>
                <a href="#">Warangal</a>
                <a href="#">Fathima Nagar</a>
            </div>
            <div class="box">
                <h3>Contact Info</h3>
                <a href="#">Phone: 9876543210</a>
                <a href="#"> Email: cityguru@gmail.com</a>
            </div>
        </div>
        <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-twitter"></a>
        </div>
        <div class="credit">
            <p>Copyright &copy; City Guru All Rights Reserved</p>
        </div>
    </section>
</body>

</html>