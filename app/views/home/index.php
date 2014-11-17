<?php

    /**
     * Home.index view
     */

?>

<h1>Home page</h1>
<?php foreach ($posts as $post): ?>
    <?php echo $post->post_name; ?>
<?php endforeach ?>