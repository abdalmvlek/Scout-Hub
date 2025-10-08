document.addEventListener('DOMContentLoaded', function() {
    const createNewVolunteertBtn = document.getElementById("new-volunteer-btn");
    const uploadFileDiv = document.getElementById("upload-file-div");
    const choosePhoto = document.getElementById("choose-photo");
    const photoSelected = document.getElementById("photo-selected");
    const form = document.getElementById("myForm");
    const editForm = document.getElementById("myForm2");
    const volunterWorks = document.getElementById("volunterworks");
    const workDesc = document.querySelectorAll(".work-description");

    const createBtn = document.getElementById("create-btn");
    const popUpCreate = document.getElementById("pop-up-create");
    const popUpCreateInner = document.getElementById("wrapper");
    const title = document.getElementById("title");
    const description = document.getElementById("description");
    const date = document.getElementById("date");
    const cancelCreateVolunteerBtn = document.getElementById("cancel");

    const workMenuBtns = document.querySelectorAll(".work-menu-btn");
    const workMenu = document.querySelectorAll(".work-menu");
    const deleteWorkBtn = document.querySelectorAll(".delete-option");
    const editWorkBtn = document.querySelectorAll(".edit-option")

    const popUpConfReg = document.getElementById("pop-up-reg");
    const popUpInnerReg = document.getElementById("register-inner");
    const workRegBtn = document.querySelectorAll("#work-register-btn");

    const cancelRegisterBtn = document.querySelectorAll("#cancel-register-btn")
    const popUpCancelReg = document.getElementById("pop-up-cancel-reg");
    const popUpInnerCancelReg = document.getElementById("cancel-register-inner");
    const yesCancelRegBtn = document.getElementById("yes-cancel-reg");
    const noCancelRegBtn = document.getElementById("no-cancel-reg");

    const popUpForDelete = document.getElementById("pop-up-deletion");
    const popUpInnerDelete = document.getElementById("delete-inner");
    const confDelete = document.getElementById("conf-delete");
    const cancelDelete = document.getElementById("cancel-delete");

    const popUpEdit = document.getElementById("pop-up-edit");
    const popUpEditInner = document.getElementById("wrapper2");
    const titleForEditForm = document.getElementById("title2");
    const descForEditForm = document.getElementById("description2");
    const dateForEditForm = document.getElementById("date2");
    const choosePhotoEditForm = document.getElementById("choose-photo2");
    const photoSelectedEditForm = document.getElementById("photo-selected2");
    const uploadFileDivForEdit = document.getElementById("upload-file-div2");
    const confEditBtn = document.getElementById("edit-btn");
    const cancelEditBtn = document.getElementById("cancel-edit-btn");
    const dummyFeildForWorkId = document.getElementById("work-id");
    const dummyFeildOldImagePath = document.getElementById("old-image-path");

    const showRegistered = document.querySelectorAll(".work-show-registers");

    const editFormError = document.getElementById("error1");

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
        createNewVolunteertBtn.style.display = "inline-block";
        volunterWorks.style.display = "flex";
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

    function changeImageLabel(stateSelected,stateNotSelected) {
        stateNotSelected.classList.remove("active");
        stateSelected.classList.add("active");
    }

    /* ----[Creating] a new volunteer work---- */

    //make the date input feild starts from todays date
    document.getElementById("date").setAttribute('min', today);

    //Display the creating new volunteer work form When the button is clicked
    if(createNewVolunteertBtn) {
        createNewVolunteertBtn.addEventListener('click', function() {
            popUpCreate.classList.add("active");
        });
   }

    //validate the create volunteer work data
    createBtn.addEventListener('click',function (event) {
        //the form won't be created if the data is not valid
        if(!validateForm(title,description,date,error)) {
            event.preventDefault();
        }
    });

    //hide the pop up form and show the created volunteer works when the cancel btn is clicked
    cancelCreateVolunteerBtn.addEventListener('click', function () {

        HideFormShowEvents(popUpCreate);
        
        resetForm(form,photoSelected,choosePhoto,error);

    });

    //hide the pop up create form when the blured background is clicked
    popUpCreate.addEventListener('click',function (event) {
        //don't hide it when the from it self is clicked
        if(event.target == popUpCreateInner || popUpCreateInner.contains(event.target)) {
            return;
        }

        //otherwise hid it
        HideFormShowEvents(popUpCreate);
        
        //reset the form
        resetForm(form,photoSelected,choosePhoto,error);

    });

    //change the text of the label when a photo get uploaded
    uploadFileDiv.addEventListener('change', function () {
        changeImageLabel(photoSelected,choosePhoto);
    });



    /* ----[Displaying] the menu for deleting and editing of events---- */

    //when the three dots are clicked
    workMenuBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation(); //stop the click event from reaching other listeners


            //open the menu for the event when the three dots are being clicked
            const menu = (this.nextElementSibling).nextElementSibling;
            if(window.getComputedStyle(menu).display === 'none') {

                //hide other menus if they are opened
                workMenu.forEach(function(e) {
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

    //hide all menus when the users clicks anywhere in the document
    document.addEventListener('click', function () {
        workMenu.forEach(function(e) {
            e.style.display = 'none';
        })
    });



    /* ----Handle [Deleting] volunteer works---- */

    //when the delete option is clicked
    deleteWorkBtn.forEach(function (listItem) {


        listItem.addEventListener('click',function (event) {
            
            const link = listItem.firstElementChild;

            //prevent default behivor of link
            //event.preventDefault();
            
            //get the work id of the volunteer work that needs to be deleted
            const workId = link.getAttribute("data-work-id");

            //display the confrim delete pop up
            popUpForDelete.classList.add("active");

            //set the path and pass the work id to the php file that handels the deleting of volunteer works
            const attValue = 'includes/volunteer.delete.inc.php?id=' + workId;
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



    /* ----Handle [Editing] volunteer works---- */

    //make the date input feild starts from todays date
    dateForEditForm.setAttribute('min', today);

    //When the edit option is clicked
    editWorkBtn.forEach(function (listItem) {
        
        listItem.addEventListener('click', function (event) {

            //prevent default behavior of link
            //event.preventDefault();

            const link = listItem.firstElementChild;

            //get the event id of the event needed to be edited
            const workId = link.getAttribute("data-work-id");

            dummyFeildForWorkId.value = workId;

            //get the event data
            const title = link.getAttribute("data-work-title");
            const description = link.getAttribute("data-work-description");
            const startDate = link.getAttribute("data-work-startdate");
            const imagePath = link.getAttribute("data-work-image");

            //add the exsiting data to the edit form pop up
            titleForEditForm.value = title;
            descForEditForm.value = description;
            dateForEditForm.value = startDate;
            dummyFeildOldImagePath.value = imagePath;

            //check if there's a photo selected or it's the default one
            if(imagePath !== 'uploads/defaultWork.jpg') {
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
        
        resetForm(editForm,photoSelectedEditForm,choosePhotoEditForm,editFormError);
    });

    //hide the pop up edit form when the blured background is clicked
    popUpEdit.addEventListener('click',function (event) {
        //don't hide it when the from it self is clicked
        if(event.target == popUpEditInner || popUpEditInner.contains(event.target)) {
            return;
        }

        //otherwise hid it
        HideFormShowEvents(popUpEdit);

        //reset the form
        resetForm(editForm,photoSelectedEditForm,choosePhotoEditForm,editFormError);

    });

    uploadFileDivForEdit.addEventListener('change',function () {
        changeImageLabel(photoSelectedEditForm,choosePhotoEditForm);
    });



    /* ----[Showing] more or less of the Description---- */

    //when the read more/less text is clicked
    workDesc.forEach(function (desc) {
        //get the read more links
        const readMoreLink = desc.nextElementSibling;

        //check if text is truncated (got cut off) or not by
        //by comparing the actual text height with the the text height visible to the user
        if(desc.scrollHeight > desc.clientHeight + 1) {
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

    //When the rigister in this work button is clicked
    if(workRegBtn) {
        workRegBtn.forEach(function (btn) {
            btn.addEventListener('click', function () {

                //get work id of the volunteer work that the user wants to register in
                const workId = btn.getAttribute("data-work-id");

                //show the confirm/cancel registration pop up 
                popUpConfReg.classList.add("active");

                //direct the user to the php file that handel the rigisteration
                filePath = 'includes/volunteer.registration.inc.php?id=' + workId;
                

            });
        });
    }
    
    //hide and confirm registration when the blured background is clicked
    popUpConfReg.addEventListener('click',function (event) {
        //dont' hide it when the pop up it self is clicked
        if(event.target == popUpInnerReg || popUpInnerReg.contains(event.target)) {
            return;
        }
        //otherwise hide it
        popUpConfReg.classList.remove("active");
        //go to the php file to handle the registration
        window.location.href = filePath;
    });



    /* ----Handle the [Cancel] registeration of works the user volunteered in---- */

    //handel the cancel registration of events
    cancelRegisterBtn.forEach(function (btn) {
        btn.addEventListener('click',function() {

            //get the work id of the volunteer work that the user want's to cancel thier registration in
            const workId = btn.getAttribute('data-work-id');

            //show the cancel registration pop up
            popUpCancelReg.classList.add("active");

            //set the php file path the work id with it inside the href attribte for the (no) btn
            const attValue = "includes/volunteer.cancel.registration.inc.php?id=" + workId;
            yesCancelRegBtn.setAttribute('href',attValue);

        });
    });

    //hide the cancel registration pop up when the the (no) btn is clicked
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
            const workId = divBtn.getAttribute("data-work-id");
            //redirect the user to the memebers-registered page with the eventId 
            window.location.href = './volunteer-memebers-registered.php?workId=' + workId;
        });
    });



    /* ----[Resting] the form after returning from the server after creating new volunteer work---- */

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