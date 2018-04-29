import sys
import json
from surprise import dump



def top3(model, testset, n):
    algo = dump.load(model+'/model')[1]
    pred = algo.test(testset)
    scores = [[p.est, p.iid] for p in pred]
    # print(len(scores))
    return sorted(scores, reverse=True)[0:n]


f1 = open("PreprocessedData/productID.data", "r")
items = set(item.strip() for item in f1.readlines())
f1.close()

result = {}
cnt = 0
for user in ["AD685ORUUQ018","A1EHFQIPRXEC8Q","A1XCRR76WSH0KA","ACQN6P2OLPMG9","A2S3VLETZTPZYS","A1A9M72MINQAJI","AU2BTPE4NPRRF","A2I9S3PXGL7D4A","AFN1L4WPOV13K","A2GQGQKTVW1JBH"]:
    f = open("PreprocessedData/userHistory.data", "r")
    uhistory = set(json.load(f)[user])
    f.close()
    testset = [(user, item, 0) for item in items - uhistory]
    for model in ["SVD", "NMF", "Baseline", "KNN-user-based", "KNN-item-based", "Random"]:
        output = top3(model, testset, 3)
        if user not in result:
            result[user] = {}
        result[user][model] = output
        cnt += 1
        print(int(cnt*1000/60)/10,"%")

with open("PreprocessedData/predictions.data", "w") as f:
    json.dump(result, f)
