<?php 
    if(isset($_POST["login"])) {
        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "scouthub";
        $conn = "";
    
        //create a connection to the database
        $conn = new mysqli($db_server,$db_user,$db_pass,$db_name);

        //check if the connection was successful
        if($conn->connect_error) {
            die('Connection Faild : ' . $conn->connect_error);
        }

        
        //get form data
        $nameEmail = $_POST["usernameEmail"];
        $password = $_POST["password"];


        $sql = "SELECT * FROM user WHERE BINARY username=? OR email=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {

            mysqli_close($conn);
            header("Location: ../login.phpl?error=sqlerror");
            exit;
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss",$nameEmail, $nameEmail);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            //Get the row with user/email selected from the database
            if($row = mysqli_fetch_assoc($result)) {
                //check if the password is correct
                $passwordCheck = password_verify($password,$row["password"]);
                if($passwordCheck) {
                    session_start();
                     $_SESSION["userId"] = $row["id"];
                     $_SESSION["username"] = $row["username"];
                     $_SESSION["rank"] = $row["rank"];
                     $_SESSION["branchId"] = $row["branch_id"];
                     
                     header("Location: ../main.php");
                } 
                else {
                    header("Location: ../login.php?error=wrongPassword");
                }
            }
            else {
                header("Location: ../login.php?error=nouser");
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        header("Location: ../index.html?error=AccessDenied");
        exit;
    }

?>