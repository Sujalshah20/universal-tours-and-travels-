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
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 2rem;
    }
    .register-box {
        width: 100%;
        max-width: 600px;
        padding: 3.5rem;
        border-radius: 2.5rem;
    }
    .input-group-custom {
        margin-bottom: 1.5rem;
    }
</style>

<main>
    <div class="glass-panel register-box animate-fade-in">
        <div class="text-center mb-5">
            <h2 class="font-weight-900 mb-2">Create Account</h2>
            <p class="text-secondary">Join Skyline and start your journey today</p>
        </div>

        <?php
        if(isset($_GET['error'])) {
            $msg = '';
            if($_GET['error'] === 'invalidemail') $msg = "Invalid email address";
            else if($_GET['error'] === 'pwdnotmatch') $msg = "Passwords do not match";
            else if($_GET['error'] === 'sqlerror') $msg = "Database connection error";
            else if($_GET['error'] === 'usernameexists') $msg = "Username already exists";
            else if($_GET['error'] === 'emailexists') $msg = "Email already exists";
            
            if($msg) {
                echo '<div class="alert alert-danger border-0 mb-4 small" style="background: rgba(220, 38, 38, 0.1); color: #f87171;">
                        <i class="fa fa-exclamation-circle mr-2"></i> '.$msg.'
                      </div>';
            }
        }
        ?>

        <form action="includes/register.inc.php" method="POST">
            <div class="row">
                <div class="col-md-6 input-group-custom">
                    <label>USERNAME</label>
                    <div class="position-relative">
                        <i class="fa fa-user position-absolute" style="left: 1rem; top: 1rem; color: var(--text-secondary);"></i>
                        <input type="text" name="username" class="custom-input" placeholder="traveler_01" style="padding-left: 3rem;" required>
                    </div>
                </div>
                <div class="col-md-6 input-group-custom">
                    <label>EMAIL ADDRESS</label>
                    <div class="position-relative">
                        <i class="fa fa-envelope position-absolute" style="left: 1rem; top: 1rem; color: var(--text-secondary);"></i>
                        <input type="email" name="email_id" class="custom-input" placeholder="john@example.com" style="padding-left: 3rem;" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 input-group-custom">
                    <label>PASSWORD</label>
                    <div class="position-relative">
                        <i class="fa fa-lock position-absolute" style="left: 1rem; top: 1rem; color: var(--text-secondary);"></i>
                        <input type="password" name="password" class="custom-input" placeholder="••••••••" style="padding-left: 3rem;" 
                               required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                               title="Must contain at least 8 characters, one number, one uppercase and one lowercase letter">
                    </div>
                </div>
                <div class="col-md-6 input-group-custom">
                    <label>CONFIRM PASSWORD</label>
                    <div class="position-relative">
                        <i class="fa fa-shield position-absolute" style="left: 1rem; top: 1rem; color: var(--text-secondary);"></i>
                        <input type="password" name="password_repeat" class="custom-input" placeholder="••••••••" style="padding-left: 3rem;" required>
                    </div>
                </div>
            </div>

            <div class="custom-control custom-checkbox my-4">
                <input type="checkbox" class="custom-control-input" id="termsCheck" required>
                <label class="custom-control-label text-secondary small" for="termsCheck">
                    I agree to the <a href="#" class="text-accent">Terms of Service</a> and <a href="#" class="text-accent">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" name="signup_submit" class="btn btn-premium btn-block py-3">
                Complete Registration
            </button>

            <div class="text-center mt-5">
                <p class="text-secondary small">Already have an account? 
                    <a href="login.php" class="text-accent font-weight-bold ml-1">Log in here</a>
                </p>
            </div>
        </form>
    </div>
</main>

<?php subview('footer.php'); ?>