<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $user_email = $_POST["signupEmail"];
    $password = $_POST["signupPassword"];
    $cpassword = $_POST["signupcPassword"];

    $existSql = "SELECT * FROM `users` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);

    if($numExistRows > 0){
        $showError = "Username already in use, try another";
        header("Location: /forum/index.php?signupsuccess=false&error=$showError");
    }
    else{ 
        if($password == $cpassword){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) 
                    VALUES ('$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result){
                header("Location: /forum/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError = "passwords do not match";
            header("Location: /forum/index.php?signupsuccess=false&error=$showError");
        }
    }
}
?>