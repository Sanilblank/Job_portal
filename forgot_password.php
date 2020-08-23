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
    <title>Forgot Password</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div login">
                <form action="forgot_password.php" method="POST">
                    <h2 class="text-center">Recover your password</h2>
                    <?php if (count($errors) > 0) { ?>
                        <div class="alert alert-danger">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <?php foreach ($errors as $error) { ?>
                                <?php echo $error  . "<br>" ?>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="forgot-password" class="btn btn-primary btn-block btn-lg">Recover your password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>