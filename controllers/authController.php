<?php

session_start();

require 'includes/db.php';
require_once 'emailController.php';

$errors = array();
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
                    //login user
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['verified'] = $user['verified'];

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
