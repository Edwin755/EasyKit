<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="stylesheets/screen.css">
        <style>
            <?php echo file_get_contents(__DIR__ . '/../core/ErrorHandling/stylesheets/monokai_sublime.css'); ?>
        </style>
    </head>
    <body>
        <pre>
            <code class="language-php">
                <?php var_dump($data); ?>
            </code>
        </pre>
        <script src="scripts/jquery.min.js"></script>
        <script src="scripts/highlight.pack.js"></script>
        <script>
            (function($) {
                $('.language-php').each(function(i, block) {
                    hljs.highlightBlock(block);
                });
            })(jQuery);
        </script>
    </body>
</html>