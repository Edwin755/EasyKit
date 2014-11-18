<?php

    /**
     * Home.index view
     */

?>

<h1>Home page</h1>
<?php foreach ($posts as $post): ?>
    <h2><?php echo $post->post_name; ?></h2>
    <p><?php echo $post->post_content; ?></p>
<?php endforeach ?>

<?php echo Core\Form::input(); ?>