<?php
require 'includes/admin_header.php';
require 'controllers/authController.php';
?>

<?php
$verified = 1;
//Retrieving total no of verified users from database
$sql = "SELECT * FROM users WHERE verified = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('Location: adminDashboard.php?error=sqlerror');
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "i", $verified);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userno = mysqli_num_rows($result);
}

//Retrieving total no of Job Providers from database
$jobProvider = "provider";
$sql = "SELECT * FROM users where accounttype = ? && verified = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('Location: adminDashboard.php?error=sqlerror');
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "si", $jobProvider, $verified);
    mysqli_stmt_execute($stmt);
    $resultProvider = mysqli_stmt_get_result($stmt);
    $userProvider = mysqli_num_rows($resultProvider);
}

//Retrieving total no of Job Seekers from database
$jobSeeker = "seeker";
$sql = "SELECT * FROM users where accounttype = ? && verified = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('Location: adminDashboard.php?error=sqlerror');
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "si", $jobSeeker, $verified);
    mysqli_stmt_execute($stmt);
    $resultSeeker = mysqli_stmt_get_result($stmt);
    $userSeeker = mysqli_num_rows($resultSeeker);
}

//Retrieving total no of Approved Jobs from database
$jobApproved = "Approved";
$sql = "SELECT * FROM jobs where status = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('Location: adminDashboard.php?error=sqlerror');
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $jobApproved);
    mysqli_stmt_execute($stmt);
    $resultApproved = mysqli_stmt_get_result($stmt);
    $userApproved = mysqli_num_rows($resultApproved);
}

//Retrieving total no of Rejected Jobs from database
$jobRejected = "Rejected";
$sql = "SELECT * FROM jobs where status = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('Location: adminDashboard.php?error=sqlerror');
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $jobRejected);
    mysqli_stmt_execute($stmt);
    $resultRejected = mysqli_stmt_get_result($stmt);
    $userRejected = mysqli_num_rows($resultRejected);
}

?>

<section>
    <div class="container">
        <div class="col-md-11 offset-md-4 divTable" style="background: none; border: none;">
            <div class="row">
                <div class="card">
                    <div class="card text-white bg-info mb-3" style="max-width: 18rem; width: 300px">
                        <div class="card-header" style="font-size: 30px;">Total Users</div>
                        <div class="card-body" style="font-size: 80px;">
                            <?php echo $userno; ?>
                        </div>
                    </div>
                    <div class="card text-white bg-secondary mb-3" style="max-width: 18rem; width: 300px">
                        <div class="card-header" style="font-size: 30px;">Total Job Providers</div>
                        <div class="card-body" style="font-size: 80px;">
                            <?php echo $userProvider; ?>
                        </div>
                    </div>
                    <div class="card text-white bg-warning mb-3" style="max-width: 18rem; width: 300px">
                        <div class="card-header" style="font-size: 30px;">Total Job Seekers</div>
                        <div class="card-body" style="font-size: 80px;">
                            <?php echo $userSeeker; ?>
                        </div>
                    </div>
                    <div class="card text-white bg-success mb-3" style="max-width: 18rem; width: 300px">
                        <div class="card-header" style="font-size: 30px;">Total Approved Jobs</div>
                        <div class="card-body" style="font-size: 80px;">
                            <?php echo $userApproved; ?>
                        </div>
                    </div>
                    <div class="card text-white bg-danger mb-3" style="max-width: 18rem; width: 300px">
                        <div class="card-header" style="font-size: 30px;">Total Rejected Jobs</div>
                        <div class="card-body" style="font-size: 80px;">
                            <?php echo $userRejected; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php
require 'includes/jobprovider_footer.php';
?>