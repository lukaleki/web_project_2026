<?php require_once 'Auth.php'; $auth = new Auth(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexGen CMS | Home</title>
    <link rel="icon" href="./images/favicon.png" />
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>
<body class="page">
    
    <header class="header">
        <div class="header__inner">
            <h1 class="header__logo">FileStor</h1>
            <nav class="nav">
                <ul class="nav__list">
                    <li class="nav__item"><a href="index.php" class="nav__link nav__link--active">Home</a></li>
                    <?php if($auth->isLoggedIn()): ?>
                        <li class="nav__item"><a href="dashboard.php" class="nav__link">Dashboard</a></li>
                        <?php if($auth->isAdmin()) echo '<li class="nav__item"><a href="admin.php" class="nav__link">Admin</a></li>'; ?>
                        <li class="nav__item"><a href="login.php?action=logout" class="nav__link">Logout</a></li>
                    <?php else: ?>
                        <li class="nav__item"><a href="login.php" class="nav__link">Login</a></li>
                        <li class="nav__item"><a href="register.php" class="btn btn--primary">Get Started</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="page__main">
        <section class="hero">
            <span class="hero__badge">fast and secure</span>
            <h1 class="hero__title">Manage your files with absolute precision</h1>
            <p class="hero__text">this file storage website is so cool and unique that, I just cant hold myself together, this is the best website in the world, also I would like to make this text long, because large descriptions look more professional</p>
            <?php if(!$auth->isLoggedIn()): ?>
                <a href="register.php" class="btn btn--primary" style="padding: 1.2rem 2.5rem; font-size: 1.1rem;">Create Free Account</a>
            <?php endif; ?>
        </section>
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
            &copy; <?= date('Y'); ?> NexGen CMS Project. All requirements fulfilled.
        </div>
    </footer>

</body>
</html>