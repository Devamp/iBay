"""
Python program to parse .json auction files and its data into a .csv file

Author: Devam Patel
Date: 11/13/2022
Class: CS434
"""

import json
import csv
from time import sleep
import re
from datetime import datetime


print("Notice: The parse runs quiet slow on the VM, building tblUsers and tblItems will take a moment. Please be patience.\n")
print("========== Beginning Parse ==========")
sleep(1)

"""
Create tblUsers
"""
print("Building tblUser.csv...")

csvUsers = open('tblUsers.csv', 'w')

# create csv writer linked to our csv file
userWriter = csv.writer(csvUsers)

# header flag
isHeader = True

# headers to user for tblUsers
userHeaders = ['UserID', 'Rating', 'Location', 'Country']

# user information stores as [userID, rating]
userIds = []

listIdx = 0

# helper list to remove users that are both sellers and bidders
sellerList = []

def getUserIds(item_data):
    global listIdx

    for item in item_data:
        
        # Get users that are sellers
        if item['Seller']['UserID'] not in sellerList:
            userIds.append([])
            userIds[listIdx].append(item['Seller']['UserID'])
            userIds[listIdx].append(item['Seller']['Rating'])
            userIds[listIdx].append(item['Location'])
            userIds[listIdx].append('')
            sellerList.append(item['Seller']['UserID'])
            listIdx += 1
            

        # Get users that are bidders
        if item['Bids'] != None:
            for x in range(len(item['Bids'])):

                if item['Bids'][x]['Bid']['Bidder']['UserID'] not in sellerList:
                    userIds.append([])

                    userIds[listIdx].append(
                        item['Bids'][x]['Bid']['Bidder']['UserID'])
                    userIds[listIdx].append(
                        item['Bids'][x]['Bid']['Bidder']['Rating'])

                    if 'Location' in item['Bids'][x]['Bid']['Bidder']:
                        userIds[listIdx].append(
                            item['Bids'][x]['Bid']['Bidder']['Location'])
                    else:
                        userIds[listIdx].append(' ')

                    if 'Country' in item['Bids'][x]['Bid']['Bidder']:
                        userIds[listIdx].append(
                            item['Bids'][x]['Bid']['Bidder']['Country'])
                    else:
                        userIds[listIdx].append(' ')
            
                    sellerList.append(item['Bids'][x]['Bid']['Bidder']['UserID'])

                    listIdx += 1
        


idx = 0
usersWritten = []

# loop through all of the items-x.json files and dump data into a csv file
for x in range(40):
    with open('./AuctionData/items-' + str(x) + '.json') as file:
        data = json.load(file)
        item_data = data['Items']

    getUserIds(item_data)

    for item in item_data:

        if isHeader:
            userWriter.writerow(userHeaders)
            isHeader = False

        # Writing data of CSV file

        if userIds[idx] not in usersWritten:
            userWriter.writerow(userIds[idx])
            usersWritten.append(userIds[idx])

        if idx < len(userIds)-1:
            idx += 1
            
    # Writing data of CSV file
    #for userTuple in userIds:
    #    if userTuple not in usersWritten:
    #        userWriter.writerow(userTuple)
    #        usersWritten.append(userTuple)



# close csv file
csvUsers.close()


"""
Create tblBids
"""

print("Building tblBids.csv...")

csvBids = open('tblBids.csv', 'w')

# create csv writer linked to our csv file
bidsWriter = csv.writer(csvBids)

# header flag
isHeader = True

# headers to user for tblUsers
bidsHeaders = ['BidID', 'UserID', 'ItemID', 'Time', 'Amount']

"""
Data conversion from valueIn = “$1,234.56” to 1234.56
"""


def amountConversion(valueIn):
    if valueIn == None or len(valueIn) == 0:
        return valueIn

    return re.sub(r'[^\d.]', '', valueIn)


"""
Data conversion from valueIn = Mon-DD-YY HH:MM:SS to YYYY-MM-DD HH:MM:SS
"""


