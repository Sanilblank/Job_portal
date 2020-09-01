<?php
require 'includes/jobseeker_header.php';
require 'controllers/authController.php';
?>
<?php
if (isset($_GET['job_id'])) {
    $jobid = $_GET['job_id'];
    $status = $_GET['status'];
}
?>

<?php
$sql = "SELECT * FROM jobs WHERE id = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('Location: jobseekerMessagesDisplay.php?error=sqlerror');
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "i", $jobid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
}


?>

<section>
    <div class="col-md-11 offset-md-4 heading">
        <h2 class="h2heading">Job Details</h2>
    </div>
    <div class="col-md-11 offset-md-4 divTable">
        <form action="jobseekerMessages.php" method="POST">
            <h2 style="margin-left: 80px; margin-top: 20px;">Recruiter: <?php echo $row['recruiter']; ?></h2>
            <hr>
            <h2 style="margin-left: 80px; margin-top: 20px;">Job Title: <?php echo $row['title']; ?></h2>
            <hr>
            <h2 style="margin-left: 80px; margin-top: 20px;">Salary: <?php echo $row['salary']; ?></h2>
            <hr>
            <h2 style="margin-left: 80px; margin-top: 20px;">Location: <?php echo $row['location']; ?></h2>
            <hr>
            <h2 style="margin-left: 80px; margin-top: 20px;">Email: <?php echo $row['email']; ?></h2>
            <hr>
            <h2 style="margin-left: 80px; margin-top: 20px;">Status: <?php echo $status; ?></h2>
            <hr>

            <?php
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM applications WHERE jobid = ? && username = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header('Location: jobseekerMessagesDisplay.php?error=sqlerror');
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "is", $jobid, $username);
                mysqli_stmt_execute($stmt);
                $resultApplications = mysqli_stmt_get_result($stmt);
                $rowMessage = mysqli_fetch_assoc($resultApplications);
            }
            ?>
            <h2 style="margin-left: 80px; margin-top: 20px;">Message from Recruiter:</h2>
            <p class="h3" style="margin-top: 30px; margin-left:80px"><?php echo $rowMessage['message']; ?></p>
            <hr>
            <input type="hidden" name="readseekerjobid" value="<?php echo $jobid; ?>">
            <input type="hidden" name="readseekerusername" value="<?php echo $username; ?>">
            <button name="jobseekermessageread" class="btn btn-primary" style="margin-left:450px; margin-top:30px; margin-bottom:30px; width:200px; font-size:22px;">Confirm</button>
        </form>
    </div>



</section>

<?php
require 'includes/jobprovider_footer.php';
?>