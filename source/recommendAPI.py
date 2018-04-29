import sys
import json
from surprise import dump


def recommand(model, user, n):
    n = int(n)
    f = open("PreprocessedData/userHistory.data", "r")
    uhistory = set(json.load(f)[user])
    f.close()

    f1 = open("PreprocessedData/productID.data", "r")
    items = set(item.strip() for item in f1.readlines())
    f1.close()

    testset = [(user, item, 0) for item in items - uhistory]

    algo = dump.load(model+'/model')[1]
    pred = algo.test(testset)
    scores = [(p.est, p.iid) for p in pred]
    # print(len(scores))

    return sorted(scores, reverse=True)[0:n]

print(recommand(sys.argv[1], sys.argv[2], sys.argv[3]))