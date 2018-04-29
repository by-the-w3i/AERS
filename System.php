<?php
/**
 * Created by PhpStorm.
 * User: Jevin
 * Date: 4/27/18
 * Time: 5:13 PM
 */

class System
{

    public static function headContent() {
        $html = <<<HTML
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Amazon Electronics Recommendation System">
<meta name="author" content="bythew3i">

<title>AERS</title>

<link rel="icon" type="image/png" sizes="32x32" href="src/favicon-32x32.png">

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
<link href="css/jquery.loading.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/3-col-portfolio.css" rel="stylesheet">
<link href="css/aers.css" rel="stylesheet">
HTML;
        return $html;
    }


    public static function presentNav($opt1, $opt2, $opt3) {
        $html = <<<HTML
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">AERS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item $opt1">
                    <a class="nav-link" href="index.php">History</a>
                </li>
                <li class="nav-item $opt2">
                    <a class="nav-link" href="recommendation.php">Recommendation</a>
                </li>
                <li class="nav-item $opt3">
                    <a class="nav-link" href="report.php">Report</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
HTML;
        return $html;
    }

    public static function footerContent() {
        $html = <<<HTML
<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Wei Jiang & Shun Ran 2018</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.loading.min.js"></script>

<script src="js/aers.js"></script>
HTML;
        return $html;
    }

    public static function ratingStars($score, $max, $R=false){
        $html = "";
        for ($i=0; $i<$max; $i++){
            if ($i < $score){
                $html .= '<span class="fas fa-star"></span>';
            } else {
                $html .= '<span class="far fa-star"></span>';
            }
        }
        if ($R){
            $score = round($score, 2);
        }
        $html .= " ($score/$max)";
        return $html;
    }


    // return true if success
    public function initSys($userID){

        $command = escapeshellcmd('python3 /user/jiangw14/classweb/cse482-AERS/pyscript/initSys.py '.$userID);
        $output = shell_exec($command);
//        echo $output;
        $this->reviews = json_decode($output, true);

        if (count($this->reviews)===0){
            return false; // this user doesnot exist
        }

        $this->userID = $userID;
        $this->userName = reset($this->reviews)["reviewerName"];

        return true;

    }


    public function showUserInfo() {
        $html = <<<HTML
<p>Hello, $this->userName ($this->userID) <a class="btn btn-outline-danger btn-sm" href="login.php" role="button">Log Out</a></p>
HTML;
        return $html;
    }


    public function displayHistory() {
        $pids = array_keys($this->reviews);
        $html = "";
        $cnt = 0;

        foreach($pids as $pid){
            $pinfo = $this->getProdInfo($pid);
            if ($cnt % 3 === 0) {
                $html .= '<div class="row">';
            }
//            A66FNXVJ8KE0F
//            AFHIUAR14924K

            $title = array_key_exists("title", $pinfo) ? $pinfo["title"]:"&nbsp;";
            $img = array_key_exists("imUrl", $pinfo) ? $pinfo["imUrl"]:"&nbsp;";
            $price = array_key_exists("price", $pinfo) ? $pinfo["price"]:"&nbsp;";
            $rating = array_key_exists("overall", $this->reviews[$pid]) ?self::ratingStars($this->reviews[$pid]["overall"], 5):self::ratingStars(0, 5);

            $html .= <<<HTML
<div class="col-lg-4 col-sm-6 portfolio-item">
    <div class="card h-100">
        <a href="detail.php?asin=$pid"><img class="card-img-top aers-product" src="$img" alt="$pid"></a>
        <div class="card-body">
            <h4 class="card-title">
                <a class="item-name" href="detail.php?asin=$pid">$title</a>
            </h4>
            <p class="card-text"><i class="fas fa-dollar-sign"></i>  $price</p>
            <p class="card-text">$rating</p>
        </div>
    </div>
</div>
HTML;
            if ($cnt % 3 === 2) {
                $html .= '</div>';
            }
            $cnt += 1;
        }
        $html .= '</div>';

        return $html;
    }


