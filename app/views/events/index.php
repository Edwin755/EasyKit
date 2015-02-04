<div ng-controller="allEvents">
    <div id="search_event">
        <input type="search" id="search" placeholder="Search an event..." ng-model="search" ng-change="update()">
    </div>

    <div id="container_all_events">
        <div class="block" ng-repeat="event in data.events track by $index" id="{{index}}">
            <div class="couverture">
                <ul>
                    <li ng-repeat="photos in event.events_medias|limitTo:1" style="background: url({{photos.medias_file}})"></li>
                </ul>
                <div class="description">
                    {{event.events_summary}}<span class="info">Vancouver, November 24, 2014</span>
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
    </div>
</div>