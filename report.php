<?php
require "System.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo System::headContent()?>
    <link rel="stylesheet"
          href="css/agate.css">
    <script src="js/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <script src="js/echarts.min.js"></script>
</head>

<body>

<?php echo System::presentNav("","","active")?>

<!-- Page Content -->
<div class="container">
    <header class="aers-header">
        <h1 class="display-6" style="text-align: center">AERS Report</h1>
        <hr class="my-4">
    </header>
</div>
<!-- /.container -->

<div class="container">
    <h2>Data collection and preprocessing</h2>
    <div id="accordion" class="card-block">
        <div class="card">
            <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <h5 class="mb-0">
                    <button class="btn btn-link">
                        Raw Electronics Review Data: <span class="badge badge-secondary">reviews_Electronics_5.json</span> (1.48 GB) <span class="badge badge-secondary">metadata.json</span> (10.54 GB)
                        <i class="far fa-caret-square-down"></i>
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <a href="http://jmcauley.ucsd.edu/data/amazon/">Source Data</a>
                    <pre>
reviews_Electronics_5.json Sample:
                        <code class="json">
{
  "reviewerID": "A2SUAM1J3GNN3B",
  "asin": "0000013714",
  "reviewerName": "J. McDonald",
  "helpful": [2, 3],
  "reviewText": "I bought this for my husband who plays the piano.  He is having a wonderful time playing these old hymns.  The music  is at times hard to read because we think the book was published for singing from more than playing from.  Great purchase though!",
  "overall": 5.0,
  "summary": "Heavenly Highway Hymns",
  "unixReviewTime": 1252800000,
  "reviewTime": "09 13, 2009"
}
                            </code>
                    </pre>
                    <pre>
metadata.json Sample:
                        <code class="json">
{
  "asin": "0000031852",
  "title": "Girls Ballet Tutu Zebra Hot Pink",
  "price": 3.17,
  "imUrl": "http://ecx.images-amazon.com/images/I/51fAmVkTbyL._SY300_.jpg",
  "related":
  {
    "also_bought": ["B00JHONN1S", "B002BZX8Z6", "B00D2K1M3O", "0000031909", "B00613WDTQ", "B00D0WDS9A", "B00D0GCI8S", "0000031895", "B003AVKOP2", "B003AVEU6G", "B003IEDM9Q", "B002R0FA24", "B00D23MC6W", "B00D2K0PA0", "B00538F5OK", "B00CEV86I6", "B002R0FABA", "B00D10CLVW", "B003AVNY6I", "B002GZGI4E", "B001T9NUFS", "B002R0F7FE", "B00E1YRI4C", "B008UBQZKU", "B00D103F8U", "B007R2RM8W"],
    "also_viewed": ["B002BZX8Z6", "B00JHONN1S", "B008F0SU0Y", "B00D23MC6W", "B00AFDOPDA", "B00E1YRI4C", "B002GZGI4E", "B003AVKOP2", "B00D9C1WBM", "B00CEV8366", "B00CEUX0D8", "B0079ME3KU", "B00CEUWY8K", "B004FOEEHC", "0000031895", "B00BC4GY9Y", "B003XRKA7A", "B00K18LKX2", "B00EM7KAG6", "B00AMQ17JA", "B00D9C32NI", "B002C3Y6WG", "B00JLL4L5Y", "B003AVNY6I", "B008UBQZKU", "B00D0WDS9A", "B00613WDTQ", "B00538F5OK", "B005C4Y4F6", "B004LHZ1NY", "B00CPHX76U", "B00CEUWUZC", "B00IJVASUE", "B00GOR07RE", "B00J2GTM0W", "B00JHNSNSM", "B003IEDM9Q", "B00CYBU84G", "B008VV8NSQ", "B00CYBULSO", "B00I2UHSZA", "B005F50FXC", "B007LCQI3S", "B00DP68AVW", "B009RXWNSI", "B003AVEU6G", "B00HSOJB9M", "B00EHAGZNA", "B0046W9T8C", "B00E79VW6Q", "B00D10CLVW", "B00B0AVO54", "B00E95LC8Q", "B00GOR92SO", "B007ZN5Y56", "B00AL2569W", "B00B608000", "B008F0SMUC", "B00BFXLZ8M"],
    "bought_together": ["B002BZX8Z6"]
  },
  "salesRank": {"Toys & Games": 211836},
  "brand": "Coxlures",
  "categories": [["Sports & Outdoors", "Other Sports", "Dance"]]
}
                        </code>
                    </pre>
                </div>
            </div>
        </div>

        <div class="card" >
            <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed">
                        <span class="badge badge-secondary">reviews_Electronics_5.json</span> (1.48 GB)
                        <i class="fas fa-arrow-right"></i>
                        <span class="badge badge-secondary">userID.data</span> (2 MB)
                        <span class="badge badge-secondary">reviews.json.data</span> (1.26 GB)
                        <span class="badge badge-secondary">train.data</span> (41.4 MB)
                        <i class="far fa-caret-square-down"></i>
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <pre>
                        <code data-lang="python">#
