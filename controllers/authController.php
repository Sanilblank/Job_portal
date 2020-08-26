<?php

session_start();

require 'includes/db.php';
require_once 'emailController.php';

$errors = array();
$success = array();
$username = "";
$email = "";
$accountType = "";

//Sign up
if (isset($_POST['signup-btn'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $passwordConf = trim($_POST['passwordConf']);

    if (isset($_POST['accountType'])) {
        $accountType = trim($_POST['accountType']);
    }

    if (empty($username)) {
        $errors['username'] = "Username required";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email address is invalid";
    }
    if (empty($email)) {
        $errors['email'] = "Email required";
    }
    if (empty($password)) {
        $errors['password'] = "Password required";
    }
    if ($password !== $passwordConf) {
        $errors['password'] = "The two passwords do not match";
    }
    if (empty($accountType)) {
        $errors['accountType'] = "Please select the type of account";
    }

    $sql = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: signup.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $userCount = mysqli_num_rows($result);
        mysqli_stmt_close($stmt);

        if ($userCount > 0) {
            $errors['emailexists'] = "Email already exists";
        }
    }

    $sql = "SELECT * FROM users WHERE username=? LIMIT 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: signup.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $userCount = mysqli_num_rows($result);
        mysqli_stmt_close($stmt);

        if ($userCount > 0) {
            $errors['userexists'] = "User already exists";
        }
    }

    if (!count($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));
        $verified = false;

        $sql = "INSERT INTO users (username, email, verified, token, password, accounttype) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: signup.php?error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ssbsss", $username, $email, $verified, $token, $password, $accountType);

            if (mysqli_stmt_execute($stmt)) {
                //login user
                $user_id = $conn->insert_id;
                $_SESSION['id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['verified'] = $verified;
                $_SESSION['accountType'] = $accountType;


                sendVerificationEmail($email, $token);

                //Set flash message
                $_SESSION['message'] = "You are now logged in!";
                $_SESSION['alert-class'] = "alert-success";
                header('location: index.php');
                exit();
            } else {
                $errors['error'] = "Failed to register";
            }
        }
    }
}

//Log in
if (isset($_POST['login-btn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) {
        $errors['username'] = "Username required";
    }
    if (empty($password)) {
        $errors['password'] = "Password required";
    }
    if ($username == "admin" && $password == "admin") {
        header('Location: adminDashboard.php');
        exit();
    }

    if (!count($errors)) {
        $sql = "SELECT * FROM users WHERE email = ? OR username=? LIMIT 1";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: login.php?error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $username, $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            if (!$user) {
                $errors['nouser'] = "No such user exists";
            } else {
                if (password_verify($password, $user['password'])) {

                    if (!empty($_POST['remember'])) {
                        setcookie("cookie_username", $username, time() + 86400 * 30);
                        setcookie("cookie_password", $password, time() + 86400 * 30);
                    } else {
                        setcookie("cookie_username", "");
                        setcookie("cookie_password", "");
                    }

                    //login user
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['verified'] = $user['verified'];
                    $_SESSION['accountType'] = $user['accounttype'];

                    $_SESSION['message'] = "You are now logged in!";
                    $_SESSION['alert-class'] = "alert-success";
                    header('location: index.php');
                    exit();
                } else {
                    $errors['login_fail'] = "Wrong credentials";
                }
            }
        }
    }
}

//logout user
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['verify']);
    header('Location: login.php');
    exit();
}

//Verify user by token
function verifyUser($token)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $update_query = "UPDATE users SET verified = 1 WHERE token = '$token'";

        if (mysqli_query($conn, $update_query)) {
            //Log user in
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = 1;

            $_SESSION['message'] = "Your email address was successfully verified!";
            $_SESSION['alert-class'] = "alert-success";
            header('location: index.php');
            exit();
        }
    } else {
        echo "User not found";
    }
}


//If user clicks on forgot password
if (isset($_POST['forgot-password'])) {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email address is invalid";
    }
    if (empty($email)) {
        $errors['email'] = "Email required";
    }

    if (!count($errors)) {
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: forgot_password.php?error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            if (!$user) {
                $errors['nouser'] = "No such user exists";
            } else {
                $token = $user['token'];
                sendPasswordResetLink($email, $token);
                header('Location: password-message.php');
                exit();
            }
        }
    }
}

//If user clicked on reset password button
if (isset($_POST['reset-password-btn'])) {
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    if (empty($password) ||  empty($passwordConf)) {
        $errors['password'] = "Password required";
    }
    if ($password !== $passwordConf) {
        $errors['password'] = "The two passwords do not match";
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = $_SESSION['email'];
    if (!count($errors)) {
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: reset_password.php?error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $password, $email);
            mysqli_stmt_execute($stmt);

            header('Location:login.php?success=reset successful');
            exit();
        }
    }
}

function resetPassword($token)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE token = ? LIMIT 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: index.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        $_SESSION['email'] = $user['email'];
        header('Location:reset_password.php');
        exit();
    }
}

if (isset($_POST['addjob'])) {
    $username = $_SESSION['username'];
    $recruiter = trim($_POST['recruiter']);
    $title = trim($_POST['title']);
    $salary = trim($_POST['salary']);
    $email = trim($_POST['email']);
    $location = trim($_POST['location']);
    $status = "Pending";
    $newfromadmin = 0;

    $sql = "SELECT * FROM jobs WHERE recruiter = ? && title =? && username = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: jobproviderDashboard.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $recruiter, $title, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $userCount = mysqli_num_rows($result);

        if ($userCount > 0) {
            $errors['jobexists'] = "Same job title with same recruiter already exists";
        }
    }

    if (!count($errors)) {
        $sql = "INSERT INTO jobs (recruiter, title, status, salary, email, location, newfromadmin, username) VALUES (?,?,?,?,?,?,?,?)";
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: jobproviderDashboard.php?error=sqlerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssis", $recruiter, $title, $status, $salary, $email, $location, $newfromadmin, $username);
            mysqli_stmt_execute($stmt);
            $success['jobadded'] = "Job has been added successfully";
        }
    }
}

if (isset($_GET['deletejob'])) {
    $id = $_GET['bookId'];
    $sql = "DELETE FROM jobs WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: jobproviderDashboard.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        $success['deletedjob'] = "Job has been deleted successfully";
    }
}

if (isset($_GET['approveid'])) {
    $id = $_GET['approveid'];
    $status = "Approved";
    $sql = "UPDATE jobs SET status = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: adminJobs.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);

        $success['jobApproved'] = "Job post has been approved successfully";

        header('Location:adminJobs.php?success=Approved');
        exit();
    }
}

if (isset($_GET['rejectid'])) {
    $id = $_GET['rejectid'];
    $status = "Rejected";
    $sql = "UPDATE jobs SET status = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: adminJobs.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);

        $errors['jobRejected'] = "Job post has been rejected";
    }
}
