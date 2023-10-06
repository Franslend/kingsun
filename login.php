<?php
    // The session will start here and if it results in an error, change the port to 3306 and turn off MYSQL80//
    session_start();
    if (isset($_SESSION['user'])) {
        header('location: dashboard.php');
    }

    $error_message = '';

    if ($_POST) {
        include('database/connection.php');
        $username = $_POST['username'];
        $password = $_POST['password'];
        $employee_id = $_POST['employee_id'];
        $query = 'SELECT * FROM users WHERE users.email="' . $username . '" AND users.employee_id='.$employee_id.'';
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
          $user = $stmt->fetchAll()[0];
          if (password_verify($password, $user["password"])) {
            $_SESSION['user'] = $user;
            if ($user['role'] == 'manager') {
              header('Location: dashboard.php');
            }else{
              header('Location: pos.php');
            }
          }else{
            $error_message = 'Please make sure that the Employee ID, Username and Password you entered are correct.';
          }
        } else {
            $error_message = 'Please make sure that the Employee ID, Username and Password you entered are correct.';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KIS Login - KingSun Inventory System</title>
    <script src="https://kit.fontawesome.com/8bf423e820.js" crossorigin="anonymous"></script>
    <!--if you edit your css and it won't change anything...try this -->
    <link rel="stylesheet" type="text/css" href="css/login.css?v=<?php echo time(); ?>">
    
</head>
<style>
  /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<body id="loginBody">
    <div class="container centered">
        <div class="loginHeader">
            <center><img src="./css/kin.png" alt="DSMS Logo" width="300"></center>
            <p>Product Information System</p>
        </div>
        <div class="loginBody">
            <form action="login.php" method="POST">
                <?php if (!empty($error_message)) { ?>
                    <div id="errorMessage">
                        <p>Error: <?= $error_message ?> </p>
                    </div>
                <?php } ?>
                <!-- <div class="loginAsContainer">
                    <label>Login As:</label>
                    <div class="checkboxContainer">
                        <input type="checkbox" name="loginType" value="manager" onclick="handleCheckboxSelection(this)">
                        <label>Manager</label>
                    </div>
                    <div class="checkboxContainer">
                        <input type="checkbox" name="loginType" value="employee" onclick="handleCheckboxSelection(this)">
                        <label>Employee</label>
                    </div>
                </div> -->
                <div class="mustBeCenter">
                    <div class="form-control">
                        <i class="far fa-user"></i>
                        <input type="number" name="employee_id" required="">
                        <label>
                            <span style="transition-delay:0ms">Y</span>
                            <span style="transition-delay:50ms">o</span>
                            <span style="transition-delay:100ms">u</span>
                            <span style="transition-delay:150ms">r</span>
                            <span style="transition-delay:200ms"> </span>
                            <span style="transition-delay:250ms">I</span>
                            <span style="transition-delay:300ms">D</span>
                            
                        </label>
                    </div>
                    <div class="form-control">
                        <i class="far fa-envelope"></i>
                        <input type="text" name="username" required="">
                        <label>
                            <span style="transition-delay:0ms">U</span>
                            <span style="transition-delay:50ms">s</span>
                            <span style="transition-delay:100ms">e</span>
                            <span style="transition-delay:150ms">r</span>
                            <span style="transition-delay:200ms">n</span>
                            <span style="transition-delay:250ms">a</span>
                            <span style="transition-delay:300ms">m</span>
                            <span style="transition-delay:350ms">e</span>
                        </label>
                    </div>
                    <div class="form-pass">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" required="">
                        <label>
                            <span style="transition-delay:0ms">P</span>
                            <span style="transition-delay:50ms">a</span>
                            <span style="transition-delay:100ms">s</span>
                            <span style="transition-delay:150ms">s</span>
                            <span style="transition-delay:200ms">w</span>
                            <span style="transition-delay:250ms">o</span>
                            <span style="transition-delay:300ms">r</span>
                            <span style="transition-delay:350ms">d</span>
                        </label>
                    </div>
                </div>
                    <div class="loginButtonContainer">
                        <button type="submit">Login</button>
                    </div>
                    <div class="forgotPasswordContainer">
                    <a href="#" id="forgotPasswordLink" onclick="openModal('forgotPasswordModal')">Forgot Password?</a>
                    </div>
            </form>
        </div>


        <div id="forgotPasswordModal" class="modals ">
            <div class="modal-content-cutie ">
                <span class="closed" onclick="closeModal()">&times;</span>
                <form id="forgotPasswordForm" method="POST">
                <div class="form-controling-u">
                   <label>Enter your email</label>
                    <input type="email" name="email" style="width:100%" required>
                </div>
                <div class="loginButtonContainers">
                    <button id="sendVerificationButton" onclick="sendVerificationCode()">Send Verification Code</button>
                </div>
                </form>
            </div>

            <div id="verificationModal" class="modals ">
                <div class="modal-content-cutie ">
                <span class="closed" onclick="closeModal()">&times;</span>
                <h2>Verification Code Sent</h2>
                <p>A verification code has been sent to your email address. Please check your inbox and enter the code below:</p>
                <input type="text" id="verificationCode" placeholder="Enter verification code" style="width:100%" required>
                <div class="loginButtonContainers">
                <button id = "v_code_sub" onclick="submitVerificationCode()">Submit</button>
                </div>
                </div>
            </div>

            <div id="resetPasswordModal" class="modals">
                <div class="modal-content-cutie">
                <span class="closed" onclick="closeModal()">&times;</span>
              
                    <label for="new-password">New Password:</label>
                    <input type="password" id="new-password" name="new-password" style="width:100%" required><br><br>
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" style="width:100%" required><br><br>
                    <div class="loginButtonContainers">
                    <button id="c_pass"  onclick="resetPassword()">Reset now</button>
                </div>
                
                </div>
            </div>
        </div>


</div>


  <script src="./js/script.js"></script>
  <script src="./js/jquery/jquery-3.5.1.min.js"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
<script>

// for checkbox, only one checkbox
function handleCheckboxSelection(checkbox) {
    var checkboxes = document.getElementsByName('loginType[]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] !== checkbox) {
            checkboxes[i].checked = false;
        }
    }
}
function openModal(modalId) {
  var modal = document.getElementById(modalId);
  modal.style.display = 'block';
}
function closeModal() {
  var modals = document.querySelectorAll('.modals');
  modals.forEach(function(modal) {
    modal.style.display = 'none';
  });
  document.body.classList.remove('blurred');
}
function sendVerificationCode() {
  var email = document.querySelector('#forgotPasswordForm input[name="email"]').value;
  if (email == '' || email == null) {
    return false;
  }
  //sendPasswordResetEmail(email);
  var data = { email: email, phpmailer:'send_code' };
  phpMailer(data);
}
function submitVerificationCode() {
  var verificationCode = document.getElementById('verificationCode').value;
  var email = document.querySelector('#forgotPasswordForm input[name="email"]').value;
  if (verificationCode == '' || verificationCode == null || email == '' || email == null) {
    return false;
  }
  var data = { email:email, v_code:verificationCode, phpmailer:'v_code' };
  phpMailer(data);
}
function resetPassword() {
  var newPassword = document.getElementById('new-password').value;
  var confirmPassword = document.getElementById('confirm-password').value;
  var email = document.querySelector('#forgotPasswordForm input[name="email"]').value;
  if (newPassword != '' || confirmPassword != '') {
    if (newPassword !== confirmPassword) {
      alert('Passwords do not match. Please try again.');
    } else {
      var data = { email:email, newPassword:newPassword, phpmailer:'c_pass' };
      phpMailer(data);
    }
  } else {
    alert('Input Required');
  }

  return false;
}
function phpMailer(data) {
    $.ajax({
          url: "fetchProduct.php",
          type: "POST",
          data: data,
          dataType: "json",
          beforeSend: function(response){
            $('#sendVerificationButton').prop('disabled', true).html('Please wait sending...');
            $('#v_code_sub').prop('disabled', true).html('Verifying please wait...');
            $('#c_pass').prop('disabled', true).html('Updating Please wait...');
          },
          success: function(response) {
            $('#sendVerificationButton').prop('disabled', false).html('Send Verification Code');
            $('#v_code_sub').prop('disabled', false).html('Submit');
            $('#c_pass').prop('disabled', false).html('Reset now');
            switch (data.phpmailer) {
              case 'send_code':
                if (response.msg) {
                  openModal('verificationModal');
                  alert('Code has been sent!');
                }else{
                  alert("Email doesn't exist!");
                }
                break;
              case 'v_code':
                if (response.msg) {
                  openModal('resetPasswordModal');
                }else{
                 alert('Invalid verification code. Please try again.');
                }
                break;
              case 'c_pass':
                if (response.msg) {
                  alert('Password reset successful!');
                  closeModal();
                }else{
                 alert('Please try again!');
                }
                break;
              default:
                alert("ERROR");
                break;
            }
          },
          error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
          }
        });
}

    </script>
</body>

</html>



