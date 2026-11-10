
<?php
require_once '../config/db.php';
require_once '../class/Artist.php';
require_once '../class/Genre.php';
require_once '../class/Song.php';

$db = (new Database())->connect();

$artist = new Artist($db);
$genre = new Genre($db);
$song = new Song($db);

$message = '';

$artists = $artist->getAll();
$genres = $genre->getAll();

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
        try {
            if ($song->create(
                $title,
                $artistId,
                $genreId,
                $year,
                $duration
            )) {
                header('Location: songs.php?success=added');
                exit;
            }
        } catch (PDOException $e) {
            $message = 'Failed to add song.';
        }
    } else {
        $message = 'Please complete all fields correctly.';
    }
}

if (isset($_GET['delete'])) {
    try {
        $song->delete((int) $_GET['delete']);
        header('Location: songs.php?success=deleted');
        exit;
    } catch (PDOException $e) {
        $message = 'Failed to delete song.';
    }
}

$songs = $song->getAll();

$pageTitle = 'Songs';
$currentPage = 'songs';

include 'header.php';
?>

<h1>Songs</h1>
<p class="subtitle">Manage your music collection and track every song.</p>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        Song successfully <?= htmlspecialchars($_GET['success']) ?>.
    </div>
<?php endif; ?>

<?php if ($message): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<div class="panel">
    <h2>Add New Song</h2>

    <form method="POST">

        <div class="form-group">
            <label>Song Title</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Artist</label>
            <select name="artist_id" required>
                <option value="">Select Artist</option>

                <?php foreach ($artists as $item): ?>
                    <option value="<?= $item['id'] ?>">
                        <?= htmlspecialchars($item['artist_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Genre</label>
            <select name="genre_id" required>
                <option value="">Select Genre</option>

                <?php foreach ($genres as $item): ?>
                    <option value="<?= $item['id'] ?>">
                        <?= htmlspecialchars($item['genre_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Release Year</label>
            <input type="number" name="release_year"
                   min="1901" max="2155" required>
        </div>

        <div class="form-group">
            <label>Duration (seconds)</label>
            <input type="number" name="duration" min="1" required>
        </div>

        <button type="submit">Add Song</button>

    </form>
</div>

<div class="panel">
    <h2>Song Collection</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Song Title</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Release Year</th>
                <th>Duration</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($songs as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['id']) ?></td>

                <td><?= htmlspecialchars($item['title']) ?></td>

                <td><?= htmlspecialchars($item['artist_name']) ?></td>

                <td><?= htmlspecialchars($item['genre_name']) ?></td>

                <td><?= htmlspecialchars($item['release_year']) ?></td>

                <td><?= htmlspecialchars($item['duration']) ?> sec</td>

                <td>
                    <a class="action-link"
                       href="edit_song.php?id=<?= $item['id'] ?>">
                       Edit
                    </a>

                    <a class="action-link"
                       href="songs.php?delete=<?= $item['id'] ?>"
                       onclick="return confirm('Delete this song?')">
                       Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
