<?php
require_once 'Auth.php';
$auth = new Auth();
if (!$auth->isLoggedIn()) { header("Location: login.php"); exit; }

$storage = new Storage();
$user_id = $_SESSION['user_id'];
$is_admin = $auth->isAdmin();

// ... (KEEP ALL PHP LOGIC EXACTLY THE SAME AS PREVIOUS DASHBOARD.PHP) ...

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $desc = $_POST['description'];
    $tag_id = (int)$_POST['tag_id'];
    $file = $_FILES['file']['name'];
    $target = "uploads/" . basename($file);
    if (!is_dir('uploads')) mkdir('uploads', 0777, true);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        $uploads = $storage->read('uploads.json');
        $upload_id = time() . rand(10, 99);
        $uploads[] = ['id' => $upload_id, 'user_id' => $user_id, 'filename' => $file, 'description' => $desc];
        $storage->write('uploads.json', $uploads);
        $upload_tags = $storage->read('upload_tags.json');
        $upload_tags[] = ['upload_id' => $upload_id, 'tag_id' => $tag_id];
        $storage->write('upload_tags.json', $upload_tags);
    }
}

if (isset($_GET['delete'])) {
    $del_id = $_GET['delete'];
    $uploads = $storage->read('uploads.json');
    $filtered = [];
    foreach ($uploads as $upload) {
        if ($upload['id'] == $del_id && !$is_admin && $upload['user_id'] != $user_id) { $filtered[] = $upload; continue; }
        if ($upload['id'] != $del_id) { $filtered[] = $upload; }
    }
    $storage->write('uploads.json', $filtered);
}

if (isset($_POST['update'])) {
    $update_id = $_POST['id'];
    $new_desc = $_POST['description'];
    $uploads = $storage->read('uploads.json');
    foreach ($uploads as &$upload) {
        if ($upload['id'] == $update_id && ($is_admin || $upload['user_id'] == $user_id)) {
            $upload['description'] = $new_desc;
        }
    }
    $storage->write('uploads.json', $uploads);
}

$all_uploads = $storage->read('uploads.json');
$records = [];
foreach ($all_uploads as $upload) { if ($is_admin || $upload['user_id'] == $user_id) { $records[] = $upload; } }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page">

    <header class="header">
        <div class="header__inner">
            <div class="header__logo">NexGen<span>.</span></div>
            <nav class="nav">
                <ul class="nav__list">
                    <li class="nav__item"><a href="index.php" class="nav__link">Home</a></li>
                    <li class="nav__item"><a href="dashboard.php" class="nav__link nav__link--active">Dashboard</a></li>
                    <li class="nav__item"><a href="login.php?action=logout" class="nav__link">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="page__main" style="max-width: 1200px; margin: 0 auto; width: 100%;">
        
        <div class="card">
            <h2 style="margin-bottom: 2rem;">Upload New Document</h2>
            <form action="" method="POST" enctype="multipart/form-data" class="form" style="max-width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div class="form__group" style="grid-column: 1 / -1;">
                    <input type="file" name="file" class="form__input form__file" required>
                </div>
                <div class="form__group">
                    <label class="form__label">File Description</label>
                    <input type="text" name="description" class="form__input" placeholder="Enter a brief description..." required>
                </div>
                <div class="form__group">
                    <label class="form__label">Category Tag</label>
                    <select name="tag_id" class="form__input" required>
                        <option value="1">Document</option>
                        <option value="2">Image</option>
                        <option value="3">Archive</option>
                    </select>
                </div>
                <div class="form__group" style="grid-column: 1 / -1; align-items: flex-start;">
                    <button type="submit" name="upload" class="btn btn--primary">Secure Upload</button>
                </div>
            </form>
        </div>

        <h2 style="margin-top: 4rem;">Your Managed Files</h2>
        
        <div class="dashboard-grid">
            <?php foreach($records as $row): ?>
                <div class="card card--slim card--animated file-item">
                    <div class="file-item__icon">📄</div>
                    <div class="file-item__name"><?= htmlspecialchars($row['filename']) ?></div>
                    
                    <form action="" method="POST" class="form file-item__actions">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="text" name="description" class="form__input" value="<?= htmlspecialchars($row['description']) ?>" required>
                        <div style="display: flex; gap: 1rem; width: 100%;">
                            <button type="submit" name="update" class="btn btn--primary" style="flex: 1;">Save</button>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn--danger">Drop</a>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>
</html>