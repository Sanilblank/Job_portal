<?php
require 'includes/jobseeker_header.php';
require 'controllers/authController.php';
?>


<section>
    <?php
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM seekerdetails WHERE username = ? LIMIT 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: jobseekerDashboard.php');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_num_rows($result);
        if (!$user) { ?>

            <div class="col-md-11 offset-md-4 divTable" style="top: 50px; padding-top: 50px; padding-bottom: 50px;">
                <h2 style="text-align: center; margin-bottom: 30px;">It seems you have not updated your profile yet.</h2>

                <h3 style="text-align: center;"><a href="jobseekerProfile.php">Click here</a> to update it.</h3>

            </div>


    <?php } else {
        }
    }
    ?>



    </div>
    </div>




</section>



<?php
require 'includes/jobprovider_footer.php';
?>