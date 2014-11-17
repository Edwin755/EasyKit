<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link rel="stylesheet" href="<?php echo HTML::link('css/bootstrap.min.css'); ?>">
    </head>
    <body>
        <div class="container">
            <?php echo $content_for_layout; ?>
        </div>
        
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="<?php echo HTML::link('js/bootstrap.min.js'); ?>"></script>
    </body>
</html>