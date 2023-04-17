$(document).ready(function() {
    
    if(localStorage.getItem(frontSessionEmail) == null && localStorage.getItem(frontSessionToken) == null) {
        window.location.href="loginpage.html";
    }


    //checking every 2 minutes that the token is valid or not
    setInterval(function() {
        $.ajax({
            url: "admin/"+ apiVerifyToken,
            method: "post",
            data: JSON.stringify({"token": localStorage.getItem(frontSessionToken)}),
            complete: function(res) {
                let response = JSON.parse(res.responseText);
                if(response['status'] == "0") {
                    localStorage.removeItem(frontSessionEmail);
                    localStorage.removeItem(frontSessionToken);
                    window.location.href = "loginpage.html";
                } else {
                    //do something if the session is valid
                }
            }
        });
    }, 120000);
})