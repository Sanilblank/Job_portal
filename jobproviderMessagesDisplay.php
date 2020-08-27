<?php
require_once 'controllers/authController.php';
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Message</title>
</head>

<body>

    <?php
    if (isset($_GET['readjobstatus'])) {
        $status = $_GET['readjobstatus'];
        $id = $_GET['readjobid'];
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-4 form-div" style="top: 100px;">
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
</body>

</html>