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
        <div class="error">
            <div class="title">
                <?= $errno ?>
            </div>
            <div class="message">
                <?= $errstr ?>
            </div>
        </div>
        <div class="content">
            <div class="file">
                <div class="filename"><?= $errfile ?></div>
                <div class="filecontent">
                    <ul class="lines">
                        <?php for ($i = $errline - 6; $i <= $errline + 3; $i++) : ?>
                            <li><?= $i ?>.</li>
                        <?php endfor ?>
                    </ul>
                    <pre><code class="language-php"><?= $errlines ?></code></pre>
                </div>
            </div>
            <div class="traces">
                <h3>Server</h3>
                <table>
                    <?php foreach ($_SERVER as $k =>$v) : ?>
                        <tr>
                            <td class="key"><?= $k ?></td>
                            <td class="value"><?= $v ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
                <h3>Session</h3>
                <table>
                    <?php foreach ($_SESSION as $k =>$v) : ?>
                        <tr>
                            <td class="key"><?= $k ?></td>
                            <td class="value"><pre><?php print_r($v) ?></pre></td>
                        </tr>
                    <?php endforeach ?>
                </table>
                <h3>Cookie</h3>
                <table>
                    <?php foreach ($_COOKIE as $k =>$v) : ?>
                        <tr>
                            <td class="key"><?= $k ?></td>
                            <td class="value"><?= $v ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
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