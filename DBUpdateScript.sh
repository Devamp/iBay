query="

USE AuctionDatabase;

ALTER TABLE tblBids ADD CONSTRAINT bids_PK PRIMARY KEY (BidID);
ALTER TABLE tblUsers ADD CONSTRAINT users_PK PRIMARY KEY (UserID);
ALTER TABLE tblCategory ADD CONSTRAINT category_PK PRIMARY KEY (CategoryID);
ALTER TABLE tblItems ADD CONSTRAINT items_PK PRIMARY KEY (ItemID);


ALTER TABLE tblBids ADD CONSTRAINT bids_FK_users FOREIGN KEY (UserID) REFERENCES tblUsers(UserID);
ALTER TABLE tblBids ADD CONSTRAINT bids_FK_itemID FOREIGN KEY (ItemID) REFERENCES tblItems(ItemID);


ALTER TABLE tblItems ADD CONSTRAINT items_FK_seller FOREIGN KEY (Seller) REFERENCES tblUsers(UserID);

ALTER TABLE tblItemCategory ADD CONSTRAINT itemCategory_FK_ItemID FOREIGN KEY (ItemID) REFERENCES tblItems(ItemID);
ALTER TABLE tblItemCategory ADD CONSTRAINT itemCategory_FK_CategoryID FOREIGN KEY (CategoryID) REFERENCES tblCategory(CategoryID);



ALTER TABLE tblItems MODIFY COLUMN ItemName varchar(255) NOT NULL;
ALTER TABLE tblItems MODIFY COLUMN Currently decimal(13,2) NOT NULL;
ALTER TABLE tblItems MODIFY COLUMN First_Bid decimal(13,2) NOT NULL;
ALTER TABLE tblItems MODIFY COLUMN Number_of_Bids int NOT NULL;
ALTER TABLE tblItems MODIFY COLUMN Location varchar(255) NOT NULL;
ALTER TABLE tblItems MODIFY COLUMN Country varchar(255) NOT NULL;
ALTER TABLE tblItems MODIFY COLUMN Started datetime NOT NULL;
ALTER TABLE tblItems MODIFY COLUMN Ends datetime NOT NULL;
ALTER TABLE tblItems MODIFY COLUMN Seller varchar(255) NOT NULL;
ALTER TABLE tblItems MODIFY COLUMN Description text NOT NULL;
ALTER TABLE tblItems ADD CONSTRAINT checkPrices CHECK (ItemID > 0 AND Currently >= 0 AND First_Bid >= 0 AND Number_of_Bids >= 0);


ALTER TABLE tblCategory MODIFY COLUMN Name varchar(255) NOT NULL;
ALTER TABLE tblCategory ADD CONSTRAINT checkID CHECK (CategoryID > 0);

ALTER TABLE tblUsers MODIFY COLUMN Rating int NOT NULL;

ALTER TABLE tblBids MODIFY COLUMN UserID varchar(255) NOT NULL;
ALTER TABLE tblBids MODIFY COLUMN ItemID int NOT NULL;
ALTER TABLE tblBids MODIFY COLUMN Time datetime NOT NULL;
ALTER TABLE tblBids MODIFY COLUMN Amount decimal(13,2) NOT NULL;
ALTER TABLE tblBids ADD CONSTRAINT checkAmount CHECK (BidID > 0 AND Amount > 0.0);

ALTER TABLE tblItemCategory MODIFY COLUMN ItemID int NOT NULL;
ALTER TABLE tblItemCategory MODIFY COLUMN CategoryID int NOT NULL;
ALTER TABLE tblItemCategory ADD CONSTRAINT checkIDs CHECK (CategoryID > 0 AND ItemID > 0);



Delimiter //

START TRANSACTION;

CREATE TRIGGER newBidTrigger BEFORE INSERT ON tblBids FOR EACH ROW
	BEGIN
		SET @newTime = NEW.Time;
		SET @endTime = (SELECT Ends from tblItems WHERE tblItems.ItemID = NEW.ItemID);
		SET @currentAmount = (SELECT Currently FROM tblItems WHERE tblItems.ItemID = NEW.ItemID);
		
		IF @newTime < @endTime AND NEW.Amount > @currentAmount THEN
		
			UPDATE tblItems 
			SET tblItems.Number_of_Bids = tblItems.Number_of_Bids + 1, tblItems.Currently = NEW.Amount
			WHERE tblItems.ItemID = NEW.ItemID;
			
		ELSE
			SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'ERROR: verify bid time or bid amount';
	
		END IF;
	END;

COMMIT;

//



CREATE FULLTEXT INDEX idx_description ON tblItems (Description);
CREATE INDEX idx_category ON tblCategory (Name);
CREATE INDEX idx_seller ON tblItems (Seller);

ALTER TABLE tblUsers ADD Password varchar(255);



"

/usr/bin/mysql -u root -p --local_infile << EOF

$query

EOF

echo "Done."

