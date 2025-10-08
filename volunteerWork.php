<?php
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

    session_start();

    if (!$_SESSION["userId"]) {
        header("Location: ./index.php?error=accessesDenied");
        exit;
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

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأعمال التطوعية</title>
    <link rel="stylesheet" href="style/volunteerWork-style.css">
    <script src="js/volunteerWork-scritpt.js"></script>
    <!--<script src="./js/jquery-3.7.1.min.js"></script>-->
</head>

<body>
    <nav class="navbar">
        <a href="main.php"><img src="Images/ScoutHub_1.svg" alt="logo" width="150px" height="50px" class="logo"></a>
        <ul class="links">
            <li><a href="main.php">الصفحة الرئيسية</a></li>
            <li><a href="announcements.php">الإعلانات</a></li>
            <li><a href="events.php">الأنشطة</a></li>
            <li><a href="volunteerWork.php" style="opacity:1">الأعمال التطوعية</a></li>
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

    <div class="works-header-div">
        <p class="works-header"><span class="main-header"><a href="main.php">الرئيسية</a> </span><span class="page-header">> الأعمال التطوعية</span></p>
    </div>

    <!--creating new event (only visible for leaders)-->   
        <?php
            if($rank == "قائد") {
                echo '<div class="new-volunteer-div">
                        <button type="button" id="new-volunteer-btn">انشاء مبادرة تطوعية...</button>
                    </div>';
                }
        ?>
    </div>

    <!--the branch events-->
    <div class="container" id="volunterworks"> 
        <?php 
            $sql1 = "SELECT * FROM volunteerwork WHERE start_date >= CURDATE() AND deleted = 0 AND branch_id = ? ORDER BY start_date ASC";
            $stmt1 = mysqli_stmt_init($conn);
            //check if preparing the statment fails
            if(!mysqli_stmt_prepare($stmt1,$sql1)) {
                header("Location: ./profile.php?error=sqlError");
                exit;
            }
            else {
                mysqli_stmt_bind_param($stmt1,"i",$branch_id);
                mysqli_stmt_execute($stmt1);
                $result = mysqli_stmt_get_result($stmt1);

                $row_no = mysqli_num_rows($result);

                //get the events records (rows) and display them
                while($row = mysqli_fetch_assoc($result)) {

                    //check if the user is registered in this event or not
                    $sql2 = "SELECT * FROM volunteer_registration WHERE user_id = ". $_SESSION["userId"] . " AND work_id =" . $row["work_id"];
                    //exexcute the query
                    $result2 = mysqli_query($conn,$sql2);

                    $no_rows = mysqli_num_rows($result2);

                    echo '<div class="work-container">';
                    if($rank == "قائد")
                        echo '<div class="work-menu-btn">
                             <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  width="800px" height="800px" viewBox="0 0 342.382 342.382" xml:space="preserve"><g><g><g><path d="M45.225,125.972C20.284,125.972,0,146.256,0,171.191c0,24.94,20.284,45.219,45.225,45.219 c24.926,0,45.219-20.278,45.219-45.219C90.444,146.256,70.151,125.972,45.225,125.972z"/></g><g><path d="M173.409,125.972c-24.938,0-45.225,20.284-45.225,45.219c0,24.94,20.287,45.219,45.225,45.219 c24.936,0,45.226-20.278,45.226-45.219C218.635,146.256,198.345,125.972,173.409,125.972z"/></g><g><path d="M297.165,125.972c-24.932,0-45.222,20.284-45.222,45.219c0,24.94,20.29,45.219,45.222,45.219 c24.926,0,45.217-20.278,45.217-45.219C342.382,146.256,322.091,125.972,297.165,125.972z"/></g></g></g></svg>
                        </div>';
                    echo '<img src="includes/' . $row["image_path"] . '" alt="event image" width="350px" height="225px">';
                    echo '<div class="work-menu">
                             <ul>
                                <li id="delete-option" class="delete-option" ><a href="#" data-work-id="'. $row["work_id"]. '">حذف</a></li>
                                <li id="edit-option" class="edit-option"><a href="#" data-work-id="'. $row["work_id"] .'" data-work-title="'. $row["title"] .'" data-work-description="'. $row["description"] .'" data-work-startdate="'. $row["start_date"] .'" data-work-image="'. $row["image_path"] .'">تعديل</a></li>
                             </ul>
                         </div>';
                    echo '<div class="work-text">
                            <h3>' . $row["title"] .'</h3>
                            <p class="start-date">' . $row["start_date"] . '</p>
                            <p class="work-description">' . $row["description"] . '</p>
                            <a href="#" class="read-more">اقرأ المزيد</a>';
                    if($rank == "عضو") {
                        if($no_rows > 0)
                            echo '<br>
                                <div style="display:flex; margin-top: 10px">
                                <span>تم التسجيل</span>
                                <img class="green-check-mark" src="Images/green_checkmark_icon1.png" alt="green check-mark" width="28px" height="28px">
                                <button type="button" id="cancel-register-btn" class="register-cancel-btn" data-work-id="'.$row["work_id"] . '">إالغاء التسجيل</button>
                                </div>';
                        else
                            echo '<br><div style="margin-top:10px;"><button type="button" id="work-register-btn" data-work-id="'.$row["work_id"] . '">تـطـوع الأن</button></div>';
                    } 
                    else {
                        echo '<br><div style="margin-top:10px;" data-work-id="'.$row["work_id"] . '"><button type="button" id="work-show-registers" class="work-show-registers">عرض المسجلين</button></div>';
                    }
                    

                    echo '</div>';
                    echo "</div>"; //closing tag for event container
                }
                //in case there's no events to show
                if($row_no == 0) {
                    echo '<h3 class="no-works-text">لا يوجد أعمال تطوعية حاليًا</h3>';
                }
            }
            //close the connection to the datebase 
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        ?>
    </div>

    <!-- cancel/confirm cancel registration -->
     <div class="pop-up" id="pop-up-cancel-reg">
        <div class="pop-up-inner" id="cancel-register-inner">
            <img src="Images/calendar_cross_icon2.png" alt="a calendar with a cross on it" width="64" height="64">
            <p>هل أنت متأكد من أنك تريد إالغاء تطوعك بهذا العمل</p>
            <a href="#" id="no-cancel-reg" class="conf-btns">لا</a>
            <a href="#" id="yes-cancel-reg" class="conf-btns">نعم</a>
        </div>
     </div>

    <!-- cancel/confrim confirm registration -->
     <div class="pop-up" id="pop-up-reg">
            <div class="pop-up-inner" id="register-inner">
                <img src="Images/green_checkmark_icon1.png" alt="a calnder with a check mark on it" width="100" height="100">
                <p>تم تسجيلك كمتطوع في هذا العمل</p>
                <!--<a href="#" id="cancel-reg" class="conf-btns">إالغاء</a>
                <a href="#" id="conf-reg" class="conf-btns">تسجيل</a> -->
            </div>
     </div>
    
    <!-- cancel/confrim delete pop-up-->
    <div class="pop-up" id="pop-up-deletion">
        <div class="pop-up-inner" id="delete-inner">
            <img src="Images/exclamation-256.png" alt="exclamtion mark icon" width="64" height="64">
            <p>هل أنت متأكد أنك تريد حذف هذاالعمل التطوعي!</p>
            <a href="#" id="cancel-delete" class="conf-btns">إالغاء</a>
            <a href="#" id="conf-delete" class="conf-btns">حذف</a>
        </div>
    </div>

    <!--Create new event pop up form-->
    <div class="pop-up-create" id="pop-up-create">
        <div class="wrapper" id="wrapper">
            <div class="header">
                <h3>إنشاء مبادرة</h3>
            </div>
            <p id="error">‎</p>

            <form action="includes/volunteer.inc.php" method="post" id="myForm" enctype="multipart/form-data">
                <label for="title" style="display: inline">العنوان :<span style="color:red">*</span></label>
                <div class="input-box">
                    <input type="text" name="title" id="title">
                </div>
                <label for="description">الوصف :<span style="color:red">*</span></label>
                <br>
                <div class="text-area">
                    <textarea name="description" id="description" name="description"></textarea>
                </div>

                <div class="date-and-file">
                    <div class="date-group">
                        <label for="date">تاريخ البدء :<span style="color:red">*</span></label>
                        <div class="date-field">
                            <input type="date" id="date" name="date" min="">
                        </div>
                    </div>
                    <div class="file-group" id="upload-file-div">
                        <label for="file-input" class="file-caption" id="photo-selected">صورة مرفقة</label>
                        <label for="file-input" class="file-caption active" id="choose-photo">إرفاق صورة</label>
                        <div class="file-field">
                            <input type="file" id="file-input" accept="image/*" style="display:none" name="image">
                            <label for="file-input" class="upload-photo">
                                <img src="./Images/upload-image2.png" alt="upload-photo-icon">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit" class="create-btn" id="create-btn" name="create-volunteerwork">إنشاء</button>
                    <button type="button" class="cancel-btn" id="cancel">إالغاء</button>
                </div>
            </form>
        </div>
    </div>


    <!--edit event pop up form-->
    <div id="pop-up-edit" class="pop-up-edit">
            <div class="wrapper" id="wrapper2">
                <div class="header">
                    <h3>تعديل التفاصيل</h3>
                </div>
                <p id="error1">‎</p>

                <form action="includes/volunteer.edit.inc.php" method="post" id="myForm2" enctype="multipart/form-data">
                    <!--dummy feild to pass the event id to the back end-->
                    <input type="text" style="display:none" hidden name="work-id" id="work-id">
                    <!--dummy field to pass the exsiting iamge path--> 
                    <input type="text" style="display:none" hidden name="old-image-path" id="old-image-path">

                    <label for="title" style="display: inline">العنوان :<span style="color:red">*</span></label>
                    <div class="input-box">
                        <input type="text" name="title2" id="title2">
                    </div>
                    <label for="description2">الوصف :<span style="color:red">*</span></label>
                    <br>
                    <div class="text-area">
                        <textarea id="description2" name="description2"></textarea>
                    </div>

                    <div class="date-and-file">
                        <div class="date-group">
                            <label for="date">تاريخ البدء :<span style="color:red">*</span></label>
                            <div class="date-field">
                                <input type="date" id="date2" name="date2" min="">
                            </div>
                        </div>
                        <div class="file-group" id="upload-file-div2">
                            <label for="file-input2" class="file-caption" id="photo-selected2">صورة مرفقة</label>
                            <label for="file-input2" class="file-caption active" id="choose-photo2">إرفاق صورة</label>
                            <div class="file-field">
                                <input type="file" id="file-input2" accept="image/*" style="display:none" name="image2">
                                <label for="file-input2" class="upload-photo">
                                    <img src="./Images/upload-image2.png" alt="upload-photo-icon">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="submit" class="edit-btn" id="edit-btn" name="edit-work">تعديل</button>
                        <button type="button" class="cancel-btn" id="cancel-edit-btn">إالغاء</button>
                    </div>
                </form>
            </div>
    </div>


</body>

</html>