# filter the user has more than 5 reviews
#
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
                        </code>
                    </pre>

                    <div class="output">
                        <h5>output</h5>
                        <p>Total User: 192403</p>
                        <p>Valid User: 133309</p>
                    </div>

                    <pre><code data-lang="python">#
# reduce reviews_Electronics_5.json to reviews.json.data based on the userID.data
#
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
                        </code>
                    </pre>
                    <div class="output">
                        <h5>output</h5>
                        <p>Total Review: 1689188</p>
                        <p>Valid Review: 1393718</p>
                    </div>


                    <pre><code data-lang="python">
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

                        </code>
                    </pre>
                    <div class="output">
                        <h5>output</h5>
                        <p>Total Line: 1393718</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="card" >
            <div class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed">
                        <span class="badge badge-secondary">metadata.json</span> (10.54 GB)
                        <i class="fas fa-arrow-right"></i>
                        <span class="badge badge-secondary">productID.data</span> (693 KB)
                        <span class="badge badge-secondary">productInfo.data</span> (12.5 MB)
                        <i class="far fa-caret-square-down"></i>
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">


                    <pre><code data-lang="python"> # Get all product ID
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

                        </code>
                    </pre>
                    <div class="output">
                        <h5>output</h5>
                        <p>Total Products: 62997<p>
                        <p>Total users: 133309</p>
                    </div>


                    <pre><code data-lang="python"> # Store all the product info as json file
# dictionary key is asin
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
                        </code>
                    </pre>
                    <div class="output">
                        <h5>output</h5>
                        <p>Total Product: 62997<p>
                        <p>Processed Product Info: 62997</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="datareport" class="egraph"></div>



    <h2>Model building and evaluation</h2>
    <div id="accordion" class="card-block">

        <div class="card">
            <div class="card-header"  data-toggle="collapse" data-target="#SVD" aria-expanded="true" aria-controls="SVD">
                <h5 class="mb-0">
                    <button class="btn btn-link">
                        <span class="badge badge-info">SVD</span>: The famous SVD algorithm, as popularized by Simon Funk during the Netflix Prize.
                        <i class="far fa-caret-square-down"></i>
                    </button>
                </h5>
            </div>

            <div id="SVD" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <button class="model-b">Build Model</button>
                    <pre>
                        <code class="python">
from surprise import Dataset
from surprise import Reader
from surprise import SVD
from surprise import dump

def train():
    reader = Reader(line_format='user item rating', sep=',')
    data = Dataset.load_from_file('../PreprocessedData/train.data', reader=reader)

    trainset = data.build_full_trainset()

    algo = SVD()
    algo.fit(trainset)

    dump.dump('./model', algo=algo, verbose=1)

