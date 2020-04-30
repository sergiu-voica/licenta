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
        $carId = $_POST['id_masina']; 
        $userId = $_POST['id_user'];
        $description = $_POST['description'];

        $sql = "INSERT INTO cargo (id_user, id_masina, denumire) VALUES ('$userId', '$carId', '$description')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?pg=cargo&addcargo=success");
            exit();
        } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
        }
        
        mysqli_close($conn);
    }