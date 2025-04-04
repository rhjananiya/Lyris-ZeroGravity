<?php 
include 'connect.php';

if(isset($_POST['signUp'])){
    $fullName = $_POST['fName'];
    $PatientID = $_POST['PID'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    
    if ($result->num_rows > 0) {
        echo "❌ Email Address Already Exists!";
    } else {
        $insertQuery = "INSERT INTO users(fullName, PatientID, email, password)
                        VALUES ('$fullName', '$PatientID', '$email', '$password')";
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];

        // 🔹 Redirect admin to admin.php
        if ($email === "admin@gmail.com") {
            header("Location: admin.php");
        } else {
            header("Location: homepage.php");
        }
        exit();
    } else {
        echo "❌ Incorrect Email or Password!";
    }
}
?>
