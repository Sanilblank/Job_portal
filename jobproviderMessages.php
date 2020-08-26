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

                <input type="checkbox" id="checkOGa">
                <label for="checkOGa">
                    <i class="fas fa-angle-double-right" id="btnOGa"></i>
                    <i class="fas fa-angle-double-left" id="cancelOGa"></i>
                </label>
                <div class="messages">
                    <h2 class="h2heading">Messages from Admin will appear here</h2>
                    <div class="col-md-11 offset-md-4 messageTable1">

                    </div>
                </div>

                <div class="messages2">
                    <h2 class="h2heading">Messages from Users will appear here</h2>
                    <div class="col-md-11 offset-md-4 messageTable1">

                    </div>
                </div>






</section>



<?php
require 'includes/jobprovider_footer.php';
?>