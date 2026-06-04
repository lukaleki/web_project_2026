<?php
require_once 'Auth.php';
$auth = new Auth();
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($auth->register($_POST['email'], $_POST['password'])) {
        header("Location: login.php");
        exit;
    } else {
        $msg = "Registration failed. This email address may already be in use.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexGen | Create Account</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>
<body class="page">
    
    <header class="header">
        <div class="header__inner">
            <div class="header__logo"><a href="index.php" style="color: inherit;">NexGen<span>.</span></a></div>
            <nav class="nav">
                <ul class="nav__list">
                    <li class="nav__item"><a href="index.php" class="nav__link">Home</a></li>
                    <li class="nav__item"><a href="login.php" class="nav__link">Login</a></li>
                    <li class="nav__item"><a href="register.php" class="nav__link nav__link--active">Register</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="page__main">
        <div class="card" style="max-width: 480px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="margin-bottom: 0.5rem;">Create an Account</h2>
                <p style="color: #706c68; font-size: 0.95rem;">Join the platform to securely manage your files.</p>
            </div>

            <?php if($msg): ?>
                <div class="message message--error"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>

            <form action="" method="POST" class="form">
                <div class="form__group">
                    <label class="form__label">Email Address</label>
                    <input type="email" name="email" class="form__input" placeholder="name@domain.com" required>
                </div>
                
                <div class="form__group">
                    <label class="form__label">Password</label>
                    <input type="password" name="password" class="form__input" placeholder="••••••••" required minlength="6">
                </div>

                <button type="submit" class="btn btn--primary" style="margin-top: 0.5rem; width: 100%;">Create Account</button>
            </form>

            <div style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #706c68;">
                Already have an account? <a href="login.php" style="color: #3d5a45; font-weight: 600;">Log in here</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer__inner">
            <div class="footer__col">
                <h4>NexGen<span>.</span></h4>
                <p class="footer__text">Delivering high-quality, academic-grade web development projects using modern standards, SCSS, and JSON-based file storage.</p>
            </div>
            <div class="footer__col">
                <h4>Platform</h4>
                <ul class="footer__links">
                    <li><a href="register.php" class="footer__link">Registration</a></li>
                    <li><a href="login.php" class="footer__link">Client Login</a></li>
                    <li><a href="dashboard.php" class="footer__link">File Manager</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h4>Legal & Tech</h4>
                <ul class="footer__links">
                    <li><span class="footer__link">CSS3 Animations</span></li>
                    <li><span class="footer__link">BEM Methodology</span></li>
                    <li><span class="footer__link">No Database Required</span></li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            &copy; <?= date('Y'); ?> NexGen CMS Project. All rights reserved.
        </div>
    </footer>

</body>
</html>