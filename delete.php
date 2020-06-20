<?php 
    // session_start();
    if ($_GET['e'] == "car") {
        $id = $_GET['id'];
    
        $sql = "DELETE cars.*,cargo.* 
            FROM cars LEFT JOIN cargo 
            ON cars.id = cargo.id_masina 
            WHERE cars.id=$id";

        //$sql = "DELETE FROM cars WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        header("Location: index.php?pg=cars&removecar=success");
        exit();
    } else if ($_GET['e'] == "cargo") {
        $id = $_GET['id'];
    
        $sql = "DELETE FROM cargo WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        header("Location: index.php?pg=cargo&removecargo=success");
        exit();
    } 

    $id = $_GET['id'];
    
    $sql = "DELETE users.*,cargo.* 
    FROM users LEFT JOIN cargo 
    ON users.idUsers=cargo.id_user 
    WHERE users.idUsers=$id";

    //$sql = "DELETE FROM users WHERE idUsers=$id";
    $result = mysqli_query($conn, $sql);
    header("Location: index.php?pg=databasequery&removeuser=success");
    exit();   
?>