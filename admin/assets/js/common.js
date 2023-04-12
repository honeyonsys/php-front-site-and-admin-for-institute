$(document).ready(function(){
    let sessionEmailName = localStorage.getItem(sessionEmail);
    let sessionTokenName = localStorage.getItem(sessionToken);
    if(sessionEmailName == null && sessionTokenName == null) {
        window.location.href="login.html";
    }
    $('header').load("headerNav.html");
    
    //checking every 2 minutes that the token is valid or not
    setInterval(function() {
        $.ajax({
            url: apiVerifyToken,
            method: "post",
            data: JSON.stringify({"token": localStorage.getItem(sessionToken)}),
            complete: function(res) {
                let response = JSON.parse(res.responseText);
                if(response['status'] == "0") {
                    localStorage.removeItem(sessionEmail);
                    localStorage.removeItem(sessionToken);
                    window.location.href = "login.html";
                } else {
                    //do something if the session is valid
                }
            }
        });
    }, 120000);

    $("body").on("click", "#logoutBtn", function() {
        //sending request to logout endpoint to remove session token from user data row
        $.ajax({
            url: apiLogoutUser,
            method: "post",
            data: JSON.stringify({"email": localStorage.getItem(sessionEmail)}),
            headers: {"token": localStorage.getItem(sessionToken)},
            complete: function(res) {
                
                localStorage.removeItem(sessionEmail);
                localStorage.removeItem(sessionToken);
                window.location.href = "login.html";
                // if(response['status'] == "1") {
                    
                // } else {
                //     alert(response['message']);
                // }
            }
        });
    });
});
