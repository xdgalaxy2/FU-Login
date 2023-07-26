// js/script.js
$(document).ready(function() {
  // Function to handle form submission via AJAX
  function handleFormSubmit(formId) {
    var formData = $("#" + formId).serialize();

    $.ajax({
      type: "POST",
      url: "login_and_register.php",
      data: formData,
      success: function(response) {
        // Handle the response from the server
        // You can update the DOM here if needed or show success/failure messages
        console.log(response);
        // For example, to show success messages
        if (response.indexOf("Create Account Successful") !== -1) {
          $(".float-success").html("<p>Create Account Successful</p>").show();
        } else if (response.indexOf("Error creating account") !== -1) {
          $(".float-error").html("<p>Error creating account<br>Please fix the errors in the form.</p>").show();
        } else if (response.indexOf("Incorrect password") !== -1 || response.indexOf("ID number not found") !== -1) {
          $(".float-error-login").html("<p>Incorrect ID number or password</p>").show();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        // Handle the error if the request fails
        console.log("Error:", textStatus, errorThrown);
      }
    });
  }

  // Listen for form submissions
  $("#login-form").on("submit", function(event) {
    event.preventDefault();
    handleFormSubmit("login-form");
  });

  $("#signup-form").on("submit", function(event) {
    event.preventDefault();
    handleFormSubmit("signup-form");
  });
});
