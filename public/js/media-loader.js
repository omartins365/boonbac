var loaderPreviews = document.querySelectorAll("article .loader-preview");
//I added event handler for the file upload control to access the files properties.
document.addEventListener("DOMContentLoaded", init, false);

//To save an array of attachments
var AttachmentArray = [];

//counter for attachment array
var arrCounter = 0;

if (upload_limit == undefined) {
    var upload_limit = 15;
}
if (upload_size == undefined) {
    var upload_size = 10240;
}
//to make sure the error message for number of files will be shown only one time.
var filesCounterAlertStatus = false;

//un ordered list to keep attachments thumbnails
var ul = document.createElement("ul");
ul.className = "thumb-Images";
ul.id = "imgList";


function init() {
    //add javascript handlers for the file upload event
    document
        .querySelector("#files")
        .addEventListener("change", handleFileSelect, false);
}

//the handler for file upload event
function handleFileSelect(e) {
    //to make sure the user select file/files
    if (!e.target.files) return;

    //To obtaine a File reference
    var files = e.target.files;

    // Loop through the FileList and then to render image files as thumbnails.
    for (var i = 0, f;
        (f = files[i]); i++) {
        //instantiate a FileReader object to read its contents into memory
        var fileReader = new FileReader();

        // Closure to capture the file information and apply validation.
        fileReader.onload = (function(readerEvt) {
            return function(e) {
                //Apply the validation rules for attachments upload
                ApplyFileValidationRules(readerEvt);

                //Render attachments thumbnails.
                RenderThumbnail(e, readerEvt);

                //Fill the array of attachment
                FillAttachmentArray(e, readerEvt);
            };
        })(f);

        // Read in the image file as a data URL.
        // readAsDataURL: The result property will contain the file/blob's data encoded as a data URL.
        // More info about Data URI scheme https://en.wikipedia.org/wiki/Data_URI_scheme
        fileReader.readAsDataURL(f);
    }
    document
        .getElementById("files")
        .addEventListener("change", handleFileSelect, false);
}

//To remove attachment once user click on x button
jQuery(function($) {
    $("div").on("click", ".img-wrap .close", function() {
        var id = $(this)
            .closest(".img-wrap")
            .find("img")
            .data("id");

        //to remove the deleted item from array
        var elementPos = AttachmentArray.map(function(x) {
            return x.FileName;
        }).indexOf(id);
        if (elementPos !== -1) {
            AttachmentArray.splice(elementPos, 1);
        }

        //to remove image tag
        $(this)
            .parent()
            .find("img")
            .not()
            .remove();

        //to remove div tag that contain the image
        $(this)
            .parent()
            .find("div")
            .not()
            .remove();

        //to remove div tag that contain caption name
        $(this)
            .parent()
            .parent()
            .find("div")
            .not()
            .remove();

        //to remove li tag
        var lis = document.querySelectorAll("#imgList li");
        for (var i = 0;
            (li = lis[i]); i++) {
            if (li.innerHTML == "") {
                li.parentNode.removeChild(li);
            }
        }
    });
});

//Apply the validation rules for attachments upload
function ApplyFileValidationRules(readerEvt) {
    //To check file type according to upload conditions
    if (CheckFileType(readerEvt.type) == false) {
        alert(
            "The file (" +
            readerEvt.name +
            ") does not match the upload conditions, You can only upload jpg/png/gif files"
        );
        readerEvt.preventDefault();
        return;
    }

    //To check file Size according to upload conditions
    if (CheckFileSize(readerEvt.size) == false) {
        alert(
            "The file (" +
            readerEvt.name +
            ") does not match the upload conditions, The maximum file size for uploads should not exceed " + (upload_size / 1024) + "MB"
        );
        readerEvt.preventDefault();
        return;
    }

    //To check files count according to upload conditions
    if (CheckFilesCount(AttachmentArray) == false) {
        if (!filesCounterAlertStatus) {
            filesCounterAlertStatus = true;
            alert(
                "You have added more than " + upload_limit + " files. According to upload conditions you can upload " + upload_limit + " files maximum"
            );
        }
        readerEvt.preventDefault();
        return;
    }
}

//To check file type according to upload conditions
function CheckFileType(fileType) {
    if (fileType == "image/jpeg") {
        return true;
    } else if (fileType == "image/png") {
        return true;
    } else if (fileType == "image/gif") {
        return true;
    } else {
        return false;
    }
    return true;
}

//To check file Size according to upload conditions
function CheckFileSize(fileSize) {
    if (fileSize < (upload_size * 1024)) {
        return true;
    } else {
        return false;
    }
    return true;
}

//To check files count according to upload conditions
function CheckFilesCount(AttachmentArray) {
    //Since AttachmentArray.length return the next available index in the array,
    //I have used the loop to get the real length
    var len = 0;
    for (var i = 0; i < AttachmentArray.length; i++) {
        if (AttachmentArray[i] !== undefined) {
            len++;
        }
    }
    //To check the length does not exceed 10 files maximum
    if (len > upload_limit) {
        return false;
    } else {
        return true;
    }
}

//Render attachments thumbnails.
function RenderThumbnail(e, readerEvt) {
    var li = document.createElement("li");
    ul.appendChild(li);
    li.innerHTML = [
        '<div class="img-wrap"> <span class="close">&times;</span>' +
        '<img class="thumb" src="',
        e.target.result,
        '" title="',
        escape(readerEvt.name),
        '" data-id="',
        readerEvt.name,
        '"/>' + "</div>"
    ].join("");

    var div = document.createElement("div");
    div.className = "FileNameCaptionStyle";
    li.appendChild(div);
    div.innerHTML = [readerEvt.name].join("");
    document.getElementById("Filelist").insertBefore(ul, null);
}

