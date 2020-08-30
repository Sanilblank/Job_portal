<?php
require 'includes/jobprovider_header.php';
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

                    if ($rowCount == 0) { ?>
                        <div class="col-md-11 offset-md-4 divTable">
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
                            <table class="table table-striped mydatatable" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Recruiter</th>
                                        <th>Title</th>
                                        <th>Status</th>
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
                                            <td><?php echo $user['recruiter']; ?></td>
                                            <td><?php echo $user['title']; ?></td>
                                            <td><?php

                                                if ($user['status'] == "Pending") { ?>
                                                    <button type="button" class="btn btn-warning" style="width: 90px;">Pending</button>
                                                <?php } elseif ($user['status'] == "Approved") { ?>
                                                    <button type="button" class="btn btn-success" style="width: 90px;">Approved</button>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-danger" style="width: 90px;">Rejected</button>
                                                <?php  }
                                                ?>
                                            </td>
                                            <td><?php echo $user['salary']; ?></td>
                                            <td><?php echo $user['location']; ?></td>
                                            <td>
                                                <a href="jobproviderapplications.php?job_id=<?php echo $user['id']; ?>" class="btn btn-info">Applications</a>
                                            </td>
                                            <!-- Button trigger modal -->
                                            <td>
                                                <button type="button" class="btn btn-danger" style="margin-left: -30px;" data-toggle="modal" data-target="#deletejobmodal" data-book-id="<?php echo $user['id']; ?>" data-book-user="<?php echo $user['recruiter']; ?>">
                                                    Delete
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="deletejobmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="exampleModalLabel">Delete</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="jobproviderDashboard.php" method="GET">
                                                                <div class="modal-body">
                                                                    <h5>Are you sure you want to delete the job?</h5>
                                                                    <input type="hidden" name="bookId" value="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" name="deletejob" value="Delete" class="btn btn-danger">Yes</button>
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
<script>
    $('#deletejobmodal').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var bookId = $(e.relatedTarget).data('book-id');

        //populate the textbox
        $(e.currentTarget).find('input[name="bookId"]').val(bookId);
    });
</script>



<?php
require 'includes/jobprovider_footer.php';
?>