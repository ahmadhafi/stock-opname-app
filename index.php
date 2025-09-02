<?php
include 'db.php';

// Fetch all stocks
$stmt = $pdo->query("SELECT * FROM stocks");
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Opname - Warehouse Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Warehouse Stock Opname</h1>
        <a href="create.php" class="btn btn-primary">Add New Stock</a>
        <div class="card-grid">
            <?php foreach ($stocks as $stock): ?>
            <div class="card">
                <div class="card-header">
                    <h2><?php echo htmlspecialchars($stock['name']); ?></h2>
                    <div class="card-actions">
                        <a href="update.php?id=<?php echo $stock['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                        <a href="delete.php?id=<?php echo $stock['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> <?php echo $stock['id']; ?></p>
                    <p><strong>Quantity:</strong> <?php echo $stock['quantity']; ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($stock['description']); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($stock['category']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
