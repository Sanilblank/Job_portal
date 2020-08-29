<?php
require 'includes/jobseeker_header.php';
require 'controllers/authController.php';
?>


<section>
    <div class="container">
        <div class="row">


            <?php
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM seekerdetails WHERE username = ? LIMIT 1";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: jobseekerDashboard.php");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $userCount = mysqli_num_rows($result);
                $user = mysqli_fetch_assoc($result);
                if (!$userCount) {
                    $errors['nouser'] = "Please create your profile first";
                    header("Location: jobseekerDashboard.php?createprofilefirst");
                    exit();
                } else {
            ?>
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
                        <h2 class="h2heading">My Profile</h2>
                    </div>
                    <div class="col-md-11 offset-md-4 divTable">
                        <h2 style="margin-left: 80px; margin-top: 20px;">Username: <?php echo $_SESSION['username']; ?></h2>
                        <hr>
                        <h2 style="margin-left: 80px;">Name: <?php echo $user['name']; ?></h2>
                        <hr>
                        <h2 style="margin-left: 80px;">Address: <?php echo $user['address']; ?> </h2>
                        <hr>
                        <h2 style="margin-left: 80px;">Email: <?php echo $user['email']; ?> </h2>
                        <hr>
                        <h3 style="margin-left: 250px; margin-top:30px; margin-bottom:30px;">Your CV is also present and working fine.</h3>
                        <hr>
                        <!-- Modal Link -->
                        <a href="#editprofileModal" class="btn btn-primary" style="margin-left: 380px; margin-top: 30px; font-size: 25px" data-toggle="modal" data-target="#editprofileModal" data-book-id="<?php echo $user['id']; ?>" data-book-username="<?php echo $user['username']; ?>" data-book-name="<?php echo $user['name']; ?>" data-book-address="<?php echo $user['address']; ?>" data-book-email="<?php echo $user['email']; ?>">Edit Profile</a>

                        <!-- Modal -->
                        <div class="modal fade" id="editprofileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="jobseekerProfile.php" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="bookName">Name</label>
                                                <input type="text" name="bookName" class="form-control form-control-lg" placeholder="Write your Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="bookAddress">Address</label>
                                                <input type="text" name="bookAddress" class="form-control form-control-lg" placeholder="Write your Address" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="bookEmail">Email</label>
                                                <input type="email" name="bookEmail" class="form-control form-control-lg" placeholder="Write your Email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="file">Upload your CV here</label>
                                                <input type="file" name="file" class="form-control form-control-lg" style="border: none; box-shadow:none;" required>
                                            </div>
                                            <input type="hidden" name="bookUsername" value="">
                                            <input type="hidden" name="bookId">
                                            <hr>
                                            <div class="form-group">
                                                <button type="submit" name="editseekerdata" class="btn btn-primary btn-block btn-lg">Confirm</button>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


            <?php }
            }
            ?>

        </div>
    </div>
</section>

<script>
    $('#editprofileModal').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var bookId = $(e.relatedTarget).data('book-id');
        var bookUsername = $(e.relatedTarget).data('book-username');
        var bookName = $(e.relatedTarget).data('book-name');
        var bookAddress = $(e.relatedTarget).data('book-address');
        var bookEmail = $(e.relatedTarget).data('book-email');

        //populate the textbox
        $(e.currentTarget).find('input[name="bookId"]').val(bookId);
        $(e.currentTarget).find('input[name="bookUsername"]').val(bookUsername);
        $(e.currentTarget).find('input[name="bookName"]').val(bookName);
        $(e.currentTarget).find('input[name="bookAddress"]').val(bookAddress);
        $(e.currentTarget).find('input[name="bookEmail"]').val(bookEmail);
    });
</script>

<?php
require 'includes/jobprovider_footer.php';
?>