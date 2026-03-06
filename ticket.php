<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>

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
    .ticket-wrapper {
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        display: flex;
        flex-direction: column;
    }
    @media (min-width: 992px) {
        .ticket-wrapper {
            flex-direction: row;
        }
    }
    .ticket-main {
        padding: 2.5rem;
        flex: 1;
        position: relative;
        border-right: 2px dashed #cbd5e1;
    }
    .ticket-main::after, .ticket-main::before {
        content: '';
        position: absolute;
        width: 40px;
        height: 40px;
        background: #0f172a; /* Matches body background */
        border-radius: 50%;
        right: -20px;
    }
    .ticket-main::after { top: -20px; }
    .ticket-main::before { bottom: -20px; }
    
    .ticket-stub {
        background: var(--secondary-color);
        color: white;
        padding: 2.5rem;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    @media (min-width: 992px) {
        .ticket-stub { width: 300px; }
    }
    
    .ticket-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .ticket-value {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.5rem;
    }
    .ticket-time {
        font-size: 2.5rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
        letter-spacing: -1px;
    }
    .flight-path-line {
        height: 2px;
        background: #e2e8f0;
        position: relative;
        margin: 1.5rem 0;
    }
    .flight-path-line i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--secondary-color);
        background: white;
        padding: 0 10px;
    }
</style>

