$(function(){

    loadStudentLists();

    $("#login-form").submit(function(e){
        e.preventDefault();

        $.ajax({
          type        : 'POST',  
          url         : 'actions/verify-user.php',
          data        : $('#login-form').serialize(), // data : $('#form_ID').serialize() or data : {var1:val1,var2:val2}
          dataType    : 'json',  //  xml, html, script, json, text
          beforeSend : function() {
            $('#login-message').html("Verifiying Account.");
          },
          //is called when the server returns success status code, like: 200, 201
          success:function(data){   
              //console.log(data);
            if(data.message=='Password Verified!'){
                $('#login-message').html(data.message);
                /*
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                })
                */
                
                setTimeout(
                    function() 
                    {
                        $(window).attr('location','/FU-Login/');
                    }, 1500);

            }else{

                 $('#login-message').html(data.message);
                setTimeout(
                    function() 
                    {
                         $('#login-message').html("");
                    }, 1000);

                /*
                  Swal.fire({
                    icon: 'warning',
                    title: 'LOGIN',
                    text: data.message,
                    footer: ''
                  })
                 */
            }
              
             
          },
          // is called always when the request is complete. (no matter, it is success/error response from server.)
          complete : function(data,status) {
              //console.log(data.responseText);
          },
          error:function (xhr, ajaxOptions, thrownError){
              console.log(xhr.responseText);
          }
      });

    })