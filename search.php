<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        #maincontainer{
            min-height: 100vh;
        }
    </style>
    <title>Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
   <?php include 'partials/_dbconnect.php'; ?>
<?php include 'partials/_header.php'; ?>

<div class="container my-3" id="maincontainer">

<?php
$query = $_GET['search'] ?? '';
$query = trim($query);
?>

<h1 class="py-3">Search results for <em>"<?php echo htmlspecialchars($query); ?>"</em></h1>

<?php

if($query == ""){
    echo "<div class='alert alert-warning'>Please enter something to search.</div>";
}
else{

    // 🔒 Secure query
    $query_safe = mysqli_real_escape_string($conn, $query);

    // 🔎 Pagination setup
    $results_per_page = 5;
    $page = $_GET['page'] ?? 1;
    $start = ($page - 1) * $results_per_page;

    // Count total results
    $count_sql = "SELECT COUNT(*) as total FROM threads 
                  WHERE MATCH(thread_title, thread_desc) AGAINST ('$query_safe')";
    $count_result = mysqli_query($conn, $count_sql);
    $total_rows = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_rows / $results_per_page);

    // Main query
    $sql = "SELECT * FROM threads 
            WHERE MATCH(thread_title, thread_desc) AGAINST ('$query_safe') 
            LIMIT $start, $results_per_page";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $title = htmlspecialchars($row['thread_title']);
            $desc = htmlspecialchars($row['thread_desc']);
            $thread_id = $row['thread_id'];

            // 🔥 Highlight keyword
            $highlight = "<span style='background:yellow;'>$query</span>";
            $title = str_ireplace($query, $highlight, $title);
            $desc = str_ireplace($query, $highlight, $desc);

            echo '
            <div class="result mb-4">
                <h4><a href="thread.php?threadid='.$thread_id.'" class="text-dark">'.$title.'</a></h4>
                <p>'.$desc.'</p>
            </div>';
        }

        // 🔷 Pagination UI
        echo '<nav><ul class="pagination">';

        for($i=1; $i<=$total_pages; $i++){
            echo '<li class="page-item '.($i==$page?'active':'').'">
                    <a class="page-link" href="search.php?search='.$query.'&page='.$i.'">'.$i.'</a>
                  </li>';
        }

        echo '</ul></nav>';
    }
    else{
        echo '<div class="jumbotron">
                <h2>No Results Found</h2>
                <ul>
                    <li>Check spelling</li>
                    <li>Use different keywords</li>
                    <li>Try general words</li>
                </ul>
              </div>';
    }
}
?>

</div>

<?php include 'partials/_footer.php'; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>
