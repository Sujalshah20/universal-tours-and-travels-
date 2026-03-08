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
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/main.css">
        <title>Skyline — Flights, Hotels, Holidays</title>
        <link rel="icon" href="assets/images/brand.png" type="image/x-icon">
    </head>
    <body>
        <!-- ===== TOP NAVBAR (Dark) ===== -->
        <nav class="navbar-top">
            <div class="container d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                <a href="index.php" class="navbar-brand" style="text-decoration:none; margin:0;">
                    <span>make</span>my<span>trip</span>
                </a>

                <div class="d-flex align-items-center" style="gap: 8px; flex-wrap:wrap;">
                    <a href="#" class="nav-link-top" style="text-decoration:none;">List Your Property</a>
                    <a href="#" class="nav-link-top" style="text-decoration:none; border-left:1px solid #444; padding-left:12px !important;">myBiz</a>

                    <?php if(isset($_SESSION['userId'])): ?>
                        <div class="dropdown ml-2">
                            <button class="btn-login-mmt dropdown-toggle" type="button" id="userMenuBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user mr-1"></i>
                                <?php echo htmlspecialchars($_SESSION['userUid']); ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right mt-1" aria-labelledby="userMenuBtn" style="border-radius:4px; border:1px solid #e0e0e0; box-shadow:0 4px 20px rgba(0,0,0,0.15);">
                                <a class="dropdown-item" href="my_flights.php" style="font-size:13px; font-weight:700; color:#4a4a4a;">
                                    <i class="fa fa-ticket mr-2" style="color:#008cff;"></i> My Trips
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="includes/logout.inc.php" method="POST">
                                    <button class="dropdown-item text-danger" type="submit" style="font-size:13px; font-weight:700;">
                                        <i class="fa fa-sign-out mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="dropdown ml-2">
                            <button class="btn-login-mmt dropdown-toggle" type="button" id="loginBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Login or Create Account
                            </button>
                            <div class="dropdown-menu dropdown-menu-right mt-1" aria-labelledby="loginBtn" style="border-radius:4px; border:1px solid #e0e0e0; box-shadow:0 4px 20px rgba(0,0,0,0.15); min-width:200px;">
                                <a class="dropdown-item" href="login.php" style="font-size:13px; font-weight:700; color:#4a4a4a;">
                                    <i class="fa fa-user-circle mr-2" style="color:#008cff;"></i> Passenger Login
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="register.php" style="font-size:13px; font-weight:700; color:#4a4a4a;">
                                    <i class="fa fa-user-plus mr-2" style="color:#008cff;"></i> Create Account
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="admin/login.php" style="font-size:13px; font-weight:700; color:#4a4a4a;">
                                    <i class="fa fa-lock mr-2" style="color:#9b9b9b;"></i> Admin Portal
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <!-- ===== BOTTOM NAVBAR (White service tabs) ===== -->
        <nav class="navbar-bottom">
            <div class="container">
                <div class="d-flex align-items-center overflow-auto" style="gap:0;">
                    <a href="index.php" class="nav-tab-item active" data-target="flights">
                        <i class="fa fa-plane"></i>
                        Flights
                    </a>
                    <a href="#" class="nav-tab-item">
                        <i class="fa fa-bed"></i>
                        Hotels
                    </a>
                    <a href="#" class="nav-tab-item">
                        <i class="fa fa-train"></i>
                        Trains
                    </a>
                    <a href="#" class="nav-tab-item">
                        <i class="fa fa-bus"></i>
                        Bus
                    </a>
                    <a href="#" class="nav-tab-item">
                        <i class="fa fa-car"></i>
                        Cabs
                    </a>
                    <a href="feedback.php" class="nav-tab-item">
                        <i class="fa fa-star"></i>
                        Feedback
                    </a>
                    <?php if(isset($_SESSION['userId'])): ?>
                    <a href="my_flights.php" class="nav-tab-item">
                        <i class="fa fa-ticket"></i>
                        My Trips
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>