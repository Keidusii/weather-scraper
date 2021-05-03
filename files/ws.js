$("form").on("submit", function (e) {
    var valid = true;
      
    if ($("#city").val() == "") {
        valid = false;
        $("#content").html('<div class="alert alert-danger" role="alert">Please Enter a City!</div>');
    }
    
    if (!valid) {
        e.preventDefault();
    }
})