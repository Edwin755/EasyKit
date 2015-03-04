<div id="container_event" ng-controller="event">
    <div ng-repeat="event in data track by $index">
        <div ng-repeat="photos in event.events_medias|limitTo:1" class="video_header" style="background-image: url({{photos.medias_file}})"></div>
    
        <div id="present_event">
            <h2>{{event.events_name}}</h2>
    
            <div class="trait"></div>
    
            <p>{{event.events_description}}</p>
    
            <div class="gallery_event">
                <img ng-repeat="photos in event.events_medias|limitTo:3" src="{{photos.medias_file}}" alt="" title="">
            </div>
        </div>
    
        <div class="trait_vertical"></div>
    
        <div id="info_event">
            <ul class="detail">
                <li>
                    <a href="" class="lien_info">
                        <ul>
                            <li ng-controller="likes">
                                <img src="<?= HTML::link('default/images/like.png'); ?>" data-id="{{event.events_id}}" ng-click="like($event)" class="like" title="Like this event" width="21" alt="like">
                                <div class="spinner-like"></div>
                                <span class="like_number">{{event.events_like}}</span>
                            </li>
                        </ul>
                    </a>
                </li>
    
                <li>Location : {{event.events_address}}</li>
    
                <li>Date : {{event.events_starttime}}</li>
        
            </ul>
    
            <ul class="share">
                <li>Share this event :</li>
                <div id="share">
                <span class='st_facebook_vcount' displayText='Facebook'></span>
                <span class='st_twitter_vcount' displayText='Tweet'></span>
                <span class='st_email_vcount' displayText='Email'></span>
            </div>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "d27b2df4-3fe7-4733-a697-2714cfec8f49", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

