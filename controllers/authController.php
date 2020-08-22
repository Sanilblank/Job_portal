<?php

session_start();

require 'includes/db.php';

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
        header('Location: ../signup.php?error=sqlerror');
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

    if (!count($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));
        $verified = false;

        $sql = "INSERT INTO users (username, email, verified, token, password, accounttype) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../signup.php?error=sqlerror');
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

                $_SESSION['message'] = "You are now logged in!";
                $_SESSION['alert-class'] = "alert-success";
                header('location: index.php');
            } else {
                $errors['error'] = "Failed to register";
            }
        }
    }
}
