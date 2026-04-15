<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <style>
        #ques {
            min-height: 433px;
        }
    </style>

    <title>iDiscuss - Thread</title>
</head>

<body>

<?php
session_start();
include 'partials/_dbconnect.php';
include 'partials/_header.php';

// 🔒 Secure thread id
$id = isset($_GET['threadid']) ? (int)$_GET['threadid'] : 0;

// 🔍 Fetch thread
$sql = "SELECT * FROM threads WHERE thread_id = $id";
$result = mysqli_query($conn, $sql);

if(!$result){
    die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if(!$row){
    die("Thread not found");
}

$title = htmlspecialchars($row['thread_title']);
$desc = htmlspecialchars($row['thread_desc']);
$thread_user_id = $row['thread_user_id'];

// 🔍 Fetch user
$sql2 = "SELECT user_email FROM users WHERE sno = '$thread_user_id'";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$posted_by = $row2['user_email'];


// 🔥 INSERT COMMENT
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(!isset($_SESSION['sno'])){
        echo "<div class='alert alert-danger'>Login required</div>";
    }
    else{
        $comment = trim($_POST['comment']);
        $comment = htmlspecialchars($comment);
        $sno = (int) $_SESSION['sno'];

        if($comment != ""){
            $sql = "INSERT INTO comments 
            (comment_content, thread_id, comment_by, comment_time) 
            VALUES ('$comment', '$id', '$sno', current_timestamp())";

            $result = mysqli_query($conn, $sql);

            if(!$result){
                die("Insert Error: " . mysqli_error($conn));
            } else {
                echo '<div class="alert alert-success">Comment added successfully</div>';
            }
        }
    }
}
?>

<!-- 🔷 Thread Display -->
<div class="container my-4">
    <div class="jumbotron">
        <h1 class="display-4"><?php echo $title; ?></h1>
        <p class="lead"><?php echo $desc; ?></p>
        <hr>
        <p>Posted by: <strong><?php echo $posted_by; ?></strong></p>
    </div>
</div>

<!-- 🔷 Comment Form -->
<?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo '<div class="container">
        <h3>Post a Comment</h3>
        <form action="'. $_SERVER['REQUEST_URI'] .'" method="post">
            <div class="form-group">
                <textarea class="form-control" name="comment" rows="3" placeholder="Write your comment..." required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
}
else{
    echo '<div class="container">
        <p class="lead">Please login to post a comment</p>
    </div>';
}
?>

<!-- 🔷 Comments Section -->
<div class="container my-4" id="ques">
    <h3>Discussions</h3>

<?php
$sql = "SELECT * FROM comments WHERE thread_id = $id ORDER BY comment_time DESC";
$result = mysqli_query($conn, $sql);

if(!$result){
    die("Fetch Error: " . mysqli_error($conn));
}

$noResult = true;

while($row = mysqli_fetch_assoc($result)){
    $noResult = false;

    $content = htmlspecialchars($row['comment_content']);
    $comment_time = $row['comment_time'];
    $user_id = $row['comment_by'];

    // 🔍 Fetch user email
    $sql2 = "SELECT user_email FROM users WHERE sno='$user_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);

    echo '<div class="media my-3">
        <img src="https://picsum.photos/200" width="54px" class="mr-3">
        <div class="media-body">
            <p class="font-weight-bold">'.$row2['user_email'].' at '.$comment_time.'</p>
            '.$content.'
        </div>
    </div>';
}

if($noResult){
    echo '<div class="alert alert-info">No comments yet. Be the first!</div>';
}
?>

</div>

<?php include 'partials/_footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>