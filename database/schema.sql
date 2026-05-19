-- database/schema.sql
-- Run this once to create the shared database tables
-- All 4 students share this same schema

CREATE DATABASE IF NOT EXISTS food_blog;
USE food_blog;

-- Users table (Task 1)
CREATE TABLE IF NOT EXISTS users (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100) NOT NULL,
    email           VARCHAR(150) NOT NULL UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    role            ENUM('admin', 'member') NOT NULL DEFAULT 'member',
    profile_picture VARCHAR(255) DEFAULT NULL,
    remember_token  VARCHAR(255) DEFAULT NULL,
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Restaurants table (Task 2)
CREATE TABLE IF NOT EXISTS restaurants (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    name             VARCHAR(150) NOT NULL,
    location         VARCHAR(150) NOT NULL,
    area             VARCHAR(100) NOT NULL,
    short_background TEXT,
    goals            TEXT,
    created_at       DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Menu items table (Task 2)
CREATE TABLE IF NOT EXISTS menu_items (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    name          VARCHAR(150) NOT NULL,
    description   TEXT,
    price         DECIMAL(10,2) NOT NULL,
    image_path    VARCHAR(255) DEFAULT NULL,
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
);

-- Reviews on food items (Task 3)
CREATE TABLE IF NOT EXISTS reviews (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    menu_item_id INT NOT NULL,
    user_id      INT NOT NULL,
    comment      TEXT NOT NULL,
    created_at   DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Food experience posts (Task 4)
CREATE TABLE IF NOT EXISTS food_experience_posts (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    user_id       INT NOT NULL,
    title         VARCHAR(200) NOT NULL,
    content       TEXT NOT NULL,
    post_type     ENUM('restaurant','food','both') DEFAULT 'both',
    restaurant_id INT DEFAULT NULL,
    menu_item_id  INT DEFAULT NULL,
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Food experience comments (Task 4)
CREATE TABLE IF NOT EXISTS food_experience_comments (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    post_id    INT NOT NULL,
    user_id    INT NOT NULL,
    comment    TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES food_experience_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