train()
                        </code>
                    </pre>
                    <button class="model-e">Model Evaluation</button>
                    <p>Evaluating RMSE, MAE of algorithm SVD on 5 split(s).</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Fold 1</th>
                            <th scope="col">Fold 2</th>
                            <th scope="col">Fold 3</th>
                            <th scope="col">Fold 4</th>
                            <th scope="col">Fold 5</th>
                            <th scope="col">Mean</th>
                            <th scope="col">Std</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">RMSE (testset)</th>
                            <td>1.0882</td>
                            <td>1.0904</td>
                            <td>1.0861</td>
                            <td>1.0923</td>
                            <td>1.0900</td>
                            <td>1.0894</td>
                            <td>0.0021</td>
                        </tr>
                        <tr>
                            <th scope="row">MAE (testset)</th>
                            <td>0.8063</td>
                            <td>0.8085</td>
                            <td>0.8051</td>
                            <td>0.8094</td>
                            <td>0.8073</td>
                            <td>0.8073</td>
                            <td>0.0015</td>
                        </tr>
                        <tr>
                            <th scope="row">Fit time</th>
                            <td>83.23</td>
                            <td>83.74</td>
                            <td>83.03</td>
                            <td>83.52</td>
                            <td>83.95</td>
                            <td>83.49</td>
                            <td>0.33</td>
                        </tr>
                        <tr>
                            <th scope="row">Test time</th>
                            <td>4.13</td>
                            <td>3.51</td>
                            <td>3.93</td>
                            <td>3.80</td>
                            <td>3.49</td>
                            <td>3.77</td>
                            <td>0.24</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <div class="card">
            <div class="card-header" data-toggle="collapse" data-target="#NMF" aria-expanded="true" aria-controls="NMF">
                <h5 class="mb-0">
                    <button class="btn btn-link">
                        <span class="badge badge-info">NMF</span>: A collaborative filtering algorithm based on Non-negative Matrix Factorization.
                        <i class="far fa-caret-square-down"></i>
                    </button>
                </h5>
            </div>

            <div id="NMF" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <button class="model-b">Build Model</button>
                    <pre>
                        <code class="python">
from surprise import Dataset
from surprise import Reader
from surprise import NMF
from surprise import dump


def train():
    reader = Reader(line_format='user item rating', sep=',')
    data = Dataset.load_from_file('../PreprocessedData/train.data', reader=reader)

    trainset = data.build_full_trainset()

    algo = NMF(n_factors=20, n_epochs=200, random_state=1)
    algo.fit(trainset)


    dump.dump('./model', algo=algo, verbose=1)

train()
                        </code>
                    </pre>
                    <button class="model-e">Model Evaluation</button>
                    <p>Evaluating RMSE, MAE of algorithm NMF on 5 split(s).</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Fold 1</th>
                            <th scope="col">Fold 2</th>
                            <th scope="col">Fold 3</th>
                            <th scope="col">Fold 4</th>
                            <th scope="col">Fold 5</th>
                            <th scope="col">Mean</th>
                            <th scope="col">Std</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">RMSE (testset)</th>
                            <td>1.2482</td>
                            <td>1.2500</td>
                            <td>1.2514</td>
                            <td>1.2519</td>
                            <td>1.2480</td>
                            <td>1.2499</td>
                            <td>0.0016</td>
                        </tr>
                        <tr>
                            <th scope="row">MAE (testset)</th>
                            <td>0.9617</td>
                            <td>0.9628</td>
                            <td>0.9638</td>
                            <td>0.9642</td>
                            <td>0.9620</td>
                            <td>0.9629</td>
                            <td>0.0010</td>
                        </tr>
                        <tr>
                            <th scope="row">Fit time</th>
                            <td>533.69</td>
                            <td>516.64</td>
                            <td>517.18</td>
                            <td>518.09</td>
                            <td>515.83</td>
                            <td>520.29</td>
                            <td>6.74</td>
                        </tr>
                        <tr>
                            <th scope="row">Test time</th>
                            <td>3.41</td>
                            <td>2.99</td>
                            <td>3.44</td>
                            <td>3.00</td>
                            <td>3.01</td>
                            <td>3.17</td>
                            <td>0.21</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header" data-toggle="collapse" data-target="#Baseline" aria-expanded="true" aria-controls="Baseline">
                <h5 class="mb-0">
                    <button class="btn btn-link">
                        <span class="badge badge-info">Baseline</span>: Algorithm predicting the baseline estimate for given user and item.
                        <i class="far fa-caret-square-down"></i>
                    </button>
                </h5>
            </div>

            <div id="Baseline" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <button class="model-b">Build Model</button>
                    <pre>
                        <code class="python">
