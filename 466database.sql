DROP TABLE IF EXISTS Products;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS User;

CREATE TABLE Products(
    PartNum INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(127),
    Description VARCHAR(127),
    ProductDetail VARCHAR(255),
    Price FLOAT(5),
    Customization VARCHAR(127)
);

CREATE TABLE Orders(
    OrderNum INT PRIMARY KEY AUTO_INCREMENT,
    Notes VARCHAR(127),
    `Date` DATE,
    Status CHAR(6)
);

CREATE TABLE User(
    UserID INT AUTO_INCREMENT,
    Name VARCHAR(31),
    ContactInfo VARCHAR(127),
    InternalNotes VARCHAR(127),
    OrderHistroy VARCHAR(256)
);