<?php
require 'includes/jobseeker_header.php';
require 'controllers/authController.php';
?>
<section>

    <div class="container">
        <div class="row">
            <div class="col-md-11 offset-md-4 heading">

                <h2 class="h2heading">All of your messages will appear here</h2>
                <div class="col-md-11 offset-md-4 messageTable1" style="background: none; border: none;">
                    <?php
                    //To see if any messages present
                    $newfromprovider = 0;
                    $sql = "SELECT * FROM applications WHERE newfromprovider <> ?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header('jobseekerMessages.php?error=sqlerror');
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "i", $newfromprovider);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        $rows = mysqli_stmt_num_rows($stmt);
                        if ($rows == 0) { ?>
                            <div class="col-md-11 offset-md-4 divTable">
                                <h2 class="nodataheading">No messages yet.</h2>

                            </div>

                        <?php } else {
                            $sql = "SELECT * FROM applications WHERE newfromprovider <> ? ORDER BY id desc";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header('Location: jobseekerMessages.php?error=sqlerror');
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "i", $newfromprovider);
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
                                            header('jobseekerMessages.php?error=sqlerror');
                                            exit();
                                        } else {
                                            mysqli_stmt_bind_param($stmt, "i", $usermessage['jobid']);
                                            mysqli_stmt_execute($stmt);
                                            $resultjob = mysqli_stmt_get_result($stmt);
                                            if ($resultjob) {
                                                $job = mysqli_fetch_assoc($resultjob);

                                                if ($usermessage['newfromprovider'] == 1) { ?>
                                                    <tr class='clickable-row' data-href='#'>

                                                        <td style="width: 35%; font-size: 23px; text-align: left; padding: 20px 20px; background: rgb(185, 181, 181);"><?php echo $job['recruiter']; ?> <button class="btn btn-danger" style="border-radius: 15px; width: 60px; padding: 0;">New</button></td>
                                                        <td style="font-size: 23px; text-align: left; padding: 20px 20px; background: rgb(185, 181, 181);">Reply for your application for post of <?php echo $job['title']; ?></td>
                                                    </tr>

                                                <?php } else { ?>

                                                    <tr class='clickable-row' data-href='#'>

                                                        <td style="width: 35%; font-size: 23px; text-align: left; padding: 20px 20px; background: whitesmoke;"><?php echo $job['recruiter']; ?></td>
                                                        <td style="font-size: 23px; text-align: left; padding: 20px 20px; background: whitesmoke;">Reply for your application for post of <?php echo $job['title']; ?></td>
                                                    </tr>

                                    <?php }
                                            }
                                        }
                                    } ?>

                                </tbody>
                            </table>
                    <?php  }
                    } ?>







                </div>

            </div>
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




<?php
require 'includes/jobprovider_footer.php';
?>