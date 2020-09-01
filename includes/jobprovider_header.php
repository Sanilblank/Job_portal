<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Provider</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="headerStyle.css">
    <script src="https://kit.fontawesome.com/37572b58fa.js" crossorigin="anonymous"></script>
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.4.4/umd/popper.min.js" integrity="sha512-eUQ9hGdLjBjY3F41CScH3UX+4JDSI9zXeroz7hJ+RteoCaY+GP/LDoM8AO+Pt+DRFw3nXqsjh9Zsts8hnYv8/A==" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <header class="actualHeaderOG">
        <ul>
            <li><a href="#">Logout</a></li>
        </ul>
    </header>


    <input type="checkbox" id="checkOG">
    <label for="checkOG">
        <i class="fas fa-bars" id="btnOG"></i>
        <i class="fas fa-times" id="cancelOG"></i>
    </label>
    <div class="sidebarOG">
        <header>Jobs</header>
        <ul>
            <li><a href="jobproviderDashboard.php"><i class="fab fa-windows"></i>Dashboard</a></li>
            <li><a href="jobproviderMessages.php"><i class="fas fa-envelope"></i>Messages</a></li>

        </ul>
    </div>

    <?php
    if (!isset($_SESSION['accountType'])) {
        header('Location: login.php');
        exit();
    } else {
        if ($_SESSION['accountType'] == "seeker") {
            header('Location: login.php');
            exit();
        }
    }
    ?>