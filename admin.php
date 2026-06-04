<?php
require_once 'Auth.php';
$auth = new Auth();

// Kick out anyone who isn't an admin
if (!$auth->isAdmin()) { 
    header("Location: index.php"); 
    exit; 
}

$logFile = "user_log.txt";

// Handle log form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log_info'])) {
    $entry = date("Y-m-d H:i:s") . " - ADMIN [" . $_SESSION['user_id'] . "] - " . $_POST['log_info'] . PHP_EOL;
    file_put_contents($logFile, $entry, FILE_APPEND);
}

// Read current logs
$logs = file_exists($logFile) ? file_get_contents($logFile) : "System ready. No logs available.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexGen | Admin Console</title>
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
                    <li class="nav__item"><a href="dashboard.php" class="nav__link">Dashboard</a></li>
                    <li class="nav__item"><a href="admin.php" class="nav__link nav__link--active">Admin</a></li>
                    <li class="nav__item"><a href="login.php?action=logout" class="nav__link">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="page__main" style="max-width: 900px; margin: 0 auto; width: 100%;">
        
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 2rem; color: #2c2a29; letter-spacing: -0.5px;">System Console</h2>
            <p style="color: #706c68; font-size: 1.05rem;">Monitor system activity and manually append audit logs.</p>
        </div>

        <div class="card" style="margin-bottom: 2rem;">
            <form action="" method="POST" class="form" style="max-width: 100%;">
                <div class="form__group">
                    <label class="form__label">New Audit Entry</label>
                    <textarea name="log_info" class="form__input" rows="3" placeholder="Describe the administrative action or system note..." required style="resize: vertical;"></textarea>
                </div>
                <div class="form__group" style="align-items: flex-start; margin-top: 0.5rem;">
                    <button type="submit" class="btn btn--primary">Append to Log</button>
                </div>
            </form>
        </div>

        <div class="card card--slim">
            <h3 style="font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; color: #2c2a29; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(44,42,41,0.08); padding-bottom: 0.75rem;">
                Live Output: user_log.txt
            </h3>
            
            <div style="background: #232221; color: #a6a099; padding: 1.5rem; border-radius: 6px; font-family: 'Courier New', Courier, monospace; font-size: 0.85rem; line-height: 1.8; overflow-x: auto; white-space: pre-wrap; min-height: 250px; border: 1px solid #1a1a1a; box-shadow: inset 0 4px 6px rgba(0,0,0,0.2);">
<?= htmlspecialchars($logs) ?>
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