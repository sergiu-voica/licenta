<?php 
    session_start();
    if (isset($_POST['add-cargo'])) {
        require 'includes/db.php';

        $auth = isset($_SESSION['userUid']);
        if(!$auth) {
            header("Location: index.php?pg=cargo&auth=false");
            exit();
        }
        addCar($conn);
    }

    function addCar($conn) {
        $userId = $_SESSION['userUid'];
        $carId = $_POST['id_masina']; 
        $description = $_POST['description'];

        $sql = "INSERT INTO cargo (userUid, vehicleNumber, denumire) VALUES ('$userId', '$carId', '$description')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?pg=cargo&addcargo=success");
            exit();
        } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
        }
        
        mysqli_close($conn);
    }