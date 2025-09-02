<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare("INSERT INTO stocks (name, quantity, description, category) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $quantity, $description, $category]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Stock</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Stock</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="Used">Used</option>
                <option value="Unused (Abolish Plan)">Unused (Abolish Plan)</option>
            </select>

            <button type="submit" class="btn btn-primary">Add Stock</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
