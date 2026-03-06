<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<link rel="stylesheet" href="assets/css/form.css">

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
    .payment-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 2rem;
        padding: 3rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    .accepted-cards i {
        font-size: 2.5rem;
        margin-right: 1rem;
        opacity: 0.8;
        transition: var(--transition);
    }
    .accepted-cards i:hover {
        opacity: 1;
        transform: scale(1.1);
    }
    /* Simple input styles for payment to ensure stability */
    .payment-input {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 1rem !important;
        color: white !important;
        padding: 1rem !important;
        font-size: 1.1rem;
        width: 100%;
        margin-bottom: 1.5rem;
    }
    .payment-input:focus {
        border-color: var(--secondary-color) !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
        outline: none;
    }
    .payment-label {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: inline-block;
    }
</style>

<?php if(isset($_SESSION['userId'])) {   ?> 
<main>
    <?php
    if(isset($_GET['error'])) {
        $msg = '';
        if($_GET['error'] === 'sqlerror') $msg = "Database connection error.";
        else if($_GET['error'] === 'noret') $msg = "No return flight available.";
        else if($_GET['error'] === 'mailerr') $msg = "Failed to send confirmation email.";
        
        if($msg) {
            echo '<div class="container mb-4"><div class="alert alert-danger border-0 small" style="background: rgba(220, 38, 38, 0.1); color: #f87171;">
                    <i class="fa fa-exclamation-circle mr-2"></i> '.$msg.'
                  </div></div>';
        }
    }
    ?>
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="payment-card animate-fade-in">
                    <div class="text-center mb-4">
                        <h2 class="font-weight-900 text-white mb-2">Secure Checkout</h2>
                        <p class="text-secondary small">Your payment is encrypted and secure</p>
                    </div>

                    <div class="accepted-cards text-center mb-4 pb-4 border-bottom border-secondary">
                        <i class="fa fa-cc-visa text-light"></i>
                        <i class="fa fa-cc-mastercard text-light"></i>
                        <i class="fa fa-cc-amex text-light"></i>
                        <i class="fa fa-cc-discover text-light"></i>
                    </div>

                    <form action="includes/payment.inc.php" method="post" id="payment-form">
                        <div class="form-group">
                            <label class="payment-label">CARD NUMBER</label>
                            <input id="cc-number" name="cc-number" type="tel" class="payment-input" placeholder="0000 0000 0000 0000" required autocomplete="off">
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="payment-label">EXPIRY DATE</label>
                                    <input id="cc-exp" name="cc-exp" type="tel" class="payment-input" required placeholder="MM/YY" autocomplete="cc-exp">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="payment-label">CVV CODE</label>
                                    <input id="x_card_code" name="x_card_code" type="password" class="payment-input" placeholder="•••" required autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button id="payment-button" type="submit" name="pay_but" class="btn btn-premium btn-block btn-lg py-3">
                                <i class="fa fa-lock mr-2"></i> Confirm Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php subview('footer.php'); ?> 
<script>
$(document).ready(function() {
    $("#payment-form").submit(function(e) {
        var cvv = $('#x_card_code').val();
        var CardNo = $('#cc-number').val().replace(/\s/g, ''); // Remove spaces
        var date = $('#cc-exp').val();
        
        if(CardNo.length < 12 || CardNo.length > 19) {
            alert("Please enter a valid card number.");
            e.preventDefault();
            return false;
        }
        
        if(cvv.length < 3 || cvv.length > 4) {
            alert("Please enter a valid CVV code.");
            e.preventDefault();
            return false;
        }

        if(!date.includes('/')) {
            alert("Please format expiry date as MM/YY.");
            e.preventDefault();
            return false;
        }
    });
});
</script>
<?php } else {
    header("Location: index.php");
    exit();
} ?>