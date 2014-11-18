<?php

    /**
     * Home.index view
     */

?>

<h1>Home page</h1>
<?php foreach ($posts as $post): ?>
    <h2><?= $post->post_name; ?></h2>
    <p><?= $post->post_content; ?></p>
<?php endforeach ?>

<?= Core\Form::input(); ?>