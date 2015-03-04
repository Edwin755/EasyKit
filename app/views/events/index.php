<div ng-controller="allEvents">
    <div id="search_event">
        <input type="search" id="search" placeholder="Search an event..." ng-model="search" ng-change="update()">
    </div>

    <div id="container_all_events">

        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>

            <a class="block" ng-repeat="event in data.events track by $index" id="{{event.events_id}}" href="<?= HTML::link('/events/show/{{event.events_id}}')?>">
        <div class="couverture">
            <ul>
                <li ng-repeat="photos in event.events_medias|limitTo:1" style="background: url({{photos.medias_file}})"></li>
            </ul>

            <div class="description">
                {{event.events_summary}}<span class="info">{{event.events_address}}</span>
            </div>
        </div>

        <div class="block-text">
            <p class="titre">{{event.events_name}}</p>

            <div class="trait-block-text"></div>

            <ul class="icones" data-id="{{event.events_id}}">
                <li ng-controller="likes">
                    <img src="<?= HTML::link('default/images/like.png'); ?>" data-id="{{event.events_id}}" ng-click="like($event)" class="like off" title="Like this event" width="21" alt="like">
                    <img src="<?= HTML::link('default/images/like_on.png'); ?>" data-id="{{event.events_id}}" ng-click="unLike($event)" class="like on" title="Like this event" width="21" alt="like">

                    <div class="spinner-like"></div>
                    <span class="like_number">{{event.events_like}}</span>
                </li>

                <li><img src="<?= HTML::link('default/images/share.png'); ?>" title="Share this event" width="21" alt="share"></li>
            </ul>
        </div>
    </a>
        </div>
</div>