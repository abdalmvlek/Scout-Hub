<?php 
    if(isset($_POST["edit-work"])) {
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

        //store the event image
        $targetDir = "uploads/";
        $fullPath = "";
        $AnImage = true;
        $oldImagePath = $_POST["old-image-path"];

        //check if the file (image) was uploaded without errors
        if(isset($_FILES["image2"]) && $_FILES["image2"]["error"] == UPLOAD_ERR_OK) {
            //check if the file is an image
            $check = getimagesize($_FILES["image2"]["tmp_name"]);
            if($check == false) {
                $AnImage = false;
            }


            $fileName = basename($_FILES["image2"]["name"]);   
            
            $fullPath = $targetDir . $fileName;   

            //check if the file name already exists and if so change it to be unique
            if(file_exists($fullPath)) {
                //add 1 before the existing file name to make it unique
                $fullPath = $targetDir . "1" . $fileName;
            }
            

            //move the file from its temporary place to the target file path and do that if only it is an image
            if($AnImage) {
                if(move_uploaded_file($_FILES["image2"]["tmp_name"],$fullPath)) {
                    //file was moved succesfully
                }
                else {
                    //an error occured while trying to move the file so we set the target file to be the old image
                    $fullPath = $oldImagePath;
                }
            }
        }
        //if there's an error whille uploading or the user didn't upload an image we set the old image
        else {
            $fullPath = $oldImagePath;
        }


        $title = $_POST["title2"];
        $description = $_POST["description2"];
        $startDate = $_POST["date2"];
        $workId = $_POST["work-id"];


        $sql = "UPDATE volunteerwork SET title = ?, description = ?, start_date = ?, image_path = ? WHERE work_id = ?";
        $stmt = mysqli_stmt_init($conn);
        //check if the preparing if statment failed
        if(!mysqli_stmt_prepare($stmt,$sql)) {

            mysqli_close($conn);
            header("Location: ../volunteerWork.php?error=sqlError");
            exit;
        }
        else {
            mysqli_stmt_bind_param($stmt,"ssssi",$title,$description,$startDate,$fullPath,$workId);
            mysqli_stmt_execute($stmt);

            header("Location: ../volunteerWork.php");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        header("Location: ../volunteerWork.php?error=accesesDenied");
    }
?>