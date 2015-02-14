<!DOCTYPE html>
<html lang="fr" ng-app="myApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= self::$title ?> | EasyKit</title>
    <link rel="stylesheet" href="<?= HTML::link('default/stylesheets/style.css'); ?>">
    <link rel="stylesheet" href="<?= HTML::link('default/stylesheets/font-awesome-4.2.0/css/font-awesome.min.css'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1"/>
    <link rel="icon" type="image/x-icon" href="<?= HTML::link('/favicon.ico') ?>">
    <link rel="canonical" href="<?= HTML::getCurrentURL(); ?>">
</head>
<body>

<div id="bar-menu" style="background:black;">
    <div id="logo">
        <a href="<?= HTML::link('/') ?>"><img src="<?= HTML::link('default/images/logo.png'); ?>" alt="" /></a>
    </div>

    <ul id="buttons">
        <!--<li id="item1"><a href="#">Create your pack</a></li>-->
        <li id="item2"><a href="<?= HTML::link('/') ?>#infographie">How it works</a></li>
        <?php if (isset($_SESSION['user'])) : ?>
            <li id="item3" class="item3"><a href="#">My Account</a></li>
        <?php else : ?>
            <li id="item3" class="item3"><a href="#">Log in</a></li>
            <li id="item4"><a href="<?= HTML::link('users/register') ?>">Register</a></li>
        <?php endif; ?>
    </ul>

    <?php if (!isset($_SESSION['user'])) : ?>
        <div id="login-popup">
            <form class="sign-up login" style="border:solid 1px white;">
                <a href="#" id="close"><i class="fa fa-times"></i></a>
                <input type="email" id="emailLogin" class="sign-up-input" placeholder="What's your mail?" >
                <input type="password" id="passwordLogin" class="sign-up-input" placeholder="Password">
                <input type="checkbox"> Remember me <br/> <a href="#" class="forgot_pass">Forgot password?</a> <br/>
                <input type="submit" id="submitLogin" value="Log in!" class="sign-up-button">
                <ul class="social_button">
                    <li class="button fb"><a href="<?= HTML::link('users') ?>">With Facebook</a></li>
                </ul>
            </form>
        </div>
    <?php endif; ?>

    <div id="menu-mobile">
        <a href="#" id="open_menu_mobile"><img src="http://localhost:8888/EasyKit/default/images/menu.png" alt="" /></a>
    </div>

    <div id="menu_open">
        <ul>
            <li class="menu_deroulant"><a href="#infographie" data-slide="">How it works</a></li>
            <li class="menu_deroulant"><a href="#" class="item3">Login</a></li>
            <li class="menu_deroulant"><a href="register.html">Register</a></li>
        </ul>
    </div>


</div>

<div class="sucess_alert">
    <p><img src="<?= HTML::link('default/images/success.png') ?>" /> Success </p>
</div>
<div class="warning_alert">
    <p><img src="<?= HTML::link('default/images/warning.png') ?>" /> Warning </p>
</div>
<div class="wrong_alert">
    <p><img src="<?= HTML::link('default/images/wrong.png') ?>" /> Wrong </p>
</div>
<?= $content_for_layout; ?>

<div id="footer">
    <p>Copyright easykit 2015 - All right reserved</p>
</div>

<script>
    var url = "<?= HTML::link(''); ?>"
</script>
<script src="<?= HTML::link('default/scripts/jquery.min.js'); ?>"></script>
<script src="<?= HTML::link('default/scripts/angular.min.js'); ?>"></script>
<script src="<?= HTML::link('default/scripts/login.js'); ?>"></script>
<script src="<?= HTML::link('default/scripts/views/' . self::getFolders() . '.js'); ?>"></script>
<script src="<?= HTML::link('default/scripts/function.js'); ?>"></script>

</body>
</html>