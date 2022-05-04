/*
* Moses Mang
* CSCI 466 - 1
* Spring 2022
* Group Project
* Purpose: SQL file to create database for online store
*/


DROP TABLE IF EXISTS Payment;
DROP TABLE IF EXISTS OrderDetails;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS Foods, Meds, Armors; 
DROP TABLE IF EXISTS Products;
DROP TABLE IF EXISTS User;

CREATE TABLE User(
    UserID INT PRIMARY KEY AUTO_INCREMENT,          -- Primrary Key
    Notes VARCHAR(127),                             -- Notes about User
    Name VARCHAR(31),                               -- Name of user
    BillingAddress VARCHAR(255),                    -- Billing Address of User
    ShippingAddress VARCHAR(255),                   -- Shipping Address of User
    Phone VARCHAR(14),                              -- Phone number of User
    Email VARCHAR(255)                              -- Email address of User
);

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

CREATE TABLE Armors (   
  item_id INT PRIMARY KEY,                          -- Primary Key
  name VARCHAR(255) NOT NULL,                       -- Name of armor
  tier INT DEFAULT 1,
  FOREIGN KEY (item_id) REFERENCES Products(id)
);

CREATE TABLE Meds (
  item_id INT PRIMARY KEY,                          -- Primary Key
  type VARCHAR(255) NOT NULL,                       -- Type of medicine
  name VARCHAR(255) NOT NULL,                       -- Name of medicine
  FOREIGN KEY (item_id) REFERENCES Products(id)
);

CREATE TABLE Foods (
  item_id INT PRIMARY KEY,                          -- Primary Key
  type VARCHAR(255) NOT NULL,                       -- Type of food
  name VARCHAR(255) NOT NULL,                       -- Name of foofd
  FOREIGN KEY (item_id) REFERENCES Products(id)
);

CREATE TABLE Orders(
    OrderID INT PRIMARY KEY AUTO_INCREMENT,                 -- Primray Key
    OrderDate DATE DEFAULT CURRENT_DATE(),                  -- Date of order
    UserID INT,                                             -- UserID, foreign key
    Total DOUBLE(9,2) DEFAULT 0.00,                         -- Total of order
    Notes VARCHAR(127),                                     -- Notes about order
    TrackingNum VARCHAR(31),                                -- Tracking number
    Status CHAR(10) DEFAULT 'Pending',                      -- Status of order
    FOREIGN KEY (UserID) REFERENCES User(UserID)
);

CREATE TABLE OrderDetails(
    RowID INT PRIMARY KEY AUTO_INCREMENT,                    -- Primary Key
    OrderID INT,                                         
    Price FLOAT(7),                                         -- Price of order
    QTYOrdered INT(100),                                    -- Quantity ordered
    UserID INT,                                             -- UserID, foreign key
    ItemID INT,
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (ItemID) REFERENCES Products(id)
);

CREATE TABLE Payment(
    PaymentID INT PRIMARY KEY AUTO_INCREMENT,         -- Primary Key
    CreditCardInfo BIGINT(16),                        -- Credit Card #
    PaymentAmount DOUBLE(9,2) DEFAULT 0.00,           -- Payment Amout
    UserID INT,
    OrderID INT,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID)
);