def timeConversion(valueIn):
    MONTHS = {'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04', 'May': '05', 'Jun': '06',
              'Jul': '07', 'Aug': '08', 'Sep': '09', 'Oct': '10', 'Nov': '11', 'Dec': '12'}
    valueIn = valueIn.strip().split(' ')
    tok = valueIn[0].split('-')
    mnt = tok[0]
    if mnt in MONTHS:
        mnt = MONTHS[mnt]
    date = '20' + tok[2] + '-'
    date += mnt + '-' + tok[1]
    return date + ' ' + valueIn[1]


# helper counter variables and bidsList
bids = []
idxCounter = 0
bidsIDCounter = 1


def getBids(item_data):
    global idxCounter
    global bidsIDCounter

    for item in item_data:
        if item['Bids'] != None:

            # loop through array of bids
            for x in range(len(item['Bids'])):
                bids.append([])
                bids[idxCounter].append(bidsIDCounter)
                bids[idxCounter].append(
                    item['Bids'][x]['Bid']['Bidder']['UserID'])
                bids[idxCounter].append(
                    item['ItemID'])
                bids[idxCounter].append(datetime.strptime(timeConversion(item['Bids'][x]['Bid']['Time']), '%Y-%m-%d %H:%M:%S'))
                bids[idxCounter].append(amountConversion(
                    item['Bids'][x]['Bid']['Amount']))

                idxCounter += 1
                bidsIDCounter += 1


idxer = 0
bidsWritten = []
# loop through all of the items-x.json files and dump data into a csv file
for x in range(40):

    with open('./AuctionData/items-' + str(x) + '.json') as file:
        data = json.load(file)
        item_data = data['Items']

    getBids(item_data)

    for item in item_data:
        if isHeader:
            bidsWriter.writerow(bidsHeaders)
            isHeader = False

        # Writing data of CSV file
        if bids[idxer] not in bidsWritten:
            toWrite = [bids[idxer][0], bids[idxer]
                       [1], bids[idxer][2], bids[idxer][3],
                       bids[idxer][4]]
            bidsWriter.writerow(toWrite)
            bidsWritten.append(bids[idxer])

        if idxer < len(bids)-1:
            idxer += 1


# close csv file
csvBids.close()


"""
Create tblCategory
"""

print("Building tblCategory.csv...")

csvCategory = open('tblCategory.csv', 'w')

# create csv writer linked to our csv file
categoryWriter = csv.writer(csvCategory)

# header flag
isHeader = True

# headers to user for tblUsers
categoryHeaders = ['CategoryID', 'Name']


# Helper function to return list of unique categories
categoryList = [[]]
categorySeen = []
categoryIDCounter = 1
catIdxer = 0

# get unique list of categories


def getCategoryList(item_data):
    global catIdxer
    global categoryIDCounter

    for item in item_data:
        for category in item['Category']:
            if category not in categorySeen:
                categorySeen.append(category)

                categoryList.append([])
                categoryList[catIdxer].append(categoryIDCounter)
                categoryList[catIdxer].append(category)

                catIdxer += 1
                categoryIDCounter += 1


categoryWritten = []  # variable to store the categories that are written into csv
index = 0

# loop through all of the items-x.json files and dump data into a csv file
for x in range(40):
    with open('./AuctionData/items-' + str(x) + '.json') as file:
        data = json.load(file)
        item_data = data['Items']

    getCategoryList(item_data)

    for item in item_data:

        if isHeader:
            categoryWriter.writerow(categoryHeaders)
            isHeader = False

        # Writing data of CSV file
        if categoryList[index] != []:
            if categoryList[index][1] not in categoryWritten:
                toWrite = [categoryList[index][0], categoryList[index][1]]
                categoryWriter.writerow(toWrite)
                categoryWritten.append(categoryList[index])

        if (index < len(categoryList)-1):
            index += 1

# close csv file
csvCategory.close()


"""
Create tblItems
"""

print("Building tblItems.csv...")

csvItems = open('tblItems.csv', 'w')

# create csv writer linked to our csv file
itemsWriter = csv.writer(csvItems)

# header flag
isHeader = True

