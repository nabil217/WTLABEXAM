online_food_blog;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','member') DEFAULT 'member',
    profile_picture VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    area VARCHAR(100) NOT NULL,
    short_background TEXT,
    goals TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2),
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    menu_item_id INT,
    user_id INT,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);











-----------------


INSERT INTO users(name,email,password_hash,role)
VALUES
('Member User','member@gmail.com',
'$2y$10$2JmT4E9Wz7mYd9Q0U3gB5.ZJZ5c2qS6A6r8N8tR4L6y4WmF0cF7oG','member');

INSERT INTO restaurants(name,location,area,short_background,goals)
VALUES
('Pizza Palace','Dhaka','Mirpur','Famous pizza shop','Serve quality pizza'),
('Burger Town','Dhaka','Dhanmondi','Best burgers in town','Affordable burgers');

INSERT INTO menu_items(restaurant_id,name,description,price,image_path)
VALUES
(1,'Cheese Pizza','Delicious cheese pizza',450,'pizza.jpg'),
(1,'Chicken Pizza','Spicy chicken pizza',550,'pizza2.jpg'),
(2,'Beef Burger','Juicy beef burger',300,'burger.jpg');