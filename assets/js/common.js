$(document).ready(function(){
   $('header').load("./header.html");
   $('footer').load("./footer.html");

   setTimeout(function() {
      let sessionEmailName = localStorage.getItem(frontSessionEmail);
      let sessionTokenName = localStorage.getItem(frontSessionToken);
      let sessionUserType = localStorage.getItem(frontSessionUserType);
      // if(sessionEmailName == null && sessionTokenName == null) {
      //    window.location.href="loginpage.html";
      // }
      if(sessionEmailName == null && sessionTokenName == null) {
         $(".topIconsRight").html('<a href="loginpage.html?login=student"><div class="topBtn">Login Student</div></a>    <a href="loginpage.html?login=teacher"><div class="topBtn">Login Teacher</div></a>');    
      } else {
            let dashlink = "dashboardstudent.html";
            if(sessionUserType == 2) {
               dashlink = "dashboardteacher.html";
            }
            $(".topIconsRight").html('<a href="'+dashlink+'"><div class="topBtn">Dashboard: '+sessionEmailName+'</div></a> <a href="#" id="frontLogoutBtn"><div class="topBtn">Logout</div></a>');
      }
   }, 3000);

   $("body").on("click", "#frontLogoutBtn", function(event) {
      event.preventDefault();
      //sending request to logout endpoint to remove session token from user data row
      $.ajax({
          url: "admin/"+apiLogoutUser,
          method: "post",
          data: JSON.stringify({"email": localStorage.getItem(frontSessionEmail)}),
          headers: {"token": localStorage.getItem(frontSessionToken)},
          complete: function(res) {
              
              localStorage.removeItem(frontSessionEmail);
              localStorage.removeItem(frontSessionToken);
              localStorage.removeItem(frontSessionUserType);
              window.location.href = "loginpage.html";
              // if(response['status'] == "1") {
                  
              // } else {
              //     alert(response['message']);
              // }
          }
      });
  });
});