<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM stocks WHERE id = ?");
    $stmt->execute([$id]);

    // Renumber IDs sequentially after deletion
    $deleted_id = $id;

    // Get all IDs greater than the deleted ID in descending order
    $stmt = $pdo->prepare("SELECT id FROM stocks WHERE id > ? ORDER BY id DESC");
    $stmt->execute([$deleted_id]);
    $ids_to_update = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Update each ID to the new sequential value
    foreach ($ids_to_update as $current_id) {
        $new_id = $current_id - 1;
        $update_stmt = $pdo->prepare("UPDATE stocks SET id = ? WHERE id = ?");
        $update_stmt->execute([$new_id, $current_id]);
    }

    // Reset AUTO_INCREMENT to the next available ID
    $stmt = $pdo->query("SELECT MAX(id) FROM stocks");
    $max_id = $stmt->fetchColumn();
    $next_auto = $max_id ? $max_id + 1 : 1;
    $pdo->exec("ALTER TABLE stocks AUTO_INCREMENT = $next_auto");
}

header('Location: index.php');
exit;
?>