# headers to user for tblUsers
itemsHeader = ['ItemID',
               'ItemName',
               'Currently',
               'Buy_Price',
               'First_Bid',
               'Number_of_Bids',
               'Location',
               'Country',
               'Started',
               'Ends',
               'Seller',
               'Description']


# helper function to get categoryID from category
def getCategoryID(category):

    for c in categoryWritten:
        if c[1] == category:
            return c[0]


# helper function to get bidID from Bid object
def getBidID(currentBid):

    for bid in bidsWritten:
        if bid[1] == currentBid['Bid']['Bidder']['UserID']:
            return bid[0]

    return ''


# variables to store items found and indexing variable
items = []
itemIdx = 0

# get all uniqie items and store into items list (finds all permutations of category and bidders)


def getItems(item_data):
    global itemIdx

    for item in item_data:

        items.append([])
        items[itemIdx].append(item['ItemID'])
        items[itemIdx].append(item['Name'])
        items[itemIdx].append(amountConversion(item['Currently']))

        if "Buy_Price" in item:
            items[itemIdx].append(amountConversion(item['Buy_Price']))
        else:
            items[itemIdx].append(' ')
        
        items[itemIdx].append(amountConversion(item['First_Bid']))
        items[itemIdx].append(amountConversion(item['Number_of_Bids']))
        items[itemIdx].append(item['Location'])
        items[itemIdx].append(item['Country'])
        items[itemIdx].append(datetime.strptime(timeConversion(item['Started']), '%Y-%m-%d %H:%M:%S'))
        items[itemIdx].append(datetime.strptime(timeConversion(item['Ends']), '%Y-%m-%d %H:%M:%S'))
        items[itemIdx].append(item['Seller']['UserID'])
        items[itemIdx].append(item['Description'])

        itemIdx += 1


itemsWritten = []
itemIndex = 0
# loop through all of the items-x.json files and dump data into a csv file
for x in range(40):

    with open('./AuctionData/items-' + str(x) + '.json') as file:
        data = json.load(file)
        item_data = data['Items']

    getItems(item_data)

    for item in item_data:
        if isHeader:
            itemsWriter.writerow(itemsHeader)
            isHeader = False

        # Writing data of CSV file
        
        itemsWriter.writerow(items[itemIndex])
        itemsWritten.append(items[itemIndex][0])

        if itemIndex < len(items):
            itemIndex += 1

# close csv file
csvItems.close()



print("Building tblItemCategory.csv...")

csvItemsCategory = open('tblItemCategory.csv', 'w')

# create csv writer linked to our csv file
itemsCategoryWriter = csv.writer(csvItemsCategory)

# header flag
isHeader = True

# headers to user for tblUsers
itemCategoryHeader = ['ItemID',
               'CategoryID']


itemCat = []
itCatIdx = 0
def getItemCategory(item_data):
    global itCatIdx

    for item in item_data:

        for category in item['Category']:
            itemCat.append([])
            itemCat[itCatIdx].append(item['ItemID'])
            itemCat[itCatIdx].append(getCategoryID(category))

            itCatIdx += 1

    return itemCat

itemsCategoryWritten = []
itemCatIdx = 0
# loop through all of the items-x.json files and dump data into a csv file
for x in range(40):

    with open('./AuctionData/items-' + str(x) + '.json') as file:
        data = json.load(file)
        item_data = data['Items']

    getItemCategory(item_data)

    for item in item_data:
        if isHeader:
            itemsCategoryWriter.writerow(itemCategoryHeader)
            isHeader = False

        # Writing data of CSV file
        itemsCategoryWriter.writerow(itemCat[itemCatIdx])
        itemsCategoryWritten.append(itemCat[itemCatIdx][0])


        if itemCatIdx < len(items)-1:
            itemCatIdx += 1

csvItemsCategory.close()

print("\n")
print("========== Parsing Results ==========")
print("Items parsed: " + str(len(itemsWritten)))
print("Users parsed: " + str(len(usersWritten)))
print("Categories parsed: " + str(len(categoryWritten)))
print("ItemCategories parsed: " + str(len(itemsCategoryWritten)))
print("Bids parsed: " + str(len(bidsWritten)))

