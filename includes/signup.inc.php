<?php

//making sure that the user got here by clicking the submit button and not by accessing the file path directly 
if (isset($_POST["signup"])) {
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "scouthub";
    $conn = "";

    //create a connection to the database 
    $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

    //check if the connection was successful
    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    }

    //get form data
    $fname = $_POST["firstname"];
    $midname = $_POST["midname"];
    $lastname = $_POST["lastname"];
    $gender = $_POST["gender"];
    $commission = $_POST["commission"];

    $fooj = $_POST["fooj"];
    $ring = $_POST["ring"];
    $branch_no = $_POST["group"];
    $rank = $_POST["rank"];

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $conf_password = $_POST["conf-password"];
    
    $branch_id = "";

    //SERVER SIDE VALIDATION check the data before inserting it into the database 
    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9._]*$/", $username)) {

        mysqli_close($conn);
        header("Location: ../signup.php?error=invalidUsernme");
        exit;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        mysqli_close($conn);
        header("Location: ../signup.php?error=invalidEmail");
        exit;
    } else if ($password != $conf_password) {

        mysqli_close($conn);
        header("Location: ../signup.php?error=pwdCheck");
        exit;
    } else {
        /* check if the username already exists */
        $sql = "SELECT username FROM user WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        //check if the preparing of sql statement fails
        if (!mysqli_stmt_prepare($stmt, $sql)) {

            mysqli_close($conn);
            header("Location: ../signup.php?error=serverError");
            exit;
        } 
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            //store the result we got from the database inside $stmt variable
            mysqli_stmt_store_result($stmt);
            //check how many rows we got as a result
            $resultCheck = mysqli_stmt_num_rows($stmt);
            //if we got 1 row returned it means that the username already exists
            if ($resultCheck > 0) {
                header("Location: ../signup.php?error=usertaken");
                exit;
            }
            //in case the username doesn't already exists 
            else {
                //check if the email already exists
                $sql = "SELECT email FROM user WHERE email=?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {

                    mysqli_close($conn);
                    header("Location: ../signup.php?error=serverError1");
                    exit;
                }
                else {
                    mysqli_stmt_bind_param($stmt,"s",$email);
                    mysqli_stmt_execute($stmt);
                    //store the result we got from the database inside $stmt variable
                    mysqli_stmt_store_result($stmt);
                    //check how many rows we got as a result
                    $resultCheck = mysqli_stmt_num_rows($stmt);
                    //if we got 1 row returned it means that the email already exists
                    if($resultCheck > 0) {

                        mysqli_close($conn);
                        header("Location: ../signup.php?error=emailtaken");
                        exit;
                    }
                    //if email and username both are not already exists in the database then we insert the data
                    else {

                        //first we get the branch id based on waht the user entered for com,foj,ring,branch
                        $sql1 = "SELECT branch_id FROM branch AS a1 INNER JOIN ring AS a2 ON a1.ring_id = a2.ring_id
                                INNER JOIN fooj as a3 ON a2.fooj_id = a3.fooj_id INNER JOIN commission as a4 ON a3.com_id = a4.com_id 
                                WHERE branch_no = ? AND ring_name = ? AND fooj_name = ? AND com_name = ?";

                        $stmt1 = mysqli_stmt_init($conn);
                        //check if preparing of sql statment fails
                        if(!mysqli_stmt_prepare($stmt1,$sql1)) {

                            mysqli_close($conn);
                            header("Location: ../signup.php?error=UnableToPrepareStmtToGetBranchId");
                            exit;
                        }
                        else {
                            mysqli_stmt_bind_param($stmt1,"isss",$branch_no,$ring,$fooj,$commission);
                            mysqli_stmt_execute($stmt1);
                            $result = mysqli_stmt_get_result($stmt1);

                            $row = mysqli_fetch_assoc($result);
                            //if we didn't get a result return to the signup page
                            if(!$row) {

                                mysqli_close($conn);
                                header("Location: ../signup.php?error=unableToGetBranchId");
                                exit;
                            }
                            else {
                                $branch_id = $row["branch_id"];
                            }
                        }

                        //insert the user data
                        $sql = "INSERT INTO user (username, password, fname, midname, lastname, branch_id, rank, email,gender)
                        VALUES (?,?,?,?,?,?,?,?,?)";
                        $stmt = mysqli_stmt_init($conn);
                        //check if preparing of sql statement fails
                        if (!mysqli_stmt_prepare($stmt, $sql)) {

                            mysqli_close($conn);
                            header("Location: ../signup.php?error=UnableToPrepareToInsertUserData");
                            exit;
                        } 
                        else {

                            //hash the password
                            $hashed_passowrd = password_hash($password, PASSWORD_DEFAULT);

                            mysqli_stmt_bind_param($stmt, "sssssisss", $username, $hashed_passowrd, $fname, $midname, $lastname, $branch_id, $rank, $email,$gender);
                            mysqli_stmt_execute($stmt);

                            session_start();
                            $_SESSION["userId"] = mysqli_insert_id($conn);
                            $_SESSION["username"] = $username;
                            $_SESSION["rank"] = $rank;
                            $_SESSION["branchId"] = $branch_id;

                            //direct the user to the main page
                            header("Location: ../main.php");
                        }
                    }

                }

            }
        }
    }

    //close the statement and the connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else {
    header("Location: ../signup.php");
    exit;
}
