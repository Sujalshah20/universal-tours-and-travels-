<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>

<?php
if(isset($_GET['error'])) {
    $msg = '';
    if($_GET['error'] === 'invdate') $msg = 'Invalid date of birth provided.';
    elseif($_GET['error'] === 'moblen') $msg = 'Invalid contact number (10 digits required).';
    elseif($_GET['error'] === 'sqlerror') $msg = 'Database error. Please try again.';
}
?>

<?php if(isset($_SESSION['userId']) && isset($_POST['book_but'])) {   
    $flight_id  = $_POST['flight_id'];
    $passengers = $_POST['passengers']; 
    $price      = $_POST['price'];
    $class      = $_POST['class'];
    $type       = $_POST['type'];
    $ret_date   = isset($_POST['ret_date']) ? $_POST['ret_date'] : ''; 
?>

<style>
body { background: #f5f5f5; }
.page-header { background: linear-gradient(90deg, #05012d 0%, #07263d 100%); padding: 28px 0; }
.page-header h2 { color: #fff; font-size: 20px; font-weight: 900; margin-bottom: 4px; }
.page-header p { color: rgba(255,255,255,0.65); font-size: 13px; margin: 0; }

.pass-wrap { padding: 32px 0 50px; }

.pass-main-card {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    overflow: hidden;
}
.pass-main-header {
    background: linear-gradient(90deg, #05012d 0%, #07263d 100%);
    padding: 18px 28px;
    display: flex; align-items: center; gap: 12px;
}
.pass-main-header i { font-size: 20px; color: #53b2fe; }
.pass-main-header h3 { color: #fff; font-size: 16px; font-weight: 700; margin: 0; }
.pass-main-header p { color: rgba(255,255,255,0.6); font-size: 12px; margin: 0; }
.pass-main-body { padding: 28px; }

/* Passenger block */
.pax-block {
    border: 1.5px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 20px;
    transition: border-color 0.25s;
}
.pax-block:hover { border-color: #008cff; }
.pax-block-header {
    background: #eaf5ff;
    padding: 12px 20px;
    display: flex; align-items: center; gap: 10px;
}
.pax-num-badge {
    width: 28px; height: 28px;
    background: #008cff; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 900; color: #fff; flex-shrink: 0;
}
.pax-title { font-size: 13px; font-weight: 700; color: #333; }
.pax-block-body { padding: 20px; }

/* Form fields */
.f-field { margin-bottom: 16px; }
.f-label { display: block; font-size: 11px; font-weight: 700; color: #9b9b9b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
.f-input {
    width: 100%;
    border: 1.5px solid #e0e0e0;
    border-radius: 4px;
    padding: 11px 14px;
    font-size: 14px;
    font-family: 'Lato', sans-serif;
    font-weight: 700;
    color: #333;
    background: #fff;
    outline: none;
    transition: all 0.25s;
}
.f-input:focus { border-color: #008cff; box-shadow: 0 0 0 3px rgba(0,140,255,0.1); }
.f-input::placeholder { color: #c0c0c0; font-weight: 400; }

/* Error bar */
.error-bar { background: #fff5f5; border: 1px solid #fecaca; border-left: 4px solid #ef4444; border-radius: 4px; padding: 12px 16px; color: #dc2626; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }

/* Continue button */
.btn-continue {
    background: linear-gradient(93deg, #53b2fe, #065af3);
    border: none; border-radius: 50px;
    color: #fff; font-size: 15px; font-weight: 900;
    font-family: 'Lato', sans-serif;
    padding: 14px 50px;
    cursor: pointer; transition: all 0.25s; letter-spacing: 0.5px; text-transform: uppercase;
    box-shadow: 0 4px 16px rgba(6,90,243,0.3);
}
.btn-continue:hover { background: linear-gradient(93deg, #065af3, #053ab5); box-shadow: 0 6px 24px rgba(6,90,243,0.4); transform: translateY(-2px); }
</style>

<div class="page-header">
    <div class="container">
        <h2><i class="fa fa-users mr-2" style="color:#53b2fe;"></i> Traveller Details</h2>
        <p>Enter details exactly as on your government-issued ID</p>
    </div>
</div>

<div class="pass-wrap">
    <div class="container">
        <?php if(isset($msg) && $msg): ?>
            <div class="error-bar mb-3"><i class="fa fa-exclamation-circle"></i><?php echo $msg; ?></div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="pass-main-card animate-in">
                    <div class="pass-main-header">
                        <i class="fa fa-users"></i>
                        <div>
                            <h3>Passenger Information</h3>
                            <p><?php echo $passengers; ?> Traveller(s) &nbsp;|&nbsp; <?php echo $class == 'B' ? 'Business' : 'Economy'; ?> Class</p>
                        </div>
                    </div>
                    <div class="pass-main-body">
                        <form action="includes/pass_detail.inc.php" method="POST">
                            <input type="hidden" name="type"       value="<?php echo htmlspecialchars($type); ?>">   
                            <input type="hidden" name="ret_date"   value="<?php echo htmlspecialchars($ret_date); ?>">   
                            <input type="hidden" name="class"      value="<?php echo htmlspecialchars($class); ?>">   
                            <input type="hidden" name="passengers" value="<?php echo htmlspecialchars($passengers); ?>">   
                            <input type="hidden" name="price"      value="<?php echo htmlspecialchars($price); ?>">   
                            <input type="hidden" name="flight_id"  value="<?php echo htmlspecialchars($flight_id); ?>">   

                            <?php for($i = 1; $i <= $passengers; $i++) { ?>
                            <div class="pax-block">
                                <div class="pax-block-header">
                                    <div class="pax-num-badge"><?php echo $i; ?></div>
                                    <div class="pax-title">Passenger <?php echo $i; ?></div>
                                </div>
                                <div class="pax-block-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="f-field">
                                                <label class="f-label">First Name</label>
                                                <input type="text" name="firstname[]" class="f-input" placeholder="e.g. John" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="f-field">
                                                <label class="f-label">Middle Name</label>
                                                <input type="text" name="midname[]" class="f-input" placeholder="e.g. Edward" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="f-field">
                                                <label class="f-label">Last Name</label>
                                                <input type="text" name="lastname[]" class="f-input" placeholder="e.g. Doe" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="f-field">
                                                <label class="f-label"><i class="fa fa-phone mr-1"></i> Contact Number</label>
                                                <input type="number" name="mobile[]" class="f-input" placeholder="10-digit mobile number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="f-field">
                                                <label class="f-label"><i class="fa fa-calendar mr-1"></i> Date of Birth</label>
                                                <input type="date" name="date[]" class="f-input" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="text-center mt-4">
                                <button name="pass_but" type="submit" class="btn-continue">
                                    Continue to Payment <i class="fa fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } else { header("Location: index.php"); exit(); } ?>
<?php subview('footer.php'); ?>
