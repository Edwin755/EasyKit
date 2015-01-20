<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title><?= self::$title ?> | EasyKit</title>
        <link rel="stylesheet" href="<?= HTML::link('default/stylesheets/style.css'); ?>">
        <link rel="stylesheet" href="<?= HTML::link('default/stylesheets/font-awesome-4.2.0/css/font-awesome.min.css'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1"/>
        <link rel="canonical" href="<?= HTML::getCurrentURL(); ?>">
    </head>
    <body>
        <div class="container">
            <?= $content_for_layout; ?>
        </div>
        
        <script src="<?= HTML::link('default/scripts/jquery.min.js'); ?>"></script>
        <script src="<?= HTML::link('default/scripts/angular.min.js'); ?>"></script>
        <script src="<?= HTML::link('default/scripts/function.js'); ?>"></script>
    </body>
</html>