    public function singleRCard($pid, $score){
        $pinfo = $this->getProdInfo($pid);
        $title = array_key_exists("title", $pinfo) ? $pinfo["title"]:"&nbsp;";
        $img = array_key_exists("imUrl", $pinfo) ? $pinfo["imUrl"]:"&nbsp;";
        $price = array_key_exists("price", $pinfo) ? $pinfo["price"]:"&nbsp;";
        $rating = self::ratingStars($score, 5, true);

        $html = <<<HTML
<div class="col-lg-4 col-sm-6 portfolio-item">
    <div class="card h-100">
        <img class="card-img-top aers-product" src="$img" alt="$pid">
        <div class="card-body">
            <h4 class="card-title">
                $title
            </h4>
            <p class="card-text">Price: $$price</p>
            <p class="card-text">Predict: $rating</p>
        </div>
    </div>
</div>
HTML;

        return $html;
    }

    public function displayRecommendation($model, $desc){

        $p = $this->getPredictions($model);

        $card1 = $this->singleRCard($p[0][1], $p[0][0]);
        $card2 = $this->singleRCard($p[1][1], $p[1][0]);
        $card3 = $this->singleRCard($p[2][1], $p[2][0]);

        $html = <<<HTML
<h3 style="color:#64c5ff">
        $model
    </h3>
    <div class="alert alert-info" role="alert">
      $desc
    </div>

    <div class="row">
        $card1
        $card2
        $card3
    </div>
HTML;
        return $html;
    }



    public function showDetail($pid) {
        $pinfo = $this->getProdInfo($pid);
        $review = $this->reviews[$pid];

        $title = array_key_exists("title", $pinfo) ? $pinfo["title"]:"&nbsp;";
        $price = array_key_exists("price", $pinfo)?$pinfo["price"]:"&nbsp;";
        $imgurl = array_key_exists("imUrl", $pinfo)?$pinfo["imUrl"]:"&nbsp;";
        $summary  = array_key_exists("summary", $review)?$review["summary"]:"&nbsp;";
        $date = array_key_exists("reviewTime", $review)?$review["reviewTime"]:"&nbsp;";
        $text = array_key_exists("reviewText", $review)?$review["reviewText"]:"&nbsp;";
        $rate = array_key_exists("overall", $review)?$review["overall"]:0;
        $score = '<p class="card-text">'.self::ratingStars($rate, 5).'</p>';

        $html = <<<HTML
<div class="col">
    <div class="card card-outline-secondary">
        <img class="card-img-top detail-img" src="$imgurl" alt="">
        <div class="card-body">
            <h5 class="card-title">$title</h5>
            <h5>$ $price</h5>
        </div>
    </div>
</div>
<div class="col">
    <div class="card card-outline-secondary">
        <div class="card-header">
            Product Reviews
        </div>
        <div class="card-body">
            <h5 class="card-title">$summary</h5>
            $score
            <p>$text</p>
            <small class="text-muted">Posted by $this->userName on $date</small>
        </div>
    </div>
</div>
HTML;
        return $html;

    }

    // getters
    public function getReviews() {
        return $this->reviews;
    }

    public function getProdInfo($asin){
        if (is_null($this->allProducts)){
            $this->loadAllProducts();
        }
        return $this->allProducts[$asin];
    }

    public function loadAllProducts() {
        $s = file_get_contents("/user/jiangw14/classweb/cse482-AERS/DB/productInfo.data");
        $this->allProducts = json_decode($s, true);
    }

    public function loadPredictions() {
        $s = file_get_contents("/user/jiangw14/classweb/cse482-AERS/DB/predictions_small.data");
        $this->predictions = json_decode($s, true)[$this->userID];
    }

    public function getPredictions($model){
        if (is_null($this->predictions)){
            $this->loadPredictions();
        }
        return $this->predictions[$model];
    }

    private $userName = null;
    private $userID = null;
    private $reviews = null;
    private $allProducts = null;
    private $predictions = null;
}