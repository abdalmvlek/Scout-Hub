<?php
    session_start();

    if(isset($_POST["create-event"])) {
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
        $eventDate = $_POST["date"];

        //store the event image
        $targetDir = "uploads/";
        $fullPath = "";
        $AnImage = true;

        //check if the file (image) was uploaded without errors
        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
            //check if the file is an image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check == false) {
                $AnImage = false;
            }

            $fileName = basename($_FILES["image"]["name"]);   
            
            $fullPath = $targetDir . $fileName;   

            //check if the file name already exists and if so change it to be unique
            if(file_exists($fullPath)) {
                //add 1 before the existing file name to make it unique
                $fullPath = $targetDir . "1" . $fileName;
            }
            

            //move the file from its temporary place to the target file path and do that if only it is an image
            if($AnImage) {
                //if an error occured while trying to move the file so we set the target file to be the default image
                if(move_uploaded_file($_FILES["image"]["tmp_name"],$fullPath)) {
                    //file was moved succesfully
                }
                else {
                    //an error occured while trying to move the file so we set the target file to be the default image
                    $fullPath = $targetDir . "defaultWork.jpg";
                }
            }
        }
        //if there's an error whille uploading or the user didn't upload an image we set the default image
        else {
            $fullPath = $targetDir . "default.jpg";
        }

        $sql = "INSERT INTO event (title,description,start_date,created_by,branch_id,image_path)
                VALUES (?,?,?,?,?,?)";
            
        $stmt = mysqli_stmt_init($conn);

        //check if the preparing of the statent fails
        if(!mysqli_stmt_prepare($stmt,$sql)) {

            mysqli_close($conn);
            header("Location: ../event.php?error=sqlError");
            exit;
        }
        else {
            mysqli_stmt_bind_param($stmt,"sssiis",$eventTitle,$eventDesc,$eventDate,$_SESSION["userId"],$_SESSION["branchId"],$fullPath);
            mysqli_stmt_execute($stmt);

            header("Location: ../events.php?msg=success");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        header("Location: ../event.php?error=AccsessDenied");
        exit;
    }

?>