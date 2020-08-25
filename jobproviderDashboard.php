<?php
require 'includes/jobprovider_header.php';
require 'controllers/authController.php';
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

                <h2 class="h2heading">Datatable containing all your advertised jobs</h2>
            </div>
            <div class="col-md-11 offset-md-4 divTable">

                <!-- Modal -->
                <div class="modal fade" id="addjobmodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">Add New Job Title</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="jobproviderDashboard.php" method="POST">
                                <div class="modal-body">
                                    <!-- To be displayed in modal -->

                                    <div class="form-group">
                                        <label for="recruiter">Recruiter or Company Name</label>
                                        <input type="text" name="recruiter" class="form-control" placeholder="Enter Name of Recruiter or Company" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Job Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Title of Job" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="salary">Salary</label>
                                        <input type="text" name="salary" class="form-control" placeholder="Enter Salary" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input type="text" name="location" class="form-control" placeholder="Enter Location" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="addjob" class="btn btn-primary">Save Data</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal end -->
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addjobmodel">
                    Add New Job Title
                </button>
                <hr>

                <?php
                $username = $_SESSION['username'];
                $sql = "SELECT * FROM jobs WHERE username = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header('Location: jobproviderDashboard.php?error=sqlerror');
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $rowCount = mysqli_stmt_num_rows($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($rowCount == 0) { ?>
                        <div class="col-md-11 offset-md-4" divTable>
                            <h2 class="nodataheading">No jobs have been added by you.</h2>
                            <h3 class="nodataheading">Please add a new job title.</h3>
                        </div>
                    <?php } else {

                        $sql = "SELECT * FROM jobs WHERE username = ?";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header('Location: jobproviderDashboard.php?error=sqlerror');
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "s", $username);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                        }
                    ?>

                        <div class="container mb-3 mt-3">
                            <table class="table table-striped table-bordered mydatatable" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Recruiter</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Salary</th>
                                        <th>Location</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($user = mysqli_fetch_assoc($result)) {  ?>
                                        <tr>
                                            <td><?php echo $user['id']; ?></td>
                                            <td><?php echo $user['recruiter']; ?></td>
                                            <td><?php echo $user['title']; ?></td>
                                            <td><?php echo $user['status']; ?></td>
                                            <td><?php echo $user['salary']; ?></td>
                                            <td><?php echo $user['location']; ?></td>
                                            <td>
                                                <a href="applications.php?job_id=<?php echo $user['id']; ?>" class="btn btn-info">Applications</a>
                                                <a href="jobProviderDashboard.php?deletejobid=<?php echo $user['id']; ?>" class="btn btn-danger">Delete</a>
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
    $('.mydatatable').DataTable();
</script>



<?php
require 'includes/jobprovider_footer.php';
?>