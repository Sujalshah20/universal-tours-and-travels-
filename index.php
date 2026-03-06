<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); 
require 'helpers/init_conn_db.php';                      
?> 

<style>
    .hero-section {
        background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('assets/images/hero-bg.png');
        background-size: cover;
        background-position: center;
        padding: 12rem 0 10rem;
        margin-top: -80px;
    }

    .search-card {
        margin-top: -100px;
        position: relative;
        z-index: 10;
        border-radius: 2rem;
        padding: 2.5rem;
    }

    .nav-pills .nav-link {
        color: var(--text-secondary);
        border-radius: 1rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        margin-right: 0.5rem;
    }

    .nav-pills .nav-link.active {
        background: var(--secondary-color);
        color: #fff;
    }

    .city-select {
        cursor: pointer;
    }

    .passenger-counter {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: rgba(255, 255, 255, 0.05);
        padding: 0.5rem;
        border-radius: 0.75rem;
        border: 1px solid var(--glass-border);
    }

    .counter-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid var(--glass-border);
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .counter-btn:hover {
        background: var(--secondary-color);
    }
</style>

<main>
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="hero-title animate-fade-in">Experience the World in Premium Class</h1>
            <p class="hero-subtitle animate-fade-in" style="animation-delay: 0.2s;">
                Discover breathtaking destinations with exclusive deals and unparalleled comfort. Your journey begins here.
            </p>
        </div>
    </section>

    <section class="container mb-5">
        <div class="glass-panel search-card animate-fade-in" style="animation-delay: 0.4s;">
            <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-round-tab" data-toggle="pill" data-target="#pills-round" type="button" role="tab">Round Trip</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-one-tab" data-toggle="pill" data-target="#pills-one" type="button" role="tab">One Way</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <!-- Round Trip Form -->
                <div class="tab-pane fade show active" id="pills-round" role="tabpanel">
                    <form action="book_flight.php" method="post">
                        <input type="hidden" name="type" value="round">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label><i class="fa fa-map-marker mr-1"></i> From</label>
                                <select name="dep_city" class="custom-input h-100" required>
                                    <option value="" disabled selected>Departure City</option>
                                    <?php
                                    $sql = 'SELECT * FROM Cities ORDER BY city ASC';
                                    $res = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo '<option value="'.htmlspecialchars($row['city']).'">'.htmlspecialchars($row['city']).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label><i class="fa fa-plane mr-1"></i> To</label>
                                <select name="arr_city" class="custom-input h-100" required>
                                    <option value="" disabled selected>Arrival City</option>
                                    <?php
                                    mysqli_data_seek($res, 0);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo '<option value="'.htmlspecialchars($row['city']).'">'.htmlspecialchars($row['city']).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label><i class="fa fa-calendar mr-1"></i> Depart</label>
                                <input type="date" name="dep_date" class="custom-input" required>
                            </div>
                            <div class="col-md-2 form-group">
                                <label><i class="fa fa-calendar mr-1"></i> Return</label>
                                <input type="date" name="ret_date" class="custom-input" required>
                            </div>
                            <div class="col-md-2 form-group">
                                <label><i class="fa fa-star mr-1"></i> Class</label>
                                <select name="f_class" class="custom-input">
                                    <option value="E">Economy</option>
                                    <option value="B">Business</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4 align-items-center">
                            <div class="col-md-4">
                                <div class="passenger-counter">
                                    <span class="text-secondary small font-weight-bold ml-2">PASSENGERS:</span>
                                    <button type="button" class="counter-btn minus-btn"><i class="fa fa-minus"></i></button>
                                    <span class="p-count">1</span>
                                    <button type="button" class="counter-btn plus-btn"><i class="fa fa-plus"></i></button>
                                    <input type="hidden" name="passengers" class="p-input" value="1">
                                </div>
                            </div>
                            <div class="col-md-8 text-right">
                                <button type="submit" name="search_but" class="btn btn-premium btn-lg px-5">
                                    Search Flights <i class="fa fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- One Way Form -->
                <div class="tab-pane fade" id="pills-one" role="tabpanel">
                    <form action="book_flight.php" method="post">
                        <input type="hidden" name="type" value="one">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label><i class="fa fa-map-marker mr-1"></i> From</label>
                                <select name="dep_city" class="custom-input" required>
                                    <option value="" disabled selected>Departure City</option>
                                    <?php
                                    mysqli_data_seek($res, 0);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo '<option value="'.htmlspecialchars($row['city']).'">'.htmlspecialchars($row['city']).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label><i class="fa fa-plane mr-1"></i> To</label>
                                <select name="arr_city" class="custom-input" required>
                                    <option value="" disabled selected>Arrival City</option>
                                    <?php
                                    mysqli_data_seek($res, 0);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo '<option value="'.htmlspecialchars($row['city']).'">'.htmlspecialchars($row['city']).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label><i class="fa fa-calendar mr-1"></i> Depart</label>
                                <input type="date" name="dep_date" class="custom-input" required>
                            </div>
                            <div class="col-md-2 form-group">
                                <label><i class="fa fa-star mr-1"></i> Class</label>
                                <select name="f_class" class="custom-input">
                                    <option value="E">Economy</option>
                                    <option value="B">Business</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4 align-items-center">
                            <div class="col-md-4">
                                <div class="passenger-counter">
                                    <span class="text-secondary small font-weight-bold ml-2">PASSENGERS:</span>
                                    <button type="button" class="counter-btn minus-btn"><i class="fa fa-minus"></i></button>
                                    <span class="p-count">1</span>
                                    <button type="button" class="counter-btn plus-btn"><i class="fa fa-plus"></i></button>
                                    <input type="hidden" name="passengers" class="p-input" value="1">
                                </div>
                            </div>
                            <div class="col-md-8 text-right">
                                <button type="submit" name="search_but" class="btn btn-premium btn-lg px-5">
                                    Search Flights <i class="fa fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="container py-5 mt-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="glass-panel p-4 h-100 rounded-pill-lg" style="border-radius: 2rem;">
                    <i class="fa fa-shield fa-3x text-primary mb-3"></i>
                    <h4 class="font-weight-bold">Secure Booking</h4>
                    <p class="text-secondary">Your data and transactions are protected with industry-leading encryption.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="glass-panel p-4 h-100" style="border-radius: 2rem;">
                    <i class="fa fa-clock-o fa-3x text-primary mb-3"></i>
                    <h4 class="font-weight-bold">Live Updates</h4>
                    <p class="text-secondary">Get real-time flight status and notifications for your journey.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="glass-panel p-4 h-100" style="border-radius: 2rem;">
                    <i class="fa fa-life-ring fa-3x text-primary mb-3"></i>
                    <h4 class="font-weight-bold">Best Support</h4>
                    <p class="text-secondary">Our dedicated team is available 24/7 to assist with your travel needs.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php subview('footer.php'); ?>

<script>
    document.querySelectorAll('.passenger-counter').forEach(counter => {
        const minusBtn = counter.querySelector('.minus-btn');
        const plusBtn = counter.querySelector('.plus-btn');
        const countDisplay = counter.querySelector('.p-count');
        const input = counter.querySelector('.p-input');

        minusBtn.addEventListener('click', () => {
            let val = parseInt(input.value);
            if (val > 1) {
                val--;
                input.value = val;
                countDisplay.innerText = val;
            }
        });

        plusBtn.addEventListener('click', () => {
            let val = parseInt(input.value);
            if (val < 10) {
                val++;
                input.value = val;
                countDisplay.innerText = val;
            }
        });
    });
</script>
