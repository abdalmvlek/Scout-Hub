<?php
    if(isset($_GET["id"])) {
        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "scouthub";
        $conn = "";

        //create connection to the database
        $conn = new mysqli($db_server,$db_user,$db_pass,$db_name);

        //check if the connection was successful
        if ($conn->connect_error) {
            die('Connection Failed : ' . $conn->connect_error);
        }
        
        //deleting an event by setting it delted column to 1 (true)
        $sql = "UPDATE announcement SET deleted = 1 WHERE ann_id=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            
            mysqli_close($conn);    
            header("Location: ../announcements.php?error=deletEditError");
            exit;
        }
        else {
            mysqli_stmt_bind_param($stmt,"i",$_GET["id"]);
            mysqli_stmt_execute($stmt);

            header("Location: ../announcements.php");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
?>