from surprise import Dataset
from surprise import Reader
from surprise import BaselineOnly
from surprise import dump

def train():
    reader = Reader(line_format='user item rating', sep=',')
    data = Dataset.load_from_file('../raw_data/train.data', reader=reader)

    trainset = data.build_full_trainset()

    algo = BaselineOnly()
    algo.fit(trainset)

    dump.dump('./model', algo=algo, verbose=1)

train()
                        </code>
                    </pre>
                    <button class="model-e">Model Evaluation</button>
                    <p>Evaluating RMSE, MAE of algorithm BaselineOnly on 5 split(s).</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Fold 1</th>
                            <th scope="col">Fold 2</th>
                            <th scope="col">Fold 3</th>
                            <th scope="col">Fold 4</th>
                            <th scope="col">Fold 5</th>
                            <th scope="col">Mean</th>
                            <th scope="col">Std</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">RMSE (testset)</th>
                            <td>1.0857</td>
                            <td>1.0853</td>
                            <td>1.0880</td>
                            <td>1.0856</td>
                            <td>1.0852</td>
                            <td>1.0860</td>
                            <td>0.0011</td>
                        </tr>
                        <tr>
                            <th scope="row">MAE (testset)</th>
                            <td>0.8155</td>
                            <td>0.8140</td>
                            <td>0.8161</td>
                            <td>0.8155</td>
                            <td>0.8155</td>
                            <td>0.8153</td>
                            <td>0.0007</td>
                        </tr>
                        <tr>
                            <th scope="row">Fit time</th>
                            <td>5.12</td>
                            <td>5.40</td>
                            <td>5.23</td>
                            <td>5.29</td>
                            <td>5.22</td>
                            <td>5.25</td>
                            <td>0.09</td>
                        </tr>
                        <tr>
                            <th scope="row">Test time</th>
                            <td>2.97</td>
                            <td>3.33</td>
                            <td>2.62</td>
                            <td>3.01</td>
                            <td>2.97</td>
                            <td>2.98</td>
                            <td>0.22</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header" data-toggle="collapse" data-target="#KNN-user-based" aria-expanded="true" aria-controls="KNN-user-based">
                <h5 class="mb-0">
                    <button class="btn btn-link">
                        <span class="badge badge-info">KNN-user-based</span>: Algorithm predicting the KNN-user-based estimate for given user and item.
                        <i class="far fa-caret-square-down"></i>
                    </button>
                </h5>
            </div>

            <div id="KNN-user-based" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <button class="model-b">Build Model</button>
                    <pre>
                        <code class="python">
from surprise import Dataset
from surprise import Reader
from surprise import KNNBaseline
from surprise import dump
from surprise.model_selection import train_test_split

def train():
    reader = Reader(line_format='user item rating', sep=',')
    data = Dataset.load_from_file('../PreprocessedData/train.data', reader=reader)

    trainset, testset = train_test_split(data, test_size=.99, random_state=1)

    sim_options = {'name': 'pearson_baseline', 'user_based': True}
    algo = KNNBaseline(k=10, sim_options=sim_options)
    algo.fit(trainset)

    dump.dump('./model', algo=algo, verbose=1)

train()
                        </code>
                    </pre>
                    <button class="model-e">Model Evaluation</button>
                    <p>Evaluating RMSE, MAE of algorithm KNN-user-based on 1% data as trasinset and another 1% data as testset.</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">RMSE</th>
                            <th scope="col">MAE</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1.1514</td>
                            <td>0.8909</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header" data-toggle="collapse" data-target="#KNN-item-based" aria-expanded="true" aria-controls="KNN-item-based">
                <h5 class="mb-0">
                    <button class="btn btn-link">
                        <span class="badge badge-info">KNN-item-based</span>: Algorithm predicting the KNN-item-based estimate for given user and item.
                        <i class="far fa-caret-square-down"></i>
                    </button>
                </h5>
            </div>

            <div id="KNN-item-based" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <button class="model-b">Build Model</button>
                    <pre>
                        <code class="python">
