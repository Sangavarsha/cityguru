<style>
    /* Style the navbar container */
    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        background-color: white;
        /* Change this to your preferred color */
    }

    /* Style the logo */
    .navbar .logo a {
        color: white;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;

    }

    /* Remove default list styling */
    .navbar ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        /* Display the list items in a row */
    }

    /* Style the list items and links */
    .navbar ul li {
        margin-right: 20px;
        /* Spacing between links */
    }

    .navbar ul li a {
        color: black;
        text-decoration: none;
        font-size: 18px;
        padding: 8px 16px;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Hover effect for links */
    .navbar ul li a:hover {
        background-color: #555;
        /* Change this to your preferred hover color */
        color: #fff;
        /* Change this to your preferred hover text color */
    }

    /* Style for the mobile menu icon (hidden by default) */
    .menu-icon {
        display: none;
    }

    /* Responsive behavior */
    @media screen and (max-width: 768px) {
        .navbar ul {
            display: none;
            /* Hide the nav links by default */
            flex-direction: column;
            /* Stack them vertically on smaller screens */
        }

        .navbar ul.show {
            display: flex;
            /* Show the nav links when the menu icon is clicked */
        }

        .menu-icon {
            display: block;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
    }
</style>

<header>
    <div class="navbar">
        <div class="logo">
            <a href="index.php">City Guru</a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact Us</a></li>
            </ul>
        </nav>
        <div class="menu-icon">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>