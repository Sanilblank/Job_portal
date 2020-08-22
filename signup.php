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
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div">
                <form action="signup.php" method="POST">
                    <h2 class="text-center">Register</h2>

                    <?php if (count($errors) > 0) { ?>
                        <div class="alert alert-danger">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <?php foreach ($errors as $error) { ?>
                                <?php echo $error  . "<br>" ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="<?php echo $email; ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="passwordConf">Confirm Password</label>
                        <input type="password" name="passwordConf" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <p class="text-center radio">Select type of account</p>
                        <div class="text-center radio">
                            <input type="radio" name="accountType" value="seeker">
                            <label for="seeker">Job Seeker</label>
                            <input type="radio" name="accountType" value="provider">
                            <label for="provider">Job Provider</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="signup-btn" class="btn btn-primary btn-block btn-lg">Sign Up</button>
                    </div>
                    <p class="text-center">Already a member? <a href="login.php">Sign In</a></p>
                </form>
            </div>
        </div>
    </div>

</body>

</html>