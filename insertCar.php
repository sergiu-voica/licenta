<?php 
    session_start();
    if (isset($_POST['add-car'])) {
        require 'includes/db.php';

        $auth = isset($_SESSION['userUid']);
        if(!$auth) {
            header("Location: index.php?pg=cars&auth=false");
            exit();
        }
        addCar($conn);
    }

    function addCar($conn) {
        $brand = $_POST['brand']; 
        $vehicleNumber = $_POST['vehicleNumber'];
        $user = $_POST['user'];

        $sql = "INSERT INTO cars (userUid, brand, vehicleNumber) VALUES ('$user', '$brand', '$vehicleNumber')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?pg=cars&addcar=success");
            exit();
        } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
        }
        
        mysqli_close($conn);
    }