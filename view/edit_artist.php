
<?php
require_once '../config/db.php';
require_once '../class/Artist.php';

$db = (new Database())->connect();
$artist = new Artist($db);

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$data = $artist->getById($id);

if (!$data) {
    die("Artist not found.");
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['artist_name'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $year = (int) ($_POST['debut_year'] ?? 0);

    if ($name !== '' && $country !== '' && $year > 0) {
        if ($artist->update($id, $name, $country, $year)) {
            header('Location: artists.php?success=updated');
            exit;
        }
    } else {
        $message = 'Please complete all fields.';
    }
}

$pageTitle = 'Edit Artist';
$currentPage = 'artists';

include 'header.php';
?>

<h1>Edit Artist</h1>
<p class="subtitle">Update artist information.</p>

<?php if ($message): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<div class="panel">
    <h2>Artist Information</h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="form-group">
            <label>Artist Name</label>
            <input
                type="text"
                name="artist_name"
                value="<?= htmlspecialchars($data['artist_name']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>Country</label>
            <input
                type="text"
                name="country"
                value="<?= htmlspecialchars($data['country']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>Debut Year</label>
            <input
                type="number"
                name="debut_year"
                min="1901"
                max="2155"
                value="<?= htmlspecialchars($data['debut_year']) ?>"
                required
            >
        </div>

        <button type="submit">Save Changes</button>
        <a href="artists.php" class="btn">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>
