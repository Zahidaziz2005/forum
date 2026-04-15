<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <title>About Us - iDiscuss</title>

    <style>
        .hero {
            background: #343a40;
            color: white;
            padding: 60px 20px;
            text-align: center;
        }
        .section {
            padding: 40px 20px;
        }
    </style>
</head>

<body>

<?php include 'partials/_dbconnect.php'; ?>
<?php include 'partials/_header.php'; ?>

<!-- 🔷 Hero Section -->
<div class="hero">
    <h1>Welcome to iDiscuss</h1>
    <p>A platform where ideas meet solutions</p>
</div>

<!-- 🔷 About Section -->
<div class="container section">
    <h2>About Us</h2>
    <p>
        iDiscuss is a coding discussion forum designed to help developers learn, share knowledge,
        and solve problems together. Whether you are a beginner or an experienced programmer,
        this platform provides a collaborative environment to grow your skills.
    </p>
</div>

<!-- 🔷 Mission Section -->
<div class="container section">
    <h2>Our Mission</h2>
    <p>
        Our mission is to build a supportive community where users can freely ask questions,
        share answers, and improve their understanding of programming and technology.
    </p>
</div>

<!-- 🔷 Features Section -->
<div class="container section">
    <h2>What We Offer</h2>
    <ul>
        <li>✔ Ask and answer coding questions</li>
        <li>✔ Explore different programming categories</li>
        <li>✔ Learn from community discussions</li>
        <li>✔ Build knowledge through collaboration</li>
    </ul>
</div>

<!-- 🔷 Developer Section -->
<div class="container section">
    <h2>About Developer</h2>
    <p>
        This platform is developed by <strong>Zahid Aziz</strong>, a computer science graduate
        and educator, aiming to provide a simple and effective learning environment for students
        and developers.
    </p>
</div>

<?php include 'partials/_footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>