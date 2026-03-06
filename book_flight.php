<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); 
require 'helpers/init_conn_db.php';                      
?> 	

<style>
    body {
        background: radial-gradient(circle at top right, #1e293b, #0f172a);
        min-height: 100vh;
    }
    .flight-header {
        padding: 4rem 0 2rem;
        background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('assets/images/hero-bg.png');
        background-size: cover;
        background-position: center;
        border-bottom: 1px solid var(--glass-border);
    }
    .flight-result-card {
        border-radius: 1.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        transition: var(--transition);
    }
    .flight-result-card:hover {
        transform: translateY(-5px);
        border-color: var(--secondary-color);
    }
    .airline-logo {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .time-large {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    .price-tag {
        font-size: 2rem;
        font-weight: 900;
        color: var(--accent-color);
    }
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
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

        if ($dep_city === $arr_city) {
            header('Location: index.php?error=sameval');
            exit();
        }
        if($dep_city === '0' || empty($dep_city)) {
            header('Location: index.php?error=seldep');
            exit(); 
        }
        if($arr_city === '0' || empty($arr_city)) {
            header('Location: index.php?error=selarr');
            exit();              
        }
    ?>
    <section class="flight-header text-center mb-5">
        <div class="container animate-fade-in">
            <h1 class="hero-title mb-2"><?php echo htmlspecialchars($dep_city); ?> <i class="fa fa-long-arrow-right mx-3" style="font-size: 0.6em; vertical-align: middle; color: var(--secondary-color);"></i> <?php echo htmlspecialchars($arr_city); ?></h1>
            <p class="text-secondary font-weight-bold">
                <i class="fa fa-calendar mr-2"></i> <?php echo date('D, d M Y', strtotime($dep_date)); ?> 
                <span class="mx-3 text-muted">|</span> 
                <i class="fa fa-users mr-2"></i> <?php echo htmlspecialchars($passengers); ?> Travelers
            </p>
        </div>
    </section>

    <div class="container pb-5">
        <?php
        $sql = 'SELECT * FROM Flight WHERE source=? AND Destination =? AND DATE(departure)=? ORDER BY Price';
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);                
        mysqli_stmt_bind_param($stmt,'sss',$dep_city,$arr_city,$dep_date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 0) {
            echo '<div class="glass-panel p-5 text-center animate-fade-in">
                    <i class="fa fa-plane-slash fa-4x text-muted mb-4"></i>
                    <h3>No Flights Found</h3>
                    <p class="text-secondary">We couldn\'t find any flights matching your criteria for this date.</p>
                    <a href="index.php" class="btn btn-premium mt-3">Search Another Date</a>
                  </div>';
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $price = (int)$row['Price']*(int)$passengers;
            if($type === 'round') { $price = $price*2; }
            if($f_class == 'B') { $price += 0.5*$price; }

            $status_text = "Scheduled";
            $status_class = "bg-primary-transparent text-primary";
            if($row['status'] === 'dep') { $status_text = "Departed"; $status_class = "bg-info-transparent text-info"; }
            else if($row['status'] === 'issue') { $status_text = "Delayed"; $status_class = "bg-danger-transparent text-danger"; }
            else if($row['status'] === 'arr') { $status_text = "Arrived"; $status_class = "bg-success-transparent text-success"; }
            ?>
            <div class="glass-panel flight-result-card animate-fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-2 mb-3 mb-lg-0">
                        <div class="d-flex align-items-center">
                            <div class="airline-logo mr-3">
                                <i class="fa fa-plane"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 font-weight-800"><?php echo htmlspecialchars($row['airline']); ?></h5>
                                <span class="small text-secondary"><?php echo $f_class == 'B' ? 'Business' : 'Economy'; ?> Class</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 text-center mb-3 mb-lg-0">
                        <div class="time-large mb-1"><?php echo date('H:i', strtotime($row['departure'])); ?></div>
                        <div class="small text-secondary font-weight-bold"><?php echo htmlspecialchars($row['source']); ?></div>
                    </div>
                    <div class="col-lg-2 text-center mb-3 mb-lg-0">
                        <div class="position-relative">
                            <hr class="border-secondary" style="border-style: dashed;">
                            <i class="fa fa-plane position-absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%); color: var(--secondary-color);"></i>
                        </div>
                        <?php 
                        $start = new DateTime($row['departure']);
                        $end = new DateTime($row['arrivale']);
                        $diff = $start->diff($end);
                        echo '<span class="small text-muted font-weight-bold">'.$diff->format('%h hrs %i min').'</span>';
                        ?>
                    </div>
                    <div class="col-lg-3 text-center mb-3 mb-lg-0">
                        <div class="time-large mb-1"><?php echo date('H:i', strtotime($row['arrivale'])); ?></div>
                        <div class="small text-secondary font-weight-bold"><?php echo htmlspecialchars($row['Destination']); ?></div>
                    </div>
                    <div class="col-lg-2 text-right">
                        <div class="mb-2">
                            <span class="status-badge <?php echo $status_class; ?>" style="background: rgba(255,255,255,0.05);">
                                <?php echo $status_text; ?>
                            </span>
                        </div>
                        <div class="price-tag mb-3">$<?php echo number_format($price); ?></div>
                        
                        <?php if(isset($_SESSION['userId']) && $row['status'] === '') { ?>
                            <form action='pass_form.php' method='post'>
                                <input name='flight_id' type='hidden' value="<?php echo $row['flight_id']; ?>">
                                <input name='type' type='hidden' value="<?php echo $type; ?>">
                                <input name='passengers' type='hidden' value="<?php echo $passengers; ?>">
                                <input name='price' type='hidden' value="<?php echo $price; ?>">
                                <input name='ret_date' type='hidden' value="<?php echo $ret_date; ?>">
                                <input name='class' type='hidden' value="<?php echo $f_class; ?>">
                                <button name='book_but' type='submit' class='btn btn-premium btn-block'>Book Now</button>
                            </form>
                        <?php } else if (isset($_SESSION['userId'])) { ?>
                            <button class="btn btn-secondary btn-block disabled" disabled>Not Available</button>
                        <?php } else { ?>
                            <a href="login.php" class="btn btn-accent btn-block">Login to Book</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
    </div>
    <?php } ?>
</main>

<?php subview('footer.php'); ?>