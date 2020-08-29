<?php
require 'includes/jobseeker_header.php';
require 'controllers/authController.php';
?>


<section>
    <div class="container">
        <div class="row">

            <?php
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM seekerdetails WHERE username = ? LIMIT 1";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: jobseekerDashboard.php");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $userCount = mysqli_num_rows($result);
                $user = mysqli_fetch_assoc($result);
                if (!$userCount) {
                    $errors['nouser'] = "Please create your profile first";
                    header("Location: jobseekerDashboard.php?createprofilefirst");
                    exit();
                } else {
            ?>
                    <div class="col-md-11 offset-md-4 heading">
                        <h2 class="h2heading">My Profile</h2>
                    </div>
                    <div class="col-md-11 offset-md-4 divTable">
                        <h2 style="margin-left: 80px; margin-top: 20px;">Username: <?php echo $_SESSION['username']; ?></h2>
                        <hr>
                        <h2 style="margin-left: 80px;">Name: <?php echo $user['name']; ?></h2>
                        <hr>
                        <h2 style="margin-left: 80px;">Address: <?php echo $user['address']; ?> </h2>
                        <hr>
                        <h2 style="margin-left: 80px;">Email: <?php echo $user['email']; ?> </h2>
                        <hr>


                    </div>


            <?php }
            }
            ?>

        </div>
    </div>
</section>

<?php
require 'includes/jobprovider_footer.php';
?>