<?php
require 'includes/jobprovider_header.php';
require 'controllers/authController.php';
?>

<?php
if (!isset($_SESSION['accountType'])) {
    header('Location: login.php');
    exit();
} else {
    if ($_SESSION['accountType'] == "seeker") {
        header('Location: login.php');
        exit();
    }
}
?>

<section>
    <?php
    if (isset($_GET['job_id'])) {
        $jobid = $_GET['job_id'];
    }
    ?>

    <?php
    $i = 1;
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-11 offset-md-4 heading">
                <?php if (count($errors) > 0) { ?>
                    <div class="alert alert-danger" style="left: 20px;">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php foreach ($errors as $error) { ?>
                            <?php echo $error  . "<br>" ?>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if (count($success) > 0) { ?>
                    <div class="alert alert-success" style="left: 20px;">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php foreach ($success as $success) { ?>
                            <?php echo $success  . "<br>" ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <?php
            $sql = "SELECT * FROM applications WHERE jobid = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header('Location: jobproviderapplications.php?error=sqlerror');
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "i", $jobid);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $numrows = mysqli_stmt_num_rows($stmt);
                if ($numrows == 0) { ?>
                    <div class="col-md-11 offset-md-4 divTable">
                        <h2 class="h2heading" style="color: black; margin-top:60px; margin-bottom:60px;">No one has applied for the job yet</h2>
                    </div>
                    <?php } else {
                    $sql = "SELECT * FROM applications WHERE jobid = ?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header('Location: jobproviderapplications.php?error=sqlerror');
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "i", $jobid);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt); ?>
                        <div class="col-md-11 offset-md-4 heading">
                            <h2 class="h2heading">Users who applied for the job are shown below</h2>
                        </div>

                        <div class="col-md-11 offset-md-4 divTable">
                            <div class="container mb-3 mt-3">
                                <table class="table table-striped mydatatable">
                                    <thead style="background: rgb(52, 58, 64); color:honeydew;">
                                        <tr>
                                            <td>S.N</td>
                                            <td>Username</td>
                                            <td>Status</td>
                                            <td></td>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($user = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?php echo $i;
                                                    $i++; ?></td>
                                                <td><?php echo $user['username']; ?></td>
                                                <td>
                                                    <?php

                                                    if ($user['selected'] == "Pending") { ?>
                                                        <button type="button" class="btn btn-warning" style="width: 90px;">Pending</button>
                                                    <?php } elseif ($user['selected'] == "Approved") { ?>
                                                        <button type="button" class="btn btn-success" style="width: 90px;">Approved</button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-danger" style="width: 90px;">Rejected</button>
                                                    <?php  }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="applicationDetails.php?job_id=<?php echo $user['jobid']; ?>&&applied_username=<?php echo $user['username']; ?>" class="btn btn-primary">Details</a>
                                                </td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>

            <?php }
                }
            }
            ?>
        </div>
    </div>
</section>
<script>
    $('.mydatatable').DataTable({});
</script>


<?php
require 'includes/jobprovider_footer.php';
?>