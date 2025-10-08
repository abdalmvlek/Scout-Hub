<?php

    session_start();

    if(isset($_GET['workId'])) {            
        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "scouthub";
        $conn = "";

        //create connection to the database
        $conn = new mysqli($db_server,$db_user,$db_pass,$db_name);

        //check if the connection was successful
        if ($conn->connect_error) {
            die('Connection Faild : ' . $conn->connect_error);
        }


        //retrieve event data for the user branch
        $fname = "";
        $midname = "";
        $lastname = "";
        $branch_id = "";
        $rank = "";
        $email = "";
        $gender = "";


        $sql = "SELECT * FROM user WHERE username =?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ./main.php?error=sqlerror");
            exit;
        }
        else {
            mysqli_stmt_bind_param($stmt,"s",$_SESSION["username"]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            //get the record with the given username
            if($row = mysqli_fetch_assoc($result)) {
                $fname = $row["fname"];
                $midname = $row["midname"];
                $lastname = $row["lastname"];
                $branch_id = $row["branch_id"];
                $rank = $row["rank"];
                $email = $row["email"];
                $gender = $row["gender"];
            }
        }
    }
    else {
        header("Location: ./events.php?error=accessesDenied");
    }

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأنشطة</title>
    <link rel="stylesheet" href="style/memebers-registered-style.css">
</head>

<body>
    <nav class="navbar">
        <a href="main.php"><img src="Images/ScoutHub_1.svg" alt="logo" width="150px" height="50px" class="logo"></a>
        <ul class="links">
            <li><a href="main.php">الصفحة الرئيسية</a></li>
            <li><a href="announcements.php">الإعلانات</a></li>
            <li><a href="events.php">الأنشطة</a></li>
            <li><a href="volunteerWork.php" style="opacity: 1">الأعمال التطوعية</a></li>
        </ul>
        <!--Showing the account icon based on gender-->
        <ul class="icon-ul">
            <?php 
                if($gender == "ذكر") 
                    echo '<a href="profile.php"><img class="accountIcon" src="Images/bs_icon2.png" alt="accountIcon"></a>';
                else if($gender == "انثى") 
                    echo '<a href="profile.php"><img class="accountIcon" src="Images/bs_icon_hijab3png.png" alt="accountIcon"></a>';
            ?>
        </ul>
    </nav>

    <div class="memebers-header-div">
        <p class="memebers-header"><span class="main-header"><a href="main.php">الرئيسية</a> </span><span class="page-header">> <a href="./volunteerWork.php">الأعمال التطوعية</a></span><span class="page2-header"> > الاعضاء المسجلين</span></p>
    </div>
    <br>
    <hr style="width:60%">


    <?php

        function convertNumToWord($num) {
            $words = ["الاولى","الثانية","الثالثة","الرابعة","الخامسة","السادسة",
                        "السابعة","الثامنة","التاسعة","العاشرة"];    
            return $words[$num - 1];
        }

        //select the branch data
        $sql = "SELECT branch_no,ring_name,fooj_name,com_name FROM branch AS a1 INNER JOIN ring AS a2 
            ON a1.ring_id = a2.ring_id INNER JOIN fooj AS a3 ON a2.fooj_id = a3.fooj_id 
            INNER JOIN commission AS a4 ON a3.com_id = a4.com_id WHERE branch_id = " . $_SESSION['branchId'];
        $result = mysqli_query($conn,$sql);

        $row = mysqli_fetch_assoc($result);
        if($row > 0) {
            echo '<div class="branch-header header">
                    <h1>الفرقة '. convertNumToWord($row['branch_no']) .' '. $row['ring_name'] . ' فوج ' . $row['fooj_name'] .'</h1>
                </div>';
        }
        

        //select the event data
        $sql2 = 'SELECT * FROM volunteerwork WHERE work_id=' . $_GET['workId'];
        $result2 = mysqli_query($conn,$sql2);

        $row2 = mysqli_fetch_assoc($result2);
        if($row2 > 0) {
            echo '<div class="title-header haeder">
                    <h3>اسم المبادرة: ' . $row2['title'] . '</h3>
                    <h3>رقم المبادرة: ' . $row2['work_id'] . '</h3>
                  </div>';
        }   

        //select the memebers regietered in the event
        $sql3 = 'SELECT fname, midname, lastname,email FROM volunteer_registration as ev INNER JOIN user as us on ev.user_id = us.id WHERE work_id = ' . $_GET['workId'];
        $result3 = mysqli_query($conn,$sql3);

        $noRows3 = mysqli_num_rows($result3);
        if($noRows3 > 0) {
            echo '<table>
                    <tr>
                        <th>اسم العضو</th>
                        <th>البريد الالكتروني</th>
                    </tr>';
            while($row3 = mysqli_fetch_assoc($result3)) {
                echo '<tr>
                        <td>' . $row3['fname'] .' '. $row3['midname'] . ' ' . $row3['lastname'] . '</td>
                        <td>'. $row3['email'] .'</td>
                    </tr>';
            }
        }
        else {
            echo '<h3 class="no-memebers-text">لا يوجد اعضاء مسجلين حتى هذه اللحظة</h3>';
        }

    ?>

</body>

</html>