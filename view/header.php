
<?php
$pageTitle = $pageTitle ?? 'Dashboard';
$currentPage = $currentPage ?? 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | MUSETRACK</title>

    <link rel="stylesheet" href="/tp7/style.css">
</head>

<body>

<div class="sidebar">
    <div class="brand">♫ MUSETRACK</div>

    <p class="menu-label">MAIN MENU</p>

    <a href="/tp7/index.php"
       class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>">
       Dashboard
    </a>

    <a href="/tp7/view/artists.php"
       class="<?= $currentPage === 'artists' ? 'active' : '' ?>">
       Artists
    </a>

    <a href="/tp7/view/genres.php"
       class="<?= $currentPage === 'genres' ? 'active' : '' ?>">
       Genres
    </a>

    <a href="/tp7/view/songs.php"
       class="<?= $currentPage === 'songs' ? 'active' : '' ?>">
       Songs
    </a>

    <div class="sidebar-bottom">
        Your Everlasting Music.
    </div>
</div>

<main class="main-content">

    <header class="topbar">
        <span>Music On Track</span>
        <span class="topbar-brand">
            MUSETRACK / <?= htmlspecialchars($pageTitle) ?>
        </span>
    </header>

    <div class="content">
