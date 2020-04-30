<?php 
    // session_start();
    $id = $_GET['id'];
    
    $sql = "DELETE FROM users WHERE idUsers=$id";
    $result = mysqli_query($conn, $sql);
    header("Location: index.php?p=databasequery&removeuser=success");
    exit();

    
?>