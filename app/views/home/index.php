<?php

/**
 * Home.index view
 */

?>


<div id="header">
    <div id="image-header"></div>

    <div id="filtre"></div>

    <div id="bar-menu">
        <div id="logo">
            <a href="./"><img src="<?= HTML::link('default/images/logo.png'); ?>" alt=""></a>
        </div>

        <ul id="buttons">
            <!--<li id="item1"><a href="#">Create your pack</a></li>-->

            <li id="item2"><a href="#infographie" data-slide="">How it works</a></li>

            <li id="item3" class="item3"><a href="#">Log in</a></li>

            <li id="item4"><a href="register.html">Register</a></li>
        </ul>

        <div id="login-popup">
            <form class="sign-up login" style="border:solid 1px white;">
                <a href="#" id="close"></a> <input type="email" class="sign-up-input" placeholder="What's your mail?"> <input type="password" class="sign-up-input" placeholder="Password"> <input type="submit" value="Log in!" class="sign-up-button">

                <ul class="social_button">
                    <li class="button fb"><a href="construction.html">With Facebook</a></li>

                    <li class="button tw"><a href="construction.html">With Twitter</a></li>

                    <li class="button in"><a href="construction.html">With Linkedin</a></li>

                    <li class="button g"><a href="construction.html">With Google +</a></li>
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

                <li class="menu_deroulant"><a href="register.html">Register</a></li>
            </ul>
        </div>
    </div>

    <div id="search-area">
        <h1>Less planning, more sharing</h1>

        <h3>Create the perfect pack in three easy steps</h3><a id="cta" href="create_your_pack.html" onclick="ga('send','event', 'Lien', 'Clic', 'Button Create Pack');">Create your pack</a> <!--<div id="bar-search">
        <form id="formu" method="post" action="traitement.php">
        <input type="search" id="search" placeholder="Search an event to start your pack...">
        </form>
        <a id="add" href="#">Or add an event</a>
    </div>-->
    </div>
</div>

