<?php
require 'controllers/authController.php';
?>

<?php
if (isset($_POST['addjob'])) {
    $recruiter = trim($_POST['recruiter']);
    $title = trim($_POST['title']);
    $salary = trim($_POST['salary']);
    $email = trim($_POST['email']);
    $location = trim($_POST['location']);
    $status = "Pending";
    $availability = "Open";
    $newfromadmin = 0;

    $sql = "SELECT * FROM jobs WHERE recruiter = ? && title =?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: jobproviderDashboard.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $recruiter, $title);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $userCount = mysqli_num_rows($result);

        if ($userCount > 0) {
            $errors['jobexists'] = "Same job title with same recruiter already exists";
            header('Location: jobproviderDashboard.php');
            exit();
        }
    }

    if (!count($errors)) {
        $sql = "INSERT INTO jobs (recruiter, title, status, availability, salary, email, location, newfromadmin) VALUES (?,?,?,?,?,?,?,?)";
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: jobproviderDashboard.php?error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "sssssssi", $recruiter, $title, $status, $availability, $salary, $email, $location, $newfromadmin);
            mysqli_stmt_execute($stmt);
            header('Location: jobproviderDashboard.php');
            exit();
        }
    }
}
?>