select sum(Number_of_Bids) - Bid.numBids FROM tblItems, (Select count(*) as numBids from tblBids) Bid GROUP BY Bid.numBids;

