LOAD DATA LOCAL INFILE 'products.csv'
INTO TABLE Products 
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
\! echo "loading products into product table"

LOAD DATA LOCAL INFILE 'armor.csv'
INTO TABLE Armors 
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
\! echo "loading armors"

LOAD DATA LOCAL INFILE 'meds.csv'
INTO TABLE Meds 
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
\! echo "loading meds"

LOAD DATA LOCAL INFILE 'food.csv'
INTO TABLE Foods 
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
\! echo "loading food"

LOAD DATA LOCAL INFILE 'sampleusers.csv'
INTO TABLE User 
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
\! echo "loading sample users"

LOAD DATA LOCAL INFILE 'sampleorders.csv'
INTO TABLE Orders 
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
\! echo "loading sample orders"

LOAD DATA LOCAL INFILE 'sampledetails.csv'
INTO TABLE OrderDetails 
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
\! echo "loading sample details"