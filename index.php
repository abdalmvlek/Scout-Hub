<?php

    session_start();

    if(isset($_SESSION["userId"])) {
        header("Location: ./main.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoutHub</title>
    <link rel="stylesheet" href="style/Index-style.css">
</head>
<body>
    <nav class="navbar">
        <a href="index.php"><img src="Images/ScoutHub_1.svg" alt="logo" width="150px" height="50px"></a>
        <ul>
            <li><a href="signup.php" class="signup">التسجيل</a></li>
            <li><a href="login.php" class="login">تسجيل الدخول</a></li>
        </ul>
    </nav>


    
    <div class="hero">
        <img src="images/purple_tent_illustration_png.png" alt="image of a tent" height="360" width="540">
        <h3>
            <span>هنا تبدأ كل خطوة نحو نشاط  كشفي منظم ومميز</span>
            <span>سجّل معنًا وكن على اطلاع دائم بما هو قادم.</span>
        </h3>
    </div>
    

</body>
</html>