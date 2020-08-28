<?php
require 'includes/jobseeker_header.php';
require 'controllers/authController.php';
?>


<section>
    <div class="col-md-11 offset-md-4 heading">
        <h2 class="h2heading">My Profile</h2>
    </div>
    <div class="col-md-11 offset-md-4 divTable">
        <h2 style="margin-left: 80px; margin-top: 20px;">Username: <?php echo $_SESSION['username']; ?></h2>
        <hr>
        <h2 style="margin-left: 80px;">Name: </h2>
        <hr>
        <h2 style="margin-left: 80px;">Address: </h2>
        <hr>
        <h2 style="margin-left: 80px;">Email: </h2>
        <hr>


    </div>
</section>

<?php
require 'includes/jobprovider_footer.php';
?>