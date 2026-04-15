<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <title>Contact Us - iDiscuss</title>

    <style>
        .container {
            min-height: 87vh;
        }
    </style>
</head>

<body>

<?php
include 'partials/_dbconnect.php';
include 'partials/_header.php';

$showAlert = false;

// 🔥 Handle form submit
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // 🔒 Basic security
    $email = mysqli_real_escape_string($conn, $email);
    $subject = mysqli_real_escape_string($conn, $subject);
    $message = mysqli_real_escape_string($conn, $message);

    if($email != "" && $message != ""){
        $sql = "INSERT INTO contacts (email, subject, message) 
                VALUES ('$email', '$subject', '$message')";
        
        $result = mysqli_query($conn, $sql);

        if($result){
            $showAlert = true;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<div class="container my-3">
    <h1 class="text-center">Contact Us</h1>

    <?php
    if($showAlert){
        echo '<div class="alert alert-success">
                Your message has been sent successfully!
              </div>';
    }
    ?>

    <form method="post" action="contact.php">

        <div class="form-group">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Subject</label>
            <select name="subject" class="form-control">
                <option>General Inquiry</option>
                <option>Technical Issue</option>
                <option>Feedback</option>
                <option>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label>Your Message</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>

<?php include 'partials/_footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>