//Fill the array of attachment
function FillAttachmentArray(e, readerEvt) {
    AttachmentArray[arrCounter] = {
        AttachmentType: 1,
        ObjectType: 1,
        FileName: readerEvt.name,
        FileDescription: "Attachment",
        NoteText: "",
        MimeType: readerEvt.type,
        Content: e.target.result.split("base64,")[1],
        FileSizeInBytes: readerEvt.size
    };
    arrCounter = arrCounter + 1;
}
//console.debug(AttachmentArray);
$("#upload_media").click(function(e) {
    console.log(e);
    e.preventDefault();
    $('#upload_media').attr('disabled', '');
    if (AttachmentArray == []) {
        $('#loader_msg').attr("class", "danger h5").html('you have not selected any image');
        $('#upload_media').removeAttr('disabled');
        return;
    }
    console.log(AttachmentArray);
    var payload = JSON.stringify(AttachmentArray);
    var mode_el = document.querySelector('#media-upload-mode');
    if (mode_el) {
        var mode = mode_el.value;
    } else {
        var mode = "full";
    }
    var mtype = document.querySelector("input[name=media-upload-type]");
    if (mtype) {
        var type = mtype.value;
    } else {
        var type = "question";
    }

    $('#loader_msg').attr("class", "h5").html('<div class=\"text-center\"><div class=\"spinner-border\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></div>Saving images... please wait...');

    $.ajax({
        url: $('#action_loader').value,
        type: "POST",
        data: {
            payload: payload,
        },
        success: function(data) {
            try {
                document.querySelector("#imgList").innerHTML = "";
            } catch (error) {

            }

            AttachmentArray = [];
            //console.log(data);
            if (data == "" || data == null) {
                $('#loader_msg').attr("class", "text-danger h5");
                $('#loader_msg').html('Something went wrong: Please try again...');
                $('#upload_media').removeAttr('disabled');
            }
            try {
                var response = JSON.parse(data);
                var status = response['status'];
                if (status === "success") {
                    $('#loader_msg').attr("class", "text-success h5");
                    $('#loader_msg').html(response['msg']);

                    // console.info(response['console']);
                    loaderPreviews = document.querySelectorAll(".loader-preview");
                    loaderPreviews.forEach(
                        el => el.addEventListener('click', ev => {

                            img = el;
                            console.log(img.dataset);
                            document.querySelector('#img-view').src = img.dataset.src;
                            document.querySelector('#img-alt').innerHTML = img.dataset.alt;
                            document.querySelector('#img-desc').innerHTML = img.dataset.caption;
                            $('#model-img-view').modal();
                        })
                    )
                    if (type == "person") {
                        window.location.reload();
                    } else {
                        // console.log(response['preview']);
                        $('#loader-preview-container').prepend(response['preview']);

                        document.querySelectorAll("article .loader-preview").forEach(
                            el => el.addEventListener('click', ev => {
                                img = el;
                                console.log(img.dataset);
                                document.querySelector('#img-view').src = img.dataset.src;
                                document.querySelector('#img-alt').innerHTML = img.dataset.alt;
                                document.querySelector('#img-desc').innerHTML = img.dataset.caption;
                                // $('#model-img-view').modal();
                                var myModal = new bootstrap.Modal(document.querySelector('#model-img-view'));
                                myModal.show();

                            })
                        )
                    }
                } else {
                    $('#loader_msg').attr("class", "text-danger h5");
                    $('#loader_msg').html(response['msg']);

                }
            } catch (e) {
                console.error(e);
                // $("#loader_msg").html(data);
            }



            //console.debug(AttachmentArray);

        },
        error: function($e) {
            console.error($e);
            // alert($e.responseJSON.message || "");
            $("#loader_msg").html("Something went wrong, please try again");
        }
    });
    $('#upload_media').removeAttr('disabled');
});


//lazy loader
const images = document.querySelectorAll(".loader-preview");

const imgOptions = {};
const imgObserver = new IntersectionObserver((entries, imgObserver) => {
    entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const img = entry.target;
        img.src = img.dataset.src;
        imgObserver.unobserve(entry.target);
    });
}, imgOptions);

images.forEach((img) => {
    imgObserver.observe(img);
});

// loaderPreviews.forEach(
//     el => el.addEventListener('click', ev => {
//         img = el;
//         console.log(img.dataset);
//         document.querySelector('#img-view').src = img.dataset.src;
//         document.querySelector('#img-alt').innerHTML = img.dataset.alt;
//         document.querySelector('#img-desc').innerHTML = img.dataset.caption;
//         var myModal = new bootstrap.Modal(document.querySelector('#model-img-view'));
//         myModal.show();
//     })
// )


// document.querySelectorAll(".media-setter").forEach(
//     el => el.addEventListener('click', ev => {
//         document.querySelector('#img-dest').setAttribute("value", el.dataset.dest);

//         var myModal = new bootstrap.Modal(document.querySelector('#media-library'));
//         myModal.show();
//     })
// )

// var selectMedia = document.querySelector("#select-media");
// if (selectMedia) {
//     selectMedia.addEventListener('click', function() {
//         var selImage = document.querySelector("input[name=mediaradio]:checked");

//         if (selImage) {
//             var cimg = selImage.value;
//             console.log(selImage.dataset);
//             //update form
//             saveto = document.querySelector('#img-dest').value;
//             document.querySelector('input[name=' + saveto + ']').setAttribute("value", cimg);
//             //set preview
//             document.querySelector('#media-preview-' + saveto).src = selImage.dataset.src;
//             //close modal
//             var myModal = bootstrap.Modal.getOrCreateInstance(document.querySelector('#media-library'));
//             myModal.hide();

//         } else {
//             alert("please select an image then try again or choose remove image and try again");
//         }
//     });
// }
