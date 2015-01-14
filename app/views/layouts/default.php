<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>Document</title>
        <link rel="stylesheet" href="<?= HTML::link('css/bootstrap.min.css'); ?>">
        <link rel="canonical" href="<?= HTML::getCurrentURL(); ?>">
    </head>
    <body>
        <div class="container">
            <?= $content_for_layout; ?>
        </div>
        
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="<?= HTML::link('js/angular.min.js'); ?>"></script>
    </body>
</html>