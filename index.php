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
        <input type="text" id="searchInput" placeholder="Search stocks..." style="margin-bottom: 15px; padding: 8px; width: 100%; max-width: 400px; border-radius: 8px; border: 1px solid #ccc;">

        <table id="stocksTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Quantity</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stocks as $stock): ?>
                <tr>
                    <td><?php echo htmlspecialchars($stock['name']); ?></td>
                    <td><?php echo $stock['id']; ?></td>
                    <td><?php echo $stock['quantity']; ?></td>
                    <td><?php echo htmlspecialchars($stock['description']); ?></td>
                    <td><?php echo htmlspecialchars($stock['category']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $stock['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                        <a href="delete.php?id=<?php echo $stock['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                var filter = this.value.toLowerCase();
                var rows = document.querySelectorAll('#stocksTable tbody tr');

                rows.forEach(function(row) {
                    var text = row.textContent.toLowerCase();
                    row.style.display = text.indexOf(filter) > -1 ? '' : 'none';
                });
            });
        </script>
    </div>
    <script src="script.js"></script>
</body>
</html>
