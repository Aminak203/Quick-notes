<!doctype html>
<html lang="en">
<head>

  <style>
    #toast-container>.toast-success {
        background-color: green;
    }
    #toast-container>.toast-error {
        background-color: red;
    }
</style>

  <title>Forgot Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
  <div class="section">
    <div class="container">
      <div class="row full-height justify-content-center">
        <div class="col-12 text-center align-self-center py-5">
          <div class="section pb-5 pt-5 pt-sm-2 text-center">
            <h4 class="mb-4 pb-3">Forgot Password</h4>
            <form id="reset-password-form" method="post">
                <div class="form-group">
                    <input type="text" name="UserName" id="UserName" class="form-style" placeholder="Enter your UserName" required>
                    <i class="input-icon uil uil-user"></i>
                </div>
                <button type="button" id="submit_send_otp" class="btn mt-4">Send OTP</button>
            </form>
            
            <br>
            <div id="otp-section" style="display:none;">
              <form id="verify-otp-form" method="post">
                <div class="form-group">
                  <input type="text" name="otp" id="otp" class="form-style" placeholder="Enter the OTP" required>
                  <i class="input-icon uil uil-lock"></i>
                </div>
                <button type="button" id="submit_verify_otp" class="btn mt-4">Verify OTP</button>
              </form>
            </div>
            <div id="password-update-section" style="display:none;"><br>
              <form id="update-password-form" method="post">
                <div class="form-group">
                  <input type="password" name="new_password" id="new_password" class="form-style" placeholder="Enter your new password" required>
                  <i class="input-icon uil uil-lock"></i>
                </div>
                <br>
                <div class="form-group">
                  <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-style" placeholder="Confirm your new password" required>
                  <i class="input-icon uil uil-lock"></i>
                </div>
                <input type="hidden" name="otp" id="hidden-otp">
                <button type="button" id="submit_change_password" class="btn mt-4">Update Password</button>
              </form>
            </div>
            <div id="update-password-result"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
        $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // $("#submit_send_otp").click(function() {
        //     $.ajax({
        //         url: 'passswordlink.php',
        //         method: 'POST',
        //         data: {
        //             email: $("#email").val(),
        //             submit_send_otp: true
        //         },
        //         success: function(response) {
        //             toastr.success(response);
        //             $("#otp-section").show();
        //         },
        //         error: function() {
        //             toastr.error('Error sending OTP. Please try again later.');
        //         }
        //     });
        // });

        $(document).ready(function() {
    $("#submit_send_otp").click(function(event) {
        event.preventDefault(); // Add this line to prevent default form submission behavior
        $.ajax({
            url: 'passswordlink.php',
            method: 'POST',
            data: {
                UserName: $("#UserName").val(), // Update this line to use the UserName
                submit_send_otp: true
            },
            success: function(response) {
                toastr.success(response);
                $("#otp-section").show();
            },
            error: function() {
                toastr.error('Error sending OTP. Please try again later.');
            }
        });
    });

        $('#submit_verify_otp').click(function() {
            var otp = $('#otp').val();

            if (otp === '') {
              toastr.alert('Please enter the OTP.');
                return false;
            }

            $.ajax({
                url: 'verify_otp.php',
                type: 'POST',
                data: {
                    otp: otp
                },
                success: function(response) {
                    if (response.trim() === 'success') {
                      toastr.success('OTP verified successfully.');
                        $('#otp-section').hide();
                        $('#password-update-section').show();
                        // Set the hidden OTP field value
                        $('#hidden-otp').val(otp);
                    } else {
                      toastr.error('Incorrect OTP. Please try again.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });

        $('#submit_change_password').click(function() {
    var new_password = $('#new_password').val();
    var confirm_new_password = $('#confirm_new_password').val();
    var otp = $('#hidden-otp').val();

    if (new_password === '' || confirm_new_password === '' || otp === '') {
        toastr.error('Please fill in all the fields.');
        return false;
    }

    $.ajax({
        url: 'password_c_otp.php',
        type: 'POST',
        data: {
            UserName: $("#UserName").val(),
            new_password: new_password,
            confirm_new_password: confirm_new_password,
            otp: otp,
            submit_change_password: 1
        },
        success: function(response) {
            if (response.trim() === "Password changed successfully") {
                toastr.success(response);
                setTimeout(function() {
                    window.location.href = 'main.php';
                }, 2000);
            } else {
                toastr.error(response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            toastr.error('Error updating password. Please try again later.');
        }
    });
});

    });
    

  });
  </script>
</body>
</html>

