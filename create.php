<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $names = $_POST['name'];
    $quantities = $_POST['quantity'];
    $descriptions = $_POST['description'];
    $categories = $_POST['category'];

    $stmt = $pdo->prepare("INSERT INTO stocks (name, quantity, description, category) VALUES (?, ?, ?, ?)");
    for ($i = 0; $i < count($names); $i++) {
        if (!empty($names[$i])) {
            $stmt->execute([$names[$i], $quantities[$i], $descriptions[$i], $categories[$i]]);
        }
    }

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
            <div id="items">
                <div class="item">
                    <h3>Item 1</h3>
                    <label for="name0">Name:</label>
                    <input type="text" id="name0" name="name[]" required>

                    <label for="quantity0">Quantity:</label>
                    <input type="number" id="quantity0" name="quantity[]" required>

                    <label for="description0">Description:</label>
                    <textarea id="description0" name="description[]"></textarea>

                    <label for="category0">Category:</label>
                    <select id="category0" name="category[]" required>
                        <option value="Used">Used</option>
                        <option value="Unused (Abolish Plan)">Unused (Abolish Plan)</option>
                    </select>
                </div>
            </div>

            <button type="button" id="addItem" class="btn btn-secondary">Add Another Item</button>
            <button type="submit" class="btn btn-primary">Add Stocks</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>

        <script>
            let itemCount = 1;
            document.getElementById('addItem').addEventListener('click', function() {
                itemCount++;
                const itemsDiv = document.getElementById('items');
                const newItem = itemsDiv.querySelector('.item').cloneNode(true);
                newItem.querySelector('h3').textContent = 'Item ' + itemCount;

                // Update IDs and clear values
                const inputs = newItem.querySelectorAll('input, textarea, select');
                inputs.forEach((input, index) => {
                    input.id = input.id.replace(/\d+/, itemCount - 1);
                    input.value = '';
                });

                itemsDiv.appendChild(newItem);
            });
        </script>
    </div>
    <script src="script.js"></script>
</body>
</html>
