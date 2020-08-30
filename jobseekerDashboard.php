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
            //Check if account is created or not
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

                        <!-- Link trigger modal -->
                        <h3 style="text-align: center;"><a href="#addseekerdataModal" data-toggle="modal" data-target="#addseekerdataModal" data-book-username="<?php echo $username; ?>">Click here</a> to update it.</h3>



                        <!-- Modal -->
                        <div class="modal fade" id="addseekerdataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel">Profile Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="jobseekerDashboard.php" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="seekername">Name</label>
                                                <input type="text" name="seekername" class="form-control form-control-lg" placeholder="Write your Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" name="address" class="form-control form-control-lg" placeholder="Write your Address" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" class="form-control form-control-lg" placeholder="Write your Email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="file">Upload your CV here</label>
                                                <input type="file" name="file" class="form-control form-control-lg" style="border: none; box-shadow:none;" required>
                                            </div>
                                            <input type="hidden" name="bookUsername" value="">
                                            <hr>
                                            <div class="form-group">
                                                <button type="submit" name="addseekerdata" class="btn btn-primary btn-block btn-lg">Confirm</button>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    <?php } else {
                    $status = "Approved";
                    $sql = "SELECT * FROM jobs WHERE status = ?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header('Location: jobseekerDashboard.php?error=sqlerror');
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $status);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        $rowCount = mysqli_stmt_num_rows($stmt);

                        if ($rowCount == 0) { ?>
                            <div class="col-md-11 offset-md-4 divTable">
                                <h2 class="nodataheading">No new jobs have been added yet</h2>
                                <h3 class="nodataheading">Please wait for new job posts.</h3>
                            </div>
                            <?php } else {
                            $sql = "SELECT * FROM jobs WHERE status = ?";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header('Location: jobseekerDashboard.php?error=sqlerror');
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "s", $status);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt); ?>
                                <div class="col-md-11 offset-md-4 heading">
                                    <h2 class="h2heading">Table containing all jobs posted by Providers</h2>
                                </div>

                                <div class="col-md-11 offset-md-4 divTable">

                                    <div class="container mb-3 mt-3">
                                        <table class="table table-striped mydatatable" style="width: 100%">
                                            <thead class="thead-dark" style="background: rgb(52, 58, 64); color:aliceblue;">
                                                <tr>
                                                    <td>S.N</td>
                                                    <td>Job Title</td>
                                                    <td>Recruiter</td>
                                                    <td>Salary</td>
                                                    <td>Email</td>
                                                    <td>Location</td>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($user = mysqli_fetch_assoc($result)) { ?>
                                                    <tr>
                                                        <td><?php echo $i;
                                                            $i++;  ?></td>
                                                        <td><?php echo $user['title']; ?></td>
                                                        <td><?php echo $user['recruiter']; ?></td>
                                                        <td><?php echo $user['salary']; ?></td>
                                                        <td><?php echo $user['email']; ?></td>
                                                        <td><?php echo $user['location']; ?></td>
                                                        <td>
                                                            <?php
                                                            //Already applied or left to apply
                                                            $jobid = $user['id'];
                                                            $username = $_SESSION['username'];
                                                            $sql = "SELECT * FROM  applications WHERE jobid = ? && username = ?";
                                                            $stmt = mysqli_stmt_init($conn);
                                                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                                                header('Location: jobseekerDashboard.php?error=sqlerror');
                                                                exit();
                                                            } else {
                                                                mysqli_stmt_bind_param($stmt, "is", $jobid, $username);
                                                                mysqli_stmt_execute($stmt);
                                                                mysqli_stmt_store_result($stmt);
                                                                $isApplied = mysqli_stmt_num_rows($stmt);
                                                                if ($isApplied == 0) { ?>
                                                                    <!-- Modal button -->
                                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applyforjobModal" data-book-jobid="<?php echo $jobid; ?>" data-book-jobusername="<?php echo $_SESSION['username']; ?>">
                                                                        Apply for Job
                                                                    </button>
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="applyforjobModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="exampleModalLabel">Apply for Job</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <form action="jobseekerDashboard.php" method="POST">
                                                                                    <div class="modal-body">
                                                                                        <h3>Are you sure you want to apply for the job?</h3>
                                                                                        <input type="hidden" name="bookJobId" value="">
                                                                                        <input type="hidden" name="bookJobUsername" value="">
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="submit" class="btn btn-primary" name="applyforjob">Apply</button>
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                <?php } else { ?>
                                                                    <button class="btn btn-success" style="width: 115px;">Applied</button>

                                                            <?php }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>


                                                <?php }
                                                ?>
                                            </tbody>

                                    </div>
                                </div>

            <?php }
                        }
                    }
                }
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

<script>
    $('#addseekerdataModal').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var bookUsername = $(e.relatedTarget).data('book-username');

        //populate the textbox
        $(e.currentTarget).find('input[name="bookUsername"]').val(bookUsername);
    });
</script>

<script>
    $('#applyforjobModal').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var bookJobId = $(e.relatedTarget).data('book-jobid');
        var bookJobUsername = $(e.relatedTarget).data('book-jobusername');

        //populate the textbox
        $(e.currentTarget).find('input[name="bookJobId"]').val(bookJobId);
        $(e.currentTarget).find('input[name="bookJobUsername"]').val(bookJobUsername);
    });
</script>



<?php
require 'includes/jobprovider_footer.php';
?>