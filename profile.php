<?php
    session_start();

    if(!$_SESSION["userId"]) {
        header("Location: ./index.php?error=acessesDenied");
        exit;
    }

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "scouthub";
    $conn = "";

    //create a connection to the database
    $conn = new mysqli($db_server,$db_user,$db_pass,$db_name);
    
    //check if the connection was successful
    if ($conn->connect_error) {
        die('Connection Faild : ' . $conn->connect_error);
    }
    

    //retrieve user data to use it later in the page
    $username = "";
    $fname = "";
    $midname = "";
    $lastname = "";
    $commission = "";
    $fooj = "";
    $ring = "";
    $branch_no = "";
    $branch_id = "";
    $rank = "";
    $email = "";
    $gender = "";

    $sql = "SELECT * FROM user WHERE username =?";
    $stmt = mysqli_stmt_init($conn);
    //check if preparing the statment fails
    if(!mysqli_stmt_prepare($stmt,$sql)) {

        mysqli_close($conn);
        header("Location: ./main.php?error=sqlerror");
        exit;
    }
    else {
        mysqli_stmt_bind_param($stmt,"s",$_SESSION["username"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        //get the record with the given username
        if(!$row) {

            mysqli_close($conn);
            header("Location: ./main.php?error=mainDataError");
            exit;
        }
        else {
            $username = $row["username"];
            $fname = $row["fname"];
            $midname = $row["midname"];
            $lastname = $row["lastname"];
            $branch_id = $row["branch_id"];
            $rank = $row["rank"];
            $email = $row["email"];
            $gender = $row["gender"];
        }
    }

    $sql1 = "SELECT branch_no,ring_name,fooj_name,com_name FROM branch AS a1 INNER JOIN ring AS a2 
                ON a1.ring_id = a2.ring_id INNER JOIN fooj AS a3 ON a2.fooj_id = a3.fooj_id 
                INNER JOIN commission AS a4 ON a3.com_id = a4.com_id WHERE branch_id = ?";
    $stmt1 = mysqli_stmt_init($conn);
    //check if preparing the statment fails
    if(!mysqli_stmt_prepare($stmt1,$sql1)) {

        mysqli_close($conn);
        header("Location: ./main.php?error=sqlError");
        exit;
    }
    else {
        mysqli_stmt_bind_param($stmt1,"i",$branch_id);
        mysqli_stmt_execute($stmt1);

        $result = mysqli_stmt_get_result($stmt1);
        $row = mysqli_fetch_assoc($result);
        if(!$row) {

            mysqli_close($conn);
            header("Location: ./main.php?error=mainDataError");
            exit;
        }
        else {
            $branch_no = $row["branch_no"];
            $ring = $row["ring_name"];
            $fooj = $row["fooj_name"];
            $commission = $row["com_name"];
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي</title>
    <link rel="stylesheet" href="style/profile.css">
    <script src="js/profile-script.js"></script>
</head>
<body>
    <nav class="navbar">
        <a href="main.php"><img src="Images/ScoutHub_1.svg" alt="logo" width="150px" height="50px" class="logo"></a>
        <ul class="links">
            <li><a href="main.php">الصفحة الرئيسية</a></li>
            <li><a href="announcements.php">الإعلانات</a></li>
            <li><a href="events.php">الأنشطة</a></li>
            <li><a href="volunteerWork.php">الأعمال التطوعية</a></li>
        </ul>
        <ul class="icon-ul">
            <?php
                if($gender == "ذكر")
                    echo '<a href="profile.php"><img class="accountIcon" src="Images/bs_icon2.png" alt="accountIcon"></a>';
                else if($gender == "انثى") 
                    echo '<a href="profile.php"><img class="accountIcon" src="Images/bs_icon_hijab3png.png" alt="accountIcon"></a>';
            ?>
        </ul>
    </nav>
    <div class="container">
        <div id="side-bar">
            <div id="scout-info" class="side-info info-selected">معلومات الكشاف</div>
            <div id="account-info" class="side-info">معلومات الحساب</div>
            <div class="logout"><a href="./includes/logout.inc.php" id="logout-btn">تسجيل الخروج</a></div>
        </div>
        <div id="main-side">
                <div id="scout-main" class="main-info active">
                    <?php
                        if($gender == "ذكر") 
                            echo '<img src="./Images/bs_icon2.png" alt="account-img" width="200px" height="200px">';
                        else if($gender == "انثى") 
                            echo '<img src="./Images/bs_icon_hijab3png.png" alt="account-img" width="200px" height="200px">'
                    ?>
                    <div id="wrapper">
                        <?php
                            echo '<div id="full-name" class="text-content" style="display:inline">الاسم : ' . $fname . " " . $midname . " " . $lastname . '</div><br>';
                            echo '<div id="rank" class="text-content" style="display: inline">المفوضية : ' . $commission . '</div><br>';
                            echo '<div id="rank" class="text-content" style="display: inline">الفوج : ' . $fooj . '</div><br>';
                            echo '<div id="rank" class="text-content" style="display: inline">الحلقة : ' . $ring . '</div><br>';
                            echo '<div id="rank" class="text-content" style="display: inline">رقم الفرقة : ' . $branch_no . '</div><br>';
                            echo '<div id="rank" class="text-content" style="display: inline">الرتبة : ' . $rank . '</div>';
                        ?>
                    </div>
                </div>
                <div id="account-main" class="main-info">
                    <?php
                        if($gender == "ذكر") 
                            echo '<img src="./Images/bs_icon2.png" alt="account-img" width="200px" height="200px">';
                        else if($gender == "انثى") 
                            echo '<img src="./Images/bs_icon_hijab3png.png" alt="account-img" width="200px" height="200px">'
                    ?>
                    <div id="wrapper2">
                            <?php 
                                echo '<div id="rank" class="text-content" style="display: inline">اسم المستخدم : ' . $username . '</div><br>';
                                echo '<div id="rank" class="text-content" style="display: inline">البريد الالكتروني : ' . $email . '</div><br>';
                            ?>
                    </div>
                </div>
        </div>
    </div>
</body>
</html>