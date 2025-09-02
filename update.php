<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM stocks WHERE id = ?");
$stmt->execute([$id]);
$stock = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$stock) {
    die("Stock not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare("UPDATE stocks SET name = ?, quantity = ?, description = ?, category = ? WHERE id = ?");
    $stmt->execute([$name, $quantity, $description, $category, $id]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Stock</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Update Stock</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($stock['name']); ?>" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $stock['quantity']; ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($stock['description']); ?></textarea>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="Used" <?php echo ($stock['category'] == 'Used') ? 'selected' : ''; ?>>Used</option>
                <option value="Unused (Abolish Plan)" <?php echo ($stock['category'] == 'Unused (Abolish Plan)') ? 'selected' : ''; ?>>Unused (Abolish Plan)</option>
            </select>

            <button type="submit" class="btn btn-primary">Update Stock</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
