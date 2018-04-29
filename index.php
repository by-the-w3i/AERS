<?php
require "site.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo System::headContent()?>
</head>

<body>

<?php echo System::presentNav("active","","")?>

<!-- Page Content -->
<div class="container">

    <header class="aers-header">
        <h1 class="display-6"><img src="src/circuit.png">Amazon Electronics Recommendation System</h1>
        <hr class="my-4">
        <?php echo $sys->showUserInfo()?>
    </header>


    <!-- Page Heading -->
    <h3 style="color:#64c5ff">
        Purchase History
    </h3>

    <?php echo $sys->displayHistory()?>


</div>
<!-- /.container -->

<?php echo System::footerContent()?>
</body>

</html>



