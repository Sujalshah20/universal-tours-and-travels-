<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); 
require 'helpers/init_conn_db.php';                      

// Early connection check
$is_db_connected = isset($conn) && $conn !== false;
?> 

<style>
    body { background: #f5f5f5; }

    /* Hero */
    .hero-section {
        background: linear-gradient(135deg, #05012d 0%, #07263d 100%);
        padding: 50px 0 120px;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: -100px; left: -100px;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(83,178,254,0.12) 0%, transparent 70%);
        pointer-events: none;
    }
    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -80px; right: -80px;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(6,90,243,0.18) 0%, transparent 70%);
        pointer-events: none;
    }
    .hero-title {
        color: #fff;
        font-size: 28px;
        font-weight: 900;
        margin-bottom: 6px;
        font-family: 'Lato', sans-serif;
    }
    .hero-sub {
        color: rgba(255,255,255,0.65);
        font-size: 13px;
        margin-bottom: 0;
    }

    /* SEARCH CARD */
    .search-card-wrap {
        margin-top: -80px;
        position: relative;
        z-index: 30;
    }
    .search-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        overflow: hidden;
    }

    /* Trip type bar */
    .trip-type-bar {
        background: #f8f8f8;
        padding: 14px 24px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        gap: 28px;
        flex-wrap: wrap;
    }
    .trip-radio-label {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        font-weight: 700;
        color: #4a4a4a;
        cursor: pointer;
        margin: 0;
    }
    .trip-radio-label input[type="radio"] {
        accent-color: #008cff;
        width: 15px;
        height: 15px;
        cursor: pointer;
    }

    /* City fields row */
    .city-row {
        display: flex;
        align-items: stretch;
        border-bottom: 1px solid #e0e0e0;
    }
    .city-col {
        flex: 1;
        padding: 18px 24px;
        cursor: pointer;
        border-right: 1px solid #e0e0e0;
        position: relative;
        transition: background 0.2s;
    }
    .city-col:last-child { border-right: none; }
    .city-col:hover { background: #f0f7ff; }

    .city-label {
        font-size: 11px;
        font-weight: 700;
        color: #9b9b9b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .city-select-mmt {
        width: 100%;
        border: none;
        outline: none;
        font-size: 24px;
        font-weight: 900;
        font-family: 'Lato', sans-serif;
        color: #333;
        background: transparent;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        padding: 0;
    }
    .city-select-mmt option { font-size: 14px; font-weight: 400; }
    .city-sub {
        font-size: 11px;
        color: #9b9b9b;
        margin-top: 3px;
    }

    /* Swap button */
    .swap-col {
        width: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-right: 1px solid #e0e0e0;
        flex-shrink: 0;
        background: #fff;
    }
    .swap-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 2px solid #e0e0e0;
        background: #fff;
        color: #008cff;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .swap-btn:hover {
        background: #008cff;
        color: #fff;
        border-color: #008cff;
        transform: rotate(180deg);
    }

    /* Date cols */
    .date-col {
        flex: 1;
        padding: 18px 24px;
        cursor: pointer;
        border-right: 1px solid #e0e0e0;
        transition: background 0.2s;
    }
    .date-col:hover { background: #f0f7ff; }
    .date-input-mmt {
        width: 100%;
        border: none;
        outline: none;
        font-size: 24px;
        font-weight: 900;
        font-family: 'Lato', sans-serif;
        color: #333;
        background: transparent;
        cursor: pointer;
        padding: 0;
    }
    .date-input-mmt::-webkit-calendar-picker-indicator {
        opacity: 0;
        position: absolute;
        width: 100%;
        left: 0;
        cursor: pointer;
    }

    /* Pax & class row */
    .pax-row {
        display: flex;
        align-items: center;
        padding: 16px 24px;
        gap: 28px;
        border-bottom: 1px solid #e0e0e0;
        flex-wrap: wrap;
    }
    .pax-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .pax-label { font-size: 11px; font-weight: 700; color: #9b9b9b; text-transform: uppercase; letter-spacing: 0.5px; }
    .pax-btn-mmt {
        width: 28px; height: 28px;
        border-radius: 50%;
        border: 1.5px solid #e0e0e0;
        background: #fff;
        color: #008cff;
        font-size: 14px;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .pax-btn-mmt:hover { background: #008cff; color: #fff; border-color: #008cff; }
    .pax-num { font-size: 20px; font-weight: 900; color: #333; min-width: 24px; text-align: center; }

    /* Special fares */
    .special-fares-bar {
        padding: 14px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .sf-label { font-size: 12px; font-weight: 700; color: #4a4a4a; white-space: nowrap; }
    .sf-chip {
        border: 1.5px solid #e0e0e0;
        border-radius: 50px;
        padding: 5px 14px;
        font-size: 12px;
        font-weight: 700;
        color: #4a4a4a;
        cursor: pointer;
        transition: all 0.2s;
        background: #fff;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .sf-chip:hover, .sf-chip.active {
        border-color: #008cff;
        color: #008cff;
        background: #eaf5ff;
    }

    /* Search button */
    .search-btn-wrap {
        display: flex;
        justify-content: center;
        padding: 10px 0 32px;
    }
    .search-btn {
        background: linear-gradient(93deg, #53b2fe, #065af3);
        border: none;
        border-radius: 50px;
        color: #fff;
        font-family: 'Lato', sans-serif;
        font-size: 16px;
        font-weight: 900;
        padding: 14px 70px;
        cursor: pointer;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        box-shadow: 0 4px 20px rgba(6,90,243,0.4);
        transition: all 0.25s;
    }
    .search-btn:hover {
        background: linear-gradient(93deg, #065af3, #053ab5);
        box-shadow: 0 6px 28px rgba(6,90,243,0.5);
        transform: translateY(-2px);
    }

    /* Stats strip */
    .stats-strip { background: linear-gradient(90deg, #05012d 0%, #07263d 100%); padding: 28px 0; margin-top: 48px; }
    .stat-item { text-align: center; }
    .stat-num { font-size: 34px; font-weight: 900; color: #53b2fe; line-height: 1; margin-bottom: 4px; font-family: 'Lato', sans-serif; }
    .stat-label { font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.65); text-transform: uppercase; letter-spacing: 0.5px; }

    /* Offers section */
    .offers-section { background: #fff; padding: 36px 0; border-top: 1px solid #e0e0e0; }
    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .section-head h2 { font-size: 20px; font-weight: 900; color: #333; margin: 0; }
    .offer-card {
        background: #fff;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        overflow: hidden;
        transition: all 0.25s;
        cursor: pointer;
        height: 100%;
    }
    .offer-card:hover {
        box-shadow: 0 4px 20px rgba(0,140,255,0.2);
        border-color: #008cff;
        transform: translateY(-3px);
    }
    .offer-img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        background: linear-gradient(135deg, #05012d, #07263d);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
    }
    .offer-body { padding: 14px; }
    .offer-tag {
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        background: #eaf5ff;
        color: #008cff;
        padding: 2px 8px;
        border-radius: 50px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    .offer-title { font-size: 14px; font-weight: 700; color: #333; margin-bottom: 3px; }
    .offer-sub { font-size: 12px; color: #9b9b9b; }

    /* Destinations */
    .destinations-section { background: #f5f5f5; padding: 36px 0; }
    .dest-card {
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        height: 200px;
        transition: all 0.3s;
    }
    .dest-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
    .dest-img-bg {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        position: absolute;
        top: 0; left: 0;
    }
    .dest-overlay {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.75));
        padding: 20px 16px 14px;
        color: #fff;
    }
    .dest-city { font-size: 18px; font-weight: 900; margin-bottom: 2px; }
    .dest-price { font-size: 12px; color: rgba(255,255,255,0.8); font-weight: 700; }
    .dest-badge {
        position: absolute;
        top: 12px; right: 12px;
        background: rgba(0,140,255,0.9);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 50px;
        text-transform: uppercase;
    }

    /* Features section */
    .features-section { background: #fff; padding: 36px 0; border-top: 1px solid #e0e0e0; }
    .feature-card { text-align: center; padding: 24px 16px; }
    .feature-icon {
        width: 60px; height: 60px;
        background: #eaf5ff;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
        font-size: 24px;
        color: #008cff;
    }
    .feature-title { font-size: 14px; font-weight: 700; color: #333; margin-bottom: 6px; }
    .feature-desc { font-size: 12px; color: #9b9b9b; line-height: 1.6; }
</style>

<main>
    <!-- ===== HERO ===== -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="hero-title">Unlock ₹1,400 off* on flights</h1>
            <p class="hero-sub">Use code <strong style="color:#53b2fe;">SKYLINE14</strong> &nbsp;|&nbsp; Valid on all domestic flights</p>
        </div>
    </section>

    <!-- ===== SEARCH CARD ===== -->
    <div class="container search-card-wrap animate-in">
        <div class="search-card">
            <!-- Trip type -->
            <div class="trip-type-bar" id="trip-type-bar">
                <label class="trip-radio-label"><input type="radio" name="trip_ui" value="one" onclick="setTripType('one')"> One Way</label>
                <label class="trip-radio-label"><input type="radio" name="trip_ui" value="round" checked onclick="setTripType('round')"> Round Trip</label>
                <label class="trip-radio-label"><input type="radio" name="trip_ui" value="multi" onclick="setTripType('multi')"> Multi City</label>
            </div>

            <!-- Round trip form (shown by default) -->
            <form action="book_flight.php" method="post" id="round-form">
                <input type="hidden" name="type" value="round">
                <!-- City row -->
                <div class="city-row">
                    <div class="city-col">
                        <div class="city-label"><i class="fa fa-map-marker mr-1"></i> From</div>
                        <select name="dep_city" class="city-select-mmt" required>
                            <option value="" disabled selected>City or Airport</option>
                            <?php
                            if ($is_db_connected) {
                                $sql = 'SELECT * FROM Cities ORDER BY city ASC';
                                $res = mysqli_query($conn, $sql);
                                if ($res) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo '<option value="'.htmlspecialchars($row['city']).'">'.htmlspecialchars($row['city']).'</option>';
                                    }
                                } else {
                                    echo '<option value="" disabled>Error loading cities</option>';
                                }
                            } else {
                                echo '<option value="" disabled>Database not connected</option>';
                                echo '<option value="Mumbai">Mumbai (Demo)</option>';
                                echo '<option value="Delhi">Delhi (Demo)</option>';
                            }
                            ?>
                        </select>
                        <div class="city-sub">Tap to select departure city</div>
                    </div>
                    <div class="swap-col">
                        <button type="button" class="swap-btn" title="Swap cities"><i class="fa fa-exchange"></i></button>
                    </div>
                    <div class="city-col">
                        <div class="city-label"><i class="fa fa-plane mr-1"></i> To</div>
                        <select name="arr_city" class="city-select-mmt" required>
                            <option value="" disabled selected>City or Airport</option>
                            <?php
                            if ($is_db_connected && $res) {
                                mysqli_data_seek($res, 0);
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo '<option value="'.htmlspecialchars($row['city']).'">'.htmlspecialchars($row['city']).'</option>';
                                }
                            } else {
                                echo '<option value="" disabled>Database not connected</option>';
                                echo '<option value="Bangalore">Bangalore (Demo)</option>';
                                echo '<option value="Dubai">Dubai (Demo)</option>';
                            }
                            ?>
                        </select>
                        <div class="city-sub">Tap to select arrival city</div>
                    </div>
                    <div class="date-col">
                        <div class="city-label"><i class="fa fa-calendar mr-1"></i> Departure</div>
                        <input type="date" name="dep_date" class="date-input-mmt" required>
                        <div class="city-sub">Select departure date</div>
                    </div>
                    <div class="date-col" style="border-right:none;">
                        <div class="city-label"><i class="fa fa-calendar-check-o mr-1"></i> Return</div>
                        <input type="date" name="ret_date" class="date-input-mmt" required>
                        <div class="city-sub">Select return date</div>
                    </div>
                </div>

                <!-- Pax & Class -->
                <div class="pax-row">
                    <div>
                        <div class="pax-label mb-1">Travellers</div>
                        <div class="pax-group">
                            <button type="button" class="pax-btn-mmt" id="r-minus"><i class="fa fa-minus"></i></button>
                            <span class="pax-num" id="r-count">1</span>
                            <button type="button" class="pax-btn-mmt" id="r-plus"><i class="fa fa-plus"></i></button>
                            <input type="hidden" name="passengers" id="r-pax-val" value="1">
                            <span style="font-size:12px; color:#9b9b9b; margin-left:4px;">Traveller(s)</span>
                        </div>
                    </div>
                    <div>
                        <div class="pax-label mb-1">Class</div>
                        <select name="f_class" style="border:none; font-size:14px; font-weight:700; font-family:'Lato',sans-serif; color:#4a4a4a; background:transparent; outline:none; cursor:pointer;">
                            <option value="E">Economy</option>
                            <option value="B">Business</option>
                        </select>
                    </div>
                </div>

                <!-- Special Fares -->
                <div class="special-fares-bar">
                    <span class="sf-label">Special Fares (Optional):</span>
                    <span class="sf-chip active"><i class="fa fa-check-circle"></i> Regular</span>
                    <span class="sf-chip"><i class="fa fa-graduation-cap"></i> Student</span>
                    <span class="sf-chip"><i class="fa fa-shield"></i> Armed Forces</span>
                    <span class="sf-chip"><i class="fa fa-medkit"></i> Senior Citizen</span>
                </div>

                <!-- Search Button -->
                <div class="search-btn-wrap">
                    <button type="submit" name="search_but" class="search-btn">
                        <i class="fa fa-search mr-2"></i> SEARCH FLIGHTS
                    </button>
                </div>
            </form>

            <!-- One Way form (hidden by default) -->
            <div id="one-form-wrap" style="display:none;">
                <form action="book_flight.php" method="post">
                    <input type="hidden" name="type" value="one">
                    <div class="city-row">
                        <div class="city-col">
                            <div class="city-label"><i class="fa fa-map-marker mr-1"></i> From</div>
                            <select name="dep_city" class="city-select-mmt" required>
                                <option value="" disabled selected>City or Airport</option>
                                <?php
                                if ($is_db_connected && $res) {
                                    mysqli_data_seek($res, 0);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo '<option value="'.htmlspecialchars($row['city']).'">'.htmlspecialchars($row['city']).'</option>';
                                    }
                                } else {
                                    echo '<option value="" disabled>Database not connected</option>';
                                    echo '<option value="Mumbai">Mumbai (Demo)</option>';
                                    echo '<option value="Delhi">Delhi (Demo)</option>';
                                }
                                ?>
                            </select>
                            <div class="city-sub">Tap to select departure city</div>
                        </div>
                        <div class="swap-col">
                            <button type="button" class="swap-btn"><i class="fa fa-exchange"></i></button>
                        </div>
                        <div class="city-col">
                            <div class="city-label"><i class="fa fa-plane mr-1"></i> To</div>
                            <select name="arr_city" class="city-select-mmt" required>
                                <option value="" disabled selected>City or Airport</option>
                                <?php
                                if ($is_db_connected && $res) {
                                    mysqli_data_seek($res, 0);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo '<option value="'.htmlspecialchars($row['city']).'">'.htmlspecialchars($row['city']).'</option>';
                                    }
                                } else {
                                    echo '<option value="" disabled>Database not connected</option>';
                                    echo '<option value="Bangalore">Bangalore (Demo)</option>';
                                    echo '<option value="Dubai">Dubai (Demo)</option>';
                                }
                                ?>
                            </select>
                            <div class="city-sub">Tap to select arrival city</div>
                        </div>
                        <div class="date-col" style="border-right:none;">
                            <div class="city-label"><i class="fa fa-calendar mr-1"></i> Departure</div>
                            <input type="date" name="dep_date" class="date-input-mmt" required>
                            <div class="city-sub">Select departure date</div>
                        </div>
                    </div>
                    <div class="pax-row">
                        <div>
                            <div class="pax-label mb-1">Travellers</div>
                            <div class="pax-group">
                                <button type="button" class="pax-btn-mmt ow-minus"><i class="fa fa-minus"></i></button>
                                <span class="pax-num ow-count">1</span>
                                <button type="button" class="pax-btn-mmt ow-plus"><i class="fa fa-plus"></i></button>
                                <input type="hidden" name="passengers" class="ow-pax-val" value="1">
                                <span style="font-size:12px; color:#9b9b9b; margin-left:4px;">Traveller(s)</span>
                            </div>
                        </div>
                        <div>
                            <div class="pax-label mb-1">Class</div>
                            <select name="f_class" style="border:none; font-size:14px; font-weight:700; font-family:'Lato',sans-serif; color:#4a4a4a; background:transparent; outline:none; cursor:pointer;">
                                <option value="E">Economy</option>
                                <option value="B">Business</option>
                            </select>
                        </div>
                    </div>
                    <div class="special-fares-bar">
                        <span class="sf-label">Special Fares (Optional):</span>
                        <span class="sf-chip active"><i class="fa fa-check-circle"></i> Regular</span>
                        <span class="sf-chip"><i class="fa fa-graduation-cap"></i> Student</span>
                        <span class="sf-chip"><i class="fa fa-shield"></i> Armed Forces</span>
                    </div>
                    <div class="search-btn-wrap">
                        <button type="submit" name="search_but" class="search-btn">
                            <i class="fa fa-search mr-2"></i> SEARCH FLIGHTS
                        </button>
                    </div>
                </form>
            </div>

        </div><!-- /.search-card -->
    </div><!-- /.container -->

    <!-- ===== STATS STRIP ===== -->
    <div class="stats-strip">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3 stat-item mb-3 mb-md-0">
                    <div class="stat-num" data-target="5000000">0</div>
                    <div class="stat-label">Happy Travellers</div>
                </div>
                <div class="col-6 col-md-3 stat-item mb-3 mb-md-0">
                    <div class="stat-num" data-target="500">0</div>
                    <div class="stat-label">Routes Available</div>
                </div>
                <div class="col-6 col-md-3 stat-item mb-3 mb-md-0">
                    <div class="stat-num" data-target="120">0</div>
                    <div class="stat-label">Destinations</div>
                </div>
                <div class="col-6 col-md-3 stat-item">
                    <div class="stat-num" data-target="50">0</div>
                    <div class="stat-label">Partner Airlines</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== OFFERS ===== -->
    <div class="offers-section">
        <div class="container">
            <div class="section-head">
                <h2>Offers For You</h2>
                <a href="#" style="font-size:13px; font-weight:700; color:#008cff;">View All <i class="fa fa-chevron-right"></i></a>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="offer-card animate-in animate-delay-1">
                        <div class="offer-img" style="background: linear-gradient(135deg, #0a2342, #1565c0);">✈️</div>
                        <div class="offer-body">
                            <span class="offer-tag">Flights</span>
                            <div class="offer-title">Up to 40% OFF on Domestic Flights</div>
                            <div class="offer-sub">Use code SKYFLY40 &nbsp;|&nbsp; T&amp;C Apply</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="offer-card animate-in animate-delay-2">
                        <div class="offer-img" style="background: linear-gradient(135deg, #1a237e, #283593);">🌏</div>
                        <div class="offer-body">
                            <span class="offer-tag">International</span>
                            <div class="offer-title">International Flights from ₹12,999</div>
                            <div class="offer-sub">Explore world destinations &nbsp;|&nbsp; Select routes</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="offer-card animate-in animate-delay-3">
                        <div class="offer-img" style="background: linear-gradient(135deg, #004d40, #00695c);">🏖️</div>
                        <div class="offer-body">
                            <span class="offer-tag">Holiday</span>
                            <div class="offer-title">Holiday Packages from ₹7,999</div>
                            <div class="offer-sub">Flight + Hotel combos &nbsp;|&nbsp; Best prices</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== POPULAR DESTINATIONS ===== -->
    <div class="destinations-section">
        <div class="container">
            <div class="section-head mb-3">
                <h2>Popular Destinations</h2>
                <a href="#" style="font-size:13px; font-weight:700; color:#008cff;">View All <i class="fa fa-chevron-right"></i></a>
            </div>
            <div class="row">
                <div class="col-6 col-md-3 mb-3">
                    <div class="dest-card">
                        <div class="dest-img-bg" style="background: linear-gradient(135deg, #0d47a1, #1565c0, #42a5f5);"></div>
                        <span class="dest-badge">Trending</span>
                        <div class="dest-overlay">
                            <div class="dest-city">Delhi</div>
                            <div class="dest-price">From ₹2,499</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="dest-card">
                        <div class="dest-img-bg" style="background: linear-gradient(135deg, #880e4f, #ad1457, #ec407a);"></div>
                        <span class="dest-badge">Hot Deal</span>
                        <div class="dest-overlay">
                            <div class="dest-city">Mumbai</div>
                            <div class="dest-price">From ₹1,999</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="dest-card">
                        <div class="dest-img-bg" style="background: linear-gradient(135deg, #1b5e20, #2e7d32, #66bb6a);"></div>
                        <div class="dest-overlay">
                            <div class="dest-city">Goa</div>
                            <div class="dest-price">From ₹3,299</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="dest-card">
                        <div class="dest-img-bg" style="background: linear-gradient(135deg, #4a148c, #6a1b9a, #ab47bc);"></div>
                        <span class="dest-badge">Popular</span>
                        <div class="dest-overlay">
                            <div class="dest-city">Bengaluru</div>
                            <div class="dest-price">From ₹2,799</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== WHY CHOOSE US ===== -->
    <div class="features-section">
        <div class="container">
            <h2 class="text-center mb-1" style="font-size:20px; font-weight:900;">Why Book with Skyline?</h2>
            <p class="text-center mb-4" style="color:#9b9b9b; font-size:13px;">India's most trusted flight booking platform</p>
            <div class="row">
                <div class="col-6 col-md-3 mb-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-shield"></i></div>
                        <div class="feature-title">Secure Booking</div>
                        <div class="feature-desc">Bank-level encryption keeps your data safe</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-tag"></i></div>
                        <div class="feature-title">Best Price Guarantee</div>
                        <div class="feature-desc">We match any lower price you find online</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-clock-o"></i></div>
                        <div class="feature-title">Real-Time Updates</div>
                        <div class="feature-desc">Live flight status and instant notifications</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa fa-headphones"></i></div>
                        <div class="feature-title">24/7 Support</div>
                        <div class="feature-desc">Our team is always ready to help you</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php subview('footer.php'); ?>

<script>
// Trip type toggle
function setTripType(type) {
    document.getElementById('round-form').style.display = type === 'round' ? 'block' : 'none';
    document.getElementById('one-form-wrap').style.display = type === 'one' ? 'block' : 'none';
}

// Special fare chip toggle
document.querySelectorAll('.sf-chip').forEach(chip => {
    chip.addEventListener('click', function() {
        const bar = this.closest('.special-fares-bar');
        bar.querySelectorAll('.sf-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
    });
});

// Round trip passenger counter
const rMinus = document.getElementById('r-minus');
const rPlus  = document.getElementById('r-plus');
const rCount = document.getElementById('r-count');
const rVal   = document.getElementById('r-pax-val');

rMinus.addEventListener('click', () => { let v = parseInt(rVal.value); if(v > 1) { v--; rVal.value = v; rCount.innerText = v; }});
rPlus.addEventListener('click',  () => { let v = parseInt(rVal.value); if(v < 9) { v++; rVal.value = v; rCount.innerText = v; }});

// One-way passenger counter
document.querySelectorAll('.ow-minus').forEach(btn => {
    btn.addEventListener('click', function() {
        const wrap = this.closest('.pax-group');
        const inp = wrap.querySelector('.ow-pax-val');
        const disp = wrap.querySelector('.ow-count');
        let v = parseInt(inp.value);
        if(v > 1) { v--; inp.value = v; disp.innerText = v; }
    });
});
document.querySelectorAll('.ow-plus').forEach(btn => {
    btn.addEventListener('click', function() {
        const wrap = this.closest('.pax-group');
        const inp = wrap.querySelector('.ow-pax-val');
        const disp = wrap.querySelector('.ow-count');
        let v = parseInt(inp.value);
        if(v < 9) { v++; inp.value = v; disp.innerText = v; }
    });
});

// Swap cities
document.querySelectorAll('.swap-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const form = this.closest('form') || this.closest('#round-form');
        if (!form) return;
        const dep = form.querySelector('[name="dep_city"]');
        const arr = form.querySelector('[name="arr_city"]');
        if (dep && arr) {
            const tmp = dep.value;
            dep.value = arr.value;
            arr.value = tmp;
        }
    });
});

// Count-up animation
function animateCount(el) {
    const target = parseInt(el.getAttribute('data-target'));
    const duration = 1800;
    const start = performance.now();
    function update(now) {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = Math.floor(eased * target);
        el.textContent = target >= 1000 ? (current >= 1000000 ? (current/1000000).toFixed(1)+'M+' : current >= 1000 ? Math.floor(current/1000)+'K+' : current+'+') : current+'+';
        if (progress < 1) requestAnimationFrame(update);
    }
    requestAnimationFrame(update);
}

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateCount(entry.target);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('.stat-num[data-target]').forEach(el => observer.observe(el));
</script>
