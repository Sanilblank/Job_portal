<?php
require_once 'controllers/authController.php';
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div login">
                <form action="login.php" method="POST">
                    <h2 class="text-center">Login</h2>
                    <?php if (count($errors) > 0) { ?>
                        <div class="alert alert-danger">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <?php foreach ($errors as $error) { ?>
                                <?php echo $error  . "<br>" ?>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="username">Username or Email</label>
                        <input type="text" name="username" value="<?php if (isset($_COOKIE['cookie_username'])) {
                                                                        echo $_COOKIE['cookie_username'];
                                                                    }  ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" value="<?php if (isset($_COOKIE['cookie_password'])) {
                                                                            echo $_COOKIE['cookie_password'];
                                                                        }  ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember" <?php if (isset($_COOKIE['cookie_username'])) { ?> checked <?php } ?>>
                        <label for="remember">Remember me</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login-btn" class="btn btn-primary btn-block btn-lg">Login</button>
                    </div>
                    <p class="text-center">Not yet a member? <a href="signup.php">Sign Up</a></p>
                    <div style="font-size: 0.9em; text-align:center;"><a href="forgot_password.php">Forgot your Password?</a></div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>