from surprise import Dataset
from surprise import Reader
from surprise import KNNBaseline
from surprise import dump
from surprise.model_selection import train_test_split

def train():
    reader = Reader(line_format='user item rating', sep=',')
    data = Dataset.load_from_file('../PreprocessedData/train.data', reader=reader)

    trainset, testset = train_test_split(data, test_size=.99, random_state=1)

    sim_options = {'name': 'pearson_baseline', 'user_based': False}
    algo = KNNBaseline(k=10, sim_options=sim_options)
    algo.fit(trainset)

    dump.dump('./model', algo=algo, verbose=1)

train()
                        </code>
                    </pre>
                    <button class="model-e">Model Evaluation</button>
                    <p>Evaluating RMSE, MAE of algorithm KNN-item-based on 1% data as trasinset and another 1% data as testset.</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">RMSE</th>
                            <th scope="col">MAE</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1.1514</td>
                            <td>0.8909</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card" >
            <div class="card-header" data-toggle="collapse" data-target="#Random" aria-expanded="true" aria-controls="Random">
                <h5 class="mb-0">
                    <button class="btn btn-link">
                        <span class="badge badge-info">Random</span>: Algorithm predicting a random rating.
                        <i class="far fa-caret-square-down"></i>
                    </button>
                </h5>
            </div>

            <div id="Random" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <button class="model-b">Build Model</button>
                    <pre>
                        <code class="python">
from surprise import Dataset
from surprise import Reader
from surprise import NormalPredictor
from surprise import dump

def train():
    reader = Reader(line_format='user item rating', sep=',')
    data = Dataset.load_from_file('../PreprocessedData/train.data', reader=reader)

    trainset = data.build_full_trainset()

    algo = NormalPredictor()
    algo.fit(trainset)

    dump.dump('./model', algo=algo, verbose=1)

train()
                        </code>
                    </pre>
                    <button class="model-e">Model Evaluation</button>
                    <p>Evaluating RMSE, MAE of algorithm NormalPredictor on 5 split(s).</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Fold 1</th>
                            <th scope="col">Fold 2</th>
                            <th scope="col">Fold 3</th>
                            <th scope="col">Fold 4</th>
                            <th scope="col">Fold 5</th>
                            <th scope="col">Mean</th>
                            <th scope="col">Std</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">RMSE (testset)</th>
                            <td>1.5010</td>
                            <td>1.5026</td>
                            <td>1.5038</td>
                            <td>1.5047</td>
                            <td>1.5012</td>
                            <td>1.5026</td>
                            <td>0.0015</td>
                        </tr>
                        <tr>
                            <th scope="row">MAE (testset)</th>
                            <td>1.1187</td>
                            <td>1.1193</td>
                            <td>1.1209</td>
                            <td>1.1217</td>
                            <td>1.1183</td>
                            <td>1.1198</td>
                            <td>0.0013</td>
                        </tr>
                        <tr>
                            <th scope="row">Fit time</th>
                            <td>2.57</td>
                            <td>2.55</td>
                            <td>2.55</td>
                            <td>2.75</td>
                            <td>2.58</td>
                            <td>2.60</td>
                            <td>0.08</td>
                        </tr>
                        <tr>
                            <th scope="row">Test time</th>
                            <td>4.19</td>
                            <td>3.03</td>
                            <td>3.73</td>
                            <td>3.75</td>
                            <td>4.16</td>
                            <td>3.77</td>
                            <td>0.42</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div id="compare" class="egraph"></div>


    <h2>Recommendation API</h2>
    <div class="alert alert-success" role="alert">
        We also provide the recommend code and models for you to run on local.
        <hr/>
        Download the <a href="http://webdev.cse.msu.edu/~jiangw14/cse482-AERS/BigDataAnalysis/"> Preprocessed data</a>
    </div>
    <pre>
        <code class="bash">
