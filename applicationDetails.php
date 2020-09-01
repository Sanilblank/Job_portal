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
                <a href="<?php echo $seeker['cv']; ?>" download>
                    <p style="font-size: 22px; margin-top:25px; margin-bottom:25px;"><i class="far fa-file-pdf"> Click to download CV </i></p>
                </a>
                <hr>

                <?php
                $sql = "SELECT * FROM applications WHERE username = ? && jobid = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header('jobproviderapplications.php?error=sqlerror');
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "si", $appliedusername, $jobid);
                    mysqli_stmt_execute($stmt);
                    $resultforbutton = mysqli_stmt_get_result($stmt);
                    $seekerdetails = mysqli_fetch_assoc($resultforbutton);
                    $selected = $seekerdetails['selected'];
                    if ($selected == "Pending") { ?>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success" style="font-size:20px; margin-left:150px; width:150px; margin-bottom:20px; margin-top:20px;" data-toggle="modal" data-target="#approveapplicationModal" data-book-jobid="<?php echo $jobid; ?>" data-book-appliedusername="<?php echo $appliedusername; ?>">
                            Approve
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="approveapplicationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel">Approve Application</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="jobproviderapplications.php" method="POST">
                                        <div class="modal-body">
                                            <h5 style="margin-bottom: 25px;">Please write a short message to send to the applicant<h5>
                                                    <textarea name="message" placeholder="Write message here" style="width: 460px;"></textarea>
                                                    <input type="hidden" name="bookAppliedUsername">
                                                    <input type="hidden" name="bookJobId">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="approvejobseeker" class="btn btn-success">Confirm</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" style="font-size:20px; margin-left:40px; width:150px; margin-bottom:20px; margin-top:20px;" data-toggle="modal" data-target="#rejectapplicationModal" data-book-jobid="<?php echo $jobid; ?>" data-book-appliedusername="<?php echo $appliedusername; ?>">
                            Reject
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="rejectapplicationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel">Reject Application</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="jobproviderapplications.php" method="POST">
                                        <div class="modal-body">
                                            <h5 style="margin-bottom: 25px;">Please write a short message to send to the applicant<h5>
                                                    <textarea name="message" placeholder="Write message here" style="width: 460px;"></textarea>
                                                    <input type="hidden" name="bookAppliedUsername">
                                                    <input type="hidden" name="bookJobId">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="rejectjobseeker" class="btn btn-danger">Confirm</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                <?php }
                }

                ?>



            </div>
        </div>
    </div>


</section>

<script>
    $('#approveapplicationModal').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var bookAppliedUsername = $(e.relatedTarget).data('book-appliedusername');
        var bookJobId = $(e.relatedTarget).data('book-jobid');


        //populate the textbox
        $(e.currentTarget).find('input[name="bookAppliedUsername"]').val(bookAppliedUsername);
        $(e.currentTarget).find('input[name="bookJobId"]').val(bookJobId);
    });
</script>
<script>
    $('#rejectapplicationModal').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var bookAppliedUsername = $(e.relatedTarget).data('book-appliedusername');
        var bookJobId = $(e.relatedTarget).data('book-jobid');


        //populate the textbox
        $(e.currentTarget).find('input[name="bookAppliedUsername"]').val(bookAppliedUsername);
        $(e.currentTarget).find('input[name="bookJobId"]').val(bookJobId);
    });
</script>

<?php
require 'includes/jobprovider_footer.php';
?>