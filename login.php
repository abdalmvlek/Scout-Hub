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
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="style/signup_login-style.css">
    <script src="js/login-script.js"></script>
</head>
<body>
    <nav class="navbar">
        <a href="index.php"><img src="Images/ScoutHub_1.svg" alt="logo" width="150px" height="50px"></a>
    </nav>
    <div class="wrapper" id="login-wrapper">
        <h1>تسجيل الدخول</h1>
        <form action="includes/login.inc.php" method="post" id="login-form"> 
            <div class="input-box" id="nameEmail-div">
                <input type="text" onfocus="Focused('nameEmail-div')" onblur="Blured('nameEmail-div')" placeholder="اسم المستخدم/البريد الالكتروني" name="usernameEmail" id="usernameEmail">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
                </svg>
            </div>
            <div class="input-box" id="password-div" style="margin-bottom: 10px;">
                <input type="password" onfocus="Focused('password-div')" onblur="Blured('password-div')" placeholder="كلمة المرور" name="password" id="password">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
                </svg>
            </div>

            <p id="error" >‎</p>

            <input type="submit" id="login" name="login" class="btn" value="تسجيل الدخول">

            <div class="register">
                <p>ليس لديك حساب؟ <a href="signup.php">سجل الأن</a></p>
            </div>

        </form>
    </div>
</body>
</html>