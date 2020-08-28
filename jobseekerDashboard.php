<?php
require 'includes/jobseeker_header.php';
require 'controllers/authController.php';
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
                    <div class="alert alert-success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php foreach ($success as $success) { ?>
                            <?php echo $success  . "<br>" ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <?php
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
                }
            }
            ?>
        </div>
    </div>





</section>

<script>
    $('#addseekerdataModal').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var bookUsername = $(e.relatedTarget).data('book-username');

        //populate the textbox
        $(e.currentTarget).find('input[name="bookUsername"]').val(bookUsername);
    });
</script>


<?php
require 'includes/jobprovider_footer.php';
?>