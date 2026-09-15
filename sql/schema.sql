CREATE DATABASE IF NOT EXISTS inmanage_test;

USE inmanage_test;

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1,
    birth_date DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS posts (
    id INT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id)
);