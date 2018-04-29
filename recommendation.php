<?php
require "site.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo System::headContent()?>
</head>

<body>

<?php echo System::presentNav("","active","")?>

<!-- Page Content -->
<div class="container">

    <header class="aers-header">
        <h1 class="display-6"><img src="src/circuit.png">Amazon Electronics Recommendation System</h1>
        <hr class="my-4">
        <?php echo $sys->showUserInfo()?>
    </header>

    <?php
    echo $sys->displayRecommendation("SVD", "The famous SVD algorithm, as popularized by Simon Funk during the Netflix Prize.");
    echo $sys->displayRecommendation("NMF", "A collaborative filtering algorithm based on Non-negative Matrix Factorization.");
    echo $sys->displayRecommendation("Baseline", "Algorithm predicting the baseline estimate for given user and item.");
    echo $sys->displayRecommendation("KNN-user-based", "A basic knn-user-based collaborative filtering algorithm (Only take 1% as trainset)");
    echo $sys->displayRecommendation("KNN-item-based", "A basic knn-item-based collaborative filtering algorithm (Only take 1% as trainset)");
    echo $sys->displayRecommendation("Random", "Algorithm predicting a random rating based on the distribution of the training set, which is assumed to be normal.");
    ?>

</div>
<!-- /.container -->

<?php echo System::footerContent()?>
</body>

</html>