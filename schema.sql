-- MySQL Schema for Stock Opname App

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS stock_opname;
USE stock_opname;

-- Table for stock categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT
);

-- Table for suppliers
CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_info TEXT
);

-- Table for users (for authentication and tracking)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for stocks (products/inventory)
CREATE TABLE IF NOT EXISTS stocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    description TEXT,
    category VARCHAR(255) DEFAULT 'Used',
    category_id INT,
    supplier_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL
);

-- Table for stock opname records (stocktaking history)
CREATE TABLE IF NOT EXISTS opname_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stock_id INT NOT NULL,
    recorded_quantity INT NOT NULL, -- Quantity in system
    actual_quantity INT NOT NULL, -- Quantity counted during opname
    discrepancy INT AS (actual_quantity - recorded_quantity),
    opname_date DATE NOT NULL,
    user_id INT, -- User who performed the opname
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (stock_id) REFERENCES stocks(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Indexes for better performance
CREATE INDEX idx_stocks_category ON stocks(category_id);
CREATE INDEX idx_stocks_supplier ON stocks(supplier_id);
CREATE INDEX idx_opname_stock ON opname_records(stock_id);
CREATE INDEX idx_opname_date ON opname_records(opname_date);
