<?php 
    if(isset($_POST["edit-ann"])) {
        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "scouthub";
        $conn = "";

        //create a connection to the database
        $conn = new mysqli($db_server,$db_user,$db_pass,$db_name);

        //check if the connection failed
        if($conn->connect_error) {
            die('Connection Failed : ' . $conn->connect_error);
        }


        $title = $_POST["title2"];
        $description = $_POST["description2"];
        $annId = $_POST["ann-id"];


        $sql = "UPDATE announcement SET title = ?, description = ? WHERE ann_id = ?";
        $stmt = mysqli_stmt_init($conn);
        //check if the preparing if statment failed
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            
            mysqli_close($conn);
            header("Location: ../announcements.php?error=sqlError");
            exit;
        }
        else {
            mysqli_stmt_bind_param($stmt,"ssi",$title,$description,$annId);
            mysqli_stmt_execute($stmt);

            header("Location: ../announcements.php");
        }
        mysqli_stmt_close($stmt);   
        mysqli_close($conn);
    }
    else {
        header("Location: ../announcements.php?error=accesesDenied");
    }

?>