<?php
    session_start();    

    if(isset($_GET["id"])) {

        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "scouthub";
        $conn = "";

        //create connection to the database 
        $conn = new mysqli($db_server,$db_user,$db_pass,$db_name);

        //check if the connection was successful
        if($conn->connect_error) {
            die("Connection Failed : " . $conn->connect_error);
        }

        $sql = "INSERT INTO event_registration (user_id,event_id) 
                VALUES (?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {

            mysqli_close($conn);
            header("Location: ../events.php?error=sqlError");
            exit;
        }
        else {
            mysqli_stmt_bind_param($stmt,"ii",$_SESSION["userId"],$_GET["id"]);
            mysqli_stmt_execute($stmt);

            header("Location: ../events.php");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

?>