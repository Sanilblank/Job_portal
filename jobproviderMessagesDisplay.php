<?php
require_once 'controllers/authController.php';
require_once 'includes/jobprovider_header.php';
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
<?php
if (isset($_GET['readjobstatus'])) {
    $status = $_GET['readjobstatus'];
    $id = $_GET['readjobid'];
}
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-7 offset-md-4 divTable">

                <form action="jobproviderMessages.php" method="GET">
                    <h2>Message from admin</h2>
                    <hr>
                    <?php
                    if ($status == "Approved") { ?>
                        <p style="font-size: 22px;">Congrats!!! Your job post has been approved by the admin.<br>
                            Job seekers can now apply for your job.
                        </p>
                    <?php  } else { ?>
                        <p style="font-size: 22px;">Oops!!! Your job post has been rejected by the admin. <br>
                            Please try uploading a new job post.
                        </p>
                    <?php  }
                    ?>
                    <input type="hidden" name="jobreadid" value="<?php echo $id; ?>">
                    <hr>
                    <button type="submit" name="jobreadconfirm" class="btn btn-primary" style="margin-left: 250px;">Confirm</button>
                </form>


            </div>
        </div>
    </div>
</section>

<?php
require_once 'includes/jobprovider_footer.php';
?>