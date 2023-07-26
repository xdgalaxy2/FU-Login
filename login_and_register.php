<?php
session_start();
require "sqlconnect.php";
require "actions/switch.php";
error_reporting(E_ALL);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FUCS</title>

    <!-- jQuery --> 
    <script src="lib/jquery.min.js"></script>

    <!-- Custom -->
    <script src="js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>            
<div class="login-box">
    <img src="assets/images/FU_logo.png" class="avatar">
    <div class="wrapper">
         <div class="title-text">
            <div class="title login">
               Login
            </div>
            <div class="title signup">
               Signup
            </div>
         </div>
         <div class="form-container">
            <div class="slide-controls">
               <input type="radio" name="slide" id="login" checked>
               <input type="radio" name="slide" id="signup">
               <label for="login" class="slide login">Login</label>
               <label for="signup" class="slide signup">Signup</label>
               <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
                <form class="login" method="post" action="login_and_register.php">
                  <div class="field">
                     <input type="text" name="id_number" placeholder="ID number" required>
                  </div>
                  <div class="field">
                     <input type="password" name="password" placeholder="Password" required>
                  </div>
                  <div class="pass-link">
                     <a href="#">Forgot password?</a>
                  </div>
                  <div class="field btn">
                    <div class="btn-layer"></div>
                     <input type="submit" name="login" value="Login">
                  </div>
                   <?php if (isset($loginError) && !empty($loginError)): ?>
                  <div>
                     <?php echo $loginError; ?>
                  </div>
                  <?php endif; ?>
                  <div class="signup-link">
                     Not a member? <a href="">Signup now</a>
                  </div>
               </form>
               <form class ="signup" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="field">
                        <input type="text" name="name" placeholder="First name" required>
                        <span class="error"><?php echo $nameErr; ?></span>
                    </div>
                    <div class="field">
                        <input type="text" name="lastname" placeholder="Last name" required>
                        <span class="error"><?php echo $lastnameErr; ?></span>
                    </div>
                    <div class="field">
                        <input type="text" name="email" placeholder="Email" required>
                        <span class="error"><?php echo $emailErr; ?></span>
                    </div>
                    <div class="field">
                        <input type="text" name="id_number" placeholder="ID number" required>
                        <span class="error"><?php echo $idNumberErr; ?></span>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                        <span class="error"><?php echo $passwordErr; ?></span>
                    </div>
                    <div class="field">
                        <input type="password" name="confirm_password" placeholder="Confirm password" required>
                        <span class="error"><?php echo $confirmPasswordErr; ?></span>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" name="register" value="Create Account">
                    </div>
                </form>
            </div>
         </div>
      </div>
</div>
<script src="js/error.js"></script>
<script src="js/transition.js"></script>
</body>
</html>