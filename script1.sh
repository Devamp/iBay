

echo Connecting to mysql...

query="DROP DATABASE IF EXISTS AuctionDatabase;
CREATE DATABASE AuctionDatabase;
USE AuctionDatabase;

SET GLOBAL local_infile=1;

CREATE TABLE tblBids (
BidID int,
UserID varchar(255),
ItemID int,
Time DATETIME,
Amount DECIMAL(13,2)
);

load data local infile '~/Desktop/Asst2/tblBids.csv'
into table tblBids
fields terminated by ','
enclosed by '\"'
lines terminated by '\r\n'
ignore 1 rows;



CREATE TABLE tblCategory (
CategoryID int,
Name varchar(255)
);

load data local infile '~/Desktop/Asst2/tblCategory.csv'
into table tblCategory
fields terminated by ','
enclosed by '\"'
lines terminated by '\r\n'
ignore 1 rows;



CREATE TABLE tblUsers (
UserID varchar(255),
Rating int,
Location varchar(255),
Country varchar(255)
);

load data local infile '~/Desktop/Asst2/tblUsers.csv'
into table tblUsers
fields terminated by ','
enclosed by '\"'
lines terminated by '\r\n'
ignore 1 rows;



CREATE TABLE tblItems (
ItemID int,
ItemName varchar(255),
Currently decimal(13,2),
Buy_Price decimal(13,2),
First_Bid decimal(13,2),
Number_of_Bids int,
Location varchar(255),
Country varchar(255),
Started datetime,
Ends datetime,
Seller varchar(255),
Description longtext
); 

load data local infile '~/Desktop/Asst2/tblItems.csv'
into table tblItems
fields terminated by ','
enclosed by '\"'
lines terminated by '\r\n'
ignore 1 rows;



CREATE TABLE tblItemCategory (
ItemID int,
CategoryID int
);


load data local infile '~/Desktop/Asst2/tblItemCategory.csv'
into table tblItemCategory
fields terminated by ','
enclosed by '\"'
lines terminated by '\r\n'
ignore 1 rows;

SELECT COUNT(tblUsers.UserID) AS totalUsers FROM tblUsers;
SELECT COUNT(tblItems.ItemID) AS totalItems FROM tblItems;
SELECT COUNT(tblCategory.CategoryID) AS totalCategories FROM tblCategory;
SELECT COUNT(tblBids.BidID) AS totalBids FROM tblBids;
SELECT COUNT(tblItemCategory.CategoryID) AS totalItemCategories FROM tblItemCategory;
"

/usr/bin/mysql -u root -p --local_infile << EOF

$query

EOF

echo "Done."


