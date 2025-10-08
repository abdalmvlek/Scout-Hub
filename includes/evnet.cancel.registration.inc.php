<?php 
    session_start();

    if(isset($_GET["id"])) {
        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "scouthub";
        $conn = "";

        $conn = new mysqli($db_server,$db_user,$db_pass,$db_name);

        if($conn->connect_error) {
            die("Connection Failed : " + $conn->connect_error);
        }


        $sql = "DELETE FROM event_registration WHERE user_id = ? AND event_id = ?";
        $stmt = mysqli_stmt_init($conn);

        //check if the preparing of the stamtent fails
        if(!mysqli_stmt_prepare($stmt,$sql)) {

            mysqli_close($conn);
            header("Location: ../events.php?error=sqlError");
            exit;
        }
        else {
            mysqli_stmt_bind_param($stmt,"ii",$_SESSION['userId'],$_GET['id']);
            mysqli_stmt_execute($stmt);

            //redirect the user to the events page
            header("Location: ../events.php");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

?>