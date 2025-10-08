document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById("login-form"); 
    const loginButton = form.querySelector("#login");
    const errorPara = form.querySelector("#error");

    loginButton.addEventListener('click', function (event) {
        //don't submit the form if the data is not valid
        if(!validateForm()) {
            //preventing the form from submiting
            event.preventDefault()
        }
    });

    function validateForm() {
        const usernameEmail = form.querySelector("#usernameEmail").value;
        const password = form.querySelector("#password").value;


        //if any of the fields are empty output error message and return false
        if(!usernameEmail || !password) {
            errorPara.innerHTML = "يرجى تعبئة جميع الحقول المطلوبة.";
            return false;
        }
        else {
            return true;
        }
    }

    
    const queryString = window.location.search;
    
    //display an error message if we get back with an error from the server
    const urlParams = new URLSearchParams(queryString);
    if(urlParams.has("error")) {
        if(urlParams.get("error") == "wrongPassword") {
            errorPara.innerHTML = "اسم المستخدم او كمة المرور غير صحيحة، اعد المحاولة.";
        }
        else if(urlParams.get("error") == "nouser") {
            errorPara.innerHTML = "اسم المستخدم او كمة المرور غير صحيحة، اعد المحاولة."
        }

        /* clean the url */
        //get the orginal path without the query
        const cleanUrl = window.location.origin + window.location.pathname;
        //repalce the url that have the  query with the orginal one
        window.history.replaceState({}, document.title, cleanUrl);
    }
});

/*if the function is accessed from the html, it should not be inside the DOMContentLoaded
The following function are being called from an element in the html file*/

//when the input feild is focused the border becomes pruple
function Focused(divId) {
    document.getElementById(divId).style.border = "rgb(138, 43, 226,0.7) solid 2px";
}

//when the input feild losses focus the border return to the orginal color
function Blured(divId) {
    document.getElementById(divId).style.border = "#33333348 solid 2px";
}