$ python3 recommendAPI.py NMF A1QJDY7QVILLJ7 3

> [(4.919113222520594, 'B0076NA716'), (4.765648060115675, 'B001GDEM5O'), (4.683369893962228, 'B00003CWG2')]
        </code>
    </pre>



    <h2>Useful links</h2>
    <p><i class="fas fa-link"></i><a href="http://surprise.readthedocs.io/en/stable/"> Python scikit-surprise docs</a></p>
    <p><i class="fas fa-laptop"></i><a href="http://webdev.cse.msu.edu/~jiangw14/cse482-AERS/"> Web Interface Demo</a></p>
    <p><i class="fab fa-github-alt"></i><a href="https://github.com/by-the-w3i/AERS/"> Github</a></p>
    <p><i class="fas fa-database"></i><a href="http://webdev.cse.msu.edu/~jiangw14/cse482-AERS/BigDataAnalysis/"> Preprocessed data</a></p>
    <p><i class="fas fa-cloud-download-alt"></i><a href="http://webdev.cse.msu.edu/~jiangw14/cse482-AERS/FinalReport.pdf"> Download Report</a></p>


    <h2>References</h2>
    <p>[1] R. He, J. McAuley. Modeling the visual evolution of fashion trends with one-class collaborative filtering. WWW, 2016</p>
    <p>[2] J. McAuley, C. Targett, J. Shi, A. van den Hengel. Image-based recommendations on styles and substitutes. SIGIR, 2015</p>

</div>
<script>
    option = {
        title : {
            text: 'Data Collection',
            subtext: '133,309 Users + 62,997 Items + 1,393,718 Reviews',
            x:'center'

        },
        tooltip : {
            trigger: 'item',
            formatter: "{b} <br/>{c}"
        },
        legend: {
            x : 'center',
            y : '90%',
            data:['Users','Items','Reviews']
        },
        toolbox: {
            right: 20,
            show : true,
            feature : {
                saveAsImage : {
                    title: "Download",
                    show: true
                }
            }
        },
        calculable : true,
        series : [
            {
                type:'pie',
                radius : [50, 200],
                center : ['50%', '50%'],
                roseType : 'area',
                data:[
                    {value:133309, name:'Users'},
                    {value:62997, name:'Items'},
                    {value:1393718, name:'Reviews'}
                ]
            }
        ],
        color:['#64C5FF','#FFCE0D', '#FFBAFE']
    };

    var dataChart = echarts.init(document.getElementById("datareport"));
    dataChart.setOption(option);


    option2 = {
        title: {
            text: 'Evaluating RMSE, MAE of different algorithms',
            subtext: '133,309 Users + 62,997 Items + 1,393,718 Reviews',
            x:'center'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        toolbox: {
            right: 20,
            show : true,
            feature : {
                saveAsImage : {
                    title: "Download",
                    show: true,
                }
            }
        },
        legend: {
            top: '10%',
            data: ['RMSE', 'MAE']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            top: '15%',
            containLabel: true
        },
        xAxis: {
            type: 'value'
        },
        yAxis: {
            type: 'category',
            data: ["SVD", "NMF", "Baseline", "KNN-user-based", "KNN-item-based", "Random"]
        },
        series:[
            {
                name: 'RMSE',
                type: 'bar',
                barMaxWidth: 25,
                data: [1.0894, 1.2499, 1.0860, 1.1514, 1.1514, 1.5026]
            },
            {
                name: 'MAE',
                type: 'bar',
                barMaxWidth: 25,
                data: [0.8073, 0.9629, 0.8153, 0.8909, 0.8909, 1.1198]
            }
        ],
        color:['#64c5ff','#fff326']
    };

    var compareChart = echarts.init(document.getElementById("compare"));
    compareChart.setOption(option2);
</script>
<?php echo System::footerContent()?>
</body>

</html>