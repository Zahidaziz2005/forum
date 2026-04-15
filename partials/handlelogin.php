<?php

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo 'آپ لاگ ان ہیں: ' . $_SESSION['useremail'];
    // یہاں لاگ آؤٹ کا بٹن دکھائیں
} else {
    // یہاں لاگ ان اور سائن اپ کے بٹن دکھائیں
}

$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];

    $sql = "Select * from users where user_email='$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);

    if($numRows == 1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass, $row['user_pass'])){
            
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno']; // آپ کے ٹیبل کا کالم 'sno' ہی ہے
            $_SESSION['useremail'] = $email;
            
            // کامیاب لاگ ان کے بعد فوراً ری ڈائریکٹ کریں اور اسکرپٹ روک دیں
            header("Location: /forum/index.php?loginsuccess=true");
    
            exit(); 
        } else {
            header("Location: /forum/index.php?loginsuccess=false&error=wrongpassword");
            exit();
        }
    } else {
        header("Location: /forum/index.php?loginsuccess=false&error=invaliduser");
        exit();
    }
}
?>