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
            <div class="file-container">
                <div class="file">
                    <div class="filename"><?= $errfile ?><span class="frame-line"><?= $errline ?></span></div>
                    <div class="filecontent">
                        <pre class="prettyprint linenums:<?= $errline - 6 ?> language-php"><?= $errlines ?></pre>
                    </div>
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
                    <?php if (isset($_SESSION)) { foreach ($_SESSION as $k =>$v) { ?>
                        <tr>
                            <td class="key"><?= $k ?></td>
                            <td class="value"><pre><?php print_r($v) ?></pre></td>
                        </tr>
                    <?php }} ?>
                </table>
                <h3>Cookie</h3>
                <table>
                    <?php if (isset($_COOKIE)) { foreach ($_COOKIE as $k =>$v) { ?>
                        <tr>
                            <td class="key"><?= $k ?></td>
                            <td class="value"><?= $v ?></td>
                        </tr>
                    <?php }} ?>
                </table>
                <h3>Get</h3>
                <table>
                    <?php foreach ($_GET as $k =>$v) : ?>
                        <tr>
                            <td class="key"><?= $k ?></td>
                            <td class="value"><?= $v ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
                <h3>Post</h3>
                <table>
                    <?php foreach ($_POST as $k =>$v) : ?>
                        <tr>
                            <td class="key"><?= $k ?></td>
                            <td class="value"><?= $v ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
                <h3>Files</h3>
                <table>
                    <?php foreach ($_FILES as $k =>$v) : ?>
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
            <?= file_get_contents(__DIR__ . '/../../core/ErrorHandling/scripts/prettify.js'); ?>
        </script>
        <script>
            (function($) {
                prettyPrint();

                var highlightCurrentLine = function() {
                    // Highlight the active and neighboring lines for this frame:
                    var activeLineNumber = +($('.frame-line').text());
                    var $lines           = $('.linenums li');
                    var firstLine        = +($lines.first().val());

                    console.log()

                    $($lines[activeLineNumber - firstLine - 1]).addClass('current');
                    $($lines[activeLineNumber - firstLine]).addClass('current active');
                    $($lines[activeLineNumber - firstLine + 1]).addClass('current');
                };

                // Highlight the active for the first frame:
                highlightCurrentLine();
            })(jQuery);
        </script>
    </body>
</html>