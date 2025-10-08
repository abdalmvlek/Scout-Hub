document.addEventListener('DOMContentLoaded', function () {
    const createNewEventBtn = document.getElementById("new-event-btn");
    const uploadFileDiv = document.getElementById("upload-file-div");
    const choosePhoto = document.getElementById("choose-photo");
    const photoSelected = document.getElementById("photo-selected");
    const form = document.getElementById("myForm");
    const editForm = document.getElementById("myForm2");
    const events = document.getElementById("events");
    const eventDesc = document.querySelectorAll(".event-description");

    const eventMenuBtns = document.querySelectorAll(".event-menu-btn");
    const eventMenu = document.querySelectorAll(".event-menu");
    const deleteEventBtn = document.querySelectorAll(".delete-option");
    const editEventBtn = document.querySelectorAll(".edit-option")

    const popUpForDelete = document.getElementById("pop-up-deletion");
    const popUpInnerDelete = document.getElementById("delete-inner");
    const confDelete = document.getElementById("conf-delete");
    const cancelDelete = document.getElementById("cancel-delete");
    

    const popUpConfReg = document.getElementById("pop-up-reg");
    const popUpInnerReg = document.getElementById("register-inner");
    const eventRegBtn = document.querySelectorAll("#event-register-btn");
    const confReg = document.getElementById("conf-reg");
    const cancelConfReg = document.getElementById("cancel-reg");

    const cancelRegisterBtn = document.querySelectorAll("#cancel-register-btn")
    const popUpCancelReg = document.getElementById("pop-up-cancel-reg");
    const popUpInnerCancelReg = document.getElementById("cancel-register-inner");
    const yesCancelRegBtn = document.getElementById("yes-cancel-reg");
    const noCancelRegBtn = document.getElementById("no-cancel-reg");

    const createBtn = document.getElementById("create-btn");
    const popUpCreate = document.getElementById("pop-up-create");
    const popUpCreateInner = document.getElementById("wrapper");
    const title = document.getElementById("title");
    const description = document.getElementById("description");
    const date = document.getElementById("date");
    const cancelCreateEventBtn = document.getElementById("cancel");

    const popUpEdit = document.getElementById("pop-up-edit");
    const popUpEditInner = document.getElementById("wrapper2");
    const titleForEditForm = document.getElementById("title2");
    const descForEditForm = document.getElementById("description2");
    const dateForEditForm = document.getElementById("date2");
    const choosePhotoEditForm = document.getElementById("choose-photo2");
    const photoSelectedEditForm = document.getElementById("photo-selected2");
    const confEditBtn = document.getElementById("edit-btn");
    const cancelEditBtn = document.getElementById("cancel-edit-btn");
    const dummyFeildForEventId = document.getElementById("event-id");
    const dummyFeildOldImagePath = document.getElementById("old-image-path");
    const uploadFileDivForEdit = document.getElementById("upload-file-div2");

    const showRegistered = document.querySelectorAll('.event-show-registers');
    

    const error = document.getElementById("error");


    const editFormError = document.getElementById("error1")

    const today = new Date().toISOString().split("T")[0];



    function resetForm(selectedForm,photoSelect,photoChoose,errMsg) {
        //reset the form
        selectedForm.reset();
        photoSelect.classList.remove("active");
        photoChoose.classList.add("active");
        errMsg.style.display = "none";
        errMsg.innerHTML = "‎";
    }

    function HideFormShowEvents(popUp) {
        popUp.classList.remove("active");
        createNewEventBtn.style.display = "inline-block";
        events.style.display = "flex";
    }

    function validateForm(title,description,date,errMsg) {
        if(!title.value || !description.value || !date.value) {   
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

    //change the text of the label when a photo get uploaded
    function changeImageLabel(stateSelected, stateNotSelected) {
        stateNotSelected.classList.remove("active");
        stateSelected.classList.add("active");
    }

    //make the date input feild starts from todays date
    document.getElementById("date").setAttribute('min', today);

    

    /* ----[Creating] a new event---- */

    //Display the creating new event form When the button is clicked
    if(createNewEventBtn) {
        createNewEventBtn.addEventListener('click', function() {
            popUpCreate.classList.add("active");
        });
   }

    //validate the create event form data
    createBtn.addEventListener('click',function (event) {
        //the form won't be created if the data is not valid
        if(!validateForm(title,description,date,error)) {
            event.preventDefault();
        }
    });

    //hide the pop up form and show the created events when the cancel btn is clicked
    cancelCreateEventBtn.addEventListener('click', function () {
        HideFormShowEvents(popUpCreate);
        
        //reset the form data
        resetForm(form,photoSelected,choosePhoto,error);
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
        resetForm(form,photoSelected,choosePhoto,error);
    });

    //change the text of the label when a photo get uploaded
    uploadFileDiv.addEventListener('change', function () {
        changeImageLabel(photoSelected,choosePhoto);
    });



    /* ----[Displaying] the menu for deleting and editing of events---- */

    //When the three dots are clicked
    eventMenuBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation(); //stop the click event from reaching other listeners


            //open the menu for the event when the three dots are being clicked
            const menu = (this.nextElementSibling).nextElementSibling;
            /*when I put menu.style.display it makes the menu appaer from the second click
            doing it this way solved this issue*/
            if(window.getComputedStyle(menu).display === 'none') {

                //hide other menus if they are opened
                eventMenu.forEach(function(e) {
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
        eventMenu.forEach(function(e) {
            e.style.display = 'none';
        })
    });



    /* ----Handle [Deleting] events---- */

    //When the delete option is clicked
    deleteEventBtn.forEach(function (listItem) {

        listItem.addEventListener('click',function (event) {
            
            const link = listItem.firstElementChild;
            
            //get the event id of the event that needs to be deleted
            const eventId = link.getAttribute("data-event-id");

            //display the confrim delete pop up
            popUpForDelete.classList.add("active");

            //set the path of the php file and pass the event id with it inside the href attribute for the deletion btn
            const attValue = 'includes/event.delete.inc.php?id=' + eventId;
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

    //make the date input feild starts from todays date if you want to delay the event
    dateForEditForm.setAttribute('min', today);

    //When the edit option is clicked
    editEventBtn.forEach(function (listItem) {
        
        listItem.addEventListener('click', function (event) {


            const link = listItem.firstElementChild;

            //get the event id of the event needed to be edited
            const eventId = link.getAttribute("data-event-id");

            dummyFeildForEventId.value = eventId;

            //get the event data
            const title = link.getAttribute("data-event-title");
            const description = link.getAttribute("data-event-description");
            const startDate = link.getAttribute("data-event-startdate");
            const imagePath = link.getAttribute("data-event-image");

            //add the exsiting data to the edit form pop up
            titleForEditForm.value = title;
            descForEditForm.value = description;
            dateForEditForm.value = startDate;
            dummyFeildOldImagePath.value = imagePath;

            //check if there's a photo selected or it's the default one
            if(imagePath !== 'uploads/default.jpg') {
                //change the label if there's a photo selected and they are not using the default one
                photoSelectedEditForm.classList.add("active");
                choosePhotoEditForm.classList.remove("active");
            }
            //otherwise keep the label the same if they are using hte default photo

            //display edit event form pop up
            popUpEdit.classList.add("active");

        })
    })

    //validate the edit form data
    confEditBtn.addEventListener('click',function (event) {
        //the form won't edited if it got one or more empty fields
        if(!validateForm(titleForEditForm,descForEditForm,dateForEditForm,editFormError)) {
            event.preventDefault();
        }
    })

    //hide the edit form pop up when the cancel btn is clicked
    cancelEditBtn.addEventListener('click',function () {

        HideFormShowEvents(popUpEdit);

        //reset the form data 
        resetForm(editForm,photoSelectedEditForm,choosePhotoEditForm,editFormError);

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
        resetForm(editForm,photoSelectedEditForm,choosePhotoEditForm,editFormError);
    });

    uploadFileDivForEdit.addEventListener('change',function () {
        changeImageLabel(photoSelectedEditForm,choosePhotoEditForm);
    });



    /* ----[Showing] more or less of the Description---- */

    //when the show more/less text is clicked
    eventDesc.forEach(function (desc) {
        //get the read more links
        const readMoreLink = desc.nextElementSibling;

        //check if text is truncated (got cut off) or not by
        //by comparing the actual text height with the the text height visible to the user
        if(desc.scrollHeight > desc.clientHeight) {
            readMoreLink.style.display = "inline-block";
        }
        else {
            readMoreLink.style.display = "none";
        }

        readMoreLink.addEventListener('click', function(e) {
            
            //prevent the default behavior of a link
            e.preventDefault();

            //toggle the expaneded class on and off the class list of the description
            desc.classList.toggle('expanded');
            
            //change the text on the read more link depnding on whater the description is expanded or not
            this.textContent = desc.classList.contains("expanded") ? "عرض أقل" : "اقرأ المزيد";
        });


    });



    /* ----Handle the [registration] of events---- */
    
    let filePath = null;

    //When the register in this event button is clicked
    if(eventRegBtn) {
        eventRegBtn.forEach(function (btn) {
            btn.addEventListener('click', function () {

                //get event id of the event that the user wants to register in
                const eventId = btn.getAttribute("data-event-id");

                //show the confirm/cancel registration pop up 
                popUpConfReg.classList.add("active");

                //set the php file the envent id with it inside the href attribte for the confirm registration btn
                filePath = 'includes/event.registration.inc.php?id=' + eventId;

            });
        });
    }

    //hide and confirm the registeration when the blured background is clicked
    popUpConfReg.addEventListener('click',function (event) {
        //dont' hide it when the pop up it self is clicked
        if(event.target == popUpInnerReg || popUpInnerReg.contains(event.target)) {
            return;
        }
        //otherwise hide it
        popUpConfReg.classList.remove("active");

        //go to the php file that handle the registeration 
        window.location.href = filePath;
    });
    


    /* ----Handle the [Cancel] of events the user registered in---- */

    //When the cancel registration button is clicked
    cancelRegisterBtn.forEach(function (btn) {
        btn.addEventListener('click',function() {

            //get the event id of the event that the user want's to cancel thier registration in
            const eventId = btn.getAttribute('data-event-id');

            //show the cancel registration pop up
            popUpCancelReg.classList.add("active");

            //set the php file path the envent id with it inside the href attribte for the (yes) btn
            const attValue = "includes/evnet.cancel.registration.inc.php?id=" + eventId;
            yesCancelRegBtn.setAttribute('href',attValue);

        });
    });

    /*hide the cancel registration pop up when the the (no) btn is clicked
    and the user don't want to cancel thier registration*/
    noCancelRegBtn.addEventListener('click',function (event) {
        //prevent the default behavior of a link
        event.preventDefault();

        //hide the pop up
        popUpCancelReg.classList.remove('active');
    });

    //hide the cancel registration pop up when the blur background is clicked
    popUpCancelReg.addEventListener('click',function (event) {
        //don't hide it when the pop it self is clicked
        if(event.target == popUpInnerCancelReg || popUpInnerCancelReg.contains(event.target)) {
            return;
        }

        //otherwise hide it 
        popUpCancelReg.classList.remove('active');
    });


    /* ----[Showing] the members registered in the events---- */

    showRegistered.forEach(function(btn) {
        btn.addEventListener('click', function () {
            const divBtn = btn.parentElement;
            const eventId = divBtn.getAttribute("data-event-id");
            //redirect the user to the memebers-registered page with the eventId 
            window.location.href = './event-memebers-registered.php?eventId=' + eventId;
        });
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
