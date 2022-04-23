/*
* Moses Mang
* CSCI 466 - 1
* Spring 2022
* Group Project
* Purpose: SQL file to create database for online store
*/

DROP TABLE IF EXISTS Products;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS Payment;
DROP TABLE IF EXISTS User;

CREATE TABLE Products(
    PartNum INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(127),
    Description VARCHAR(127),
    Price FLOAT(7),
    QTYAvailable INT(100)
);

CREATE TABLE ShoppingCart(
    CartID INT PRIMARY KEY AUTO_INCREMENT,
    QTYRequested INT(100)
);

CREATE TABLE Orders(
    OrderNum INT PRIMARY KEY AUTO_INCREMENT,
    Notes VARCHAR(127),
    `Date` DATE,
    Price FLOAT(7),
    QTYOrdered INT(100),
    Status CHAR(6),
    TrackingNum VARCHAR(31)
);

CREATE TABLE Payment(
    PaymentID INT PRIMARY KEY AUTO_INCREMENT,
    CreditCardInfo VARCHAR (15),
    PaymentAmount FLOAT(7)
);

CREATE TABLE User(
    UserID INT AUTO_INCREMENT,
    Notes VARCHAR(63),
    Name VARCHAR(31),
    BillingAddress VARCHAR(255),
    ShippingAddress VARCHAR(255),
    Phone INT(10),
    Email VARCHAR(255)
);

CREATE TABLE Employee(
    EmpID INT PRIMARY KEY,
    Role VARCHAR(127),
    FOREIGN KEY (EmpID) REFERENCES User(UserID)
);