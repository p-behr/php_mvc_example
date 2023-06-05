<?php $title = $name; ?> 
<?php ob_start() ?>

    <a href="./">Back</a>
    
    <h1><?= $name ?></h1>
    
    <div class="id"><?= $id ?></div>
    <div class="name"><?= trim($name)  ?></div>
    <div class="shape"><?= trim($shape)  ?></div>
    <div class="color"><?= trim($color)  ?></div>

<?php 
    $content = ob_get_clean();
    include 'layout.php';  
?>