<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>

<?php if(isset($_SESSION['userId'])) { ?>

<style>
body { background: #f5f5f5; }
.page-header { background: linear-gradient(90deg, #05012d 0%, #07263d 100%); padding: 28px 0; }
.page-header h2 { color: #fff; font-size: 20px; font-weight: 900; margin-bottom: 4px; }
.page-header p { color: rgba(255,255,255,0.65); font-size: 13px; margin: 0; }

.payment-wrap { padding: 32px 0 50px; }

.payment-card {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
}
.payment-card-header {
    background: linear-gradient(90deg, #05012d 0%, #07263d 100%);
    padding: 18px 28px;
    border-radius: 8px 8px 0 0;
    display: flex;
    align-items: center;
    gap: 12px;
}
.payment-card-header i { font-size: 20px; color: #53b2fe; }
.payment-card-header h3 { color: #fff; font-size: 16px; font-weight: 700; margin: 0; }
.payment-card-header p { color: rgba(255,255,255,0.6); font-size: 12px; margin: 0; }
.payment-card-body { padding: 28px; }

/* Card brand icons */
.card-brands { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #e0e0e0; }
.card-brands i { font-size: 32px; color: #4a4a4a; opacity: 0.7; transition: opacity 0.2s; }
.card-brands i:hover { opacity: 1; }

/* Form fields */
.pay-field { margin-bottom: 20px; }
.pay-label { display: block; font-size: 11px; font-weight: 700; color: #9b9b9b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
.pay-input {
    width: 100%;
    border: 1.5px solid #e0e0e0;
    border-radius: 4px;
    padding: 13px 16px;
    font-size: 16px;
    font-family: 'Lato', sans-serif;
    font-weight: 700;
    color: #333;
    background: #fff;
    outline: none;
    transition: all 0.25s;
    letter-spacing: 1px;
}
.pay-input:focus { border-color: #008cff; box-shadow: 0 0 0 3px rgba(0,140,255,0.1); }
.pay-input::placeholder { color: #c0c0c0; font-weight: 400; letter-spacing: 0; }

/* Animated card preview */
.card-preview {
    background: linear-gradient(135deg, #05012d 0%, #065af3 70%, #53b2fe 100%);
    border-radius: 12px;
    padding: 24px;
    color: #fff;
    position: relative;
    overflow: hidden;
    height: 180px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 8px 30px rgba(6,90,243,0.35);
    margin-bottom: 24px;
}
.card-preview::before {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%);
    border-radius: 50%;
}
.card-preview::after {
    content: '';
    position: absolute;
    bottom: -40px; left: 20px;
    width: 140px; height: 140px;
    background: radial-gradient(circle, rgba(255,255,255,0.06), transparent 70%);
    border-radius: 50%;
}
.card-chip {
    width: 40px; height: 28px;
    background: rgba(255,220,100,0.85);
    border-radius: 4px;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; color: #996600; font-weight: 700;
}
.card-number-display { font-size: 18px; font-weight: 700; letter-spacing: 3px; font-family: 'Courier New', monospace; position: relative; z-index: 2; }
.card-info-row { display: flex; justify-content: space-between; align-items: flex-end; position: relative; z-index: 2; }
.card-label-sm { font-size: 9px; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.5px; }
.card-value-sm { font-size: 13px; font-weight: 700; }

/* Error bar */
.error-bar { background: #fff5f5; border: 1px solid #fecaca; border-left: 4px solid #ef4444; border-radius: 4px; padding: 12px 16px; color: #dc2626; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }

/* Submit */
.btn-pay {
    width: 100%;
    background: linear-gradient(93deg, #53b2fe, #065af3);
    border: none; border-radius: 50px;
    color: #fff; font-size: 16px; font-weight: 900;
    font-family: 'Lato', sans-serif;
    padding: 15px 0; cursor: pointer;
    transition: all 0.25s; letter-spacing: 0.5px;
    text-transform: uppercase;
    box-shadow: 0 4px 20px rgba(6,90,243,0.35);
}
.btn-pay:hover { background: linear-gradient(93deg, #065af3, #053ab5); transform: translateY(-2px); box-shadow: 0 6px 28px rgba(6,90,243,0.45); }

/* Security badge */
.security-note { display: flex; align-items: center; gap: 8px; justify-content: center; margin-top: 14px; font-size: 12px; color: #9b9b9b; font-weight: 700; }
.security-note i { color: #52a755; }
</style>

<div class="page-header">
    <div class="container">
        <h2><i class="fa fa-lock mr-2" style="color:#53b2fe;"></i> Secure Checkout</h2>
        <p>Your payment is protected with 256-bit SSL encryption</p>
    </div>
</div>

<div class="payment-wrap">
    <div class="container">
        <?php
        if(isset($_GET['error'])) {
            $msg = '';
            if($_GET['error'] === 'sqlerror') $msg = 'Database error. Please try again.';
            elseif($_GET['error'] === 'noret') $msg = 'No return flight available for selected route.';
            elseif($_GET['error'] === 'mailerr') $msg = 'Booking confirmed, but email notification failed.';
            if($msg) echo '<div class="container mb-3"><div class="error-bar"><i class="fa fa-exclamation-circle"></i>'.$msg.'</div></div>';
        }
        ?>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="payment-card">
                    <div class="payment-card-header">
                        <i class="fa fa-credit-card"></i>
                        <div>
                            <h3>Pay with Card</h3>
                            <p>Safe, fast, and secure payment</p>
                        </div>
                    </div>
                    <div class="payment-card-body">
                        <!-- Card preview -->
                        <div class="card-preview">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="card-chip">CHIP</div>
                                <i class="fa fa-wifi" style="font-size:18px; transform:rotate(90deg); opacity:0.7;"></i>
                            </div>
                            <div class="card-number-display" id="card-display">•••• •••• •••• ••••</div>
                            <div class="card-info-row">
                                <div>
                                    <div class="card-label-sm">Card Holder</div>
                                    <div class="card-value-sm"><?php echo htmlspecialchars(strtoupper($_SESSION['userUid'])); ?></div>
                                </div>
                                <div>
                                    <div class="card-label-sm">Expires</div>
                                    <div class="card-value-sm" id="exp-display">MM/YY</div>
                                </div>
                                <div>
                                    <i class="fa fa-cc-visa" style="font-size:28px; opacity:0.8;" id="card-brand-icon"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Card brand icons -->
                        <div class="card-brands">
                            <i class="fa fa-cc-visa"></i>
                            <i class="fa fa-cc-mastercard"></i>
                            <i class="fa fa-cc-amex"></i>
                            <i class="fa fa-cc-discover"></i>
                        </div>

                        <form action="includes/payment.inc.php" method="post" id="payment-form">
                            <div class="pay-field">
                                <label class="pay-label">Card Number</label>
                                <input id="cc-number" name="cc-number" type="tel" class="pay-input"
                                    placeholder="0000 0000 0000 0000" required autocomplete="cc-number" maxlength="19">
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="pay-field">
                                        <label class="pay-label">Expiry Date</label>
                                        <input id="cc-exp" name="cc-exp" type="tel" class="pay-input"
                                            placeholder="MM / YY" required maxlength="5" autocomplete="cc-exp">
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="pay-field">
                                        <label class="pay-label">CVV</label>
                                        <input id="x_card_code" name="x_card_code" type="password" class="pay-input"
                                            placeholder="•••" required maxlength="4" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <button id="payment-button" type="submit" name="pay_but" class="btn-pay">
                                <i class="fa fa-lock mr-2"></i> Confirm Payment
                            </button>
                        </form>

                        <div class="security-note">
                            <i class="fa fa-lock"></i> 100% Secure Payment &nbsp;|&nbsp; <i class="fa fa-shield"></i> SSL Encrypted
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php subview('footer.php'); ?>
<script>
$(document).ready(function() {
    // Format card number with spaces
    $('#cc-number').on('input', function() {
        let v = $(this).val().replace(/\D/g, '').substring(0, 16);
        let formatted = v.replace(/(.{4})/g, '$1 ').trim();
        $(this).val(formatted);
        let display = v.padEnd(16, '•').replace(/(.{4})/g, '$1 ').trim();
        $('#card-display').text(display);
        // Auto-detect card brand
        if(v.startsWith('4')) $('#card-brand-icon').attr('class', 'fa fa-cc-visa').css({fontSize:'28px', opacity:'0.8'});
        else if(v.startsWith('5'))  $('#card-brand-icon').attr('class', 'fa fa-cc-mastercard').css({fontSize:'28px', opacity:'0.8'});
        else if(v.startsWith('3'))  $('#card-brand-icon').attr('class', 'fa fa-cc-amex').css({fontSize:'28px', opacity:'0.8'});
        else $('#card-brand-icon').attr('class', 'fa fa-credit-card').css({fontSize:'28px', opacity:'0.8'});
    });

    // Format expiry
    $('#cc-exp').on('input', function() {
        let v = $(this).val().replace(/\D/g, '').substring(0, 4);
        if(v.length >= 2) v = v.substring(0, 2) + '/' + v.substring(2);
        $(this).val(v);
        $('#exp-display').text(v || 'MM/YY');
    });

    // Validate on submit
    $('#payment-form').submit(function(e) {
        let card = $('#cc-number').val().replace(/\s/g, '');
        let cvv  = $('#x_card_code').val();
        let exp  = $('#cc-exp').val();
        if(card.length < 12 || card.length > 16) { alert('Please enter a valid card number.'); e.preventDefault(); return; }
        if(cvv.length < 3 || cvv.length > 4) { alert('Please enter a valid CVV.'); e.preventDefault(); return; }
        if(!exp.includes('/')) { alert('Please format expiry as MM/YY.'); e.preventDefault(); return; }
        $('#payment-button').text('Processing...').prop('disabled', true);
    });
});
</script>
<?php } else { header("Location: index.php"); exit(); } ?>