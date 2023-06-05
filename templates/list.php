<?php $title = 'List of Things'  ?>
<?php ob_start()  ?>
        <h1>List of Things</h1>
        <ul>
            <?php foreach ($things as $thing): ?>
            <li>
                <a href="./show?id=<?= $thing['id'] ?>">
                    <?= trim($thing['name']) ?>
                </a>
            </li>
            <?php endforeach ?>
        </ul>
<?php  $content = ob_get_clean()  ?>

<?php  include 'layout.php' ?>