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
    .main-col {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 2rem;
        padding: 3rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    .pass-form {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.5rem;
        padding: 2.5rem;
        margin-top: 2rem;
        transition: all 0.3s ease;
    }
    .pass-form:hover {
        border-color: rgba(59, 130, 246, 0.5);
        background: rgba(255, 255, 255, 0.05);
    }
    .pass-badge {
        background: var(--secondary-color);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
    }
</style>

<?php
if(isset($_GET['error'])) {
    $msg = '';
    if($_GET['error'] === 'invdate') $msg = "Invalid date of birth provided.";
    else if($_GET['error'] === 'moblen') $msg = "Invalid contact number format.";
    else if($_GET['error'] === 'sqlerror') $msg = "Database connection error.";
    
    if($msg) {
        echo '<div class="container mt-4"><div class="alert alert-danger border-0 small" style="background: rgba(220, 38, 38, 0.1); color: #f87171;">
                <i class="fa fa-exclamation-circle mr-2"></i> '.$msg.'
              </div></div>';
    }
}
?>

<?php if(isset($_SESSION['userId']) && isset($_POST['book_but'])) {   
    $flight_id = $_POST['flight_id'];
    $passengers = $_POST['passengers']; 
    $price = $_POST['price'];
    $class = $_POST['class'];
    $type = $_POST['type'];
    $ret_date = isset($_POST['ret_date']) ? $_POST['ret_date'] : ''; 
?>    
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="main-col animate-fade-in">
                    <div class="text-center mb-5">
                        <h2 class="font-weight-900 text-white mb-2">Traveler Details</h2>
                        <p class="text-secondary">Please enter the details exactly as they appear on your government-issued ID.</p>
                    </div>

                    <form action="includes/pass_detail.inc.php" method="POST">
                        <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">   
                        <input type="hidden" name="ret_date" value="<?php echo htmlspecialchars($ret_date); ?>">   
                        <input type="hidden" name="class" value="<?php echo htmlspecialchars($class); ?>">   
                        <input type="hidden" name="passengers" value="<?php echo htmlspecialchars($passengers); ?>">   
                        <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">   
                        <input type="hidden" name="flight_id" value="<?php echo htmlspecialchars($flight_id); ?>">   

                        <?php for($i=1; $i<=$passengers; $i++) { ?>
                            <div class="pass-form">
                                <div class="pass-badge">
                                    <i class="fa fa-user mr-2"></i> Passenger <?php echo $i; ?>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 form-group mb-4">
                                        <label class="text-secondary small font-weight-bold">FIRST NAME</label>
                                        <input type="text" name="firstname[]" class="custom-input" placeholder="e.g. John" required>
                                    </div>
                                    <div class="col-md-4 form-group mb-4">
                                        <label class="text-secondary small font-weight-bold">MIDDLE NAME</label>
                                        <input type="text" name="midname[]" class="custom-input" placeholder="e.g. Edward" required>
                                    </div>
                                    <div class="col-md-4 form-group mb-4">
                                        <label class="text-secondary small font-weight-bold">LAST NAME</label>
                                        <input type="text" name="lastname[]" class="custom-input" placeholder="e.g. Doe" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 form-group mb-4">
                                        <label class="text-secondary small font-weight-bold">CONTACT NUMBER</label>
                                        <div class="position-relative">
                                            <i class="fa fa-phone position-absolute" style="left: 1rem; top: 1rem; color: var(--text-secondary);"></i>
                                            <input type="number" name="mobile[]" class="custom-input" placeholder="Your phone number" style="padding-left: 3rem;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group mb-4">
                                        <label class="text-secondary small font-weight-bold">DATE OF BIRTH</label>
                                        <input type="date" name="date[]" class="custom-input" required>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="text-right mt-5">
                            <button name="pass_but" type="submit" class="btn btn-premium btn-lg px-5">
                                Continue to Payment <i class="fa fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php } else {
    // Basic protection if accessed directly
    header("Location: index.php");
    exit();
} ?>

<?php subview('footer.php'); ?>
