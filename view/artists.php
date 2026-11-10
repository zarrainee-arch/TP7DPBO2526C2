
<?php
require_once '../config/db.php';
require_once '../class/Artist.php';

$db = (new Database())->connect();
$artist = new Artist($db);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['artist_name'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $year = (int) ($_POST['debut_year'] ?? 0);

    if ($name !== '' && $country !== '' && $year > 0) {
        if ($artist->create($name, $country, $year)) {
            header('Location: artists.php?success=added');
            exit;
        }
    } else {
        $message = 'Please complete all fields.';
    }
}

if (isset($_GET['delete'])) {
    try {
        $artist->delete((int) $_GET['delete']);
        header('Location: artists.php?success=deleted');
        exit;
    } catch (PDOException $e) {
        $message = 'Cannot delete artist because songs are still connected to this artist.';
    }
}

$artists = $artist->getAll();

$pageTitle = 'Artists';
$currentPage = 'artists';

include 'header.php';
?>

<h1>Artists</h1>
<p class="subtitle">Manage your favorite music artists.</p>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        Artist successfully <?= htmlspecialchars($_GET['success']) ?>.
    </div>
<?php endif; ?>

<?php if ($message): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<div class="panel">
    <h2>Add New Artist</h2>

    <form method="POST">
        <div class="form-group">
            <label>Artist Name</label>
            <input type="text" name="artist_name" required>
        </div>

        <div class="form-group">
            <label>Country</label>
            <input type="text" name="country" required>
        </div>

        <div class="form-group">
            <label>Debut Year</label>
            <input type="number" name="debut_year"
                   min="1901" max="2155" required>
        </div>

        <button type="submit">Add Artist</button>
    </form>
</div>

<div class="panel">
    <h2>Artist Collection</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Artist Name</th>
                <th>Country</th>
                <th>Debut Year</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($artists as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['id']) ?></td>
                <td><?= htmlspecialchars($item['artist_name']) ?></td>
                <td><?= htmlspecialchars($item['country']) ?></td>
                <td><?= htmlspecialchars($item['debut_year']) ?></td>
                <td>
                    <a class="action-link"
                       href="edit_artist.php?id=<?= $item['id'] ?>">
                       Edit
                    </a>

                    <a class="action-link"
                       href="artists.php?delete=<?= $item['id'] ?>"
                       onclick="return confirm('Delete this artist?')">
                       Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
