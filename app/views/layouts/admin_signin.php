<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?= self::$title ?> | EasyKit</title>
        <link rel="stylesheet" href="<?= HTML::link('admin_signin/stylesheets/screen.css'); ?>">
        <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    </head>
    <body>
        <img class="center" src="<?= HTML::link('admin/images/logo.png') ?>" alt="Logo">
        <section class="content">
            <?= $content_for_layout; ?>
        </section>
    </body>
</html>