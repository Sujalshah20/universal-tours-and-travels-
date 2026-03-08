<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php if(isset($_SESSION['userId'])) {   
    require 'helpers/init_conn_db.php';                      
?> 

<style>
body { background: #f5f5f5; }
.page-header { background: linear-gradient(90deg, #05012d 0%, #07263d 100%); padding: 28px 0; }
.page-header h2 { color: #fff; font-size: 20px; font-weight: 900; margin-bottom: 4px; }
.page-header p { color: rgba(255,255,255,0.65); font-size: 13px; margin: 0; }

.flights-wrap { padding: 28px 0 48px; }

/* Ticket card - MMT style */
.ticket-card {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    overflow: hidden;
    margin-bottom: 14px;
    transition: all 0.25s;
}
.ticket-card:hover {
    box-shadow: 0 4px 20px rgba(0,140,255,0.15);
    border-color: #008cff;
    transform: translateY(-2px);
}
.ticket-header {
    background: linear-gradient(90deg, #05012d 0%, #07263d 100%);
    padding: 10px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ticket-header-left { display: flex; align-items: center; gap: 12px; }
.airline-icon-sm {
    width: 34px; height: 34px;
    background: rgba(255,255,255,0.12);
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: #53b2fe;
}
.airline-name-sm { font-size: 13px; font-weight: 700; color: #fff; }
.booking-id { font-size: 11px; color: rgba(255,255,255,0.55); font-weight: 700; }

.ticket-body { padding: 20px; }

/* Route display */
.time-lg { font-size: 24px; font-weight: 900; color: #333; line-height: 1; font-family: 'Lato', sans-serif; }
.city-sm { font-size: 12px; color: #9b9b9b; font-weight: 700; margin-top: 3px; }
.date-sm { font-size: 11px; color: #9b9b9b; margin-top: 2px; }

/* Path line */
.path-center {
    display: flex; flex-direction: column; align-items: center; gap: 4px;
    padding: 0 12px; flex: 1;
}
.path-row { display: flex; align-items: center; width: 100%; gap: 0; }
.path-dot-sm { width: 7px; height: 7px; border-radius: 50%; border: 2px solid #c0c0c0; background: #fff; flex-shrink: 0; }
.path-dash { flex: 1; border-top: 2px dashed #e0e0e0; }
.path-plane-sm { font-size: 13px; color: #008cff; transform: rotate(45deg); flex-shrink: 0; }
.dur-sm { font-size: 11px; color: #9b9b9b; font-weight: 700; }

/* Status */
.status-chip {
    display: inline-block; border-radius: 50px;
    font-size: 10px; font-weight: 700; padding: 3px 10px;
    text-transform: uppercase; letter-spacing: 0.5px;
}
.status-scheduled { background: #eaf5ff; color: #008cff; }
.status-dep       { background: #e3f2fd; color: #0288d1; }
.status-delayed   { background: #fff5f5; color: #dc2626; }
.status-arrived   { background: #f0fdf4; color: #16a34a; }

/* View ticket btn */
.btn-view-ticket {
    display: inline-block;
    border: 1.5px solid #008cff;
    border-radius: 4px;
    padding: 8px 18px;
    font-size: 12px;
    font-weight: 700;
    color: #008cff;
    font-family: 'Lato', sans-serif;
    transition: all 0.25s;
    text-decoration: none;
    white-space: nowrap;
}
.btn-view-ticket:hover {
    background: #008cff;
    color: #fff !important;
    text-decoration: none;
}

/* Empty state */
.empty-state { background: #fff; border-radius: 8px; border: 1px solid #e0e0e0; padding: 60px 30px; text-align: center; }
.empty-state i { font-size: 56px; color: #e0e0e0; display: block; margin-bottom: 20px; }
.empty-state h3 { font-size: 18px; font-weight: 900; color: #333; margin-bottom: 8px; }
.empty-state p { font-size: 13px; color: #9b9b9b; margin-bottom: 24px; }
.btn-book-now {
    display: inline-block; background: linear-gradient(93deg, #53b2fe, #065af3);
    border-radius: 50px; color: #fff !important; font-size: 14px; font-weight: 700;
    padding: 12px 38px; text-decoration: none; transition: all 0.25s;
    box-shadow: 0 4px 16px rgba(6,90,243,0.3);
}
.btn-book-now:hover { background: linear-gradient(93deg, #065af3, #053ab5); transform: translateY(-2px); text-decoration: none; }
</style>

<div class="page-header">
    <div class="container">
        <h2><i class="fa fa-ticket mr-2" style="color:#53b2fe;"></i> My Trips</h2>
        <p>Track your upcoming and past flights</p>
    </div>
</div>

<div class="flights-wrap">
    <div class="container">
        <?php 
        $sql_t = 'SELECT * FROM Ticket WHERE user_id=? ORDER BY flight_id DESC';
        $stmt_t = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt_t, $sql_t)) {
            echo '<div class="alert alert-danger">Database Error!</div>';
        } else {
            mysqli_stmt_bind_param($stmt_t, 'i', $_SESSION['userId']);            
            mysqli_stmt_execute($stmt_t);
            $result_t = mysqli_stmt_get_result($stmt_t);
            
            if(mysqli_num_rows($result_t) == 0):
        ?>
                <div class="empty-state">
                    <i class="fa fa-plane"></i>
                    <h3>No Trips Found</h3>
                    <p>You haven't booked any flights yet. Start exploring destinations!</p>
                    <a href="index.php" class="btn-book-now">Search Flights</a>
                </div>
        <?php
            endif;

            $processed = [];
            $card_num  = 0;
            while($row_t = mysqli_fetch_assoc($result_t)) {
                if(in_array($row_t['flight_id'], $processed)) continue;
                $processed[] = $row_t['flight_id'];
                $card_num++;

                $sql_f = 'SELECT * FROM Flight WHERE flight_id=?';
                $stmt_f = mysqli_stmt_init($conn);
                if(mysqli_stmt_prepare($stmt_f, $sql_f)) {
                    mysqli_stmt_bind_param($stmt_f, 'i', $row_t['flight_id']);
                    mysqli_stmt_execute($stmt_f);
                    $result_f = mysqli_stmt_get_result($stmt_f);
                    if($row_f = mysqli_fetch_assoc($result_f)) {
                        $date_dep = date('d M Y', strtotime($row_f['departure']));
                        $time_dep = date('H:i', strtotime($row_f['departure']));
                        $date_arr = date('d M Y', strtotime($row_f['arrivale']));
                        $time_arr = date('H:i', strtotime($row_f['arrivale']));

                        $start = new DateTime($row_f['departure']);
                        $end   = new DateTime($row_f['arrivale']);
                        $diff  = $start->diff($end);
                        $dur   = $diff->format('%hh %im');

                        $status_text  = 'Scheduled';
                        $status_class = 'status-scheduled';
                        if($row_f['status'] === 'dep')   { $status_text = 'Departed';  $status_class = 'status-dep'; }
                        elseif($row_f['status'] === 'issue') { $status_text = 'Delayed';   $status_class = 'status-delayed'; }
                        elseif($row_f['status'] === 'arr')  { $status_text = 'Arrived';   $status_class = 'status-arrived'; }
                ?>

                <div class="ticket-card animate-in" style="animation-delay:<?php echo $card_num * 0.08; ?>s; opacity:0;">
                    <div class="ticket-header">
                        <div class="ticket-header-left">
                            <div class="airline-icon-sm"><i class="fa fa-plane"></i></div>
                            <div>
                                <div class="airline-name-sm"><?php echo htmlspecialchars($row_f['airline'] ?? 'Skyline Air'); ?></div>
                                <div class="booking-id">Booking #<?php echo str_pad($row_t['flight_id'], 8, '0', STR_PAD_LEFT); ?></div>
                            </div>
                        </div>
                        <span class="status-chip <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                    </div>

                    <div class="ticket-body">
                        <div class="row align-items-center">
                            <!-- Departure -->
                            <div class="col-5 col-md-3 text-center">
                                <div class="time-lg"><?php echo $time_dep; ?></div>
                                <div class="city-sm"><?php echo htmlspecialchars($row_f['source']); ?></div>
                                <div class="date-sm"><?php echo $date_dep; ?></div>
                            </div>

                            <!-- Path -->
                            <div class="col-2 col-md-4 d-flex align-items-center justify-content-center">
                                <div class="path-center">
                                    <div class="path-row">
                                        <div class="path-dot-sm"></div>
                                        <div class="path-dash"></div>
                                        <div class="path-plane-sm"><i class="fa fa-plane"></i></div>
                                        <div class="path-dash"></div>
                                        <div class="path-dot-sm"></div>
                                    </div>
                                    <div class="dur-sm"><?php echo $dur; ?></div>
                                </div>
                            </div>

                            <!-- Arrival -->
                            <div class="col-5 col-md-3 text-center">
                                <div class="time-lg"><?php echo $time_arr; ?></div>
                                <div class="city-sm"><?php echo htmlspecialchars($row_f['Destination']); ?></div>
                                <div class="date-sm"><?php echo $date_arr; ?></div>
                            </div>

                            <!-- Action -->
                            <div class="col-md-2 text-md-right mt-3 mt-md-0 text-center">
                                <a href="ticket.php" class="btn-view-ticket">
                                    <i class="fa fa-ticket mr-1"></i> View E-Ticket
                                </a>
                            </div>
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
</div>

<?php } else {
    header("Location: index.php");
    exit();
} ?>
<?php subview('footer.php'); ?>
