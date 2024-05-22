
try {
    // require('./jquery-3.5.1.min');
    require('./bootstrap');
    require('./customer_tx');
    // require('./sw-register');
    // require('./media-loader');
} catch (error) {

}

import intlTelInput from 'intl-tel-input';
import intlTelInputUtils from 'intl-tel-input/build/js/utils';
var input = document.querySelectorAll(".tel-input");
if (input) {
    input.forEach(element => {
        intlTelInput(element, {
            // any initialisation options go here
            hiddenInput: element.dataset.name,
            initialCountry: 'ng',
            placeholderNumberType: 'MOBILE',
            intlTelInputUtils: intlTelInputUtils
        });
    });
}

const delay = (delayInms) => {
    return new Promise(resolve => setTimeout(resolve, delayInms));
};

function empty(n) {
    return !(!!n ? typeof n === 'object' ? Array.isArray(n) ? !!n.length : !!Object.keys(n).length : true : false);
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function getNCookie(cname) {
    return decodeURIComponent(getCookie(cname));
}


function writeCookie(cname, cvalue, exdays = 0) {
    var expires = 0;
    if (exdays != 0) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        expires = "expires=" + d.toUTCString();
    }
    document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/";
}

// function saveToFav(fav_array,prop_id) {


//     fav_p = JSON.stringify(fav_array);

//     writeCookie("fav_p", fav_p, exdays);
// }

// function delFromFav(fav_array,prop_id) {


// }

async function doSaveFavProp(el, prop_id) {

    el.disabled = true;

    //

    if (getCookie("fav_p") != "") {
        var fav_p = getCookie("fav_p");
    }

    var fav_array = [];
    if (fav_p != undefined) {
        fav_array = JSON.parse(fav_p);

    }

    let index = fav_array.indexOf(prop_id);



    if (index >= 0) {
        el.innerHTML = '<i class="fas fa-heart fa-beat-fade"></i> Undoing';
        let delayres = await delay(1000);
        fav_array.splice(index, 1);
        el.innerHTML = '<i class="far fa-heart"></i> Save';
    } else {
        el.innerHTML = '<i class="fas fa-heart fa-beat-fade"></i> Saving';
        let delayres = await delay(1000);
        fav_array.push(prop_id);
        el.innerHTML = '<i class="fas fa-heart"></i>  Saved';
    }


    fav_p = JSON.stringify(fav_array);
    writeCookie("fav_p", fav_p, 365);

    el.disabled = false;
}

function doShare(el, emsg, url) {
    let msg = decodeURIComponent(emsg.replace(/\+/g, ' '));

    console.log(msg);



    document.querySelector("#shareCaption").value = msg + "\n" + url;
    document.querySelector("#shareWhatsapp")?.setAttribute("href", "https://api.whatsapp.com/send?text=" + encodeURIComponent(msg + "\n" + url));
    document.querySelector("#shareTwitter")?.setAttribute("href", "https://twitter.com/intent/tweet?text=" + encodeURIComponent(msg + "\n" + url));
    document.querySelector("#shareFacebook")?.setAttribute("href", "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url));
    document.querySelector("#shareLinkedin")?.setAttribute("href", "https://www.linkedin.com/sharing/share-offsite/?url=" + encodeURIComponent(url));

    let naviShare = document.querySelector(".navi-share");
    if (!navigator.share) {
        naviShare.hidden = true;
    } else {
        naviShare.dataset.shareContent = emsg;
        naviShare.dataset.shareUrl = url;
    }



    var myModal = new bootstrap.Modal(document.getElementById("shareModalToggle"), {});
    //document.onreadystatechange = function () {
    myModal.show();
    //};
}
function copyCaption() {
    if (document.querySelector(".copy-btn")) {
        /* Get the text field */
        var copyText = document.getElementById("shareCaption");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* notify the user that the text has been copied */
        document.querySelector(".copy-btn").innerText = "Text Copied!";
    }
}
window.onload = function () {
    if (navigator.share && document.querySelector(".navi-share")) {
        document.querySelector(".navi-share").addEventListener("click", function () {

            navigator.share({
                title: 'Share Property',
                text: decodeURIComponent(this.dataset.shareContent.replace(/\+/g, ' ') ?? ""),
                url: this.dataset.shareUrl ?? ""
            }).then(() => {
                console.log('Thanks for sharing!');
            })
                .catch(console.error);

        });
    }
    document.querySelector(".copy-btn") && document.querySelector(".copy-btn").addEventListener("click", function () {
        copyCaption();
    });

    let saveBtns = document.querySelectorAll("[data-save-prop]");
    saveBtns.forEach((e) => {

        e.addEventListener("click", function () {
            let prop_id = this.dataset.saveProp;
            prop_id && doSaveFavProp(this, prop_id);
        });
    });

    let shareBtns = document.querySelectorAll("[data-share-content]");
    shareBtns.forEach((e) => {

        e.addEventListener("click", function () {
            let prop_msg = this.dataset.shareContent;
            prop_msg && doShare(this, prop_msg, this.dataset.shareUrl ?? "");
        });
    });

    // let msg_box = document.querySelector('".message-box:first > div.alert:first"');

    if (document.querySelectorAll(".message-box>div.alert").length >= 1) {
        // console.log(window.bootstrap);
        setTimeout(function () {
            var alert_handle = setInterval(function () {
                let bsAlert = new window.bootstrap.Alert(document.querySelectorAll(
                    ".message-box>div.alert")[0]);
                // let bsAlert = window.bootstrap.Alert.getInstance();
                // console.log(bsAlert);
                if (bsAlert) {
                    try {
                        bsAlert.close();
                    } catch (error) {
                        //smile
                    }
                }
                if (document.querySelectorAll(".message-box>div.alert").length < 1) {
                    document.querySelector('.message-box')?.remove();
                    // console.info("handle cleared   : " + alert_handle);
                    clearInterval(alert_handle);
                }
            }, 3000);
        }, 5000);
    }

};
