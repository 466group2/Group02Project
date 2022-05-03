/*
* Moses Mang
* CSCI 466 - 1
* Spring 2022
* Group Project
* Purpose: SQL file to create database for online store
*/

DROP TABLE IF EXISTS Added;
DROP TABLE IF EXISTS Generates;
DROP TABLE IF EXISTS ViewOrder;
DROP TABLE IF EXISTS Employee;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Payment;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS Foods, Meds, Armors; 
DROP TABLE IF EXISTS Products;


CREATE TABLE Products (
    id INT AUTO_INCREMENT PRIMARY KEY,              -- Primary Key
    name VARCHAR(197) NOT NULL,                     -- Name of Product
    tagline VARCHAR(255) NOT NULL,                  -- Product tagline 
    description TEXT NOT NULL,                      -- Description of Product
    image VARCHAR(255) NOT NULL,                    -- Image link
    price DOUBLE(9,2) DEFAULT 0.00,                 -- Price of Product
    qty INT DEFAULT 0,                              -- Available quantity
    type VARCHAR(255)                               -- Product type (armor, food, medicine)
);

CREATE TABLE ShoppingCart(
    CartID INT PRIMARY KEY AUTO_INCREMENT,          -- Primray Key
    QTYRequested INT(100)                           -- Quanutiy requested
);

CREATE TABLE Payment(
    PaymentID INT PRIMARY KEY AUTO_INCREMENT,       -- Primary Key
    CreditCardInfo INT (16),                        -- Credit Card #
    PaymentAmount DOUBLE(9,2) DEFAULT 0.00          -- Payment Amout
);

CREATE TABLE User(
    UserID INT PRIMARY KEY AUTO_INCREMENT,          -- Primrary Key
    Notes VARCHAR(127),                             -- Notes about User
    Name VARCHAR(31),                               -- Name of user
    BillingAddress VARCHAR(255),                    -- Billing Address of User
    ShippingAddress VARCHAR(255),                   -- Shipping Address of User
    Phone VARCHAR(14),                              -- Phone number of User
    Email VARCHAR(255)                              -- Email address of User
);

CREATE TABLE Orders(
    OrderID INT PRIMARY KEY AUTO_INCREMENT,                 -- Primray Key
    Notes VARCHAR(127),                                     -- Notes about order
    OrderDate DATE DEFAULT CURRENT_DATE(),                  -- Date of order
    Total DOUBLE(9,2) DEFAULT 0.00,                         -- Total of order
    Status CHAR(10) DEFAULT 'Pending',                      -- Status of order
    TrackingNum VARCHAR(31),                                -- Tracking number
    UserID INT,                                             -- UserID, foreign key
    FOREIGN KEY (UserID) REFERENCES User(UserID)
);

CREATE TABLE OrderDetails(
    OrderID INT PRIMARY KEY AUTO_INCREMENT,                 -- Primray Key
    OrderDate DATE,                                         -- Date of order
    Price FLOAT(7),                                         -- Price of order
    QTYOrdered INT(100),                                    -- Quantity ordered
    UserID INT,                                             -- UserID, foreign key
    ItemID INT,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (ItemID) REFERENCES Products(id),
    FOREIGN KEY (OrderDate) REFERENCES Orders(OrderDate)
);

CREATE TABLE Employee(
    EmpID INT PRIMARY KEY AUTO_INCREMENT,                   -- Primary Key
    Role VARCHAR(127),                                      -- Role of employee
    OrderID INT,
    FOREIGN KEY (EmpID) REFERENCES User(UserID),            -- Foreign Key
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID)        -- Foreign Key
);

CREATE TABLE ViewOrder(
    EmpID INT,
    OrderID INT,
    PRIMARY KEY (EmpID, OrderID),                           -- Primary Key
    FOREIGN KEY (EmpID) REFERENCES Employee(EmpID),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID)
);

CREATE TABLE Generates(
    product_id INT,
    CartID INT,
    OrderID INT,
    PaymentID INT,
    PRIMARY KEY (product_id, CartID, OrderID, PaymentID),          -- Primrary Key
    FOREIGN KEY (product_id) REFERENCES Products(id),
    FOREIGN KEY (CartID) REFERENCES ShoppingCart(CartID),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (PaymentID) REFERENCES Payment(PaymentID)
);

CREATE TABLE Added(
    product_id INT,
    CartID INT,
    UserID INT,
    PRIMARY KEY (product_id, CartID),                              -- Primary KEy
    FOREIGN KEY (product_id) REFERENCES Products(id),
    FOREIGN KEY (CartID) REFERENCES ShoppingCart(CartID),
    FOREIGN KEY (UserID) REFERENCES User(UserID)                -- Foreign Key
);

CREATE TABLE Armors (   
  item_id INT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  tier INT DEFAULT 1,
  FOREIGN KEY (item_id) REFERENCES Products(id)
);

CREATE TABLE Meds (
  item_id INT PRIMARY KEY,
  type VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL,
  FOREIGN KEY (item_id) REFERENCES Products(id)
);

CREATE TABLE Foods (
  item_id INT PRIMARY KEY,
  type VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL,
  FOREIGN KEY (item_id) REFERENCES Products(id)
);