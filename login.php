<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>

<style>
body { background: #f5f5f5; margin: 0; }
.auth-wrapper {
    display: flex;
    min-height: calc(100vh - 90px);
}
/* Left panel */
.auth-left {
    background: linear-gradient(160deg, #05012d 0%, #065af3 100%);
    width: 42%;
    min-height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 50px;
    color: #fff;
    position: relative;
    overflow: hidden;
}
.auth-left::before {
    content: '';
    position: absolute;
    top: -100px; right: -80px;
    width: 350px; height: 350px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
}
.auth-left::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -60px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(83,178,254,0.15) 0%, transparent 70%);
}
.auth-left-content { position: relative; z-index: 2; }
.auth-brand { font-size: 28px; font-weight: 900; color: #fff; margin-bottom: 8px; font-family: 'Lato', sans-serif; }
.auth-brand span { color: #53b2fe; }
.auth-tagline { font-size: 13px; color: rgba(255,255,255,0.7); margin-bottom: 40px; }
.auth-perk { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 22px; }
.auth-perk-icon {
    width: 40px; height: 40px; background: rgba(255,255,255,0.12);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 16px; color: #53b2fe; flex-shrink: 0;
}
.auth-perk-text h5 { font-size: 14px; font-weight: 700; color: #fff; margin-bottom: 2px; }
.auth-perk-text p { font-size: 12px; color: rgba(255,255,255,0.65); margin: 0; }

/* Right panel */
.auth-right {
    flex: 1;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 50px;
}
.auth-form-wrap { width: 100%; max-width: 420px; }
.auth-form-wrap h3 { font-size: 22px; font-weight: 900; color: #333; margin-bottom: 4px; }
.auth-form-wrap .sub { font-size: 13px; color: #9b9b9b; margin-bottom: 28px; }

/* Form inputs */
.form-field { margin-bottom: 20px; position: relative; }
.form-field label { display: block; font-size: 11px; font-weight: 700; color: #9b9b9b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
.form-field input {
    width: 100%;
    border: 1.5px solid #e0e0e0;
    border-radius: 4px;
    padding: 12px 40px 12px 14px;
    font-size: 14px;
    font-family: 'Lato', sans-serif;
    font-weight: 700;
    color: #333;
    background: #fff;
    outline: none;
    transition: all 0.25s;
}
.form-field input:focus { border-color: #008cff; box-shadow: 0 0 0 3px rgba(0,140,255,0.1); }
.form-field input::placeholder { color: #c0c0c0; font-weight: 400; }
.form-field .field-icon { position: absolute; right: 14px; bottom: 13px; color: #c0c0c0; font-size: 14px; }

.error-bar { background: #fff5f5; border: 1px solid #fecaca; border-left: 4px solid #ef4444; border-radius: 4px; padding: 12px 16px; color: #dc2626; font-size: 13px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }

.btn-submit {
    width: 100%;
    background: linear-gradient(93deg, #53b2fe, #065af3);
    border: none;
    border-radius: 50px;
    color: #fff;
    font-size: 15px;
    font-weight: 900;
    font-family: 'Lato', sans-serif;
    padding: 14px 0;
    cursor: pointer;
    transition: all 0.25s;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    box-shadow: 0 4px 16px rgba(6,90,243,0.3);
    margin-top: 8px;
}
.btn-submit:hover {
    background: linear-gradient(93deg, #065af3, #053ab5);
    box-shadow: 0 6px 24px rgba(6,90,243,0.4);
    transform: translateY(-2px);
}

.forgot-link { font-size: 12px; color: #008cff; font-weight: 700; float: right; }
.register-link { text-align: center; margin-top: 28px; font-size: 13px; color: #9b9b9b; }
.register-link a { color: #008cff; font-weight: 700; }

@media (max-width: 768px) {
    .auth-left { display: none; }
    .auth-right { padding: 40px 24px; }
}
</style>

<div class="auth-wrapper">
    <!-- Left Panel -->
    <div class="auth-left">
        <div class="auth-left-content">
            <div class="auth-brand"><span>make</span>my<span>trip</span></div>
            <p class="auth-tagline">India's #1 Travel Booking Platform</p>
            <div class="auth-perk">
                <div class="auth-perk-icon"><i class="fa fa-tag"></i></div>
                <div class="auth-perk-text">
                    <h5>Exclusive Member Deals</h5>
                    <p>Get up to 40% off on flights & hotels</p>
                </div>
            </div>
            <div class="auth-perk">
                <div class="auth-perk-icon"><i class="fa fa-clock-o"></i></div>
                <div class="auth-perk-text">
                    <h5>Instant Confirmation</h5>
                    <p>Tickets confirmed in under 60 seconds</p>
                </div>
            </div>
            <div class="auth-perk">
                <div class="auth-perk-icon"><i class="fa fa-shield"></i></div>
                <div class="auth-perk-text">
                    <h5>Secure & Safe</h5>
                    <p>Bank-level encryption for all payments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="auth-right">
        <div class="auth-form-wrap">
            <h3>Welcome Back!</h3>
            <p class="sub">Login to access your trips and exclusive deals</p>

            <?php
            if(isset($_GET['error'])) {
                $msg = '';
                if($_GET['error'] === 'invalidcred') $msg = 'Invalid username or email';
                else if($_GET['error'] === 'wrongpwd')  $msg = 'Incorrect password. Please try again.';
                else if($_GET['error'] === 'sqlerror')  $msg = 'Database error. Please try again.';
                if($msg) echo '<div class="error-bar"><i class="fa fa-exclamation-circle"></i>'.$msg.'</div>';
            }
            ?>

            <form action="includes/login.inc.php" method="POST">
                <div class="form-field">
                    <label>Username or Email</label>
                    <input type="text" name="user_id" placeholder="Enter your username or email" required autocomplete="username">
                    <span class="field-icon"><i class="fa fa-envelope"></i></span>
                </div>
                <div class="form-field">
                    <label>
                        Password
                        <a href="reset-pwd.php" class="forgot-link">Forgot password?</a>
                    </label>
                    <input type="password" name="user_pass" placeholder="Enter your password" required autocomplete="current-password">
                    <span class="field-icon"><i class="fa fa-lock"></i></span>
                </div>
                <button type="submit" name="login_but" class="btn-submit">Login to Account</button>
            </form>

            <div class="register-link">
                New to Skyline? <a href="register.php">Create a free account</a>
            </div>
        </div>
    </div>
</div>

<?php subview('footer.php'); ?>