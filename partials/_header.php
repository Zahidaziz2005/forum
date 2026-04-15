<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/forum">iDiscuss</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/forum">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
              <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Top Categories
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
$sql = "SELECT category_name, category_id FROM `categories` LIMIT 3";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo '<a class="dropdown-item" href="threadlist.php?catid=' . $row['category_id'] . '">' . $row['category_name'] . '</a>';
}
echo '</div>
    </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center">
               <form method="get" action="search.php" class="form-inline my-2 my-lg-0 ml-auto">
    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search threads..." required>
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>';

// logout logic is here 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {


    echo '<div class="d-flex align-items-center">
                            <p class="text-light my-0 mx-2">Welcome ' . $_SESSION['useremail'] . '</p>
                            <a href="partials/logout.php" class="btn btn-success ms-2">Logout</a>
                          </div>';
} else {
    echo '<div class="mx-2 d-flex">
                            <button class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                            <button class="btn btn-outline-success ms-2" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</button>
                          </div>';
}

echo '      </div> 
        </div> 
    </div>
</nav>';

include 'partials/loginmodal.php';
include 'partials/signupmodal.php';

// alert for successful sign up
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You can now login
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
?>