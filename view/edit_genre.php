
<?php
require_once '../config/db.php';
require_once '../class/Genre.php';

$db = (new Database())->connect();
$genre = new Genre($db);

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$data = $genre->getById($id);

if (!$data) {
    die("Genre not found.");
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['genre_name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name !== '') {
        try {
            if ($genre->update($id, $name, $description)) {
                header('Location: genres.php?success=updated');
                exit;
            }
        } catch (PDOException $e) {
            $message = 'Genre name already exists.';
        }
    } else {
        $message = 'Genre name is required.';
    }
}

$pageTitle = 'Edit Genre';
$currentPage = 'genres';

include 'header.php';
?>

<h1>Edit Genre</h1>
<p class="subtitle">Update genre information.</p>

<?php if ($message): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<div class="panel">
    <h2>Genre Information</h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="form-group">
            <label>Genre Name</label>
            <input
                type="text"
                name="genre_name"
                value="<?= htmlspecialchars($data['genre_name']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3"><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
        </div>

        <button type="submit">Save Changes</button>
        <a href="genres.php" class="btn">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>
