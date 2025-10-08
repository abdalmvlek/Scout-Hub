document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('multiStepForm');
    const steps = form.querySelectorAll('.step');
    const nextButton = form.querySelector('.next-btn');
    const backButton = form.querySelector('.back-btn');
    const errorPara = form.querySelector("#error");
    let currentStep = 0;
    
    //set default type for submit button
    nextButton.setAttribute('type','button');

    nextButton.addEventListener('click', function () {
        if(validateForm())
        {
            //show the back button when you reach the second step
            if(currentStep == 0) {
                backButton.style.display = "block";
            }
            //change the next button to the submit button after completing the second step
            if(currentStep == 1) {
                nextButton.innerHTML = "سجل الأن";
            }

            //submit the form after completing the last step
            else if(currentStep == 2) {
                nextButton.setAttribute('type','submit');
                return; //do not execute the rest of the code while submiting form
                        //to prevent the form from disapearing while you still submiting
            }
            
            //hide the current step and show the next one
            steps[currentStep].classList.remove('active');
            currentStep++;
            steps[currentStep].classList.add('active');
        }
    });

    backButton.addEventListener('click', function () {

        /*Hide the back button on the first step.
        currentStep = 1 because when the user clikcs the back button to get to the first step (0) 
        we would be on the second step (1)*/
        if(currentStep == 1) {
            backButton.style.display = "none";
        }
        //change the submit button to the next button when the user gets back from the last step to previouse steps
        else if(currentStep == 2) {
            nextButton.innerHTML = "التالي";
        }

        //delete any error messages form the current step when you get back to the prevoiuse step
        errorPara.innerHTML = "‎"

        //hide the current step and show the previous step
        steps[currentStep].classList.remove('active');
        currentStep--;
        steps[currentStep].classList.add('active');
        

    });


    function validateForm() {

        const maleRingDiv = document.getElementById("maleRing-div");
        const femaleRingDiv = document.getElementById("femaleRing-div");
        const maleRing = document.getElementById("maleRing").value;
        const femaleRing = document.getElementById("femaleRing").value;

        //validate the first step of the form
        if(currentStep == 0) {
            const fname = document.getElementById("fname").value;
            const midname = document.getElementById("midname").value;
            const lastname = document.getElementById("lastname").value;
            const commission = document.getElementById("commission").value;
            const gender = document.getElementById("gender").value;


            //check if any of the input feilds are empty
            if(!fname || !midname || !lastname) {
                errorPara.innerHTML = "يرجى تعبئة جميع الحقول المطلوبة.";
                return false;
            }
            //check if the user selected an option in the list
            //if the value is the defualt it means the user didn't select an option
            else if(commission == "commission" || gender == "gender") {
                errorPara.innerHTML = "يرجى تعبئة جميع الحقول المطلوبة.";
                return false;
            }
            else {
                //Show the rings based on the gender of the user
                if(gender == "انثى") {
                    femaleRingDiv.classList.add("ring-active");
                    maleRingDiv.classList.remove("ring-active");
                }
                else if(gender == "ذكر") {
                    maleRingDiv.classList.add("ring-active");
                    femaleRingDiv.classList.remove("ring-active");
                }

                errorPara.innerHTML = "‎";
                return true;
            }
        }

        //validate the second step of the form
        else if(currentStep == 1) {
            const fooj = document.getElementById("fooj").value;
            const group = document.getElementById("group").value;
            const rank = document.getElementById("rank").value;
            
            //get the appropriate Ring field to validate 
            let ring;
            if(document.getElementById("maleRing-div").classList.contains("ring-active")) {
                ring = document.getElementById("maleRing").value;
            }
            else {
                ring = document.getElementById("femaleRing").value;
            }

            //check if the user didn't select an option than the value would be the default
            if(fooj == "fooj" || ring == "ring" || rank == "rank") {
                errorPara.innerHTML = "يرجى تعبئة جميع الحقول المطلوبة.";
                return false;
            }
            //check if the input feild for the group is empty or not
            else if(group == "") {
                errorPara.innerHTML = "يرجى تعبئة جميع الحقول المطلوبة.";
                return false;
            }
            else if(parseInt(group) < 1 || parseInt(group) > 10) {
                group.value = "";
                errorPara.innerHTML = "يرجى اختيار الفرقة ضمن القيّم المحددة."
                return false;
            }
            else {
                errorPara.innerHTML = "‎";
                return true;
            }
        }
        //validate the third step of the form
        else if(currentStep == 2) {
            const username = document.getElementById("username");
            const email = document.getElementById("email");
            const password = document.getElementById("password");
            const conf_password = document.getElementById("conf-password");

            let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


            //document.getElementById("error").innerHTML = "‎";

            let isValidEmail = re.test(email.value);

            if(!username.value || !email.value || !password.value || !conf_password.value) {
                errorPara.innerHTML = "يرجى تعبئة جميع الحقول المطلوبة.";
                return false;
            }
            else if(!isValidEmail) {
                //empty the email input field
                email.value = "";
                //display the error message
                errorPara.innerHTML = "يُرجى التأكد من إدخال عنوان بريد إلكتروني صالح.";
                return false;
            }
            else if(password.value !== conf_password.value) {
                //empty the passwords input fields
                password.value = "";
                conf_password.value = "";
                //display the error message
                errorPara.innerHTML = "كلمتا المرور غير متطابقتين. يُرجى التأكد وإعادة المحاولة.";
                return false;
            }

            return true;

        }
    }

    
    //get the query string ? part of the URL 
    const queryString = window.location.search;

    //display an error message if we get back with an error from the server
    const urlParams = new URLSearchParams(queryString);
    if(urlParams.has("error")) {
        if(urlParams.get("error") === "usertaken") {
            errorPara.innerHTML = "اسم المستخدم غير متاح. الرجاء اختيار اسم آخر."
        }
        else if (urlParams.get("error") === "emailtaken") {
            errorPara.innerHTML = 'يوجد حساب مسجل بهذا البريد بالفعل. هل تريد <a href="login.html">تسجيل الدخول</a> بدلاً من ذلك؟';
        }
        else if(urlParams.get("error") == "invalidUsernme") {
            errorPara.innerHTML = "اسم المستخدم غير صالح، أدخل اسمًا بدون رموز أو مسافات.";
        }
        else if(urlParams.get("error") == "invalidEmail") {
            errorPara.innerHTML = "يُرجى التأكد من إدخال عنوان بريد إلكتروني صالح."
        }
        else if(urlParams.get("error") == "pwdCheck") {
            errorPara.innerHTML = "كلمتا المرور غير متطابقتين. يُرجى التأكد وإعادة المحاولة."
        }
        else {
            errorPara.innerHTML = "حدث خطأ ما! يرجى إعادة المحاولة.";
        }

        /* clean the url */
        //get the orginal path without the query
        const cleanUrl = window.location.origin + window.location.pathname;
        //repalce the url that have the  query with the orginal one
        window.history.replaceState({}, document.title, cleanUrl);
    }
});


//increase the opacity when the user select an option from the select list
function changeOpacity(element) {
    element.style.opacity = "1";
}

function Focused(divId) {
    document.getElementById(divId).style.border = "rgb(138, 43, 226,0.7) solid 2px";
}

function Blured(divId) {
    document.getElementById(divId).style.border = "#33333348 solid 2px";
}