<main>
  <?php if(isset($_SESSION['userId'])) {   
    require 'helpers/init_conn_db.php';   
    
    // Cancellation Logic (Unchanged)
    if(isset($_POST['cancel_but'])) {
        $ticket_id = $_POST['ticket_id'];
        $stmt = mysqli_stmt_init($conn);
        $sql = 'SELECT * FROM Ticket WHERE ticket_id=?';
        if(mysqli_stmt_prepare($stmt,$sql)) {
            mysqli_stmt_bind_param($stmt,'i',$ticket_id);            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {   
              $sql_pas = 'DELETE FROM Passenger_profile WHERE passenger_id=?';
              $stmt_pas = mysqli_stmt_init($conn);
              if(mysqli_stmt_prepare($stmt_pas,$sql_pas)) {
                  mysqli_stmt_bind_param($stmt_pas,'i',$row['passenger_id']);            
                  mysqli_stmt_execute($stmt_pas);
                  $sql_t = 'DELETE FROM Ticket WHERE ticket_id=?';
                  $stmt_t = mysqli_stmt_init($conn);
                  if(mysqli_stmt_prepare($stmt_t,$sql_t)) {
                      mysqli_stmt_bind_param($stmt_t,'i',$row['ticket_id']);            
                      mysqli_stmt_execute($stmt_t);
                  }                  
              }              
            }
        }        
    }
    ?>     
    
    <div class="container pb-5"> 
        <div class="text-center mb-5 animate-fade-in">
            <h2 class="font-weight-900 text-white mb-2">My Boarding Passes</h2>
            <p class="text-secondary">Please present this ticket at the boarding gate</p>
        </div>

      <?php 
      $stmt = mysqli_stmt_init($conn);
      $sql = 'SELECT * FROM Ticket WHERE user_id=? ORDER BY ticket_id DESC';
      if(mysqli_stmt_prepare($stmt,$sql)) {
          mysqli_stmt_bind_param($stmt,'i',$_SESSION['userId']);            
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          
          if(mysqli_num_rows($result) == 0) {
              echo '<div class="glass-panel p-5 text-center animate-fade-in">
                      <i class="fa fa-ticket fa-4x text-muted mb-4"></i>
                      <h3>No Tickets Found</h3>
                      <p class="text-secondary">You haven\'t booked any tickets yet.</p>
                      <a href="index.php" class="btn btn-premium mt-3">Book a Flight</a>
                    </div>';
          }

          while ($row = mysqli_fetch_assoc($result)) {   
            $sql_p = 'SELECT * FROM Passenger_profile WHERE passenger_id=?';
            $stmt_p = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt_p,$sql_p)) {
                mysqli_stmt_bind_param($stmt_p,'i',$row['passenger_id']);            
                mysqli_stmt_execute($stmt_p);
                $result_p = mysqli_stmt_get_result($stmt_p);
                
                if($row_p = mysqli_fetch_assoc($result_p)) {
                  $sql_f = 'SELECT * FROM Flight WHERE flight_id=?';
                  $stmt_f = mysqli_stmt_init($conn);
                  if(mysqli_stmt_prepare($stmt_f,$sql_f)) {
                      mysqli_stmt_bind_param($stmt_f,'i',$row['flight_id']);            
                      mysqli_stmt_execute($stmt_f);
                      $result_f = mysqli_stmt_get_result($stmt_f);
                      
                      if($row_f = mysqli_fetch_assoc($result_f)) {
                        $date_dep = date('d M Y', strtotime($row_f['departure']));
                        $time_dep = date('H:i', strtotime($row_f['departure']));    
                        $date_arr = date('d M Y', strtotime($row_f['arrivale']));
                        $time_arr = date('H:i', strtotime($row_f['arrivale'])); 
                        $class_txt = $row['class'] === 'B' ? 'BUSINESS' : 'ECONOMY';
                        ?>
                        
                        <div class="ticket-wrapper animate-fade-in">
                            <!-- Main Ticket Body -->
                            <div class="ticket-main">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h3 class="mb-0 font-weight-900" style="color: var(--secondary-color);">SKYLINE <span class="badge badge-dark ml-2"><?php echo $class_txt; ?></span></h3>
                                    <h5 class="mb-0 text-muted">Flight: <?php echo htmlspecialchars($row_f['airline']); ?></h5>
                                </div>
                                
                                <div class="row align-items-center">
                                    <div class="col-4 text-center">
                                        <div class="ticket-time"><?php echo $time_dep; ?></div>
                                        <div class="ticket-value mb-0"><?php echo htmlspecialchars($row_f['source']); ?></div>
                                        <div class="ticket-label"><?php echo $date_dep; ?></div>
                                    </div>
                                    <div class="col-4">
                                        <div class="flight-path-line">
                                            <i class="fa fa-plane fa-2x"></i>
                                        </div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="ticket-time"><?php echo $time_arr; ?></div>
                                        <div class="ticket-value mb-0"><?php echo htmlspecialchars($row_f['Destination']); ?></div>
                                        <div class="ticket-label"><?php echo $date_arr; ?></div>
                                    </div>
                                </div>
                                
                                <hr class="my-4">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="ticket-label">Passenger</div>
                                        <div class="ticket-value text-uppercase"><?php echo htmlspecialchars($row_p['f_name'].' '.$row_p['l_name']); ?></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="ticket-label">Gate</div>
                                        <div class="ticket-value">TBA</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="ticket-label">Seat</div>
                                        <div class="ticket-value"><?php echo htmlspecialchars($row['seat_no']); ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Ticket Stub / Actions -->
                            <div class="ticket-stub text-center">
                                <div>
                                    <i class="fa fa-qrcode fa-4x mb-3"></i>
                                    <div class="small font-weight-bold mb-4">BOARDING PASS</div>
                                </div>
                                
                                <div>
                                    <form action="e_ticket.php" target="_blank" method="post" class="mb-2">
                                        <input type="hidden" name="ticket_id" value="<?php echo $row['ticket_id']; ?>">
                                        <button class="btn btn-light btn-block font-weight-bold" name="print_but">
                                            <i class="fa fa-print mr-2"></i> Print Ticket
                                        </button>
                                    </form>
                                    
                                    <form action="ticket.php" method="post" onsubmit="return confirm('Are you sure you want to cancel this ticket?');">
                                        <input type="hidden" name="ticket_id" value="<?php echo $row['ticket_id']; ?>">
                                        <button class="btn btn-outline-light btn-block" name="cancel_but">
                                            <i class="fa fa-times mr-2"></i> Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <?php
                      }
                  }                  
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