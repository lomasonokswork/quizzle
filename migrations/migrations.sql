CREATE DATABASE IF NOT EXISTS quizzle;
USE quizzle;

CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    permission_level ENUM("User", "Admin") NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS quizzes (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    created_by INT NOT NULL,
    title VARCHAR(30) NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS questions (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    quiz_id INT NOT NULL,
    question VARCHAR(255) NOT NULL,
    variant_1 VARCHAR(255) NOT NULL,
    variant_2 VARCHAR(255) NOT NULL,
    variant_3 VARCHAR(255) NOT NULL,
    variant_4 VARCHAR(255) NOT NULL,
    variant_correct VARCHAR(255) NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
);

ALTER TABLE questions ADD COLUMN variant_4 VARCHAR(255) NOT NULL DEFAULT '' AFTER variant_3;
