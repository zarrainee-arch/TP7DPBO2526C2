
<?php
require_once '../config/db.php';
require_once '../class/Genre.php';

$db = (new Database())->connect();
$genre = new Genre($db);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['genre_name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name !== '') {
        try {
            if ($genre->create($name, $description)) {
                header('Location: genres.php?success=added');
                exit;
            }
        } catch (PDOException $e) {
            $message = 'Genre already exists or could not be added.';
        }
    } else {
        $message = 'Genre name is required.';
    }
}

if (isset($_GET['delete'])) {
    try {
        $genre->delete((int) $_GET['delete']);
        header('Location: genres.php?success=deleted');
        exit;
    } catch (PDOException $e) {
        $message = 'Cannot delete genre because songs are still connected to it.';
    }
}

$genres = $genre->getAll();

$pageTitle = 'Genres';
$currentPage = 'genres';

include 'header.php';
?>

<h1>Genres</h1>
<p class="subtitle">Organize music by its genre and style.</p>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        Genre successfully <?= htmlspecialchars($_GET['success']) ?>.
    </div>
<?php endif; ?>

<?php if ($message): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<div class="panel">
    <h2>Add New Genre</h2>

    <form method="POST">
        <div class="form-group">
            <label>Genre Name</label>
            <input type="text" name="genre_name" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3"></textarea>
        </div>

        <button type="submit">Add Genre</button>
    </form>
</div>

<div class="panel">
    <h2>Genre Collection</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Genre Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($genres as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['id']) ?></td>
                <td><?= htmlspecialchars($item['genre_name']) ?></td>
                <td><?= htmlspecialchars($item['description'] ?? '') ?></td>
                <td>
                    <a class="action-link"
                       href="edit_genre.php?id=<?= $item['id'] ?>">
                       Edit
                    </a>

                    <a class="action-link"
                       href="genres.php?delete=<?= $item['id'] ?>"
                       onclick="return confirm('Delete this genre?')">
                       Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
