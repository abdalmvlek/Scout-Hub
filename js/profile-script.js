document.addEventListener("DOMContentLoaded" , function () {
    const sidebar = document.getElementById("side-bar");
    const scoutInfo = sidebar.querySelector("#scout-info");
    const accountInfo = sidebar.querySelector("#account-info");
    
    const mainSide = document.getElementById("main-side");
    const scoutMain = mainSide.querySelector("#scout-main");
    const accountMain = mainSide.querySelector("#account-main");
    

    function HideAndShowInfo(otherInfo,selectedInfo,otherMain,selectedMain) {
        otherInfo.classList.remove("info-selected");
        selectedInfo.classList.add("info-selected");
        otherMain.classList.remove("active");
        selectedMain.classList.add("active");
    }
    
    scoutInfo.addEventListener('click', function () {
        HideAndShowInfo(accountInfo, scoutInfo, accountMain, scoutMain);
    });

    accountInfo.addEventListener('click', function () {
        HideAndShowInfo(scoutInfo, accountInfo, scoutMain, accountMain);
    });

});