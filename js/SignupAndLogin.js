let registerSubmit = $("#registersubmit");

registerSubmit.click(function(e){
    e.preventDefault();
    $.ajax({
        url: "../php/signup.php",
        method: "POST",
        data: $("#registerform").serialize(),
        success: function(data){
            if(data.trim() == "registerd_successfully"){
                window.location.href = "index.php";
                $("#desc").html("Registered Successfully");
            } else {
                console.log("reviewData");  
                $("#signup_msg").html(data);
            }
        }
    });
});