<?php
    session_start();

    if(!$_SESSION["userId"]) {
        header("Location: ./index.php?error=accesesDenied");
        exit;
    }

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


    //retrieve user data
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

        mysqli_close($conn);
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
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعلانات</title>
    <link rel="stylesheet" href="style/announcements-style.css">
    <script src="js/announcements-script.js"></script>
</head>
<body>
    <nav class="navbar">
        <a href="main.php"><img src="Images/ScoutHub_1.svg" alt="logo" width="150px" height="50px" class="logo"></a>
        <ul class="links">
            <li><a href="main.php">الصفحة الرئيسية</a></li>
            <li><a href="announcements.php" style="opacity:1">الإعلانات</a></li>
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

    <div class="ann-header-div">
        <p class="ann-header"><span class="main-header"><a href="main.php">الرئيسية</a> </span><span class="page-header">> الإعلانات</span></p>
    </div>

    <?php
        //show (create new announcement) only to the leaders
        if($rank == "قائد") 
            echo '
                <div class="new-ann-div">
                    <button id="create-ann">اخبرنا بما تريد الإعلان عنه...</button>
                </div>';
    ?>

    <!-- the branch announcements -->
    <div class="container" id="announcements">
        <?php 
            $sql1 = "SELECT * FROM announcement WHERE deleted = 0 AND branch_id = ? ORDER BY created_at DESC";
            $stmt1 = mysqli_stmt_init($conn);
            //check if preparing the statment fails
            if(!mysqli_stmt_prepare($stmt1,$sql1)) {

                mysqli_close($conn);
                header("Location: ./profile.php?error=sqlError");
                exit;
            }
            else {
                mysqli_stmt_bind_param($stmt1,"i",$branch_id);
                mysqli_stmt_execute($stmt1);
                $result = mysqli_stmt_get_result($stmt1);

                $rowNoAnn = mysqli_num_rows($result);

                //get the announcements records (rows) and display them
                while($row = mysqli_fetch_assoc($result)) {
                    //change the padding of the container to fill up the space left out by the three dots
                    if($rank == "قائد")
                        echo '<div class="ann-container" style="padding:5px 0 10px 0">';
                    else 
                        echo '<div class="ann-container" style="padding:10px 0 10px 0">';

                    if($rank == "قائد")
                        echo '<div class="ann-menu-btn">
                             <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  width="800px" height="800px" viewBox="0 0 342.382 342.382" xml:space="preserve"><g><g><g><path d="M45.225,125.972C20.284,125.972,0,146.256,0,171.191c0,24.94,20.284,45.219,45.225,45.219 c24.926,0,45.219-20.278,45.219-45.219C90.444,146.256,70.151,125.972,45.225,125.972z"/></g><g><path d="M173.409,125.972c-24.938,0-45.225,20.284-45.225,45.219c0,24.94,20.287,45.219,45.225,45.219 c24.936,0,45.226-20.278,45.226-45.219C218.635,146.256,198.345,125.972,173.409,125.972z"/></g><g><path d="M297.165,125.972c-24.932,0-45.222,20.284-45.222,45.219c0,24.94,20.29,45.219,45.222,45.219 c24.926,0,45.217-20.278,45.217-45.219C342.382,146.256,322.091,125.972,297.165,125.972z"/></g></g></g></svg>
                        </div>';
                    echo '<div class="ann-menu">
                             <ul>
                                <li id="delete-option" class="delete-option" ><a href="#" data-ann-id="'. $row["ann_id"] .'">حذف</a></li>
                                <li id="edit-option" class="edit-option"><a href="#" data-ann-title ="'. $row["title"] . '" data-ann-description="'. $row["description"] . '" data-ann-id="'. $row["ann_id"] .'">تعديل</a></li>
                             </ul>
                         </div>';
                    echo '<div class="ann-text">
                            <p class="created-at">'. $row['created_at'] .'</p>
                            <h3>' . $row["title"] .'</h3>
                            <p>' . $row["description"] . '</p>';
                    echo '</div>';
                    echo "</div>"; //closing tag for announcement container
                }
                //in case there's no announcements to show
                if($rowNoAnn == 0) {
                    echo '<h3 class="no-ann-text">لا يوجد إعلانات حاليًا</h3>';
                }
            }

            //close the connection with the database 
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        ?>
    </div>

    <!-- cancel/confrim delete pop-up-->
    <div class="pop-up" id="pop-up-deletion">
        <div class="pop-up-inner" id="delete-inner">
            <img src="Images/exclamation-256.png" alt="exclamtion mark icon" width="64" height="64">
            <p>هل أنت متأكد أنك تريد حذف هذا الإعلان!</p>
            <a href="#" id="cancel-delete" class="conf-btns">إالغاء</a>
            <a href="#" id="conf-delete" class="conf-btns">حذف</a>
        </div>
    </div>

    <!--Create new announcement pop up form-->
    <div class="pop-up-create" id="pop-up-create">
        <div class="wrapper" id="wrapper">
            <div class="header">
                <h3>إنشاء إعلان</h3>
            </div>
            <p id="error">‎</p>
            <br>

            <form action="includes/announcement.inc.php" method="post" id="myForm" enctype="multipart/form-data">
                <label for="title" style="display: inline">العنوان :<span style="color:red">*</span></label>
                <div class="input-box">
                    <input type="text" name="title" id="title">
                </div>
                <label for="description">الوصف :<span style="color:red">*</span></label>
                <br>
                <div class="text-area">
                    <textarea name="description" id="description" name="description"></textarea>
                </div>

                <div class="buttons">
                    <button type="submit" class="create-btn" id="create-btn" name="create-ann">إنشاء</button>
                    <button type="button" class="cancel-btn" id="cancel">إالغاء</button>
                </div>
            </form>
        </div>
    </div>

    <!--edit announcement pop up form-->
    <div id="pop-up-edit" class="pop-up-edit">
            <div class="wrapper" id="wrapper2">
                <div class="header">
                    <h3>تعديل التفاصيل</h3>
                </div>
                <p id="error1">‎</p>
                <br>

                <form action="includes/announcement.edit.inc.php" method="post" id="myForm2" enctype="multipart/form-data">
                    <!--dummy feild to pass the announcement id to the back end-->
                    <input type="text" style="display:none" hidden name="ann-id" id="ann-id">

                    <label for="title" style="display: inline">العنوان :<span style="color:red">*</span></label>
                    <div class="input-box">
                        <input type="text" name="title2" id="title2">
                    </div>
                    <label for="description2">الوصف :<span style="color:red">*</span></label>
                    <br>
                    <div class="text-area">
                        <textarea id="description2" name="description2"></textarea>
                    </div>

                    <div class="buttons">
                        <button type="submit" class="edit-btn" id="edit-btn" name="edit-ann">تعديل</button>
                        <button type="button" class="cancel-btn" id="cancel-edit-btn">إالغاء</button>
                    </div>
                </form>
            </div>
    </div>

</body>
</html>