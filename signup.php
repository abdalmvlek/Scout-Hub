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
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/signup_login-style.css">
    <title>التسجيل</title>
    <script defer src="js/signup-script.js"></script>
</head>

<body>
    <nav class="navbar">
        <a href="index.php"><img src="Images/ScoutHub_1.svg" alt="logo" width="150px" height="50px"></a>
    </nav>


    <div class="wrapper">
        <div class="header">
            <h1 class="reg-h1">التسجيل</h1>
        </div>
        <form action="includes/signup.inc.php" method="post" name="myform" id="multiStepForm">        
            
            <!-- Step 1 -->
            <div class="step active">
                <div class="input-box" id="firstname-div">
                    <input type="text" onfocus="Focused('firstname-div')" onblur="Blured('firstname-div')"
                        placeholder="الاسم الاول" name="firstname" id="fname">
                        <svg xmlns="http://www.w3.org/2000/svg" width="682.7" height="682.7" version="1.0" viewBox="0 0 512 512"><path d="M154 60c-27 6-50 25-60 49-5 12-6 20-6 35 1 11 1 14 4 22 8 22 22 38 43 49 12 5 19 7 35 7s22-2 36-8c16-9 29-21 37-37 5-12 7-19 8-33 2-37-21-70-59-82-5-2-9-2-20-3l-18 1zM357 101c-9 3-12 9-12 18 1 8 4 13 10 16l70 2 72-1c6-1 10-4 13-9 3-6 2-14-1-19-6-8-1-8-79-8l-73 1zM355 198c-13 7-13 26 0 32 4 2 9 2 74 2 64 0 69 0 73-2s6-4 9-9c3-8 0-17-7-22l-3-3h-71c-67 0-72 0-75 2zM153 267A170 170 0 0 0 2 418c-3 21-1 30 9 34l159 1c153 0 155 0 159-2 8-4 10-10 9-27a169 169 0 0 0-185-157zM357 293c-9 2-12 8-12 18 1 7 4 12 10 15 3 1 7 2 74 2 66 0 70-1 73-2 8-4 12-14 9-23-1-5-7-10-12-11l-71-1c-55 0-68 0-71 2z"/></svg>
                </div>
                <div class="input-box" id="midname-div">
                    <input type="text" onfocus="Focused('midname-div')" onblur="Blured('midname-div')"
                        placeholder="اسم الأب" name="midname" id="midname">
                        <svg xmlns="http://www.w3.org/2000/svg" width="682.7" height="682.7" version="1.0" viewBox="0 0 512 512"><path d="M154 60c-27 6-50 25-60 49-5 12-6 20-6 35 1 11 1 14 4 22 8 22 22 38 43 49 12 5 19 7 35 7s22-2 36-8c16-9 29-21 37-37 5-12 7-19 8-33 2-37-21-70-59-82-5-2-9-2-20-3l-18 1zM357 101c-9 3-12 9-12 18 1 8 4 13 10 16l70 2 72-1c6-1 10-4 13-9 3-6 2-14-1-19-6-8-1-8-79-8l-73 1zM355 198c-13 7-13 26 0 32 4 2 9 2 74 2 64 0 69 0 73-2s6-4 9-9c3-8 0-17-7-22l-3-3h-71c-67 0-72 0-75 2zM153 267A170 170 0 0 0 2 418c-3 21-1 30 9 34l159 1c153 0 155 0 159-2 8-4 10-10 9-27a169 169 0 0 0-185-157zM357 293c-9 2-12 8-12 18 1 7 4 12 10 15 3 1 7 2 74 2 66 0 70-1 73-2 8-4 12-14 9-23-1-5-7-10-12-11l-71-1c-55 0-68 0-71 2z"/></svg>
                </div>
                <div class="input-box" id="lastname-div">
                    <input type="text" placeholder="اللقب" onfocus="Focused('lastname-div')"
                        onblur="Blured('lastname-div')" name="lastname" id="lastname">
                        <svg xmlns="http://www.w3.org/2000/svg" width="682.7" height="682.7" version="1.0" viewBox="0 0 512 512"><path d="M154 60c-27 6-50 25-60 49-5 12-6 20-6 35 1 11 1 14 4 22 8 22 22 38 43 49 12 5 19 7 35 7s22-2 36-8c16-9 29-21 37-37 5-12 7-19 8-33 2-37-21-70-59-82-5-2-9-2-20-3l-18 1zM357 101c-9 3-12 9-12 18 1 8 4 13 10 16l70 2 72-1c6-1 10-4 13-9 3-6 2-14-1-19-6-8-1-8-79-8l-73 1zM355 198c-13 7-13 26 0 32 4 2 9 2 74 2 64 0 69 0 73-2s6-4 9-9c3-8 0-17-7-22l-3-3h-71c-67 0-72 0-75 2zM153 267A170 170 0 0 0 2 418c-3 21-1 30 9 34l159 1c153 0 155 0 159-2 8-4 10-10 9-27a169 169 0 0 0-185-157zM357 293c-9 2-12 8-12 18 1 7 4 12 10 15 3 1 7 2 74 2 66 0 70-1 73-2 8-4 12-14 9-23-1-5-7-10-12-11l-71-1c-55 0-68 0-71 2z"/></svg>
                </div>
                <div class="input-box" id="gender-div">
                    <select onchange="changeOpacity(this)" onfocus="Focused('gender-div')"
                        onblur="Blured('gender-div')" name="gender" id="gender" class="myselect">
                        <option value="gender" selected disabled>الجنس</option>
                        <option value="ذكر">ذكر</option>
                        <option value="انثى">انثى</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="682.7" height="682.7" version="1.0" viewBox="0 0 512 512"><path d="m251 7-3 3v246l1 248c3 5 11 5 14 0l1-248V10l-3-3c-1-2-3-3-5-3s-4 1-5 3zM92 7a62 62 0 0 0 2 119c7 2 22 2 30 0 21-5 39-23 45-45V51c-6-21-24-39-45-45-8-1-25-1-32 1zM383 7c-16 4-32 18-39 32-7 13-8 27-5 40 2 12 7 21 16 30 13 13 26 19 44 19 10 0 17-1 26-6A62 62 0 0 0 383 7zM332 145c-10 4-19 13-22 23a1381 1381 0 0 0-19 119c2 17 13 29 29 34 2 1 1 4-3 27l-5 27 3 3c2 3 3 3 10 3h7v54c1 59 0 57 7 65l7 6c4 2 6 2 12 2 10 0 17-4 22-14 3-3 3-4 3-58v-55h33v54c1 59 0 57 7 65 6 5 13 8 21 8 7-1 11-3 15-7 8-8 8-5 8-66v-54h6c7 0 10-1 13-5 1-2 1-3-3-28l-4-27 5-2c8-3 15-11 20-20 6-12 6-14-5-76-8-47-9-54-12-60-4-7-10-13-18-17l-5-3h-63c-61 0-64 0-69 2zM37 148c-15 3-27 15-31 29-2 6-2 9-2 84v78l3 6c5 10 13 15 26 16h7v130l3 4c3 6 8 10 13 12l24 1h21V408l3-2c3-4 7-4 10-1 2 3 2 3 2 53v50h20l24-1c5-1 11-6 13-11 3-4 3-5 3-70v-65h7c13-1 22-7 27-16l2-6V179l-4-7c-4-10-11-16-20-21l-7-3-71-1-73 1z"/></svg>
                </div>
                <div class="input-box" id="commission-div">
                    <select onchange="changeOpacity(this)" onfocus="Focused('commission-div')"
                        onblur="Blured('commission-div')" name="commission" id="commission" class="myselect">
                        <option value="commission" selected disabled>المفوضية</option>
                        <option value="طرابلس">طرابلس</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="682.7" height="682.7" version="1.0" viewBox="0 0 512 512"><path d="M241 40c-8 2-20 6-29 11-11 6-27 21-33 32a89 89 0 1 0 154 0c-6-11-22-26-33-32a92 92 0 0 0-59-11z"/><path d="M83 124c-19 5-36 20-44 39-4 9-5 15-5 26a67 67 0 0 0 50 64c9 2 24 2 32-1 15-3 30-14 39-27 13-20 15-46 3-68-5-10-17-22-27-27-14-8-32-10-48-6zM395 124c-17 5-33 18-41 33-9 17-11 38-3 56 7 19 25 34 45 39 9 3 24 3 32 1 24-6 42-25 49-49 1-7 2-22 0-30-5-24-25-44-49-50-10-3-23-3-33 0zM196 237c-16 3-26 9-37 20-10 9-15 17-19 30l-3 7v84c0 83 0 85 2 88l5 5c3 2 5 2 112 2s109 0 112-2l5-5c2-3 2-5 2-88v-84l-3-7c-4-13-9-21-19-30-9-10-18-15-30-19l-8-3h-56l-63 1zM64 274c-28 4-52 24-61 53-3 8-3 8-3 60v52l3 5c4 12 14 21 26 26 5 2 6 2 43 3h38l-1-3a3191 3191 0 0 1 2-186l2-9v-2H92l-28 1zM399 275l2 8 3 16c2 14 1 166-1 171l-1 3h38c37 0 38-1 43-3 12-5 22-14 26-26l3-6v-51c0-52 0-52-3-60-7-24-24-42-47-49-10-4-20-5-43-5h-20v2z"/></svg>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="step">
                <div class="input-box" id="fooj-div">
                    <select onchange="changeOpacity(this)" onfocus="Focused('fooj-div')" onblur="Blured('fooj-div')"
                        name="fooj" id="fooj" class="myselect">
                        <option value="fooj" selected disabled>الفوج</option>
                        <option value="حي الاندلس">حي الاندلس</option>
                        <option value="الشط">الشط</option>
                        <option value="المدينة">المدينة</option>
                        <option value="تاجوراء">تاجوراء</option>
                        <option value="الهضبة">الهضبة</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="682.7" height="682.7" version="1.0" viewBox="0 0 512 512"><path d="M239 44a107 107 0 0 0-9 209c8 2 11 2 26 2s18 0 26-2a107 107 0 0 0-7-209h-36z"/><path d="M121 109c-27 7-46 25-54 52-2 6-2 10-2 20 0 14 1 21 6 32 9 20 28 35 49 41 14 3 31 2 45-3 9-3 9-3 0-12a128 128 0 0 1-30-130c0-3-5-3-14 0zM377 108l6 26a128 128 0 0 1-36 104c-9 10-9 10 0 13a75 75 0 0 0 99-51c2-10 2-29-1-39-9-29-33-50-62-54l-6 1zM84 278a95 95 0 0 0-84 99c0 17 0 20 2 23l4 4 19 1h18v-15a143 143 0 0 1 58-109l6-3H84z"/><path d="M168 278c-52 6-95 47-102 99-2 7-2 19-2 47 0 41 0 41 6 44 3 2 369 1 372 0l5-4 1-45-2-48c-6-26-17-45-36-62-19-18-41-28-67-31H168z"/><path d="m405 277 9 7c34 25 55 66 55 110v11h18l19-1 4-4c3-5 2-38-1-50a96 96 0 0 0-82-72l-22-1z"/></svg>
                </div>
                <div class="input-box rings ring-active" id="maleRing-div">
                    <select onchange="changeOpacity(this)" onfocus="Focused('maleRing-div')" onblur="Blured('maleRing-div')"
                        name="ring" id="maleRing" class="myselect">
                        <option value="ring" selected disabled>الحلقة</option>
                        <option value="أشبال">أشبال</option>
                        <option value="فتيان">فتيان</option>
                        <option value="متقدم">متقدم</option>
                        <option value="بحرية">بحرية</option>
                        <option value="جوالة">جوالة</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="682.7" height="682.7" version="1.0" viewBox="0 0 512 512"><path d="M244 18c-25 6-41 33-34 57 6 26 32 42 58 35 25-6 41-32 35-57-7-26-34-42-59-35zM226 130c-38 8-61 52-44 85 6 11 18 20 31 23 8 3 78 3 87 0 21-5 36-25 36-47 0-23-14-46-35-56-13-6-19-7-45-7-16 0-26 1-30 2zM137 165a182 182 0 0 0-46 59c-5 9-6 12-6 16 0 12 12 19 23 14 4-2 5-4 11-16 9-17 15-26 29-40 12-13 13-15 12-23-1-4-5-9-9-11s-11-1-14 1zM360 165c-6 4-9 10-8 17l12 16c14 14 21 23 29 40 6 13 7 14 11 16 11 5 23-2 23-14 0-9-14-35-28-52-8-9-19-21-23-23-4-3-11-3-16 0zM84 274c-25 6-41 33-34 58 6 25 32 41 58 35 25-7 41-33 35-58-7-26-34-42-59-35zM404 274c-25 6-41 33-34 58 6 25 32 41 58 35 25-7 41-33 35-58-7-26-34-42-59-35zM66 386c-38 8-61 52-44 85 6 11 18 20 31 24 8 2 78 2 87 0 21-6 36-26 36-47 0-24-14-47-35-57-13-6-19-7-45-7-16 0-26 1-30 2zM386 386c-38 8-61 52-44 85 6 11 18 20 31 24 8 2 78 2 87 0 21-6 36-26 36-47 0-24-14-47-35-57-13-6-19-7-45-7-16 0-26 1-30 2zM199 449c-11 5-13 19-5 27 5 4 23 9 44 11s51 0 70-6c11-4 15-9 15-17 0-11-10-18-20-15l-16 4c-22 5-56 3-75-4h-13z"/></svg>
                </div>

                <div class="input-box rings" id="femaleRing-div">
                    <select onchange="changeOpacity(this)" onfocus="Focused('femaleRing-div')" onblur="Blured('femaleRing-div')"
                        name="ring" id="femaleRing" class="myselect">
                        <option value="ring" selected disabled>الحلقة</option>
                        <option value="زهرات">زهرات</option>
                        <option value="فتيات">فتيات</option>
                        <option value="دليلات">دليلات</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="682.7" height="682.7" version="1.0" viewBox="0 0 512 512"><path d="M244 18c-25 6-41 33-34 57 6 26 32 42 58 35 25-6 41-32 35-57-7-26-34-42-59-35zM226 130c-38 8-61 52-44 85 6 11 18 20 31 23 8 3 78 3 87 0 21-5 36-25 36-47 0-23-14-46-35-56-13-6-19-7-45-7-16 0-26 1-30 2zM137 165a182 182 0 0 0-46 59c-5 9-6 12-6 16 0 12 12 19 23 14 4-2 5-4 11-16 9-17 15-26 29-40 12-13 13-15 12-23-1-4-5-9-9-11s-11-1-14 1zM360 165c-6 4-9 10-8 17l12 16c14 14 21 23 29 40 6 13 7 14 11 16 11 5 23-2 23-14 0-9-14-35-28-52-8-9-19-21-23-23-4-3-11-3-16 0zM84 274c-25 6-41 33-34 58 6 25 32 41 58 35 25-7 41-33 35-58-7-26-34-42-59-35zM404 274c-25 6-41 33-34 58 6 25 32 41 58 35 25-7 41-33 35-58-7-26-34-42-59-35zM66 386c-38 8-61 52-44 85 6 11 18 20 31 24 8 2 78 2 87 0 21-6 36-26 36-47 0-24-14-47-35-57-13-6-19-7-45-7-16 0-26 1-30 2zM386 386c-38 8-61 52-44 85 6 11 18 20 31 24 8 2 78 2 87 0 21-6 36-26 36-47 0-24-14-47-35-57-13-6-19-7-45-7-16 0-26 1-30 2zM199 449c-11 5-13 19-5 27 5 4 23 9 44 11s51 0 70-6c11-4 15-9 15-17 0-11-10-18-20-15l-16 4c-22 5-56 3-75-4h-13z"/></svg>
                </div>

                <div class="input-box" id="group-div">
                    <input type="number" name="group" id="group" onfocus="Focused('group-div')"
                        onblur="Blured('group-div')" placeholder="الفرقة" min="1" max="10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="682.7" height="682.7" version="1.0" viewBox="0 0 512 512"><path d="M82 2C64 5 47 19 39 35c-12 26-8 54 12 74 25 25 65 25 90 0s25-65 0-90A64 64 0 0 0 82 2zM242 2c-18 3-35 17-43 33-9 19-9 39 0 58a64 64 0 0 0 119-42c-7-35-41-57-76-50zM402 2c-18 3-35 17-43 33-9 19-9 39 0 58a64 64 0 0 0 119-42c-7-35-41-57-76-50zM37 161c-9 3-15 9-19 18-3 5-3 11-11 82-7 77-7 78-5 81l5 7c3 2 4 3 15 3h12l6 52c8 58 8 59 17 67s10 9 39 9 31-1 39-9c8-7 9-11 14-50l6-39c0-3 0-4-5-6-10-6-19-19-21-32a7007 7007 0 0 1 14-160l4-15c3-6 3-8 2-8a1386 1386 0 0 0-112 0zM197 161c-9 3-15 9-19 18-3 5-3 11-11 82-7 77-7 78-5 81l5 7c3 2 4 3 15 3h12l6 68c7 63 7 68 10 73 3 7 9 13 16 16 4 2 6 3 30 3s26-1 30-3c7-3 13-9 16-16 3-5 3-10 10-73l7-68h11c12 0 12-1 16-4 7-6 7-1-1-87-8-71-8-77-11-82-3-7-9-13-16-16-4-2-5-2-60-3l-61 1zM362 161l2 5 3 11 10 82c8 85 8 85 2 97-3 8-10 16-17 20l-5 2 11 78c2 9 9 17 18 21 4 2 6 2 30 2 29 1 31 0 39-8 9-8 9-9 17-67l6-52h12c11 0 12-1 15-3l6-7c1-4 1-4-6-81-8-71-8-77-11-82-3-7-9-13-16-16-4-2-5-2-59-3l-57 1z"/></svg>
                </div>
                <div class="input-box" id="rank-div">
                    <select onchange="changeOpacity(this)" onfocus="Focused('rank-div')" onblur="Blured('rank-div')"
                        name="rank" id="rank" class="myselect">
                        <option value="rank" selected disabled>الرتبة</option>
                        <option value="قائد">قائد فرقة</option>
                        <option value="عضو">عضو فرقة</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="682.7" height="682.7" version="1.0" viewBox="0 0 512 512"><path d="M198 1C139 9 94 58 90 118c-2 40 19 82 53 105 53 35 116 30 161-15 12-12 24-31 29-47 9-29 7-62-6-89A126 126 0 0 0 198 1z"/><path d="M119 253c-39 17-73 48-95 87A210 210 0 0 0 3 472c2 4 6 7 11 8l149 1h146l1-3 9-48c0-2-22-26-54-58-21-21-21-21-18-22a2348 2348 0 0 1 100-15l19-46-13-11c-15-11-33-21-47-27l-6-2-5 4c-13 10-36 19-55 23a155 155 0 0 1-105-22l-6-4-10 3z"/><path d="M390 288a4275 4275 0 0 0-30 64l-8 2-20 2-29 4-19 3c-2 0 0 3 27 30l29 29-5 27-9 37c-3 16-3 19-2 19l57-33 15-9 25 14 36 21 11 6v-4l-8-41-7-38 28-28 26-28-36-6-37-7c-2 0-4-3-10-17l-19-38-10-21-5 11z"/></svg>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="step">
                <div class="input-box" id="username-div">
                    <input type="text" id="username" onfocus="Focused('username-div')" onblur="Blured('username-div')"
                        placeholder="اسم المستخدم" name="username">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
                    </svg>
                </div>
                <div class="input-box" id="email-div">
                    <input type="email" id="email" onfocus="Focused('email-div')" onblur="Blured('email-div')"
                        placeholder="البريد الالكتروني" name="email">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                            d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                    </svg>
                </div>
                <div class="input-box" id="password-div">
                    <input type="password" onfocus="Focused('password-div')" onblur="Blured('password-div')"
                        placeholder="كلمة المرور" id="password" name="password">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                            d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
                    </svg>
                </div>
                <div class="input-box" id="repassword-div">
                    <input type="password" onfocus="Focused('repassword-div')" onblur="Blured('repassword-div')"
                        placeholder="تأكيد كلمة المرور" id="conf-password" name="conf-password">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                            d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
                    </svg>
                </div>
            </div>
            <p id="error">‎</p>


            <div id="next">
                <button type="button" class="btn next-btn" name="signup" value="signup">التالي</button>
            </div>

            <div id="back">
                <button type="button" class="back-btn">رجوع</button>
            </div>

            <div class="register">
                <p>لديك حساب بالفعل؟ <a href="login.php">سجل دخولك</a></p>
            </div>
        </form>
    </div>


</body>

</html>