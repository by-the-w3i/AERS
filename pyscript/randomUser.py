
from random import randint

num = randint(1, 10)
with open("/user/jiangw14/classweb/cse482-AERS/DB/userID_small.data", "r") as f:
    cnt = 0
    for line in f:
        if line=="\n":continue
        cnt += 1
        if cnt == num:
            print(line.strip())
