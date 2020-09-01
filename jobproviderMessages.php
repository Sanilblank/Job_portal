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
                    <div class="col-md-11 offset-md-4 messageTable1" style="background: none; border: none;">

                        <?php
                        //For new messages from admin

                        $username = $_SESSION['username'];
                        $newfromadmin = 0;
                        $sql = "SELECT * FROM jobs WHERE username = ? && newfromadmin <> ? ";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header('Location: jobproviderMessages.php?error=sqlerror');
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "si", $username, $newfromadmin);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                            $rowCount = mysqli_stmt_num_rows($stmt);
                            if ($rowCount == 0) { ?>
                                <div class="col-md-11 offset-md-4 divTable">
                                    <h2 class="nodataheading">No messages from admin yet.</h2>

                                </div>

                            <?php } else {
                                $sql = "SELECT * FROM jobs WHERE username = ? && newfromadmin <> ? ORDER BY id desc";
                                $stmt = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header('Location: jobproviderMessages.php?error=sqlerror');
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "si", $username, $newfromadmin);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                }

                            ?>
                                <table class="table" style="border-radius: 5px; overflow:hidden; margin-top: -20px;">
                                    <tbody>
                                        <?php
                                        while ($user = mysqli_fetch_assoc($result)) {
                                            if ($user['newfromadmin'] == 1) { ?>
                                                <tr class='clickable-row' data-href='jobproviderMessagesDisplay.php?readjobstatus=<?php echo $user['status']; ?>&&readjobid=<?php echo $user['id']; ?>'>

                                                    <td style="width: 35%; font-size: 23px; text-align: left; padding: 20px 20px; background: rgb(185, 181, 181);">Admin <button class="btn btn-danger" style="border-radius: 15px; width: 60px; padding: 0;">New</button></td>
                                                    <?php
                                                    if ($user['status'] == "Approved") { ?>
                                                        <td style="font-size: 23px; text-align: left; padding: 20px 20px; background: rgb(185, 181, 181);">Your job post has been approved.</td>

                                                    <?php  } else { ?>
                                                        <td style="font-size: 23px; text-align: left; padding: 20px 20px; background: rgb(185, 181, 181);">Your job post has been rejected.</td>


                                                    <?php }
                                                    ?>
                                                </tr>

                                            <?php } else { ?>

                                                <tr class='clickable-row' data-href='jobproviderMessagesDisplay.php?readjobstatus=<?php echo $user['status']; ?>&&readjobid=<?php echo $user['id']; ?>'>

                                                    <td style="width: 35%; font-size: 23px; text-align: left; padding: 20px 20px; background: whitesmoke;">Admin</td>
                                                    <?php
                                                    if ($user['status'] == "Approved") { ?>
                                                        <td style="font-size: 23px; text-align: left; padding: 20px 20px; background: whitesmoke;">Your job post has been approved.</td>

                                                    <?php  } else { ?>
                                                        <td style="font-size: 23px; text-align: left; padding: 20px 20px; background: whitesmoke;">Your job post has been rejected.</td>


                                                    <?php }
                                                    ?>
                                                </tr>

                                            <?php }



                                            ?>


                                <?php }
                                    }
                                }
                                ?>


                                    </tbody>
                                </table>

                    </div>
                </div>

                <div class="messages2">
                    <h2 class="h2heading">Messages from Users will appear here</h2>
                    <div class="col-md-11 offset-md-4 messageTable1" style="background: none; border: none;">
                        <?php
                        //To see if any messages present
                        $sql = "SELECT * FROM applications";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header('jobproviderMessages.php?error=sqlerror');
                            exit();
                        } else {
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                            $rows = mysqli_stmt_num_rows($stmt);
                            if ($rows == 0) { ?>
                                <div class="col-md-11 offset-md-4 divTable">
                                    <h2 class="nodataheading">No messages from users yet.</h2>

                                </div>

                            <?php } else {
                                //For messages from users
                                $sql = "SELECT * FROM applications ORDER BY id desc";
                                $stmt = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header('Location: jobproviderMessages.php?error=sqlerror');
                                    exit();
                                } else {
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                }
                            ?>
                                <table class="table" style="border-radius: 5px; overflow:hidden; margin-top: -20px;">
                                    <tbody>
                                        <?php
                                        while ($usermessage = mysqli_fetch_assoc($result)) {

                                            $sql = "SELECT * FROM jobs WHERE id=?";
                                            $stmt = mysqli_stmt_init($conn);
                                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                                header('jobproviderMessages.php?error=sqlerror');
                                                exit();
                                            } else {
                                                mysqli_stmt_bind_param($stmt, "i", $usermessage['jobid']);
                                                mysqli_stmt_execute($stmt);
                                                $resultjob = mysqli_stmt_get_result($stmt);
                                                if ($resultjob) {
                                                    $job = mysqli_fetch_assoc($resultjob);

                                                    if ($usermessage['newfromseeker'] == 1) { ?>
                                                        <tr class='clickable-row' data-href='applicationDetails.php?job_id=<?php echo $usermessage['jobid']; ?>&&applied_username=<?php echo $usermessage['username']; ?>'>

                                                            <td style="width: 35%; font-size: 23px; text-align: left; padding: 20px 20px; background: rgb(185, 181, 181);"><?php echo $usermessage['username']; ?> <button class="btn btn-danger" style="border-radius: 15px; width: 60px; padding: 0;">New</button></td>
                                                            <td style="font-size: 23px; text-align: left; padding: 20px 20px; background: rgb(185, 181, 181);">Application for post of <?php echo $job['title']; ?></td>
                                                        </tr>

                                                    <?php } else { ?>

                                                        <tr class='clickable-row' data-href='applicationDetails.php?job_id=<?php echo $usermessage['jobid']; ?>&&applied_username=<?php echo $usermessage['username']; ?>'>

                                                            <td style="width: 35%; font-size: 23px; text-align: left; padding: 20px 20px; background: whitesmoke;"><?php echo $usermessage['username']; ?></td>
                                                            <td style="font-size: 23px; text-align: left; padding: 20px 20px; background: whitesmoke;">Application for post of <?php echo $job['title']; ?></td>
                                                        </tr>

                                <?php }
                                                }
                                            }
                                        }
                                    }
                                } ?>




                                    </tbody>
                                </table>




                    </div>
                </div>






</section>


<script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>
<script>
    $('#newfromadmin1Modal').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var bookStatus = $(e.relatedTarget).data('book-status');

        //populate the textbox
        $(e.currentTarget).find('input[name="bookStatus"]').val(bookStatus);
    });
</script>

<?php
require 'includes/jobprovider_footer.php';
?>