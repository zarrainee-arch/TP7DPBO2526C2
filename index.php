
<?php
require_once 'config/db.php';
require_once 'class/Artist.php';
require_once 'class/Genre.php';
require_once 'class/Song.php';

$db = (new Database())->connect();

$artist = new Artist($db);
$genre = new Genre($db);
$song = new Song($db);

$artists = $artist->getAll();
$genres = $genre->getAll();
$songs = $song->getAll();

$pageTitle = 'Dashboard';
$currentPage = 'dashboard';

include 'view/header.php';
?>

<h1>Welcome to MUSETRACK</h1>
<p class="subtitle">Your personal music universe.</p>

<div class="stats">
    <div class="stat-card">
        <span>Total Artists</span>
        <h2><?= count($artists) ?></h2>
    </div>
    <div class="stat-card">
        <span>Total Genres</span>
        <h2><?= count($genres) ?></h2>
    </div>
    <div class="stat-card">
        <span>Total Songs</span>
        <h2><?= count($songs) ?></h2>
    </div>
</div>

<section class="panel">
    <h2>Recently Added Songs</h2>
    <table>
        <thead>
            <tr>
                <th>Song Title</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Release Year</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach (array_slice($songs, 0, 5) as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td><?= htmlspecialchars($item['artist_name']) ?></td>
                <td><?= htmlspecialchars($item['genre_name']) ?></td>
                <td><?= htmlspecialchars($item['release_year']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php include 'view/footer.php'; ?>
