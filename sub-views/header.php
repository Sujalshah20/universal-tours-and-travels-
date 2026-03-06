<?php
session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/44f557ccce.js"></script>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/main.css">
        <title>Online Flight Booking | Premium Travel</title>         
        <link rel="icon" href="assets/images/brand.png" type="image/x-icon">       
    </head>
    <body>        
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                    <img src="assets/images/brand.png" width="30" height="30" class="d-inline-block align-top mr-2" alt="Logo">
                    SKYLINE
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <?php if(isset($_SESSION['userId'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="my_flights.php">My Flights</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ticket.php">Tickets</a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" href="feedback.php">Feedback</a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center">
                        <?php
                        if(isset($_SESSION['userId'])) {
                            echo '
                            <div class="dropdown">
                                <button class="btn btn-link text-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="avatar-sm mr-2 d-flex align-items-center justify-content-center" style="width:32px; height:32px; background:rgba(255,255,255,0.1); border-radius:50%;">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <span class="font-weight-600">'.htmlspecialchars($_SESSION['userUid']).'</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right glass-panel mt-2" aria-labelledby="userDropdown">
                                    <form action="includes/logout.inc.php" method="POST">
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="fa fa-sign-out mr-2"></i> Logout
                                        </button>
                                    </form> 
                                </div>
                            </div>';
                        } else {
                            echo '
                            <div class="dropdown">
                                <button class="btn btn-premium dropdown-toggle" type="button" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Get Started
                                </button>
                                <div class="dropdown-menu dropdown-menu-right glass-panel mt-2" aria-labelledby="loginDropdown">
                                    <a class="dropdown-item" href="login.php">
                                        <i class="fa fa-user-circle mr-2"></i> Passenger Login
                                    </a>
                                    <div class="dropdown-divider border-secondary"></div>
                                    <a class="dropdown-item" href="admin/login.php">
                                        <i class="fa fa-lock mr-2"></i> Admin Portal
                                    </a>
                                </div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
        <div style="height: 80px;"></div> <!-- Spacer for fixed-top navbar -->