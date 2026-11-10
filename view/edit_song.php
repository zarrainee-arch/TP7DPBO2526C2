
<?php
require_once '../config/db.php';
require_once '../class/Artist.php';
require_once '../class/Genre.php';
require_once '../class/Song.php';

$db = (new Database())->connect();

$artist = new Artist($db);
$genre = new Genre($db);
$song = new Song($db);

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$data = $song->getById($id);

if (!$data) {
    die("Song not found.");
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $artistId = (int) ($_POST['artist_id'] ?? 0);
    $genreId = (int) ($_POST['genre_id'] ?? 0);
    $year = (int) ($_POST['release_year'] ?? 0);
    $duration = (int) ($_POST['duration'] ?? 0);

    if (
        $title !== '' &&
        $artist->getById($artistId) &&
        $genre->getById($genreId) &&
        $year > 0 &&
        $duration > 0
    ) {
        if ($song->update(
            $id,
            $title,
            $artistId,
            $genreId,
            $year,
            $duration
        )) {
            header('Location: songs.php?success=updated');
            exit;
        }
    } else {
        $message = 'Please complete all fields correctly.';
    }
}

$artists = $artist->getAll();
$genres = $genre->getAll();

$pageTitle = 'Edit Song';
$currentPage = 'songs';

include 'header.php';
?>

<h1>Edit Song</h1>
<p class="subtitle">Update your music information.</p>

<?php if ($message): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<div class="panel">
    <h2>Song Information</h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="form-group">
            <label>Song Title</label>
            <input
                type="text"
                name="title"
                value="<?= htmlspecialchars($data['title']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>Artist</label>
            <select name="artist_id" required>
                <?php foreach ($artists as $item): ?>
                    <option
                        value="<?= $item['id'] ?>"
                        <?= $data['artist_id'] == $item['id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($item['artist_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Genre</label>
            <select name="genre_id" required>
                <?php foreach ($genres as $item): ?>
                    <option
                        value="<?= $item['id'] ?>"
                        <?= $data['genre_id'] == $item['id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($item['genre_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Release Year</label>
            <input
                type="number"
                name="release_year"
                min="1901"
                max="2155"
                value="<?= htmlspecialchars($data['release_year']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>Duration (seconds)</label>
            <input
                type="number"
                name="duration"
                min="1"
                value="<?= htmlspecialchars($data['duration']) ?>"
                required
            >
        </div>

        <button type="submit">Save Changes</button>
        <a href="songs.php" class="btn">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>
