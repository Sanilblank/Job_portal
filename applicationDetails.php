<?php
require 'includes/jobprovider_header.php';
require 'controllers/authController.php';
?>
<section>

    <?php
    if (isset($_GET['job_id']) && isset($_GET['applied_username'])) {
        $jobid = $_GET['job_id'];
        $appliedusername = $_GET['applied_username'];

        $sql = "SELECT * FROM seekerdetails WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('jobproviderapplications.php?error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $appliedusername);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $seeker = mysqli_fetch_assoc($result);
        }
    }

    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-4 divTable">
                <h2 class="text-center" style="margin-bottom: 25px;">Application Details</h2>
                <hr>
                <h3 style="margin-bottom: 25px;">Username: <?php echo $seeker['username']; ?></h3>
                <hr>
                <h3 style="margin-bottom: 25px;">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $seeker['name']; ?></h3>
                <hr>
                <h3 style="margin-bottom: 25px;">Address: &nbsp; &nbsp;<?php echo $seeker['address']; ?></h3>
                <hr>
                <h3 style="margin-bottom: 25px;">Email:&nbsp;&emsp;&nbsp; <?php echo $seeker['email']; ?></h3>
                <hr>
                <a href="uploads/Sabita.pdf" download>
                    <p style="font-size: 22px; margin-top:25px; margin-bottom:25px;"><i class="far fa-file-pdf"> Click to download CV </i></p>
                </a>



            </div>
        </div>
    </div>


</section>

<?php
require 'includes/jobprovider_footer.php';
?>