<?php
session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200&display=swap" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/44f557ccce.js"></script>
        <title>Online Flight Booking - Admin</title>          
        <link rel="icon" href="../assets/images/brand.png" type="image/x-icon">          
    </head>
<style>
@font-face {
  font-family: 'product sans';
  src: url('../assets/css/Product Sans Bold.ttf');
}
:root {
    --primary-color: #0f172a;
    --secondary-color: #3b82f6;
    --accent-color: #60a5fa;
    --background-color: #f8fafc;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --glass-bg: rgba(255, 255, 255, 0.95);
    --glass-border: rgba(255, 255, 255, 0.2);
    --transition: all 0.3s ease;
}

body {
    background-color: var(--background-color);
    font-family: 'Inter', 'product sans', sans-serif;
    color: var(--text-primary);
}

/* Glassmorphism Navbar */
.navbar-custom {
    background: var(--primary-color) !important;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 1rem 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.navbar-brand h4 {
    font-family: 'product sans', sans-serif;
    font-weight: 800;
    margin: 0;
    letter-spacing: 1px;
    color: white;
}

.nav-link h5 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    color: rgba(255, 255, 255, 0.8);
    transition: var(--transition);
}

.nav-link:hover h5 {
    color: var(--accent-color);
}

.admin-dropdown-menu {
    background: white;
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 1rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    padding: 1rem;
    min-width: 250px;
}

.admin-input {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    color: var(--text-primary);
    width: 100%;
}
.admin-input:focus {
    outline: none;
    border-color: var(--secondary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-admin-premium {
    background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
    color: white;
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: var(--transition);
}
.btn-admin-premium:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    color: white;
}

.admin-glass-panel {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    padding: 2rem;
}

.admin-header-title {
    font-family: 'product sans', sans-serif;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 2rem;
}

/* Custom Table Styles */
.custom-table {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}
.custom-table thead th {
    background: var(--primary-color);
    color: white;
    font-weight: 600;
    border: none;
    padding: 1rem;
}
.custom-table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #e2e8f0;
    color: var(--text-secondary);
    font-weight: 500;
}
.custom-table tbody tr:hover td {
    background-color: #f8fafc;
}
</style>
    <body>

        <nav class="navbar navbar-custom navbar-expand-lg navbar-dark mb-4">
          <a class="navbar-brand text-light" href="index.php"><h4>SKYLINE <span style="color: var(--accent-color);">ADMIN</span></h4></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <?php
              if(isset($_SESSION['adminId'])) { ?>
                <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                      <h5 class="ml-2"><i class="fa fa-dashboard mr-2"></i> Dashboard</h5>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="flight.php">
                      <h5 class="ml-2"><i class="fa fa-plane mr-2"></i> Add Flight</h5>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="all_flights.php">
                      <h5 class="ml-2"><i class="fa fa-list mr-2"></i> Flight List</h5>
                    </a>
                  </li>   
                  <li class="nav-item">
                    <a class="nav-link" href="list_airlines.php">
                      <h5 class="ml-2"><i class="fa fa-building mr-2"></i> Airlines</h5>
                    </a>
                  </li>              
                </ul>
                <ul class="nav navbar-nav navbar-right align-items-center">
                  <li class="nav-item mr-3">
                    <div class="dropdown mt-2 mt-lg-0">
                      <button class="btn btn-outline-light btn-sm dropdown-toggle rounded-pill px-3" type="button" 
                        id="dropdownMenuButton" data-toggle="dropdown" 
                          aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-plus mr-1"></i> New Airline
                      </button>  
                      <div class="dropdown-menu dropdown-menu-right admin-dropdown-menu">
                        <form action="../includes/admin/airline.inc.php" method="post">
                          <h6 class="font-weight-bold mb-3">Add Airline</h6>
                          <div class="form-group">
                            <input type="text" class="admin-input mb-2" name="airline" placeholder="Airline Name" required>
                            <input type="number" class="admin-input" name="seats" placeholder="Total Seats" required>                              
                          </div>  
                          <button type="submit" name="air_but" class="btn btn-admin-premium w-100">Add Airline</button>
                        </form>
                      </div>
                    </div>  
                  </li>
                  <li class="nav-item border-left border-secondary pl-3 mr-3 d-none d-lg-block">
                          <i class="fa fa-user-circle text-light mr-2"></i>
                          <span class="text-light font-weight-bold">
                          <?php echo htmlspecialchars($_SESSION['adminUname']); ?>
                          </span>
                  </li>            
                  <li class="nav-item">
                    <form action="../includes/logout.inc.php" method="POST" class="m-0">
                        <button class="btn btn-danger btn-sm rounded-pill px-3" type="submit">
                            <i class="fa fa-sign-out mr-1"></i> Logout
                        </button>
                    </form> 
                  </li>
                </ul>                 
            <?php } ?>
        </div>
        </nav>
