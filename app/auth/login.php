<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExamShield LPS — Sign In</title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Custom Login CSS -->
    <link rel="stylesheet" href="../../assets/css/login.css">
</head>
<body>

<div class="login-wrapper">

    <!-- ── Left Side: Branding & Illustration ── -->
    <div class="login-brand-side">
        <!-- Abstract Background Shapes -->
        <div class="brand-bg-shape shape-1"></div>
        <div class="brand-bg-shape shape-2"></div>

        <div class="brand-content fade-in-up">
            <div class="brand-logo-wrap">
                <div class="brand-logo-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="brand-logo-text">
                    ExamShield
                    <span>LPS Platform</span>
                </div>
            </div>

            <h1 class="brand-headline">Secure, Intelligent and Reliable Assessment.</h1>
            <p class="brand-description">
                Experience the next generation of online examinations. ExamShield LPS provides advanced proctoring, 
                seamless academic management, and deep analytics for modern institutions.
            </p>

            <!-- Floating Illustration -->
            <div class="brand-illustration">
                <div class="glass-panel panel-main">
                    <i class="bi bi-laptop"></i>
                </div>
                <div class="glass-panel panel-float-1">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div class="glass-panel panel-float-2">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Right Side: Login Form ── -->
    <div class="login-form-side">

        <!-- Mobile Logo (Hidden on desktop) -->
        <div class="mobile-logo fade-in-up">
            <div class="mobile-logo-icon"><i class="bi bi-shield-check"></i></div>
            <div class="mobile-logo-text">ExamShield LPS</div>
        </div>

        <div class="login-card fade-in-up" style="animation-delay: 0.1s;">
            
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Sign in to continue to your dashboard</p>
            </div>

            <!-- Flash Messages -->
            <?php if (isset($_SESSION["error"])) : ?>
                <div class="alert-custom alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>
                        <?php 
                        echo $_SESSION["error"]; 
                        unset($_SESSION["error"]); 
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION["success_message"])) : ?>
                <div class="alert-custom alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <?php 
                        echo $_SESSION["success_message"]; 
                        unset($_SESSION["success_message"]); 
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="login_process.php" method="POST" id="loginForm">
                
                <div class="form-floating-custom">
                    <input type="email" name="email" id="email" class="form-control-custom" placeholder="Email Address" required autocomplete="email">
                    <i class="bi bi-envelope-fill input-icon"></i>
                </div>

                <div class="form-floating-custom">
                    <input type="password" name="password" id="password" class="form-control-custom" placeholder="Password" required autocomplete="current-password">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                        <i class="bi bi-eye-slash-fill" id="toggleIcon"></i>
                    </button>
                </div>

                <div class="login-options">
                    <label class="form-check-custom" for="rememberMe">
                        <input type="checkbox" class="form-check-input-custom" id="rememberMe" name="remember_me">
                        Remember Me
                    </label>
                    <a href="forgot_password.php" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="btn-text">Sign In</span>
                    <i class="bi bi-arrow-right btn-icon"></i>
                    <div class="spinner"></div>
                </button>

            </form>

            <div class="login-footer-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>

        </div>

        <div class="page-footer fade-in-up" style="animation-delay: 0.2s;">
            &copy; <?php echo date("Y"); ?> ExamShield LPS. All rights reserved. <br>
            <span style="opacity: 0.7;">v2.0.0 &bull; <a href="mailto:support@examshield.com" style="color: inherit; text-decoration: none;">Support</a></span>
        </div>

    </div>

</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        if (type === 'password') {
            toggleIcon.classList.remove('bi-eye-fill');
            toggleIcon.classList.add('bi-eye-slash-fill');
        } else {
            toggleIcon.classList.remove('bi-eye-slash-fill');
            toggleIcon.classList.add('bi-eye-fill');
        }
    });

    // Form Loading State
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const btnText = loginBtn.querySelector('.btn-text');
    const btnIcon = loginBtn.querySelector('.btn-icon');
    const spinner = loginBtn.querySelector('.spinner');

    loginForm.addEventListener('submit', function() {
        // Only trigger loading if form is valid
        if (loginForm.checkValidity()) {
            loginBtn.classList.add('loading');
            btnText.textContent = 'Signing in...';
            btnIcon.style.display = 'none';
            spinner.style.display = 'block';
        }
    });

});
</script>

</body>
</html>