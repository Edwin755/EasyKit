<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $errstr ?></title>
        <style>
            <?= file_get_contents(__DIR__ . '/../../core/ErrorHandling/stylesheets/screen.css'); ?>
        </style>
        <style>
            <?= file_get_contents(__DIR__ . '/../../core/ErrorHandling/stylesheets/monokai_sublime.css'); ?>
        </style>
    </head>
    <body>
        <div class="sidebar">
            <?php foreach ($errbacktrace as $backtrace) : ?>
                <div class="backtrace">
                    <div class="class">
                        <?= $backtrace['class'] ?>
                    </div>
                    <div class="function">
                        <?= $backtrace['function'] ?>
                    </div>
                    <div class="file">
                        <?= isset($backtrace['object']->errfile) ? str_replace(__DIR__, '', $backtrace['object']->errfile) : $backtrace['file'] ?><span class="line"><?= isset($backtrace['line']) ? ':' . $backtrace['line'] : '' ?></span>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="content">
            <div class="error">
                <div class="title">
                    <?= $errno ?>
                </div>
                <div class="message">
                    <?= $errstr ?>
                </div>
            </div>
            <div class="file">
                <div class="filename"><?= $errfile ?></div>
                <pre><code class="language-php"><?= $errlines ?></code></pre>
            </div>
            <div class="traces">
                <div class="row">
                    <div class="col-4">
                        <h3>Session</h3>
                        <?php var_dump($_SESSION); ?>
                    </div>
                    <div class="col-4">
                        <h3>Cookie</h3>
                        <?php var_dump($_COOKIE); ?>
                    </div>
                    <div class="col-4">

                    </div>
                </div>
            </div>
        </div>
        <script>
            <?= file_get_contents(__DIR__ . '/../../core/ErrorHandling/scripts/jquery.min.js'); ?>
        </script>
        <script>
            <?= file_get_contents(__DIR__ . '/../../core/ErrorHandling/scripts/highlight.pack.js'); ?>
        </script>
        <script>
            (function($) {
                $('.language-php').each(function(i, block) {
                    hljs.highlightBlock(block);
                });
            })(jQuery);
        </script>
    </body>
</html>