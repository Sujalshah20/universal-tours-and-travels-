<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>

<style>
body { background: #f5f5f5; }
.auth-wrapper { display: flex; min-height: calc(100vh - 90px); }
.auth-left {
    background: linear-gradient(160deg, #05012d 0%, #065af3 100%);
    width: 42%; min-height: 100%;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    padding: 60px 50px; color: #fff; position: relative; overflow: hidden;
}
.auth-left::before {
    content:''; position:absolute; top:-100px; right:-80px;
    width:350px; height:350px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
}
.auth-left::after {
    content:''; position:absolute; bottom:-80px; left:-60px;
    width:280px; height:280px;
    background: radial-gradient(circle, rgba(83,178,254,0.15) 0%, transparent 70%);
}
.auth-left-content { position:relative; z-index:2; }
.auth-brand { font-size:28px; font-weight:900; color:#fff; margin-bottom:6px; font-family:'Lato',sans-serif; }
.auth-brand span { color:#53b2fe; }
.auth-tagline { font-size:13px; color:rgba(255,255,255,0.7); margin-bottom:36px; }
.auth-perk { display:flex; align-items:flex-start; gap:14px; margin-bottom:20px; }
.auth-perk-icon { width:40px; height:40px; background:rgba(255,255,255,0.12); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:16px; color:#53b2fe; flex-shrink:0; }
.auth-perk-text h5 { font-size:14px; font-weight:700; color:#fff; margin-bottom:2px; }
.auth-perk-text p { font-size:12px; color:rgba(255,255,255,0.65); margin:0; }

.auth-right { flex:1; background:#fff; display:flex; align-items:center; justify-content:center; padding:60px 50px; }
.auth-form-wrap { width:100%; max-width:500px; }
.auth-form-wrap h3 { font-size:22px; font-weight:900; color:#333; margin-bottom:4px; }
.auth-form-wrap .sub { font-size:13px; color:#9b9b9b; margin-bottom:28px; }

.form-field { margin-bottom:18px; position:relative; }
.form-field label { display:block; font-size:11px; font-weight:700; color:#9b9b9b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; }
.form-field input {
    width:100%; border:1.5px solid #e0e0e0; border-radius:4px;
    padding:12px 40px 12px 14px; font-size:14px;
    font-family:'Lato',sans-serif; font-weight:700; color:#333; background:#fff;
    outline:none; transition:all 0.25s;
}
.form-field input:focus { border-color:#008cff; box-shadow:0 0 0 3px rgba(0,140,255,0.1); }
.form-field input::placeholder { color:#c0c0c0; font-weight:400; }
.form-field .field-icon { position:absolute; right:14px; bottom:13px; color:#c0c0c0; font-size:14px; }

.error-bar { background:#fff5f5; border:1px solid #fecaca; border-left:4px solid #ef4444; border-radius:4px; padding:12px 16px; color:#dc2626; font-size:13px; font-weight:700; margin-bottom:20px; display:flex; align-items:center; gap:8px; }

.btn-submit {
    width:100%; background:linear-gradient(93deg, #53b2fe, #065af3);
    border:none; border-radius:50px; color:#fff;
    font-size:15px; font-weight:900; font-family:'Lato',sans-serif;
    padding:14px 0; cursor:pointer; transition:all 0.25s;
    letter-spacing:0.5px; text-transform:uppercase; box-shadow:0 4px 16px rgba(6,90,243,0.3); margin-top:8px;
}
.btn-submit:hover { background:linear-gradient(93deg, #065af3, #053ab5); box-shadow:0 6px 24px rgba(6,90,243,0.4); transform:translateY(-2px); }

.terms-check { display:flex; align-items:flex-start; gap:10px; margin-top:16px; }
.terms-check input[type="checkbox"] { margin-top:2px; accent-color:#008cff; flex-shrink:0; }
.terms-check label { font-size:12px; color:#9b9b9b; line-height:1.5; cursor:pointer; }
.terms-check a { color:#008cff; font-weight:700; }

.login-link { text-align:center; margin-top:24px; font-size:13px; color:#9b9b9b; }
.login-link a { color:#008cff; font-weight:700; }

@media(max-width:768px) { .auth-left { display:none; } .auth-right { padding:40px 24px; } }
</style>

<div class="auth-wrapper">
    <div class="auth-left">
        <div class="auth-left-content">
            <div class="auth-brand"><span>make</span>my<span>trip</span></div>
            <p class="auth-tagline">Join millions of happy travellers</p>
            <div class="auth-perk">
                <div class="auth-perk-icon"><i class="fa fa-bolt"></i></div>
                <div class="auth-perk-text">
                    <h5>Instant Booking</h5>
                    <p>Get confirmed tickets in seconds</p>
                </div>
            </div>
            <div class="auth-perk">
                <div class="auth-perk-icon"><i class="fa fa-gift"></i></div>
                <div class="auth-perk-text">
                    <h5>Welcome Offer</h5>
                    <p>₹500 off on your first booking</p>
                </div>
            </div>
            <div class="auth-perk">
                <div class="auth-perk-icon"><i class="fa fa-plane"></i></div>
                <div class="auth-perk-text">
                    <h5>Track All Trips</h5>
                    <p>Manage all your bookings in one place</p>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-form-wrap">
            <h3>Create Your Account</h3>
            <p class="sub">Start your journey today — it's free!</p>

            <?php
            if(isset($_GET['error'])) {
                $msg = '';
                if($_GET['error'] === 'invalidemail')    $msg = 'Invalid email address.';
                elseif($_GET['error'] === 'pwdnotmatch') $msg = 'Passwords do not match.';
                elseif($_GET['error'] === 'sqlerror')    $msg = 'Database error. Please try again.';
                elseif($_GET['error'] === 'usernameexists') $msg = 'Username already taken.';
                elseif($_GET['error'] === 'emailexists')    $msg = 'Email already registered.';
                if($msg) echo '<div class="error-bar"><i class="fa fa-exclamation-circle"></i>'.$msg.'</div>';
            }
            ?>

            <form action="includes/register.inc.php" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-field">
                            <label>Username</label>
                            <input type="text" name="username" placeholder="e.g. traveller_01" required autocomplete="username">
                            <span class="field-icon"><i class="fa fa-user"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-field">
                            <label>Email Address</label>
                            <input type="email" name="email_id" placeholder="john@example.com" required autocomplete="email">
                            <span class="field-icon"><i class="fa fa-envelope"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-field">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Min 8 chars, upper &amp; number"
                                required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                title="Must have 8+ chars, one number, one uppercase" autocomplete="new-password">
                            <span class="field-icon"><i class="fa fa-lock"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-field">
                            <label>Confirm Password</label>
                            <input type="password" name="password_repeat" placeholder="Repeat your password" required autocomplete="new-password">
                            <span class="field-icon"><i class="fa fa-shield"></i></span>
                        </div>
                    </div>
                </div>
                <div class="terms-check">
                    <input type="checkbox" id="termsCheck" required>
                    <label for="termsCheck">
                        I agree to Skyline's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                    </label>
                </div>
                <button type="submit" name="signup_submit" class="btn-submit">Create Free Account</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="login.php">Log in here</a>
            </div>
        </div>
    </div>
</div>

<?php subview('footer.php'); ?>