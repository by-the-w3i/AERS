import json
from surprise import Dataset
from surprise import Reader
from surprise import dump
from surprise import accuracy
from surprise.model_selection import cross_validate
from surprise.model_selection import train_test_split


# load data
reader = Reader(line_format='user item rating', sep=',')
data = Dataset.load_from_file('PreprocessedData/train.data', reader=reader)
_, testset= train_test_split(data, test_size=.01, random_state=2)


for model in ["SVD", "NMF", "Baseline", "KNN-user-based", "KNN-item-based", "Random"]:
# for model in ["KNN-user-based", "KNN-item-based", "Random"]:
    # load algorithm
    algo = dump.load(model+'/model')[1]

    # Run 5-fold cross-validation and print results.
    if "KNN" in model:
        predictions = algo.test(testset)
        print(model)
        print(accuracy.rmse(predictions), accuracy.mae(predictions))
    else:
        cross_validate(algo, data, measures=['RMSE', 'MAE'], cv=5, verbose=True)
