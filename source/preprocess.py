import json
import re


def selectUsers(threshold):
    users = {}
    validUserCnt = 0

    with open("reviews_Electronics_5.json", "r") as f:
        for line in f:
            rid = json.loads(line)["reviewerID"]
            if rid not in users:
                users[rid] = 0
            users[rid]+=1

    with open("userID.data", "w") as f:
        for rid  in users:
            if users[rid] > threshold:
                validUserCnt += 1
                f.write(rid+"\n")
    print("# Total User:", len(users))
    print("# Valid User:", validUserCnt)

# selectUsers(5) # filter the user has > 5 reviews
# Total User: 192403
# Valid User: 133309



def getReviewData():
    users = []
    with open("userID.data", "r") as f:
        users = [user.strip() for user in f.readlines()]

    newf = open("reviews.json.data", "w")
    validCnt = 0
    totCnt = 0
    with open("reviews_Electronics_5.json", "r") as f:
        for line in f:
            totCnt += 1
            if json.loads(line)["reviewerID"] in users:
                newf.write(line + "\n")
                validCnt += 1

    newf.close()
    print("# Total Review:", totCnt)
    print("# Valid Review:", validCnt)

# getReviewData()
# Total Review: 1689188
# Valid Review: 1393718


def getTrainData():
    # build a csv file from reviews.json.data
    # userId(reviewerID), itemId(asin), rating
    train_file = open("train.data", "w")
    cnt = 0
    with open("reviews.json.data", "r") as f:
        for line in f:
            if line=="\n": continue
            data = json.loads(line)
            train_file.write(data["reviewerID"] + ",")
            train_file.write(data["asin"] + ",")
            train_file.write(str(data["overall"]) + "\n")
            cnt += 1
            print(cnt)
    train_file.close()
    print("# Total Line:", cnt)

# getTrainData()
# Total Line: 1393718



def getProductData():
    uhistory = {}
    products = set()
    with open("train.data", "r") as f:
        for line in f:
            if line=="\n": continue
            user, item, rating = line.strip().split(',')
            products.add(item)
            if user not in uhistory:
                uhistory[user] = set()
            uhistory[user].add(item)

    with open("productID.data", "w") as f:
        for pid in products:
            f.write(pid + "\n")

    for user in uhistory:
        uhistory[user] = list(uhistory[user])

    with open("userHistory.data", "w") as f:
        json.dump(uhistory, f)

    print("# Total Products:", len(products))
    print("# Total users:", len(uhistory))

# getProductData()
# Total Products: 62997
# Total users: 133309


def getProductInfo():
    bigdic = {}
    pids = set()
    cnt = 0
    pcnt = 0
    with open("productID.data", "r") as f:
        for line in f:
            pcnt += 1
            pids.add(line.strip())
        print(pcnt)

    with open("output.strict", "r") as f:
        for line in f:
            pjson = json.loads(line)
            pid = pjson["asin"]
            if pid in pids:
                if pid not in bigdic:
                    bigdic[pid] = {}
                    if "title" in pjson:
                        bigdic[pid]["title"] = pjson["title"]
                    if "price" in pjson:
                        bigdic[pid]["price"] = pjson["price"]
                    if "imUrl" in pjson:
                        bigdic[pid]["imUrl"] = pjson["imUrl"]
                    cnt += 1
                    print(cnt)
            if pcnt == cnt:
                break

    with open("productInfo.data", "w") as f:
        json.dump(bigdic, f)

    print("# Total Product:", pcnt)
    print("# Processed Product Info:", cnt)

# getProductInfo()
# Total Product: 62997
# Processed Product Info: 62997



def getUserItemTable():
    """
        ITEM1   ITEM2   ITEM3   ...
    USER1
    USER2
    USER3
    .
    .
    .

    return CSV file
    """
    table = {}
    cnt = 0
    with open("train.data", "r") as f:
        for line in f:
            data = line.strip().split(',')
            user = data[0]
            item = data[1]
            rating = data[2]
            if user not in table:
                table[user] = {}
            table[user][item] = rating
            cnt += 1

    items = []
    with open("productID.data", "r") as f:
        items = [item.strip() for item in f.readlines()]

    users = []
    with open("userID.data", "r") as f:
        users = [user.strip() for user in f.readlines()]

    ucnt = 0
    with open("userItemTable.data", "w") as f:
        for user in users:
            for item in items:
                if item in table[user]:
                    f.write(table[user][item])
                if item != items[-1]:
                    f.write(",")
                else:
                    f.write("\n")
            ucnt += 1
            print("Process: {:.2f}%".format(ucnt*100/len(users)))

    print("# Processed Reviews:", cnt)
    print("# Processed Users:", len(users))
    print("# Processed Items:", len(items))


# getUserItemTable()
# Processed Reviews: 1393718
# Processed Users: 133309
# Processed Items: 62997


def getReviewInfo():
    # userbased : list revirews, huge json
    info = {}
    cnt = 0
    procedure = 0
    with open("reviews.json.data", "r") as f:
        for line in f:
            if line=="\n": continue
            data = json.loads(line)
            reviewID = data["reviewerID"]
            if reviewID not in info:
                info[reviewID] = []
            info[reviewID].append(data)
            cnt += 1
            cur = int(cnt*1000/1393718)
            if cur > procedure:
                procedure = cur
                print("{}%".format(procedure/10))

    print("Start Writing ...")
    with open("reviewInfo.data", "w") as f:
        json.dump(info, f)

# getReviewInfo()






# for website
def getSmallReviewJson():
    users = set([
"AD685ORUUQ018",
"A1EHFQIPRXEC8Q",
"A1XCRR76WSH0KA",
"ACQN6P2OLPMG9",
"A2S3VLETZTPZYS",
"A1A9M72MINQAJI",
"AU2BTPE4NPRRF",
"A2I9S3PXGL7D4A",
"AFN1L4WPOV13K",
"A2GQGQKTVW1JBH"])
    cnt = 0
    procedure = 0
    nf = open("reviews_small.json.data", "w")
    with open("reviews.json.data", "r") as f:
        for line in f:
            if line=="\n": continue
            data = json.loads(line)
            if data["reviewerID"] in users:
                nf.write(line.strip()+"\n")
            cnt += 1
            cur = int(cnt*1000/1393718)
            if cur > procedure:
                procedure = cur
                print(procedure/10, "%")
    nf.close()



# getSmallReviewJson()















