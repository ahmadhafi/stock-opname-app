<?php
// Database configuration
$host = 'localhost';
$dbname = 'stock_opname';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS stocks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        quantity INT NOT NULL,
        description TEXT,
        category VARCHAR(255) DEFAULT 'Used'
    )";
    $pdo->exec($sql);

    // Add category column if it doesn't exist (for existing tables)
    try {
        $pdo->exec("ALTER TABLE stocks ADD COLUMN category VARCHAR(255) DEFAULT 'Used'");
    } catch (PDOException $e) {
        // Column might already exist, ignore
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
