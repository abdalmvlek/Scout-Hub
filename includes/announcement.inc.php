<?php
    session_start();

    if(isset($_POST["create-ann"])) {
        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "scouthub";
        $conn = "";

        //create a connection to the database
        $conn = new mysqli($db_server,$db_user,$db_pass,$db_name);

        if($conn->connect_error) { 
            die('Connection Failed : ' . $conn->connect_error);
        }

        //get form data
        $eventTitle = $_POST["title"];
        $eventDesc = $_POST["description"];

        $sql = "INSERT INTO announcement (title,description,created_by,branch_id)
                VALUES (?,?,?,?)";
            
        $stmt = mysqli_stmt_init($conn);

        //check if the preparing of the statent fails
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            
            mysqli_close($conn);
            header("Location: ../announcements.php?error=sqlError");
            exit;
        }
        else {
            mysqli_stmt_bind_param($stmt,"ssii",$eventTitle,$eventDesc,$_SESSION["userId"],$_SESSION["branchId"]);
            mysqli_stmt_execute($stmt);

            header("Location: ../announcements.php?msg=success");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        header("Location: ../announcements.php?error=AccsessDenied");
        exit;
    }

?>