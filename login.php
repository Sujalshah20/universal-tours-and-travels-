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
        padding: 2rem;
    }
    .login-box {
        width: 100%;
        max-width: 450px;
        padding: 3rem;
        border-radius: 2rem;
    }
</style>

<main>
    <div class="glass-panel login-box animate-fade-in">
        <div class="text-center mb-5">
            <h2 class="font-weight-900 mb-2">Welcome Back</h2>
            <p class="text-secondary">Please enter your details to login</p>
        </div>

        <?php
        if(isset($_GET['error'])) {
            $msg = '';
            if($_GET['error'] === 'invalidcred') $msg = "Invalid Credentials";
            else if($_GET['error'] === 'wrongpwd') $msg = "Wrong Password";
            else if($_GET['error'] === 'sqlerror') $msg = "Database Error";
            
            if($msg) {
                echo '<div class="alert alert-danger border-0 mb-4 small" style="background: rgba(220, 38, 38, 0.1); color: #f87171;">
                        <i class="fa fa-exclamation-circle mr-2"></i> '.$msg.'
                      </div>';
            }
        }
        ?>

        <form action="includes/login.inc.php" method="POST">
            <div class="form-group mb-4">
                <label>USERNAME OR EMAIL</label>
                <div class="position-relative">
                    <i class="fa fa-envelope position-absolute" style="left: 1rem; top: 1rem; color: var(--text-secondary);"></i>
                    <input type="text" name="user_id" class="custom-input" placeholder="Enter your username" style="padding-left: 3rem;" required>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="d-flex justify-content-between">
                    <label>PASSWORD</label>
                    <a href="reset-pwd.php" class="small text-accent">Forgot?</a>
                </div>
                <div class="position-relative">
                    <i class="fa fa-lock position-absolute" style="left: 1rem; top: 1rem; color: var(--text-secondary);"></i>
                    <input type="password" name="user_pass" class="custom-input" placeholder="••••••••" style="padding-left: 3rem;" required>
                </div>
            </div>

            <button type="submit" name="login_but" class="btn btn-premium btn-block py-3 mt-4">
                Login to Account
            </button>

            <div class="text-center mt-5">
                <p class="text-secondary small">Don't have an account? 
                    <a href="register.php" class="text-accent font-weight-bold ml-1">Create free account</a>
                </p>
            </div>
        </form>
    </div>
</main>

<?php subview('footer.php'); ?>