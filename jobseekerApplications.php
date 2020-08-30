<?php
require 'includes/jobseeker_header.php';
require 'controllers/authController.php';
?>
<?php
$i = 1;
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-11 offset-md-4 heading">
                <h2 class="h2heading">All your applied jobs will be shown here</h2>
            </div>

            <?php
            $appliedUsername = $_SESSION['username'];
            $sql = "SELECT * FROM applications WHERE username = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header('Location: jobseekerApplications.php');
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $appliedUsername);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (!$result) { ?>
                    <div class="col-md-11 offset-md-4 divTable">
                        <h2 class="nodataheading" style="margin-left:30px;">You have not applied for any jobs.</h2>
                        <h3 class="nodataheading" style="margin-left: 30px;">Apply for a job to get started.</h3>
                    </div>
                <?php } else { ?>

                    <div class="col-md-11 offset-md-4 divTable">
                        <div class="container mb-3 mt-3">
                            <table class="table table-striped mydatatable" style="width: 100%">
                                <thead style="background: rgb(52, 58, 64); color:aliceblue;">
                                    <tr>
                                        <td>S.N</td>
                                        <td>Job Title</td>
                                        <td>Recruiter</td>
                                        <td>Salary</td>
                                        <td>Email</td>
                                        <td>Location</td>
                                        <td>Status</td>
                                    </tr>
                                </thead>
                                <?php
                                while ($user = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <?php $jobid = $user['jobid'];
                                        $sql = "SELECT * FROM jobs WHERE id = ?";
                                        $stmt = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                                            header('Location: jobseekerApplications.php?error=sqlerror');
                                            exit();
                                        } else {
                                            mysqli_stmt_bind_param($stmt, "i", $jobid);
                                            mysqli_stmt_execute($stmt);
                                            $applicationResult = mysqli_stmt_get_result($stmt);
                                            if ($applicationResult) {
                                                $jobapplied = mysqli_fetch_assoc($applicationResult);
                                        ?>
                                                <td><?php echo $i;
                                                    $i++; ?></td>
                                                <td><?php echo $jobapplied['title']; ?></td>
                                                <td><?php echo $jobapplied['recruiter']; ?></td>
                                                <td><?php echo $jobapplied['salary']; ?></td>
                                                <td><?php echo $jobapplied['email']; ?></td>
                                                <td><?php echo $jobapplied['location']; ?></td>
                                                <td><?php

                                                    if ($user['selected'] == "Pending") { ?>
                                                        <button type="button" class="btn btn-warning" style="width: 90px;">Pending</button>
                                                    <?php } elseif ($user['selected'] == "Approved") { ?>
                                                        <button type="button" class="btn btn-success" style="width: 90px;">Approved</button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-danger" style="width: 90px;">Rejected</button>
                                                    <?php  }
                                                    ?></td>


                                        <?php }
                                        } ?>



                                    </tr>
                                <?php }

                                ?>
                        </div>
                    </div>
            <?php }
            }
            ?>
        </div>
    </div>
</section>

<script>
    $('.mydatatable').DataTable({
        "columnDefs": [{
            "orderable": false,
            "targets": 6
        }]
    });
</script>



<?php
require 'includes/jobprovider_footer.php';
?>