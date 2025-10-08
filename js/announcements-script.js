document.addEventListener('DOMContentLoaded', function () {
    const createNewAnnouncement = document.getElementById("create-ann");
    const form = document.getElementById("myForm");
    const editForm = document.getElementById("myForm2");
    const announcements = document.getElementById("announcements");

    const createBtn = document.getElementById("create-btn");
    const popUpCreate = document.getElementById("pop-up-create");
    const popUpCreateInner = document.getElementById("wrapper");
    const title = document.getElementById("title");
    const description = document.getElementById("description");
    const cancelCreateAnnBtn = document.getElementById("cancel");

    const annMenuBtns = document.querySelectorAll(".ann-menu-btn");
    const annMenu = document.querySelectorAll(".ann-menu");
    const deleteAnntBtn = document.querySelectorAll(".delete-option");
    const editAnnBtn = document.querySelectorAll(".edit-option")

    const popUpForDelete = document.getElementById("pop-up-deletion");
    const popUpInnerDelete = document.getElementById("delete-inner");
    const confDelete = document.getElementById("conf-delete");
    const cancelDelete = document.getElementById("cancel-delete");

    const popUpEdit = document.getElementById("pop-up-edit");
    const popUpEditInner = document.getElementById("wrapper2");
    const titleForEditForm = document.getElementById("title2");
    const descForEditForm = document.getElementById("description2");
    const confEditBtn = document.getElementById("edit-btn");
    const cancelEditBtn = document.getElementById("cancel-edit-btn");
    const dummyFeildForAnnId = document.getElementById("ann-id");

    const error = document.getElementById("error");

    const editFormError = document.getElementById("error1")



    function resetForm(selectedForm,errMsg) {
        //reset the form
        selectedForm.reset();
        errMsg.style.display = "none";
        errMsg.innerHTML = "‎";
    }

    function HideFormShowEvents(popUp) {
        popUp.classList.remove("active");
        createNewAnnouncement.style.display = "inline-block";
        announcements.style.display = "flex";
    }

    function validateForm(title,description,errMsg) {
        if(!title.value || !description.value) {   
            errMsg.style.display = 'block';
            errMsg.innerHTML = 'يرجى تعبئة جميع الحقول المطلوبة';
            return false;
        }
        else {
            errMsg.style.display = 'none';
            errMsg.innerHTML = '‎';
            return true;        
        }
    }

    /* ----[Creating] a new announcement---- */

    if(createNewAnnouncement) {        
        createNewAnnouncement.addEventListener('click' ,function () {
            popUpCreate.classList.add('active');
        });
    }

    //validate the create event form data
    createBtn.addEventListener('click',function (event) {
        //the form won't be created if the data is not valid
        if(!validateForm(title,description,error)) {
            event.preventDefault();
        }
    });

    //hide the pop up form and show the created events when the cancel btn is clicked
    cancelCreateAnnBtn.addEventListener('click', function () {
        HideFormShowEvents(popUpCreate);
        
        //reset the form data
        resetForm(form,error);
    });

    //hide the pop up create form when the blured background is clicked
    popUpCreate.addEventListener('click', function(event) {
        //don't hide it when the pop up itself is clicked
        if(event.target == popUpCreateInner || popUpCreateInner.contains(event.target)) {
            return;
        }

        //other wise hide it
        HideFormShowEvents(popUpCreate);

        //reset the data 
        resetForm(form,error);
    });


    /* ----[Displaying] the menu for deleting and editing of announcements---- */

    //When the three dots are clicked
    annMenuBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation(); //stop the click event from reaching other listeners


            //open the menu for the announcment when the three dots are being clicked
            const menu = this.nextElementSibling;
            /*when I put menu.style.display it makes the menu appaer from the second click
            doing it this way solved this issue*/

            //if the menu was not visable
            if(window.getComputedStyle(menu).display === 'none') {

                //hide other menus if they are opened
                annMenu.forEach(function(e) {
                    e.style.display = 'none';
                });
                
                //display the current menu
                menu.style.display = 'block';
            }
            else {
                
               //hide the current menu if the it was already opned when the three dots are clicked
               menu.style.display = 'none';
            }
        });
    });


    //hide all events menu when the users clicks anywhere in the document
    document.addEventListener('click', function () {
        annMenu.forEach(function(e) {
            e.style.display = 'none';
        })
    });


    /* ----Handle [Deleting] events---- */

    //When the delete option is clicked
    deleteAnntBtn.forEach(function (listItem) {

        listItem.addEventListener('click',function (event) {
            
            const link = listItem.firstElementChild;

            //get the event id of the event that needs to be deleted
            const annId = link.getAttribute("data-ann-id");

            //display the confrim delete pop up
            popUpForDelete.classList.add("active");

            //set the path of the php file and pass the event id with it inside the href attribute for the deletion btn
            const attValue = 'includes/announcement.delete.inc.php?id=' + annId;
            confDelete.setAttribute('href',attValue);

        });

    });

    //hide the confirm delete pop up if the cancel button is clicked 
    cancelDelete.addEventListener('click', function (event) {
        event.preventDefault();
        popUpForDelete.classList.remove("active");
    });

    //hide the pop up if the blured background is clicked
    popUpForDelete.addEventListener('click',function (event) {
        //don't hide when the pop up it self is clicked
        if(event.target == popUpInnerDelete || popUpInnerDelete.contains(event.target)) {
            return;
        }
        //otherwise hide it
        popUpForDelete.classList.remove("active");
    });


    /* ----Handle [Editing] events---- */

    //When the edit option is clicked
    editAnnBtn.forEach(function (listItem) {
        
        listItem.addEventListener('click', function (event) {

            const link = listItem.firstElementChild;

            //get the event id of the event needed to be edited
            const annId = link.getAttribute("data-ann-id");

            dummyFeildForAnnId.value = annId;

            //get the event data
            const title = link.getAttribute("data-ann-title");
            const description = link.getAttribute("data-ann-description");

            //add the exsiting data to the edit form pop up
            titleForEditForm.value = title;
            descForEditForm.value = description;
            
            //display edit event form pop up
            popUpEdit.classList.add("active");

        })
    })

    //validate the edit form data
    confEditBtn.addEventListener('click',function (event) {
        //the form won't edited if it got one or more empty fields
        if(!validateForm(titleForEditForm,descForEditForm,editFormError)) {
            event.preventDefault();
        }
    })

    //hide the edit form pop up when the cancel btn is clicked
    cancelEditBtn.addEventListener('click',function () {

        HideFormShowEvents(popUpEdit);

        //reset the form data 
        resetForm(editForm,editFormError);

    });

    //hide the pop up edit form when the blured background is clicked
    popUpEdit.addEventListener('click',function (event) {
        //don't hide it when the pop up itself is clicked
        if(event.target == popUpEditInner || popUpEditInner.contains(event.target)) {
            return;
        }
        //otherewise hide it
        HideFormShowEvents(popUpEdit);
        
        //reset the form data
        resetForm(editForm,editFormError);
    });


    /* ----[Resting] the form after returning from the server after creating new event---- */

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    if(urlParams.has("msg")) {
        if(urlParams.get("msg") == "success") {
            form.reset();
        }

        //clean the url
        const cleanUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, cleanUrl);
    }
});