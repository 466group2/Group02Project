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
DROP TABLE IF EXISTS Products;

CREATE TABLE Products(
    PartNum INT PRIMARY KEY AUTO_INCREMENT,         -- Primary Key
    Name VARCHAR(127),                              -- Name of Product
    Description VARCHAR(127),                       -- Description of Product
    Price FLOAT(7),                                 -- Price of Product
    QTYAvailable INT(100)                           -- Available quantity
);

CREATE TABLE ShoppingCart(
    CartID INT PRIMARY KEY AUTO_INCREMENT,          -- Primray Key
    QTYRequested INT(100)                           -- Quanutiy requested
);

CREATE TABLE Payment(
    PaymentID INT PRIMARY KEY AUTO_INCREMENT,       -- Primary Key
    CreditCardInfo INT (15),                        -- Credit Card #
    PaymentAmount FLOAT(7)                          -- Payment Amout
);

CREATE TABLE User(
    UserID INT PRIMARY KEY AUTO_INCREMENT,          -- Primrary Key
    Notes VARCHAR(127),                             -- Notes about User
    Name VARCHAR(31),                               -- Name of user
    BillingAddress VARCHAR(255),                    -- Billing Address of User
    ShippingAddress VARCHAR(255),                   -- Shipping Address of User
    Phone INT(10),                                  -- Phone number of User
    Email VARCHAR(255)                              -- Email address of User
);

CREATE TABLE Orders(
    OrderID INT PRIMARY KEY AUTO_INCREMENT,                 -- Primray Key
    Notes VARCHAR(127),                                     -- Notes about order
    `Date` DATE,                                            -- Date of order
    Price FLOAT(7),                                         -- Price of order
    QTYOrdered INT(100),                                    -- Quantity ordered
    Status CHAR(6),                                         -- Status of order
    TrackingNum VARCHAR(31),                                -- Tracking number
    UserID INT,                                             -- UserID, foreign key
    FOREIGN KEY (UserID) REFERENCES User(UserID)
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
    PartNum INT,
    CartID INT,
    OrderID INT,
    PaymentID INT,
    PRIMARY KEY (PartNum, CartID, OrderID, PaymentID),          -- Primrary Key
    FOREIGN KEY (PartNum) REFERENCES Products(PartNum),
    FOREIGN KEY (CartID) REFERENCES ShoppingCart(CartID),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (PaymentID) REFERENCES Payment(PaymentID)
);

CREATE TABLE Added(
    PartNum INT,
    CartID INT,
    UserID INT,
    PRIMARY KEY (PartNum, CartID),                              -- Primary KEy
    FOREIGN KEY (PartNum) REFERENCES Products(PartNum),
    FOREIGN KEY (CartID) REFERENCES ShoppingCart(CartID),
    FOREIGN KEY (UserID) REFERENCES User(UserID)                -- Foreign Key
);