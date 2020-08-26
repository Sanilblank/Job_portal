<?php
require 'includes/admin_header.php';
require 'controllers/authController.php';
?>

<?php
$i = 1;
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-11 offset-md-4 heading">
                <?php if (count($errors) > 0) { ?>
                    <div class="alert alert-danger">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php foreach ($errors as $error) { ?>
                            <?php echo $error  . "<br>" ?>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if (count($success) > 0) { ?>
                    <div class="alert alert-success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php foreach ($success as $success) { ?>
                            <?php echo $success  . "<br>" ?>
                        <?php } ?>
                    </div>
                <?php } ?>

                <h2 class="h2heading">Datatable containing jobs to be approved</h2>
            </div>
            <div class="col-md-11 offset-md-4 divTable">

                <?php
                $status = "Pending";
                $sql = "SELECT * FROM jobs WHERE status = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header('Location: adminDashboard.php?error=sqlerror');
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $status);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $rowCount = mysqli_stmt_num_rows($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($rowCount == 0) { ?>
                        <div class="col-md-11 offset-md-4" divTable>
                            <h2 class="nodataheading">No jobs to approve. </h2>
                            <h3 class="nodataheading">Wait for job providers to add new jobs.</h3>
                        </div>
                    <?php } else {

                        $sql = "SELECT * FROM jobs WHERE status = ?";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header('Location: adminDashboard.php?error=sqlerror');
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "s", $status);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                        }
                    ?>

                        <div class="container mb-3 mt-3">
                            <table class="table table-striped mydatatable" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Username</th>
                                        <th>Recruiter</th>
                                        <th>Title</th>

                                        <th>Salary</th>

                                        <th>Location</th>
                                        <th></th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($user = mysqli_fetch_assoc($result)) {  ?>
                                        <tr>
                                            <td><?php echo $i;
                                                $i++;  ?></td>
                                            <td><?php echo $user['username'] ?></td>
                                            <td><?php echo $user['recruiter']; ?></td>
                                            <td><?php echo $user['title']; ?></td>

                                            <td><?php echo $user['salary']; ?></td>

                                            <td><?php echo $user['location']; ?></td>
                                            <td>
                                                <a href="adminJobs.php?approveid=<?php echo $user['id']; ?>" class="btn btn-success">Approve</a>
                                            </td>
                                            <td>
                                                <a href="adminJobs.php?rejectid=<?php echo $user['id']; ?>" class="btn btn-danger" style="margin-left: -30px;">Reject</a>
                                            </td>


                                        </tr>
                                    <?php }

                                    ?>
                                </tbody>

                            </table>
                        </div>
                <?php  }
                }
                ?>
            </div>
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