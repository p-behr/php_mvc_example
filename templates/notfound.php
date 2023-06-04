<?php $title = 'Not found'  ?>
<?php ob_start()  ?>
        <h1>Oh no, we seem to have lost that page</h1>
        <p>You asked for <?= $uri ?>; we've looked everywhere and it just can't be found :-(</p>
<?php  $content = ob_get_clean()  ?>

<?php  include 'layout.php' ?>