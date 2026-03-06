<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php if(isset($_SESSION['userId'])) {   
    require 'helpers/init_conn_db.php';                      
?> 
<style>
    body {
        background: radial-gradient(circle at top right, #1e293b, #0f172a);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    main {
        flex: 1;
        padding: 4rem 0;
    }
    .flight-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 1.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        transition: var(--transition);
    }
    .flight-card:hover {
        transform: translateY(-5px);
        border-color: rgba(59, 130, 246, 0.3);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    }
    .city-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
    }
    .time-large {
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: -1px;
        color: white;
    }
    .date-text {
        color: var(--text-secondary);
        font-size: 0.9rem;
        font-weight: 600;
    }
    .flight-path {
        position: relative;
        padding: 2rem 0;
        text-align: center;
    }
    .flight-path::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        border-top: 2px dashed rgba(255, 255, 255, 0.2);
        z-index: 1;
    }
    .flight-path i {
        position: relative;
        z-index: 2;
        background: #0f172a;
        padding: 0 1rem;
        color: var(--secondary-color);
        font-size: 1.5rem;
    }
    .flight-path.completed::before {
        border-top: 2px solid var(--secondary-color);
    }
    .status-badge {
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

<main>
    <div class="container">
        <div class="text-center mb-5 animate-fade-in">
            <h2 class="font-weight-900 text-white mb-2">My Flights</h2>
            <p class="text-secondary">Track the status of your upcoming and past flights</p>
        </div>

        <?php 
        $sql_t = 'SELECT * FROM Ticket WHERE user_id=? ORDER BY flight_id DESC';
        $stmt_t = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt_t,$sql_t)) {
            echo '<div class="alert alert-danger">Database Error!</div>';
        } else {
            mysqli_stmt_bind_param($stmt_t,'i',$_SESSION['userId']);            
            mysqli_stmt_execute($stmt_t);
            $result_t = mysqli_stmt_get_result($stmt_t);
            
            if(mysqli_num_rows($result_t) == 0) {
                echo '<div class="glass-panel p-5 text-center animate-fade-in">
                        <i class="fa fa-ticket fa-4x text-muted mb-4"></i>
                        <h3>No Bookings Found</h3>
                        <p class="text-secondary">You haven\'t booked any flights yet.</p>
                        <a href="index.php" class="btn btn-premium mt-3">Book a Flight</a>
                      </div>';
            }

            // To avoid duplicate flight cards for multiple passengers on same flight
            $processed_flights = [];
            
            while($row_t = mysqli_fetch_assoc($result_t)) {   
                if(in_array($row_t['flight_id'], $processed_flights)) continue;
                $processed_flights[] = $row_t['flight_id'];

                $sql_f = 'SELECT * FROM Flight WHERE flight_id=?';
                $stmt_f = mysqli_stmt_init($conn);
                if(mysqli_stmt_prepare($stmt_f,$sql_f)) {
                    mysqli_stmt_bind_param($stmt_f,'i',$row_t['flight_id']);            
                    mysqli_stmt_execute($stmt_f);
                    $result_f = mysqli_stmt_get_result($stmt_f);
                    
                    if($row_f = mysqli_fetch_assoc($result_f)) {
                        $date_dep = date('d M Y', strtotime($row_f['departure']));
                        $time_dep = date('H:i', strtotime($row_f['departure']));    
                        $date_arr = date('d M Y', strtotime($row_f['arrivale']));
                        $time_arr = date('H:i', strtotime($row_f['arrivale']));      
                        
                        $status = "Scheduled";
                        $badge_class = "style='background: rgba(59, 130, 246, 0.1); color: #60a5fa;'";
                        $path_class = "";
                        $icon = "fa-plane";
                        
                        if($row_f['status'] === 'dep') {
                            $status = "Departed";
                            $badge_class = "style='background: rgba(14, 165, 233, 0.1); color: #38bdf8;'";
                            $icon = "fa-plane";
                        } else if($row_f['status'] === 'issue') {
                            $status = "Delayed";
                            $badge_class = "style='background: rgba(220, 38, 38, 0.1); color: #f87171;'";
                        } else if($row_f['status'] === 'arr') {
                            $status = "Arrived";
                            $badge_class = "style='background: rgba(34, 197, 94, 0.1); color: #4ade80;'";
                            $path_class = "completed";
                            $icon = "fa-check-circle";
                        }                           
                        ?>
                        
                        <div class="flight-card animate-fade-in">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center text-md-left mb-4 mb-md-0">
                                    <div class="text-secondary small font-weight-bold mb-1">DEPARTURE</div>
                                    <div class="city-name"><?php echo htmlspecialchars($row_f['source']); ?></div>
                                    <div class="time-large"><?php echo $time_dep; ?></div>
                                    <div class="date-text"><?php echo $date_dep; ?></div>
                                </div>
                                
                                <div class="col-md-4 mb-4 mb-md-0">
                                    <div class="flight-path <?php echo $path_class; ?>">
                                        <i class="fa <?php echo $icon; ?>"></i>
                                    </div>
                                    <div class="text-center pt-2">
                                        <span class="status-badge" <?php echo $badge_class; ?>><?php echo $status; ?></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 text-center text-md-right mb-4 mb-md-0">
                                    <div class="text-secondary small font-weight-bold mb-1">ARRIVAL</div>
                                    <div class="city-name"><?php echo htmlspecialchars($row_f['Destination']); ?></div>
                                    <div class="time-large"><?php echo $time_arr; ?></div>
                                    <div class="date-text"><?php echo $date_arr; ?></div>
                                </div>
                                
                                <div class="col-md-2 text-center text-md-right">
                                    <a href="ticket.php" class="btn btn-outline-light btn-sm rounded-pill px-3">View Ticket</a>
                                </div>
                            </div>
                        </div>

                        <?php 
                    }
                }            
            }
        }
        ?>    
    </div>
</main>     
<?php } else {
    header("Location: index.php");
    exit();
} ?>
<?php subview('footer.php'); ?>
