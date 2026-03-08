<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); 
require 'helpers/init_conn_db.php';                      
?> 	

<style>
body { background: #f5f5f5; }

.page-header {
    background: linear-gradient(90deg, #05012d 0%, #07263d 100%);
    padding: 24px 0;
    color: #fff;
}
.page-header h1 { color: #fff; font-size: 22px; font-weight: 900; margin-bottom: 4px; }
.page-header p { color: rgba(255,255,255,0.65); font-size: 13px; margin: 0; }

.route-arrow { font-size: 0.7em; color: #53b2fe; vertical-align: middle; margin: 0 10px; }

.results-wrap { padding: 24px 0 40px; }

/* Flight result card - MMT style */
.flight-card {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    margin-bottom: 12px;
    transition: all 0.25s;
    overflow: hidden;
}
.flight-card:hover {
    box-shadow: 0 4px 20px rgba(0,140,255,0.18);
    border-color: #008cff;
    transform: translateY(-2px);
}
.flight-card-body { padding: 20px 24px; }
.flight-card-footer {
    background: #f8f8f8;
    border-top: 1px solid #e0e0e0;
    padding: 8px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
    color: #9b9b9b;
}

/* Airline info */
.airline-logo-box {
    width: 44px;
    height: 44px;
    background: #eaf5ff;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #008cff;
    flex-shrink: 0;
}
.airline-name { font-size: 14px; font-weight: 700; color: #333; }
.airline-code { font-size: 11px; color: #9b9b9b; }

/* Time display */
.time-display { font-size: 26px; font-weight: 900; color: #333; line-height: 1; font-family: 'Lato', sans-serif; }
.city-code { font-size: 12px; color: #9b9b9b; font-weight: 700; margin-top: 3px; }

/* Flight path */
.flight-path-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    padding: 0 8px;
    flex: 1;
}
.path-line {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 0;
}
.path-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    border: 2px solid #c0c0c0;
    background: #fff;
    flex-shrink: 0;
}
.path-dashes { flex: 1; border-top: 2px dashed #c0c0c0; }
.path-plane { font-size: 14px; color: #008cff; flex-shrink: 0; transform: rotate(45deg); }
.duration-text { font-size: 11px; color: #9b9b9b; font-weight: 700; }
.nonstop-badge { font-size: 11px; color: #52a755; font-weight: 700; }

/* Price */
.price-display { font-size: 26px; font-weight: 900; color: #333; line-height: 1; font-family: 'Lato', sans-serif; }
.price-sub { font-size: 11px; color: #9b9b9b; margin-top: 2px; }

/* Book button */
.btn-book {
    background: linear-gradient(93deg, #53b2fe, #065af3);
    border: none;
    border-radius: 4px;
    color: #fff !important;
    font-size: 13px;
    font-weight: 700;
    font-family: 'Lato', sans-serif;
    padding: 10px 22px;
    cursor: pointer;
    transition: all 0.25s;
    white-space: nowrap;
    display: inline-block;
    text-align: center;
}
.btn-book:hover {
    background: linear-gradient(93deg, #065af3, #053ab5);
    box-shadow: 0 4px 16px rgba(6,90,243,0.35);
    color: #fff !important;
    transform: translateY(-1px);
    text-decoration: none;
}
.btn-book:disabled, .btn-book-disabled {
    background: #e0e0e0;
    color: #9b9b9b !important;
    cursor: not-allowed;
    box-shadow: none;
    transform: none;
}

/* Status badges */
.badge-scheduled { background: #eaf5ff; color: #008cff; }
.badge-departed  { background: #e3f2fd; color: #0288d1; }
.badge-delayed   { background: #fff5f5; color: #dc2626; }
.badge-arrived   { background: #f0fdf4; color: #16a34a; }
.status-pill {
    display: inline-block;
    font-size: 10px; font-weight: 700;
    padding: 3px 10px; border-radius: 50px;
    text-transform: uppercase; letter-spacing: 0.5px;
    margin-bottom: 8px;
}

/* Filter sidebar */
.filter-sidebar {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    padding: 20px;
    margin-bottom: 16px;
}
.filter-title {
    font-size: 12px; font-weight: 700;
    color: #4a4a4a; text-transform: uppercase;
    letter-spacing: 0.5px; margin-bottom: 12px;
    padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;
}

/* Empty state */
.empty-state {
    background: #fff; border-radius: 8px;
    border: 1px solid #e0e0e0; padding: 60px 30px;
    text-align: center;
}
.empty-state i { font-size: 56px; color: #e0e0e0; display: block; margin-bottom: 20px; }
.empty-state h3 { font-size: 18px; font-weight: 900; color: #333; margin-bottom: 8px; }
.empty-state p { font-size: 13px; color: #9b9b9b; margin-bottom: 24px; }
</style>

<main>
    <?php if(isset($_POST['search_but'])) { 
        $dep_date = $_POST['dep_date'];                        
        $ret_date = isset($_POST['ret_date']) ? $_POST['ret_date'] : '';  
        $dep_city = $_POST['dep_city'];  
        $arr_city = $_POST['arr_city'];     
        $type = $_POST['type'];
        $f_class = $_POST['f_class'];
        $passengers = $_POST['passengers'];

        if ($dep_city === $arr_city) { header('Location: index.php?error=sameval'); exit(); }
        if($dep_city === '0' || empty($dep_city)) { header('Location: index.php?error=seldep'); exit(); }
        if($arr_city === '0' || empty($arr_city)) { header('Location: index.php?error=selarr'); exit(); }
    ?>
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
            <div>
                <h1>
                    <?php echo htmlspecialchars($dep_city); ?>
                    <i class="fa fa-long-arrow-right route-arrow"></i>
                    <?php echo htmlspecialchars($arr_city); ?>
                </h1>
                <p>
                    <i class="fa fa-calendar mr-2"></i><?php echo date('D, d M Y', strtotime($dep_date)); ?>
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <i class="fa fa-users mr-2"></i><?php echo htmlspecialchars($passengers); ?> Traveller(s)
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <?php echo $f_class == 'B' ? 'Business Class' : 'Economy Class'; ?>
                    <?php if($type == 'round'): ?>
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <i class="fa fa-exchange mr-1"></i> Round Trip
                    <?php endif; ?>
                </p>
            </div>
            <a href="index.php" class="btn-book" style="padding:10px 24px; font-size:13px; border-radius:50px;">
                <i class="fa fa-search mr-1"></i> Modify Search
            </a>
        </div>
    </div>

    <!-- Results -->
    <div class="results-wrap">
        <div class="container">
            <div class="row">
                <!-- Filter Sidebar -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="filter-sidebar">
                        <div class="filter-title">Stops</div>
                        <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:700; color:#4a4a4a; cursor:pointer; margin-bottom:8px;">
                            <input type="checkbox" checked style="accent-color:#008cff;"> Non Stop
                        </label>
                        <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:700; color:#4a4a4a; cursor:pointer;">
                            <input type="checkbox" style="accent-color:#008cff;"> 1 Stop
                        </label>
                    </div>
                    <div class="filter-sidebar">
                        <div class="filter-title">Departure Time</div>
                        <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:700; color:#4a4a4a; cursor:pointer; margin-bottom:8px;">
                            <input type="checkbox" style="accent-color:#008cff;"> Morning (6am – 12pm)
                        </label>
                        <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:700; color:#4a4a4a; cursor:pointer; margin-bottom:8px;">
                            <input type="checkbox" style="accent-color:#008cff;"> Afternoon (12pm – 6pm)
                        </label>
                        <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:700; color:#4a4a4a; cursor:pointer;">
                            <input type="checkbox" style="accent-color:#008cff;"> Night (After 6pm)
                        </label>
                    </div>
                </div>

                <!-- Flight Results -->
                <div class="col-md-9">
                    <?php
                    $sql = 'SELECT * FROM Flight WHERE source=? AND Destination=? AND DATE(departure)=? ORDER BY Price';
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $sql);                
                    mysqli_stmt_bind_param($stmt, 'sss', $dep_city, $arr_city, $dep_date);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    
                    if (mysqli_num_rows($result) == 0) {
                        echo '<div class="empty-state">
                            <i class="fa fa-search"></i>
                            <h3>No Flights Found</h3>
                            <p>We couldn\'t find flights for <strong>' . htmlspecialchars($dep_city) . ' → ' . htmlspecialchars($arr_city) . '</strong> on ' . date('D, d M Y', strtotime($dep_date)) . '.<br>Try a different date or route.</p>
                            <a href="index.php" class="btn-book" style="padding:12px 36px; border-radius:50px;">Search Another Date</a>
                        </div>';
                    }

                    $i = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $price = (int)$row['Price'] * (int)$passengers;
                        if($type === 'round') $price *= 2;
                        if($f_class == 'B') $price += 0.5 * $price;

                        $status_text = 'Scheduled';
                        $status_class = 'badge-scheduled';
                        if($row['status'] === 'dep')   { $status_text = 'Departed';  $status_class = 'badge-departed'; }
                        elseif($row['status'] === 'issue') { $status_text = 'Delayed';   $status_class = 'badge-delayed'; }
                        elseif($row['status'] === 'arr')  { $status_text = 'Arrived';   $status_class = 'badge-arrived'; }

                        $start = new DateTime($row['departure']);
                        $end   = new DateTime($row['arrivale']);
                        $diff  = $start->diff($end);
                        $dur   = $diff->format('%hh %im');
                        $i++;
                    ?>

                    <div class="flight-card animate-in" style="animation-delay:<?php echo $i*0.08; ?>s; opacity:0;">
                        <div class="flight-card-body">
                            <div class="row align-items-center">
                                <!-- Airline -->
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <div class="d-flex align-items-center" style="gap:12px;">
                                        <div class="airline-logo-box"><i class="fa fa-plane"></i></div>
                                        <div>
                                            <div class="airline-name"><?php echo htmlspecialchars($row['airline']); ?></div>
                                            <div class="airline-code"><?php echo $f_class == 'B' ? 'Business' : 'Economy'; ?></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Departure -->
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <div class="time-display"><?php echo date('H:i', strtotime($row['departure'])); ?></div>
                                    <div class="city-code"><?php echo htmlspecialchars($row['source']); ?></div>
                                </div>

                                <!-- Flight path -->
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <div class="flight-path-center">
                                        <div class="path-line">
                                            <div class="path-dot"></div>
                                            <div class="path-dashes"></div>
                                            <div class="path-plane"><i class="fa fa-plane"></i></div>
                                            <div class="path-dashes"></div>
                                            <div class="path-dot"></div>
                                        </div>
                                        <div class="duration-text"><?php echo $dur; ?></div>
                                        <div class="nonstop-badge">Non-stop</div>
                                    </div>
                                </div>

                                <!-- Arrival -->
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <div class="time-display"><?php echo date('H:i', strtotime($row['arrivale'])); ?></div>
                                    <div class="city-code"><?php echo htmlspecialchars($row['Destination']); ?></div>
                                </div>

                                <!-- Price & Book -->
                                <div class="col-md-2 text-md-right">
                                    <div class="mb-1">
                                        <span class="status-pill <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                    </div>
                                    <div class="price-display">₹<?php echo number_format($price); ?></div>
                                    <div class="price-sub">Per person (incl. taxes)</div>
                                    <div class="mt-2">
                                    <?php if(isset($_SESSION['userId']) && $row['status'] === '') { ?>
                                        <form action='pass_form.php' method='post' style="display:inline;">
                                            <input name='flight_id' type='hidden' value="<?php echo $row['flight_id']; ?>">
                                            <input name='type' type='hidden' value="<?php echo $type; ?>">
                                            <input name='passengers' type='hidden' value="<?php echo $passengers; ?>">
                                            <input name='price' type='hidden' value="<?php echo $price; ?>">
                                            <input name='ret_date' type='hidden' value="<?php echo $ret_date; ?>">
                                            <input name='class' type='hidden' value="<?php echo $f_class; ?>">
                                            <button name='book_but' type='submit' class='btn-book' style="width:100%;">BOOK NOW</button>
                                        </form>
                                    <?php } elseif(isset($_SESSION['userId'])) { ?>
                                        <button class="btn-book btn-book-disabled" disabled style="width:100%;">Unavailable</button>
                                    <?php } else { ?>
                                        <a href="login.php" class="btn-book" style="width:100%; display:block;">LOGIN TO BOOK</a>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flight-card-footer">
                            <span><i class="fa fa-info-circle mr-1"></i> Refundable &nbsp;|&nbsp; Free Meal</span>
                            <span><?php echo $type === 'round' ? '<i class="fa fa-exchange mr-1"></i> Round Trip' : '<i class="fa fa-arrow-right mr-1"></i> One Way'; ?></span>
                        </div>
                    </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</main>

<?php subview('footer.php'); ?>