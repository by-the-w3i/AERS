<?php
require "site.inc.php";
if (!isset($_GET["asin"])){
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo System::headContent()?>
    <script src=""></script>
</head>

<body>
<?php echo System::presentNav("","","")?>



<!-- Page Content -->
<div class="container" style="margin-bottom:30px">

    <header class="aers-header">
        <h1 class="display-6"><img src="src/circuit.png">Amazon Electronics Recommendation System</h1>
        <hr class="my-4">
        <?php echo $sys->showUserInfo()?>
    </header>

    <div class="row">
        <?php echo $sys->showDetail(strip_tags($_GET["asin"]))?>
    </div>

</div>
<!-- /.container -->

<?php echo System::footerContent()?>

</body>

</html>

