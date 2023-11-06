-- User Not Logged In: Users can add products to the Cart table without logging in.
-- User Logs In: When a user logs in, their cart items (from the Cart table) can be moved to the OrderDetails table, associated with a new entry in the Orders table. This new entry represents the order.
-- Checkout: During checkout, users can select an address from the Addresses table or input a new address. The order total and products are stored in the Orders and OrderDetails tables respectively, along with the selected address.
-- Order History: To retrieve order history for a specific user, you can query the Orders and OrderDetails tables based on the UserID. The Addresses table can also be queried to retrieve user addresses.

CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);


CREATE TABLE products (
    id INT NOT NULL AUTO_INCREMENT UNSIGNED PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    product_image VARCHAR(255), -- Specify the appropriate size for the image URL
    product_description VARCHAR(255) NOT NULL,
    product_price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100) NOT NULL
);

-- create a temporary unique cart ID for the session and store the cart items in the Cart table using that ID.
-- session_start(); // Start the session if not already started
-- $_SESSION['cart_id'] = uniqid();
CREATE TABLE cart (
    cart_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    total DECIMAL(10, 2), -- Specify the appropriate precision and scale for your application
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE orders (
    order_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    address_id INT,
    total DECIMAL(10, 2),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (address_id) REFERENCES address(address_id)
);

CREATE TABLE orderdetail (
    orderdetail_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    user_id INT UNSIGNED, 
    quantity INT,
    product_id INT,
    total DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (user_id) REFERENCES users(id), -- Corrected foreign key reference
    FOREIGN KEY (product_id) REFERENCES cart(product_id)
);

CREATE TABLE address (
    address_id INT PRIMARY KEY,
    user_id INT UNSIGNED, -- This should reference users(id)
    address_1 VARCHAR(255),
    address_2 VARCHAR(255),
    state VARCHAR(255),
    postal VARCHAR(20),
    delivery_method VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);