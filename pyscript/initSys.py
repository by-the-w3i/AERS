
import sys
import json

uid = sys.argv[1]
result = {}
with open("/user/jiangw14/classweb/cse482-AERS/DB/reviews_small.json.data") as f:
    for line in f:
        if line=="\n": continue
        data = json.loads(line)
        if data["reviewerID"] == uid:
            result[data["asin"]] = data
    print(json.dumps(result))