<?php

/**
 * Home.index view
 */

?>


<div id="header">
    <video autoplay loop poster="images/easykit.png" id="bgvid">
        <source src="<?= HTML::link('default/videos/easykit.mp4') ?>" type="video/mp4">
    </video>

    <div id="filtre"></div>

    <div id="bar-menu">
        <div id="logo">
            <a href="<?= HTML::link('/') ?>"><img src="<?= HTML::link('default/images/logo.png'); ?>" alt=""></a>
        </div>

        <ul id="buttons">
            <!--<li id="item1"><a href="#">Create your pack</a></li>-->

            <li id="item2"><a href="#infographie" data-slide="">How it works</a></li>

            <li id="item3" class="item3"><a href="#">Log in</a></li>

            <li id="item4"><a href="<?= HTML::link('users/register'); ?>">Register</a></li>
        </ul>

        <div id="login-popup">
            <form class="sign-up login" style="border:solid 1px white;">
                <a href="#" id="close"><i class="fa fa-times"></i></a> <input type="email" class="sign-up-input" id="emailLogin" placeholder="What's your mail?"> <input type="password" id="passwordLogin" class="sign-up-input" placeholder="Password"> <input type="checkbox"> Remember me <br/> <a href="#" class="forgot_pass">Forgot password?</a> <br/><input type="submit" id="submitLogin" value="Log in!" class="sign-up-button">

                <ul class="social_button">
                    <li class="button fb"><a href="construction.html">With Facebook</a></li>
                </ul>
            </form>
        </div>

        <div id="menu-mobile">
            <a href="#" id="open_menu_mobile"><img src="<?= HTML::link('default/images/menu.png'); ?>" alt=""></a>
        </div>

        <div id="menu_open">
            <ul>
                <li class="menu_deroulant"><a href="#infographie" data-slide="">How it works</a></li>

                <li class="menu_deroulant"><a href="#" class="item3">Login</a></li>

                <li class="menu_deroulant"><a href="<?= HTML::link('users/register'); ?>">Register</a></li>
            </ul>
        </div>
    </div>

    <div id="search-area">
        <h1>Less planning, more sharing</h1>

        <h3>Create the perfect event in three easy steps</h3><a id="cta" href="<?= HTML::link('packs/create') ?>" onclick="ga('send','event', 'Lien', 'Clic', 'Button Create Pack');">Create your pack</a> <!--<div id="bar-search">
        <form id="formu" method="post" action="traitement.php">
        <input type="search" id="search" placeholder="Search an event to start your pack...">
        </form>
        <a id="add" href="#">Or add an event</a>
    </div>-->
    </div>
</div>

<div id="containt" ng-controller="popularEvents">
    <h2>Popular Events</h2>

    <div class="trait"></div>
    <span us-spinner="{radius:30, width:8, length: 16}"></span>

    <div class="block" ng-repeat="event in data.events track by $index" id="{{index}}">
        <div class="couverture">
            <ul>
                <li ng-repeat="photos in event.events_medias|limitTo:1" style="background: url({{photos.medias_file}})"></li>
            </ul>

            <div class="description">
                {{event.events_summary}}<span class="info">United States, May 13, 2015</span>
            </div>
        </div>

        <div class="block-text">
            <p class="titre">{{event.events_name}}</p>

            <div class="trait-block-text"></div>

            <ul class="icones">
                <li><img src="<?= HTML::link('default/images/like.png'); ?>" title="Like this event" width="21" alt="like"> <span>3430</span></li>

                <li><img src="<?= HTML::link('default/images/comment.png'); ?>" title="Post a comment" width="21" alt="comment"> <span>132</span></li>

                <li><img src="<?= HTML::link('default/images/share.png'); ?>" title="Share this event" width="21" alt="share"></li>

                <li class="favorit">
                    <img class="coeur" src="<?= HTML::link('default/images/favorit.png'); ?>" title="Add to your favorite events" width="23" alt="favorit">
                    <img class="coeur2" src="<?= HTML::link('default/images/favorit-vert.png'); ?>" width="23" alt="favorit2">
                </li>
            </ul>
        </div>
    </div>

    <div id="all-events">
        <a href="<?= HTML::link('events') ?>">See all events</a>
    </div>
</div>

<div id="infographie">
    <h2>How it works</h2>

    <div class="trait"></div>

    <div id="image-info"></div>
</div>

<div id="joinus">
    <h2>Join us</h2>

    <div class="trait"></div>

    <div id="socials">
        <ul class="social">
            <li><a href="http://www.facebook.com/easykit.project" target="_blank"></a></li>

            <li><a href="http://twitter.com/easy_kit" target="_blank"></a></li>

            <li><a href="http://plus.google.com/u/0/b/100863695395542898157/100863695395542898157/" target="_blank"></a></li>
        </ul>
    </div>

    <div id="mc_embed_signup">
        <form action="//ovh.us9.list-manage.com/subscribe/post?u=ec0be1ea7c0c896f8c94ca0ab&amp;id=e2c3d70672" method="post" id="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
            <div id="mc_embed_signup_scroll">
                <label for="mce-EMAIL">Keep posted about the last event, receive our selection every week !</label> <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required="">

                <div class="clear">
                    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
                </div>
            </div>
        </form>
    </div>
</div>