<div id="containt">
    <h2>Popular Events</h2>

    <div class="trait"></div>

    <div class="block">
        <div class="couverture">
            <a href="event.html"><img src="<?= HTML::link('default/images/event-1.jpg'); ?>" alt=""></a>

            <div class="description">
                TED (Technology, Entertainment, Design) is a global set of conferences owned by the private non-profit Sapling Foundation, under the slogan: "Ideas Worth Spreading".<span class="info">Vancouver, November 24, 2014</span>
            </div>
        </div>

        <div class="block-text">
            <p class="titre">Ted Conference</p>

            <div class="trait-block-text"></div>

            <ul class="icones">
                <li><img src="<?= HTML::link('default/images/like.png'); ?>" title="Like this event" width="21" alt="like"> <span>2450</span></li>

                <li><img src="<?= HTML::link('default/images/comment.png'); ?>" title="Post a comment" width="21" alt="comment"> <span>72</span></li>

                <li><img src="<?= HTML::link('default/images/share.png'); ?>" title="Share this event" width="21" alt="share"></li>

                <li class="favorit"><img class="coeur" src="<?= HTML::link('default/images/favorit.png'); ?>" title="Add to your favorite events" width="23" alt="favorit"><img class="coeur2" src="<?= HTML::link('default/images/favorit-vert.png'); ?>" width="23" alt="favorit2"></li>
            </ul>
        </div>
    </div>

    <div class="block">
        <div class="couverture">
            <img src="<?= HTML::link('default/images/event-2.jpg'); ?>" alt="">

            <div class="description">
                The Coastal Edge East Coast Surfing Championships is a major professional and amateur event for the United States Surfing Federation.<span class="info">United States, May 13, 2015</span>
            </div>
        </div>

        <div class="block-text">
            <p class="titre">Surf Championships</p>

            <div class="trait-block-text"></div>

            <ul class="icones">
                <li><img src="<?= HTML::link('default/images/like.png'); ?>" title="Like this event" width="21" alt="like"> <span>3430</span></li>

                <li><img src="<?= HTML::link('default/images/comment.png'); ?>" title="Post a comment" width="21" alt="comment"> <span>132</span></li>

                <li><img src="<?= HTML::link('default/images/share.png'); ?>" title="Share this event" width="21" alt="share"></li>

                <li class="favorit"><img class="coeur" src="<?= HTML::link('default/images/favorit.png'); ?>" title="Add to your favorite events" width="23" alt="favorit"><img class="coeur2" src="<?= HTML::link('default/images/favorit-vert.png'); ?>" width="23" alt="favorit2"></li>
            </ul>
        </div>
    </div>

    <div class="block">
        <div class="couverture">
            <img src="<?= HTML::link('default/images/event-3.jpg'); ?>" alt="">

            <div class="description">
                The Paris Masters is an annual tennis tournament for male professional players. It is played indoors. The event is part of the ATP World Tour Masters 1000 on the Association of Tennis Professionals Tour.<span class="info">Paris, October 25, 2015</span>
            </div>
        </div>

        <div class="block-text">
            <p class="titre">BNP Paribas Masters</p>

            <div class="trait-block-text"></div>

            <ul class="icones">
                <li><img src="<?= HTML::link('default/images/like.png'); ?>" title="Like this event" width="21" alt="like"> <span>2341</span></li>

                <li><img src="<?= HTML::link('default/images/comment.png'); ?>" title="Post a comment" width="21" alt="comment"> <span>33</span></li>

                <li><img src="<?= HTML::link('default/images/share.png'); ?>" title="Share this event" width="21" alt="share"></li>

                <li class="favorit"><img class="coeur" src="<?= HTML::link('default/images/favorit.png'); ?>" title="Add to your favorite events" width="23" alt="favorit"><img class="coeur2" src="<?= HTML::link('default/images/favorit-vert.png'); ?>" width="23" alt="favorit2"></li>
            </ul>
        </div>
    </div>

    <div class="block">
        <div class="couverture">
            <img src="<?= HTML::link('default/images/event-4.jpg'); ?>" alt="">

            <div class="description">
                Paris Games Week, or simply PGW, is a trade fair for video games held annually at the Parc des expositions de la porte de Versailles in Paris. It is organised by SELL.<span class="info">Paris, from 27 to 31 October, 2015</span>
            </div>
        </div>

        <div class="block-text">
            <p class="titre">Paris Games Week</p>

            <div class="trait-block-text"></div>

            <ul class="icones">
                <li><img src="<?= HTML::link('default/images/like.png'); ?>" title="Like this event" width="21" alt="like"> <span>135</span></li>

                <li><img src="<?= HTML::link('default/images/comment.png'); ?>" title="Post a comment" width="21" alt="comment"> <span>12</span></li>

                <li><img src="<?= HTML::link('default/images/share.png'); ?>" title="Share this event" width="21" alt="share"></li>

                <li class="favorit"><img class="coeur" src="<?= HTML::link('default/images/favorit.png'); ?>" title="Add to your favorite events" width="23" alt="favorit"><img class="coeur2" src="<?= HTML::link('default/images/favorit-vert.png'); ?>" width="23" alt="favorit2"></li>
            </ul>
        </div>
    </div>

    <div class="block">
        <div class="couverture">
            <img src="<?= HTML::link('default/images/event-5.jpg'); ?>" alt="">

            <div class="description">
                The European Individual Closed Championships are the event which serves as the individual European championship for squash players organised by the European Squash Federation.<span class="info">Bratislava, 2015</span>
            </div>
        </div>

        <div class="block-text">
            <p class="titre">European squash tournament</p>

            <div class="trait-block-text"></div>

            <ul class="icones">
                <li><img src="<?= HTML::link('default/images/like.png'); ?>" title="Like this event" width="21" alt="like"> <span>8997</span></li>

                <li><img src="<?= HTML::link('default/images/comment.png'); ?>" title="Post a comment" width="21" alt="comment"> <span>550</span></li>

                <li><img src="<?= HTML::link('default/images/share.png'); ?>" title="Share this event" width="21" alt="share"></li>

                <li class="favorit"><img class="coeur" src="<?= HTML::link('default/images/favorit.png'); ?>" title="Add to your favorite events" width="23" alt="favorit"><img class="coeur2" src="<?= HTML::link('default/images/favorit-vert.png'); ?>" width="23" alt="favorit2"></li>
            </ul>
        </div>
    </div>

    <div class="block">
        <div class="couverture">
            <img src="<?= HTML::link('default/images/event-6.jpg'); ?>" alt="">

            <div class="description">
                The NBA All-Star Game is an exhibition game hosted annually by the NBA, matching the league's star players from the Eastern Conference against their counterparts from the Western Conference.<span class="info">New York, February 15, 2015</span>
            </div>
        </div>

        <div class="block-text">
            <p class="titre">NBA All Star Game</p>

            <div class="trait-block-text"></div>

            <ul class="icones">
                <li><img src="<?= HTML::link('default/images/like.png'); ?>" title="Like this event" width="21" alt="like"> <span>3347</span></li>

                <li><img src="<?= HTML::link('default/images/comment.png'); ?>" title="Post a comment" width="21" alt="comment"> <span>237</span></li>

                <li><img src="<?= HTML::link('default/images/share.png'); ?>" title="Share this event" width="21" alt="share"></li>

                <li class="favorit"><img class="coeur" src="<?= HTML::link('default/images/favorit.png'); ?>" title="Add to your favorite events" width="23" alt="favorit"><img class="coeur2" src="<?= HTML::link('default/images/favorit-vert.png'); ?>" width="23" alt="favorit2"></li>
            </ul>
        </div>
    </div>

    <div id="all-events">
        <a href="#">See all events</a>
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

<div id="footer">
    <p>Copyright easykit 2015 - All right reserved</p>
</div>

